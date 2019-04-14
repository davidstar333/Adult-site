'use strict';

angular.module('matroshkiApp')
.directive('emoticonsWidget', function(appSettings) {
  return {
    restrict: 'AE',
    template: '<span>sssss</span>',
    link: function(scope, element) {
    }
  };
})
.directive('emoticonsParser', function($, emoticonsData) {
  return {
    restrict: 'A',
    replace: false,
    link: function(scope, element) {
      
      $.emoticons.define(emoticonsData);
      $(element).html($.emoticons.toString());
      $(element).on('click', '.emoticon', function(){
         var icon = $(this).html();
         scope.$emit('emoticonsParser:selectIcon', icon);
         angular.element('.choose-icon').triggerHandler('click');
         
      });
      
      $('body').click(function (){
          if(angular.element('.popover').length > 0){
          angular.element('.choose-icon').triggerHandler('click');
            }
      });
    }
  };

});