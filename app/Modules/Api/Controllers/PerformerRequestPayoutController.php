<?php

namespace App\Modules\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Modules\Model\Models\PerformerPayoutRequest;
use App\Modules\Model\Models\PerformerPayoutRequestComment;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\EarningModel;
use App\Modules\Api\Models\PerformerModel;
use App\Modules\Api\Models\UserModel;
use App\Modules\Studio\Models\StudioPayoutRequest;
use App\Helpers\PayoutRequestHelper;
use App\Modules\Api\Models\SettingModel;
/**
 * Manage product action
 * @author Tuong Tran <tuong.tran@outlook.com>
 */
class PerformerRequestPayoutController extends Controller {
  /**
   * get all comments of tracking order
   *
   * @param Request $req
   * @param type $id
   * @return type
   */
  public function getComments(Request $req, $id) {
    //$user = $req->get('user');
    $request = PerformerPayoutRequest::where([
      'id' => $id
    ])
    ->first();

    //TODO - check permission
    if (!$request) {
      return Response()->json([
        'success' => false,
        'data' => [
          'message' => 'Request not found!'
        ]
      ]);
    }

    $items = PerformerPayoutRequestComment::where(['payoutRequestId' => $id])->with('sender')->get();

    return Response()->json([
      'success' => true,
      'data' => $items
    ]);
  }

  /**
   *
   * @param Request $req
   * @param type $id
   * @return type
   */
  public function addComment(Request $req, $id) {
    $user = $req->get('user');
    $request = PerformerPayoutRequest::where([
      'id' => $id
    ])
    ->first();

    if (!$request) {
      return Response()->json([
        'success' => false,
        'data' => [
            'message' => 'Request not found!'
        ]
      ]);
    }
//
//    if ($order->performerId != $user->performerId && $order->userId != $user->id) {
//      return Response()->json([
//        'success' => false,
//        'data' => [
//          'message' => 'Permission denied'
//        ]
//      ]);
//    }

    $model = new PerformerPayoutRequestComment();
    $model->text = Input::get('text');
    $model->senderId = $user->id;
    $model->payoutRequestId = $request->id;
    $model->sentBy = 'performer';
    $model->save();

    $model->sender = $user;
    return Response()->json([
      'success' => true,
      'data' => $model
    ]);
  }

  public function updateStatus(Request $req, $id) {
    $userData = AppSession::getLoginData();
    if(!$userData || ($userData && $userData->role != 'studio' && $userData->role != 'admin')){
      return response(['message'=> 'You does not have permission on this section.'], 403)->header('Content-Type', 'application/json');  
    }
    
    $request = PerformerPayoutRequest::where([
      'id' => $id
    ])
    ->first();

    if (!$request) {
      return response(['message'=> 'Request not found!'], 403)->header('Content-Type', 'application/json');  
    }
    if($userData->role == 'studio' && $userData->id !== $request->studioRequestId){
      return response(['message'=> 'You does not have permission on this section.'], 403)->header('Content-Type', 'application/json');    
    }
    if ($request->status == PerformerPayoutRequest::STATUS_APPROVE) {
      return Response()->json([
        'success' => true,
        'data' => $request
      ]);
    }
    if (Input::get('status')) {
      $request->status = Input::get('status');
    }
    if (Input::get('note')) {
      $request->note = Input::get('note');
    }
    
    
    if($request->save()){
      if (Input::get('status') == PerformerPayoutRequest::STATUS_APPROVE) {
        //TODO: update status for earnings table also
        $performerModel = PerformerModel::find($request->performerId);
        $userModel = UserModel::find($performerModel->user_id);;
        $startDate = $request->dateFrom;
        $endDate = date('Y-m-d', strtotime("+1 day", strtotime($request->dateTo)));        
        $wherePayment = '(earnings.createdAt between "'.$startDate.'" and "'.$endDate.'")'
              . ' AND earnings.payTo='.$userModel->id
              . ' AND earnings.status IS NULL';
        $userModel->tokens = $userModel->tokens - $request->payout;
        $userModel->save();
        $earning = EarningModel::whereRaw($wherePayment)                     
                ->update(['status' => PerformerPayoutRequest::STATUS_APPROVE]);
      }
    }

    return Response()->json([
      'success' => true,
      'data' => $request
    ]);
  }
  
  public function getEarningByRequestedDate(){
    $userData = AppSession::getLoginData();
    $options = [
      'userId' => $userData->id,
      'startDate' => Input::get('startDate'),
      'endDate' => Input::get('endDate')
    ];
    $setting = SettingModel::first();
    return Response()->json([
      'amount' => round(PayoutRequestHelper::getEarningByRequestedDate($options) * $setting->conversionRate, 2)
    ]); 
  }
  public function getLastestRequestPayout(){
    $userData = AppSession::getLoginData();
    $options = [
      'type' => Input::get('type'),
      'userId' => $userData->id
    ];
    return Response()->json([
      'amount' => round(PayoutRequestHelper::getLastestRequestPayout($options), 2)
    ]);
  }
  public function getTotalPendingBalance(){
    $userData = AppSession::getLoginData();
    $options = [
      'userId' => $userData->id
    ];
    $setting = SettingModel::first();
    return Response()->json([
      'amount' => round(PayoutRequestHelper::getTotalPendingBalance($options) * $setting->conversionRate, 2)
    ]);
  }
}
