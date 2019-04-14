'use strict';

angular.module('matroshkiApp').factory('orderService', function ($http, appSettings) {
  return {
    update: function (id, data) {
      return $http.put(appSettings.BASE_URL + 'api/v1/orders/' + id, data)
              .then(function (resp) {
                return resp.data;
              });
    },

    getComments: function(id) {
      return $http.get(appSettings.BASE_URL + 'api/v1/orders/' + id + '/comments')
              .then(function (resp) {
                return resp.data;
              });
    },

    addComment: function(id, data) {
      return $http.post(appSettings.BASE_URL + 'api/v1/orders/' + id + '/comments', data)
              .then(function (resp) {
                return resp.data;
              });
    }
  };
});