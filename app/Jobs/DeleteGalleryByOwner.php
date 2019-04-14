<?php

  namespace App\Jobs;

  use App\Jobs\Job;
  use Illuminate\Queue\SerializesModels;
  use Illuminate\Queue\InteractsWithQueue;
  use Illuminate\Contracts\Queue\ShouldQueue;
  use App\Modules\Api\Models\GalleryModel;
  use App\Modules\Api\Models\VideoModel;
  use App\Jobs\deleteAttachmentByOwner;

  class DeleteGalleryByOwner extends Job implements ShouldQueue {

      use InteractsWithQueue,
          SerializesModels;

      protected $ownerId;
      protected $type;

      /**
       * Create a new job instance.
       *
       * @return void
       */
      public function __construct($ownerId, $type) {
          //
          $this->ownerId = $ownerId;
          $this->type = $type;
      }

      /**
       * Execute the job.
       *
       * @return void
       */
      public function handle() {
          //
          if ($this->type == GalleryModel::IMAGE) {
              //TODO DELETE all image gallery
              $imageGalleries = GalleryModel::where('ownerId', $this->ownerId)
                      ->where('type', GalleryModel::IMAGE);
              foreach ($imageGalleries->get() as $gallery) {
                  $job = (new deleteAttachmentByOwner($this->ownerId, GalleryModel::IMAGE, $gallery->id));
                  dispatch($job);
              }
              $imageGalleries->delete();
          }
          if ($this->type == GalleryModel::VIDEO) {

              //TODO DELETE all videos
              $videoGalleries = GalleryModel::where('ownerId', $this->ownerId)
                      ->where('type', GalleryModel::VIDEO);
              foreach ($videoGalleries->get() as $gallery) {
                  $videos = VideoModel::where('galleryId', $gallery->id);
                  foreach ($videos as $video) {
                      $job = (new deleteAttachmentByOwner($this->ownerId, GalleryModel::VIDEO, $video->id));
                      dispatch($job);
                  }
                  $videos->delete();
              }
              $videoGalleries->delete();
          }
      }

  }
  