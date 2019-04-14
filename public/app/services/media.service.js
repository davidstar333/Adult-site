/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


angular.module('matroshkiApp').factory('mediaService',[ '$http', 'commonHelper', 'appSettings', function ($http, commonHelper, appSettings) {
  return{
    findProfileByMe: function (params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/media/model/find-my-profile-image?' + query);
    },
    findMyMediaGallery: function (params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/media/model/find-my-media-gallery?' + query);
    },
    findMyVideoGallery: function (params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/media/model/find-my-video-gallery?' + query);
    },
    setMainImage: function (id) {
      return $http.put(appSettings.BASE_URL + 'api/v1/media/model/set-main-image/' + id);
    },
    checkOwner: function (params) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/media/check-owner',
        data: params

      }).then(function cb(res) {
        return res;
      }, function error(err) {
        return err;
      });
    },
    setMediaStatus: function (id, status) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/media/model/set-media-status/' + id,
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
    deleteImage: function (id) {
      return  $http({
        method: 'delete',
        url: appSettings.BASE_URL + 'api/v1/media/image/' + id,
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
    deleteVideo: function (id) {
      return  $http({
        method: 'delete',
        url: appSettings.BASE_URL + 'api/v1/media/video/' + id,
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