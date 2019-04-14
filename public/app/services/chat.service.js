angular.module('matroshkiApp').factory('chatService', [ '$http', '$q', 'commonHelper', 'appSettings', function ($http, $q, commonHelper, appSettings) {
  return{
    get: function (params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/chat-messages?' + query);
    },
    /**
     * find all messages by mdoel id (room)
     */
    findByModel: function (params) {
      //TODO - add options done
      //
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/messages?' + query);
    },
    sendInstantTokens: function (modelId) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/member/send-instant-tokens/' + modelId,
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
    sendTipTokens: function (roomId, tokens) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/member/send-tip-tokens/' + roomId,
        data: {
          tokens: tokens
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
    sendOfflineTokens: function (modelId) {
      return $http.get(appSettings.BASE_URL + 'api/v1/member/send-offline-tokens/' + modelId);
    }
  };
}]);