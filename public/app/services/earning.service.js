/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


angular.module('matroshkiApp').factory('earningService', function ($http, $q, commonHelper, appSettings) {
  return{
    findMe: function (params, page) {

      var query = commonHelper.obToquery(params);
//      var page = (page) ? page : 0;

      return $http.get(appSettings.BASE_URL + 'api/v1/earning/find-earning?' + query);
    },
    modelCommission: function () {
      return $http.get(appSettings.BASE_URL + 'api/v1/earning/commission');
    },
    filterByDay: function (date) {
      return $http.get(appSettings.BASE_URL + 'api/v1/earning/detail?filter=' + date + '&by=day');
    },
    filterByDefault: function (id) {
      return $http.get(appSettings.BASE_URL + 'api/v1/earning/detail?filter=' + id + '&by=none');
    },
    countPaidGallery: function (galleryId, item) {
      return $http.get(appSettings.BASE_URL + 'api/v1/earning/count-paid-gallery?item-id=' + galleryId + '&item=' + item);
    },
    countPaidItem: function (itemId, item) {
      return $http.get(appSettings.BASE_URL + 'api/v1/earning/count-paid-item?item-id=' + itemId + '&item=' + item);
    }

  };
});