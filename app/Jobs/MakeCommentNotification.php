<?php

namespace App\Jobs;

use App\Modules\Api\Models\NotificationModel;
use App\Modules\Api\Models\VideoModel;
use App\Modules\Api\Models\FeedModel;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\CommentModel;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MakeCommentNotification extends Job implements ShouldQueue {

  use InteractsWithQueue,
      SerializesModels;

  protected $id;
  protected $item;
  protected $itemId;
  protected $status;
  protected $ownerId;
  protected $text;
  protected $commenter;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($item, $userdata) {
    //
    $this->id = $item->id;
    $this->item = $item->item;
    $this->itemId = $item->item_id;
    $this->text = $item->text;
    $this->status = $item->status;
    $this->ownerId = $item->owner_id;
    $this->commenter = $userdata->username;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle() {
    //
    switch ($this->item) {
      case 'video': self::commentVideoNotification();
        break;
      case 'feed': self::commentFeedNotification();
        break;
//      default : self::commentOtherNotification();
//      break;
    }
  }

  /**
   * 
   * @param object $item like item (video)
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function commentVideoNotification() {
    $video = VideoModel::select('videos.ownerId', 'u.username')
      ->join('users as u', 'u.id', '=', 'videos.ownerId')
      ->where('v.id', $this->itemId)
      ->first();
    if (!$video) {
      return;
    }
    self::addNotification($video, 'video');
  }

  /**
   * 
   * @param object $item like item (video)
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function commentFeedNotification() {
//    
//  
    $feed = FeedModel::select('u.id as ownerId', 'u.username')
      ->join('users as u', 'u.id', '=', 'posts.owner_id')
      ->where('posts.id', $this->itemId)
      ->first();
    if (!$feed) {
      return;
    }
    self::addNotification($feed);
  }

  public function addNotification($data = array(), $itemName = 'post') {
    //get all comment
    $followers = UserModel::select('users.id', 'users.username')
      ->distinct()
      ->join('comments as c', 'c.owner_id', '=', 'users.id')
      ->where('c.item_id', $this->itemId)
      ->where('c.item', CommentModel::FEED_ITEM)
      ->where('users.id', '<>', $data->ownerId)
      ->where('users.id', '<>', $this->ownerId)
      ->get();
    $postData = [];
    foreach ($followers as $follow) {
      array_push($postData, array(
        'item' => NotificationModel::COMMENT_ITEM,
        'itemId' => $this->itemId,
        'itemType' => NotificationModel::FEED_TYPE,
        'ownerId' => $follow->id,
        'content' => (count($followers) > 0) ? $this->commenter . ' also comment on ' . $data->username . ' ' . $itemName . ' .' : $this->commenter . ' comment on ' . $data->username . ' ' . $itemName . ' : ' . str_limit($this->text)
      ));
    }
    //send notify to other members 
    NotificationModel::insert($postData);
    if ($this->ownerId == $data->ownerId) {
      return;
    }

    //add model notify
    $notify = new NotificationModel;
    $notify->item = NotificationModel::COMMENT_ITEM;
    $notify->itemId = $this->itemId;
    $notify->itemType = NotificationModel::FEED_TYPE;
    $notify->ownerId = $data->ownerId;
    $notify->content = (count($followers) > 0) ? $this->commenter . ' also comment on your ' . $itemName : $this->commenter . ' comment on your ' . $itemName . ': ' . str_limit($this->text);
    if (!$notify->save()) {
      echo 'Save Error.';
    }
  }

}
