angular.module('matroshkiApp').controller('ModalInstanceCtrl', function (appSettings, $scope, $uibModalInstance, authService) {

$scope.error = false;
  $scope.login = function (event) {
    if (event.keyCode === 13) {
      $scope.getLogin();
    }
  }

  $scope.getLogin = function () {
    authService.login($scope.data).then((res) => {
      if (res.login) {
        $uibModalInstance.close(res);
      } else {
        $scope.error = true;
      }
    });
  };


  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };
});