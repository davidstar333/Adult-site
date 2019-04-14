<?php

  namespace App\Jobs;

  use App\Jobs\Job;
  use Illuminate\Queue\SerializesModels;
  use Illuminate\Queue\InteractsWithQueue;
  use Illuminate\Contracts\Queue\ShouldQueue;
  use App\Modules\Api\Models\AttachmentModel;
  use App\Helpers\Helper as AppHelper;

  class deleteAttachmentByOwner extends Job implements ShouldQueue {

      use InteractsWithQueue,
          SerializesModels;

      protected $ownerId;
      protected $type;
      protected $parent_id;

      /**
       * Create a new job instance.
       *
       * @return void
       */
      public function __construct($ownerId, $type = null, $parentId = 0) {
          //
          $this->ownerId = $ownerId;
          $this->type = $type;
          $this->parent_id = $parentId;
      }

      /**
       * Execute the job.
       *
       * @return void
       */
      public function handle() {
          //
          //
          $attachment = AttachmentModel::where('owner_id', $this->ownerId)
                  ->where('media_type', $this->type)
                  ->where('parent_id', $this->parent_id);
          foreach ($attachment->get() as $item) {
              if (AppHelper::is_serialized($item->mediaMeta)) {
                  $avatar = unserialize($item->mediaMeta);
                  foreach ($avatar as $key => $value) {
                      if (file_exists(public_path($value))) {
                          \File::Delete(public_path($value));
                      }
                  }
              }
          }
          $attachment->delete();
      }

  }
  