<?php

namespace App\Modules\Member\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Api\Models\PerformerModel;
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;
use DB;

class StreamingController extends Controller {

  /**
   * action when member view a model room
   */
  public function joinModelRoom($modelId, Request $req) {
    //TODO - check model is online and active video broadcast
    //TODO - check role for the member and assign the room
    $roomId = AppHelper::getRoomId($modelId, 'group');
    $loginData = AppSession::getLoginData();

    $performer = PerformerModel::select('performer.*', 'users.username', 'users.avatar', DB::raw('(select categories.name from categories where categories.id=performer.category_id) as categoryName'), DB::raw('(select countries.name from countries where countries.id = performer.country_id) as countryName'), 'state_name', 'city_name')
      ->join('users', 'users.id', '=', 'performer.user_id')
      ->where('user_id', $modelId)
      ->first();
    $memberId = ($loginData) ? $loginData->id : 0;
    return view('Member::streaming.join')->with('room', $roomId)->with('modelId', $modelId)->with('memberId', $memberId)->with('performer', $performer);//->with('schedules', $schedules)->with('videos', $videos)->with('images', $images);
  }

}
