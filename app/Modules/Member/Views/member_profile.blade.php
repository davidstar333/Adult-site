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
@section('title','Account Settings')
@section('content')
<div class="content">
  <div class="full-container">
    <div class="row">
      <div class="col-sm-4 col-md-2 col-xs-12">
        <div class="menu-account">
          <a href="#" class="btn btn-grey btn-block menu-left-account"><i class="fa fa-bars"></i> Menu Account</a>
          <ul>
            <li><a class="{{ Request::is('members/account-settings*')? 'active' : '' }}" href="{{URL('members/account-settings')}}"><i class="fa fa-wrench"></i> Account Settings</a></li>
            <li><a class="{{ Request::is('messages*') ? 'active' : '' }}" href="{{URL('messages')}}"><i class="fa fa-envelope-o"></i> Messages ({{AppHelper::getNotification()}})</a></li>
            <li><a class="{{ Request::is('members/favorites') ? 'active' : '' }}" href="{{URL('members/favorites')}}"><i class="fa fa-heart"></i> My Favorites</a></li>
            <li><a class="{{ Request::is('members/my-candies') ? 'active' : '' }}" href="{{URL('members/my-candies')}}"><i class="fa fa-money"></i>  Funds /Tokens</a></li>
            <li><a class="{{ Request::is('members/transaction-history')? 'active' : '' }}" href="{{URL('members/transaction-history')}}"><i class="fa fa-history"></i>  Transaction history</a></li>
            <li><a class="{{ Request::is('members/payment-tokens-history')? 'active' : '' }}" href="{{URL('members/payment-tokens-history')}}"><i class="fa fa-history"></i> Payment Tokens history</a></li>
            <li><a class="{{ Request::is('*/purchased/images') ? 'active' : '' }}" href="{{URL('members/purchased/images')}}"><i class="fa fa-history"></i> Purchased Image</a></li>
            <li><a class="{{ Request::is('members/purchased/videos')? 'active' : '' }}" href="{{URL('members/purchased/videos')}}"><i class="fa fa-history"></i> Purchased Videos</a></li>
            <li><a class="{{ Request::is('members/products/purchased')? 'active' : '' }}" href="{{URL('members/products/purchased')}}"><i class="fa fa-history"></i> Purchased Products</a></li>
          </ul>
        </div>
      </div>
      <div class="col-sm-8 col-md-10 col-xs-12">
        @yield('content_sub_member')
      </div>
    </div>
  </div>
</div>     <!-- content end-->
@endsection