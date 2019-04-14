/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


angular.module('matroshkiApp').factory('paymentService', function ($http, $q, commonHelper, appSettings) {
  return{
    getDetail: function (id) {
      return $http.get(appSettings.BASE_URL + 'api/v1/transaction/'+id);
    },
  };
});