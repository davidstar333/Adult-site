'use strict';
angular.module('matroshkiApp')
.controller('modelAddProductCtrl', function ($scope, $, mediaService, appSettings) {
  if ($('#video-poster-uploader').length > 0) {
    var posterSettings = {
      url: appSettings.BASE_URL + 'api/v1/upload-items?mediaType=poster&parent-id=0',
      method: "POST",
      allowedTypes: 'png,jpg,jpeg',
      fileName: 'myFiles',
      multiple: false,
      showDelete: true,
      showPreview: false,
      showDone: true,
      statusBarWidth: '100%',
      dragdropWidth: '100%',
      onSuccess: function (files, data) {
        if (data.success) {
          const productImage = $('.product-image .img-responsive');
          if(productImage.prop('tagName') !== 'undefined'){
            productImage.prop('src', '/'+data.file.path);
          }
          $('#image-id').val(data.file.id);
          alertify.success(data.message);
          $scope.uploadStatus = '';
        } else {
          $scope.uploadStatus = "<font color='red'>"+data.message+"</font>";
        }
      },
      onError: function (files, status, errMsg) {
        $("#poster-status").html("<font color='red'>Upload is Failed</font>");
        $scope.uploadStatus = "<font color='red'>Upload failed</font>";
      },
      deleteCallback: function (element, data, pd) {
        mediaService.deleteImage(element.file.id).then(function (data) {
          if (data.data.success) {
            $('#image-id').val('');
            alertify.success(data.data.message);
          }
        });
      }
    };
    $("#video-poster-uploader").uploadFile(posterSettings);
  }

  $scope.submit = function(form) {
    //TODO - validate me
    $('#add-product-frm').submit();
  };
});