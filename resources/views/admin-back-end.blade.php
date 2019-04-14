<?php

use App\Helpers\Session as AppSession;

$userLogin = AppSession::getLoginData();
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html ng-app="matroshkiApp">
  <head>
    <meta charset="UTF-8">
    <title>@yield('title') | {{app('settings')->siteName}}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/skin-blue.min.css")}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{PATH_CSS}}/bootstrap-datetimepicker.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link href="{{PATH_LIB}}/alertifyjs/build/css/alertify.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{PATH_LIB}}/jquery-multiple-file-upload/uploadfile.css" type="text/css"/>
    <link href="{{PATH_CSS}}/admin.css" rel="stylesheet" type="text/css">
    <link href="{{PATH_CSS}}/bootstrap-tagsinput.css" rel="stylesheet" type="text/css">
    <link type="text/css" href="{{asset('lib/select2/dist/css/select2.css')}}" rel="stylesheet">

    <!-- jQuery 2.1.3 -->
    <script src="{{ asset("/bower_components/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
  </head>
  <body class="skin-blue">
    <div class="wrapper">

      <!-- Header -->
      @include('admin-header')

      <!-- Sidebar -->
      @include('admin-sidebar')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            @yield('title')
            <small>@yield('description')</small>
          </h1>
          <!-- You can dynamically generate breadcrumbs here -->

          <ol class="breadcrumb">
            @yield('breadcrumb')

          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Your Page Content Here -->
          @yield('content')
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Footer -->
      @include('admin-footer')

    </div><!-- ./wrapper -->

    <script>
      var appSettings = <?=
json_encode([
  'BASE_URL' => BASE_URL,
  'TOKEN' => ($userLogin) ? $userLogin->token : null,
  'LIMIT_PER_PAGE' => LIMIT_PER_PAGE,
  'USER' => !$userLogin ? null : ['id' => $userLogin->id, 'role' => $userLogin->role]
]);
?>;
    </script>
    <!-- REQUIRED JS SCRIPTS -->
    <script type="text/javascript" src="{{asset('lib/select2/dist/js/select2.min.js')}}"></script>

    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ asset("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js")}}" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset("/bower_components/AdminLTE/dist/js/app.min.js")}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/angular/angular.min.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/angular-cookies/angular-cookies.min.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/angular-sanitize/angular-sanitize.min.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/angular-socket-io/socket.min.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/lodash/lodash.min.js"></script>

    <script type="text/javascript" src="{{PATH_LIB}}/alertifyjs/build/alertify.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/moment-timezone/moment-timezone.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/moment-timezone/moment-timezone-utils.js"></script>
     <script type="text/javascript" src="{{PATH_LIB}}/jquery-multiple-file-upload/jquery.uploadfile.min.js"></script>
     <script type="text/javascript" src="{{PATH_LIB}}/angularlazyimg/release/angular-lazy-img.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/app.js"></script>

    <script type="text/javascript" src="{{PATH_APP}}/components/common.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/filters/filter.js"></script>
    <script src="{{PATH_LIB}}/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script src="{{PATH_LIB}}/tag-input/bootstrap-tagsinput.js"></script>

    <script type="text/javascript" src="{{PATH_LIB}}/tinymce/src/ui.tinymce.js"></script>
    <script type="text/javascript" src="{{PATH_LIB}}/tinymce/src/tinymce.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/directives/ng-tags/ng-tags-input.js"></script>

    <script type="text/javascript" src="{{PATH_APP}}/services/category.service.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/services/user.service.js"></script>
    <script src="{{PATH_APP}}/services/media.service.js"></script>
    <script src="{{PATH_APP}}/services/gallery.service.js"></script>
    <script src="{{PATH_APP}}/services/video.service.js"></script>
    <script src="{{PATH_APP}}/services/earning.service.js"></script>
    <script src="{{PATH_APP}}/services/document.service.js"></script>
    <script src="{{PATH_APP}}/services/payment.service.js"></script>
    <script src="{{PATH_APP}}/services/payout.service.js"></script>

    <script type="text/javascript" src="{{PATH_APP}}/modals/model-multiple-upload/model-multiple-upload-modal-controller.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/modals/modalStatus/userstatus-modal-controller.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/modals/video/video-popup-controller.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/modals/transaction/transaction-popup-controller.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/modals/document/document-modal-controller.js"></script>

    <script type="text/javascript" src="{{PATH_APP}}/directives/convert-to-number/convert-to-number.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/directives/app-directive.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/directives/multiple-upload/multiple-upload.js"></script>

    <script src="{{PATH_APP}}/controllers/studio-image-galleries.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/studio-video-galleries.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/model-edit-gallery.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/model-video-gallery.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/model-image-gallery.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/model-video-upload.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/model-create-gallery.controller.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/controllers/category-manager.controller.js"></script>
    <script type="text/javascript" src="{{PATH_APP}}/controllers/user.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/payment.controller.js"></script>
    <script src="{{PATH_APP}}/controllers/payout/model-request.controller.js"></script>



    <script type="text/javascript" src="{{PATH_LIB}}/jquery/src/admin.js"></script>
     @yield('scripts'))
    
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience -->
    @include('alerts.index')
    <script type="text/javascript">
        $(document).ready(function () {
            $('input.tag-input').tagsinput({});
        });
    </script>
  </body>
</html>
