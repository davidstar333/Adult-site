<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class NotificationModel extends Model {

  protected $table = "notification";

  const COMMENT_ITEM = 'comment';
  const NOTIFY_ITEM = 'notify';
  const READ_STATUS = 'read';
  const UNREAD_STATUS = 'unread';
  const COMMENT_TYPE = 'comment';
  const VIDEO_TYPE = 'video';
  const FEED_TYPE = 'feed';
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';

  /**
   * 
   * @param object $user user session data
   * @return int total comment unread
   */
  public static function countUnread($user, $item = NotificationModel::COMMENT_ITEM) {
    return NotificationModel::where('status', NotificationModel::UNREAD_STATUS)
        ->where('ownerId', $user->id)
        ->where('item', $item)
        ->count();
  }

}
