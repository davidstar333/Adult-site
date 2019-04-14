<?php

namespace App\Events;

use App\Modules\Api\Models\VideoModel;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DeleteVideo extends Event implements ShouldBroadcast {

  use SerializesModels;

  //Video id
  public $id;
  public $posterId;
  public $trailerId;
  public $fullMovieId;

  /**
   * Create a new event instance.
   * @author Phong Le <pt.hongphong@gmail.com>
   * @param object $videos videos need to delete
   * @return void
   */
  public function __construct($video) {
    //
    $this->id = $video->id;
    $this->posterId = $video->poster;
    $this->trailerId = $video->trailer;
    $this->fullMovieId = $video->fullMovie;
  }

  /**
   * Get the channels the event should be broadcast on.
   *
   * @return array
   */
  public function broadcastOn() {
    return ['deleteVideoAction'];
  }

}
