<?php

namespace App\Modules\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Api\Models\UserModel;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\BlackListModel;

class BlackListController extends Controller {

  /**
   * ban nick
   * @param int $id member id
   * @author Phong Le <pt.hongphong@gmail.com>
   * return response
   */
  public function addBlackList($username) {
    $userData = AppSession::getLoginData();
    if (!$userData || $userData->role != UserModel::ROLE_MODEL) {
      return Response()->json(array('success' => false, 'message' => 'You does not have permission.'));
    }
    $user = UserModel::where('username', $username)->first();
    if (!$user) {
      return Response()->json(array('success' => false, 'message' => 'User does not exist.'));
    }
    $lock = BlackListModel::where('locker', $userData->id)
      ->where('userId', $user->id)
      ->first();
    if (!$lock) {
      $lock = new BlackListModel;
      $lock->locker = $userData->id;
      $lock->userId = $user->id;
    }

    $lock->lock = BlackListModel::LOCK_YES;
    if ($lock->save()) {
      return Response()->json(array('success' => true, 'message' => 'Member was added to black list.'));
    }
    return Response()->json(array('success' => false, 'message' => 'System error.'));
  }

  /**
   * remove from black list
   * @param int $id member id
   * @author Phong Le <pt.hongphong@gmail.com>
   * return response
   */
  public function removeBlackList($username) {
    $userData = AppSession::getLoginData();
    if (!$userData || $userData->role != UserModel::ROLE_MODEL) {
      return Response()->json(array('success' => false, 'message' => 'You does not have permission.'));
    }
    $user = UserModel::where('username', $username)->first();
    if (!$user) {
      return Response()->json(array('success' => false, 'message' => 'User does not exist.'));
    }
    $lock = BlackListModel::where('locker', $userData->id)
      ->where('userId', $user->id)
      ->first();
    if (!$lock) {
      $lock = new BlackListModel;
      $lock->locker = $userData->id;
      $lock->userId = $user->id;
    }

    $lock->lock = BlackListModel::LOCK_NO;
    if ($lock->save()) {
      return Response()->json(array('success' => true, 'message' => 'Member was removed from black list.'));
    }
    return Response()->json(array('success' => false, 'message' => 'System error.'));
  }

  /**
   * check user is in black list or no
   * @param int $modelid 
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return response
   */
  public function checkBlackList($id) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(array('success' => false, 'message' => 'Please login.'));
    }

    $blackList = BlackListModel::where('locker', $id)
      ->where('userId', $userData->id)
      ->first();
    if ($blackList && $blackList->lock == BlackListModel::LOCK_YES) {
      return Response()->json(array('success' => false, 'lock' => BlackListModel::LOCK_YES, 'message' => 'Your account was banned.'));
    }
    return Response()->json(array('success' => true, 'lock' => BlackListModel::LOCK_NO));
  }

}
