angular.module('matroshkiApp').controller('ModalInstanceCtrl', function (appSettings, $scope, $uibModalInstance, userService, $sce, id) {

  $scope.bodyText = '';
  $scope.user = {};
  userService.findById(id).then(function (data) {
    if (data.data.success) {
      $scope.user = data.data.user;
      if (data.data.user.accountStatus == 'suspend') {
        $scope.bodyText = 'Suspend reason: ' + $sce.trustAsHtml(data.data.user.suspendReason);
      } else {
        $scope.bodyText = 'Change account Status';
      }
    } else {
      alertify.alert('Warning', data.data.message);
    }
  });
  $scope.changeAccountStatus = function (status) {
    userService.changeAccountStatus(id, status).then(function (data) {
      if (data.data.success) {
        $scope.user = data.data.user;
        alertify.success(data.data.message);
        $uibModalInstance.close($scope.user);

      } else {
        alertify.error(data.data.error);
      }
    });
  };

  $scope.close = function () {
    $uibModalInstance.close($scope.user);
  };
});