'use strict';
angular.module('matroshkiApp')
.directive('checkUserOnline', ['socket', 'userService', function (socket, userService) {
	return {
	  restrict: 'A',
	  scope: {
        userId: '@'
      },
	  template: `<span ng-class="{'text-warning': !online, 'text-success': online && !isBusy , 'text-danger': isBusy}"><i class="fa fa-circle"></i>
	              <span ng-show="!online">Offline</span><span ng-show="online && !isBusy">Online</span><span ng-show="isBusy">Busy</span></span>`,
	  link: function (scope) {
	  	userService.checkBusy(scope.userId).then(function(data) {
	  		if(data.data.isBusy) {
	  			scope.isBusy = true;
	  		}
	  	});
	    socket.emit('checkOnline', scope.userId.toString(), function(data) {
	    	scope.online = data.isOnline;
	    });
	  }
	};
}]);