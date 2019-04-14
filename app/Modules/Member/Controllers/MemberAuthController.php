<?php

  namespace App\Modules\Member\Controllers;

  use App\Http\Requests;
  use App\Http\Controllers\Controller;
  use App\Modules\Api\Models\UserModel;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Validator;
  use Illuminate\Support\Facades\Input;
  use App\Helpers\Session as AppSession;
  use \Illuminate\Support\Facades\Mail;
  use \Firebase\JWT\JWT;
  use Laravel\Socialite\Facades\Socialite;
  use App\Events\AddModelPerformerChatEvent;
  use App\Events\AddModelScheduleEvent;
  use App\Events\AddEarningSettingEvent;
  use App\Events\AddModelPerformerEvent;
  use App\Events\UpdateExtendMember;
  use App\Events\MakeChatRoomEvent;
  use App\Modules\Api\Models\CountryModel;

  class MemberAuthController extends Controller {

      /**
       * Member Login.
       *
       * @return Response
       */
      public function getLogin() {
          // return view('home.index');
          return view('login.login');
      }

      /**
       * Member logout.
       *
       * @return Response
       */
      public function getLogOut() {
          return AppSession::getLogout();
      }

      /**
       * model and member login
       */
      public function postLogin() {
          $user = UserModel::where('username', '=', Input::get('username'))
                  ->where('passwordHash', '=', md5(Input::get('password')))
                  ->whereRaw('(role = "' . UserModel::ROLE_MEMBER . '" OR role = "' . UserModel::ROLE_MODEL . '")')
                  ->first();
          if (!$user) {
              return Redirect('login')->withInput()->with('msgError', 'Username or password does not match.');
          }

          if ($user->emailVerified == 0) {
              return redirect('login')->with('msgError', 'Your account has not been verified, please check your email');
          } else if ($user->accountStatus == UserModel::ACCOUNT_DISABLE) {
              return Redirect('login')->with('msgError', 'Your account was disabled.');
          } else if ($user->accountStatus == UserModel::ACCOUNT_SUSPEND) {
              return Redirect('login')->with('msgError', 'Your account was suspend.');
          }

          AppSession::setLogin($user);

          //TODO - should redirect to specific page for model / user...
          if ($user->role == 'model') {
              //TODO - should redirect pa model panel
              //after click live we will rediect to this view
              return redirect('/models/live');
          }

          if (!empty(\Request::cookie('backUri'))) {
              return redirect(\Request::cookie('backUri'))->with('msgInfo', 'Hi ' . $user->firstName . ' ' . $user->lastName . '. Welcome back ');
          } else {
              return redirect('/')->with('msgInfo', 'Hi ' . $user->firstName . ' ' . $user->lastName . '. Welcome back ');
          }
      }

      /**
        TODO: Social Login redirect to provider
       * */
      public function redirectToProvider($provider) {
          return Socialite::with($provider)->redirect();

//          if ($provider == 'facebook') {
//              if (app('settings')->fb_client_id) {
//                  $social->clientId = app('settings')->fb_client_id;
//              }
//              if (app('settings')->fb_client_secret) {
//                  $social->clientSecret = app('settings')->fb_client_secret;
//              }
//              $social->redirectUrl = url('login/facebook');
//              $social->version = 'v2.7';
//          }
//          if ($provider == 'google') {
//              if (app('settings')->google_client_id) {
//                  $social->clientId = app('settings')->google_client_id;
//              }
//              if (app('settings')->google_client_secret) {
//                  $social->clientSecret = app('settings')->google_client_secret;
//              }
//              $social->redirectUrl = url('login/google');
//          }
//          if ($provider == 'twitter') {
//              if (app('settings')->tw_client_id) {
//                  $social->clientId = app('settings')->tw_client_id;
//              }
//              if (app('settings')->tw_client_secret) {
//                  $social->clientSecret = app('settings')->tw_client_secret;
//              }
//              $social->redirectUrl = url('login/twitter');
//          }
//    var_dump($social);
          return $social->redirect();
          die();
      }

      /**
        TODO: Social Login callback
       * */
      public function handleProviderCallback($provider) {
          if (isset($_GET['error'])) {
              return \Redirect::to('/')->with('msgError', 'Cannot Access Your ' . $provider . ' Account');
          }
          if (isset($_GET['denied'])) {
              return \Redirect::to('/')->with('msgError', 'Cannot Access Your ' . $provider . ' Account');
          }
          $user = Socialite::driver($provider)->user();
          if (!$user->getEmail() || empty($user->getEmail())) {
              $member = UserModel::where('username', '=', $user->nickname)->where('is_social', '=', 'yes')->first();
          } else {
              $member = UserModel::where('email', '=', $user->getEmail())->first();
          }

          if ($member) {
              AppSession::setLogin($member);
              return redirect("/")->with('msgInfo', 'Hi ' . $member->firstName . ' ' . $member->lastName . '. Welcome back ');
          } else {
              $newUser = new UserModel();
              if ($provider == 'twitter') {
                  $newUser->lastName = '&nbsp;';
                  $newUser->firstName = $user->getName();
                  $newUser->username = $user->getNickname();
                  $newUser->email = ($user->getEmail()) ? $user->getEmail() : '';
              }
              if ($provider == 'facebook') {
                  $newUser->lastName = '&nbsp;';
                  $newUser->firstName = $user->getName();
                  $newUser->username = ($user->getNickname()) ? $user->getNickname() : $user->getId();
                  $newUser->email = $user->getEmail();
                  $newUser->is_social = 'yes';
                  if(isset($user->getRaw()['gender'])):
                    $newUser->gender = $user->getRaw()['gender'];
                  endif;
              }
              if ($provider == 'google') {
                  $newUser->firstName = (isset($user->getRaw()['name']) && isset($user->getRaw()['name']['givenName'])) ? $user->getRaw()['name']['givenName'] : $user->getName();
                  $newUser->lastName = (isset($user->getRaw()['name']) && isset($user->getRaw()['name']['familyName'])) ? $user->getRaw()['name']['familyName'] : '&nbsp;';
                  if(isset($user->getRaw()['gender'])):
                    $newUser->gender = $user->getRaw()['gender'];
                  endif;
                  $newUser->username = ($user->getNickname()) ? $user->getNickname() : $user->getId();
                  $newUser->email = $user->getEmail();
              }

              $newUser->avatar = $user->getAvatar();
              $newUser->is_social = 'yes';
              $newUser->role = UserModel::ROLE_MEMBER;
              $newUser->emailVerified = true;
              $newUser->accountStatus = UserModel::ACCOUNT_ACTIVE;
              $newUser->tokens = app('settings')->memberJoinBonus;

              if ($newUser->save()) {
                  AppSession::setLogin($newUser);

                  return redirect("members/account-settings")->with('msgInfo', 'Hi ' . $newUser->firstName . ' ' . $newUser->lastName . '. Welcome ');
              } else {
                  return redirect("/register")->with('msgError', 'System error.');
              }
          }
      }

      /**
       * Member register.
       *
       * @return Response
       */
      public function getRegister(Request $req) {
          $userData = AppSession::getLoginData();
          if($userData){
            AppSession::getLogout();
          }
          $type = ($req->has('type')) ? $req->get('type') : '';
          $countries = CountryModel::orderBy('name')->lists('name', 'id');
          return view('login.register', compact('type', 'countries'));
      }

      /**
       * Member Post register.
       *
       * @return Response
       */
      public function postRegister(Request $get) {
          
          if (AppSession::isLogin()) {
              AppSession::getLogout();
          }
            $rules = [
                'username' => 'required|alphaNum|unique:users|max:40',
                'email' => 'required|email|unique:users|max:40',
                'password' => 'Required|Between:6,32|Confirmed',
                'password_confirmation' => 'Required|Between:6,32',
                'location' => 'required',
                'type' => 'required'
            ];
            if(Input::get('type') && Input::get('type') === 'studio') {
              $rules['studioName'] = ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'];
            }else {
              $rules['firstName'] = ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'];
              $rules['lastName'] = ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'];
              $rules['gender'] = 'required';
              $rules['birthdate'] = 'Required|date|before:18 years ago|after:100 years ago';
            }
            $this->validate(request(), $rules);
           
            $email = Input::get('email');
            $newMember = new UserModel ();
            if(Input::get('type') && Input::get('type') === 'studio') {
              $newMember->studioName = preg_replace('/\s+/', ' ',  Input::get('studioName'));
            }else {
              $newMember->firstName = preg_replace('/\s+/', ' ',  Input::get('firstName'));
              $newMember->lastName = preg_replace('/\s+/', ' ',  Input::get('lastName'));
            }
            $newMember->gender = Input::get('gender');
            $newMember->birthdate = Input::get('birthdate');
            $newMember->username = Input::get('username');
            $newMember->email = $email;
            $newMember->passwordHash = md5(Input::get('password'));
            $newMember->location_id = Input::get('location');
            $newMember->autoApprovePayment = 1;
            if ($get->type == 'model' || $get->type == 'studio') {
                $newMember->role = ($get->type == 'model') ? UserModel::ROLE_MODEL : UserModel::ROLE_STUDIO;
                $newMember->accountStatus = UserModel::ACCOUNT_WAITING;
            } else {
                $newMember->role = UserModel::ROLE_MEMBER;
            }
            if ($newMember->save()) {
                if ($get->type == 'model') {
                    \Event::fire(new AddModelPerformerChatEvent($newMember));
                    \Event::fire(new AddModelScheduleEvent($newMember));
                    \Event::fire(new AddEarningSettingEvent($newMember));
                    \Event::fire(new AddModelPerformerEvent($newMember));
                    \Event::fire(new MakeChatRoomEvent($newMember));
                } else if ($get->type == 'member') {
                    \Event::fire(new UpdateExtendMember($newMember));
                } else if ($get->type == 'studio') {
                    \Event::fire(new AddEarningSettingEvent($newMember));
                }
                $token = \App\Helpers\AppJwt::create(array('user_id' => $newMember->id, 'username' => $newMember->username, 'email' => $email));
                $sendConfirmMail = Mail::send('email.confirm', array('username' => $newMember->username, 'email' => $email, 'token' => $token), function($message) use($email) {
                            $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($email)->subject('Verify Account | ' . app('settings')->siteName);
                        });
                if ($sendConfirmMail) {
                    return redirect('/')->with('msgInfo', 'Email has been sent to your email. Please verify email to active account !');
                } else {
                    return redirect()->back()->withInput()->with('msgError', 'Sent mail error.');
                }
            } else {
                return redirect()->back()->withInput()->with('msgError', 'System error.');
            }

      }

      /**
       * Member Confirm active account.
       *
       * @return Response
       */
      public function getActiveAccount(Request $req) {

          $token = $req->get('token');
          $getData = JWT::decode($token, JWT_SECRET, array('HS512'));
          $exp = (int) ($getData->exp / 6000);
          $time = time() - $exp;
          // if ($time > 6000) {
          //     return redirect('/')->with('msgError', 'Token has been expired. Please try again!');
          // } else {
              $updateVerifyAccount = UserModel::find($getData->data->user_id);
              if ($updateVerifyAccount->emailVerified) {
                  return Redirect('/')->with('msgError', 'Your account has been activated already.');
              }
              $updateVerifyAccount->emailVerified = UserModel::EMAIL_VERIFIED;
              $updateVerifyAccount->emailVerifyToken = $getData->data->email;
              if ($updateVerifyAccount->role == UserModel::ROLE_MEMBER) {
                  $updateVerifyAccount->accountStatus = UserModel::ACCOUNT_ACTIVE;
              }
              if ($updateVerifyAccount->save()) {
                  $putLogin = UserModel::find($getData->data->user_id);
                  AppSession::setLogin($putLogin);
                  if ($putLogin->role == UserModel::ROLE_MEMBER || ($putLogin->accountStatus == UserModel::ACCOUNT_ACTIVE && $putLogin->role == UserModel::ROLE_MODEL)) {

                      return redirect('')->with('msgInfo', 'Your account is active !');
                  } else if ($updateVerifyAccount->accountStatus == UserModel::ACCOUNT_WAITING) {
                    if($putLogin->role == UserModel::ROLE_MODEL) {
                      return Redirect('models/dashboard/account-settings?action=documents')->with('msgInfo', 'Your account was active. Please upload your verification document to admin approve.');
                    }else {
                      return Redirect('studio/account-settings')->with('msgInfo', 'Your account was active. Please upload your verification document to admin approve.');
                    }
                  }
              }
          // }
      }

      /**
       * Member forgot passwrod.
       *
       * @return Response
       */
      public function postForgotPassword(Request $get) {
          if (\Request::ajax()) {
              $rules = [
                  'emailReset' => 'Required|Email|Exists:users,email',
              ];
              $validator = Validator::make(Input::all(), $rules);
              if ($validator->fails()) {
                  return response()->json([
                              'success' => false,
                              'message' => $validator->errors()->first('emailReset')
                                  ], 200);
              }

              $postEmail = $get->emailReset;
              $member = UserModel::where('email', $postEmail)->first();
              if ($member) {
                  if($member->role === UserModel::ROLE_ADMIN && env('DISABLE_EDIT_ADMIN')) {
                    return response()->json([
                              'success' => false,
                              'message' => "Your account can not use this function"
                                  ], 200);
                  }
                  $newPassword = str_random(8);
                  $token = \App\Helpers\AppJwt::create(array('newPassword' => $newPassword, 'email' => $postEmail));
                  $sendConfirmMail = Mail::send('email.forgot_password', array('newPassword' => $newPassword, 'token' => $token, 'email' => $postEmail), function($message) use($postEmail) {
                              $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($postEmail)->subject('Reset Password | ' . app('settings')->siteName);
                          });
                  if ($sendConfirmMail) {
                      return response()->json([
                                  'success' => true,
                                  'message' => "Please check your email acount to reset password."
                                      ], 200);
                  }
              } else {
                  return response()->json([
                              'success' => false,
                              'message' => "Your email account is not existing!"
                                  ], 200);
              }
          } else {
              return redirect('login')->with('msgInbox', 'Request not found!');
          }
      }

      /**
       * Member verify forgot passwrod.
       *
       * @return Response
       */
      public function getResetPassword(Request $req) {
          $token = $req->get('token');
          $getData = JWT::decode($token, JWT_SECRET, array('HS512'));
          $exp = (int) ($getData->exp / 6000);
          $time = time() - $exp;
          if ($time > 6000) {
              return redirect('')->with('msgerror', 'Token has been expired. Please try again!');
          } else {
              $verify = UserModel::where('email', '=', $getData->data->email)->update(array('passwordHash' => md5($getData->data->newPassword)));
              
              if ($verify) {
                  $model = UserModel::where('email', '=', $getData->data->email)
                          ->where('passwordHash', '=', md5($getData->data->newPassword))
                          ->first();
                  if(!$model){
                      return redirect('/')->with('msgError', 'Model does not found.');
                  }
                  if($model->role == UserModel::ROLE_ADMIN || $model->role == UserModel::ROLE_SUPERADMIN){
                      return redirect('admin/login')->with('msgInfo', 'Your password account is reset!');
                  }else if($model->role == UserModel::ROLE_STUDIO){
                      return redirect('studio/login')->with('msgInfo', 'Your password account is reset!');
                  }
                  return redirect('login')->with('msgInfo', 'Your password account is reset !');
              }else{
                  return redirect('/')->with('msgError', 'System error, please try again.');
              }
          }
      }

      /* Show the form for creating a new resource.
       *
       * @return Response
       */

      public function create() {

      }

      /**
       * Store a newly created resource in storage.
       *
       * @return Response
       */
      public function store() {
          //
      }

      /**
       * Display the specified resource.
       *
       * @param  int  $id
       * @return Response
       */
      public function show($id) {
          //
      }

      /**
       * Show the form for editing the specified resource.
       *
       * @param  int  $id
       * @return Response
       */
      public function edit($id) {
          //
      }

      /**
       * Update the specified resource in storage.
       *
       * @param  int  $id
       * @return Response
       */
      public function update($id) {
          //
      }

      /**
       * Remove the specified resource from storage.
       *
       * @param  int  $id
       * @return Response
       */
      public function destroy($id) {
          //
      }

  }
