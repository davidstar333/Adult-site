<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateExtendMember extends Event {

  use SerializesModels;

  public $id;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($member) {
    //
    $this->id = $member->id;
  }

  /**
   * Get the channels the event should be broadcast on.
   *
   * @return array
   */
  public function broadcastOn() {
    return ['updateExtendMemberAction'];
  }

}
