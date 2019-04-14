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
        streamingInfo : "=ngModel"
      },
      controller: function ($scope, $timeout, appSettings, PerformerChat, $uibModal, socket, $sce, userService, chatService, onlineService) {
        $scope.chatPanel = 'chats';
        $scope.hightLighTab = false;
        //redirect to private chat if group_chat_allowed is no
        var intervalChecking = setInterval(function(){
          var video = $('#videos-container').find('video');
          if(video.height() && video.height() > 0) {
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
        if(appSettings.USER && appSettings.USER.role === 'model') {
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

        $scope.data = {text: ''};
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
          const mems = angular.copy($scope.members);
          // if(appSettings.USER){
          //   _.remove($scope.members, function (currentObject) {
          //     return currentObject.id == appSettings.USER.id;
          //   });
          // }else {
          //   _.remove($scope.members, function (currentObject) {
          //     return currentObject.id == appSettings.IP;
          //   });
          // }
          $scope.guests = mems.filter(function(m) {
            return m.role === 'guest';
          });
          $scope.$$phase || $scope.$apply();
        });
         socket.onModelReceiveInfo(function (data){
            if(data.member){
                var existed = _.find($scope.members, ['id', data.member]);
                if(existed){
                    existed.time = (existed.time) ? existed.time + parseInt(data.time) : parseInt(data.time);
                    existed.spendTokens = (existed.spendTokens) ? existed.spendTokens + parseInt(data.tokens) : parseInt(data.tokens);
                }
            } 
         });

        
        //listen event when member is online
        socket.onMemberJoin(function (data) {
         console.log('onmenberjoin', data);
          if(data && data.id != $scope.modelId){
//            console.log(data, $scope.members);
            var extised = _.find($scope.members, ['id', data.id]);
            if(!extised){
                $scope.members.push(angular.copy(data));
                const mems = angular.copy($scope.members);
                $scope.guests = mems.filter(function(m) {
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
          if (($scope.userData && $scope.userData.role == 'model' && data && data.username && $scope.chatType == 'public') || $scope.chatType == 'group') {
            alertify.message(data.username + " left the room");
            
          }
          if($scope.chatType == 'private'){
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
          if ((keyEvent && keyEvent.keyCode === 13) || !keyEvent) {
              
            //allow once user inputs text only
            var text = $scope.data.text.trim();
            sendMessage(text);
            
            $scope.data.text = '';
            
          }
        };

        //send tips
        $scope.sendTip = function () {

          alertify.prompt("Enter your tips.", 10,
                  function (evt, value) {
                    if (angular.isNumber(parseInt(value)) && parseInt(value) > 0) {
                      userService.sendTokens($scope.roomId, parseInt(value)).then(function (response)
                      {
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
          socket.emit('checkOnline', $scope.modelId.toString(), function(data) {
            if(!data.isOnline) {
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
                  const msgId = Date.now();
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
                  
                  $scope.chatMessages.push({text: message, username: $scope.userData.username, createdAt: new Date(), userId: appSettings.USER.id, id: msgId});
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
          $scope.chatMessages.push({text: data.text, username: data.username, createdAt: data.createdAt, userId: data.message.ownerId, id: data.id});
          //calculate position and scroll to bottom
          $scope.$emit('new-chat-message');
        });
        //get send tip event
        function beep() {
          const unique = new Date().getTime();
          var snd = new Audio("/sounds/received_message.mp3?v=" + unique);
          snd.play();
        }
        socket.onReceiveTip(function (data) {
          $scope.chatMessages.push({text: data.text, tip: 'yes', username: data.username, createdAt: data.createdAt});
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
        
        if(appSettings.USER && $scope.modelId == appSettings.USER.id){
            $scope.isShowPrivateRequest = true;
        }
        
         //TODO - move to global controller
        //this is for test only
        $scope.videoRequests = [];
        socket.on('video-chat-request', function (data) {
          //get request name
          //
//          console.log(data);
          if($scope.modelId == data.model) {
            userService.findMember(data.from).then(function (user){
              if(user.status == 200 && user.data.id){
                //show messages for private request
                data.requestUrl = appSettings.BASE_URL + 'models/privatechat/' + data.from + '?roomId=' + data.room + '&vr=' +data.virtualRoom;
                data.name = user.data.firstName + ' ' + user.data.lastName;
                data.username = user.data.username;
                data.avatar = user.data.avatar;
                data.id = user.data.id;
                var existed = _.find($scope.videoRequests, ['from', data.from]);
                if(existed){
                    existed.requestUrl = data.requestUrl;
                }else{
                      $scope.videoRequests.push(data);
                }
                if($scope.chatPanel !== 'privateChat'){
                  $scope.hightLighTab = true;
                }
              }
            });
          }
        });
        socket.on('stop-video-request', function (data) {
          if($scope.modelId == data.model) {
            _.remove($scope.videoRequests, ['from', data.from]);
          }
        });

        $scope.resetMessage = function(){
          $scope.chatMessages = [];
          socket.emit('reset-chat-message',{
            roomId: $scope.roomId
          });
        };
        socket.on('reset-chat-message', function(data) {
          $scope.chatMessages = [];
        });
        function removeMsg(msgId){
          const msgs = angular.copy($scope.chatMessages);
          $scope.chatMessages  = msgs.filter(function(item) {
            return item.id !== msgId;
          });
          $scope.$$phase || $scope.$apply();
        }
        $scope.removeMessage = function(msgId){
          alertify.confirm("Are you sure you want to delete this message?",
          function () {
            removeMsg(msgId);
            socket.emit('remove-chat-message',{
              msgId: msgId
            });
          }).set('title', 'Confirm');
        };
        socket.on('remove-chat-message', function(data) {
          console.log(data);
          console.log($scope.chatMessages);
          removeMsg(data.msgId);
        });
        $scope.changeTab = function(tab) {
          $scope.chatPanel = tab;
          if($scope.chatPanel === 'privateChat'){
            $scope.hightLighTab = false;
            reloadUsersToken();
          }
        };
        function reloadUsersToken() {
          var userIds = [];
          const members = angular.copy($scope.videoRequests);
          _.map(members, function(member){
              userIds.push(member.from);
          });
          userService.getToken(userIds.join()).success(function(data){
            for(var i in members){
              var member = _.find(data, function(o) { return o.id === members[i].from; });
              $scope.videoRequests[i].tokens = member.tokens;
            }
            $scope.$$phase || $scope.$apply();            
          });
        }
      }
    };
  }
])
        .directive('mChatScroll', ['$', function ($) {
            return {
              link: function (scope, ele) {
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

                  $('.list-chat', ele).animate({scrollTop: height});
//                  ele.animate({scrollTop: height});
                });
              }
            };
          }]);
