<?php

namespace App\Listeners;

use App\Modules\Api\Models\UserModel;
use App\Events\PodcastWasRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessMemberAfterEventWasFired {

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
   * @param  PodcastWasRegistered  $event
   * @return void
   */
  public function handle(PodcastWasRegistered $event) {
    //
    var_dump($event->id);
    //Todo check member role
    $user = UserModel::find($event->id);
    if($user->role = 'model'){
      //Check performer settings
//      $performer = PerformerModel::where();
    }
  }

}
