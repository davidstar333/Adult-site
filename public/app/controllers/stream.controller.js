'use strict';

angular.module('matroshkiApp')
.controller('streamCtrl',[ '$scope', '$timeout', 'appSettings', '$uibModal',
	'socket', 'PerformerChat', 'chatService', 'chatSettingService', '$http','commonHelper', 'userService',
	function ($scope, $timeout, appSettings, $uibModal, socket, PerformerChat, chatService, chatSettingService, $http,commonHelper, userService) {
	$scope.tablist = 'profiles';
	if (!appSettings.USER || appSettings.USER.role != 'model') {
		$('#videos-container').addClass('loader');
    }
   var reTimeoutRoom = null ;
	// using single socket for RTCMultiConnection signaling
	var onMessageCallbacks = {};
	$scope.isGroupLive = false;
	$scope.isPrivateChat = false;
	$scope.isOffline = false;
	$scope.groupLink = null;
	$scope.roomId = null;
  $scope.currentModelId = null;
	$scope.virtualRoom = null;

  $scope.modelId = null;

	$scope.streamingInfo = {
		spendTokens: 0,
		time: 0,
		tokensReceive: 0,
		type: 'public',
		hasRoom: true
	};

	var threadId;
	$scope.totalView = 0;
	$scope.isStreaming = false;

	function reCountMember() {
		if (!threadId) {
			return;
		}
		socket.emit('countMember', threadId, function(data) {
			$scope.totalView = data.guests + data.members;
			$scope.$$phase || $scope.$apply();
		});

		$timeout(function() {
			reCountMember();
		}, 10000);
	}

	socket.on('broadcast-message', function (data) {
		if (data.sender == connection.userid) {
			return;
		}
		if (onMessageCallbacks[data.channel]) {
			onMessageCallbacks[data.channel](data.message);
		}
	});

	socket.onGroupChat(function (data) {
		// console.log(data);

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
		$scope.virtualRoom = data.broadcastid;

		$scope.isPrivateChat = false;
		$scope.isGroupLive = false;
		// if($('#offline-image').length > 0){
		$('#offline-image').hide();
		// }
		//$scope.joinBroadcast($scope.roomId, data.broadcastid);
		$('#videos-container').addClass('loader');
		$timeout(function () {
			const isLoading = $('#videos-container').hasClass('loader');
			if(isLoading){
				location.reload();
			}
		}, 7000);

	});

	$scope.isShowPrivateMessage = false;

	socket.on('model-private-status', function (data) {
    //      console.log(data);

    if (PerformerChat && data.modelId == PerformerChat.model_id) {
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
				// alertify.error('Model stopped video call.', 30);
				$scope.isShowPrivateMessage = true;
			}
		}
	});
	socket.on('member-missing-tokens', function (chatType) {
		// console.log(chatType);
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
  var timeoutVideo = null;
  var steamId = null;
	$scope.connectionNow = null;
	// initializing RTCMultiConnection constructor.
	$scope.isStreaming = null;
  $scope.currentConnectStart = null;
	function initRTCMultiConnection(userid) {
   	  var connection = new RTCMultiConnection();
   	  // connection.resources.firebaseio = 'https://xcamsv2.firebaseIO.com/';;
   	  // connection.enableLogs = true;
      // connection.socketURL = appSettings.SOCKET_URL + '/';
      // connection.socketOptions = {
      //   'query': commonHelper.obToquery({token: appSettings.TOKEN}),
      //   path: '/socket.io-client'
      // };
      connection.socketURL = 'https://rtcmulticonnection.herokuapp.com:443/';


    connection.socketMessageEvent = 'video-broadcast-demo';
    $scope.connectionNow = connection;
    connection.getExternalIceServers = false;
    connection.videosContainer  = document.getElementById('videos-container');
    connection.channel = connection.sessionid = connection.userid = userid || connection.userid;

    connection.sdpConstraints.mandatory = {
      OfferToReceiveAudio: true,
      OfferToReceiveVideo: true
    };


    connection.onMediaError = function (error) {
      //              JSON.stringify(error)

      alertify.alert('Warning', error.message);
    };

      connection.onstream = function (event) {
        const numOfVideos = connection.videosContainer.childElementCount;
        if(numOfVideos > 0){
          return true;
        }
        if (connection.isInitiator && event.type !== 'local') {
          return;
        }
        event.mediaElement.removeAttribute('src');
        event.mediaElement.removeAttribute('srcObject');

        connection.isUpperUserLeft = false;

        if (event.type == 'local' && $scope.streamingInfo.type == 'public') {
          var timeout = null;
          var i = 0;

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
            clearTimeout(timeoutVideo);
            i = 0;
          });
          var recordingInterval = 10000;

//          var recordSteam = function recordSteam() {
//            var recorder = {
//              video: RecordRTC(event.stream, {
//                type: 'video'
//              })
//            };
//
//            recorder.video.startRecording();
//
//            connection.streamEvents[event.streamid].recorder = recorder;
//          };
//          timeoutVideo = setTimeout(function(){
//              recordSteam();
//           var recordToServer = function recordToServer() {
//            i++;
//             var recorder = connection.streamEvents[event.streamid].recorder;
//            recorder.video.stopRecording(function (singleWebM) {
//              var blog = this.getBlob();
//               var formData = new FormData();
//
//              formData.append('video-filename', i + 'video-stream.webm');
//              formData.append('video-blob', blog);
//              formData.append('type', $scope.streamingInfo.type);
//
//              $http({
//                method: 'POST',
//                url: appSettings.BASE_URL + 'api/v1/rooms/' + appSettings.CHAT_ROOM_ID + '/recordVideo?userId=' + appSettings.USER.id + '&session=' + event.userid,
//                headers: {'Content-Type': undefined},
//                transformRequest: angular.identity,
//                data: formData
//
//              }).then(function (err) {
//
//                recordSteam();
//                timeoutVideo = setTimeout(recordToServer, recordingInterval);
//              }, function () {
//                recordSteam();
//                timeoutVideo = setTimeout(recordToServer, recordingInterval);
//              });
//
//            });
//
//          };
//            timeoutVideo = setTimeout(recordToServer, recordingInterval);
//
//          },3000);
        }

         if (connection.isInitiator == false && event.type === 'remote') {
          $scope.isStreaming = true;
          connection.dontCaptureUserMedia = true;
          connection.attachStreams = [event.stream];

          connection.sdpConstraints.mandatory = {
            OfferToReceiveAudio: true,
            OfferToReceiveVideo: true
          };
          clearTimeout(reTimeoutRoom);
          $('#offline-image').hide();
          $('#videos-container').removeClass('loader');
        }
        steamId = event.streamid;
        var video = document.createElement('video');
        if (event.type === 'local') {
          video.muted = true;

        }
        video.srcObject = event.stream;
        video.userid = event.userid;
        video.play();
        
        connection.videosContainer.appendChild(video);
		$scope.isStreaming = true;

      };




    //disable log
    connection.enableLogs = false;

    return connection;
  }
   socket.on('broadcast-stopped', function () {
        console.log('Broadcast has been stopped.');
        $('#offline-image').show();
        $('#videos-container').removeClass('loader');
      });


	// this RTCMultiConnection object is used to connect with existing users
	var connection = initRTCMultiConnection();


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
		// $scope.isStreaming = true;
    $('#startStream_' + room).hide();
	};

	/**
  * join broadcast directly, use for member side
  */

	$scope.joinBroadcast = function (room, virtualRoom) {
        //count online member
        threadId = room;
        reCountMember();
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
  $scope.privateChatRoom = null;


	// this event is emitted when a broadcast is already created.
// this event is emitted when a broadcast is already created.
  socket.on('join-broadcaster', function (broadcaster, typeOfStreams) {
    console.log('join-broadcaster');
    connection.session = typeOfStreams;
    connection.channel = connection.sessionid = broadcaster.userid;

    connection.sdpConstraints.mandatory = {
			OfferToReceiveVideo: true,
			OfferToReceiveAudio: true
    };
      (function reCheckRoomPresence() {

             socket.emit('check-broadcast-presence', broadcaster.broadcastid, function (isRoomExists) {

              if (isRoomExists) {
                setTimeout(function () {

                  connection = initRTCMultiConnection();
                  connection.session = typeOfStreams;
                  $scope.broadcaster = broadcaster;

                  connection.channel = connection.sessionid = broadcaster.userid;

                  connection.sdpConstraints.mandatory = {
                    OfferToReceiveVideo: true,
                    OfferToReceiveAudio: true
                  };
                  connection.join(broadcaster.userid, {
                    userid: broadcaster.userid,
                    extra: {},
                    session: connection.session
                  });

                }, 1000);
                if($scope.isStreaming){
                  return;
                }
              }
              if (connection) {
                connection.close();
              }
              reTimeoutRoom = setTimeout(reCheckRoomPresence, 5000);
            });
          })();

      $scope.isStreaming = true;
    });

	// this event is emitted when a broadcast is absent.
	socket.on('start-broadcasting', function (typeOfStreams) {

     console.log('start-broadcasting');
		// host i.e. sender should always use this!
		connection.sdpConstraints.mandatory = {
			OfferToReceiveVideo: false,
			OfferToReceiveAudio: false
		};

		connection.session = typeOfStreams;
		connection.dontTransmit = true;
    connection.open(connection.userid);
//    if($scope.currentConnectStart){
//      connection.close();
//    }else{
//      $scope.currentConnectStart = true;
//    }

//		if (connection.broadcastingConnection) {
//			// if new person is given the initiation/host/moderation control
//			connection.close();
//			connection.broadcastingConnection = null;
//		}
	});
  var i = 0;
  socket.on('model-left', function () {
      //close connect if model live\
      console.log('model-left',i);
      i++;
      $('#offline-image').show();
      $('#videos-container').removeClass('loader');
      if (!appSettings.USER || appSettings.USER.role != 'model') {
      	 $scope.connectionNow.close();
        connection.videosContainer.innerHTML = '';
        connection.close();
        $scope.isStreaming = false;
      }
    });

	socket.on('broadcast-error', function (data) {
		if (!appSettings.USER || appSettings.USER.role != 'model') {
      console.log('broadcast-error');
			alertify.alert('Warning', data.msg);
		}
		$scope.isStreaming = false;
	});

	//rejoin event
    socket.on('rejoin-broadcast', function (data) {

      if (!appSettings.USER || appSettings.USER.role != 'model') {

      socket.emit('check-broadcast-presence', data.id, function (isBroadcastExists) {
        setTimeout(function () {

          console.log('connection.session',connection.session);
          connection.attachStreams = [];

              socket.emit('join-broadcast', {
                broadcastid: data.id,
                room: data.room,
                userid: connection.userid,
                typeOfStreams: connection.typeOfStreams
              });



        }, 1000);

      });
    }
//		socket.emit('join-broadcast', {
//			broadcastid: data.id,
//			room: data.room,
//			userid: connection.userid,
//			typeOfStreams: connection.typeOfStreams
//		});
    });

	function beep() {
		const unique = new Date().getTime();
		var snd = new Audio("/sounds/received_message.mp3?v=" + unique);
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
					}
				});
			} else {
				alertify.error('Please enter a number.');
				$scope.sendTip();
			}
		}).set('title', 'Tip');
	};
	$scope.backToFreeChat = function(modelId, url) {
		if (appSettings.USER && appSettings.USER.role == 'member') {
	      socket.emit('stop-video-request', 
	      { 
	        data: {
	          modelId: modelId,
	        } 
	      });
	    }
	    return window.location.href = url;
	};
	/**
  *
  * @param {type} roomId
  * @returns {undefined}
  */
	socket.onModelReceiveInfo(function (data) {
		// $scope.streamingInfo.tokens += parseInt(data.tokens);
		if ($scope.streamingInfo.type == 'private' && appSettings.USER && appSettings.USER.role == 'model') {
			$scope.streamingInfo.tokensReceive += parseInt(data.tokens);
			$scope.streamingInfo.time += parseInt(data.time);
		}
	});
	/*
 if (!appSettings.USER || appSettings.USER.id != PerformerChat.model_id) {
 	//event get current model online
 	socket.getCurrentModelOnline(appSettings.CHAT_ROOM_ID);

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
      $scope.connectionNow.close();
      connection.videosContainer.innerHTML = '';
      connection.autoCloseEntireSession = true;
      $scope.connectionNow.close();
      $scope.isStreaming = false;
      //call an event to socket
      socket.emit('model-leave-room');
      location.reload();
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

	//model's status
	$scope.statusForUpdating = '';
	$scope.modelStatus = '';
	if (appSettings.USER && appSettings.USER.role == 'model') {
		userService.get().success(function(data){
			$scope.statusForUpdating = data.status;
		});
	}
	$scope.updateStatus = function(form){
		socket.emit('updateModelStatus', {
			userId: appSettings.USER.id,
			roomId: $scope.roomId,
			status: $scope.statusForUpdating
		}, function() {
			alertify.success('Updated successfully');
		});
	};
	socket.on('updateModelStatus', function(data){
		$scope.modelStatus = data.status;
	});

	// show full screen
	$scope.isFullScreenMode = false;
	$scope.showFullScreen = function() {
		$scope.isFullScreenMode = true;
		$('.header').addClass('hidden');
		$('.line-menu').addClass('hidden');
		$('.footer').addClass('hidden');
		$('body').addClass('fullscreen-mode');
        $('.top-detial').addClass('hidden');
        $('.model-detail-section').addClass('hidden');
		$scope.isFullScreenMode = true;
	};
	$scope.notShowFullScreen = function() {
		$scope.isFullScreenMode = false;
		$('.header').removeClass('hidden');
		$('.line-menu').removeClass('hidden');
		$('.footer').removeClass('hidden');
        $('.top-detial').removeClass('hidden');
		$('body').removeClass('fullscreen-mode');
        $('.model-detail-section').removeClass('hidden');
	};
	
}]);
