angular.module('matroshkiApp').factory('VideoStream', ['$q', function (a) {
  var b;
  return {
    get: function get() {
      if (b) return a.when(b);
      var c = a.defer();
       var mandatory = {
          mandatory: {
              echoCancellation: true,
              autoGainControl: true,
              noiseSuppression: true,

              highpassFilter: true,
              typingNoiseDetection: true
            }
       };
      if(window.chrome){
       mandatory = {
          mandatory: {
              echoCancellation: true,
              googAutoGainControl: true,
              googNoiseSuppression: true,
              googHighpassFilter: true,
              googTypingNoiseDetection: true,
            }
        };
      }
       navigator.getWebcam = navigator.getUserMedia || navigator.webKitGetUserMedia || navigator.moxGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
      if (navigator.mediaDevices.getUserMedia) {
        return navigator.mediaDevices.getUserMedia({ audio: mandatory, video: true }).then(function (a) {
          b = a, c.resolve(b);
        }).catch(function (a) {
          c.reject(a);
        }), c.promise;
      }
     
      return navigator.getWebcam({
        video: !0,
        audio: mandatory
      }, function (a) {
        b = a, c.resolve(b);
      }, function (a) {
        c.reject(a);
      }), c.promise;
    }
  };
}]);