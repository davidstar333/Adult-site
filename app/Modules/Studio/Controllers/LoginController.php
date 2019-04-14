<?php

  namespace App\Modules\Studio\Controllers;

  use App\Http\Requests;
  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;
  use App\Modules\Api\Models\UserModel;
  use App\Helpers\Session as AppSession;
  use Illuminate\Support\Facades\Input;
  use Illuminate\Support\Facades\Validator;

  class LoginController extends Controller {

      /**
       * Display a Studio login resource.
       * @author LongPham <long.it.stu@gmail.com>
       * @return Response
       */
      public function studioLogin() {
          return view("Studio::studioLogin");
      }

      /**
       * studio login
       */
      public function postLogin() {
          $user = UserModel::where('username', '=', Input::get('username'))
                  ->where('passwordHash', '=', md5(Input::get('password')))
                  ->where('role', UserModel::ROLE_STUDIO)
                  ->first();
          if (!$user) {
              return Redirect('studio/login')->withInput()->with('msgError', 'Username or password does not match.');
          }

          if ($user->emailVerified == 0) {
              return redirect('login')->with('msgError', 'Your account has not been verified, please check your email');
          } else if ($user->accountStatus == UserModel::ACCOUNT_DISABLE) {
              return Redirect('login')->with('msgError', 'Your account was disabled.');
          } else if ($user->accountStatus == UserModel::ACCOUNT_SUSPEND) {
              return Redirect('login')->with('msgError', 'Your account was suspend.');
          }

          AppSession::setLogin($user);

          //TODO - should redirect pa Studio panel
          return redirect('studio/account-settings');

          if (!empty(\Request::cookie('backUri'))) {
              return redirect(\Request::cookie('backUri'))->with('msgInfo', 'Hi ' . $user->firstName . ' ' . $user->lastName . '. Welcome back ');
          } else {
              return redirect('/')->with('msgInfo', 'Hi ' . $user->firstName . ' ' . $user->lastName . '. Welcome back ');
          }
      }

      /**
       * Display a Studio Recover resource.
       * @author LongPham <long.it.stu@gmail.com>
       * @return Response
       */
      public function studioRecover() {
          return view("Studio::studioRecover");
      }

      /**
       * Action Studio login Recover .
       * @author LongPham <long.it.stu@gmail.com>
       * @return Response
       */
      public function actionStudioRecover(Request $get) {
          
      }

      /**
       * Action Studio login Recover .
       * @author LongPham <long.it.stu@gmail.com>
       * @return Response
       */
      public function actionStudioLogout() {
          \Session::forget('UserLogin');
          return redirect('studio')->with('msgInfo', 'Good bye.');
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return Response
       */
      public function create() {
          //
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
  