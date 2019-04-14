<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Modules\Api\Models\EarningModel;
use App\Modules\Api\Models\UserModel;

class MessageCommission extends Command {

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'message';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'calculate message commission ';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle() {
    //insert earning table value from paymenttokens

    $commission = PaymentTokensModel::select('r.receivedId', 'paymenttokens.item as paymentItem', 'paymenttokens.id as paymentId', 'r.userId', 'paymenttokens.tokens')
      ->join('messagereply as r', 'r.id', '=', 'paymenttokens.itemId')
      ->where('paymenttokens.item', PaymentTokensModel::ITEM_MESSAGE)
      ->where('paymenttokens.status', PaymentTokensModel::STATUS_PROCESSING)
      ->paginate(10);
    if (count($commission) > 0) {
      foreach ($commission as $item) {
        //model commission
        $model = UserModel::find($item->receivedId);
        $model->increment('tokens', $item->tokens);
        if ($model->save()) {
          $earning = new EarningModel;
          $earning->item = $item->paymentItem;
          $earning->itemId = $item->paymentId;
          $earning->payFrom = $item->userId;
          $earning->payTo = $item->receivedId;
          $earning->tokens = $item->tokens;
          $earning->percent = 100;
          $earning->type = EarningModel::REFERREDMEMBER;
          if (!$earning->save()) {
            //TODO process error here  
            $model->decrement('tokens', $item->tokens);
            $model->save();
            continue;
          }
          //change payment status to approved
          $payment = PaymentTokensModel::find($item->paymentId);
          if ($payment) {
            $payment->status = 'approved';
            if (!$payment->save()) {
              //TODO process error here  
              $model->decrement('tokens', $item->tokens);
              $model->save();
              $earning->delete();
            }
          }
        }
      }
    }
  }

}
