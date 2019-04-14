'use strict';

angular.module('matroshkiApp')
.directive('mPrivateChatVideo', ['appSettings', '$timeout', '$interval', 'socket', 'VideoStream', 'peerService', '$sce', 'userService', 'onlineService', function(appSettings, $timeout, $interval, socket, VideoStream, peerService, $sce, userService, onlineService) {
  return {
    restrict: 'AE',
    templateUrl: appSettings.BASE_URL + 'app/views/partials/private-chat-video-widget.html',
    scope: {
      modelId: '=modelId',
      memberId: '=memberId',
      room: '@',
      virtualRoom: '@',
      streamingInfo : "=ngModel"
    },
    controller: function($scope, socket, userService, PerformerChat, $timeout, $window) {
      //TODO - check settings about limit/restriction
      var stream;
      var localStream = null;
      $scope.initVideoCall = false;
      $scope.streamURL = null;
      $scope.showMyCam = true;
      $scope.streamingInfo.type = 'private';
      $scope.streamingInfo.hasRoom = true;
      $scope.streamingInfo.removeMyRoom = false;
      $scope.accept = false;
      $scope.deny = false;
      var stop;
      $scope.second = 60;

      //create request
      var createStream = function(virtualRoom, room, userType) {
        VideoStream.get()
        .then(function (s) {
          localStream = s;
          stream = s;
          peerService.init(stream);
          //TODO - get room from onfig
          $scope.initVideoCall = true;
          //
          peerService.joinRoom(virtualRoom, {
            memberId: $scope.memberId,
            modelId: $scope.modelId,
            room: room
          });
          $scope.showMyCam = true;
          $timeout(function(){
              if($scope.hasRoom){
                //action to show / hide cancel button
                
              }
          }, 3000);
          if (userType === 'model') {
                  $scope.modelStreaming = true;
          }else{
            $scope.userStreaming = true;
          }
        }, function (err) {
          // $scope.initVideoCall = false;
          // $scope.error = 'No audio/video permissions. Please refresh your browser and allow the audio/video capturing.';
          // alertify.error($scope.error);

         //  //Comment this code for future using
         //  var nosignalElement = document.getElementById("nosignal");
         //   let context = nosignalElement.getContext('2d');
         //  setContext();
         //  function setContext()
         //  {
         //    let base_image = new Image();
         //    base_image.src = 'https://dev.bestpsychicsource.com/images/logo1.png';
         //    base_image.onload = function(){
         //      context.drawImage(base_image, base_image.width, base_image.height);
         //    }
         //  }
          
         // if (!nosignalElement.captureStream) {
         //   alertify.alert("You need Firefox 41, and set canvas.capturestream.enabled to true in about:config");
         //   return false;
         // }
         
         //  var captureStream = nosignalElement.captureStream(25);

         //  localStream = captureStream;
         //  stream = captureStream;
         //  peerService.init(stream);
         //  stream = URL.createObjectURL(stream);
         //  //TODO - get room from onfig
         //  $scope.initVideoCall = true;

         //  peerService.joinRoom(virtualRoom, {
         //    memberId: $scope.memberId,
         //    modelId: $scope.modelId,
         //    room: room
         //  });
         //  $scope.showMyCam = true;
         //  $timeout(function () {
         //    if ($scope.hasRoom) {
         //      //action to show / hide cancel button

         //    }
         //  }, 3000);
         //  if (userType === 'model') {
         //    $scope.modelStreaming = true;
         //  } else {
         //    $scope.userStreaming = true;
         //  }
        });
      };

      //member send request to model
      $scope.sendCallRequest = function () {
        socket.emit('checkOnline', $scope.modelId.toString(), function(data) {
          if(!data.isOnline) {
            return alertify.error('Model is now offline');
          }
          //check user token before start connect.
          userService.get().then(function (data) {
            if (data.data) {
              if(parseInt(data.data.tokens) < 1){
                return alertify.error('Credit is finished and chat will end', 6, function() {
                  return $window.location.href = '/';
                })
              }else{
                  createStream($scope.virtualRoom, $scope.room, 'user');
                  $timeout(function (){
                      if(!$scope.accept && !$scope.deny){
                          alertify.warning('Has no response from model, please connect with another model', 60);
                      }
                  }, 30000);
              }
              
            } else {
              return false;
            }
          });
        });
      };

      //model accept to join the toom
      $scope.acceptRequest = function() {
        createStream($scope.virtualRoom, $scope.room, 'model');
      };

      $scope.stopStreaming = function() {
        if(localStream){
            localStream.getVideoTracks()[0].stop();
            localStream.getAudioTracks()[0].stop();
            if (appSettings.USER && appSettings.USER.role == 'member') {
              socket.emit('stop-video-request', 
              { 
                data: {
                  modelId: $scope.modelId,
                } 
              });
            }
            
            socket.emit('model-leave-room');
        }
        //stop streaming in the client side?
        $scope.showMyCam = false;
        if (angular.isDefined(stop)) {
            $interval.cancel(stop);
            stop = undefined;
        }
        //call an event to socket
        $scope.streamingInfo.removeMyRoom = true;
        if(appSettings.USER.role == 'model'){
            $timeout(function (){
                $window.location.href = '/models/live';
            }, 5000);
        }else{
          $timeout(function (){
              location.reload();
          }, 5000);          
        }
        
      };
      
      //room has removed
        socket.on('room-has-removed', function (data){
            $scope.streamingInfo.hasRoom = false;
            alertify.message('Chat will end now', 30);
            if(appSettings.USER.role == 'model'){
                $timeout(function (){
                    $window.location.href = '/models/live';
                }, 6000);
            }else{
                $timeout(function (){
                    $window.location.href = '/';
                }, 6000);
            }
        });

      $scope.peers = [];
      $scope.streamActive = 0;
      $scope.streamingInfo.status = 'inactive';
      peerService.on('peer.stream', function (peer) {
          
          $scope.accept = true;
        $scope.streamingInfo.status = 'active';
        $scope.peers.push({
          id: peer.id,
          stream: peer.stream
        });
        if (!$scope.streamUrl) {
          $scope.streamUrl = peer.stream;
          const remoteVideo = document.getElementById("private-video-remote");
          remoteVideo.srcObject = peer.stream;
        }
        if($scope.userStreaming){
            stop = $interval(function () {

                if($scope.second === 60){
                    $scope.second = 0;
                    var vid = document.getElementById("private-video-client");
                    $scope.streamingInfo.time++; //(vid.currentTime > 60) ? parseInt(vid.currentTime/60) : 0;
                    sendPaidTokens();
                }
                $scope.second++;
            }, 1000);
        }
      });
      
      socket.on('model-denial-request', function (){
        alertify.message('Model has denied your request.', 50);
        $scope.deny = true;
      });

      peerService.on('peer.disconnected', function (peer) {
//          console.log('User disconnected', peer);
          $scope.streamingInfo.hasRoom = false;
          $scope.streamingInfo.message = 'Broastcat has been removed.';
          $scope.stopStreaming();
//          console.log('stop peer', peer);
//          $scope.streamingInfo.status = 'inactive';
//        $scope.peers = $scope.peers.filter(function (p) {
//          return p.id !== peer.id;
//        });
            $scope.peers = {};
      });
      socket.emit('has-video-call', $scope.virtualRoom, function(has) {
        
            if (!has && appSettings.USER && appSettings.USER.role == 'model') {
              $scope.streamingInfo.hasRoom = false;
            }
        });
      

      $scope.streamUrl = null;
      $scope.changeCam = function (key) {
        $scope.streamUrl = $scope.peers[key].stream;
        $scope.streamActive = key;
      };

      $scope.getLocalVideo = function () {
        const videoClient = document.getElementById("private-video-client");
        videoClient.srcObject = stream;
        // return $sce.trustAsResourceUrl(stream);
      };
      

      $scope.userRole = appSettings.USER.role;
      
      /**
        * process payment per minute
        */
       function sendPaidTokens() {
           userService.sendPaidTokens($scope.modelId, 'private').then(function (response)
           {
             if(response.data && parseInt(response.data.spend) > 0){
                 $scope.streamingInfo.spendTokens += parseInt(response.data.spend);
                 $scope.streamingInfo.tokens = response.data.tokens;
                 socket.sendModelReceiveInfo({time: 1, tokens: response.data.spend});
             }
             if (response.data.success == false || parseInt(response.data.tokens) < PerformerChat.private_price) {
                socket.emit('member-missing-tokens', $scope.chatType);
                return alertify.error('Credit is finished and chat will end', 6, function() {
                  return $window.location.href = '/';
                })
             }
           });
         }

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