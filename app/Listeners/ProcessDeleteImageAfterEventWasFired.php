<?php

namespace App\Listeners;

use App\Modules\Api\Models\AttachmentModel;
use App\Helpers\Helper as AppHelper;
use App\Events\DeleteImage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessDeleteImageAfterEventWasFired {

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
   * @param  DeleteImage  $event
   * @return void
   */
  public function handle(DeleteImage $event) {
    //
    $attachment = AttachmentModel::find($event->id);
    if ($attachment) {
      if ($attachment->mediaMeta && AppHelper::is_serialized($attachment->mediaMeta)) {
        $mediaMeta = unserialize($attachment->mediaMeta);
        foreach ($mediaMeta as $key => $media) {
          if (file_exists($media)) {
            \File::Delete($media);
          }
        }
      }
      $attachment->delete();
    }
  }

}
