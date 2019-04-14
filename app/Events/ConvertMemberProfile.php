<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ConvertMemberProfile extends Event {

  use SerializesModels;

  public $path;
  public $id;
  public $username;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($profile, $path) {
    //
    $this->id = $profile->id;
    $this->username = $profile->username;
    $this->path = $path;
  }

  /**
   * Get the channels the event should be broadcast on.
   *
   * @return array
   */
  public function broadcastOn() {
    return ['ConvertMemberProfileAction'];
  }

}
