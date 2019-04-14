<?php

namespace App\Events;

use App\Modules\Api\Models\PaymentTokensModel;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendTokensEvent extends Event implements ShouldBroadcast {

  use SerializesModels;

  public $tokens;
  public $modelId;
  public $userId;
  public $type;
  public $item;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($params, $user) {
    //
    $this->tokens = $params['tokens'];
    $this->modelId = $params['modelId'];
    $this->item = isset($params['options']['type']) ? $params['options']['type'] : null;
    switch ($user->role) {
      case 'model': $this->type = PaymentTokensModel::PERFORMERMEMBER;
        break;
      case 'member': $this->type = PaymentTokensModel::REFERREDMEMBER;
        break;
      default : $this->type = PaymentTokensModel::OTHERMEMBER;
        break;
    }
    $this->userId = $user->id;
  }

  /**
   * Get the channels the event should be broadcast on.
   *
   * @return array
   */
  public function broadcastOn() {
    return ['SendTokensAction'];
  }

}
