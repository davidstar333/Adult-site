/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('modelEarningCtrl', function ($scope, $timeout, earningService, appSettings) {
    $scope.timePeriod = {
        group: 'day',
        start: null,
        end: null
    };
    $scope.earnings = {};
    $scope.submitSearch = false;

    $('#timePeriodStart').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#timePeriodEnd').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false //Important! See issue #1075
    });
    $("#timePeriodStart").on("dp.change", function (e) {
        $timeout(function () {
            $scope.timePeriod.start = e.target.value;
//      $scope.timePeriod.start = $filter('date')(e.date, 'MM/dd/yyyy');
            $('#timePeriodEnd').data("DateTimePicker").minDate(e.date);
        });

    });
    $("#timePeriodEnd").on("dp.change", function (e) {
        $scope.timePeriod.end = e.target.value;
        $('#timePeriodStart').data("DateTimePicker").maxDate(e.date);
    });

    $scope.earningInit = function () {
        $scope.currentPage = 1;
        $scope.lastPage = 1;
        $scope.perPage = appSettings.LIMIT_PER_PAGE;
        $scope.orderBy = 'createdAt';
        $scope.sort = 'desc';
        $scope.pagination = 0;
        $scope.timePeriod.page = 0;
        $scope.loadMoreInfinite = false;

        earningService.findMe({page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, start: $scope.timePeriod.start, end: $scope.timePeriod.end, group: $scope.timePeriod.group}).success(function (data) {
            $scope.earnings = data.data;
            $scope.currentPage = data.current_page;
            if ($scope.lastPage < data.last_page) {
                $scope.lastPage += 1;
                $scope.loadMoreInfinite = true;
            }

        });
//    earningService.pagination($scope.timePeriod).success(function (data) {
//      $scope.pagination = data;
//    });
    };
    $scope.earningInit();

    $scope.submitFilterPeriod = function (form) {
        $scope.currentPage = 1;
        $scope.lastPage = 1;
        $scope.perPage = appSettings.LIMIT_PER_PAGE;
        $scope.orderBy = 'createdAt';
        $scope.sort = 'desc';
        $scope.pagination = 0;
        $scope.timePeriod.page = 0;
        $scope.loadMoreInfinite = false;

        if (form.$valid) {

            $scope.submitSearch = true;
            earningService.findMe({page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, start: $scope.timePeriod.start, end: $scope.timePeriod.end, group: $scope.timePeriod.group}).success(function (data) {

                $scope.earnings = data.data;
                $scope.currentPage = data.current_page;
                if ($scope.lastPage < data.last_page) {
                    $scope.lastPage += 1;
                    $scope.loadMoreInfinite = true;
                }

            });
        }
    };
    $(window).scroll(function () {
        if ($(window).scrollTop() == $(document).height() - $(window).height() && $scope.loadMoreInfinite) {
            $scope.loadMoreReport();
        }
    });
    $scope.loadMoreReport = function () {
//    earningService.findMe($scope.timePeriod, $scope.page).then(function (data) {
//      if (data.data.length > 0) {
//        $scope.earnings = $scope.earnings.concat(data.data);
//        $scope.timePeriod.page = parseInt($scope.timePeriod.page + 1);
//      } else {
//        $scope.pagination = 0;
//        $scope.loadMoreInfinite = false;
//      }
//    });
        earningService.findMe({page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, start: $scope.timePeriod.start, end: $scope.timePeriod.end, group: $scope.timePeriod.group}).success(function (data) {

            $scope.earnings = $scope.earnings.concat(data.data);
            $scope.currentPage = data.current_page;
            if ($scope.lastPage < data.last_page) {
                $scope.lastPage += 1;
                $scope.loadMoreInfinite = true;
            } else {
                $scope.loadMoreInfinite = false;
            }

        });
    };
    //return null if change group by
    $scope.changeGroup = function () {
        $scope.earnings = {};
        $scope.submitSearch = false;
        $scope.earningInit();
    };
    //show detail group by day


    $scope.showDayDetail = function (index, date) {
//    $scope.earnings[index].details = [];
//    earningService.filterByDay(date).then(function (data) {
//
//      $scope.earnings[index].details = data.data;
//
//    });
        if (typeof $scope.earnings[index].details != 'undefined' && $scope.earnings[index].details) {
            $scope.earnings[index].details = null;
            return false;
        } else {
            $scope.earnings[index].details = [];
        }
        earningService.filterByDay(date).then(function (data) {

            $scope.earnings[index].details = data.data;

        });

    };
    //Show detail by none
    $scope.showNoneDetail = function (index, earningId) {
//    $scope.earnings[index].detail = [];
//    earningService.filterByDefault(earningId).then(function (data) {
//      $scope.earnings[index].detail = data.data;
//    });
        if (typeof $scope.earnings[index].detail != 'undefined' && $scope.earnings[index].detail) {
            
            $scope.earnings[index].detail = null;
            return;
        } else {
            $scope.earnings[index].detail = [];
        }
//    

        earningService.filterByDefault(earningId).then(function (data) {
            $scope.earnings[index].detail = data.data;
        });
    };
});