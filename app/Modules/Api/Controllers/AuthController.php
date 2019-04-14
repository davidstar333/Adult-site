<?php

  namespace App\Modules\Api\Controllers;

  use App\Http\Requests;
  use App\Http\Controllers\Controller;
  use App\Modules\Api\Models\UserModel;
  use Illuminate\Http\Request;
  use App\Helpers\Session as AppSession;
  use App\Helpers\Helpers as AppHelper;
  use App\Helpers\Jwt;
  use Illuminate\Support\Facades\Validator;
  use Illuminate\Support\Facades\Input;

  class AuthController extends Controller {

      /**
       * Remove the specified resource from storage.
       *
       * @param  int  $id
       * @return Response
       */
      public function login(Request $req) {
          if (\Request::ajax()) {
              $login = UserModel::CheckLogin($req->username, md5($req->password));

              if ($login) {
                  $user = UserModel::where('username', '=', $req->username)
                          ->where('passwordHash', '=', md5($req->password))
                          ->first();

                  //push user data to login
                  AppSession::setLogin($user);

                  //generate jwt token for this case
                  $token = Jwt::create(['id' => $user->id, 'username' => $user->username]);

                  return response()->json(['login' => true, 'token' => $token]);
              } else {
                  return response()->json([
                              'login' => null
                  ]);
              }
          } else {

              $user = UserModel::where('username', '=', $req->username)
                      ->where('passwordHash', '=', md5($req->password))
                      ->first();
              if (!$user) {
                  return Redirect('login')->withInput()->with('msgError', 'Username or password does not match.');
              }

              if ($user->emailVerified === 0) {
                  return redirect('login')->with('msgError', 'Your account has not been verified, please check your email');
              } else if ($user->accountStatus == UserModel::ACCOUNT_DISABLE) {
                  return Redirect('login')->with('msgError', 'Your account was disabled.');
              } else if ($user->accountStatus == UserModel::ACCOUNT_SUSPEND) {
                  return Redirect('login')->with('msgError', 'Your account was suspend.');
              }

              AppSession::setLogin($user);

              //TODO - should redirect to specific page for model / user...
              if ($user->role === 'model') {
                  //TODO - should redirect pa model panel
                  //after click live we will rediect to this view
                  return redirect('/models/live');
              }
              if ($user->role === 'studio') {
                  //TODO - should redirect pa Studio panel
                  return redirect('studio/account-settings');
              }
              if (!empty(\Request::cookie('backUri'))) {
                  return redirect(\Request::cookie('backUri'))->with('msgInfo', 'Hi ' . $req->username . '. Welcome back ');
              } else {
                  return redirect('/')->with('msgInfo', 'Hi ' . $req->username . '. Welcome back ');
              }
          }
      }

      /**
       * Remove the specified resource from storage.
       *
       * @param  int  $id
       * @return Response
       */
      public function appLogin() {

          $validator = Validator::make(Input::all(), [
                      'username' => 'Required|AlphaNum',
                      'password' => 'Required'
          ]);
          if ($validator->fails()) {
              return response($validator->errors(), 401)->header('Content-Type', 'application/json');
          }


          $user = UserModel::where('username', '=', Input::get('username'))
                  ->where('passwordHash', '=', md5(Input::get('password')))
                  ->where('role', UserModel::ROLE_MEMBER)
                  ->first();

          if (!$user) {
              return response(['message' => 'Username or password does not match.'], 401)->header('Content-Type', 'application/json');
          }

          if ($user->emailVerified === 0) {
              return response(['message' => 'Your account has not been verified, please check your email.'], 422)->header('Content-Type', 'application/json');
          } else if ($user->accountStatus == UserModel::ACCOUNT_DISABLE) {
              return response(['message' => 'Your account was disabled.'], 422)->header('Content-Type', 'application/json');
          } else if ($user->accountStatus == UserModel::ACCOUNT_SUSPEND) {
              return response(['message' => 'Your account was suspend.'], 422)->header('Content-Type', 'application/json');
          }
          AppSession::setLogin($user);

          if (\Session::has('UserLogin')) {
              return response(\Session::get('UserLogin'), 200)->header('Content-Type', 'application/json');
          } else {
              return response(['message' => 'Session not found, please login again.'], 422)->header('Content-Type', 'application/json');
          }
      }

      public function isLogin() {

          $loginData = AppSession::getLoginData();
          return $loginData ? $loginData->id : null;
      }

      public function isModel() {

          if (\Session::has('UserLogin') && \Session::get('UserLogin')['role'] === 'model') {
              return true;
          } else {
              return false;
          }
      }

      public function getLogout() {
          if (AppHelper::updateLogoutTime(AppSession::getLoginData()->id)) {
              \Session::forget('UserLogin');
              return redirect('/');
          }
      }

  }
  