'use strict';
angular.module('matroshkiApp').controller('mediaCtrl', ['$scope', 'appSettings', 'videoService', 'galleryService', 'mediaService', function ($scope, appSettings, videoService, galleryService, mediaService) {
    $scope.currentTab = 0;
    $scope.currentPage = 1;
    $scope.lastPage = 1;
    
    $scope.setTab = function (index) {
      $scope.currentTab = index;
      $scope.currentPage = 1;
      $scope.lastPage = 1;
      $scope.getMedia(index, 1);
    };

//init data
    $scope.init = function (model) {
      $scope.modelId = model;
    };
    $scope.getMedia = function (index, page) {
      if (index == 1) {
        videoService.getModelVideos($scope.modelId, page).success(function (data) {
          $scope.videos = data.data;
          $scope.currentPage = data.current_page;
          $scope.lastPage = data.last_page;
        });
      } else if (index == 2) {
        galleryService.getModelGalleries($scope.modelId, page).success(function (data) {
          
          $scope.galleries = data.data;
          $scope.currentPage = data.current_page;
          $scope.lastPage = data.last_page;
        });
      }
    };
    $scope.changePage = function (status){
      if(status == 0){
          var page = ($scope.currentPage > 1) ? parseInt($scope.currentPage - 1) : 1;
          $scope.getMedia($scope.currentTab, page);
      }else{
          console.log($scope.currentPage, $scope.lastPage);
          var page = ($scope.currentPage < $scope.lastPage) ? parseInt($scope.currentPage + 1) : $scope.lastPage;
          $scope.getMedia($scope.currentTab, page);
      }
    };
    //check owner
    $scope.checkOwner = function (item, url) {
      
      mediaService.checkOwner({id: item.id}).then(function (data) {
        if (!data.data.success) {
          return alertify.alert(data.data.message);
        } else {
          if (data.data.owner > 0) {

            window.location.href = url + '/' + item.id;
          } else {
            alertify.confirm("Are you sure you want to buy this ( "+item.galleryPrice+" tokens)?", function (e) {
              if (e) {
                $.ajax({
                  url: appSettings.BASE_URL + 'api/v1/buy-item',
                  type: 'post',
                  data: {
                    id: item.id,
                    item: item.type
                  },
                  success: function (data) {
                    if (!data.success) {
                      alertify.alert('Warning', data.message);
                    } else {
                      alertify.success(data.message);
                      window.location.href = data.url;
                    }
                  }
                });
              }
            }).setHeader('<em> Confirm </em> ');
          }
        }
      });
    };
  }]);