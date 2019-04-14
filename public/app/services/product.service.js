'use strict';

angular.module('matroshkiApp').factory('productService', [
  '$http', 'appSettings', function ($http, appSettings) {
    return{
      buy: function (id, data) {
        return $http.post(appSettings.BASE_URL + 'api/v1/products/' + id + '/buy', data)
                .then(function(resp) { return resp.data; });
      }
    };
  }
]);