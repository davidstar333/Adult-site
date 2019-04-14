/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
'use strict';

angular.module('matroshkiApp').directive('wysiwygEditor', ['appSettings', function (appSettings) {
    return {
      restrict: 'A',
      scope: {
        'ngModel': '=?'
      },
      require: '?ngModel',
//      templateUrl: appSettings.BASE_URL + 'app/views/partials/editor.html',
      link: function (scope, elem, attr, ngModel) {

        if (CKEDITOR.env.ie && CKEDITOR.env.version < 9)
          CKEDITOR.tools.enableHtml5Elements(document);

// The trick to keep the editor in the sample quite small
// unless user specified own height.
        CKEDITOR.config.height = 150;
        CKEDITOR.config.width = 'auto';
        CKEDITOR.config.extraPlugins = 'wordcount';
        // Depending on the wysiwygare plugin availability initialize classic or inline editor.
        CKEDITOR.config.wordcount = {
          // Whether or not you want to show the Char Count
//          maxWordCount: 100,
          maxCharCount: attr.maxlength,
          showCharCount: true
        };
        var editor = CKEDITOR.replace(attr.id);

        // The "change" event is fired whenever a change is made in the editor.


        editor.on('change', function (evt) {
          // getData() returns CKEditor's HTML content.

          ngModel.$setViewValue(evt.editor.getData());
        });



      }
    };
  }]);

