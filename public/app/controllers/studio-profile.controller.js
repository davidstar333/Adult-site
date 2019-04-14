/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('studioProfileCtrl', function ($scope, userService, countryService) {

  $scope.profile = [];
  $scope.countries = [];

  userService.get().then(function (data) {
    $scope.profile = data.data;
    $scope.profile.countryId = parseInt($scope.profile.countryId);
    $scope.profile.stateId = parseInt($scope.profile.stateId);
    $scope.profile.cityId = parseInt($scope.profile.cityId);
    countryService.getCountries().then(function (data) {
      $scope.countries = data.data;
    });
  });
  $scope.ages = [];
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

  $scope.updateProfile = function (form) {
    userService.updateStudioProfile($scope.profile).then(function (data) {
        $scope.errors = {};
      if (!data.data.success) {
        if (data.data.errors) {
          $scope.errors = data.data.errors;
        } else {
          alertify.error(data.data.message);
        }
      } else {
        alertify.success(data.data.message);
        window.location.reload();
      }
    });
  };
  $scope.errors = {};

});