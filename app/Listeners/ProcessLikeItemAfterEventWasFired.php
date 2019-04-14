<?php

namespace App\Listeners;

use App\Modules\Api\Models\CommentModel;
use App\Modules\Api\Models\LikeModel;
use App\Modules\Api\Models\FeedModel;
use App\Events\LikeItemEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessLikeItemAfterEventWasFired {

  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct() {
    //
  }

  /**
   * Handle the event.
   *
   * @param  LikeItemEvent  $event
   * @return void
   */
  public function handle(LikeItemEvent $event) {
    //
    $item = null;

    switch ($event->item) {
      case 'comment':
        $item = CommentModel::find($event->itemId);
        break;
      case 'feed':
        $item = FeedModel::find($event->itemId);
        break;
    }
    if (!$item) {
      return null;
    }
    if ($item) {
      $totalLikes = LikeModel::where('item_id', $event->itemId)
        ->where('item', $event->item)
        ->where('status', 'like')
        ->count();
      $item->total_likes = $totalLikes;
      if ($item->save()) {
        return $totalLikes;
      } else {
        return null;
      }
    }
  }

}
