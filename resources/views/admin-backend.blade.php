<?php

use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;
use App\Helpers\AppJwt;

$userLogin = AppSession::getLoginData();
$jwtToken = $userLogin ? $userLogin->token : null;
?>
<!DOCTYPE html>

<html lang="en" ng-app="matroshkiApp">
  <head>
    <meta charset="UTF-8">
    <title>@yield('title') | {{app('settings')->siteName}}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{URL('favicon.ico')}}" />

    <link type="text/css" href="{{PATH_CSS}}/bootstrap.css" rel="stylesheet">
    <link type="text/css" href="{{PATH_FONT_AWESOME}}/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href="{{PATH_CSS}}/ionicons.min.css" rel="stylesheet">
    <link type="text/css" href="{{PATH_CSS}}/skin-red.min.css" rel="stylesheet">
    <link type="text/css" href="{{PATH_CSS}}/AdminLTE.css" rel="stylesheet">
    <link type="text/css" href="{{PATH_CSS}}/admin-style.css" rel="stylesheet">

    <link href="{{PATH_LIB}}/alertifyjs/build/css/alertify.min.css" rel="stylesheet" type="text/css">
    <link href="{{PATH_LIB}}/jquery-multiple-file-upload/uploadfile.css" rel="stylesheet" type="text/css">
    <link href="{{PATH_CSS}}/admin.css" rel="stylesheet" type="text/css">
    <link type="text/css" href="{{PATH_CSS}}/flexslider.css" rel="stylesheet">
  </head>

  <body class="skin-red">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="{{URL('/admin')}}" class="logo">Admin <b>{{app('settings')->siteName}}</b></a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <!-- Notifications Menu -->
              <li class="dropdown notifications-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">2</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 10 notifications</li>
                  <li>
                    <!-- Inner Menu: contains the notifications -->
                    <ul class="menu">
                      <li><!-- start notification -->
                        <a href="#">
                          <i class="fa fa-suitcase"></i> 5 new Studios joined today
                        </a>
                      </li><!-- end notification -->
                      <li><!-- start notification -->
                        <a href="#">
                          <i class="fa fa-users"></i> 3 new Users joined today
                        </a>
                      </li><!-- end notification -->
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
              <!-- Tasks Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  @if(AppHelper::is_serialized($userLogin->avatar))
                    <!-- The user image in the navbar-->
                    <img src="{{AppHelper::helperCheckThumb($userLogin->avatar,IMAGE_SMALL)}}" class="user-image" alt="User Image"/>
                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                    <span class="hidden-xs">{{$userLogin->username}}</span>
                  @else
                    <!-- The user image in the navbar-->
                    <img src="{{AppHelper::getMyProfileAvatar()}}" class="user-image" alt="User Image"/>
                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                    <span class="hidden-xs">{{$userLogin->username}}</span>
                  @endif
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="/images/upload/member/modelprofile.jpg" class="img-circle" alt="User Image" />
                    <p>
                      {{$userLogin->username}}
                      <small>Member since {{date('M - Y', strtotime($userLogin->createdAt->date))}}</small>
                    </p>
                  </li>

                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{URL('admin/auth/logout')}}" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">


          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="treeview"><a href="#"><i class="fa fa-user"></i> <span>Profile</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="#">Registration Info</a></li>
                <li><a href="#">Change Password</a></li>
              </ul>
            </li>
            <li class="treeview"><a href="#"><i class="fa fa-users"></i> <span>Manage users </span>  <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{URL('admin/list/users')}}"> List users</a></li>
                <li><a href="#">Transactions</a></li>
                <li><a href="#">Users show cam</a></li>
              </ul>
            </li>
            <li class="treeview"><a href="#"><i class="fa fa-users"></i> <span>Manage models </span>  <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{URL('admin/list/models')}}"> List models</a></li>
                <li><a href="#">Transactions</a></li>
              </ul>
            </li>
            <li class="treeview"><a href="#"><i class="fa fa-suitcase"></i> <span>Manage studio owners</span>  <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{URL('admin/list/studios')}}"> List studio owners</a></li>
                <li><a href="#">Transactions</a></li>
              </ul>
            </li>
            <li><a href="{{URL('admin/list/categories')}}"><i class="fa fa-server"></i> <span>Manage categories </span></a></li>
            <li class="treeview"><a href="#"><i class="fa fa-credit-card"></i> <span>Manage Payment</span>  <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{URL('admin/manager/payments/videos')}}"> Videos</a></li>
                <li><a href="{{URL('admin/manager/payments/galleries')}}"> Galleries</a></li>
              </ul>
            </li>

            <li><a href="{{URL('admin/manager/commission')}}"><i class="fa fa-database"></i> <span>Commission management </span></a></li>
            <li><a href="{{URL('admin/manager/paymentsystems')}}"><i class="fa fa-paypal"></i> <span>Payment gateway settings </span></a></li>
            <li class="treeview"><a href="#"><i class="fa fa-money"></i> <span>Default price settings </span>  <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="#">Pricing chat</a></li>
                <li><a href="#">Pricing Tokens</a></li>
                <li><a href="#">Pricing Tips</a></li>
              </ul>
            </li>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      @yield('content')
      <!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- Default to the left -->
        <strong>Copyright &copy; 2016 <a href="#">{{app('settings')->siteName}}</a>.</strong> All rights reserved.
      </footer>

    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->
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

    <script type="text/javascript" src="{{PATH_LIB}}/jquery/dist/jquery.min.js"></script>
    <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
    <script src="{{PATH_LIB}}/admin/js/app.min.js" type="text/javascript"></script>

    <script type="text/javascript" src="{{PATH_LIB}}/angular/angular.min.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/angular-cookies/angular-cookies.min.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/angular-sanitize/angular-sanitize.min.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/angular-socket-io/socket.min.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/lodash/lodash.min.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/jquery-multiple-file-upload/jquery.uploadfile.min.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/angularlazyimg/release/angular-lazy-img.js"></script>

    <script type="text/javascript" src="{{PATH_LIB}}/alertifyjs/build/alertify.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/moment/min/moment.min.js"></script>

    <script type="text/javascript" src="{{PATH_APP}}/app.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/components/common.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/filters/filter.js"></script>
    <script src="{{PATH_LIB}}/video-js/video.min.js"></script>
    <script src="{{PATH_LIB}}/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script src="{{PATH_LIB}}/tag-input/bootstrap-tagsinput.js"></script>

    <script type="text/javascript" src="{{PATH_LIB}}/tinymce/src/ui.tinymce.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/tinymce/src/tinymce.js"></script>

    <script type="text/javascript" src="{{PATH_APP}}/services/category.service.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/services/user.service.js"></script>
    <script src="{{PATH_APP}}/services/media.service.js"></script>
    <script src="{{PATH_APP}}/services/gallery.service.js"></script>
    <script src="{{PATH_APP}}/services/video.service.js"></script>
    <script src="{{PATH_APP}}/services/earning.service.js"></script>

    <script type="text/javascript" src="{{PATH_APP}}/controllers/category-manager.controller.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/controllers/user.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/model-profile-image.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/model-video.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/model-profile.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/model-create-gallery.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/model-edit-gallery.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/model-image-gallery.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/model-image-galleries.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/model-video-galleries.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/model-video-gallery.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/model-video-upload.controller.js"></script>

    <script type="text/javascript" src="{{PATH_APP}}/controllers/category-manager.controller.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/directives/convert-to-number/convert-to-number.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/directives/multiple-upload/multiple-upload.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/directives/app-directive.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/jquery/src/admin.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/directives/upload-file/upload-file.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/modals/loginmodal/login-modal-controller.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/modals/model-multiple-upload/model-multiple-upload-modal-controller.js"></script>

    @include('alerts.index')
    <script type="text/javascript">
        $(document).ready(function () {
            $('input.tag-input').tagsinput({});
        });
    </script>
  </body>
</html>
