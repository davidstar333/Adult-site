<?php

namespace App\Listeners;

use App\Modules\Api\Models\VideoModel;
use App\Modules\Api\Models\AttachmentModel;
use App\Events\DeleteVideo;
use App\Events\DeleteImage;
use App\Helpers\Helper as AppHelper;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessDeleteVideoAfterEventWasFired {

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
   * @param  DeleteVideo  $event
   * @return void
   */
  public function handle(DeleteVideo $events) {
    //TODO process delete video here
    //Trailer
    $trailer = AttachmentModel::find($events->trailerId);
    if ($trailer) {
      if (AppHelper::is_serialized($trailer->mediaMeta)) {
        $trailerMeta = unserialize($trailer->mediaMeta);
        $this->processDeleteVideo($trailerMeta);
      }
      $trailer->delete();
    }
    //Full Movie
    $fullMovie = AttachmentModel::find($events->fullMovieId);
    if ($fullMovie) {
      if (AppHelper::is_serialized($fullMovie->mediaMeta)) {
        $movieMeta = unserialize($fullMovie->mediaMeta);
        $this->processDeleteVideo($movieMeta);
      }
      $fullMovie->delete();
    }

    //get video poster
    \Event::fire(new DeleteImage($events->posterId));
  }

  /**
   * @param serialize $mediaMeta mediaMeta from attachment model
   * @author Phong Le <pt.hongphong@gmail.com>
   * @action Delete file
   * @return void
   * * */
  public function processDeleteVideo($mediaMeta) {
    if ($mediaMeta) {
      //get all hd video

      if (isset($mediaMeta['hd'])) {
        foreach ($mediaMeta['hd'] as $key => $media) {
          if (!is_array($media) && file_exists($media)) {
            \File::Delete($media);
          }
          //delete frame images
          else if (is_array($media)) {
            foreach ($media as $frame) {
              if (file_exists($frame)) {
                \File::Delete($frame);
              }
            }
          }
        }
      }
      //get and delete all sd video
      if (isset($mediaMeta['sd'])) {
        foreach ($mediaMeta['sd'] as $key => $media) {
          if (!is_array($media) && file_exists($media)) {
            \File::Delete($media);
          }
        }
      }
    }
  }

}
