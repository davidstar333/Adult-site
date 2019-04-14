angular.module('matroshkiApp')
        .factory('countryService', function ($http, $q, appSettings) {
          return{
            getStates: function (countryId) {
              return $http.get(appSettings.BASE_URL + 'api/v1/country/states/'+countryId);
            },
            getCities: function (stateId) {
              return $http.get(appSettings.BASE_URL + 'api/v1/country/cities/'+stateId);
            },
            getCountries: function () {
              return $http.get(appSettings.BASE_URL + 'api/v1/country/countries');
            }
          };
        });