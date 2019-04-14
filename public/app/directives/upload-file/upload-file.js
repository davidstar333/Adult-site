/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
'use strict';

angular.module('matroshkiApp').directive('uploadFile', ['appSettings', 'mediaService', function (appSettings, mediaService) {

    return {
      restrict: 'AE',
      template: '<div><input type="hidden" name="myFiles" ng-model="myFiles"><div id="mulitplefileuploader">Upload</div><div id="status"></div></div>',
      require: 'ngModel',
      replace: true,
      scope: {
        myfiles: '=ngModel',
        fileName: '@',
        multiple: '@',
        showDelete: '@',
        showPreview: '@',
        allowedTypes: '@',
        mediaType: '@',
        parentId: '@',
        showDone: '@'
      },
//      templateUrl: appSettings.BASE_URL + 'app/views/partials/editor.html',
      link: function (scope, elem, attr, ngModel) {
        var current = [];
//        scope.myPhotos = ngModelCtrl;
        if (!ngModel)
          return; // do nothing if no ng-model

        // Specify how UI should be updated
//        ngModel.$render = function () {
//          
//        };
        ngModel.$render = function () {
//          elem.html(ngModel.$viewValue || '');
        };
        var mediaType = (scope.mediaType) ? scope.mediaType : '';
        var parentId = (scope.parentId) ? scope.parentId : 0;
        var settings = {
          url: appSettings.BASE_URL + 'api/v1/upload-items?parent-id='+parentId+'&mediaType='+mediaType,
          method: "POST",
          allowedTypes: "jpg,png,gif,jpeg,mp4,m4v,ogg,ogv,webm",
          fileName: "myFiles",
          multiple: true,
          showDelete: true,
          showPreview: false,
          showDone: true,
          statusBarWidth: '55%',
          dragdropWidth: '55%',
          onSuccess: function (files, data, xhr)
          {

            if (data.success == true) {
//              ngModelCtrl.$viewValue = data.fileName;
//              scope.$apply(function () {
//                ngModelCtrl.$setViewValue(data.fileName);
//                ngModelCtrl.$setViewValue('StackOverflow');
//              });
//              scope.$watch('myPhotos', function (value) {
//                if (ngModelCtrl.$viewValue != value) {
//                  ngModelCtrl.$setViewValue(data.fileName);
//                  
//                }
//              });


              current.push(data.file.id);
              ngModel.$setViewValue(current);

              $("#status").html("<font color='green'>" + data.message + "</font>");
            } else {
              $("#status").html("<font color='red'>" + data.message + "</font>");
            }

          },
          onError: function (files, status, errMsg)
          {
            $("#status").html("<font color='red'>Upload is Failed</font>");
          },
          deleteCallback: function (element, data, pd) {

            if (element.file.type.indexOf('image') != -1) {
              mediaService.deleteImage(element.file.id).then(function (data) {
                if (data.data.success) {
                  var index = current.indexOf(element.file.id);
                  current.splice(index, 1);
                  ngModel.$setViewValue(current);
                  alertify.success(data.data.message);
                } else {
                  alertify.error(data.data.message);
                }
              });
            } else if (element.file.type.indexOf('video') != -1) {
              mediaService.deleteVideo(element.file.id).then(function (data) {
                if (data.data.success) {
                  var index = current.indexOf(element.file.id);
                  current.splice(index, 1);
                  ngModel.$setViewValue(current);
                  alertify.success(data.data.message);
                } else {
                  alertify.error(data.data.message);
                }
              });
            }
          }
        };
        $("#mulitplefileuploader").uploadFile(settings);

      }


    };
  }]);

