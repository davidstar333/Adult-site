'use strict';

angular.module('matroshkiApp').factory('chatSettingService', [ '$q', '$http', 'appSettings', function ($q, $http, appSettings) {
  return{
    get: function (role, modelId) {
      return $http.get(appSettings.BASE_URL + 'api/v1/performerchat/' + role + '/' + modelId);
    },
    update: function (modelId, data) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/performerchat/update/' + modelId,
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
    getChatPrice: function (model, type) {
      return $http.get(appSettings.BASE_URL + 'api/v1/performer-chat-price/' + type + '/' + model);
    }
  };
}]);