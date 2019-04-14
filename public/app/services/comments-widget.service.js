/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


angular.module('matroshkiApp').factory('commentsWidgetService', function ($http, $q, commonHelper, appSettings) {
  return{
    count: function (params){
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/comments/count?' + query);
    },
    findAll: function (params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/comments/findAll?' + query);
    },
    subComments: function (params){
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/comments/subComments?' + query);
    },
    addNewComment: function (params) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/comments/addNew',
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