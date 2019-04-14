<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\PerformerChatModel;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\ChatThreadModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Helpers\Session as AppSession;

class PerformerChatController extends Controller {

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function getPerformerChat($role, $modelId) {
    $chatSettingData = PerformerChatModel::getPerformerChat($role, $modelId);

    if ($chatSettingData != NULL) {
      return $chatSettingData;
    }
  }

  /**
   * get default or model price setting 
   */
  public function getChatPrice($type, $id) {
    $setting = PerformerChatModel::select('private_price', 'group_price')
      ->where('model_id', $id)
      ->first();
    if (!$setting) {
      return ($type == ChatThreadModel::TYPE_GROUP) ? app('settings')->group_price : app('settings')->private_price;
    }
    if ($type == ChatThreadModel::TYPE_GROUP) {
      return ($setting->group_price > 0) ? $setting->group_price : app('settings')->group_price;
    }
    if ($type == ChatThreadModel::TYPE_PRIVATE) {
      return ($setting->private_price > 0) ? $setting->private_price : app('settings')->private_price;
    }
  }

  /*
   * Update model performerchat
   *
   */

  public function updatePerformerChat($modelId) {
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_MODEL)) {
      return Response()->json(['success' => false, 'message' => 'Please login with model role']);
    }
    if ($userData->role == UserModel::ROLE_MODEL) {
      $settings = PerformerChatModel::where('model_id', $userData->id)->first();
    } else {
      $settings = PerformerChatModel::where('model_id', $modelId)->first();
    }
    $data = Input::only('private_price', 'group_price', 'welcome_message');

    if (!$settings) {
      $settings = new PerformerChatModel;
    }

    $settings->private_price = Input::get('private_price');
    $settings->group_price = Input::get('group_price');
    $settings->welcome_message = Input::get('welcome_message');
    $settings->isCustomPrivate = Input::get('isCustomPrivate') ? Input::get('isCustomPrivate') : 0;
    $settings->isCustomGroup = Input::get('isCustomGroup') ? Input::get('isCustomGroup') : 0;
    $settings->model_id = ($userData->role = UserModel::ROLE_MODEL) ? $userData->id : $modelId;


    if ($settings->save()) {
      return Response()->json(['success' => true, 'message' => 'Your chat settings have been saved.']);
    }
    return Response()->json(['success' => false, 'message' => 'System error.']);
  }

}
