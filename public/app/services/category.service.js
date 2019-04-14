/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


angular.module('matroshkiApp').factory('categoryService', function ($http, $q, commonHelper, appSettings) {
  return{
    all: function () {
      return $http.get(appSettings.BASE_URL + 'api/v1/category/findAll');
    },
    checkName: function (name) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/category/check-name',
        data: {name: name}
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
    addNew: function (name) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/category/add-new',
        data: {name: name}
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
    update: function (category) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/category/update/' + category.id,
        data: category
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
    delete: function (id) {
      return  $http({
        method: 'delete',
        url: appSettings.BASE_URL + 'api/v1/category/delete/' + id,
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
  }
});