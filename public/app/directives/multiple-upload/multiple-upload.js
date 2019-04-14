/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
'use strict';

angular.module('matroshkiApp').directive('multipleUpload', ['appSettings', 'mediaService', function (appSettings, mediaService) {

    return {
      restrict: 'AE',
      template: '<div><input type="hidden" name="myfiles" ng-model="myFiles"><div id="mulitplefileuploader">Upload</div><div id="status"></div></div>',
      require: 'ngModel',
      replace: true,
      scope: {
        files: '=ngModel',
        fileName: '@',
        multiple: '@',
        showDelete: '@',
        showPreview: '@',
        allowedTypes: '@',
        mediaType: '@',
        parentId: '@',
        showDone: '@',
        modelId: '@'
      },
      link: function (scope, elem, attr, ngModel) {
        var myFiles = [];

        if (!ngModel)
          return; // do nothing if no ng-model

        // Specify how UI should be updated
//        ngModel.$render = function () {
//          
//        };

        ngModel.$render = function () {

        };
        var mediaType = (scope.mediaType) ? scope.mediaType : '';
        var parentId = (scope.parentId) ? scope.parentId : null;
        var modelId = (scope.modelId) ? scope.modelId : null;
        var settings = {
          url: appSettings.BASE_URL + 'api/v1/upload-items?mediaType=' + mediaType + '&parent-id=' + parentId + '&model-id=' + modelId,
          method: "POST",
          allowedTypes: scope.allowedTypes,
          fileName: 'myFiles',
          multiple: scope.multiple,
          showDelete: scope.showDelete,
          showPreview: scope.showPreview,
          showDone: scope.showDone,
          statusBarWidth: '100%',
          dragdropWidth: '100%',
          onSuccess: function (files, data, xhr, pd)
          {

            if (data.success == true) {

              myFiles.push(data.file);

              ngModel.$setViewValue(myFiles);
//              alertify.success(files);
//              console.log(pd);
              var uploadName = pd.filename[0].innerHTML;
              alertify.success(uploadName + ' ' + data.message)
//              $("#status").html("<font color='green'>" + data.message + "</font>");
            } else {
//              $("#status").html("<font color='red'>" + data.message + "</font>");
              alertify.error(data.message);
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
                  var index = myFiles.indexOf(element.file.id);
                  myFiles.splice(index, 1);
                  ngModel.$setViewValue(myFiles);
                  alertify.success(data.data.message);
                } else {
                  alertify.error(data.data.message);
                }
              });
            } else if (element.file.type.indexOf('video') != -1) {
              mediaService.deleteVideo(element.file.id).then(function (data) {
                if (data.data.success) {
                  var index = myFiles.indexOf(element.file.id);
                  myFiles.splice(index, 1);
                  ngModel.$setViewValue(myFiles);
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

