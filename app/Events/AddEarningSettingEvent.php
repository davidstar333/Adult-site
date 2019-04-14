<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AddEarningSettingEvent extends Event {

  use SerializesModels;

  public $id;
  public $role;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($user) {
    //
    $this->id = $user->id;
    $this->role = $user->role;
  }

  /**
   * Get the channels the event should be broadcast on.
   *
   * @return array
   */
  public function broadcastOn() {
    return ['EarningSettingAction'];
  }

}
