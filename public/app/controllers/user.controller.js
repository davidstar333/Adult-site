/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('userCtrl', ['$scope', '$uibModal', 'appSettings', 'userService', function ($scope, $uibModal, appSettings, userService) {

    //suspend account
    $scope.showSuspendReason = function (id, reason, size) {
      alertify.alert('Suspend Reason', reason);
    };
    $scope.setAccountStatus = function (id, size) {
      var modalInstance = $uibModal.open({
        animation: true,
        templateUrl: appSettings.BASE_URL + 'app/modals/modalStatus/modal.html',
        controller: 'ModalInstanceCtrl',
        size: size,
        backdrop: 'static',
        keyboard: false,
        resolve: {
          id: function () {
            return id;
          }
        }

      });
      modalInstance.result.then(function (data) {
//        window.location.reload();
        $('#account-status-' + id).text(data.accountStatus);
      });
//  
    };
    $scope.confirmDelete = function (id) {
      alertify.confirm('Are you sure you want to delete this member?',
              function () {
                return window.location.href = appSettings.BASE_URL + 'admin/manager/user/delete/' + id;
              }).set('title', 'Confirm');
    };
    $scope.showDocument = function (id, size) {
      var documentModel = $uibModal.open({
        animation: true,
        templateUrl: appSettings.BASE_URL + 'app/modals/document/modal.html',
        controller: 'documentModalCtrl',
        size: size,
        backdrop: 'static',
        keyboard: false,
        resolve: {
          id: function () {
            return id;
          }
        }

      });
      documentModel.result.then(function (data) {
//        window.location.reload();
      });
    };
    //apply user to admin
    $scope.addToAdmin = function (id){
      userService.changeAccountRole(id, 'admin').then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
          window.location.reload();
        } else  {
          if(data.data.error){
            alertify.error(data.data.error);
          }else{
            alertify.error('System error.');
          }
        }
      });
    };
  }]);