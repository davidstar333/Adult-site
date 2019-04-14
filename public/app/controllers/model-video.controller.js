/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('modelVideoCtrl', function ($scope, $uibModal, appSettings, mediaService, userService) {

  $scope.currentPage = 1;
  var lastPage = 1;
  $scope.perPage = appSettings.LIMIT_PER_PAGE;
  $scope.orderBy = 'createdAt';
  $scope.sort = 'desc';

  $scope.myVideos = [];

  $scope.loadMoreInfinite = false;

  mediaService.findByMe({page: lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'video'}).success(function (data) {
    $scope.myVideos = data.data;
    $scope.currentPage = data.current_page;
    if (lastPage < data.last_page) {
      lastPage = lastPage + 1;
      $scope.loadMoreInfinite = true;
    }
  });

  //delete image
  $scope.deleteModelImage = function (key, id) {
    alertify.confirm('Are you sure you want to delete this?', function () {
      mediaService.deleteFile(id).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
          $scope.myVideos.splice(key, 1);
        } else {
          alertify.error(data.data.error);
        }
      });
    }).set('title', 'Confirm');


  };
//load more
  $scope.loadMoreImages = function () {

    if ($scope.loadMoreInfinite == true) {
      mediaService.findByMe({page: lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'video'}).success(function (data) {
        lastPage = lastPage + 1;


        $scope.myVideos = $scope.myVideos.concat(data.data);



        if (lastPage > data.last_page) {

          $scope.loadMoreInfinite = false;
        }
      });
    }
  };
  ///call upload model

  $scope.showUploadModal = function (size) {
    var modalInstance = $uibModal.open({
      animation: true,
      templateUrl: appSettings.BASE_URL + 'app/modals/model-upload-images/upload-images.html?v=' + Math.random().toString(36).slice(2),
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
        }
      }

    });
    modalInstance.result.then(function (data) {
      for (var i in data) {
        $scope.myVideos.push(data[i]);
      }
    });
  };
});