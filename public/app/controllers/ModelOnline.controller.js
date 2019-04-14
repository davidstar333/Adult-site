'use strict';
angular.module('matroshkiApp')
.controller('modelOnlineCtrl', [
  '$scope', 'appSettings', '_', 'onlineService', 'socket',
  function ($scope, appSettings, _, onlineService, socket) {
    $scope.currentPage = 1;
    $scope.lastPage = 1;
    $scope.perPage = appSettings.LIMIT_PER_PAGE;
    $scope.orderBy = 'isStreaming';
    $scope.sort = 'desc';
    $scope.totalPages = 0;
    $scope._ = _;
    $scope.modelOnlineNull = false;
    $scope.keyword = '';
    $scope.filter = 'week';
    $scope.styleModelItem = {};
    $scope.getData = function () {
        var widthScreen = $(window).width();
        if(widthScreen > 2000){
            var widthItems = Math.floor(100/Math.floor(widthScreen/280));
            $scope.styleModelItem = {
                "width": widthItems+'%'
            };
        }
      onlineService.get({page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, keyword: $scope.keyword, filter: $scope.filter, category: $scope.categoryId}).success(function (data) {
        $scope.users = data.data;
        $scope.currentPage = data.current_page;
        $scope.totalPages = data.last_page;//Math.ceil(data.total / data.per_page);
        if (data.total == 0) {
          $scope.modelOnlineNull = true;
        } else {
          $scope.modelOnlineNull = false;
        }

      });
    };

    $scope.customSplitStringTags = function (item) {
        if (item.tags != null) {
            var arr = item.tags.split(',');
            return arr;
        }
    };

    $scope.getTopModels = function () {
      onlineService.getTopModels().success(function (data) {
        $scope.topModels = data;
      });
    };

    $scope.setPage = function (page) {
      if (page > 0 && page <= $scope.totalPages) {
        $scope.lastPage = page;
        $scope.getData();
      }
    };

    $scope.onlineInit = function (keyword, id) {
      $scope.keyword = keyword;
      $scope.categoryId = id || '';
      $scope.getData();
      $scope.getTopModels();
      // Run function every second
      setInterval($scope.getData, 30000);
    };

    $scope.setFilter = function (filter) {
      $scope.filter = filter;
      $scope.getData();
    };
    //load models in streaming page
    $scope.getModelsByCategory = function (model, category) {

      onlineService.getModelsByCategory(model, category).success(function (data)
      {
        $scope.users = data;
      });
    };

    $scope.setFavorite = function (index, id) {
      onlineService.setFavorite(id).then(function (data) {
        if (data.data.success) {
          $scope.users[index].favorite = (data.data.favorite === 'like') ? data.data.favorite : null;
        } else {
          alertify.error(data.data.message);
        }
      });
    };

    $scope.isRotate = false;

    $scope.modelRotates = function (thread) {

      onlineService.getModelRotateImages(thread.threadId).then(function (data) {

        if (data && angular.isArray(data.data)) {
          $scope.isRotate = true;

          var images = data.data;

          angular.forEach(images, function (item) {
            setTimeout(function () {
              thread.lastCaptureImage = item;
            }, 150);
          });
        }
      });

    };
  }
]);
