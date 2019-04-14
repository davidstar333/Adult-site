'use strict';

angular.module('matroshkiApp').controller('buyProductCtrl', [
  '$scope', 'productService', function ($scope, productService) {
    $scope.quantity = 1;

    $scope.buy = function(product) {
      if (!$scope.quantity || $scope.quantity < 0) {
        return alertify.error('Invalid quantity');
      }

      if ($scope.quantity > product.inStock) {
        return alertify.error('Invalid quantity');
      }

      if (!window.appSettings.USER) {
        return alertify.error('Please login.');
      }

      productService.buy(product.id, { quantity: $scope.quantity })
      .then(function(data) {
        if (!data.success) {
          return alertify.error(data.data.message);
        }

        alertify.success('Buy product successfully.');
      });
    };
  }
]);