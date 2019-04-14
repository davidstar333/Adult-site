<?php

namespace App\Modules\Member\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Helpers\Session as AppSession;
use DB;

class PaymentTokenController extends Controller {

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response 
   */
  public function getPaymentTokens(Request $req) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->with('msgError', 'Your session has expired.');
    }
    $payments = PaymentTokensModel::select('paymenttokens.*', 'u.username')
      ->join('users as u', 'u.id', '=', 'paymenttokens.ownerId')
      ->where('paymenttokens.ownerId', $userData->id);

    if ($req->has('timePeriodStart') && !$req->has('timePeriodEnd')) {
      $payments = $payments->where(DB::raw("DATE_FORMAT(paymenttokens.createdAt, '%Y-%m-%d')"), '>=', $req->get('timePeriodStart'));
    } else if ($req->has('timePeriodEnd') && !$req->has('timePeriodStart')) {
      $payments = $payments->where(DB::raw("DATE_FORMAT(paymenttokens.createdAt, '%Y-%m-%d')"), '<=', $req->get('timePeriodEnd'));
    } else if ($req->has('timePeriodStart') && $req->has('timePeriodEnd')) {
      $payments = $payments->whereBetween(DB::raw("DATE_FORMAT(paymenttokens.createdAt, '%Y-%m-%d')"), array($req->get('timePeriodStart'), $req->get('timePeriodEnd')));
    }
    
    $payments = $payments->orderBy('paymenttokens.createdAt', 'desc')->paginate(LIMIT_PER_PAGE);

    return view('Member::member_paymenttokens_history', compact('payments'));
  }

}
