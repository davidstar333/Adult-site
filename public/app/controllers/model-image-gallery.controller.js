/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('modelImageGalleryCtrl', function ($scope, galleryService, mediaService, appSettings, $uibModal, earningService) {

  $scope.currentPage = 1;
  $scope.lastPage = 1;
  $scope.perPage = appSettings.LIMIT_PER_PAGE;
  $scope.orderBy = 'createdAt';
  $scope.sort = 'desc';

  $scope.myImages = [];

  $scope.loadMoreInfinite = false;
  $scope.galleryInit = function (id) {
    $scope.pageLoadSuccess = false;
    $scope.galleryId = id;
    mediaService.findMyMediaGallery({page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'image', galleryId: id}).success(function (data) {
      $scope.myImages = data.data;
      $scope.pageLoadSuccess = true;
      $scope.currentPage = data.current_page;
      if ($scope.lastPage < data.last_page) {
        $scope.lastPage += 1;
        $scope.loadMoreInfinite = true;
      }
    });
  };

  $scope.showUploadModal = function (modelId, size) {
    var modalInstance = $uibModal.open({
      animation: true,
      templateUrl: appSettings.BASE_URL + 'app/modals/model-multiple-upload/multiple-upload.html?v=' + Math.random().toString(36).slice(2),
      controller: 'ModalUploadInstanceCtrl',
      size: size,
      backdrop: 'static',
      keyboard: false,
      resolve: {
        type: function () {
          return 'image';
        },
        mediaType: function () {
          return 'image';
        },
        parentId: function () {
          return $scope.galleryId;
        },
        modelId: function (){
          return modelId
        }
      }

    });
    modalInstance.result.then(function (data) {
      for (var i in data) {

        $scope.myImages.push(data[i]);
      }
    });
  };
  $scope.setMainImage = function (index, id) {
    mediaService.setMainImage(id).then(function (data) {
      if (data.data.success) {
        alertify.success(data.data.message);
        window.location.reload();
      } else {
        alertify.error(data.data.error);
      }
    });
  };
  //delete media
  $scope.deleteImageGallery = function (key, id) {
    alertify.confirm('Are you sure you want to delete this?', function () {
      earningService.countPaidItem(id, 'image').then(function (data) {
        if (data.data == 0) {
          mediaService.deleteImage(id).then(function (data) {
            if (data.data.success) {
              alertify.success(data.data.message);
              $scope.myImages.splice(key, 1);
            } else {
              alertify.error(data.data.error);
            }
          });
        } else {
          alertify.alert('This is a purchase image. You can not delete it.');
        }
      });

    }).set('title', 'Confirm');


  };
  //set image status active or inactive
  $scope.setMediaStatus = function (index, status) {
    if (status == 'processing') {
      return;
    }
    var imageId = $scope.myImages[index].id;
    mediaService.setMediaStatus(imageId, status).then(function (data) {
      if (data.data.success) {
        alertify.success(data.data.message);
        $scope.myImages[index].status = data.data.status;
      } else {
        alertify.error(data.data.message);
      }

    });
  };

  $(window).scroll(function () {
    if ($(window).scrollTop() == $(document).height() - $(window).height() && $scope.loadMoreInfinite) {
      mediaService.findMyMediaGallery({page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'image', galleryId: $scope.galleryId}).success(function (data) {
        $scope.myImages = $scope.myImages.concat(data.data);
        $scope.currentPage = data.current_page;
        if ($scope.lastPage < data.last_page) {
          $scope.lastPage += 1;
          $scope.loadMoreInfinite = true;
        } else {
          $scope.loadMoreInfinite = false;
        }
      });
    }
  });

});