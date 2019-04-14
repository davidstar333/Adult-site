<?php

namespace App\Jobs;

use App\Modules\Api\Models\NotificationModel;
use App\Modules\Api\Models\VideoModel;
use App\Modules\Api\Models\FeedModel;
use App\Modules\Api\Models\CommentModel;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MakeNotification extends Job implements ShouldQueue {

  use InteractsWithQueue,
      SerializesModels;

  protected $id;
  protected $item;
  protected $itemId;
  protected $status;
  protected $ownerId;
  protected $liker;

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
    $this->status = $item->status;
    $this->ownerId = $item->owner_id;
    $this->liker = $userdata->username;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle() {
    //
    switch ($this->item) {
      case 'video': self::likeVideoNotification();
        break;
      case 'feed': self::likeFeedNotification();
        break;
      case 'comment': self::likeCommentNotification();
        break;
    }
  }

  /**
   * 
   * @param object $item like item (video)
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function likeVideoNotification() {
    $video = VideoModel::find($this->itemId);
    if (!$video || $video->ownerId == $this->ownerId) {
      return;
    }
    $notify = new NotificationModel;
    $notify->item = NotificationModel::NOTIFY_ITEM;
    $notify->itemId = $this->itemId;
    $notify->itemType = NotificationModel::VIDEO_TYPE;
    $notify->ownerId = $video->ownerId;
    $notify->content = $this->liker . ' ' . $this->status . ' your video: ' . str_limit($video->name, 20);
    if (!$notify->save()) {
      echo 'Save Error.';
    }
  }

  /**
   * 
   * @param object $item like item (feed)
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function likeFeedNotification() {
//    
//  
    $feed = FeedModel::find($this->itemId);
    if (!$feed || $feed->owner_id == $this->ownerId) {
      return;
    }
    $notify = new NotificationModel;
    $notify->item = NotificationModel::NOTIFY_ITEM;
    $notify->itemId = $this->itemId;
    $notify->itemType = NotificationModel::FEED_TYPE;
    $notify->ownerId = $feed->owner_id;
    $notify->content = $this->liker . ' ' . $this->status . ' your post: ' . str_limit($feed->title, 20);
    if (!$notify->save()) {
      echo 'Save Error.';
    }
  }

  /**
   * 
   * @param object $item like item (comment)
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function likeCommentNotification() {
    $comment = CommentModel::find($this->itemId);
    if (!$comment || $comment->owner_id == $this->ownerId) {
      return;
    }
    $notify = new NotificationModel;
    $notify->item = NotificationModel::NOTIFY_ITEM;
    $notify->itemId = $this->itemId;
    $notify->ownerId = $comment->owner_id;
    $notify->itemType = NotificationModel::COMMENT_TYPE;
    $notify->content = $this->liker . ' ' . $this->status . ' your comment: ' . str_limit($comment->text, 20);
    if (!$notify->save()) {
      echo 'Save Error.';
    }
  }

}
