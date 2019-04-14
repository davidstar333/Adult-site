/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


angular.module('matroshkiApp').factory('videoService', [ '$http', 'commonHelper', 'appSettings', function ($http, commonHelper, appSettings) {
  return{
    checkExist: function (params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/media/video/find-video-name?' + query);
    },
    create: function (data) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/media/video/store',
        data: data
      }).then(function successCallback(response) {
        // this callback will be called asynchronously
        // when the response is available
        return response;
      }, function errorCallback(err) {
        // called asynchronously if an error occurs
        // or server returns response with an error status.
        return err;
      });
    },
    setVideoStatus: function (id, status) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/media/video/status/' + id,
        data: {
          status: status
        }
      }).then(function successCallback(response) {
        // this callback will be called asynchronously
        // when the response is available
        return response;
      }, function errorCallback(err) {
        // called asynchronously if an error occurs
        // or server returns response with an error status.
        return err;
      });
    },
    findVideoById: function (id) {
      return $http.get(appSettings.BASE_URL + 'api/v1/media/video/find-by-id/' + id);
    },
    getModelVideos: function (id, page) {
      return $http.get(appSettings.BASE_URL + 'api/v1/media/video/get-model-videos/' + id + '?page=' + page);
    },
    update: function (data) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/media/video/update',
        data: data
      }).then(function successCallback(response) {
        // this callback will be called asynchronously
        // when the response is available
        return response;
      }, function errorCallback(err) {
        // called asynchronously if an error occurs
        // or server returns response with an error status.
        return err;
      });
    },
  }
}]);