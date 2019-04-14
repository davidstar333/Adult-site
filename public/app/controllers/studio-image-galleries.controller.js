/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('studioImageGalleriesCtrl', ["$scope", "galleryService", "mediaService", "appSettings", "earningService", function ($scope, galleryService, mediaService, appSettings, earningService) {

    $scope.currentPage = 1;
    $scope.lastPage = 1;
    $scope.perPage = appSettings.LIMIT_PER_PAGE;
    $scope.orderBy = 'createdAt';
    $scope.sort = 'desc';

    $scope.myGaleries = [];

    $scope.loadMoreInfinite = false;
    $scope.listGalaryInit = function (modelId) {
      $scope.modelId = modelId;
      galleryService.findMyGalleries({page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'image', modelId: $scope.modelId}).success(function (data) {
        $scope.myGalleries = data.data;

        $scope.currentPage = data.current_page;
        if ($scope.lastPage < data.last_page) {
          $scope.lastPage += 1;
          $scope.loadMoreInfinite = true;
        }
      });
    }

    //delete media
    $scope.deleteImageGallery = function (key, id) {
      alertify.confirm('Are you sure you want to delete this?', function () {
        mediaService.deleteFile(id).then(function (data) {
          if (data.data.success) {
            alertify.success(data.data.message);
            $scope.myImages.splice(key, 1);
          } else {
            alertify.error(data.data.error);
          }
        });
      }).set('title', 'Confirm');


    };
    //set image gallery status public or private
    $scope.setGalleryStatus = function (index, status) {
      var galleryId = $scope.myGalleries[index].id;
      galleryService.setGalleryStatus(galleryId, status).then(function (data) {
        if (data.data.success) {
          $scope.myGalleries[index].status = data.data.gallery.status;
          alertify.success(data.data.message);
        } else {
          alertify.error(data.data.message);
        }
      });
    };

    /*
     * delete Gallery
     * @author: Phong Le<pt.hongphong@gmail.com>
     */
    $scope.deleteProcessing = 0;
    $scope.deleteGallery = function (index, id) {
      alertify.confirm('Are you sure you want to delete this?', function () {
        $scope.deleteProcessing = id;
        earningService.countPaidGallery(id, 'image').then(function (data) {
          if (data.data == 0) {

            galleryService.deleteGallery(id).then(function (data) {
              if (data.data.success) {
                alertify.success(data.data.message);
                $scope.myGalleries.splice(index, 1);
              } else {
                alertify.error(data.data.message);
              }
            });
          } else {
            alertify.alert('This is purchase galllery. You can not delete it.');
            $scope.deleteProcessing = 0;
          }
        });

      }).set('title', 'Confirm');


    };
    $(window).scroll(function () {
      if ($(window).scrollTop() == $(document).height() - $(window).height() && $scope.loadMoreInfinite) {
        galleryService.findMyGalleries({page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'image', modelId: $scope.modelId}).success(function (data) {
          $scope.myGalleries = $scope.myGalleries.concat(data.data);
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

  }]);