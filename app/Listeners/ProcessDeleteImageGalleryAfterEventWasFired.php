<?php

namespace App\Listeners;

use App\Modules\Api\Models\AttachmentModel;
use App\Helpers\Helper as AppHelper;
use App\Events\DeleteImageGallery;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessDeleteImageGalleryAfterEventWasFired {

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
   * @param  DeleteImageGallery  $event
   * @return void
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function handle(DeleteImageGallery $event) {
    //
    $attachment = AttachmentModel::where('parent_id', $event->id)
      ->where('media_type', $event->type)
      ->get();
    foreach ($attachment as $image) {
      if (AppHelper::is_serialized($image->mediaMeta)) {
        $mediaMeta = unserialize($image->mediaMeta);
        foreach ($mediaMeta as $key => $media) {
          if (file_exists($media)) {
            \File::Delete($media);
          }
        }
      }
      $image->delete();
    }
  }

  //delete file process
  public function deleteAttachmentFile($mediaMeta) {
    
  }

}
