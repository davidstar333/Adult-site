'use strict';

angular.module('matroshkiApp').controller('RegisterInstanceCtrl', function (appSettings, $scope, $uibModalInstance, authService) {

  $scope.errors = {};
  $scope.user = {};
  $scope.welcomeImage = appSettings.registerImage;

  $scope.formSubmitted = false;
  $scope.createFreeAccount = function (form) {
    $scope.errors = {};
    if (!form.$valid) {
      return false;
    }
    $scope.formSubmitted = true;

    authService.createUser($scope.user, function (data) {

      if (data.success) {

        alertify.success(data.message);
        sessionStorage.closePopup = true;
        $uibModalInstance.close(data);
      } else {
        $scope.formSubmitted = false;
        if (data.errors) {
          $scope.errors = data.errors;
        }
        //        alertify.error(data.message);
      }
    }, function (err) {});
  };

  $scope.cancel = function () {
    sessionStorage.closePopup = true;
    $uibModalInstance.dismiss('cancel');
  };
});
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('matroshkiApp').controller('transactionPopupCtrl', ['appSettings', '$scope', '$uibModalInstance', 'transaction', 'paymentService', function (appSettings, $scope, $uibModalInstance, transaction, paymentService) {

  paymentService.getDetail(transaction).then(function (data) {
    if (data.data.success) {

      $scope.bodyContent = '';
      $scope.transaction = JSON.parse(data.data.data.parameters);
      $.getJSON('/lib/moment-timezone/data/packed/latest.json').then(function (data) {
        moment.tz.load(data);
        var format = moment($scope.transaction.start_date);

        if (appSettings.TIMEZONE) {
          format = format.tz(appSettings.TIMEZONE);
        }
        var date = moment(format._d);
        $scope.transaction.start_date = date.format('YYYY-MM-DD HH:mm a');
      });
    }
  });
  $scope.close = function () {
    $uibModalInstance.close();
  };
}]);
angular.module('matroshkiApp').controller('ModalUploadInstanceCtrl', function (appSettings, $scope, $uibModalInstance, type, mediaType, parentId, modelId) {

  $scope.error = false;
  $scope.myfiles = [];
  $scope.allowedTypes = 'jpg,png,gif,jpeg';
  $scope.modalTitle = 'Upload Images';
  $scope.parentId = parentId ? parentId : 0;
  $scope.mediaType = mediaType;
  $scope.modelId = modelId ? modelId : null;

  if (type == 'video') {
    $scope.modalTitle = 'Upload Videos';
    $scope.allowedTypes = 'mp4,m4v,ogg,ogv,webm';
  }
  $scope.closeUpload = function () {
    $uibModalInstance.close($scope.myfiles);
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };
});
//# sourceMappingURL=modal.js.map
