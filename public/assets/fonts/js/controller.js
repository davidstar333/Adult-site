/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';

angular.module('matroshkiApp').controller('chatSettingCtrl', ['$scope', 'appSettings', 'chatSettingService', function ($scope, appSettings, chatSettingService) {
  $scope.performerchat = [];
  //get chat settings data;
  console.log(appSettings);
  chatSettingService.get(appSettings.USER.role, appSettings.USER.id).then(function (data) {
    $scope.performerchat = data.data;
    console.log(data);
  });
  $scope.saveChanges = function (form) {
    var settingsData = angular.copy($scope.performerchat);
    chatSettingService.update(appSettings.USER.id, settingsData).then(function (data) {
      if (data.data.success) {
        return alertify.success(data.data.message);
      }
      return alertify.error(data.data.message);
    });
  };
}]);
'use strict';

angular.module('matroshkiApp').controller('streamCtrl', ['$scope', '$timeout', 'appSettings', '$uibModal', 'socket', 'PerformerChat', 'chatService', 'chatSettingService', '$http', function ($scope, $timeout, appSettings, $uibModal, socket, PerformerChat, chatService, chatSettingService, $http) {
  $scope.tablist = 'profiles';
  // using single socket for RTCMultiConnection signaling
  var onMessageCallbacks = {};
  $scope.isGroupLive = false;
  $scope.isPrivateChat = false;
  $scope.isOffline = false;
  $scope.groupLink = null;
  $scope.roomId = null;
  $scope.virtualRoom = null;

  $scope.streamingInfo = {
    spendTokens: 0,
    time: 0,
    tokensReceive: 0,
    type: 'public',
    hasRoom: true
  };

  socket.on('broadcast-message', function (data) {
    if (data.sender == connection.userid) {
      return;
    }
    if (onMessageCallbacks[data.channel]) {
      onMessageCallbacks[data.channel](data.message);
    }
  });

  socket.onGroupChat(function (data) {
    //      console.log(data);

    if (PerformerChat.model_id == data.model) {
      $scope.isGroupLive = data.online;
      $scope.isOffline = true;
      $('#videos-container').removeClass('loader');
      var virtualRoom = data.virtualRoom ? '?vr=' + data.virtualRoom : '';
      $scope.groupLink = appSettings.BASE_URL + 'members/groupchat/' + data.model + virtualRoom;
    } else {
      $('#offline-image').show();
      $scope.isOffline = true;
    }
  });
  socket.on('public-room-status', function (status) {
    if (!status) {
      $('#videos-container').removeClass('loader');
      $('#offline-image').show();
      $scope.isOffline = true;
    } else {
      $('#videos-container').addClass('loader');
      $('#offline-image').hide();
      $scope.isPrivateChat = false;
      $scope.isGroupLive = false;
      $scope.isOffline = false;
    }
  });
  socket.onModelInitPublicChat(function (data) {
    //    console.log('model init room');

    $scope.virtualRoom = data.broadcastid;

    $scope.isPrivateChat = false;
    $scope.isGroupLive = false;
    //    if($('#offline-image').length > 0){
    $('#offline-image').hide();
    //         
    //    } 
    //$scope.joinBroadcast($scope.roomId, data.broadcastid);
    $('#videos-container').addClass('loader');
    $scope.statusMessage = 'Model is online please refresh your browser to connect again. if website does not auto connect.';
  });

  $scope.isShowPrivateMessage = false;

  socket.on('model-private-status', function (data) {
    //      console.log(data);
    if (data.modelId == PerformerChat.model_id) {
      $scope.isPrivateChat = data.isStreaming;
      $scope.isOffline = true;
      if (data.isStreaming) {
        if ($('#offline-image').length > 0) {

          $('#offline-image').hide();
        }
      } else {
        if ($('#offline-image').length > 0) {

          $('#offline-image').show();
        }
      }
    }
    if ($scope.streamingInfo.type == 'private' && !data.isStreaming) {
      if (!$scope.isShowPrivateMessage) {
        //  alertify.error('Model stopped video call.', 30);
        $scope.isShowPrivateMessage = true;
      }
    }
  });
  socket.on('member-missing-tokens', function (chatType) {
    //     console.log(chatType);
    if (chatType == 'private') {
      alertify.warning('User tokens do not enough, private chat have disconnected');
      socket.emit('model-leave-room');
      $timeout(function () {
        window.location.href = appSettings.BASE_URL + 'models/live';
      }, 3000);
    }
  });

  socket.on('disconnectAll', function (data) {
    if (appSettings.CHAT_ROOM_ID != data.id && data.ownerId == appSettings.USER.id) {
      var modalInstance = $uibModal.open({
        animation: true,
        templateUrl: appSettings.BASE_URL + 'app/modals/close-modal/modal.html?v=' + Math.random().toString(36).slice(2),
        controller: 'modalCloseCtrl',
        backdrop: 'static',
        keyboard: false
      });
      modalInstance.result.then(function (res) {
        window.location.reload();
      });
    }
  });

  $scope.connectionNow = null;
  // initializing RTCMultiConnection constructor.
  $scope.isStreaming = null;
  function initRTCMultiConnection(userid) {
    var connection = new RTCMultiConnection();
    $scope.connectionNow = connection;
    connection.body = document.getElementById('videos-container');
    connection.channel = connection.sessionid = connection.userid = userid || connection.userid;
    connection.sdpConstraints.mandatory = {
      OfferToReceiveAudio: true,
      OfferToReceiveVideo: true
    };

    // using socket.io for signaling
    connection.openSignalingChannel = function (config) {
      var channel = config.channel || this.channel;
      onMessageCallbacks[channel] = config.onmessage;
      if (config.onopen) {
        setTimeout(config.onopen, 1000);
      }

      return {
        send: function send(message) {
          socket.emit('broadcast-message', {
            sender: connection.userid,
            channel: channel,
            message: message
          });
        },
        channel: channel
      };
    };
    connection.onMediaError = function (error) {
      //              JSON.stringify(error)
      alertify.alert('Warning', error.message);
    };

    //fix echo
    connection.onstream = function (event) {
      if (event.mediaElement) {
        event.mediaElement.muted = true;
        delete event.mediaElement;
      }

      var video = document.createElement('video');
      if (event.type === 'local') {
        video.muted = true;
      }
      video.src = URL.createObjectURL(event.stream);
      connection.videosContainer.appendChild(video);
    };

    //disable log
    connection.enableLogs = false;

    return connection;
  }

  // this RTCMultiConnection object is used to connect with existing users
  var connection = initRTCMultiConnection();

  //get other TURN server
  //TODO - config our turn server
  var setupConnection = function setupConnection() {
    connection.getExternalIceServers = true;
    connection.onstream = function (event) {
      if (event.type == 'local' && $scope.streamingInfo.type == 'public') {
        var timeout = null;
        var initNumber = 1;
        var capture = function capture() {

          connection.takeSnapshot(event.userid, function (snapshot) {
            $http.post(appSettings.BASE_URL + 'api/v1/rooms/' + appSettings.CHAT_ROOM_ID + '/setImage', {
              base64: snapshot,
              shotNumber: initNumber
            });
          });
          initNumber = initNumber < 6 ? initNumber + 1 : 1;

          timeout = setTimeout(capture, 30000);
        };
        capture();

        $scope.$on('destroy', function () {
          clearTimeout(timeout);
        });
      }
      //      event.mediaElement.controls = false;
      connection.body.appendChild(event.mediaElement);

      if (connection.isInitiator == false && !connection.broadcastingConnection) {
        $scope.isStreaming = true;
        // "connection.broadcastingConnection" global-level object is used
        // instead of using a closure object, i.e. "privateConnection"
        // because sometimes out of browser-specific bugs, browser
        // can emit "onaddstream" event even if remote user didn't attach any stream.
        // such bugs happen often in chrome.
        // "connection.broadcastingConnection" prevents multiple initializations.

        // if current user is broadcast viewer
        // he should create a separate RTCMultiConnection object as well.
        // because node.js server can allot him other viewers for
        // remote-stream-broadcasting.
        connection.broadcastingConnection = initRTCMultiConnection(connection.userid);

        // to fix unexpected chrome/firefox bugs out of sendrecv/sendonly/etc. issues.
        connection.broadcastingConnection.onstream = function () {};

        connection.broadcastingConnection.session = connection.session;
        connection.broadcastingConnection.attachStreams.push(event.stream); // broadcast remote stream
        connection.broadcastingConnection.dontCaptureUserMedia = true;

        // forwarder should always use this!
        connection.broadcastingConnection.sdpConstraints.mandatory = {
          OfferToReceiveVideo: false,
          OfferToReceiveAudio: false
        };

        connection.broadcastingConnection.open({
          dontTransmit: true
        });
        $('#offline-image').hide();
        $('#videos-container').removeClass('loader');
      }
    };
  };
  setupConnection();

  // ask node.js server to look for a broadcast
  // if broadcast is available, simply join it. i.e. "join-broadcaster" event should be emitted.
  // if broadcast is absent, simply create it. i.e. "start-broadcasting" event should be fired.
  // TODO - model side should start broadcasting and member/client side should join only
  $scope.openBroadcast = function (room, virtualRoom) {
    $scope.roomId = room;
    $scope.virtualRoom = virtualRoom;
    //TODO - hide start button

    connection.session = {
      video: true,
      screen: false,
      audio: true,
      oneway: true
    };

    socket.emit('join-broadcast', {
      broadcastid: $scope.virtualRoom,
      room: $scope.roomId,
      userid: connection.userid,
      typeOfStreams: connection.session,
      openBroadcast: true
    });
    $scope.isStreaming = true;
    $('#startStream_' + room).hide();
  };

  /**
   * join broadcast directly, use for member side
   */

  $scope.joinBroadcast = function (room, virtualRoom) {
    //check model is online / streaming then open broadcast.
    socket.emit('has-broadcast', virtualRoom, function (has) {

      if (!has) {
        //TODO - should show nice alert message
        $('#offline-image').show();
        //       $scope.isOffline = true;
        $('#videos-container').removeClass('loader');
        return;
      }
      $scope.isPrivateChat = false;
      $scope.isGroupLive = false;
      $scope.isOffline = false;

      $scope.roomId = room;
      $scope.virtualRoom = virtualRoom;
      //TODO - check model room is open or not first?
      connection.session = {
        video: true,
        screen: false,
        audio: true,
        oneway: true
      };
      socket.emit('join-broadcast', {
        broadcastid: $scope.virtualRoom,
        room: $scope.roomId,
        userid: connection.userid,
        typeOfStreams: connection.session
      });
    });
  };

  // this event is emitted when a broadcast is already created.
  socket.on('join-broadcaster', function (broadcaster, typeOfStreams) {

    connection.session = typeOfStreams;
    connection.channel = connection.sessionid = broadcaster.userid;

    connection.sdpConstraints.mandatory = {
      OfferToReceiveVideo: !!connection.session.video,
      OfferToReceiveAudio: !!connection.session.audio
    };

    connection.join({
      sessionid: broadcaster.userid,
      userid: broadcaster.userid,
      extra: {},
      session: connection.session
    });
  });

  // this event is emitted when a broadcast is absent.
  socket.on('start-broadcasting', function (typeOfStreams) {
    //      console.log('model start broadcast');
    // host i.e. sender should always use this!
    connection.sdpConstraints.mandatory = {
      OfferToReceiveVideo: false,
      OfferToReceiveAudio: false
    };
    connection.session = typeOfStreams;
    connection.open({
      dontTransmit: true
    });

    if (connection.broadcastingConnection) {
      // if new person is given the initiation/host/moderation control
      connection.close();
      connection.broadcastingConnection = null;
    }
  });

  socket.on('model-left', function () {
    //close connect if model live
    connection.close();
    connection.broadcastingConnection = null;
  });

  socket.on('broadcast-error', function (data) {
    if (!appSettings.USER || appSettings.USER.role != 'model') {
      alertify.alert('Warning', data.msg);
    }

    // if (appSettings.USER && appSettings.USER.role == 'model') {
    //   window.location.reload();
    // }
    $scope.isStreaming = false;
  });

  //rejoin event
  socket.on('rejoin-broadcast', function (data) {
    connection = initRTCMultiConnection();
    setupConnection();

    socket.emit('join-broadcast', {
      broadcastid: data.id,
      room: data.room,
      userid: connection.userid,
      typeOfStreams: connection.typeOfStreams
    });
  });

  $scope.initRoom = function (roomId, virtualRoom) {
    $scope.roomId = roomId;
    $scope.virtualRoom = virtualRoom;

    //get model streaming
    socket.emit('join-broadcast', {
      broadcastid: $scope.virtualRoom,
      room: $scope.roomId,
      userid: connection.userid,
      openBroadcast: false,
      typeOfStreams: {
        video: false,
        screen: false,
        audio: false,
        oneway: true
      }
    });
  };

  function beep() {
    var snd = new Audio("/sounds/received_message.mp3");
    snd.play();
  }

  $scope.sendTip = function (roomId, chatType) {

    alertify.prompt("Enter your tips.", '', function (evt, value) {
      if (angular.isNumber(parseInt(value)) && parseInt(value) > 0) {
        chatService.sendTipTokens(roomId, parseInt(value)).then(function (response) {
          if (response.data.success == false) {
            return alertify.warning(response.data.message);
          } else {
            alertify.success(response.data.message);
            $scope.streamingInfo.spendTokens += parseInt(value);
            $scope.streamingInfo.tokens -= parseInt(value);

            var sendObj = {
              roomId: roomId,
              text: 'Send ' + parseInt(value) + ' tokens',
              type: chatType
            };
            //emit chat event to server
            socket.sendTip(sendObj);
            socket.sendModelReceiveInfo({ time: 0, tokens: value });
            beep();
          }
        });
      } else {
        alertify.error('Please enter a number.');
        $scope.sendTip();
      }
    }).set('title', 'Tip');
  };
  /**
   * 
   * @param {type} roomId
   * @returns {undefined}
   */
  socket.onModelReceiveInfo(function (data) {
    //      $scope.streamingInfo.tokens += parseInt(data.tokens);
    if ($scope.streamingInfo.type == 'private' && appSettings.USER && appSettings.USER.role == 'model') {
      $scope.streamingInfo.tokensReceive += parseInt(data.tokens);
      $scope.streamingInfo.time += parseInt(data.time);
    }
  });
  /*
  if (!appSettings.USER || appSettings.USER.id != PerformerChat.model_id) {
    //event get current model online
    socket.getCurrentModelOnline(appSettings.CHAT_ROOM_ID);
  //            
    //event receive current model online or offline (return undefined)
    $scope.modelOnline = null;
    socket.onCurrentModelOnline(function (data) {
      $scope.modelOnline = _.find(data, _.matchesProperty('id', PerformerChat.model_id));
      
      if (!$scope.modelOnline || typeof $scope.modelOnline == 'undefined') {
        alertify.notify('Model is offline.');
        $scope.isOffline = true;
        if($('#offline-image').length > 0){
            $('#offline-image').show();
        }
        $('#videos-container').removeClass('loader');
       
      }
    });
  }*/

  $scope.stopStreaming = function () {
    //    $("video").each(function () {
    //      this.pause();
    //      delete(this);
    //    });

    // connection.stopMediaStream();
    //   connection.removeStream();
    $scope.connectionNow.close();

    //       socket.leaveRoom(roomId);


    //    connection.close();
    //    connection.broadcastingConnection = null;
    $scope.isStreaming = false;

    //call an event to socket

    socket.emit('model-leave-room');
  };
  $scope.changeStreaming = function (modelId, type) {
    chatSettingService.getChatPrice(modelId, type).success(function (cost) {
      var message = type == 'group' ? 'Group chat will take you ' + cost + ' tokens each minute' : 'Private chat will take you ' + cost + ' tokens each minute';
      alertify.confirm(message, function () {
        if (type == 'group') {
          return window.location.href = appSettings.BASE_URL + 'members/groupchat/' + modelId;
        } else {
          return window.location.href = appSettings.BASE_URL + 'members/privatechat/' + modelId;
        }
      }).set('title', 'Confirm');
    });
  };
}]);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('likesWidgetCtrl', ['$scope', 'appSettings', 'likesWidgetService', function ($scope, appSettings, likesWidgetService) {

  $scope.init = function (itemId, item) {
    $scope.itemId = itemId;
    $scope.item = item;
    likesWidgetService.count({ itemId: $scope.itemId, item: $scope.item }).success(function (data, status, headers, config) {
      $scope.totalLikes = data;
    });
    //check like status
    likesWidgetService.checkMe({ itemId: $scope.itemId, item: $scope.item }).success(function (data, status, headers, config) {
      $scope.liked = data;
    });
  };

  $scope.likeThis = function () {
    likesWidgetService.likeMe({ itemId: $scope.itemId, status: $scope.liked, item: $scope.item }).then(function (data, status, headers, config) {
      if (data.data.status == 'error') {
        alertify.warning(data.data.message);
        return;
      }
      $scope.liked = data.data.status == 'like' ? 1 : 0;
      likesWidgetService.count({ itemId: $scope.itemId, item: $scope.item }).success(function (data, status, headers, config) {
        $scope.totalLikes = data;
      });
    });
  };
}]);
'use strict';
angular.module('matroshkiApp').controller('modelOnlineCtrl', ['$scope', 'appSettings', '_', 'onlineService', 'socket', function ($scope, appSettings, _, onlineService, socket) {

  $scope.currentPage = 1;
  $scope.lastPage = 1;
  $scope.perPage = appSettings.LIMIT_PER_PAGE;
  $scope.orderBy = 'isStreaming';
  $scope.sort = 'desc';
  $scope.totalPages = 0;
  $scope._ = _;
  $scope.modelOnlineNull = false;
  $scope.keyword = '';
  $scope.filter = 'week';

  $scope.getData = function () {
    onlineService.get({ page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, keyword: $scope.keyword, filter: $scope.filter, category: $scope.categoryId }).success(function (data) {
      $scope.users = data.data;
      $scope.currentPage = data.current_page;
      $scope.totalPages = data.last_page; //Math.ceil(data.total / data.per_page);
      if (data.total == 0) {
        $scope.modelOnlineNull = true;
      } else {
        $scope.modelOnlineNull = false;
      }
    });
  };

  $scope.getTopModels = function () {
    onlineService.getTopModels().success(function (data) {
      $scope.topModels = data;
    });
  };

  $scope.setPage = function (page) {
    if (page > 0 && page <= $scope.totalPages) {
      $scope.lastPage = page;
      $scope.getData();
    }
  };

  $scope.onlineInit = function (keyword, id) {
    $scope.keyword = keyword;
    $scope.categoryId = id || '';
    $scope.getData();
    $scope.getTopModels();
    // Run function every second
    setInterval($scope.getData, 30000);
  };

  $scope.setFilter = function (filter) {
    $scope.filter = filter;
    $scope.getData();
  };
  //load models in streaming page
  $scope.getModelsByCategory = function (model, category) {

    onlineService.getModelsByCategory(model, category).success(function (data) {
      $scope.users = data;
    });
  };

  //check model online
  socket.onModelInitPublicChat = function (data) {
    console.log(data);
  };

  $scope.setFavorite = function (index, id) {
    onlineService.setFavorite(id).then(function (data) {
      if (data.data.success) {
        $scope.users[index].favorite = data.data.favorite == 'like' ? data.data.favorite : null;
      } else {
        alertify.error(data.data.message);
      }
    });
  };

  $scope.isRotate = false;

  $scope.modelRotates = function (thread) {

    onlineService.getModelRotateImages(thread.threadId).then(function (data) {

      if (data && angular.isArray(data.data)) {
        $scope.isRotate = true;

        var images = data.data;

        angular.forEach(images, function (item) {
          setTimeout(function () {
            thread.lastCaptureImage = item;
          }, 150);
        });
      }
    });
  };
}]);
'use strict';
angular.module('matroshkiApp').controller('mediaCtrl', ['$scope', 'appSettings', 'videoService', 'galleryService', 'mediaService', function ($scope, appSettings, videoService, galleryService, mediaService) {
  $scope.currentTab = 0;
  $scope.currentPage = 1;
  $scope.lastPage = 1;

  $scope.setTab = function (index) {
    $scope.currentTab = index;
    $scope.currentPage = 1;
    $scope.lastPage = 1;
    $scope.getMedia(index, 1);
  };

  //init data
  $scope.init = function (model) {
    $scope.modelId = model;
  };
  $scope.getMedia = function (index, page) {
    if (index == 1) {
      videoService.getModelVideos($scope.modelId, page).success(function (data) {
        $scope.videos = data.data;
        $scope.currentPage = data.current_page;
        $scope.lastPage = data.last_page;
      });
    } else if (index == 2) {
      galleryService.getModelGalleries($scope.modelId, page).success(function (data) {

        $scope.galleries = data.data;
        $scope.currentPage = data.current_page;
        $scope.lastPage = data.last_page;
      });
    }
  };
  $scope.changePage = function (status) {
    if (status == 0) {
      var page = $scope.currentPage > 1 ? parseInt($scope.currentPage - 1) : 1;
      $scope.getMedia($scope.currentTab, page);
    } else {
      console.log($scope.currentPage, $scope.lastPage);
      var page = $scope.currentPage < $scope.lastPage ? parseInt($scope.currentPage + 1) : $scope.lastPage;
      $scope.getMedia($scope.currentTab, page);
    }
  };
  //check owner
  $scope.checkOwner = function (item, url) {

    mediaService.checkOwner({ id: item.id }).then(function (data) {
      if (!data.data.success) {
        return alertify.alert(data.data.message);
      } else {
        if (data.data.owner > 0) {

          window.location.href = url + '/' + item.id;
        } else {
          alertify.confirm("Are you sure you want to buy this ( " + item.galleryPrice + " tokens)?", function (e) {
            if (e) {
              $.ajax({
                url: appSettings.BASE_URL + 'api/v1/buy-item',
                type: 'post',
                data: {
                  id: item.id,
                  item: item.type
                },
                success: function success(data) {
                  if (!data.success) {
                    alertify.alert('Warning', data.message);
                  } else {
                    alertify.success(data.message);
                    window.location.href = data.url;
                  }
                }
              });
            }
          }).setHeader('<em> Confirm </em> ');
        }
      }
    });
  };
}]);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('paymentCtrl', ['$scope', '$uibModal', 'appSettings', function ($scope, $uibModal, appSettings) {

  //Reject transaction
  $scope.rejectTransaction = function (id) {
    alertify.confirm('Are you sure you want to reject this transaction? Please refund member money first.', function () {
      return window.location.href = appSettings.BASE_URL + 'admin/manager/transaction/reject/' + id;
    }).set('title', 'Confirm');
  };
  //Approve transaction
  $scope.approveTransaction = function (id) {
    alertify.confirm('Are you sure you want to approve this transaction?', function () {
      return window.location.href = appSettings.BASE_URL + 'admin/manager/transaction/approve/' + id;
    }).set('title', 'Confirm');
  };
  //transaction detail

  $scope.showTransactionDetail = function (_transaction, size) {
    var modalInstance = $uibModal.open({
      animation: true,
      templateUrl: appSettings.BASE_URL + 'app/modals/transaction/modal.html',
      controller: 'transactionPopupCtrl',
      size: size,
      backdrop: 'static',
      keyboard: false,
      resolve: {
        transaction: function transaction() {
          return _transaction;
        }
      }

    });
    modalInstance.result.then(function (data) {
      //        window.location.reload();

    });
    //  
  };
}]);
//# sourceMappingURL=controller.js.map
