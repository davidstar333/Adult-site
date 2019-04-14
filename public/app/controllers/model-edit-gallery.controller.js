/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('modelEditGalleryCtrl', function ($scope, galleryService, mediaService) {

  $scope.gallery = {};
  $scope.attachmentId = '';
  $scope.initEdit = function (gallery, attachmentId) {
    $scope.gallery = {
      id: gallery.id,
      description: gallery.description,
      name: gallery.name,
      price: parseInt(gallery.price),
      type: gallery.type,
      previewImage: gallery.previewImage,
      status: gallery.status,
      mediaMeta: gallery.mediaMeta
    };
    $scope.attachmentId = attachmentId;
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
          $('#previewImg').attr('src', appSettings.BASE_URL + data.file.path);
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

  $scope.errors = {};
  $scope.submitUpdateGallery = function (form) {

    if (form.$valid) {

          galleryService.update($scope.gallery).then(function (data) {
            if (data.data.success) {
                $scope.errors = {};
              alertify.success(data.data.message);
              if (data.data.errors != '') {
                alertify.warning(data.data.errors);
              } else {
                window.location.href = data.data.url;
              }
            } else {
                $scope.errors = data.data.errors;
                if(data.data.message){
                    alertify.alert(data.data.message).setHeader('Warning');
                }
            }
          });
        

    }
  };

  $scope.submitUpdateImage = function(form, modelId) {
     if (form.$valid) {
      var idModel = appSettings.USER.id;
      if(modelId){
        idModel = modelId;
      }
      return galleryService.update($scope.gallery).then(function (data) {
        if (data.data.success) {
          // if upload new image
          if($('#fileInputImage')[0].files.length) {
            var formData = new FormData();
            formData.append('myFiles', $('#fileInputImage')[0].files[0]); 
            return $.ajax({
              url: appSettings.BASE_URL + 'api/v1/upload-items?mediaType=image&parent-id='+$scope.gallery.id+'&model-id=' + idModel,
              data: formData,
              type: 'POST',
              contentType: false,
              processData: false
            })
            .then(function(dataFile){
              return mediaService.setMainImage(dataFile.file.id)
              .then(function(){
                return mediaService.setMediaStatus(dataFile.file.id, 'inactive');
              })
              .then(function(){
                // remove the old image
                return mediaService.deleteImage($scope.attachmentId);
              })
              .then(function(){
                $scope.errors = {};
                alertify.success('Update successfully');
                if(modelId){
                  return window.location.href = '/admin/manager/image-gallery/'+modelId;   
                }else {
                  return window.location.href = '/models/dashboard/media/image-galleries';   
                }
              });
            })
          }else {
            $scope.errors = {};
            alertify.success('Update successfully');
            if(modelId){
              return window.location.href = '/admin/manager/image-gallery/'+modelId;   
            }else {
              window.location.href = '/models/dashboard/media/image-galleries'; 
            }
          }
        } else {
            $scope.errors = data.data.errors;
            if(data.data.message){
                alertify.alert(data.data.message).setHeader('Warning');
            }
        }
      });
    }
  };

});