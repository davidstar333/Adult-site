<?php

namespace App\Events;

use App\Modules\Api\Models\AttachmentModel;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ConvertVideo extends Event implements ShouldBroadcast {

  use SerializesModels;

  public $id;

  /**
   * Create a new event instance.
   * @param Item $item
   * @return void
   */
  public function __construct(AttachmentModel $item) {
    //
    $this->id = $item->id;
  }

  /**
   * Get the channels the event should be broadcast on.
   *
   * @return array
   */
  public function broadcastOn() {
    return ['convertVideoAction'];
  }

}
