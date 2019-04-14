<?php

  namespace App\Modules\Admin\Controllers;

  use App\Http\Controllers\Controller;
  use App\Helpers\Session as AppSession;
  use Illuminate\Support\Facades\Validator;
  use Illuminate\Support\Facades\Input;
  use App\Modules\Api\Models\UserModel;
  use Illuminate\Support\Facades\Mail;

  class AuthController extends Controller {

      /**
       * Display a listing of the resource.
       *
       * @return Response
       */
      public function index() {

          return view("Admin::index");
      }

      /**
       * @author Phong Le <pt.hongphong@gmail.com>
       * @return Response login page
       */
      public function login() {
          return view('Admin::auth-login');
      }
      /**
       * @author Phong Le <pt.hongphong@gmail.com>
       * @return Response forgot password page
       */
      public function forgotPassword() {
          if(env('DISABLE_EDIT_ADMIN')) {
            return redirect('admin/login')->with('msgError', 'Can not access this page!');
          }
          return view('Admin::auth-forgot-password');
      }
      
      /**
       * process forgot password
       * @param text $usernameOrEmail 
       * @author Phong Le <pt.hongphong@gmail.com>
       */
      public function processForgotPassword(){        
          $validator = Validator::make(Input::all(), [
                      'email' => 'required|email'
          ]);
          if ($validator->fails()) {
              return back()->withInput()->withErrors($validator);
          }
          
          $model = UserModel::where('email', '=', Input::get('email'))
            ->whereRaw('(role="'.UserModel::ROLE_ADMIN.'" OR role = "'.UserModel::ROLE_SUPERADMIN.'")')
            ->first();
          if(!$model){
              
              return back()->withInput()->withErrors(['email' => 'Email does not exist.']);
          }
         
         $email = Input::get('email');
         $newPassword = str_random(8);
         $token = \App\Helpers\AppJwt::create(array('newPassword' => $newPassword, 'email' => $email));
         $model->passwordResetToken = $token;
         if($model->save()){
            $sendConfirmMail = Mail::send('email.forgot_password', array('newPassword'=>$newPassword, 'email' => $model->email, 'token' => $token), function($message) use($email) {
                        $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($email)->subject('Reset Password | ' . app('settings')->siteName);
                    });
            if ($sendConfirmMail) {
                return redirect('admin/login')->with('msgInfo', 'Please check your email acount to reset password.');
            } else {
                return redirect()->back()->withInput()->with('msgError', 'Sent mail error.');
            }
         }
         return back()->with('msgError', 'System error.');
      }

      
      /**
       * @author Phong Le <pt.hongphong@gmail.com>
       * @param string $email admin email
       * @param string $password admin password
       */
      public function loginProcess() {

          $validator = Validator::make(Input::all(), [
                      'email' => 'email|required',
                      'password' => 'required',
          ]);
          if ($validator->fails()) {
              return redirect('admin/login')
                              ->withErrors($validator)
                              ->withInput(Input::except('password'));
          }
          $email = Input::get('email');
          $password = md5(Input::get('password'));

          $userLogin = UserModel::where('email', '=', $email)->where('passwordHash', '=', $password)->whereRaw('(role="' . UserModel::ROLE_ADMIN . '" OR role = "' . UserModel::ROLE_SUPERADMIN . '")')->where('emailVerified', '=', 1)->first();

          if (!$userLogin) {
              return redirect('admin/login')
                              ->withInput(Input::except('password'))
                              ->with('msgError', 'Email/Password is not correct.');
          }
          if ($userLogin->accountStatus == UserModel::ACCOUNT_DISABLE) {
              return back()->with('msgError', 'Your account was disabled.');
          } else if ($userLogin->accountStatus == UserModel::ACCOUNT_SUSPEND) {
              return back()->with('msgError', 'Your account was suspend.');
          }
          if ($userLogin->accountStatus == UserModel::ACCOUNT_ACTIVE) {
              AppSession::setLogin($userLogin);
              return Redirect('admin/dashboard');
          }else{
              return back()->with('msgError', 'Your account was not activated.');
          }
              
      }

      /**
       * 
       */
      public static function checkPassword($attribute, $value, $parameters) {
          $userData = AppSession::getLoginData();
          if (!$userData) {
              return false;
          }

          return UserModel::where('id', $userData->id)
                          ->where('passwordHash', md5($value))->first();
      }

      /**
       * get admin logout
       */
      public function logout() {
          AppSession::getAdminLogout();
          return Redirect('admin/login');
      }

  }
  