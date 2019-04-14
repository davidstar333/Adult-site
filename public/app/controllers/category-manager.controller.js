/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('categoryManagerCtrl', ['$scope', 'categoryService', function ($scope, categoryService) {

    $scope.categories = [];
    $scope.category = {};

    categoryService.all().then(function (data) {
      $scope.categories = data.data;
    });

    $scope.addCategory = function (categoryName) {
      if (typeof categoryName == 'undefined' || categoryName == '') {
        return alertify.error('Category name is required.');

      }
      categoryService.checkName(categoryName).then(function (data) {
        if (!data.data.success) {
          return alertify.error(data.data.error);
        }
        categoryService.addNew(categoryName).then(function (data) {
          if (!data.data.success) {
            return alertify.error(data.data.error);
          }
          $scope.categories.push(data.data.category);
          alertify.success(data.data.message);
          $scope.category.name = null;
        });
      });
    };

    $scope.deleteCategory = function (index, category) {
      alertify.confirm("Are you sure you want to delete this category?",
              function () {
                categoryService.delete(category.id).then(function (data) {
                  if (!data.data.success) {
                    return alertify.error(data.data.error);
                  }
                  $scope.categories.splice(index, 1);
                  alertify.success(data.data.message);
                });
              }).set('title', 'Confirm');
    };

    $scope.updateCategory = function (index, category) {
      if (typeof category == 'undefined' || category.name == '') {
        return alertify.error('Category name is required.');

      }
      categoryService.update(category).then(function (data) {
        if (!data.data.success) {
          return alertify.error(data.data.error);
        }
        alertify.success(data.data.message);
      });

    };

  }]);