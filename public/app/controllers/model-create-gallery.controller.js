/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('modelCreateGalleryCtrl', function ($scope, galleryService, appSettings, mediaService) {

  $scope.gallery = {
    name: '',
    description: '',
    price: 100,
    type: '',
    status: 'public'
  };


  $scope.submitted = false;
  $scope.errors = {};
  
  $scope.submitCreateGallery = function (form) {
    if (form.$valid) {
      $scope.submitted = true;
      galleryService.create($scope.gallery).then(function (data) {
        if (data.data.success) {
            $scope.errors = {};
          alertify.success(data.data.message);
          window.location.href = data.data.url;
        } else {
          $scope.submitted = false;
          $scope.errors = data.data.errors;
          if(data.data.message){
                alertify.alert(data.data.message).setHeader('Warning');
            }
        }
      });
    }
  };
  $scope.submitCreateImage = function (form, modelId) {
    $scope.errors = {};
    if(!$('#fileInputImage')[0].files.length) {
      $scope.errors.image = 'Please select an image';
      return false;
    }
    if (form.$valid) {
      $scope.submitted = true;
      var idModel = appSettings.USER.id;
      if(modelId) {
        $scope.gallery.model_id = modelId;
        idModel = modelId;
      }
      return galleryService.create($scope.gallery)
      .then(function (data) {
        if (data.data.success) {
          var formData = new FormData();
          formData.append('myFiles', $('#fileInputImage')[0].files[0]); 
          return $.ajax({
            url: appSettings.BASE_URL + 'api/v1/upload-items?mediaType=image&parent-id='+data.data.id+'&model-id=' + idModel,
            data: formData,
            type: 'POST',
            contentType: false,
            processData: false
          });
        } else {
          return Promise.reject({
            errors: data.data.errors,
            message: data.data.message
          });
        }
      })
      .then(function(dataFile){
        return mediaService.setMainImage(dataFile.file.id).then(function(){
          return Promise.resolve(dataFile);
        });
      })
      .then(function(dataFile){
        return mediaService.setMediaStatus(dataFile.file.id, 'inactive');
      })
      .then(function(){
        $scope.errors = {};
        alertify.success('Create successfully');
        if(!modelId) {
          window.location.href = '/models/dashboard/media/image-galleries'; 
        }else {
          window.location.href = '/admin/manager/image-gallery/'+modelId; 
        }
      })
      .catch(function(err){
        $scope.submitted = false;
        $scope.errors = err.errors;
        alertify.alert(err.message).setHeader('Warning');
      });
    }
    
  };

});