/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('modelProfileCtrl', function ($scope, appSettings, userService, countryService, categoryService) {

  $scope.profile = [];
  $scope.performer = [];
  $scope.countries = [];
  $scope.states = [];
  $scope.cities = [];

  userService.get().then(function (data) {
    $scope.profile = data.data;
  });
  userService.getPerformer().then(function (data) {
    $scope.performer = data.data;
    $scope.performer.category_id = parseInt($scope.performer.category_id);
    $scope.performer.age = (parseInt($scope.performer.age) > 0 ) ? parseInt($scope.performer.age) : null;
    $scope.performer.city_id = parseInt($scope.performer.city_id);
    $scope.performer.countryId = parseInt($scope.performer.countryId);
    $scope.performer.country_id = parseInt($scope.performer.country_id);
//    $scope.performer.height = parseInt($scope.performer.height);
    $scope.performer.parentId = parseInt($scope.performer.parentId);
    $scope.performer.stateId = parseInt($scope.performer.stateId);
    $scope.performer.state_id = parseInt($scope.performer.state_id);
    $scope.performer.user_id = parseInt($scope.performer.user_id);
    $scope.performer.tokens = parseInt($scope.performer.tokens);
    
    
    if (data.data.languages != '') {
      $scope.performer.languages = data.data.languages.split(', ');
    }
    countryService.getCountries().then(function (data) {
      $scope.countries = data.data;
    });
    countryService.getStates($scope.performer.country_id).then(function (data) {
      $scope.states = data.data;
    });
    countryService.getCities($scope.performer.state_id).then(function (data) {
      $scope.cities = data.data;
    });
  });
  $scope.ages = [];

  $scope.init = function () {
    var i;
    for (i = 18; i <= 59; i++) {
      $scope.ages.push(i);
    }
    $scope.heightList = [
      {
        value: 140,
        text: '4.6 (140 cm)'
      },
      {
        value: 141,
        text: '4.6 (141 cm)'
      },
      {
        value: 142,
        text: '4.7 (142 cm)'
      },
      {
        value: 143,
        text: '4.7 (143 cm)'
      }
      ,
      {
        value: 144,
        text: '4.7 (144 cm)'
      },
      {
        value: 145,
        text: '4.8 (145 cm)'
      },
      {
        value: 146,
        text: '4.8 (146 cm)'
      },
      {
        value: 147,
        text: '4.8 (147 cm)'
      },
      {
        value: 148,
        text: '4.9 (148 cm)'
      },
      {
        value: 149,
        text: '4.9 (149 cm)'
      },
      {
        value: 150,
        text: '4.9 (150 cm)'
      },
      {
        value: 151,
        text: '5.0 (151 cm)'
      },
      {
        value: 152,
        text: '5.0 (152 cm)'
      },
      {
        value: 153,
        text: '5.0 (153 cm)'
      },
      {
        value: 154,
        text: '5.1 (154 cm)'
      },
      {
        value: 155,
        text: '5.1 (155 cm)'
      },
      {
        value: 156,
        text: '5.1 (156 cm)'
      },
      {
        value: 157,
        text: '5.1 (157 cm)'
      },
      {
        value: 158,
        text: '5.2 (158 cm)'
      },
      {
        value: 159,
        text: '5.2 (159 cm)'
      },
      {
        value: 160,
        text: '5.2 (160 cm)'
      },
      {
        value: 161,
        text: '5.3 (161 cm)'
      },
      {
        value: 162,
        text: '5.3 (162 cm)'
      },
      {
        value: 163,
        text: '5.3 (163 cm)'
      },
      {
        value: 164,
        text: '5.4 (164 cm)'
      },
      {
        value: 165,
        text: '5.4 (165 cm)'
      },
      {
        value: 166,
        text: '5.4 (166 cm)'
      },
      {
        value: 167,
        text: '5.5 (167 cm)'
      },
      {
        value: 168,
        text: '5.5 (168 cm)'
      },
      {
        value: 169,
        text: '5.5 (169 cm)'
      },
      {
        value: 170,
        text: '5.6 (170 cm)'
      },
      {
        value: 171,
        text: '5.6 (171 cm)'
      },
      {
        value: 172,
        text: '5.6 (172 cm)'
      },
      {
        value: 173,
        text: '5.7 (173 cm)'
      },
      {
        value: 174,
        text: '5.7 (174 cm)'
      },
      {
        value: 175,
        text: '5.7 (175 cm)'
      },
      {
        value: 176,
        text: '5.8 (176 cm)'
      },
      {
        value: 177,
        text: '5.8 (177 cm)'
      },
      {
        value: 178,
        text: '5.8 (178 cm)'
      },
      {
        value: 179,
        text: '5.9 (179 cm)'
      },
      {
        value: 180,
        text: '5.9 (180 cm)'
      },
      {
        value: 181,
        text: '5.9 (181 cm)'
      },
      {
        value: 182,
        text: '6.0 (182 cm)'
      },
      {
        value: 183,
        text: '6.0 (183 cm)'
      },
      {
        value: 184,
        text: '6.0 (184 cm)'
      },
      {
        value: 185,
        text: '6.1 (185 cm)'
      },
      {
        value: 186,
        text: '6.1 (186 cm)'
      },
      {
        value: 187,
        text: '6.1 (187 cm)'
      },
      {
        value: 188,
        text: '6.2 (188 cm)'
      },
      {
        value: 189,
        text: '6.2 (189 cm)'
      },
      {
        value: 190,
        text: '6.2 (190 cm)'
      },
      {
        value: 191,
        text: '6.3 (191 cm)'
      },
      {
        value: 192,
        text: '6.3 (192 cm)'
      },
      {
        value: 193,
        text: '6.3 (193 cm)'
      },
      {
        value: 194,
        text: '6.4 (194 cm)'
      },
      {
        value: 195,
        text: '6.4 (195 cm)'
      },
      {
        value: 196,
        text: '6.4 (196 cm)'
      },
      {
        value: 197,
        text: '6.5 (197 cm)'
      },
      {
        value: 198,
        text: '6.5 (198 cm)'
      },
      {
        value: 199,
        text: '6.5 (199 cm)'
      }
    ];
    $scope.publics = [
      {
        value: 'trimmed',
        text: 'Trimmed'
      },
      {
        value: 'shaved',
        text: 'Shaved'
      },
      {
        value: 'hairy',
        text: 'Hairy'
      },
      {
        value: 'no_comment',
        text: 'No Comment'
      }

    ];
    $scope.categories = [];
    $scope.selectState = 'Select a State';
    $scope.selectCity = 'Select a City';
    if (!$scope.performer.country_id) {
      $scope.selectState = 'Select a Country first';
    }
    if (!$scope.performer.state_id) {
      $scope.selectCity = 'Select s State first';
    }

    categoryService.all().then(function (data) {
      $scope.categories = data.data;
    });
  };
  $scope.init();

  $scope.changeCountry = function (countryId) {
    if (countryId) {
      $scope.selectState = 'Select a State';
    } else {
      $scope.selectState = 'Select a Country first';
    }
    countryService.getStates(countryId).then(function (data) {
      $scope.states = data.data;
    });
  };
  $scope.changeState = function (stateId) {
    if (stateId) {
      $scope.selectCity = 'Select a City';
    } else {
      $scope.selectCity = 'Select a State first';
    }
    countryService.getCities(stateId).then(function (data) {
      $scope.cities = data.data;
    });
  };

  $scope.errors = {
    state: false,
    city: false
  };

  $scope.formSubmitted = false;
  $scope.savePerformerProfile = function (form) {

    if (!$scope.performer.state_id && $scope.performer.state_name == '') {
      $scope.errors.state = true;
    } else {
      $scope.errors.state = false;
    }
    if (!$scope.performer.city_id && $scope.performer.city_name == '') {
      $scope.errors.city = true;

    } else {
      $scope.errors.city = false;
    }
    if ($scope.errors.state || $scope.errors.city) {
      return;
    }
    if (form.$valid) {
      $scope.formSubmitted = true;
      userService.updatePerformer($scope.performer, {firstName: $scope.profile.firstName, lastName: $scope.profile.lastName, status: $scope.profile.status}).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
          window.location.href = data.data.url;
        } else {
          $scope.formSubmitted = false;
          alertify.error(data.data.message);
        }
      });
    }
  };
  $scope.checkLanguage = function (tag) {
    var myRegEx = /^[a-zA-Z]+$/;
    return myRegEx.test(tag.text);
  };

});