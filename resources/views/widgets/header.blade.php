<?php
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;

$userLogin = AppSession::getLoginData();
?>
<div class="header">
  <div class="full-container">
    <div class="logo">
      <a href="{{URL('/')}}">
        @if(app('settings')->logo)
        <img src="/uploads/{{app('settings')->logo}}" alt="{{app('settings')->siteName}}"></a>
        @endif
      </a>
    </div>
    <div class="right-header">
      <?php if (!AppSession::isLogin()): ?>
        <div class="login-top">
          {{Form::open(array('method'=>'post', 'url'=>URL('auth/login'), 'class'=>'form-horizontal', 'autocomplete' => 'off' ))}}
            {{Form::text('username', old('username'), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Username'))}}
            {{Form::password('password', array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Password'))}}
            {{Form::submit('Login', array('class'=>'btn btn-grey'))}}
          {{Form::close()}}
        </div>
        <a href="{{URL('login')}}" class="btn btn-danger button-register visible-xs">Login</a>
        <a href="{{URL('register')}}" class="btn btn-danger button-register">Register</a>
      <?php else: ?>
        <div class="profile-top dropdown">

            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="{{AppHelper::getMyProfileAvatar()}}">
              <?php echo $userLogin->username;?>
            </a>

          @if($userLogin->role === 'member')
            <ul class="dropdown-menu" aria-labelledby="dLabel">
              <li><a href="{{URL('members/account-settings')}}"><i class="fa fa-wrench"></i> Account Settings</a></li>
              <li><a href="{{URL('messages')}}"><i class="fa fa-envelope-o"></i> Messages ({{AppHelper::getNotification()}})</a></li>
              <li><a href="{{URL('members/favorites')}}"><i class="fa fa-heart"></i> My Favorites</a></li>
              <li><a href="{{URL('members/my-candies')}}"><i class="fa fa-money"></i> Funds /Tokens</a></li>
            </ul>
          @endif
          @if($userLogin->role === 'model')
          <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a href="{{URL('models/dashboard/profile')}}"><i class="fa fa-user" aria-hidden="true"></i> Profile</a></li>
            <li><a href="{{URL('models/dashboard/account-settings?action=commissions')}}"><i class="fa fa-wrench"></i> Account Settings</a></li>
            <li><a href="{{URL('models/dashboard/messages')}}"><i class="fa fa-envelope-o"></i> (Messages {{AppHelper::getNotification()}})</a></li>
            <li><a href="{{URL('models/dashboard/chat-settings')}}"><i class="fa fa-cogs"></i> Chat settings</a></li>
          </ul>
          @endif
          @if($userLogin->role === 'studio')
          <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a href="{{URL('studio/account-settings')}}"><i class="fa fa-wrench"></i> Account Settings</a></li>
          </ul>
          @endif
          @if($userLogin->role === 'admin')
          <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a href="{{URL('admin')}}"><i class="fa fa-wrench"></i> Admin Dashboard</a></li>
          </ul>
          @endif
        </div>
        @if($userLogin->role == 'studio')
        <a href="{{URL($userLogin->role.'/logout')}}" class="logout"><i class="fa fa-power-off"></i></a>
        @endif
        @if($userLogin->role == 'member')
        <a href="{{URL('members/logout')}}" class="logout"><i class="fa fa-power-off"></i></a>
        @endif
         @if($userLogin->role == 'model')
        <a href="{{URL('models/logout')}}" class="logout"><i class="fa fa-power-off"></i></a>
        @endif
      <?php endif; ?>
    </div>
  </div>
</div>
