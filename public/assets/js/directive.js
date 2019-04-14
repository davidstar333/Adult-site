/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';

angular.module('matroshkiApp').directive('pwCheck', [function () {
  return {
    require: 'ngModel',
    link: function link(scope, elem, attrs, ctrl) {
      var firstPassword = '#' + attrs.pwCheck;
      elem.add(firstPassword).on('keyup', function () {
        scope.$apply(function () {
          // console.info(elem.val() === $(firstPassword).val());
          ctrl.$setValidity('pwmatch', elem.val() === $(firstPassword).val());
        });
      });
    }
  };
}]).directive('integer', function () {
  return {
    require: 'ngModel',
    link: function link(scope, elm, attrs, ctrl) {
      ctrl.$validators.integer = function (modelValue, viewValue) {
        if (ctrl.$isEmpty(modelValue)) {
          // consider empty models to be valid
          return true;
        }
        var INTEGER_REGEXP = /^\-?\d+$/;
        if (INTEGER_REGEXP.test(viewValue)) {
          // it is valid
          return true;
        }

        // it is invalid
        return false;
      };
    }
  };
}).directive('welcomeMessage', function () {
  return {
    restrict: 'AE',
    scope: {
      message: '@message'
    },
    controller: function controller($scope) {
      if ($scope.message != '') {
        alertify.message($scope.message, 20);
      }
    }
  };
}).directive('validateWebAddress', function () {
  var URL_REGEXP = /^((?:http|ftp)s?:\/\/)(?:(?:[A-Z0-9](?:[A-Z0-9-]{0,61}[A-Z0-9])?\.)+(?:[A-Z]{2,6}\.?|[A-Z0-9-]{2,}\.?)|localhost|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})(?::\d+)?(?:\/?|[\/?]\S+)$/i;
  return {
    require: 'ngModel',
    restrict: 'A',
    link: function link(scope, element, attrs, ctrl) {
      element.on("keyup", function () {
        var isValidUrl = URL_REGEXP.test(element.val());
        if (isValidUrl && element.hasClass('alert-danger') || element.val() == '') {
          element.removeClass('alert-danger');
        } else if (isValidUrl == false && !element.hasClass('alert-danger')) {
          element.addClass('alert-danger');
        }
      });
    }
  };
}).directive('welcomePopup', ['socket', 'userService', '$window', function (socket, userService, $window) {
  return {
    restrict: 'EA',
    scope: {
      inRoom: '=inRoom'
    },
    controller: function controller($scope, $timeout, $uibModal, appSettings) {

      if (!appSettings.USER && !sessionStorage.closePopup) {
        $timeout(function () {
          var autoInstance = $uibModal.open({
            animation: true,
            templateUrl: appSettings.BASE_URL + 'app/modals/register-modal/modal.html?v=' + Math.random().toString(36).slice(2),
            controller: 'RegisterInstanceCtrl',
            backdrop: 'static',
            size: 'lg welcome',
            keyboard: false
          });
          autoInstance.result.then(function (res) {});
        }, 3);
      }

      socket.on('video-chat-request', function (data) {
        //get request name
        //

        if (appSettings.USER && appSettings.USER.role == 'model' && appSettings.USER.id == data.model) {
          userService.findMember(data.from).then(function (user) {

            if (user.status == 200 && user.data.id) {
              //show messages for private request
              data.requestUrl = appSettings.BASE_URL + 'models/privatechat/' + data.from + '?roomId=' + data.room + '&vr=' + data.virtualRoom;
              data.name = user.data.firstName + ' ' + user.data.lastName;
              data.username = user.data.username;
              data.avatar = user.data.avatar;

              //show as confirm
              if (!$scope.inRoom) {

                alertify.confirm(data.name + ' send private chat request.', function () {
                  $window.location.href = data.requestUrl;
                }, function () {
                  callBackDenial(data);
                }).setting('labels', { 'ok': 'Accept', 'cancel': 'Deny' }).setHeader('Private Chat').autoCancel(25).setting('modal', false);
              } else {
                var msg = alertify.message('You just received a private call request from ' + data.name + ', click here to accept.', 25);
                msg.callback = function (isClicked) {
                  if (isClicked) $window.location.href = data.requestUrl;else callBackDenial(data);
                };
              }
            }
          });
        }
      });
      function callBackDenial(data) {
        angular.element('ul.list-user li#private-' + data.from).remove();
        var totalRequest = angular.element('.tab-content .tab-private ul.list-user li').length;

        angular.element('span#private-amount').text(totalRequest);
        socket.emit('model-denial-request', data.virtualRoom);
      }
    }
  };
}]).directive('validateEmail', function () {
  var EMAIL_REGEXP = /^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;

  return {
    require: 'ngModel',
    restrict: '',
    link: function link(scope, elm, attrs, ctrl) {
      // only apply the validator if ngModel is present and Angular has added the email validator
      if (ctrl && ctrl.$validators.email) {

        // this will overwrite the default Angular email validator
        ctrl.$validators.email = function (modelValue) {
          return ctrl.$isEmpty(modelValue) || EMAIL_REGEXP.test(modelValue);
        };
      }
    }
  };
}).directive('fallbackSrc', function () {
  var fallbackSrc = {
    link: function postLink(scope, iElement, iAttrs) {
      iElement.bind('error', function () {
        angular.element(this).attr("src", iAttrs.fallbackSrc);
      });
    }
  };
  return fallbackSrc;
}).directive('emojiInput', ['$timeout', function ($timeout) {
  return {
    restrict: 'A',
    require: 'ngModel',
    link: function link($scope, $el, $attr, ngModel) {
      $.emojiarea.path = '/lib/jquery-emojiarea-master/packs/basic/images';

      var options = $scope.$eval({ wysiwyg: true });
      var $wysiwyg = $($el[0]).emojiarea(options);
      $wysiwyg.on('change', function () {
        ngModel.$setViewValue($wysiwyg.val());
        $scope.$apply();
      });

      $('.chat-mes').on('keypress', function (e) {

        var code = e.keyCode || e.which;
        if (code == 13) {
          angular.element('#send-message').trigger('click');
          e.preventDefault();
        }
      });
      ngModel.$formatters.push(function (data) {
        // emojiarea doesn't have a proper destroy :( so we have to remove and rebuild
        $wysiwyg.siblings('.emoji-wysiwyg-editor, .emoji-button').remove();
        $timeout(function () {
          $wysiwyg.emojiarea(options);
        }, 0);
        return data;
      });
    }
  };
}]);
'use strict';

angular.module('matroshkiApp').directive('videoPlayer', ['$sce', function ($sce) {
  return {
    template: '<div><video ng-src="{{trustSrc()}}" id="streaming-{{videoId}}" autoplay  class="img-responsive" height="130px"></video></div>',
    restrict: 'E',
    replace: true,
    scope: {
      vidSrc: '@',
      showControl: '@',
      vid: '@',
      muted: '='
    },
    link: function link(scope, elem, attr) {
      console.log('Initializing video-player');
      scope.videoId = scope.vid;
      scope.isMuted = scope.muted ? 'muted' : '';
      if (scope.isMuted) {
        jQuery(elem.context.firstChild).attr('muted', true);
        elem.context.firstChild.muted = true;
      }

      scope.trustSrc = function () {
        if (!scope.vidSrc) {
          return undefined;
        }
        return $sce.trustAsResourceUrl(scope.vidSrc);
      };
      if (scope.showControl && elem.context && elem.context.firstChild) {
        elem.context.firstChild.controls = true;
      }
    }
  };
}]);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('matroshkiApp').directive('convertToNumber', function () {
  return {
    require: 'ngModel',
    link: function link(scope, element, attrs, ngModel) {
      ngModel.$parsers.push(function (val) {
        return parseInt(val);
      });
      ngModel.$formatters.push(function (val) {
        return '' + val;
      });
    }
  };
});
'use strict';

angular.module('matroshkiApp').directive('mChatText', ['appSettings', 'chatService', '_', '$uibModal', function (appSettings, chatService, _, $uibModal) {
  return {
    restrict: 'AE',
    templateUrl: appSettings.BASE_URL + 'app/views/partials/chat-text-widget.html',
    scope: {
      modelId: '=modelId',
      chatType: '@chatType',
      memberId: '@',
      roomId: '@',
      isStreaming: '@',
      streamingInfo: "=ngModel"
    },
    controller: function controller($scope, $timeout, appSettings, PerformerChat, $uibModal, socket, $sce, userService, chatService, onlineService) {
      $scope.chatPanel = 'chats';
      $scope.hightLighTab = false;
      //redirect to private chat if group_chat_allowed is no
      var intervalChecking = setInterval(function () {
        var video = $('#videos-container').find('video');
        if (video.height() && video.height() > 0) {
          $('.list-chat').height(video.height() - 100);
        }
      }, 3000);

      $scope.Performerchat = PerformerChat;
      $scope.chatMessages = [];
      $scope.lastpage = 1;
      $scope.orderBy = 'createdAt';
      $scope.sort = 'desc';
      $scope.limit = 20;
      $scope.enableLoadMore = false;
      $scope.showLoading = false;
      $scope.isShowPrivateRequest = false;
      $scope.isOffline = false;
      $scope.isShowResetMessage = false;
      $scope.isShowRemoveMessage = false;
      if (appSettings.USER && appSettings.USER.role === 'model') {
        $scope.isShowResetMessage = true;
        $scope.isShowRemoveMessage = true;
      }

      ////load messages at first time
      // chatService.findByModel({
      //   modelId: $scope.modelId,
      //   memberId: $scope.memberId || '',
      //   type: $scope.chatType,
      //   page: $scope.lastpage,
      //   orderBy: $scope.orderBy,
      //   sort: $scope.sort,
      //   limit: $scope.limit
      // }).success(function (res) {
      //   $scope.chatMessages = $scope.chatMessages.concat(res.data);
      //   //$scope.gotoAnchor($scope.chatMessages.length - 1);

      //   if (res.last_page > $scope.lastpage) {

      //     $scope.lastpage += 1;

      //     $scope.enableLoadMore = true;
      //   } else {
      //     $scope.enableLoadMore = false;
      //   }
      //   $scope.currentpage = res.current_page;

      //   //scroll to bottom
      //   $timeout(function () {
      //     $scope.$emit('new-chat-message');
      //   });
      // });

      $scope.loadPreviousMessage = function () {

        if ($scope.enableLoadMore) {
          $scope.showLoading = true;
          chatService.findByModel({
            modelId: $scope.modelId,
            memberId: $scope.memberId || '',
            type: $scope.chatType,
            page: $scope.lastpage,
            orderBy: $scope.orderBy,
            sort: $scope.sort,
            limit: $scope.limit
          }).success(function (res) {
            $scope.chatMessages = $scope.chatMessages.concat(res.data);
            $scope.showLoading = false;
            if (res.last_page > $scope.lastpage) {
              $scope.lastpage += 1;

              $scope.enableLoadMore = true;
            } else {
              $scope.enableLoadMore = false;
            }
            $scope.currentpage = res.current_page;
          });
        }
      };

      $scope.data = { text: '' };
      //        $.emoticons.define(emoticonsData);
      //        $scope.$on('emoticonsParser:selectIcon', function (event, icon) {
      //          $scope.data.text += ' ' + icon;
      //          $scope.$$phase || $scope.$apply();
      //        });

      //get my info
      //
      var myInfo = [];
      $scope.userData = appSettings.USER;

      userService.get().then(function (data) {
        if (data.data != "") {
          $scope.userData = _.clone(data.data);
          $scope.streamingInfo.tokens = data.data.tokens;
        } else {
          $scope.userData = {
            id: 0,
            username: 'guest',
            avatar: ''
          };
        }
      });

      $scope.members = {};
      $scope.guests = [];
      socket.getOnlineMembers($scope.roomId);
      socket.onlineMembers(function (data) {
        $scope.members = angular.copy(data.members);
        var mems = angular.copy($scope.members);
        // if(appSettings.USER){
        //   _.remove($scope.members, function (currentObject) {
        //     return currentObject.id == appSettings.USER.id;
        //   });
        // }else {
        //   _.remove($scope.members, function (currentObject) {
        //     return currentObject.id == appSettings.IP;
        //   });
        // }
        $scope.guests = mems.filter(function (m) {
          return m.role === 'guest';
        });
        $scope.$$phase || $scope.$apply();
      });
      socket.onModelReceiveInfo(function (data) {
        if (data.member) {
          var existed = _.find($scope.members, ['id', data.member]);
          if (existed) {
            existed.time = existed.time ? existed.time + parseInt(data.time) : parseInt(data.time);
            existed.spendTokens = existed.spendTokens ? existed.spendTokens + parseInt(data.tokens) : parseInt(data.tokens);
          }
        }
      });

      //listen event when member is online
      socket.onMemberJoin(function (data) {
        console.log('onmenberjoin', data);
        if (data && data.id != $scope.modelId) {
          //            console.log(data, $scope.members);
          var extised = _.find($scope.members, ['id', data.id]);
          if (!extised) {
            $scope.members.push(angular.copy(data));
            var mems = angular.copy($scope.members);
            $scope.guests = mems.filter(function (m) {
              return m.role === 'guest';
            });
          }
        }

        if ($scope.userData && $scope.userData.role == 'model') {
          if (data && typeof data.username != 'undefined' && $scope.chatType != 'private') {
            alertify.message(data.username + " join the room.");
          }
        }
        //TODO: get user join data via api and show on model message by userId
        //update view

        $scope.$$phase || $scope.$apply();
      });

      //listen event when member is leave
      socket.onLeaveRoom(function (data) {
        //          console.log(data, $scope.chatType);
        if ($scope.userData && $scope.userData.role == 'model' && data && data.username && $scope.chatType == 'public' || $scope.chatType == 'group') {
          alertify.message(data.username + " left the room");
        }
        if ($scope.chatType == 'private') {
          //              socket.emit('model-leave-room');
        }

        _.remove($scope.members, function (currentObject) {
          return currentObject.id === data.id;
        });
        //update view
        $scope.$$phase || $scope.$apply();
      });

      //if user is not anonymous, join to group chat
      if (!appSettings.USER) {

        if ($scope.chatType === 'private') {
          //request to join private room
          socket.emit('join-private-room', {
            modelId: $scope.modelId,
            memberId: $scope.memberId
          }, function (data) {
            //assign room id to the thread
            roomId = data.id;
          });
        } else {
          //join to public room
          var joinRoomData = {
            roomId: $scope.roomId,
            userData: $scope.userData,
            type: $scope.chatType
          };

          socket.joinRoom(joinRoomData);
        }
      } else {
        var joinRoomData = {
          roomId: $scope.roomId,
          userData: $scope.userData,
          type: $scope.chatType
        };

        socket.joinRoom(joinRoomData);
      }

      $scope.send = function (keyEvent) {
        if (keyEvent && keyEvent.keyCode === 13 || !keyEvent) {

          //allow once user inputs text only
          var text = $scope.data.text.trim();
          sendMessage(text);

          $scope.data.text = '';
        }
      };

      //send tips
      $scope.sendTip = function () {

        alertify.prompt("Enter your tips.", 10, function (evt, value) {
          if (angular.isNumber(parseInt(value)) && parseInt(value) > 0) {
            userService.sendTokens($scope.roomId, parseInt(value)).then(function (response) {
              if (response.data.success == false) {
                alertify.error(response.data.message);
                return;
              } else {
                alertify.success(response.data.message);
                sendMessage('Send ' + parseInt(value) + ' tokens');
              }
            });
          } else {
            alertify.error('Please enter a number.');
            $scope.sendTip();
          }
        });
      };

      function sendMessage(message) {
        socket.emit('checkOnline', $scope.modelId.toString(), function (data) {
          if (!data.isOnline) {
            return alertify.error('Model is now offline');
          }
          //check room id
          //TODO - wait timeout
          if (!$scope.roomId) {
            return alertify.notify('Room does not exist.', 'warning');
          }
          if (typeof message !== 'undefined' && message != '') {
            userService.checkBanNick($scope.modelId).then(function (data) {
              if (data.data.success && data.data.lock == 'no') {
                var msgId = Date.now();
                var sendObj = {
                  roomId: $scope.roomId,
                  text: message,
                  type: $scope.chatType,
                  id: msgId
                };
                if (!appSettings.USER) {
                  return alertify.alert('Warning', 'Please login to enter new message.');
                }

                //emit chat event to server
                socket.sendChatMessage(sendObj);

                //                var icon = $.emoticons.replace(message);

                $scope.chatMessages.push({ text: message, username: $scope.userData.username, createdAt: new Date(), userId: appSettings.USER.id, id: msgId });
                $scope.data.text = '';
                angular.element('.emoji-wysiwyg-editor').focus();
                $scope.$emit('new-chat-message');
              } else {
                alertify.error(data.data.message);
              }
            });
          }
        });
      }

      /**
       * @requires user is premium and premium chat only
       * @returns check and process payment for premium
       */
      if ($scope.chatType != 'public' && !appSettings.USER) {
        alertify.alert('Warning', 'Please login to join this room.');
        window.location.href = '/';
      }

      //add handler for new message from server
      socket.onReceiveChatMessage(function (data) {
        //          var icon = data.text;
        //
        //          icon = $.emoticons.replace(data.text);
        //        console.log(data.message.ownerId);
        $scope.chatMessages.push({ text: data.text, username: data.username, createdAt: data.createdAt, userId: data.message.ownerId, id: data.id });
        //calculate position and scroll to bottom
        $scope.$emit('new-chat-message');
      });
      //get send tip event
      function beep() {
        var unique = new Date().getTime();
        var snd = new Audio("/sounds/received_message.mp3?v=" + unique);
        snd.play();
      }
      socket.onReceiveTip(function (data) {
        $scope.chatMessages.push({ text: data.text, tip: 'yes', username: data.username, createdAt: data.createdAt });
        //calculate position and scroll to bottom
        $scope.$emit('new-chat-message');
        beep();
      });

      //check group and private chat init
      socket.reqPrivateChat($scope.modelId);
      socket.reqGroupChat($scope.modelId);
      $scope.banNick = function (user, index) {
        userService.addBlackList(user.username).then(function (data) {
          if (data.data.success) {
            alertify.success(data.data.message);
            _.findIndex($scope.chatMessages, function (o) {
              if (o.username == user.username) {
                o.banStatus = 'yes';
              }
            });
          } else {
            alertify.error(data.data.message);
          }
        });
      };
      $scope.unlockNick = function (user, index) {
        userService.removeBlackList(user.username).then(function (data) {
          if (data.data.success) {
            alertify.success(data.data.message);
            _.findIndex($scope.chatMessages, function (o) {
              if (o.username == user.username) {
                o.banStatus = 'no';
              }
            });
          } else {
            alertify.error(data.data.message);
          }
        });
      };

      if (appSettings.USER && $scope.modelId == appSettings.USER.id) {
        $scope.isShowPrivateRequest = true;
      }

      //TODO - move to global controller
      //this is for test only
      $scope.videoRequests = [];
      socket.on('video-chat-request', function (data) {
        //get request name
        //
        //          console.log(data);
        if ($scope.modelId == data.model) {
          userService.findMember(data.from).then(function (user) {
            if (user.status == 200 && user.data.id) {
              //show messages for private request
              data.requestUrl = appSettings.BASE_URL + 'models/privatechat/' + data.from + '?roomId=' + data.room + '&vr=' + data.virtualRoom;
              data.name = user.data.firstName + ' ' + user.data.lastName;
              data.username = user.data.username;
              data.avatar = user.data.avatar;
              data.id = user.data.id;
              var existed = _.find($scope.videoRequests, ['from', data.from]);
              if (existed) {
                existed.requestUrl = data.requestUrl;
              } else {
                $scope.videoRequests.push(data);
              }
              if ($scope.chatPanel !== 'privateChat') {
                $scope.hightLighTab = true;
              }
            }
          });
        }
      });
      socket.on('stop-video-request', function (data) {
        if ($scope.modelId == data.model) {
          _.remove($scope.videoRequests, ['from', data.from]);
        }
      });

      $scope.resetMessage = function () {
        $scope.chatMessages = [];
        socket.emit('reset-chat-message', {
          roomId: $scope.roomId
        });
      };
      socket.on('reset-chat-message', function (data) {
        $scope.chatMessages = [];
      });
      function removeMsg(msgId) {
        var msgs = angular.copy($scope.chatMessages);
        $scope.chatMessages = msgs.filter(function (item) {
          return item.id !== msgId;
        });
        $scope.$$phase || $scope.$apply();
      }
      $scope.removeMessage = function (msgId) {
        alertify.confirm("Are you sure you want to delete this message?", function () {
          removeMsg(msgId);
          socket.emit('remove-chat-message', {
            msgId: msgId
          });
        }).set('title', 'Confirm');
      };
      socket.on('remove-chat-message', function (data) {
        console.log(data);
        console.log($scope.chatMessages);
        removeMsg(data.msgId);
      });
      $scope.changeTab = function (tab) {
        $scope.chatPanel = tab;
        if ($scope.chatPanel === 'privateChat') {
          $scope.hightLighTab = false;
          reloadUsersToken();
        }
      };
      function reloadUsersToken() {
        var userIds = [];
        var members = angular.copy($scope.videoRequests);
        _.map(members, function (member) {
          userIds.push(member.from);
        });
        userService.getToken(userIds.join()).success(function (data) {
          for (var i in members) {
            var member = _.find(data, function (o) {
              return o.id === members[i].from;
            });
            $scope.videoRequests[i].tokens = member.tokens;
          }
          $scope.$$phase || $scope.$apply();
        });
      }
    }
  };
}]).directive('mChatScroll', ['$', function ($) {
  return {
    link: function link(scope, ele) {
      scope.$on('new-chat-message', function () {

        //check current scroll of the div
        //                  var height = $('.list-chat', $(ele)).outerHeight();

        //TODO - check position on scroll
        //                  if($ele.scrollTop() + $ele.innerHeight() >= $(ele)[0].scrollHeight) {
        //                    alert('end reached');
        //                  }
        //                  

        var height = $('.list-chat', $(ele)).height();
        ele.find('li').each(function (i, value) {
          height += parseInt($(this).outerHeight());
        });

        $('.list-chat', ele).animate({ scrollTop: height });
        //                  ele.animate({scrollTop: height});
      });
    }
  };
}]);

'use strict';

angular.module('matroshkiApp').directive('mPrivateChatVideo', ['appSettings', '$timeout', '$interval', 'socket', 'VideoStream', 'peerService', '$sce', 'userService', 'onlineService', function (appSettings, $timeout, $interval, socket, VideoStream, peerService, $sce, userService, onlineService) {
  return {
    restrict: 'AE',
    templateUrl: appSettings.BASE_URL + 'app/views/partials/private-chat-video-widget.html',
    scope: {
      modelId: '=modelId',
      memberId: '=memberId',
      room: '@',
      virtualRoom: '@',
      streamingInfo: "=ngModel"
    },
    controller: function controller($scope, socket, userService, PerformerChat, $timeout, $window) {
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
      var createStream = function createStream(virtualRoom, room, userType) {
        VideoStream.get().then(function (s) {
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
          $timeout(function () {
            if ($scope.hasRoom) {
              //action to show / hide cancel button

            }
          }, 3000);
          if (userType === 'model') {
            $scope.modelStreaming = true;
          } else {
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
        socket.emit('checkOnline', $scope.modelId.toString(), function (data) {
          if (!data.isOnline) {
            return alertify.error('Model is now offline');
          }
          //check user token before start connect.
          userService.get().then(function (data) {
            if (data.data) {
              if (parseInt(data.data.tokens) < 1) {
                return alertify.error('Credit is finished and chat will end', 6, function () {
                  return $window.location.href = '/';
                });
              } else {
                createStream($scope.virtualRoom, $scope.room, 'user');
                $timeout(function () {
                  if (!$scope.accept && !$scope.deny) {
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
      $scope.acceptRequest = function () {
        createStream($scope.virtualRoom, $scope.room, 'model');
      };

      $scope.stopStreaming = function () {
        if (localStream) {
          localStream.getVideoTracks()[0].stop();
          localStream.getAudioTracks()[0].stop();
          if (appSettings.USER && appSettings.USER.role == 'member') {
            socket.emit('stop-video-request', {
              data: {
                modelId: $scope.modelId
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
        if (appSettings.USER.role == 'model') {
          $timeout(function () {
            $window.location.href = '/models/live';
          }, 5000);
        } else {
          $timeout(function () {
            location.reload();
          }, 5000);
        }
      };

      //room has removed
      socket.on('room-has-removed', function (data) {
        $scope.streamingInfo.hasRoom = false;
        alertify.message('Chat will end now', 30);
        if (appSettings.USER.role == 'model') {
          $timeout(function () {
            $window.location.href = '/models/live';
          }, 6000);
        } else {
          $timeout(function () {
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
          var remoteVideo = document.getElementById("private-video-remote");
          remoteVideo.srcObject = peer.stream;
        }
        if ($scope.userStreaming) {
          stop = $interval(function () {

            if ($scope.second === 60) {
              $scope.second = 0;
              var vid = document.getElementById("private-video-client");
              $scope.streamingInfo.time++; //(vid.currentTime > 60) ? parseInt(vid.currentTime/60) : 0;
              sendPaidTokens();
            }
            $scope.second++;
          }, 1000);
        }
      });

      socket.on('model-denial-request', function () {
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
      socket.emit('has-video-call', $scope.virtualRoom, function (has) {

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
        var videoClient = document.getElementById("private-video-client");
        videoClient.srcObject = stream;
        // return $sce.trustAsResourceUrl(stream);
      };

      $scope.userRole = appSettings.USER.role;

      /**
        * process payment per minute
        */
      function sendPaidTokens() {
        userService.sendPaidTokens($scope.modelId, 'private').then(function (response) {
          if (response.data && parseInt(response.data.spend) > 0) {
            $scope.streamingInfo.spendTokens += parseInt(response.data.spend);
            $scope.streamingInfo.tokens = response.data.tokens;
            socket.sendModelReceiveInfo({ time: 1, tokens: response.data.spend });
          }
          if (response.data.success == false || parseInt(response.data.tokens) < PerformerChat.private_price) {
            socket.emit('member-missing-tokens', $scope.chatType);
            return alertify.error('Credit is finished and chat will end', 6, function () {
              return $window.location.href = '/';
            });
          }
        });
      }

      // show full screen
      $scope.isFullScreenMode = false;
      $scope.showFullScreen = function () {
        $scope.isFullScreenMode = true;
        $('.header').addClass('hidden');
        $('.line-menu').addClass('hidden');
        $('.footer').addClass('hidden');
        $('body').addClass('fullscreen-mode');
        $('.panel-heading').addClass('hidden');
        $('.private-chat-instruction').addClass('hidden');
        $scope.isFullScreenMode = true;
      };
      $scope.notShowFullScreen = function () {
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
        var subStreamVideo = void 0;
        $scope.peers.map(function (p) {
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
        var videoClient = document.getElementById("group-video-remote");
        videoClient.srcObject = $scope.streamUrl;
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
      $scope.showFullScreen = function () {
        $scope.isFullScreenMode = true;
        $('.header').addClass('hidden');
        $('.line-menu').addClass('hidden');
        $('.footer').addClass('hidden');
        $('body').addClass('fullscreen-mode');
        $('.panel-heading').addClass('hidden');
        $('.private-chat-instruction').addClass('hidden');
        $scope.isFullScreenMode = true;
      };
      $scope.notShowFullScreen = function () {
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
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
'use strict';

angular.module('matroshkiApp').directive('uploadFile', ['appSettings', 'mediaService', function (appSettings, mediaService) {

  return {
    restrict: 'AE',
    template: '<div><input type="hidden" name="myFiles" ng-model="myFiles"><div id="mulitplefileuploader">Upload</div><div id="status"></div></div>',
    require: 'ngModel',
    replace: true,
    scope: {
      myfiles: '=ngModel',
      fileName: '@',
      multiple: '@',
      showDelete: '@',
      showPreview: '@',
      allowedTypes: '@',
      mediaType: '@',
      parentId: '@',
      showDone: '@'
    },
    //      templateUrl: appSettings.BASE_URL + 'app/views/partials/editor.html',
    link: function link(scope, elem, attr, ngModel) {
      var current = [];
      //        scope.myPhotos = ngModelCtrl;
      if (!ngModel) return; // do nothing if no ng-model

      // Specify how UI should be updated
      //        ngModel.$render = function () {
      //          
      //        };
      ngModel.$render = function () {
        //          elem.html(ngModel.$viewValue || '');
      };
      var mediaType = scope.mediaType ? scope.mediaType : '';
      var parentId = scope.parentId ? scope.parentId : 0;
      var settings = {
        url: appSettings.BASE_URL + 'api/v1/upload-items?parent-id=' + parentId + '&mediaType=' + mediaType,
        method: "POST",
        allowedTypes: "jpg,png,gif,jpeg,mp4,m4v,ogg,ogv,webm",
        fileName: "myFiles",
        multiple: true,
        showDelete: true,
        showPreview: false,
        showDone: true,
        statusBarWidth: '55%',
        dragdropWidth: '55%',
        onSuccess: function onSuccess(files, data, xhr) {

          if (data.success == true) {
            //              ngModelCtrl.$viewValue = data.fileName;
            //              scope.$apply(function () {
            //                ngModelCtrl.$setViewValue(data.fileName);
            //                ngModelCtrl.$setViewValue('StackOverflow');
            //              });
            //              scope.$watch('myPhotos', function (value) {
            //                if (ngModelCtrl.$viewValue != value) {
            //                  ngModelCtrl.$setViewValue(data.fileName);
            //                  
            //                }
            //              });


            current.push(data.file.id);
            ngModel.$setViewValue(current);

            $("#status").html("<font color='green'>" + data.message + "</font>");
          } else {
            $("#status").html("<font color='red'>" + data.message + "</font>");
          }
        },
        onError: function onError(files, status, errMsg) {
          $("#status").html("<font color='red'>Upload is Failed</font>");
        },
        deleteCallback: function deleteCallback(element, data, pd) {

          if (element.file.type.indexOf('image') != -1) {
            mediaService.deleteImage(element.file.id).then(function (data) {
              if (data.data.success) {
                var index = current.indexOf(element.file.id);
                current.splice(index, 1);
                ngModel.$setViewValue(current);
                alertify.success(data.data.message);
              } else {
                alertify.error(data.data.message);
              }
            });
          } else if (element.file.type.indexOf('video') != -1) {
            mediaService.deleteVideo(element.file.id).then(function (data) {
              if (data.data.success) {
                var index = current.indexOf(element.file.id);
                current.splice(index, 1);
                ngModel.$setViewValue(current);
                alertify.success(data.data.message);
              } else {
                alertify.error(data.data.message);
              }
            });
          }
        }
      };
      $("#mulitplefileuploader").uploadFile(settings);
    }

  };
}]);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
'use strict';

angular.module('matroshkiApp').directive('multipleUpload', ['appSettings', 'mediaService', function (appSettings, mediaService) {

  return {
    restrict: 'AE',
    template: '<div><input type="hidden" name="myfiles" ng-model="myFiles"><div id="mulitplefileuploader">Upload</div><div id="status"></div></div>',
    require: 'ngModel',
    replace: true,
    scope: {
      files: '=ngModel',
      fileName: '@',
      multiple: '@',
      showDelete: '@',
      showPreview: '@',
      allowedTypes: '@',
      mediaType: '@',
      parentId: '@',
      showDone: '@',
      modelId: '@'
    },
    link: function link(scope, elem, attr, ngModel) {
      var myFiles = [];

      if (!ngModel) return; // do nothing if no ng-model

      // Specify how UI should be updated
      //        ngModel.$render = function () {
      //          
      //        };

      ngModel.$render = function () {};
      var mediaType = scope.mediaType ? scope.mediaType : '';
      var parentId = scope.parentId ? scope.parentId : null;
      var modelId = scope.modelId ? scope.modelId : null;
      var settings = {
        url: appSettings.BASE_URL + 'api/v1/upload-items?mediaType=' + mediaType + '&parent-id=' + parentId + '&model-id=' + modelId,
        method: "POST",
        allowedTypes: scope.allowedTypes,
        fileName: 'myFiles',
        multiple: scope.multiple,
        showDelete: scope.showDelete,
        showPreview: scope.showPreview,
        showDone: scope.showDone,
        statusBarWidth: '100%',
        dragdropWidth: '100%',
        onSuccess: function onSuccess(files, data, xhr, pd) {

          if (data.success == true) {

            myFiles.push(data.file);

            ngModel.$setViewValue(myFiles);
            //              alertify.success(files);
            //              console.log(pd);
            var uploadName = pd.filename[0].innerHTML;
            alertify.success(uploadName + ' ' + data.message);
            //              $("#status").html("<font color='green'>" + data.message + "</font>");
          } else {
            //              $("#status").html("<font color='red'>" + data.message + "</font>");
            alertify.error(data.message);
          }
        },
        onError: function onError(files, status, errMsg) {
          $("#status").html("<font color='red'>Upload is Failed</font>");
        },
        deleteCallback: function deleteCallback(element, data, pd) {

          if (element.file.type.indexOf('image') != -1) {
            mediaService.deleteImage(element.file.id).then(function (data) {
              if (data.data.success) {
                var index = myFiles.indexOf(element.file.id);
                myFiles.splice(index, 1);
                ngModel.$setViewValue(myFiles);
                alertify.success(data.data.message);
              } else {
                alertify.error(data.data.message);
              }
            });
          } else if (element.file.type.indexOf('video') != -1) {
            mediaService.deleteVideo(element.file.id).then(function (data) {
              if (data.data.success) {
                var index = myFiles.indexOf(element.file.id);
                myFiles.splice(index, 1);
                ngModel.$setViewValue(myFiles);
                alertify.success(data.data.message);
              } else {
                alertify.error(data.data.message);
              }
            });
          }
        }
      };
      $("#mulitplefileuploader").uploadFile(settings);
    }

  };
}]);

'use strict';
angular.module('matroshkiApp').directive('checkUserOnline', ['socket', 'userService', function (socket, userService) {
  return {
    restrict: 'A',
    scope: {
      userId: '@'
    },
    template: '<span ng-class="{\'text-warning\': !online, \'text-success\': online && !isBusy , \'text-danger\': isBusy}"><i class="fa fa-circle"></i>\n\t              <span ng-show="!online">Offline</span><span ng-show="online && !isBusy">Online</span><span ng-show="isBusy">Busy</span></span>',
    link: function link(scope) {
      userService.checkBusy(scope.userId).then(function (data) {
        if (data.data.isBusy) {
          scope.isBusy = true;
        }
      });
      socket.emit('checkOnline', scope.userId.toString(), function (data) {
        scope.online = data.isOnline;
      });
    }
  };
}]);
//# sourceMappingURL=directive.js.map
