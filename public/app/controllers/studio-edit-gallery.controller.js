/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('studioEditGalleryCtrl', function ($scope, galleryService, mediaService) {

  $scope.gallery = {};

  $scope.initEdit = function (gallery) {
    $scope.gallery = {
      id: gallery.id,
      description: gallery.description,
      name: gallery.name,
      price: gallery.price,
      type: gallery.type,
      previewImage: gallery.previewImage,
      status: gallery.status
    };

  };
  if ($('#preview-image-uploader').length > 0) {
    var priviewSetting = {
      url: appSettings.BASE_URL + 'api/v1/upload-items?parent-id=0',
      method: "POST",
      allowedTypes: 'png,jpg,jpeg',
      fileName: 'myFiles',
      multiple: false,
      showDelete: true,
      showPreview: false,
      showDone: true,
      statusBarWidth: '100%',
      dragdropWidth: '100%',
      onSuccess: function (files, data, xhr)
      {

        if (data.success == true) {

          $scope.gallery.previewImage = data.file.id;
          alertify.success(data.message);

        } else {
          alertify.error(data.message);
        }

      },
      onError: function (files, status, errMsg)
      {
        $("#priviewImageStatus").html("<font color='red'>Upload is Failed</font>");
      },
      deleteCallback: function (element, data, pd) {
        mediaService.deleteFile(element.file.id).then(function (data) {
          if (data.data.success) {
            $scope.gallery.priviewImage = null;
            alertify.success(data.data.message);
          }
        });
      }
    };
    $("#preview-image-uploader").uploadFile(priviewSetting);
  }

  $scope.submitUpdateGallery = function (form) {

    if (form.$valid) {
      galleryService.checkExist($scope.gallery).then(function (data) {

        if (data.data.success) {
          alertify.alert(data.data.message);
        } else {
          galleryService.update($scope.gallery).then(function (data) {
            if (data.data.success) {
              alertify.success(data.data.message);
              window.location.href = data.data.url;
            } else {
              alertify.alert(data.data.message).setHeader('Warning');
            }
          });
        }
      });

    }
  };
  

});