/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('chatSettingCtrl', [ '$scope', 'appSettings', 'chatSettingService', function ($scope, appSettings, chatSettingService) {
  $scope.performerchat = [];
  //get chat settings data;
  chatSettingService.get(appSettings.USER.role, appSettings.USER.id).then(function (data) {
    $scope.performerchat = data.data;
  });
  $scope.saveChanges = function (form) {
    var settingsData = angular.copy($scope.performerchat);
    chatSettingService.update(appSettings.USER.id, settingsData).then(function (data) {
      if (data.data.success) {
        return alertify.success(data.data.message);
      }
      return  alertify.error(data.data.message);


    });
  };
}]);