<?php

use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;

$userLogin = AppSession::getLoginData();
?>
<!DOCTYPE html>
<html lang="en" ng-app="matroshkiApp">
<head>
  <meta charset="utf-8">
    <title>@yield('title') | {{app('settings')->title}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{URL('favicon.ico')}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link type="text/css" href="{{asset('assets/css/frontend.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('assets/css/lib.css')}}" rel="stylesheet">
</head>
<body class="studio">
  <div class="header">
      <div class="full-container">
        <div class="logo">
          <a href="{{URL('/')}}"><img src="{{URL('uploads/'.app('settings')->logo)}}" alt="{{app('settings')->siteName}}" fallback-src="{{URL('images/logo.png')}}"></a>
        </div>
        <div class="right-header">
          <?php if (!AppSession::isLogin()): ?>
            <div class="login-top">
              {{Form::open(array('method'=>'post', 'url'=>URL('studio/auth/login'), 'class'=>'form-horizontal', 'autocomplete' => 'off' ))}}
                {{Form::text('username', old('username'), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Username'))}}
                {{Form::password('password', array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Password'))}}
                {{Form::submit('Login', array('class'=>'btn btn-grey'))}}
              {{Form::close()}}
            </div>
            <a href="{{URL('register')}}" class="btn btn-danger button-register">Register</a>
          <?php else: ?>
            <div class="profile-top dropdown">
              <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src="{{AppHelper::getMyProfileAvatar()}}">
                  <?php echo (!empty($userLogin->firstName) && !empty($userLogin->lastName)) ? $userLogin->firstName . ' '. $userLogin->lastName : $userLogin->username;?>
                </a>
            </div>
            <a href="{{URL('studio/logout')}}" class="logout"><i class="fa fa-power-off"></i></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="line-menu">
      <div class="full-container">
        <div class="search-top">
          <form method="get" action="">
            <input type="text" class="form-control" placeholder="Search" name="q" value="{{Request::get('q')}}">
            <button><i class="fa fa-search"></i></button>
          </form>
        </div>
      </div>
    </div>

    <!-- content -->
    @yield('content')
    <!-- content end-->

    <div class="footer">
      <div class="full-container">
        @foreach( app('pages') as $page )
        <a href="{{URL('page/'.$page->alias)}}">{{$page->title}}</a>
        @endforeach
        <a href="{{URL('register?type=model')}}">Models Sign up</a>
        <a href="{{URL('register?type=member')}}">User Sign up</a>
        <div class="copy">&COPY; Copyright {{app('settings')['siteName']}} {{Date('Y')}} - Version {{VERSION}} - build {{BUILD}}. All Rights Reserved.</div>
      </div>
    </div>
      <script>
        var appSettings = <?=
        json_encode([
          'SOCKET_URL' => SOCKET_URL,
          'CHAT_ROOM_ID' => isset($roomId) ? $roomId : null,
          'BASE_URL' => BASE_URL,
          'TURN_CONFIG' => AppHelper::getTurnInfo() ? AppHelper::getTurnInfo() : [],
          'IS_ANONYMOUS' => isset($isAnonymous) ? $isAnonymous : false,
          'TOKEN' => ($userLogin) ? $userLogin->token : null,
          'LIMIT_PER_PAGE' => LIMIT_PER_PAGE,
          'USER' => !$userLogin ? null : ['id' => $userLogin->id, 'role' => $userLogin->role]
          ]);
        ?>;
        var userData = {'USER_TOKEN': '<?= ($userLogin) ? $userLogin->token : null; ?>'};
      </script>
    <script type="text/javascript" src="{{asset('lib/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
<!--    <script type="text/javascript" src="{{PATH_LIB}}/socketio/socket.io-1.4.5.js"></script>-->
    <script type="text/javascript" src="{{asset('lib/eventEmitter/EventEmitter.min.js')}}"></script>
    <script src="{{ asset('assets/js/angular.js') }}"></script>
    <script type="text/javascript" src="{{asset('lib/lodash/lodash.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/json3/lib/json3.min.js')}}"></script>
    <!--<script type="text/javascript" src="{{PATH_LIB}}/emoticons/emoticons.js"></script>-->



    <script src="{{ asset('assets/js/lib.js') }}"></script>

    <script type="text/javascript" src="{{PATH_LIB}}/angularlazyimg/release/angular-lazy-img.js"></script>

    <script type="text/javascript" src="{{URL('js/bootstrap-tagsinput.min.js')}}"></script>
    <!--Bower-->
    <script type="text/javascript" src="{{asset('assets/js/app.js')}}"></script>
    <script type="text/javascript" src="{{asset('app/filters/filter.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/service.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/model.controller.js')}}"></script>
    <script src="{{ asset('assets/js/directive.js') }}"></script>
    <script type="text/javascript" src="{{asset('lib/jquery/src/site.js')}}"></script>
    <script src="{{ asset('assets/js/modal.js') }}"></script>
    <script>
      $(document).ready(function () {
        $('.menu ul li a.menu-category').click(function () {
          $('.menu ul li ul').toggle();
        });
        $('.toggle-menu').click(function () {
          $('.menu').toggle();
          return false;
        });
        $('.button-login').click(function () {
          $('.login-top').toggle();
          return false;
        });
        $('.menu-left-account').click(function () {
          $('.menu-account ul').toggle();
          return false;
        });
        $('.left_nav button').click(function () {
          $('.left_nav .user_navigation.collapsed').toggle();
        });
      });
    </script>

      @include('alerts.index')
    </body>
    </html>
