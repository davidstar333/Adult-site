/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('modelVideoGalleryCtrl', ["$scope", "mediaService", "appSettings", "$uibModal", "earningService", "videoService", function ($scope, mediaService, appSettings, $uibModal, earningService, videoService) {

    $scope.currentPage = 1;
    $scope.lastPage = 1;
    $scope.perPage = appSettings.LIMIT_PER_PAGE;
    $scope.orderBy = 'createdAt';
    $scope.sort = 'desc';

    $scope.myVideos = [];

    $scope.loadMoreInfinite = false;
    $scope.galleryInit = function (id, modelId) {
      $scope.galleryId = id;
      const options = {
        page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'video' 
      };
      if(modelId) {
        options.modelId = modelId;
      }
      if(id) {
        options.galleryId = id;
      }
      mediaService.findMyVideoGallery(options).success(function (data) {
        $scope.myVideos = data.data;
        $scope.currentPage = data.current_page;
        if ($scope.lastPage < data.last_page) {
          $scope.lastPage += 1;
          $scope.loadMoreInfinite = true;
        }
      });
    };

    $scope.showUploadModal = function (size) {
      var modalInstance = $uibModal.open({
        animation: true,
        templateUrl: appSettings.BASE_URL + 'app/modals/model-multiple-upload/multiple-upload.html?v=' + Math.random().toString(36).slice(2),
        controller: 'ModalUploadInstanceCtrl',
        size: size,
        backdrop: 'static',
        keyboard: false,
        resolve: {
          type: function () {
            return 'video';
          },
          mediaType: function () {
            return 'video';
          },
          parentId: function () {
            return $scope.galleryId;
          }
        }

      });
      modalInstance.result.then(function (data) {
        for (var i in data) {
          $scope.myVideos.push(data[i]);
        }
      });
    };

    //delete media
    $scope.deleteVideoGallery = function (key, id) {
      alertify.confirm('Are you sure you want to delete this?', function () {
        earningService.countPaidItem(id, 'video').then(function (data) {
          if (data.data == 0) {
            mediaService.deleteVideo(id).then(function (data) {
              if (data.data.success) {
                alertify.success(data.data.message);
                $scope.myVideos.splice(key, 1);
              } else {
                alertify.error(data.data.error);
              }
            });
          } else {
            alertify.alert('This is a purchase video. You can not delete it.');
          }
        });

      }).set('title', 'Confirm');


    };
    //show video popup
    $scope.showVideoDetail = function (id, size) {
      
      var modalInstance = $uibModal.open({
        animation: true,
        templateUrl: appSettings.BASE_URL + 'app/modals/video/modal.html',
        controller: 'videoPopupCtrl',
        size: size,
        keyboard: false,
        resolve: {
          id: function () {
            return id;
          }
        }

      });
      modalInstance.result.then(function (data) {
//        window.location.reload();
//        $('#account-status-' + id).text(data.accountStatus);
console.log(data);
      });
    };

//set image status active or inactive
    $scope.setVideoStatus = function (index, status) {
      if (status == 'processing') {
        return;
      }
      var videoId = $scope.myVideos[index].id;
      videoService.setVideoStatus(videoId, status).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
          $scope.myVideos[index].status = data.data.status;
        } else {
          alertify.error(data.data.message);
        }

      });
    };

    $(window).scroll(function () {
      if ($(window).scrollTop() == $(document).height() - $(window).height() && $scope.loadMoreInfinite) {
        const options = {page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'video', galleryId: $scope.galleryId};
        if($scope.galleryId) {
          options.galleryId = $scope.galleryId;
        }
        mediaService.findMyVideoGallery().success(function (data) {

          $scope.myVideos = $scope.myVideos.concat(data.data);
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