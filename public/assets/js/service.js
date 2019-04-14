'use strict';

angular.module('matroshkiApp').factory('userService', function ($http, $q, appSettings, commonHelper) {
  return {
    get: function get() {
      return $http.get(appSettings.BASE_URL + 'api/v1/findMe');
    },
    findAll: function findAll(params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/user/find-all?' + query);
    },
    findMember: function findMember(id) {
      return $http.get(appSettings.BASE_URL + 'api/v1/findMember/' + id);
    },
    findById: function findById(id) {
      return $http.get(appSettings.BASE_URL + 'api/v1/user/find-by-id/' + id);
    },
    getPerformer: function getPerformer() {
      return $http.get(appSettings.BASE_URL + 'api/v1/profile/performer');
    },
    findByRoom: function findByRoom(roomId) {
      return $http.get(appSettings.BASE_URL + 'api/v1/members/find-by-room/' + roomId);
    },
    countModelOnline: function countModelOnline() {
      return $http.get(appSettings.BASE_URL + 'api/v1/online/count');
    },
    changeAccountStatus: function changeAccountStatus(id, status) {
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
    changeAccountRole: function changeAccountRole(id, role) {
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
    sendTokens: function sendTokens(modelId, tokens, options) {
      return $http({
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
    sendPaidTokens: function sendPaidTokens(modelId, type) {
      return $http({
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
    updateOtherSetting: function updateOtherSetting(setting) {
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
    updateContact: function updateContact(contact) {
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
    updatePayment: function updatePayment(payment) {
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
    suspendAccount: function suspendAccount(data) {
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
    updatePerformer: function updatePerformer(performer, profile) {
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
    updateStudioProfile: function updateStudioProfile(profile) {
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
    setProfile: function setProfile(imageId) {
      return $http.get(appSettings.BASE_URL + 'api/v1/me/profile/image/' + imageId);
    },
    checkPremium: function checkPremium(room) {
      return $http.get(appSettings.BASE_URL + 'api/v1/me/check-premium/' + room);
    },
    addBlackList: function addBlackList(id) {
      return $http.get(appSettings.BASE_URL + 'api/v1/user/add-black-list/' + id);
    },
    removeBlackList: function removeBlackList(id) {
      return $http.get(appSettings.BASE_URL + 'api/v1/user/remove-black-list/' + id);
    },
    checkBanNick: function checkBanNick(modelId) {
      return $http.get(appSettings.BASE_URL + 'api/v1/user/check-black-list/' + modelId);
    },
    getToken: function getToken(userIds) {
      return $http.get(appSettings.BASE_URL + 'api/v1/member/get-token?ids=' + userIds);
    },
    checkBusy: function checkBusy(modelId) {
      return $http.get(appSettings.BASE_URL + 'api/v1/models/' + modelId + '/check-busy');
    }
  };
});
angular.module('matroshkiApp').factory('authService', ['$http', 'userService', '$cookieStore', '$q', 'appSettings', function ($http, userService, $cookieStore, $q, appSettings) {
  var currentUser = userService.get();
  return {
    /**
     * Authenticate user and save token
     *
     * @param  {Object}   user     - login info
     * @param  {Function} callback - optional
     * @return {Promise}
     */
    login: function login(user, callback) {
      var cb = callback || angular.noop;
      var deferred = $q.defer();

      $http.post(appSettings.BASE_URL + 'api/v1/auth/login', {
        username: user.username,
        password: user.password
      }).success(function (data) {
        $cookieStore.put('token', data.token);
        currentUser = userService.get();
        deferred.resolve(data);
        return cb();
      }).error(function (err) {
        this.logout();
        deferred.reject(err);
        return cb(err);
      }.bind(this));

      return deferred.promise;
    },
    /*
     * Update password after confirm email
     * @returns {function}
     */
    resetPassword: function resetPassword(user) {
      return $http.post(ppSettings.BASE_URL + 'api/v1/users/resetPassword', {
        email: user.email,
        password: user.password,
        confirmPassword: user.confirmPassword
      });
    },
    /*
     * Forgot password
     * @returns {undefined}
     */
    forgotPassword: function forgotPassword(user, cb) {
      return $http.post(ppSettings.BASE_URL + 'api/users/forgotPassword', {
        email: user.email
      }).success(function (data) {
        return cb(data);
      }).error(function (err) {
        return cb(err);
      }.bind(this));
    },
    /**
     * Delete access token and user info
     *
     * @param  {Function}
     */
    logout: function logout() {
      $cookieStore.remove('token');
      currentUser = {};
    },
    /**
     * Create a new user
     *
     * @param  {Object}   user     - user info
     * @param  {Function} callback - optional
     * @return {Promise}
     */
    createUser: function createUser(user, callback) {
      var cb = callback || angular.noop;
      return $http.post(appSettings.BASE_URL + 'api/v1/user/account-new', user).success(function (data) {
        return cb(data);
      }).error(function (err) {
        return cb(err);
      }).$promise;
    },
    /**
     * Change password
     *
     * @param  {String}   oldPassword
     * @param  {String}   newPassword
     * @param  {Function} callback    - optional
     * @return {Promise}
     */
    changePassword: function changePassword(oldPassword, newPassword, callback) {
      var cb = callback || angular.noop;

      return $http.put(appSettings.BASE_URL + 'api/v1/users/change-password', {
        oldPassword: oldPassword,
        newPassword: newPassword
      }).success(function (data) {
        return cb(data);
      }).error(function (err) {
        return cb(err);
      }).$promise;
    },
    /**
     * Gets all available info on authenticated user
     *
     * @return {Object} user
     */
    getCurrentUser: function getCurrentUser() {
      return currentUser;
    },
    /**
     * Check if a user is logged in
     *
     * @return {Boolean}
     */
    isLoggedIn: function isLoggedIn() {
      return currentUser.hasOwnProperty('role');
    },
    /**
     * Waits for currentUser to resolve before checking if user is logged in
     */
    isLoggedInAsync: function isLoggedInAsync(cb) {
      if (currentUser.hasOwnProperty('$promise')) {
        currentUser.$promise.then(function () {
          cb(true);
        }).catch(function () {
          cb(false);
        });
      } else if (currentUser.hasOwnProperty('role')) {
        cb(true);
      } else {
        cb(false);
      }
    },
    /**
     * Check if a user is an admin
     *
     * @return {Boolean}
     */

    /**
     * Get auth token
     */
    getToken: function getToken() {
      return $cookieStore.get('token');
    },
    recoverPassword: function recoverPassword(email, callback) {
      var cb = callback || angular.noop;
      var deferred = $q.defer();

      $http.post(ppSettings.BASE_URL + 'auth/recoverPassword', {
        email: email
      }).success(function (data) {
        deferred.resolve(data);
        return cb();
      }).error(function (err) {
        deferred.reject(err);
        return cb(err);
      }.bind(this));

      return deferred.promise;
    },
    confirmResetPasswordToken: function confirmResetPasswordToken(token, callback) {
      var cb = callback || angular.noop;
      var deferred = $q.defer();

      $http.get(ppSettings.BASE_URL + 'auth/confirmPasswordResetToken/' + token).success(function (data) {
        //do login
        $cookieStore.put('token', data.token);
        currentUser = userService.get();

        deferred.resolve(data);
        return cb();
      }).error(function (err) {
        deferred.reject(err);
        return cb(err);
      }.bind(this));

      return deferred.promise;
    }
  };
}]);
angular.module('matroshkiApp').factory('chatService', ['$http', '$q', 'commonHelper', 'appSettings', function ($http, $q, commonHelper, appSettings) {
  return {
    get: function get(params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/chat-messages?' + query);
    },
    /**
     * find all messages by mdoel id (room)
     */
    findByModel: function findByModel(params) {
      //TODO - add options done
      //
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/messages?' + query);
    },
    sendInstantTokens: function sendInstantTokens(modelId) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/member/send-instant-tokens/' + modelId
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
    sendTipTokens: function sendTipTokens(roomId, tokens) {
      return $http({
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
    sendOfflineTokens: function sendOfflineTokens(modelId) {
      return $http.get(appSettings.BASE_URL + 'api/v1/member/send-offline-tokens/' + modelId);
    }
  };
}]);
/* global io */
'use strict';

angular.module('matroshkiApp').factory('socket', ['appSettings', 'socketFactory', 'commonHelper', '$window', function (appSettings, socketFactory, commonHelper, $window) {
  // socket.io now auto-configures its connection when we ommit a connection url
  var ioSocket = io(appSettings.SOCKET_URL, {
    // Send auth token on connection, you will need to DI the Auth service above
    'query': commonHelper.obToquery({ token: appSettings.TOKEN }),
    path: '/socket.io-client'
  });

  var socket = socketFactory({ ioSocket: ioSocket });

  socket.on('another-model-connected', function () {

    //       var cookies = document.cookie.split(";");
    //       console.log(cookies);
    //       for(var i=0; i < cookies.length; i++) {
    //         var equals = cookies[i].indexOf("=");
    //         var name = equals > -1 ? cookies[i].substr(0, equals) : cookies[i];
    //         document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    //       }
    //call logout to force remove http flag
    alert('You are connecting in another session. exit now!');
    $window.location.href = appSettings.BASE_URL + 'models/dashboard/profile';
  });

  return {
    socket: socket,

    /**
     * Register listeners to sync an array with updates on a model
     *
     * Takes the array we want to sync, the model name that socket updates are sent from,
     * and an optional callback function after new items are updated.
     *
     * @param {String} modelName
     * @param {Array} array
     * @param {Function} cb
     */
    syncUpdates: function syncUpdates(modelName, array, cb) {
      cb = cb || angular.noop;

      /**
       * Syncs item creation/updates on 'model:save'
       */
      socket.on(modelName + ':save', function (item) {
        var oldItem = _.find(array, { _id: item._id });
        var index = array.indexOf(oldItem);
        var event = 'created';

        // replace oldItem if it exists
        // otherwise just add item to the collection
        if (oldItem) {
          array.splice(index, 1, item);
          event = 'updated';
        } else {
          array.push(item);
        }

        cb(event, item, array);
      });

      /**
       * Syncs removed items on 'model:remove'
       */
      socket.on(modelName + ':remove', function (item) {
        var event = 'deleted';
        _.remove(array, { _id: item._id });
        cb(event, item, array);
      });
    },


    /**
     * Removes listeners for a models updates on the socket
     *
     * @param modelName
     */
    unsyncUpdates: function unsyncUpdates(modelName) {
      socket.removeAllListeners(modelName + ':save');
      socket.removeAllListeners(modelName + ':remove');
    },


    /**
    * send new-chat-message event to server
    */
    sendChatMessage: function sendChatMessage(data) {
      socket.emit('new-chat-message', data);
    },


    /**
    * event for the chat message callback
    */
    onReceiveChatMessage: function onReceiveChatMessage(cb) {
      cb = cb || angular.noop;
      socket.on('new-chat-message', cb);
    },


    /**
    * send send-tip event to server
    */
    sendTip: function sendTip(data) {
      socket.emit('send-tip', data);
    },


    /**
     * Event for send tip callback
     */
    onReceiveTip: function onReceiveTip(cb) {
      cb = cb || angular.noop;
      socket.on('send-tip', cb);
    },


    /**
     * new member join to room
     */

    joinRoom: function joinRoom(data) {
      socket.emit('join-room', data);
    },
    joinPrivateRoom: function joinPrivateRoom(data) {
      socket.emit('join-private-room', data);
    },
    onLeaveRoom: function onLeaveRoom(cb) {
      cb = cb || angular.noop;

      socket.on('leave-room', cb);
    },
    onMemberJoin: function onMemberJoin(cb) {
      cb = cb || angular.noop;
      //who
      //total members...
      //{ member: 2134, .... }
      socket.on('join-room', cb);
    },

    //event get list models online
    onModelOnline: function onModelOnline(cb) {
      cb = cb || angular.noop;
      socket.on('model-online', cb);
    },

    //event check current model online
    getCurrentModelOnline: function getCurrentModelOnline(roomId) {
      socket.emit('current-model-online', roomId);
    },

    //event get current model of room online
    onCurrentModelOnline: function onCurrentModelOnline(cb) {
      cb = cb || angular.noop;
      socket.on('current-model-online', cb);
    },
    getOnlineMembers: function getOnlineMembers(roomId) {
      socket.emit('online-members', roomId);
    },
    onlineMembers: function onlineMembers(cb) {
      cb = cb || angular.noop;
      //who
      //total members...
      //{ member: 2134, .... }
      socket.on('online-members', cb);
    },
    reqGroupChat: function reqGroupChat(modelId) {
      socket.emit('get-all-group-chat', modelId);
    },
    reqPrivateChat: function reqPrivateChat(modelId) {
      socket.emit('model-private-status', modelId);
    },
    onGroupChat: function onGroupChat(cb) {
      cb = cb || angular.noop;
      //who
      //total members...
      //{ member: 2134, .... }
      socket.on('on-group-chat', cb);
    },


    //model init public chat
    onModelInitPublicChat: function onModelInitPublicChat(cb) {
      cb = cb || angular.noop();
      //online status
      socket.on('public-chat-init', cb);
    },
    getModelStreaming: function getModelStreaming(roomId, modelId) {
      socket.emit('model-streaming', { room: roomId, model: modelId });
    },

    /**
     * notify with model when they receive new tokens
     */
    sendModelReceiveInfo: function sendModelReceiveInfo(tokens) {
      socket.emit('model-receive-info', tokens);
    },

    /**
     * model receive message
     */
    onModelReceiveInfo: function onModelReceiveInfo(cb) {
      cb = cb || angular.noop();
      socket.on('model-receive-info', cb);
    },
    onModelStreaming: function onModelStreaming(cb) {
      cb = cb || angular.noop;
      //who
      //total members...
      //{ member: 2134, .... }
      socket.on('model-streaming', cb);
    },
    on: function on(event, cb) {
      socket.on(event, cb);
    },
    emit: function emit(event, data, cb) {
      socket.emit(event, data, cb);
    }
  };
}]);

/* global RTCIceCandidate, RTCSessionDescription, RTCPeerConnection, EventEmitter */
'use strict';

/**
 * @ngdoc service
 * @name publicApp.Room
 * @description
 * # Peer
 * Factory in the publicApp.
 */
angular.module('matroshkiApp').factory('peerService', ['$rootScope', '$q', 'socket', 'appSettings', function ($rootScope, $q, socket, appSettings) {
  var iceConfig = { 'iceServers': appSettings.TURN_CONFIG },
      peerConnections = {},
      currentId,
      roomId,
      stream,
      peers = {};

  function getPeerConnection(id) {
    if (peerConnections[id]) {
      return peerConnections[id];
    }

    var pc = new RTCPeerConnection(iceConfig);
    peerConnections[id] = pc;
    pc.addStream(stream);
    pc.onicecandidate = function (evnt) {
      socket.emit('video-msg', { by: currentId, to: id, ice: evnt.candidate, type: 'ice' });
    };
    if ('ontrack' in pc) {
      pc.ontrack = function (evnt) {
        api.trigger('peer.stream', [{
          id: id,
          stream: evnt.streams[0]
        }]);

        if (!$rootScope.$$digest) {
          $rootScope.$apply();
        }
      };
    } else {
      pc.onaddstream = function (evnt) {
        console.log('Received new stream');
        api.trigger('peer.stream', [{
          id: id,
          stream: evnt.stream
        }]);

        if (!$rootScope.$$digest) {
          $rootScope.$apply();
        }
      };
    }
    return pc;
  }

  function makeOffer(id) {
    var pc = getPeerConnection(id);
    pc.createOffer(function (sdp) {
      pc.setLocalDescription(sdp);
      console.log('Creating an offer for', id);
      socket.emit('video-msg', { by: currentId, to: id, sdp: sdp, type: 'sdp-offer' });
    }, function (e) {
      console.log(e);
    }, { mandatory: { OfferToReceiveVideo: true, OfferToReceiveAudio: true, voiceActivityDetection: false } });
  }

  function handleMessage(data) {
    var pc = getPeerConnection(data.by);
    switch (data.type) {
      case 'sdp-offer':
        pc.setRemoteDescription(new RTCSessionDescription(data.sdp), function () {
          console.log('Setting remote description by offer');
          pc.createAnswer(function (sdp) {
            pc.setLocalDescription(sdp);
            socket.emit('video-msg', { by: currentId, to: data.by, sdp: sdp, type: 'sdp-answer' });
          }, function (e) {
            console.log(e);
          });
        }, function (e) {
          console.log(e);
        });
        break;
      case 'sdp-answer':
        pc.setRemoteDescription(new RTCSessionDescription(data.sdp), function () {
          console.log('Setting remote description by answer');
        }, function (e) {
          console.error(e);
        });
        break;
      case 'ice':
        if (data.ice) {
          console.log('Adding ice candidates');
          pc.addIceCandidate(new RTCIceCandidate(data.ice));
        }
        break;
    }
  }

  var socket = socket.socket,
      connected = false;

  function addHandlers(socket) {
    socket.on('peer.connected', function (params) {
      if (peers[params.id]) return;
      console.log('peer.connected', params);
      peers[params.id] = params.id;
      makeOffer(params.id);
    });

    socket.on('peer.disconnected', function (data) {
      api.trigger('peer.disconnected', [data]);
      if (!$rootScope.$$digest) {
        $rootScope.$apply();
      }
    });
    socket.on('group.disconnected', function (data) {
      api.trigger('group.disconnected', [data]);
      if (!$rootScope.$$digest) {
        $rootScope.$apply();
      }
    });
    socket.on('video-msg', function (data) {
      handleMessage(data);
    });
  }

  var api = {
    joinRoom: function joinRoom(r, options) {
      options = options || {};
      if (!connected) {
        socket.emit('video-chat-init', { room: r, data: options }, function (roomid, id) {
          currentId = id;
          roomId = roomid;
        });
        connected = true;
      }
    },
    createRoom: function createRoom() {
      var d = $q.defer();
      socket.emit('video-chat-init', null, function (roomid, id) {
        d.resolve(roomid);
        roomId = roomid;
        currentId = id;
        connected = true;
      });
      return d.promise;
    },
    joinGroupRoom: function joinGroupRoom(r, options) {
      options = options || {};
      if (!connected) {
        socket.emit('group-call-init', { room: r, data: options }, function (roomid, id) {
          currentId = id;
          roomId = roomid;
        });
        connected = true;
      }
    },
    createGroupRoom: function createGroupRoom() {
      var d = $q.defer();
      socket.emit('group-call-init', null, function (roomid, id) {
        d.resolve(roomid);
        roomId = roomid;
        currentId = id;
        connected = true;
      });
      return d.promise;
    },
    init: function init(s) {
      stream = s;
    }
  };
  EventEmitter.call(api);
  Object.setPrototypeOf(api, EventEmitter.prototype);

  addHandlers(socket);
  return api;
}]);
angular.module('matroshkiApp').factory('VideoStream', ['$q', function (a) {
  var b;
  return {
    get: function get() {
      if (b) return a.when(b);
      var c = a.defer();
      var mandatory = {
        mandatory: {
          echoCancellation: true,
          autoGainControl: true,
          noiseSuppression: true,

          highpassFilter: true,
          typingNoiseDetection: true
        }
      };
      if (window.chrome) {
        mandatory = {
          mandatory: {
            echoCancellation: true,
            googAutoGainControl: true,
            googNoiseSuppression: true,
            googHighpassFilter: true,
            googTypingNoiseDetection: true
          }
        };
      }
      navigator.getWebcam = navigator.getUserMedia || navigator.webKitGetUserMedia || navigator.moxGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
      if (navigator.mediaDevices.getUserMedia) {
        return navigator.mediaDevices.getUserMedia({ audio: mandatory, video: true }).then(function (a) {
          b = a, c.resolve(b);
        }).catch(function (a) {
          c.reject(a);
        }), c.promise;
      }

      return navigator.getWebcam({
        video: !0,
        audio: mandatory
      }, function (a) {
        b = a, c.resolve(b);
      }, function (a) {
        c.reject(a);
      }), c.promise;
    }
  };
}]);
'use strict';

angular.module('matroshkiApp').factory('chatSettingService', ['$q', '$http', 'appSettings', function ($q, $http, appSettings) {
  return {
    get: function get(role, modelId) {
      return $http.get(appSettings.BASE_URL + 'api/v1/performerchat/' + role + '/' + modelId);
    },
    update: function update(modelId, data) {
      return $http({
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
    getChatPrice: function getChatPrice(model, type) {
      return $http.get(appSettings.BASE_URL + 'api/v1/performer-chat-price/' + type + '/' + model);
    }
  };
}]);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('matroshkiApp').factory('likesWidgetService', function ($http, $q, commonHelper, appSettings) {
  return {
    count: function count(params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/likes/count?' + query);
    },
    checkMe: function checkMe(params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/likes/checkMe?' + query);
    },
    likeMe: function likeMe(params) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/likes/likeMe',
        data: params
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
  };
});
angular.module('matroshkiApp').factory('onlineService', ['$http', 'appSettings', 'commonHelper', function ($http, appSettings, commonHelper) {
  return {
    get: function get(params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/online?' + query);
    },
    getTopModels: function getTopModels() {
      return $http.get(appSettings.BASE_URL + 'api/v1/top-models');
    },
    getModelsByCategory: function getModelsByCategory(model, category) {
      return $http.get(appSettings.BASE_URL + 'api/v1/get-models-by-category?model=' + model + '&category=' + category);
    },
    checkOnline: function checkOnline(roomId, chatType) {
      return $http.get(appSettings.BASE_URL + 'api/v1/check-online/' + chatType + '/' + roomId);
    },
    getModelRotateImages: function getModelRotateImages(thread) {
      return $http.get(appSettings.BASE_URL + 'api/v1/get-model-rotate-images/' + thread);
    },
    setFavorite: function setFavorite(id) {
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
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('matroshkiApp').factory('videoService', ['$http', 'commonHelper', 'appSettings', function ($http, commonHelper, appSettings) {
  return {
    checkExist: function checkExist(params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/media/video/find-video-name?' + query);
    },
    create: function create(data) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/media/video/store',
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
    setVideoStatus: function setVideoStatus(id, status) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/media/video/status/' + id,
        data: {
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
    findVideoById: function findVideoById(id) {
      return $http.get(appSettings.BASE_URL + 'api/v1/media/video/find-by-id/' + id);
    },
    getModelVideos: function getModelVideos(id, page) {
      return $http.get(appSettings.BASE_URL + 'api/v1/media/video/get-model-videos/' + id + '?page=' + page);
    },
    update: function update(data) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/media/video/update',
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
    }
  };
}]);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('matroshkiApp').factory('galleryService', ['$http', 'commonHelper', 'appSettings', function ($http, commonHelper, appSettings) {
  return {
    findMyGalleries: function findMyGalleries(params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/gallery/find-my-galleries?' + query);
    },
    getModelGalleries: function getModelGalleries(id, page) {
      return $http.get(appSettings.BASE_URL + 'api/v1/gallery/get-model-galleries/' + id + '?page=' + page);
    },
    checkExist: function checkExist(params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/gallery/find-gallery-name?' + query);
    },
    create: function create(data) {
      return $http({
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
    update: function update(data) {
      return $http({
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
    setGalleryStatus: function setGalleryStatus(id, status) {
      return $http({
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
    deleteGallery: function deleteGallery(id) {
      return $http({
        method: 'delete',
        url: appSettings.BASE_URL + 'api/v1/gallery/delete/' + id
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
  };
}]);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('matroshkiApp').factory('scheduleService', function ($http, appSettings) {
  return {
    setSchedule: function setSchedule(schedule) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/schedule/model/update',
        data: schedule
      }).then(function successCallback(res) {
        return res;
      }, function errorCallback(err) {
        return err;
      });
    }
  };
});
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('matroshkiApp').factory('mediaService', ['$http', 'commonHelper', 'appSettings', function ($http, commonHelper, appSettings) {
  return {
    findProfileByMe: function findProfileByMe(params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/media/model/find-my-profile-image?' + query);
    },
    findMyMediaGallery: function findMyMediaGallery(params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/media/model/find-my-media-gallery?' + query);
    },
    findMyVideoGallery: function findMyVideoGallery(params) {
      var query = commonHelper.obToquery(params);
      return $http.get(appSettings.BASE_URL + 'api/v1/media/model/find-my-video-gallery?' + query);
    },
    setMainImage: function setMainImage(id) {
      return $http.put(appSettings.BASE_URL + 'api/v1/media/model/set-main-image/' + id);
    },
    checkOwner: function checkOwner(params) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/media/check-owner',
        data: params

      }).then(function cb(res) {
        return res;
      }, function error(err) {
        return err;
      });
    },
    setMediaStatus: function setMediaStatus(id, status) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/media/model/set-media-status/' + id,
        data: {
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
    deleteImage: function deleteImage(id) {
      return $http({
        method: 'delete',
        url: appSettings.BASE_URL + 'api/v1/media/image/' + id
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
    deleteVideo: function deleteVideo(id) {
      return $http({
        method: 'delete',
        url: appSettings.BASE_URL + 'api/v1/media/video/' + id
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
  };
}]);
angular.module('matroshkiApp').factory('countryService', function ($http, $q, appSettings) {
  return {
    getStates: function getStates(countryId) {
      return $http.get(appSettings.BASE_URL + 'api/v1/country/states/' + countryId);
    },
    getCities: function getCities(stateId) {
      return $http.get(appSettings.BASE_URL + 'api/v1/country/cities/' + stateId);
    },
    getCountries: function getCountries() {
      return $http.get(appSettings.BASE_URL + 'api/v1/country/countries');
    }
  };
});
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('matroshkiApp').factory('categoryService', function ($http, $q, commonHelper, appSettings) {
  return {
    all: function all() {
      return $http.get(appSettings.BASE_URL + 'api/v1/category/findAll');
    },
    checkName: function checkName(name) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/category/check-name',
        data: { name: name }
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
    addNew: function addNew(name) {
      return $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/category/add-new',
        data: { name: name }
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
    update: function update(category) {
      return $http({
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
    delete: function _delete(id) {
      return $http({
        method: 'delete',
        url: appSettings.BASE_URL + 'api/v1/category/delete/' + id
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
  };
});
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('matroshkiApp').factory('earningService', function ($http, $q, commonHelper, appSettings) {
  return {
    findMe: function findMe(params, page) {

      var query = commonHelper.obToquery(params);
      //      var page = (page) ? page : 0;

      return $http.get(appSettings.BASE_URL + 'api/v1/earning/find-earning?' + query);
    },
    modelCommission: function modelCommission() {
      return $http.get(appSettings.BASE_URL + 'api/v1/earning/commission');
    },
    filterByDay: function filterByDay(date) {
      return $http.get(appSettings.BASE_URL + 'api/v1/earning/detail?filter=' + date + '&by=day');
    },
    filterByDefault: function filterByDefault(id) {
      return $http.get(appSettings.BASE_URL + 'api/v1/earning/detail?filter=' + id + '&by=none');
    },
    countPaidGallery: function countPaidGallery(galleryId, item) {
      return $http.get(appSettings.BASE_URL + 'api/v1/earning/count-paid-gallery?item-id=' + galleryId + '&item=' + item);
    },
    countPaidItem: function countPaidItem(itemId, item) {
      return $http.get(appSettings.BASE_URL + 'api/v1/earning/count-paid-item?item-id=' + itemId + '&item=' + item);
    }

  };
});
'use strict';

angular.module('matroshkiApp').factory('payoutService', ['$http', 'appSettings', 'commonHelper', function ($http, appSettings, commonHelper) {
  return {
    getComments: function getComments(id, isStudio) {
      var url = appSettings.BASE_URL + 'api/v1/payouts/' + (isStudio ? 'studio/' : '') + id + '/comments';
      return $http.get(url).then(function (resp) {
        return resp.data;
      });
    },

    addComment: function addComment(id, data, isStudio) {
      var url = appSettings.BASE_URL + 'api/v1/payouts/' + (isStudio ? 'studio/' : '') + id + '/comments';
      return $http.post(url, data).then(function (resp) {
        return resp.data;
      });
    },

    updateStatus: function updateStatus(id, data, isStudio) {
      var url = appSettings.BASE_URL + 'api/v1/payouts/' + (isStudio ? 'studio/' : '') + id + '/status';
      return $http.post(url, data).then(function (resp) {
        return resp.data;
      });
    },
    getEarningByRequestedDate: function getEarningByRequestedDate(options) {
      var query = commonHelper.obToquery(options);
      return $http.get(appSettings.BASE_URL + 'api/v1/payouts/get-earning-by-requested-day?' + query);
    },
    getLastestRequestPayout: function getLastestRequestPayout(type) {
      return $http.get(appSettings.BASE_URL + 'api/v1/payouts/get-lastest-request-payout?type=' + type);
    },
    getTotalPendingBalance: function getTotalPendingBalance() {
      return $http.get(appSettings.BASE_URL + 'api/v1/payouts/get-total-pending-balance');
    }
  };
}]);
'use strict';

angular.module('matroshkiApp').factory('productService', ['$http', 'appSettings', function ($http, appSettings) {
  return {
    buy: function buy(id, data) {
      return $http.post(appSettings.BASE_URL + 'api/v1/products/' + id + '/buy', data).then(function (resp) {
        return resp.data;
      });
    }
  };
}]);
'use strict';

angular.module('matroshkiApp').factory('orderService', function ($http, appSettings) {
  return {
    update: function update(id, data) {
      return $http.put(appSettings.BASE_URL + 'api/v1/orders/' + id, data).then(function (resp) {
        return resp.data;
      });
    },

    getComments: function getComments(id) {
      return $http.get(appSettings.BASE_URL + 'api/v1/orders/' + id + '/comments').then(function (resp) {
        return resp.data;
      });
    },

    addComment: function addComment(id, data) {
      return $http.post(appSettings.BASE_URL + 'api/v1/orders/' + id + '/comments', data).then(function (resp) {
        return resp.data;
      });
    }
  };
});
//# sourceMappingURL=service.js.map
