/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


angular.module('matroshkiApp').controller('transactionPopupCtrl', ['appSettings', '$scope', '$uibModalInstance', 'transaction', 'paymentService', function (appSettings, $scope, $uibModalInstance, transaction, paymentService) {


    
    paymentService.getDetail(transaction).then(function (data){
      if(data.data.success){
        
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