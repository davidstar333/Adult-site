'use strict';
if (typeof PerformerChat === undefined) {
  var PerformerChat = {};
}

angular.module('matroshkiApp', [
  'ngCookies',
  'ngSanitize',
  'ui.bootstrap',
  'btford.socket-io',
//  'ngTagsInput',
//  'ngCkeditor'
//  'ui.tinymce',
  'angularLazyImg'
], function ($interpolateProvider) {
  $interpolateProvider.startSymbol('<%');
  $interpolateProvider.endSymbol('%>');
})
.constant('appSettings', window.appSettings)
.constant('PerformerChat', PerformerChat)
.value('_', _)
.value('$', $);
