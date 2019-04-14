angular.module('matroshkiApp').controller('ModalUploadInstanceCtrl', function (appSettings, $scope, $uibModalInstance, type, mediaType, parentId, modelId) {

  $scope.error = false;
  $scope.myfiles = [];
  $scope.allowedTypes = 'jpg,png,gif,jpeg';
  $scope.modalTitle = 'Upload Images';
  $scope.parentId = (parentId) ? parentId : 0;
  $scope.mediaType = mediaType;
  $scope.modelId = (modelId) ? modelId : null;

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