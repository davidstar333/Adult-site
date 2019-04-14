<?php

namespace App\Listeners;

use App\Events\SetReadMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\Api\Models\MessageReplyModel;

class SetReadMailAfterEventWasFired {

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
   * @param  SetReadMail  $event
   * @return void
   */
  public function handle(SetReadMail $event) {

    MessageReplyModel::select('messagereply.id')
      ->where('messagereply.conversationId', '=', $event->id)
      ->where('userId', '<>', $event->userId)
      ->update(['read' => MessageReplyModel::YES]);
  }

}
