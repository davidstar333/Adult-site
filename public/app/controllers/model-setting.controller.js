/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('modelSettingCtrl', function ($scope, authService, userService, countryService) {

  $scope.settings = [
    {
      password: {
        oldPassword: '',
        newPassword: '',
        newpPasswordRetype: ''
      }
    }];
  $scope.submitOtherSetting = function (form) {
    if (form.$valid) {
      
      userService.updateOtherSetting($scope.settings).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
        } else {
          alertify.error(data.data.message);
        }
      });
    }
  };

  $scope.submitChangePassword = function (form) {

    if (form.$valid) {
      authService.changePassword($scope.settings.password.oldPassword, $scope.settings.password.newPassword, function (data) {
        if (data.success) {
          alertify.success(data.message);
          window.location.href = '/login';
        } else {
          alertify.notify(data.message, 'error', 15);
        }
      });
    }
  };
  $scope.countries = [];
  $scope.countryInit = function (countryId) {
    countryService.getCountries().then(function (data) {
      $scope.countries = data.data;
    });
    $scope.contact.countryId = countryId;
  };

  $scope.formSubmitted = false;
  $scope.errors = [];
  $scope.submitUpdateContact = function (form) {
    if (form.$valid) {
      $scope.formSubmitted = true;
      userService.updateContact($scope.contact).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
          window.location.href = data.data.url;
        } else {
          $scope.formSubmitted = false;
          alertify.error(data.data.message);
          $scope.errors = data.data.errors;
        }
      });
    }
  };
  $scope.payment = {};
  $scope.paymentValue = [
    {
      min: 20
    },
    {
      min: 50
    },
    {
      min: 100
    },
    {
      min: 200
    },
    {
      min: 250
    },
    {
      min: 500
    },
    {
      min: 1000
    }
  ];
  $scope.paymentInit = function (payment) {
      var data = JSON.parse(payment);
      
    $scope.payment = data;
  };
  $scope.submitUpdatePayment = function (form) {
    if (form.$valid) {
        $scope.errors = {};
      userService.updatePayment($scope.payment).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
          window.location.href = data.data.url;
        } else {
            console.log(data.data.errors);
          $scope.errors = data.data.errors;
        }
      });
    }
  };
  $scope.suspend = {
    reason: '',
    password: '',
    check: false
  };
  $scope.submitted = false;
  $scope.submitDisableAccount = function (form) {

    if (form.$valid) {
      $scope.submitted = true;
      userService.suspendAccount($scope.suspend).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
          window.location.href = '/';
        } else {
          $scope.submitted = false;
          alertify.error(data.data.message);
        }
      });
    }
  };
  
  $scope.initSettings = function (settings){
    
    $scope.settings = settings;
  }

});