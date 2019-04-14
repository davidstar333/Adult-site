'use strict';
angular.module('matroshkiApp').directive('userOnline', ['socket', function (socket) {
    return {
      restrict: 'A',
      template: '<a href="#"><i class="fa fa-lg fa-user"></i><strong>Online:</strong>&nbsp;{{total}}</a>',
      link: function (scope) {
        scope.total = 0;
        socket.onModelOnline(function (data) {
          scope.total = data.onlineUsers.length;
          scope.$$phase || scope.$apply();
        });
      }
    };
  }]).directive('modelConnect', ['socket', function (socket) {
    return {
      restrict: 'A',
      link: function (scope) {
      }
    };
  }
])
.directive('modelOnlineId', ['socket', function (socket) {
    return {
      restrict: 'A',
      scope: {
        modelId: '@'
      },
      template: `<i class="fa fa-circle" ng-class="{'text-danger': !online, 'text-success': online}"></i>
                  <strong>Member Chat</strong>&nbsp;({{online ? 'online' : 'offline'}})`,
      link: function (scope) {
        scope.online = false;
        socket.onModelOnline(function (user) {
          scope.online = (user.onlineUsers.indexOf(parseInt(scope.modelId)) !== -1);
          scope.$$phase || scope.$apply();
        });
      }
    };
  }
]);