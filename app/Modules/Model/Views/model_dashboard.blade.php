<?php

use App\Helpers\Helper as AppHelper;
use App\Helpers\Session as AppSession;

if (AppSession::isLogin())
  $user = AppSession::getLoginData();
if (!empty(AppHelper::getMemberinfo($user->id))) {
  $member = AppHelper::getMemberinfo($user->id);
}
?>
@extends('frontend')
@section('title','Model Dashboard')
@section('content')
<div class="content">
  <div class="full-container">
    <div class="row">
      <div class="col-ms-4 col-md-2">
        <a href="{{URL('models/live')}}" class="btn btn-danger btn-lg btn-block m10 {{ Request::is('modelslive') ? 'active' : '' }}">Go Online </a>
        <div class="menu-account">
          <a href="#" class="btn btn-grey btn-block menu-left-account"><i class="fa fa-bars"></i> Menu Account</a>
          <ul>
            <li><a class="{{ Request::is('models/dashboard/profile*')? 'active' : '' }}" href="{{URL('models/dashboard/profile')}}"><i class="fa fa-user"></i> Profile</a></li>
            <li><a class="{{ Request::is('models/dashboard/account-settings')? 'active' : '' }}" href="{{URL('models/dashboard/account-settings?action=commissions')}}"><i class="fa fa-wrench"></i> Account Settings</a></li>
            <li><a class="{{ 
                  (Request::is('models/dashboard/messages*')) ? 
                  'active' : '' }}" href="{{URL('models/dashboard/messages')}}">
                <i class="fa fa-envelope-o"></i> Messages ({{AppHelper::getNotification()}})</a></li>
            <li><a class="{{ Request::is('models/dashboard/earnings') ? 'active' : '' }}" href="{{URL('models/dashboard/earnings')}}"><i class="fa fa-money"></i> Earnings</a></li>
            <li><a class="{{ Request::is('models/dashboard/schedule*') ? 'active' : '' }}" href="{{URL('models/dashboard/schedule')}}"><i class="fa fa-clock-o"></i> Schedules</a></li>
            <li><a class="{{ Request::is('models/dashboard/chat-settings')? 'active' : '' }}" href="{{URL('models/dashboard/chat-settings')}}"><i class="fa fa-cogs"></i> Chat settings</a></li>
            <li><a class="{{ (Request::is('*media/video-galleries') || Request::is('*media/videos') || Request::is('*media/view-video*') || Request::is('*media/edit-video*') || Request::is('*/media/add-video-gallery*'))? 'active' : '' }}" href="{{URL('models/dashboard/media/videos')}}"><i class="fa fa-video-camera"></i> Videos</a></li>
            <li><a class="{{ (Request::is('*media/image-galleries') || Request::is('*media/image-gallery*') || Request::is('*media/edit-image-gallery*') || Request::is('*media/add-image-gallery*'))? 'active' : '' }}" href="{{URL('models/dashboard/media/image-galleries')}}"><i class="fa fa-camera"></i> Images</a></li>
            <li>
              <a class="{{ Request::is('models/dashboard/products') ? 'active' : '' }}" href="{{URL('models/dashboard/products')}}"><i class="fa fa-list"></i>@lang('messages.myProducts')</a>
            </li>
            <li>
              <a class="{{ Request::is('models/dashboard/products/orders') ? 'active' : '' }}" href="{{URL('models/dashboard/products/orders')}}"><i class="fa fa-list"></i>@lang('messages.purchasedItems')</a>
            </li>
            <li>
              <a class="{{ Request::is('models/dashboard/payouts/requests*') ? 'active' : '' }}" href="{{URL('models/dashboard/payouts/requests')}}"><i class="fa fa-money"></i>@lang('messages.payoutRequests')</a>
            </li>
            <li><a class="{{ Request::is('models/dashboard/geo-blocking')? 'active' : '' }}" href="{{URL('models/dashboard/geo-blocking')}}"><i class="fa fa-map-marker" aria-hidden="true"></i> GEO Blocking</a></li>
          </ul>
        </div>
      </div>
      <div class="col-ms-8 col-md-10">
        @yield('content_sub_model')
      </div>
    </div>
  </div>
</div>     <!-- content end-->
@endsection