<?php

namespace App\Modules\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Modules\Model\Models\PerformerProductTracking;
use App\Modules\Model\Models\PerformerProductTrackingComment;

/**
 * Manage product action
 * @author Tuong Tran <tuong.tran@outlook.com>
 */
class PerformerProductTrackingController extends Controller {
  /**
   * Change order status with shipping status and note
   * restricted: performer
   *
   * @param Request $req
   * @param type $id
   */
  public function changeOrderStatus(Request $req, $id) {
    $performer = $req->get('performer');

    $order = PerformerProductTracking::where([
      'performerId' => $performer->id,
      'id' => $id
    ])
    ->first();

    if (!$order) {
      return Response()->json([
        'success' => false,
        'data' => [
          'message' => 'Order not found!'
        ]
      ]);
    }

    if (Input::get('shippingStatus')) {
      $order->shippingStatus = Input::get('shippingStatus');
    }
    if (Input::get('note')) {
      $order->note = Input::get('note');
    }
    if (Input::get('status')) {
      $order->status = Input::get('status');
    }

    if (!$order->save()) {
      return Response()->json([
        'success' => false,
        'data' => [
          'message' => 'Server error'
        ]
      ]);
    }

    return Response()->json([
      'success' => true,
      'data' => $order
    ]);
  }

  /**
   * get all comments of tracking order
   *
   * @param Request $req
   * @param type $id
   * @return type
   */
  public function getComments(Request $req, $id) {
    $user = $req->get('user');
    $order = PerformerProductTracking::where([
      'id' => $id
    ])
    ->first();

    if (!$order) {
      return Response()->json([
        'success' => false,
        'data' => [
          'message' => 'Order not found!'
        ]
      ]);
    }

    $items = PerformerProductTrackingComment::where(['orderId' => $id])->with('sender')->get();

    return Response()->json([
      'success' => true,
      'data' => $items
    ]);
  }

  /**
   * allow performer or buyer to comment in the tracking order
   *
   * @param Request $req
   * @param type $id
   * @return type
   */
  public function addComment(Request $req, $id) {
    $user = $req->get('user');
    $order = PerformerProductTracking::where([
      'id' => $id
    ])
    ->first();

    if (!$order) {
      return Response()->json([
        'success' => false,
        'data' => [
          'message' => 'Order not found!'
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

    $model = new PerformerProductTrackingComment();
    $model->text = Input::get('text');
    $model->senderId = $user->id;
    $model->orderId = $order->id;
    $model->save();

    $model->sender = $user;
    return Response()->json([
      'success' => false,
      'data' => $model
    ]);
  }
}