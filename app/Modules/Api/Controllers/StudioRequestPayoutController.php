<?php

namespace App\Modules\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Modules\Studio\Models\StudioPayoutRequest;
use App\Modules\Studio\Models\StudioPayoutRequestComment;
use App\Modules\Model\Models\PerformerPayoutRequest;
use App\Modules\Api\Models\EarningModel;
/**

 * Manage product action
 * @author Tuong Tran <tuong.tran@outlook.com>
 */
class StudioRequestPayoutController extends Controller {
  /**
   * get all comments of tracking order
   *
   * @param Request $req
   * @param type $id
   * @return type
   */
  public function getComments(Request $req, $id) {
    //$user = $req->get('user');
    $request = StudioPayoutRequest::where([
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

    $items = StudioPayoutRequestComment::where(['payoutRequestId' => $id])->with('sender')->get();

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
    $request = StudioPayoutRequest::where([
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

    $model = new StudioPayoutRequestComment();
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
    $request = StudioPayoutRequest::where([
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

    if (Input::get('status')) {
      $request->status = Input::get('status');
    }
    if (Input::get('note')) {
      $request->note = Input::get('note');
    }
    if($request->save()){
      if (Input::get('status') == PerformerPayoutRequest::STATUS_APPROVE) {
        //TODO: update status for earnings table also
        $startDate = $request->dateFrom;
        $endDate = date('Y-m-d', strtotime("+1 day", strtotime($request->dateTo)));        
        $wherePayment = '(earnings.createdAt between "'.$startDate.'" and "'.$endDate.'")'
              . ' AND earnings.payTo='.$request->studioId
              . ' AND earnings.status IS NULL';
        $earning = EarningModel::whereRaw($wherePayment)                     
                ->update(['status' => PerformerPayoutRequest::STATUS_APPROVE]);
      }
    }

    return Response()->json([
      'success' => true,
      'data' => $request
    ]);
  }
}
