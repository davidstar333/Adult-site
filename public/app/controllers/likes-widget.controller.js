/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('likesWidgetCtrl', [ '$scope', 'appSettings', 'likesWidgetService', function ($scope, appSettings, likesWidgetService) {

  $scope.init = function (itemId, item)
  {
    $scope.itemId = itemId;
    $scope.item = item;
    likesWidgetService.count({itemId: $scope.itemId, item: $scope.item}).success(function (data, status, headers, config) {
      $scope.totalLikes = data;
    });
    //check like status
    likesWidgetService.checkMe({itemId: $scope.itemId, item: $scope.item}).success(function (data, status, headers, config) {
      $scope.liked = data;
    });
  };

  $scope.likeThis = function () {
    likesWidgetService.likeMe({itemId: $scope.itemId, status: $scope.liked, item: $scope.item}).then(function (data, status, headers, config) {
      if (data.data.status == 'error') {
        alertify.warning(data.data.message);
        return;
      }
      $scope.liked = (data.data.status == 'like') ? 1 : 0;
      likesWidgetService.count({itemId: $scope.itemId, item: $scope.item}).success(function (data, status, headers, config) {
        $scope.totalLikes = data;
      });
    });
  };

}]);