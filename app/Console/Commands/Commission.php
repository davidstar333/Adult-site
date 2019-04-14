<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\PaymentTokensModel;
use DB;

class Commission extends Command {

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'commission';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Calculate commission percent';

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
    //get model
    $users = UserModel::where('autoApprovePayment', 1)->get();
    $userIds = [];
    foreach($users as $user){
      $userIds[] = $user->id;
    }
    $payment = PaymentTokensModel::where('status', PaymentTokensModel::STATUS_PROCESSING)
      ->whereIn('modelId', $userIds)
      ->paginate(100);
    if (count($payment) > 0) {
      foreach ($payment as $item) {
        PaymentTokensModel::approvePayment($item->id);
      }
    }
  }

}
