<?php

namespace App\Modules\Api\Models;

use App\Modules\Api\Models\UserModel;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper as AppHelper;
use App\Helpers\Session as AppSession;
use DB;

class MessageReplyModel extends Model {

  protected $table = "messagereply";

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  const SENT = 'sent';
  const RECEIVED = 'received';
  const TRASH = 'trash';
  const YES = 'yes';
  const NO = 'no';
  const ACTIVE = 'active';
  const DELETE = 'delete';

  /**
   * @param object $userdata user login data
   * @return int total unreal message
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public static function countUnread($user) {
    return MessageReplyModel::where('messagereply.read', MessageReplyModel::NO)
        ->where('userAction', 'not like', '%' . $user->id . '|' . MessageReplyModel::TRASH . '%')
        ->where('messagereply.receivedId', $user->id)
        ->count();
  }

}
