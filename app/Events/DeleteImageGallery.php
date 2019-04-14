<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DeleteImageGallery extends Event implements ShouldBroadcast {

  use SerializesModels;

  public $id;
  public $type;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($gallery) {
    //
    $this->id = $gallery->id;
    $this->type = $gallery->type;
  }

  /**
   * Get the channels the event should be broadcast on.
   *
   * @return array
   */
  public function broadcastOn() {
    return ['deleteImageGalleryAction'];
  }

}
