<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SetReadMail extends Event {

  use SerializesModels;

  public $id;
  public $userId;
  public $userOne;
  public $userTwo;
  public $read;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($message, $userData) {
    //
    $this->id = $message->id;
    $this->userOne = $message->userOne;
    $this->userTwo = $message->userTwo;
    $this->read = $message->read;
    $this->userId = $userData->id;
  }

  /**
   * Get the channels the event should be broadcast on.
   *
   * @return array
   */
  public function broadcastOn() {
    return ['SetReadMailAction'];
  }

}
