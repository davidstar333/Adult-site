angular.module('matroshkiApp').directive('mGroupChatVideo', ['appSettings', '$timeout', '$interval', 'socket', 'VideoStream', 'peerService', '$sce', 'onlineService', 'userService', function (appSettings, $timeout, $interval, socket, VideoStream, peerService, $sce, onlineService, userService) {
  return {
    restrict: 'AE',
    templateUrl: appSettings.BASE_URL + 'app/views/partials/group-chat-video-widget.html',
    scope: {
      modelId: '=modelId',
      memberId: '=memberId',
      room: '@',
      onModelRoom: '@',
      virtualRoom: '@',
      streamingInfo: "=ngModel"
    },
    controller: function controller($scope, userService, PerformerChat, $window) {
      //TODO - check settings about limit/restriction
      var stream;
      var localStream = null;
      $scope.localStream = null;
      $scope.initVideoCall = false;
      $scope.streamURL = null;
      $scope.peers = [];
      $scope.peersTmp = [];
      $scope.timer = null;
      $scope.isOnline = null;
      $scope.showMyCam = true;
      $scope.isStop = false;
      $scope.streamingInfo.type = 'group';
      $scope.groupLink = null;
      var stop;
      $scope.second = 60;

      //                console.log($scope.onModelRoom); 

      //peerService.createRoom();
      function resetSubStream() {
        let subStreamVideo;
        $scope.peers.map((p) => {
          subStreamVideo = document.getElementById(p.mediaId);console.log('cccc', subStreamVideo);
          subStreamVideo.srcObject = p.stream;
        });
      }
      //create request
      var createStream = function createStream(virtualRoom, room, userType) {
        // Don't start a new fight if we are already fighting
        if (angular.isDefined(stop)) return;

        VideoStream.get().then(function (s) {
          stream = s;
          localStream = s;
          peerService.init(stream);
          $scope.localStream = s.id;

          //init my cam
          $scope.peers.push({
            id: 0,
            mediaId: s.id,
            stream: stream,
            volume: 0
          });
          $scope.peersTmp.push({
            id: 0,
            mediaId: s.id,
            stream: stream,
            volume: 0
          });
          $scope.streamUrl = stream;

          //TODO - get room from onfig
          $scope.initVideoCall = true;
          $scope.showMyCam = true;
          //action to show / hide cancel button
          if (userType === 'model') {
            $scope.modelStreaming = true;
          } else {
            $scope.userStreaming = true;
          }
          //
          peerService.joinGroupRoom(virtualRoom, {
            memberId: $scope.memberId,
            modelId: $scope.modelId,
            type: 'group',
            room: room
          });

          if ($scope.userStreaming) {
            stop = $interval(function () {
              //                                    console.log('Second: ', $scope.second);
              if ($scope.second === 60) {
                $scope.second = 0;

                //                                        var vid = document.getElementById("streaming-0");
                //                                        console.log('current time: ', $scope.streamingInfo.time);
                $scope.streamingInfo.time++; //(vid.currentTime > 60) ? parseInt(vid.currentTime/60) : 0;
                sendPaidTokens();
              }
              $scope.second++;
            }, 1000);
          }
          $timeout(function () {
            var currVideo = document.getElementById('group-video-remote');
            currVideo.srcObject = $scope.streamUrl;
            currVideo.muted = true;
            currVideo.onvolumechange = function (vale) {
              for (var i = 0; i < $scope.peers.length; i++) {
                  
                  if ($scope.peers[i].stream == vale.target.currentSrc) {
                    $scope.peers[i].volume = vale.target.volume;
                  } else {
                    $scope.peers[i].volume = 0.9;
                  }
              }

              $('.group-videos-streaming video.img-responsive').each(function () {
                $(this).prop('muted', currVideo.muted);
              });
            };
          });
        }, function (err) {

          $scope.initVideoCall = false;

          $scope.error = 'No audio/video permissions. Please refresh your browser and allow the audio/video capturing.';
          alertify.message($scope.error, 20);
        });
      };

      socket.onLeaveRoom(function (data) {
        if (data.id == $scope.modelId) {
          $scope.isOnline = false;
          $scope.initVideoCall = false;
          $scope.userStreaming = false;
          $scope.modelStreaming = false;
          $scope.peers = [];
        }
        $scope.$apply();
      });
      socket.onGroupChat(function (data) {

        if ($scope.modelId == data.model) {
          if (data.virtualRoom == $scope.virtualRoom) {
            $scope.isOnline = data.online;
            $scope.groupLink = null;
          } else if (data.virtualRoom) {
            $scope.groupLink = '/members/groupchat/' + data.model + '?vr=' + data.virtualRoom;
          }
        }
      });

      //member send request to model
      //                onlineService.checkOnline(parseInt($scope.room), 'group').success(function (res) {
      //                    if (res == 1) {
      //                      $scope.isOnline = true;
      //                    } else {
      //                      $scope.isOnline = false;
      ////                      $scope.$apply();
      //                    }
      //                  });


      $scope.joinConversation = function () {
        //check user token before start connect.
        userService.get().then(function (data) {
          if (data.data) {
            if (parseInt(data.data.tokens) < 1) {
              return alertify.error('Your tokens do not enought, please buy more.');
            } else {
              createStream($scope.virtualRoom, $scope.room, 'user');
            }
          } else {
            return false;
          }
        });
      };

      //model accept to join the toom
      $scope.startConversation = function () {
        createStream($scope.virtualRoom, $scope.room, 'model');
      };

      $scope.stopStreaming = function () {
        if (localStream) {
          localStream.getVideoTracks()[0].stop();
          localStream.getAudioTracks()[0].stop();
          socket.emit('model-leave-room');
        }
        //stop streaming in the client side?
        $scope.showMyCam = false;
        //call an event to socket
        $scope.initVideoCall = false;
        $scope.isStop = true;
        if (angular.isDefined(stop)) {
          $interval.cancel(stop);
          stop = undefined;
        }
        if (appSettings.USER.role == 'model') {
          $timeout(function () {
            $window.location.href = '/models/live';
          }, 30000);
        }
        //                    console.log($scope.peers);
      };

      $scope.streamActive = 0;

      peerService.on('peer.stream', function (peer) {
        clearTimeout($scope.timer);
        //                  console.log('Client connected, adding new stream');
        if (peer.id != 0 || peer.id == 0 && $scope.modelId != $scope.memberId) {
          var temp = {
            id: peer.id,
            stream: peer.stream,
            mediaId: peer.stream.id
          };
          if (localStream.id != peer.stream.id) {
            temp.volume = 1;
        }
          $scope.peersTmp.push(temp);
        }
        if (!$scope.streamUrl) {
          $scope.streamUrl = peer.stream;
        }
        $scope.timer = setTimeout(function () {
          $scope.peers = $scope.peersTmp;
          $scope.$apply();
        }, 1000);
        setTimeout(function () {
          resetSubStream();
        }, 1500);
      });
      peerService.on('group.disconnected', function (peer) {
        //                  console.log('Client disconnected', peer);
        //check has room
        socket.emit('has-group-room', $scope.virtualRoom, function (has) {

          $scope.isOnline = has;
        });

        $scope.peers = $scope.peers.filter(function (p) {
          return p.id !== peer.id;
        });
        $scope.peersTmp = $scope.peersTmp.filter(function (p) {
          return p.id !== peer.id;
        });
      });

      //check has room
      socket.emit('has-group-room', $scope.virtualRoom, function (has) {
        //                    console.log($scope.virtualRoom, has);
        $scope.isOnline = has;
      });

      $scope.changeCam = function (key) {
        // var currVideo = document.getElementById('streaming-');
        // if ($scope.peers[key].mediaId == localStream.id) {

        //   currVideo.muted = true;
        //   //currVideo.volume - 
        // } else {

 
        //   currVideo.muted = false;
          
        //   currVideo.volume = $scope.peers[key].volume;
        // }
        $scope.streamUrl = $scope.peers[key].stream;
        // console.log('vvvvv');
        $scope.streamActive = key;
        const videoClient = document.getElementById("group-video-remote");
        videoClient.srcObject = $scope.streamUrl
      };

      $scope.userRole = appSettings.USER.role;

      /**
       * process payment per minute
       */
      function sendPaidTokens() {
        userService.sendPaidTokens($scope.modelId, 'group').then(function (response) {
          if (response.data && parseInt(response.data.spend) > 0) {
            $scope.streamingInfo.spendTokens += parseInt(response.data.spend);
            //                          $scope.streamingInfo.time += 1;
            $scope.streamingInfo.tokens = response.data.tokens;
            socket.sendModelReceiveInfo({ member: $scope.memberId, time: 1, tokens: response.data.spend });
            //                          console.log($scope.streamingInfo);
            //                          $scope.$apply();
          }
          if (response.data.success == false || parseInt(response.data.tokens) < PerformerChat.group_price) {

            alertify.warning('Your tokens do not enough, please buy more.', 60);
            socket.emit('member-missing-tokens', $scope.chatType);
            $scope.stopStreaming();
            // clearInterval(sendTokens);
            return;
          }

          //            alertify.notify(response.data.message);
        });
      }

      //loop
      //TODO Set purchase popup here
      //                    var sendTokens = setInterval(function () {
      //                      //check streaming
      //                      //call via api
      //                        if($scope.userStreaming && $scope.showMyCam && $scope.isOnline){
      //                          onlineService.checkOnline(parseInt($scope.room), 'group').success(function (res) {
      //
      //                            if (res == 1) {
      //
      //                                  sendPaidTokens();
      //
      //                            } else {
      //                             // clearInterval(sendTokens);
      //                            }
      //                          });
      //                        }
      //                    }, 60000);
      
      // show full screen
      $scope.isFullScreenMode = false;
      $scope.showFullScreen = function() {
          $scope.isFullScreenMode = true;
          $('.header').addClass('hidden');
          $('.line-menu').addClass('hidden');
          $('.footer').addClass('hidden');
          $('body').addClass('fullscreen-mode');
          $('.panel-heading').addClass('hidden');
          $('.private-chat-instruction').addClass('hidden');
          $scope.isFullScreenMode = true;
      };
      $scope.notShowFullScreen = function() {
          $scope.isFullScreenMode = false;
          $('.header').removeClass('hidden');
          $('.line-menu').removeClass('hidden');
          $('.footer').removeClass('hidden');
          $('body').removeClass('fullscreen-mode');
          $('.panel-heading').removeClass('hidden');
          $('.private-chat-instruction').removeClass('hidden');
      };
    }
  };
}]);