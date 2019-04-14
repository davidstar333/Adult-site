/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


angular.module('matroshkiApp')
        .factory('scheduleService', function ($http, appSettings) {
          return{
            setSchedule: function (schedule) {
              return $http({
                method: 'post',
                url: appSettings.BASE_URL + 'api/v1/schedule/model/update',
                data: schedule
              }).then(function successCallback(res) {
                return res;
              }, function errorCallback(err) {
                return err;
              });
            },
          };
        });