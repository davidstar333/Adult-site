/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


angular.module('matroshkiApp').controller('videoPopupCtrl', ['appSettings', '$scope', '$uibModalInstance', 'videoService', 'id', function (appSettings, $scope, $uibModalInstance, videoService, id) {

    $scope.bodyContent = '';
    videoService.findVideoById(id).then(function (data) {

      var player = jwplayer('video-player-popup'); // Created new video player
      player.setup({
        width: '100%',
        height: '350px',
        aspectratio: '16:9',
        image: '',
        sources: [{
            file: location.protocol + "//" + location.host + '/media/video/' + data.data.video.fullMovie,
            type: 'mp4'
          }]
      });
    });

    $scope.close = function () {
      $uibModalInstance.close();
    };
  }]);