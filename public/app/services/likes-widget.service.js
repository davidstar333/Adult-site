/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


angular.module('matroshkiApp').factory('likesWidgetService', function ($http, $q, commonHelper, appSettings) {
  return{
    count: function (params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/likes/count?' + query);
    },
    checkMe: function (params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/likes/checkMe?' + query);
    },
    likeMe: function (params) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/likes/likeMe',
        data: params
      }).then(function successCallback(response) {
        // this callback will be called asynchronously
        // when the response is available
        return response;
      }, function errorCallback(err) {
        // called asynchronously if an error occurs
        // or server returns response with an error status.
        return err;
      });
    }
  };
});