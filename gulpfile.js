var elixir = require('laravel-elixir');
require('laralix-jshint');
elixir.config.assetsDir = 'public/css/'; //trailing slash required.

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    'use strict';

    mix.jshint();
//    mix.jshint(['public/app/**/*.js']);
//    mix.sass('app.scss');
    mix.styles([
        'bootstrap.css',
        'flexslider.css',
        'bootstrap-datetimepicker.css',
        'bootstrap-tagsinput.css',
        'style.css',
        'responsive.css'
    ], 'public/assets/css/frontend.css', 'public/css');

    mix.styles([
        'alertifyjs/build/css/alertify.min.css',
        'alertifyjs/build/css/themes/default.min.css',
        'easy/easy-autocomplete.min.css',
        'jquery-multiple-file-upload/uploadfile.css',
        'jquery-emojiarea-master/jquery.emojiarea.css',
        'jquery-emojiarea-master/fontello/css/fontello.css',
        'select2/dist/css/select2.css'
    ], 'public/assets/css/lib.css', 'public/lib');


    mix.copy('public/fonts', 'public/assets/fonts');
    mix.copy('public/lib/moment-timezone/moment-timezone.js', 'public/assets/js/moment-timezone.js');

     mix.babel([
        'angular/angular.min.js',
        'angular-cookies/angular-cookies.min.js',
        'angular-sanitize/angular-sanitize.min.js',
        'angular-bootstrap/ui-bootstrap-tpls.min.js',
        'angular-socket-io/socket.min.js',
        'socketio/socket.io-1.4.5.js'
    ], 'public/assets/js/angular.js', 'public/lib');

    mix.scripts([
        'rtc-multi-connection/RTCMultiConnection.js',
       'alertifyjs/build/alertify.js',
       'moment/min/moment.min.js',
       'moment-timezone/moment-timezone.js',
       'moment-timezone/moment-timezone-utils.js',
       'jquery-multiple-file-upload/jquery.uploadfile.min.js',
       'jssor/js/jssor.slider.min.js',
       'easy/jquery.easy-autocomplete.js',
       'video-js/video.min.js',
       'bootstrap-datetimepicker/bootstrap-datetimepicker.min.js',
        'tag-input/bootstrap-tagsinput.js',
       'jquery-multiple-file-upload/jquery.uploadfile.min.js'
    ], 'public/assets/js/lib.js', 'public/lib');


    mix.babel([
        'adapter.js',
        'app.js',
        'components/common.js',
        'filters/filter.js'
    ], 'public/assets/js/app.js', 'public/app');

    mix.babel([
        'user.service.js',
        'auth.service.js',
        'chat.service.js',
        'socket.service.js',
        'peer.service.js',
        'video-stream.service.js',
        'chat-settings.service.js',
        'likes-widget.service.js',
        'online.service.js',
        'video.service.js',
        'gallery.service.js',
        'schedule.service.js',
        'media.service.js',
        'country.service.js',
        'category.service.js',
        'earning.service.js',
        'payout.service.js',
        'product.service.js',
        'order.service.js'
    ], 'public/assets/js/service.js', 'public/app/services');


    mix.babel([
       'chat-settings.controller.js',
       'stream.controller.js',
       'likes-widget.controller.js',
       'model-profile-image.controller.js',
       'model-video.controller.js',
       'model-profile.controller.js',
       'model-create-gallery.controller.js',
       'model-edit-gallery.controller.js',
       'model-image-gallery.controller.js',
       'model-image-galleries.controller.js',
       'model-video-galleries.controller.js',
       'model-video-gallery.controller.js',
       'model-video-upload.controller.js',
       'model-setting.controller.js',
       'model-schedule.controller.js',
       'model-earning.controller.js'
    ], 'public/assets/js/model.controller.js', 'public/app/controllers');

    mix.babel([
       'chat-settings.controller.js',
       'stream.controller.js',
       'likes-widget.controller.js',
       'model-profile-image.controller.js',
       'model-video.controller.js',
       'model-profile.controller.js',
       'model-create-gallery.controller.js',
       'model-edit-gallery.controller.js',
       'model-image-gallery.controller.js',
       'model-image-galleries.controller.js',
       'model-video-galleries.controller.js',
       'model-video-gallery.controller.js',
       'model-video-upload.controller.js',
       'model-setting.controller.js',
       'model-schedule.controller.js',
       'model-earning.controller.js',
       'ModelOnline.controller.js',
       'media.controller.js',
       'payment.controller.js',
       'payout/model-request.controller.js',
       'model-manage-product.controller.js',
       'product/buy.controller.js',
       'product/order-tracking.controller.js'
    ], 'public/assets/js/controller.js', 'public/app/controllers');

    mix.babel([
       'app-directive.js',
       'stream-video-player.directive.js',
       'convert-to-number/convert-to-number.js',
       'chat-text.directive.js',
       'private-chat-video.directive.js',
       'group-chat-video.directive.js',
       'upload-file/upload-file.js',
       'multiple-upload/multiple-upload.js',
       'check-user-online.directive.js'
    ], 'public/assets/js/directive.js', 'public/app/directives');

    mix.babel([
        'register-modal/register-modal-controller.js',
        'transaction/transaction-popup-controller.js',
        'model-multiple-upload/model-multiple-upload-modal-controller.js'
    ], 'public/assets/js/modal.js', 'public/app/modals');
});
