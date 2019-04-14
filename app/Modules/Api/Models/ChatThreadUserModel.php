<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class ChatThreadUserModel extends Model {

  protected $table = "chatthreadusers";
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';

  public static function findByRoom($roomId) {
    $data = ChatThreadUserModel::select('chatthreadusers.id as threadUserId', 'chatthreadusers.threadId', 'users.id as userId', 'users.username', 'users.firstName', 'users.lastName')
    ->join('users', 'chatthreadusers.userId','=','users.id')
    ->where('threadId', '=', $roomId)
    ->where('users.role', '=', 'member')
    ->get();
    return $data;
  }

}
