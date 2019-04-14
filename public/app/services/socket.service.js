/* global io */
'use strict';

angular.module('matroshkiApp')
  .factory('socket',['appSettings', 'socketFactory', 'commonHelper', '$window', function(appSettings, socketFactory, commonHelper, $window) {
    // socket.io now auto-configures its connection when we ommit a connection url
    var ioSocket = io(appSettings.SOCKET_URL, {
      // Send auth token on connection, you will need to DI the Auth service above
      'query': commonHelper.obToquery({token: appSettings.TOKEN}),
      path: '/socket.io-client'
    });

    var socket = socketFactory({ ioSocket });

   socket.on('another-model-connected', function() {

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
      socket,

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
      syncUpdates(modelName, array, cb) {
        cb = cb || angular.noop;

        /**
         * Syncs item creation/updates on 'model:save'
         */
        socket.on(modelName + ':save', function (item) {
          var oldItem = _.find(array, {_id: item._id});
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
          _.remove(array, {_id: item._id});
          cb(event, item, array);
        });
      },

      /**
       * Removes listeners for a models updates on the socket
       *
       * @param modelName
       */
      unsyncUpdates(modelName) {
        socket.removeAllListeners(modelName + ':save');
        socket.removeAllListeners(modelName + ':remove');
      },

      /**
      * send new-chat-message event to server
      */
      sendChatMessage(data) {
        socket.emit('new-chat-message', data);
      },

      /**
      * event for the chat message callback
      */
      onReceiveChatMessage(cb) {
        cb = cb || angular.noop;
        socket.on('new-chat-message', cb);
      },

      /**
      * send send-tip event to server
      */
      sendTip(data) {
        socket.emit('send-tip', data);
      },

      /**
       * Event for send tip callback
       */
      onReceiveTip(cb){
        cb = cb || angular.noop;
        socket.on('send-tip', cb);
      },

      /**
       * new member join to room
       */

      joinRoom(data) {
        socket.emit('join-room', data);
      },
      joinPrivateRoom(data) {
        socket.emit('join-private-room', data);
      },

      onLeaveRoom(cb) {
        cb = cb || angular.noop;

        socket.on('leave-room', cb);
      },
      onMemberJoin(cb){
        cb = cb || angular.noop;
        //who
        //total members...
        //{ member: 2134, .... }
        socket.on('join-room', cb);
      },
      //event get list models online
      onModelOnline(cb){
        cb = cb || angular.noop;
        socket.on('model-online', cb);

      },
      //event check current model online
      getCurrentModelOnline(roomId){
        socket.emit('current-model-online', roomId);
      },
      //event get current model of room online
      onCurrentModelOnline(cb){
        cb = cb || angular.noop;
        socket.on('current-model-online', cb);

      },

      getOnlineMembers(roomId) {
        socket.emit('online-members', roomId);
      },
      onlineMembers(cb){
        cb = cb || angular.noop;
        //who
        //total members...
        //{ member: 2134, .... }
        socket.on('online-members', cb);
      },
      reqGroupChat(modelId) {
        socket.emit('get-all-group-chat', modelId);
      },
      reqPrivateChat(modelId) {
        socket.emit('model-private-status', modelId);
      },
      onGroupChat(cb){
        cb = cb || angular.noop;
        //who
        //total members...
        //{ member: 2134, .... }
        socket.on('on-group-chat', cb);
      },

      //model init public chat
      onModelInitPublicChat(cb){
          cb = cb || angular.noop();
          //online status
          socket.on('public-chat-init', cb);
      },
      getModelStreaming(roomId, modelId) {
        socket.emit('model-streaming', {room: roomId, model: modelId});
      },
      /**
       * notify with model when they receive new tokens
       */
      sendModelReceiveInfo(tokens){
          socket.emit('model-receive-info', tokens)
      },
      /**
       * model receive message
       */
      onModelReceiveInfo(cb){
        cb = cb || angular.noop();
        socket.on('model-receive-info', cb);

      },
      onModelStreaming(cb){
        cb = cb || angular.noop;
        //who
        //total members...
        //{ member: 2134, .... }
        socket.on('model-streaming', cb);
      },

      on(event, cb) {
        socket.on(event, cb);
      },

      emit(event, data, cb) {
        socket.emit(event, data, cb);
      }
    };
  }]);
