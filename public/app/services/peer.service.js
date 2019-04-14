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
    }, { mandatory: { OfferToReceiveVideo: true, OfferToReceiveAudio: true,voiceActivityDetection: false } });
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