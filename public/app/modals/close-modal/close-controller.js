/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


angular.module('matroshkiApp').controller('modalCloseCtrl', ['appSettings', '$scope', '$uibModalInstance', function (appSettings, $scope, $uibModalInstance) {
    $scope.countdown = 5;
    var timeout = setInterval(function () {
      $scope.countdown -= 1;
      $scope.$apply();
      if ($scope.countdown == 0) {
        clearInterval(timeout);
        $uibModalInstance.close();
      }
    }, 1000);


  }]);