'use strict';

angular.module('matroshkiApp').controller('modelPayoutRequestCtrl', ['$scope', 'payoutService', function ($scope, payoutService) {
    $scope.startDate = {
      open: false,
      value: ''
    };
    $scope.toDate = {
      open: false,
      value: ''
    };
    $scope.typeRequest = '';
    $scope.init = function(typeRequest, dateFrom, dateTo){
      $scope.typeRequest = typeRequest;
      if(dateFrom){
        $scope.startDate.value = new Date(dateFrom);
      }
      if(dateTo){
        $scope.toDate.value = new Date(dateTo);
      }
    };
    $scope.$watch('startDate.value', function(data){
      showRequestPayout($scope.startDate.value, $scope.toDate.value);
    });
    $scope.$watch('toDate.value', function(data){
      showRequestPayout($scope.startDate.value, $scope.toDate.value);
    });
    $scope.earningByRequestedDate = null;
    $scope.previousPayout = null;
    $scope.pendingBalance = null;
    function showRequestPayout(startDate, endDate) {
      if(startDate && endDate){
        var convertedStartDate = new Date(startDate);
        var convertedEndDate = new Date(endDate);
        var options = {
          startDate: convertedStartDate.getFullYear() + "-" + (convertedStartDate.getMonth() + 1) + "-" + convertedStartDate.getDate(),
          endDate: convertedEndDate.getFullYear() + "-" + (convertedEndDate.getMonth() + 1) + "-" + convertedEndDate.getDate()
        };
        payoutService.getEarningByRequestedDate(options).then(function(data) {          
          $scope.earningByRequestedDate = data.data.amount;
          return payoutService.getLastestRequestPayout($scope.typeRequest);
        }).then(function(data){
          $scope.previousPayout = data.data.amount;
          return payoutService.getTotalPendingBalance();
        }).then(function(data){
          $scope.pendingBalance = (data.data.amount - $scope.earningByRequestedDate).toFixed(1);
        }); 
      }
    }
  }
])
.controller('ModelRequestPayoutViewCrl', ['$scope', 'payoutService' ,function ($scope, payoutService) {
    $scope.comments = [];

    $scope.init = function(data) {
      $scope.request = data;
      $scope.status = data.status;
      $scope.note = data.note;
      $scope.studioId = data.studioId;
      payoutService.getComments(data.id, !!$scope.studioId)
        .then(function(resp) {
          $scope.comments = resp.data;
        });
    };

    $scope.comment = function() {
      payoutService.addComment($scope.request.id, {
        text: $scope.newComment,
        studioId: $scope.studioId
      }, !!$scope.studioId)
      .then(function(resp) {
        $scope.comments.push(resp.data);
        $scope.newComment = '';
      });
    };

    //for admin only
    $scope.updateStatus = function() {
      payoutService.updateStatus($scope.request.id, {
        status: $scope.status,
        note: $scope.note
      }, !!$scope.studioId)
      .then(function(resp) {
        alertify.success('Request has been updated!');
      });
    };
  }
]);