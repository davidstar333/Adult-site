'use strict';

angular.module('matroshkiApp').factory('payoutService', [
  '$http', 'appSettings', 'commonHelper', function ($http, appSettings, commonHelper) {
    return{
      getComments: function(id, isStudio) {
        var url = appSettings.BASE_URL + 'api/v1/payouts/' + (isStudio ? 'studio/' : '') + id + '/comments';
        return $http.get(url)
                .then(function (resp) {
                  return resp.data;
                });
      },

      addComment: function(id, data, isStudio) {
        var url = appSettings.BASE_URL + 'api/v1/payouts/' + (isStudio ? 'studio/' : '') + id + '/comments';
        return $http.post(url, data)
              .then(function (resp) {
                return resp.data;
              });
      },

      updateStatus: function(id, data, isStudio) {
        var url = appSettings.BASE_URL + 'api/v1/payouts/' + (isStudio ? 'studio/' : '') + id + '/status';
        return $http.post(url, data)
              .then(function (resp) {
                return resp.data;
              });
      },
      getEarningByRequestedDate: function(options){
        var query = commonHelper.obToquery(options);
        return $http.get(appSettings.BASE_URL + 'api/v1/payouts/get-earning-by-requested-day?' + query);
      },
      getLastestRequestPayout: function(type){
        return $http.get(appSettings.BASE_URL + 'api/v1/payouts/get-lastest-request-payout?type=' + type);
      },
      getTotalPendingBalance: function(){
        return $http.get(appSettings.BASE_URL + 'api/v1/payouts/get-total-pending-balance');
      }
    };
  }
]);