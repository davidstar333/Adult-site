<?php

use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;

$userLogin = AppSession::getLoginData();
?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ AppHelper::getMyProfileAvatar() }}" class="img-circle" alt="User Image" />
      </div>
      <div class="pull-left info">
        <p>{{$userLogin->username}}</p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- search form (Optional) -->
<!--    <form action="" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search..." value="{{Request::get('q')}}"/>
        <span class="input-group-btn">
          <button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form>-->
    <!-- /.search form -->

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">HEADER</li>
      <!-- Optionally, you can add icons to the links -->
      <li class="{{Request::is('*/profile') ? 'active' : ''}}"><a href="{{URL('admin/manager/profile')}}"><i class="fa fa-user"></i> <span>Profile</span></a>
      </li>
      <li class="treeview {{Request::is('*/manager/member*') ? 'active': ''}}"><a href="#"><i class="fa fa-users"></i> <span>Manage users </span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{Request::is('*/members') ? 'active': ''}}"><a href="{{URL('admin/manager/members')}}"> List users</a></li>
          <li class="{{Request::is('*/member/add') ? 'active': ''}}"><a href="{{URL('admin/manager/member/add')}}"> Add member</a></li>
          <li class="{{Request::is('*/members/transactions') ? 'active': ''}}"><a href="{{URL('admin/manager/members/transactions')}}"> Transactions</a></li>
        </ul>
      </li>
      <li class="treeview {{(Request::is('*/manager/performers*') && !Request::is('*/performerstudios*') || Request::is('*/manager/model/*')) ? 'active': '' }}"><a href="#"><i class="fa fa-users"></i> <span>Manage models </span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{Request::is('*/performers') ? 'active': ''}}"><a href="{{URL('admin/manager/performers')}}"> List models</a></li>
          <li class="{{Request::is('*/manager/performers/online') ? 'active': ''}}"><a href="{{URL('admin/manager/performers/online')}}"> Models online</a></li>
          <li class="{{Request::is('*/model/add') ? 'active': ''}}"><a href="{{URL('admin/manager/model/add')}}"> Add model</a></li>
          <li class="{{Request::is('*/manager/performers-pending') ? 'active': ''}}"><a href="{{URL('admin/manager/performers-pending')}}"> Pending Models</a></li>
        </ul>
      </li>
      <li class="treeview {{(Request::is('*/manager/performerstudios*') || Request::is('*/manager/studio/*') || Request::is('*/studio-profile/*')) ? 'active': ''}}"><a href="#"><i class="fa fa-suitcase"></i> <span>Manage studio owners</span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{Request::is('*/performerstudios') ? 'active': ''}}"><a href="{{URL('admin/manager/performerstudios')}}"> List studio owners</a></li>
          <li class="{{Request::is('*/studio/add') ? 'active': ''}}"><a href="{{URL('admin/manager/studio/add')}}"> Add Studio</a></li>
          <li class="{{Request::is('*/performerstudios-pending') ? 'active': ''}}"><a href="{{URL('admin/manager/performerstudios-pending')}}"> Pending Studios</a></li>
        </ul>
      </li>
      <li class="treeview {{(Request::is('*/stats/*')) ? 'active': ''}}"><a href="#"><i class="fa fa-line-chart"></i> <span>Manage stats</span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{Request::is('*/stats/performer') ? 'active': ''}}"><a href="{{URL('admin/stats/performer')}}">Model</a></li>
          <li class="{{Request::is('*/stats/studio') || Request::is('*/stats/studio-model*') ? 'active': ''}}"><a href="{{URL('admin/stats/studio')}}"> Studio</a></li>
        </ul>
      </li>
      <li class="{{Request::is('*/performercategories') ? 'active' : ''}}"><a href="{{URL('admin/manager/performercategories')}}"><i class="fa fa-server"></i> <span>Manage categories </span></a></li>
      <li class="treeview {{Request::is('*/payments/*') ? 'active' : ''}}"><a href="#"><i class="fa fa-credit-card"></i> <span>Manage Transactions</span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{Request::is('*/payments/videos') ? 'active' : ''}}"><a href="{{URL('admin/manager/payments/videos')}}"> Videos</a></li>
          <li class="{{Request::is('*/payments/galleries') ? 'active' : ''}}"><a href="{{URL('admin/manager/payments/galleries')}}"> Galleries</a></li>
          <li class="{{Request::is('*/payments/others') ? 'active' : ''}}"><a href="{{URL('admin/manager/payments/others')}}"> Tips and Private/Group</a></li>
          <li class="{{Request::is('*/payments/products') ? 'active' : ''}}"><a href="{{URL('admin/manager/payments/products')}}"> Physical Product</a></li>
        </ul>
      </li>
      <li class="treeview {{Request::is('*/requestpayout/*') ? 'active' : ''}}">
        <a href="#"><i class="fa fa-usd"></i> <span>Request payout</span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{Request::is('*/requestpayout/performers/listing') ? 'active' : ''}}">
            <a href="{{URL('admin/requestpayout/performers/listing')}}"> List all Model requests</a>
          </li>
          <li class="{{Request::is('*/requestpayout/studios/listing') ? 'active' : ''}}">
            <a href="{{URL('admin/requestpayout/studios/listing')}}"> List all studio requests</a>
          </li>
        </ul>
      </li>
      <li class="treeview {{Request::is('*/commission/*') ? 'active' : ''}}">
        <a href="#"><i class="fa fa-database"></i> <span>Commission management</span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{Request::is('*/commission/model') ? 'active' : ''}}">
            <a href="{{URL('admin/manager/commission/model')}}">Model %</a>
          </li>
          <li class="{{Request::is('*/commission/studio') ? 'active' : ''}}">
            <a href="{{URL('admin/manager/commission/studio')}}"> Studio %</a>
          </li>
        </ul>
      </li>
      <li class="{{(Request::is('*/paymentsystems')) ? 'active' : ''}}"><a href="{{URL('admin/manager/paymentsystems')}}"><i class="fa fa-paypal"></i> <span>Payment gateway settings </span></a></li>
      <li class="{{(Request::is('*/settings')) ? 'active' : ''}}"><a href="{{URL('admin/dashboard/settings')}}"><i class="fa fa-wrench"></i> <span>Settings </span></a>
      <li class="{{(Request::is('*/settings/seo')) ? 'active' : ''}}"><a href="{{URL('admin/dashboard/settings/seo')}}"><i class="fa fa-wrench"></i> <span>SEO </span></a>
      </li>
      <li class="treeview {{(Request::is('*/pages') || Request::is('*/page') || Request::is('*/email-templates')) ? 'active': ''}}"><a href="#"><i class="fa fa-users"></i> <span>Content Manager</span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{(Request::is('*/pages') || Request::is('*/page')) ? 'active': ''}}"><a href="{{URL('admin/pages')}}"> Pages</a></li>
          
        </ul>
      </li>
    </ul><!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>