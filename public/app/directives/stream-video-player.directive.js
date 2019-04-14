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
      muted:'='
    },
    link: function link(scope, elem, attr) {
      console.log('Initializing video-player');
      scope.videoId = scope.vid;
      scope.isMuted = scope.muted ? 'muted':'';
        if(scope.isMuted){
        jQuery(elem.context.firstChild).attr('muted',true);
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