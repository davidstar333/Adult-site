<?php

namespace App\Helpers;

use App\Helpers\AppJwt;

class Session {

  /**
   * set user data to session
   */
  public static function setLogin($user) {
    //TODO - config redis, mongo... for session for better performance
    if(isset($user->smallAvatar)){
        $user->avatar = $user->smallAvatar;
    }
    \Session::put('UserLogin', json_encode([
      'token' => AppJwt::create(['id' => $user->id, 'username' => $user->username, 'firstName' => $user->firstName, 'lastName' => $user->lastName, 'role' => $user->role, 'avatar' => $user->avatar]),
      'id' => $user->id,
      'firstName' => $user->firstName,
      'lastName' => $user->lastName,
      'username' => $user->username,
      'role' => $user->role,
      'premium' => $user->premium,
      'tokens' => $user->tokens,
      'email' => $user->email,
      'gender' => $user->gender,
      'avatar' => $user->avatar,
      'candies' =>$user->tokens,
      'location_id' => $user->location_id,
      'birthdate' => $user->birthdate,
      'createdAt' => $user->createdAt,
      'is_social'=> $user->is_social,
      'accountStatus' => $user->accountStatus
    ]));
  }

  public static function setAvatar($avatar) {
    $userData = Session::getLoginData();
    $userData->avatar = $avatar;
    Session::setLogin($userData);
  }

  /**
  TODO:  Set Age
  **/
  public static function setAge($birthdate) {
    $userData = Session::getLoginData();
    $userData->birthdate = $birthdate;
    Session::setLogin($userData);
  }
  /**
   * set user name after change settings
   */
  public static function setName($data){
      $userData = Session::getLoginData();
      $userData->firstName = $data->firstName;
      $userData->lastName = $data->lastName;
      Session::setLogin($userData);
  }

  /**
  TODO:  Set Age
  **/
  public static function setCandies($candies) {
    $userData = Session::getLoginData();
    $userData->candies = $candies;
    Session::setLogin($userData);
  }

  /**
   * check user is login (by checking session)
   * TODO - should check jwt token also
   * @return boolean
   */
  public static function isLogin() {
    return \Session::has('UserLogin');
  }

  /**
   *  check user is model
   */
  public static function isModel() {
    $loginData = Session::getLoginData();
    if ($loginData) {
      return ($loginData->role == 'model') ? $loginData->id : null;
    } else {
      return null;
    }
  }

  /**
   * get login data from session
   *
   * @return Object
   */
  public static function getLoginData() {
    $loginData = \Session::get('UserLogin');
    return $loginData ? json_decode($loginData) : null;
  }

  public static function getLogout() {
    \Session::forget('UserLogin');
    return redirect('/')->with('msgInfo', 'Good bye');
  }

  public static function getAdminLogout() {
    \Session::forget('UserLogin');
    return redirect('admin/login')->with('msgInfo', 'Good bye');
  }

}
