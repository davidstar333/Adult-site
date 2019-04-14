/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


angular.module('matroshkiApp').factory('galleryService',[ '$http', 'commonHelper', 'appSettings', function ($http, commonHelper, appSettings) {
  return{
    findMyGalleries: function (params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/gallery/find-my-galleries?' + query);
    },
    getModelGalleries: function (id, page) {
      return $http.get(appSettings.BASE_URL + 'api/v1/gallery/get-model-galleries/' + id + '?page=' + page);
    },
    checkExist: function (params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/gallery/find-gallery-name?' + query);
    },
    create: function (data) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/gallery/store',
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
    update: function (data) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/gallery/update',
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
    setGalleryStatus: function (id, status) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/gallery/status',
        data: {
          id: id,
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
    deleteGallery: function (id) {
      return  $http({
        method: 'delete',
        url: appSettings.BASE_URL + 'api/v1/gallery/delete/' + id,
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