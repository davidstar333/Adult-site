<?php

namespace App\Listeners;

use App\Modules\Api\Models\PaymentTokensModel;
use App\Events\SendPaidTokensEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessSendPaidTokensAfterEventWasFired {

  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct() {
//
  }

  /**
   * Handle the event.
   *
   * @param  SendTokensEvent  $event
   * @return void
   */
  public function handle(SendPaidTokensEvent $event) {
//
//save payment tokens
    $payment = new PaymentTokensModel;
    $payment->ownerId = $event->userId;
    $payment->item = $event->item;
    $payment->itemId = $event->modelId;
    $payment->modelId = $event->modelId;
    $payment->tokens = $event->tokens;
    if (!$payment->save()) {
      return false;
    }
    return true;
  }

}
