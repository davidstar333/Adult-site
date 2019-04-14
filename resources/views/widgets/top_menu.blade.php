<?php
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;

$userLogin = AppSession::getLoginData();
?>
<div class="line-menu">
  <div class="full-container">
    <a class="btn btn-danger navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#bs-nav-navbar-collapse" aria-expanded="false"><i class="fa fa-bars"></i> Menu</a>
    <div class="menu collapse navbar-collapse" id="bs-nav-navbar-collapse">
        <ul>
          <li class="{{Request::is('*category*') ? 'active': ''}}" class="dropdown" id="category-sub">
            <a class="dropdown-toggle" data-toggle="dropdown" role="button"
              aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i> Categories</a>
            <ul class="dropdown-menu">
              @if(count($categories))
                @foreach($categories as $cate)
                <li><a href="{{URL('/category')}}/{{$cate->slug}}" class="btn btn-link">{{$cate->name}}</a></li>
                @endforeach
              @endif
            </ul>
        </li>
        <li class="{{Request::is('*all-model*') ? 'active': ''}}"><a href="{{URL('/all-model')}}" class="btn btn-grey">ALL MODELS</a></li>

        @if (AppSession::isLogin())
          @if($userLogin->role == 'studio')
          <li><a href="{{URL('/studio')}}">Studios</a></li>
          @endif
          @if($userLogin->role == 'model')
          <li class="{{Request::is('*live*') ? 'active': ''}}"><a href="{{URL('models/live')}}" class="btn btn-grey">Broadcast Yourself</a></li>
          <li class="{{Request::is('*models/groupchat') ? 'active': ''}}"><a href="{{URL('/models/groupchat')}}" class="btn btn-grey">Group chat</a></li>
          @elseif($userLogin->role == 'member')
          <li class="{{Request::is('*blog*') ? 'active': ''}}"><a href="{{URL('blog')}}" class="btn btn-grey">Blog</a></li>

          @endif
        @else
        <li class="{{Request::is('*live*') ? 'active': ''}}"><a href="{{URL('models/live')}}" class="btn btn-grey">Broadcast Yourself</a></li>
        <li class="{{Request::is('*blog*') ? 'active': ''}}"><a href="{{URL('blog')}}" class="btn btn-grey">Blog</a></li>
        <li class="{{Request::is('*studio*') ? 'active': ''}}"><a href="{{URL('studio')}}" class="btn btn-grey">Studios</a></li>
        @endif
      </ul>
        <div class="search-top hidden-xs hidden-sm">
            <form action="" method="get" accept-charset="utf-8" class="">
                <input type="text" name="q" class="form-control" placeholder="Search" value="{{Request::get('q')}}">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="search-top hidden-md hidden-lg hidden-sm">
        <form action="" method="get" accept-charset="utf-8" class="">
            <input type="text" name="q" class="form-control" placeholder="Search" value="{{Request::get('q')}}">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
  </div>
</div>
