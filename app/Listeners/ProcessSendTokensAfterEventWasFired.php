<?php

namespace App\Listeners;

use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\EarningModel;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Events\SendTokensEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\Helper as AppHelper;
use DB;

class ProcessSendTokensAfterEventWasFired {

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
  public function handle(SendTokensEvent $event) {
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
