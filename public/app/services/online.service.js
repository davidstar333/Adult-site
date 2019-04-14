angular.module('matroshkiApp').factory('onlineService', [ '$http', 'appSettings', 'commonHelper', function ($http, appSettings, commonHelper) {
  return{
    get: function (params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/online?' + query);
    },
    getTopModels: function () {
      return $http.get(appSettings.BASE_URL + 'api/v1/top-models');
    },
    getModelsByCategory: function (model, category) {
      return $http.get(appSettings.BASE_URL + 'api/v1/get-models-by-category?model=' + model + '&category=' + category);
    },
    checkOnline: function (roomId, chatType) {
      return $http.get(appSettings.BASE_URL + 'api/v1/check-online/' + chatType + '/' + roomId);
    },
    getModelRotateImages: function (thread){
      return $http.get(appSettings.BASE_URL + 'api/v1/get-model-rotate-images/'+thread);
    },
    setFavorite: function (id) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/user/favorite',
        data: {
          model: id
        }
      }).then(function cb(res) {
        return res;
      }, function error(err) {
        return err;
      });
    }
  };
}]);