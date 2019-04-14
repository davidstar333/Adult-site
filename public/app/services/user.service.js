angular.module('matroshkiApp').factory('userService', function ($http, $q, appSettings, commonHelper) {
  return{
    get: function () {
      return $http.get(appSettings.BASE_URL + 'api/v1/findMe');
    },
    findAll: function (params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/user/find-all?' + query);
    },
    findMember: function (id) {
      return $http.get(appSettings.BASE_URL + 'api/v1/findMember/' + id);
    },
    findById: function (id) {
      return $http.get(appSettings.BASE_URL + 'api/v1/user/find-by-id/' + id);
    },
    getPerformer: function () {
      return $http.get(appSettings.BASE_URL + 'api/v1/profile/performer');
    },
    findByRoom: function (roomId) {
      return $http.get(appSettings.BASE_URL + 'api/v1/members/find-by-room/' + roomId);
    },
    countModelOnline: function () {
      return $http.get(appSettings.BASE_URL + 'api/v1/online/count');
    },
    changeAccountStatus: function (id, status) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/user/account-status/' + id,
        data: {
          status: status
        }
      }).then(function cb(res) {
        return res;
      }, function error(err) {
        return err;
      });
    },
    changeAccountRole: function (id, role) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/user/account-role/' + id,
        data: {
          role: role
        }
      }).then(function cb(res) {
        return res;
      }, function error(err) {
        return err;
      });
    },
    sendTokens: function (modelId, tokens, options) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/member/send-tokens',
        data: {
          modelId: modelId,
          tokens: tokens,
          options: options
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
    sendPaidTokens: function (modelId, type) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/member/send-paid-tokens',
        data: {
          modelId: modelId,
          chatType: type
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
    updateOtherSetting: function (setting) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/users/model/other-settings',
        data: setting
      }).then(function successCallback(res) {
        return res;
      }, function errorCallback(err) {
        return err;
      });
    },
    updateContact: function (contact) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/users/model/update-contact',
        data: contact
      }).then(function successCallback(res) {
        return res;
      }, function errorCallback(err) {
        return err;
      });
    },
    updatePayment: function (payment) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/users/model/update-payment',
        data: payment
      }).then(function successCallback(res) {
        return res;
      }, function errorCallback(err) {
        return err;
      });
    },
    suspendAccount: function (data) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/users/model/suspend',
        data: data
      }).then(function successCallback(res) {
        return res;
      }, function errorCallback(err) {
        return err;
      });
    },
    updatePerformer: function (performer, profile) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/users/model/performer',
        data: {
          performer: performer,
          profile: profile
        }
      }).then(function successCallback(res) {
        return res;
      }, function errorCallback(err) {
        return err;
      });
    },
    updateStudioProfile: function (profile) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/studio/profile',
        data: profile
      }).then(function successCallback(res) {
        return res;
      }, function errorCallback(err) {
        return err;
      });
    },
    setProfile: function (imageId) {
      return $http.get(appSettings.BASE_URL + 'api/v1/me/profile/image/' + imageId);
    },
    checkPremium: function (room) {
      return $http.get(appSettings.BASE_URL + 'api/v1/me/check-premium/' + room);
    },
    addBlackList: function (id) {
      return $http.get(appSettings.BASE_URL + 'api/v1/user/add-black-list/' + id);
    },
    removeBlackList: function (id) {
      return $http.get(appSettings.BASE_URL + 'api/v1/user/remove-black-list/' + id);
    },
    checkBanNick: function (modelId) {
      return $http.get(appSettings.BASE_URL + 'api/v1/user/check-black-list/' + modelId);
    },
    getToken: function(userIds){
      return $http.get(appSettings.BASE_URL + 'api/v1/member/get-token?ids=' + userIds);
    },
    checkBusy: function(modelId) {
      return $http.get(appSettings.BASE_URL + 'api/v1/models/'+modelId+'/check-busy');
    }
  };
});