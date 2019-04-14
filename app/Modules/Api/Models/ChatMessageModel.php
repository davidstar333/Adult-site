<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessageModel extends Model {

  protected $table = "chatmessages";
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  const TIP_YES = 'yes';
  const TIP_NO = 'no';

    public static function chatMessages($params) {
  	$mesages = null;
  	if($params->role != 'model' && $params->groupChat == 'no'){
	    $mesages = ChatMessageModel::select('chatmessages.id as chatId', 'chatmessages.text', 'chatmessages.type', 'chatmessages.createdAt', 'users.id as userId', 'users.username')
	    ->leftJoin('users', 'chatmessages.ownerId','=', 'users.id')
	    ->where('threadId', '=', $params->roomId)
	    ->where('ownerId', '=', $params->userId)
	    ->orWhere('ownerId', '=', $params->roomId)
	    ->orderBy('chatmessages.createdAt', 'asc')
	    ->get();
	}else{
		$mesages = ChatMessageModel::select('chatmessages.id as chatId', 'chatmessages.text', 'chatmessages.type', 'chatmessages.createdAt', 'users.id as userId', 'users.username')
	    ->leftJoin('users', 'chatmessages.ownerId','=', 'users.id')
	    ->where('threadId', '=', $params->roomId)
	    ->orderBy('chatmessages.createdAt', 'asc')
	    ->get();
	}
    return $mesages;
  }

}
