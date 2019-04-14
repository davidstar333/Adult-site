<?php

namespace App\Modules\Member\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;
use App\Modules\Api\Models\ChatThreadModel;
use App\Modules\Api\Models\PerformerChatModel;
use App\Modules\Api\Models\UserModel as User;

class ChatController extends Controller {

  /**
   * action when member view a model room
   */
  public function privateChat($modelId, Request $req) {
    //TODO - setup ACL instead
    $loginData = AppSession::getLoginData();

    if (!$loginData) {
      //restrict for mdoel only
      return redirect('/login');
    }

    $model = User::where('id', '=', $modelId)->where('role', '=', 'model')->first();
    if (!$model) {
      //TODO - check model is online and active video broadcast
      //TODO - check role for the member and assign the room
      //return 404 page if model is not exist
      return redirect('/404');
    }
    //get room id
    $roomId = AppHelper::getRoomId($modelId, ChatThreadModel::TYPE_PRIVATE, ['requesterId' => $loginData->id]);

    
    $modelSetting = PerformerChatModel::select('private_price')->where('model_id', $model->id)->first();
    
    $tokensPerMinute = ($modelSetting && $modelSetting->private_price > 0) ? intval($modelSetting->private_price) : intval(app('settings')->private_price);
    
    return view('Member::chat.private')
        ->with('room', $roomId)
        ->with('model', $model)
        ->with('tokensPerMinute', $tokensPerMinute)
        ->with('user', $loginData);
  }

  /**
   * action when member view a model room
   */
  public function groupChat($modelId, Request $req) {
    //TODO - setup ACL instead
    $loginData = AppSession::getLoginData();

    if (!$loginData) {
      //restrict for mdoel only
      return redirect('/login');
    }

    $model = User::where('id', '=', $modelId)->where('role', '=', User::ROLE_MODEL)->first();
    if (!$model) {
      //TODO - check model is online and active video broadcast
      //TODO - check role for the member and assign the room
      //return 404 page if model is not exist
      return redirect('/404');
    }
    $roomId = AppHelper::getRoomId($modelId, ChatThreadModel::TYPE_GROUP);
    $room = ChatThreadModel::where('ownerId', $modelId)->where('type', ChatThreadModel::TYPE_GROUP)->first();
    if(!$room){
        return redirect('404');
    }
    
    $modelSetting = PerformerChatModel::select('group_price')->where('model_id', $model->id)->first();
    $tokensPerMinute = ($modelSetting && $modelSetting->group_price > 0) ? intval($modelSetting->group_price) : intval(app('settings')->group_price);
    
    return view('Member::chat.group')
        ->with('roomId', $room->id)
        ->with('tokensPerMinute', $tokensPerMinute)
        ->with('model', $model)
        ->with('virtualRoom', $room->virtualId)
        ->with('member', $loginData);
  }

}
