<?php

namespace App\Modules\Member\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Api\Models\PaymentsModel;
use App\Helpers\Session as AppSession;

class PaymentController extends Controller {

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response 
   */
  public function getMyTransactions() {
    $userData = AppSession::getLoginData();

    $transactions = PaymentsModel::select('payments.*', 'u.username')
      ->join('users as u', 'u.id', '=', 'payments.memberId')
      ->where('payments.memberId', $userData->id)
      ->paginate(LIMIT_PER_PAGE);

    return view('Member::member_transaction_history', compact('transactions'));
  }

}
