'use strict';

angular.module('matroshkiApp').controller('orderTrackingCtrl', [
  '$scope', 'orderService', function ($scope, orderService) {
    $scope.comments = [];

    $scope.init = function(data) {
      $scope.order = data;
      $scope.shippingStatus = data.shippingStatus;
      $scope.updatedShippingStatus = data.shippingStatus;
      $scope.note = data.note;
      $scope.status = data.status || 'open';

      orderService.getComments(data.id)
        .then(function(resp) {
          $scope.comments = resp.data;
        });
    };

    $scope.updateStatus = function() {
      orderService.update($scope.order.id, {
        shippingStatus: $scope.shippingStatus,
        note: $scope.note,
        status: $scope.status
      })
      .then(function(data) {
        $scope.updatedShippingStatus = $scope.shippingStatus;
        return alertify.success('Update order successfully.');
      });
    };

    $scope.comment = function() {
      orderService.addComment($scope.order.id, {
        text: $scope.newComment
      })
      .then(function(resp) {
        $scope.comments.push(resp.data);
        $scope.newComment = '';
      });
    };
  }
]);