<?php

namespace App\Listeners;

use App\Modules\Api\Models\ScheduleModel;
use App\Events\AddModelScheduleEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessPerformerScheduleAfterEventWasFired {

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
   * @param  AddModelScheduleEvent  $event
   * @return void
   */
  public function handle(AddModelScheduleEvent $event) {
    //
    $schedule = new ScheduleModel;
    $schedule->modelId = $event->id;

    if (!$schedule->save()) {
      echo 'Create schedule error.';
    }
  }

}
