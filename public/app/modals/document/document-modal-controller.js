/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


angular.module('matroshkiApp').controller('documentModalCtrl', ['appSettings', '$scope', '$uibModalInstance', 'documentService', 'id', function (appSettings, $scope, $uibModalInstance, documentSerivce, id) {

    documentSerivce.findDocument(id).success(function (data) {
      if (data.success) {
        if (data.document) {
          $scope.document = data.document;
        } else {
          $scope.message = 'Document not exist.';
        }
      } else {
        alertify.error(data.message);
      }
    });
    $scope.close = function () {
      $uibModalInstance.close();
    };
  }]);