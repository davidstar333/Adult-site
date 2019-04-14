<?php

namespace App\Listeners;

use App\Modules\Api\Models\PerformerChatModel;
use App\Events\AddModelPerformerChatEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessPerformerChatAfterEventWasFired {

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
   * @param  AddModelPerformerChatEvent  $event
   * @return void
   */
  public function handle(AddModelPerformerChatEvent $event) {
    //
    $performerChat = new PerformerChatModel;
    $performerChat->model_id = $event->id;
    if (!$performerChat->save()) {
      echo 'System error';
    }
  }

}
