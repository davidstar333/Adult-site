<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DeleteImage extends Event implements ShouldBroadcast {

  use SerializesModels;

  public $id;

  /**
   * Create a new event instance.
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return void
   */
  public function __construct($id) {
    //
    $this->id = $id;
  }

  /**
   * Get the channels the event should be broadcast on.
   *
   * @return array
   */
  public function broadcastOn() {
    return ['deleteImageAction'];
  }

}
