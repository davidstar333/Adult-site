/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('onlineDatingCtrl', function ($scope, $timeout, appSettings, onlineService, _) {
  $scope.users = [];
  $scope.currentPage = 1;
  $scope.lastPage = 1;
  $scope.perPage = appSettings.LIMIT_PER_PAGE;
  $scope.orderBy = 'isStreaming';
  $scope.sort = 'desc';
  $scope.totalPages = 0;
  $scope._ = _;
  $scope.modelOnlineNull = false;
  $scope.keyword = '';

  $scope.getData = function () {
    onlineService.get({page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, keyword: $scope.keyword}).success(function (data) {
      $scope.users = data.data;
      $scope.currentPage = data.current_page;
      $scope.totalPages = Math.ceil(data.total / data.per_page);
      if (data.total == 0) {
        $scope.modelOnlineNull = true;
      } else {
        $scope.modelOnlineNull = false;
      }
    });
  };
  $scope.setPage = function (page) {
    $scope.lastPage = page;
    $scope.getData();
  };

  $scope.searchInit = function (keyword) {
    $scope.keyword = keyword;
    $scope.getData();
  };
  // Run function every second


  setInterval($scope.getData, 30000);

  $scope.setFavorite = function (index, id) {
    onlineService.setFavorite(id).then(function (data) {
      if (data.data.success) {
        $scope.users[index].favorite = (data.data.favorite == 'like') ? data.data.favorite : null;
      } else {
        alertify.error(data.data.message);
      }
    });
  };
});