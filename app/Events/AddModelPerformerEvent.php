<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AddModelPerformerEvent extends Event {

  use SerializesModels;

  public $id;
  public $sex;
  public $birthdate;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($user) {
    //
    $this->id = $user->id;
    $this->sex = $user->gender;
    $this->birthdate = $user->birthdate;
  }

  /**
   * Get the channels the event should be broadcast on.
   *
   * @return array
   */
  public function broadcastOn() {
    return ['PerformerSettingAction'];
  }

}
