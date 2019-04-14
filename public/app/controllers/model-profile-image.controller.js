/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('modelProfileImageCtrl', function ($scope, $uibModal, appSettings, mediaService, userService) {

  $scope.currentPage = 1;
  var lastPage = 1;
  $scope.perPage = appSettings.LIMIT_PER_PAGE;
  $scope.orderBy = 'createdAt';
  $scope.sort = 'desc';

  $scope.myImages = [];

  $scope.loadMoreInfinite = false;

  mediaService.findProfileByMe({page: lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'image', mediaType: 'profile'}).success(function (data) {
    $scope.myImages = data.data;
    $scope.currentPage = data.current_page;
    if (lastPage < data.last_page) {
      lastPage = lastPage + 1;
      $scope.loadMoreInfinite = true;
    }
  });

//make profile
  $scope.makeProfile = function (index, id) {
    userService.setProfile(id).then(function (data) {
      if (data.data.success) {
        alertify.success(data.data.message);
        window.location.reload();
      }
    });
  };
  //delete image
  $scope.deleteModelImage = function (key, id) {
    alertify.confirm('Are you sure you want to delete this?', function () {
      mediaService.deleteImage(id).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
          $scope.myImages.splice(key, 1);
        } else {
          alertify.error(data.data.error);
        }
      });
    }).set('title', 'Confirm');


  };
//load more
  $(window).scroll(function () {
    if ($(window).scrollTop() == $(document).height() - $(window).height() && $scope.loadMoreInfinite) {
      mediaService.findProfileByMe({page: lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'image', mediaType: 'profile'}).success(function (data) {
        lastPage = lastPage + 1;


        $scope.myImages = $scope.myImages.concat(data.data);



        if (lastPage > data.last_page) {

          $scope.loadMoreInfinite = false;
        }
      });
    }
  });
  ///call upload model

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
          return 'image';
        },
        mediaType: function () {
          return 'profile';
        },
        parentId: function () {
          return 0;
        },
        modelId: function () {
          return appSettings.USER.id;
        }
      }

    });
    modalInstance.result.then(function (data) {
      for (var i in data) {
        $scope.myImages.push(data[i]);
      }
    });
  };
});