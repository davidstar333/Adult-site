/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('modelVideoUploadCtrl', function ($scope, galleryService, mediaService, videoService) {

  $scope.uploadInit = function (id, modelId) {
    $scope.video = {};
    $scope.video.ownerId = modelId;
    
    $scope.video.galleryId = id;
    $scope.unitPrices = [
      {
        value: 15,
        text: '15 tokens'
      },
      {
        value: 20,
        text: '20 tokens'
      },
      {
        value: 25,
        text: '25 tokens'
      },
      {
        value: 30,
        text: '30 tokens'
      },
      {
        value: 35,
        text: '35 tokens'
      },
      {
        value: 40,
        text: '40 tokens'
      },
      {
        value: 45,
        text: '45 tokens'
      },
      {
        value: 50,
        text: '50 tokens'
      },
      {
        value: 55,
        text: '55 tokens'
      },
      {
        value: 60,
        text: '60 tokens'
      },
      {
        value: 65,
        text: '65 tokens'
      },
      {
        value: 70,
        text: '70 tokens'
      },
      {
        value: 75,
        text: '75 tokens'
      },
      {
        value: 80,
        text: '80 tokens'
      },
      {
        value: 85,
        text: '85 tokens'
      },
      {
        value: 90,
        text: '90 tokens'
      },
      {
        value: 95,
        text: '95 tokens'
      },
      {
        value: 100,
        text: '100 tokens'
      },
      {
        value: 120,
        text: '120 tokens'
      },
      {
        value: 140,
        text: '140 tokens'
      },
      {
        value: 160,
        text: '160 tokens'
      },
      {
        value: 180,
        text: '180 tokens'
      },
      {
        value: 200,
        text: '200 tokens'
      },
      {
        value: 220,
        text: '220 tokens'
      },
      {
        value: 240,
        text: '240 tokens'
      },
      {
        value: 260,
        text: '260 tokens'
      },
      {
        value: 280,
        text: '280 tokens'
      },
      {
        value: 300,
        text: '300 tokens'
      },
      {
        value: 320,
        text: '320 tokens'
      },
      {
        value: 340,
        text: '340 tokens'
      },
      {
        value: 360,
        text: '360 tokens'
      },
      {
        value: 380,
        text: '380 tokens'
      },
      {
        value: 400,
        text: '400 tokens'
      },
      {
        value: 420,
        text: '420 tokens'
      },
      {
        value: 440,
        text: '440 tokens'
      },
      {
        value: 460,
        text: '460 tokens'
      },
      {
        value: 480,
        text: '480 tokens'
      },
      {
        value: 500,
        text: '500 tokens'
      },
      {
        value: 550,
        text: '550 tokens'
      },
      {
        value: 600,
        text: '600 tokens'
      },
      {
        value: 650,
        text: '650 tokens'
      },
      {
        value: 700,
        text: '700 tokens'
      },
      {
        value: 750,
        text: '750 tokens'
      },
      {
        value: 800,
        text: '800 tokens'
      },
      {
        value: 850,
        text: '850 tokens'
      },
      {
        value: 900,
        text: '900 tokens'
      },
      {
        value: 950,
        text: '950 tokens'
      },
      {
        value: 1000,
        text: '1000 tokens'
      },
    ];
  };


  if ($('#video-poster-uploader').length > 0) {
    var posterSettings = {
      url: appSettings.BASE_URL + 'api/v1/upload-items?mediaType=poster&parent-id=0',
      method: "POST",
      allowedTypes: 'png,jpg,jpeg',
      fileName: 'myFiles',
      multiple: false,
      showDelete: true,
      showPreview: false,
      showDone: true,
      statusBarWidth: '100%',
      dragdropWidth: '100%',
      onSuccess: function (files, data, xhr)
      {

        if (data.success == true) {

          $scope.video.poster = data.file.id;
          alertify.success(data.message);
          $("#poster-status").html("");

        } else {
          // alertify.error(data.message);
          $("#poster-status").html("<font color='red'>"+data.message+"</font>");
        }

      },
      onError: function (files, status, errMsg)
      {
        $("#poster-status").html("<font color='red'>Upload is Failed</font>");
      },
      deleteCallback: function (element, data, pd) {
        mediaService.deleteImage(element.file.id).then(function (data) {
          if (data.data.success) {
            $scope.video.poster = null;
            alertify.success(data.data.message);
          }
        });
      }
    };
    $("#video-poster-uploader").uploadFile(posterSettings);
  }
  if ($('#video-trailer-uploader').length > 0) {
    var trailerSettings = {
      url: appSettings.BASE_URL + 'api/v1/upload-items?mediaType=trailer&parent-id=0',
      method: "POST",
      allowedTypes: 'mp4,m4v,ogg,ogv,webm',
      fileName: 'myFiles',
      multiple: false,
      showDelete: true,
      showPreview: false,
      showDone: true,
      statusBarWidth: '100%',
      dragdropWidth: '100%',
      onSuccess: function (files, data, xhr)
      {

        if (data.success == true) {

          $scope.video.trailer = data.file.id;
          alertify.success(data.message);
          $("#video-trailer-status").html('');

        } else {
          // alertify.error(data.message);
          $("#video-trailer-status").html("<font color='red'>"+data.message+"</font>");
        }

      },
      onError: function (files, status, errMsg)
      {
        $("#video-trailer-status").html("<font color='red'>Upload is Failed</font>");
      },
      deleteCallback: function (element, data, pd) {
        if(data.success){
          mediaService.deleteVideo(element.file.id).then(function (data1) {
            if (data1.data.success) {
              $scope.video.trailer = null;
              alertify.success(data.data.message);
            }
          });
        }
      }
    };
    $("#video-trailer-uploader").uploadFile(trailerSettings);
  }
  if ($('#video-full-movie-uploader').length > 0) {
    var fullMovieSettings = {
      url: appSettings.BASE_URL + 'api/v1/upload-items?mediaType=video&parent-id=0',
      method: "POST",
      allowedTypes: 'mp4,m4v,ogg,ogv,webm',
      fileName: 'myFiles',
      multiple: false,
      showDelete: true,
      showPreview: false,
      showDone: true,
      statusBarWidth: '100%',
      dragdropWidth: '100%',
      onSuccess: function (files, data, xhr)
      {

        if (data.success == true) {

          $scope.video.fullMovie = data.file.id;
          alertify.success(data.message);
          $("#video-full-movie-status").html('');
        } else {
          // alertify.error(data.message);
          $("#video-full-movie-status").html("<font color='red'>"+data.message+"</font>");
        }

      },
      onError: function (files, status, errMsg)
      {
        $("#video-full-movie-status").html("<font color='red'>Upload is Failed</font>");
      },
      deleteCallback: function (element, data, pd) {
        mediaService.deleteVideo(element.file.id).then(function (data) {
          if (data.data.success) {
            $scope.video.fullMovie = null;
            alertify.success(data.data.message);
          }
        });
      }
    };
    $("#video-full-movie-uploader").uploadFile(fullMovieSettings);
  }

  $scope.formSubmitted = false;
  $scope.errors = {};
  
  $scope.submitUploadVideo = function (form) {

    if (form.$valid) {
      $scope.formSubmitted = true;

        videoService.create($scope.video).then(function (data) {
            $scope.errors = {};
          if (data.data.success) {
            alertify.success(data.data.message);
            window.location.href = data.data.url;
            $scope.errors = {};
          } else {
              $scope.errors = data.data.errors;
            $scope.formSubmitted = false;
            if(data.data.message)
                alertify.alert(data.data.message).setHeader('Warning');
          }
        });
       
    }
  };
  $scope.submitUpdateVideo = function (form) {

    if (form.$valid) {

          videoService.update($scope.video).then(function (data) {
              $scope.errors = {};
            if (data.data.success) {
              alertify.success(data.data.message);
              window.location.href = data.data.url;
            } else {
                $scope.errors = data.data.errors;
                $scope.formSubmitted = false;
                if(data.data.message)
                    alertify.alert(data.data.message).setHeader('Warning');
            }
          });

    }
  };

});