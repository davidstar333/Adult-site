<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\Api\Models\FollowingModel;
use App\Modules\Api\Models\UserModel;
use DB;

class MakeWallNotification extends Job implements ShouldQueue {

  use InteractsWithQueue,
      SerializesModels;

  public $id;
  public $ownerId;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($feed) {
    //
    $this->id = $feed->id;
    $this->ownerId = $feed->owner_id;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle() {
    //increment user wallCount item
    UserModel::whereRaw("users.id in (SELECT f.follower FROM following f WHERE f.owner_id={$this->ownerId} AND f.status='" . FollowingModel::FOLLOW . "' AND f.type='" . FollowingModel::TYPE_MODEL . "')")->update(['wallCount' => DB::raw("wallCount+1")]);
  }

}
