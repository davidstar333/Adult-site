<?php

namespace App\Listeners;

use App\Modules\Api\Models\ChatThreadModel;
use App\Events\MakeChatRoomEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MakeChatRoomAfterEventWasFired {

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
   * @param  MakeChatRoom  $event
   * @return void
   */
  public function handle(MakeChatRoomEvent $event) {
    //
//    $thread = new ChatThreadModel;
//    $thread->ownerId = $event->id;
//    $thread->type = ChatThreadModel::TYPE_PUBLIC;
    $data = array(
      array(
        'ownerId' => $event->id,
        'type' => ChatThreadModel::TYPE_PUBLIC,
      ),
      array(
        'ownerId' => $event->id,
        'type' => ChatThreadModel::TYPE_GROUP,
      )
    );

    ChatThreadModel::insert($data);
  }

}
