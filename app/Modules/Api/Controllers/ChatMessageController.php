<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\ChatMessageModel;
use App\Modules\Api\Models\ChatThreadModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Modules\Api\Models\UserModel;
use App\Helpers\Session as AppSession;

class ChatMessageController extends Controller {

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function chatMessages(Request $req) {
    $chatData = ChatMessageModel::chatMessages($req);
    if ($chatData != NULL) {
      return $chatData;
    }
  }

  /**
   * load text message by mdoel
   */
  public function findByModel(Request $req) {
    //TODO - restrict chat message
    //for normal user, can see only his messaeg, for admin or studio can see their model messages

    $type = $req->get('type') ? $req->get('type') : 'public';
    $modelId = $req->get('modelId');
    $memberId = $req->get('memberId');

    if (!$modelId || !$memberId) {
      return ['msg' => 'Missing model!'];
    }

    //get the threaed
    if ($type === ChatThreadModel::TYPE_GROUP || $type == ChatThreadModel::TYPE_PUBLIC) {
      $thread = ChatThreadModel::where('type', '=', $type)->where('ownerId', '=', $modelId)->first();
    } else {
      //check for private group
      $thread = ChatThreadModel::where('type', '=', ChatThreadModel::TYPE_PRIVATE)
        ->where('ownerId', '=', $modelId)
        ->where('requesterId', '=', $memberId)
        ->first();
    }

    if (!$thread) {
      //no message here
      return [];
    }

    //pagination
    $page = $req->get('page') ? (int) $req->get('page') : 1;
    $take = $req->get('limit');
    $sort = $req->get('sort');
    $skip = $take * ($page - 1);

    //TODO - should have avatar
    return ChatMessageModel::select('chatmessages.id as chatId', 'chatmessages.text', 'chatmessages.type', 'chatmessages.tip', 'chatmessages.createdAt', 'u.id as userId', 'u.username',DB::raw("(SELECT IF(b.lock='yes', b.lock, 'no') FROM blacklist as b WHERE b.userId=u.id AND b.locker=t.ownerId) as banStatus"))
        ->leftJoin('users as u', 'chatmessages.ownerId', '=', 'u.id')
//        ->leftJoin('blacklist as b', 'b.userId', '=', 'u.id')
        ->join('chatthreads as t', 't.id', '=', 'chatmessages.threadId')
        ->where('threadId', '=', $thread->id)
        ->where('t.type', '=', $type)
//        ->whereRaw("u.id not in (select bl.userId from blacklist bl where locker={$modelId}) and bl.lock='yes'")
        ->orderBy('chatmessages.createdAt', 'desc')
        ->paginate($take);
          
  }
  
  /**
   * delete all chat messages
   */
  public function deleteMessages(){
      $userData = AppSession::getLoginData();
      if(!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)){
          return response()->json(array('success'=>false, 'message'=>'You do not have permission on this section.'));
      }
      
      $chatIds = Input::get('ids');
      $chatMessages = ChatMessageModel::whereIn('id', $chatIds)->delete();
      
    if ($chatMessages) {
      return response()->json(array('success' => true, 'message' => 'Chat messages was successfully deleted.'));
    }
      return response()->json(array('success' => false, 'error' => 'System error.'));
    
  }
}
