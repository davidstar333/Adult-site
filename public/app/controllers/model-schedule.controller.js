/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('modelScheduleCtrl', function ($scope, scheduleService, $timeout) {

  $scope.schedule = {
    id: null,
    nextLiveShow: '',
    monday: '',
    tuesday: '',
    wednesday: '',
    thursday: '',
    friday: '',
    saturday: '',
    sunday: ''

  };

  $scope.scheduleInit = function (schedule) {
    if (schedule) {
      $scope.schedule = schedule;
    }
  };
  $('#nextLiveShow').datetimepicker({
    debug: false,
    format: 'YYYY/MM/DD HH:mm',
    minDate: moment(),
    showTodayButton: true,
    showClear: true
  });
  ;
  $('#nextLiveShow').on('dp.change', function (e) {
    $timeout(function () {
      $scope.schedule.nextLiveShow = e.target.value;
    });

  })
  $("#monday, #tuesday, #wednesday, #thursday, #friday, #saturday, #sunday").on('dp.change', function (e) {
    $timeout(function () {
      switch (e.target.id) {
        case 'monday':
          $scope.schedule.monday = e.target.value;
          break;
        case 'tuesday':
          $scope.schedule.tuesday = e.target.value;
          break;
        case 'wednesday':
          $scope.schedule.wednesday = e.target.value;
          break;
        case 'thursday':
          $scope.schedule.thursday = e.target.value;
          break;
        case 'friday':
          $scope.schedule.friday = e.target.value;
          break;
        case 'saturday':
          $scope.schedule.saturday = e.target.value;
          break;
        case 'sunday':
          $scope.schedule.sunday = e.target.value;
          break;
      }
      if(e.target.value){
        $('#'+e.target.id).parent().find('.schedule__notavailable-btn').prop('checked', false);
      }
console.log(e.target.value);
    });
  }).datetimepicker({
    format: 'HH:mm'
  });
  $('.schedule__notavailable-btn').click(function() {
    $(this).parent().find('.input-md').val('');
  });
  $scope.submitUpdateSchedule = function (form) {
    if (form.$valid) {
      scheduleService.setSchedule($scope.schedule).then(function (data) {

        if (data.data.id) {
          alertify.success('Update successfully.');
          window.location.href = '/models/dashboard/schedule';
        } else {
          alertify.error('Update error');
          window.location.reload();
        }
      });
    }
  };


});