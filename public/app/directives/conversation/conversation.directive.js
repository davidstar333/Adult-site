/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('matroshkiApp').directive('xcConversation', function() {
  return {
    restrict: 'E',
    templateUrl: '/app/directives/conversation/conversation.html',
    scope: {
      socketOptions: '=',
      options: '='
    },
    link: function(scope, element) {
      console.log(scope);
      if(!scope.options && !scope.options.room) {
        console.log('Please give a room paramater in options');
        return false;
      }
      var socketOptions = scope.socketOptions || {};
      var options = scope.options || {};
      var roomid = options.room;

      function captureUserMedia(callback, failure_callback) {
        var videosContainer = document.getElementById('video-container');
        var video = document.createElement('video');
        
        video.setAttribute('controls', 'true');
        getUserMedia({
            video: video,
            onsuccess: function(stream) {
                video.setAttribute('muted', true);
                video.setAttribute('class', 'img-responsive');
                /*var parent = angular.element(videosContainer).closest('.video-main');*/
                /*var mediaElement = getMediaElement(video, {
                    width: angular.element(videosContainer).actual('width'),
                    buttons: ['mute-audio', 'mute-video', 'full-screen', 'volume-slider']
                });*/
                //mediaElement.toggle('mute-audio');
                videosContainer.insertBefore(video, videosContainer.firstChild);
                callback && callback(stream);
            },
            onerror: function() {
                alert('unable to get access to your webcam');
                failure_callback && failure_callback();
            }
        });
      }

      var getUnique = function(videoSrc) {
        return videoSrc.split('/').pop();
      }
      
      var conferenceArgument = {
        onRemoteStream: function(media) {
          console.log(media);
          var videoUnique = getUnique(media.video.currentSrc);
          var video = {
            _id : videoUnique,
            video : media.video
          };
          scope.videos.push(video);
          scope.$apply();
        },
        onRemoteStreamEnded: function(stream, video) {
            var videoUnique = getUnique(video.currentSrc);
            var index = _.findIndex(scope.videos, function(v){
              return v._id === videoUnique;
            });
            scope.videos.splice(index, 1);
            scope.$apply();
        },
        onRoomFound: function(room) {
          console.log(room);
        }
      };
      var signaler = initReliableSignaler(conferenceArgument, socketOptions.url + '/conversation', {
        path: socketOptions.path,
        query: socketOptions.query
      });
      signaler.socket.on('closeRoom', function(){
        scope.online = false;
        scope.$apply();
      });
      
      conferenceArgument.openSocket = conferenceArgument.openSignalingChannel;

      var conferenceUI = conference(conferenceArgument);

      var createRoom = function(){
        signaler.createNewRoomOnServer(roomid, function() {
          conferenceUI.createRoom({
            roomToken: roomid,
            userToken: roomid,
            transmitRoomOnce: true
          });
        });
      };

      var checkStatus = function(cb){
        signaler.getRoomFromServer(roomid, function(room) {
          return cb(room);
        });
      };

      var joinRoom = function() {
        conferenceUI.joinRoom({
          roomToken: roomid,
          joinUser: roomid
        });
      };

      scope.online = true;
      scope.showBtn = true;
      scope.videos = [];
      scope.isParticipant = function() {
        return scope.options.type === 'participant';
      };
      scope.isBroadcaster = function() {
        return scope.options.type === 'broadcaster';
      };

      scope.startConversation = function() {
        captureUserMedia(function(stream){
          scope.showBtn = false;
          scope.$apply();
          conferenceArgument.attachStream = stream; 
          createRoom();
        });
      };

      scope.joinConversation = function() {
        checkStatus(function(online){
          if(online) {
            captureUserMedia(function(stream){
              scope.showBtn = false;
              scope.$apply();
              conferenceArgument.attachStream = stream; 
              joinRoom();
            });
          } else {
            scope.online = false;
            scope.$apply();
          }
        });
      };
    }
  };
})
.directive('vcVideo', function () {
  return {
    scope : {
      video : '='
    },
      restrict: 'EA',
      link: function (scope, element, attrs) {
        scope.$watch('video', function(nv) {
          if(nv) {
            element.html(nv).children('video').addClass('img-responsive');
          } else {
            element.html('');
          }
        })
      }
  };
});