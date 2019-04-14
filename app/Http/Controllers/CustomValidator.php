<?php

namespace App\Http\Controllers;

use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\CountryModel;
use App\Modules\Api\Models\StateModel;
use App\Modules\Api\Models\CityModel;

class CustomValidator {

  public function validatePhone($attribute, $value, $parameters, $validator) {
    if (preg_match('/^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/', $value))
      return true;

    return false;
  }

  //validate old password
  public function validateOldPassword($attribute, $value, $parameters, $validator) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return false;
    }
    return UserModel::where('id', $userData->id)
        ->where('passwordHash', md5($value))->first();
  }

  //validate country
  public function validateCountry($attribute, $value, $parameters, $validator) {

    return CountryModel::where('id', str_replace('number:', '', $value))
        ->first();
  }

  //validate state
//  public function validateState($attribute, $value, $parameters, $validator) {
//
//    return StateModel::where('id', str_replace('number:', '', $value))
//        ->first();
//  }
//
//  //validate stateID
//  public function validateStateId($attribute, $value, $parameters, $validator) {
//
//    if ($value == 0) {
//      return true;
//    }
//    return StateModel::where('id', $value)
//        ->first();
//  }
//
//  //validate city
//  public function validateCity($attribute, $value, $parameters, $validator) {
//
//    return CityModel::where('id', str_replace('number:', '', $value))
//        ->first();
//  }
//
//  //validate city
//  public function validateCityId($attribute, $value, $parameters, $validator) {
//    if ($value == 0) {
//      return true;
//    }
//    return CityModel::where('id', $value)
//        ->first();
//  }

}
