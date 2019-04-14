<?php

namespace App\Listeners;

use App\Modules\Api\Models\AttachmentModel;
use App\Events\ConvertVideo;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessVideoAfterEventWasFired {

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
   * @param  ConvertVideo  $event
   * @return void
   */
  public function handle(ConvertVideo $event) {
    
  }

}
