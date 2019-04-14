/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('paymentCtrl', ['$scope', '$uibModal', 'appSettings', function ($scope, $uibModal, appSettings) {

//Reject transaction
    $scope.rejectTransaction = function (id) {
      alertify.confirm('Are you sure you want to reject this transaction? Please refund member money first.',
              function () {
                return window.location.href = appSettings.BASE_URL + 'admin/manager/transaction/reject/' + id;
              }).set('title', 'Confirm');
    }
    //Approve transaction
    $scope.approveTransaction = function (id) {
      alertify.confirm('Are you sure you want to approve this transaction?',
              function () {
                return window.location.href = appSettings.BASE_URL + 'admin/manager/transaction/approve/' + id;
              }).set('title', 'Confirm');
    }
    //transaction detail

    $scope.showTransactionDetail = function (transaction, size) {
      var modalInstance = $uibModal.open({
        animation: true,
        templateUrl: appSettings.BASE_URL + 'app/modals/transaction/modal.html',
        controller: 'transactionPopupCtrl',
        size: size,
        backdrop: 'static',
        keyboard: false,
        resolve: {
          transaction: function () {
            return transaction;
          }
        }

      });
      modalInstance.result.then(function (data) {
//        window.location.reload();

      });
//  
    };
  }]);