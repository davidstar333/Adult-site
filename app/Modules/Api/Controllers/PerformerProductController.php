<?php

namespace App\Modules\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Modules\Model\Models\PerformerProduct;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Modules\Model\Models\PerformerProductTracking;
use App\Modules\Api\Models\PerformerModel;
use App\Modules\Api\Models\UserModel;
/**
 * Manage product action
 * @author Tuong Tran <tuong.tran@outlook.com>
 */
class PerformerProductController extends Controller {
  /**
   * buy a product with token
   *
   * @param integer $id
   */
  public function buy(Request $req, $id) {
    $user = $req->get('user');
    $product = PerformerProduct::where([
      'id' => $id,
      'isActive' => 1
    ])->first();
    if (!$product) {
      return Response()->json([
        'success' => false,
        'data' => [
          'message' => 'Product not found!'
        ]
      ]);
    }

    $quantity = Input::get('quantity', 1);
    if ($quantity > $product->inStock) {
      return Response()->json([
        'success' => false,
        'data' => [
          'message' => 'Stock is not enough!'
        ]
      ]);
    }

    $token = $quantity * $product->token;

    if ($user->tokens < $token) {
      return Response()->json([
        'success' => false,
        'data' => [
          'message' => 'Token is not enough!'
        ]
      ]);
    }
    $performer = PerformerModel::find($product->performerId);
    $userPerformer = UserModel::find($performer->user_id);
    //create tracking order
    $tracking = new PerformerProductTracking([
      'performerId' => $product->performerId,
      'userId' => $user->id,
      'quantity' => $quantity,
      'token' => $token, //total token
      'productId' => $product->id,
      'productName' => $product->name,
      'shippingAddress1' => $user->address1, //default shipping address
      'shippingAddress2' => $user->address2,
      'purchaseStatus' => 'purchased'
    ]);

    if (!$tracking->save()) {
      return Response()->json([
        'success' => false,
        'data' => [
          'message' => 'Cannot create payment!'
        ]
      ]);
    }

    //log payment for the log and statistic
    $payment = new PaymentTokensModel();
    $payment->ownerId = $user->id;
    $payment->item = PaymentTokensModel::ITEM_PERFORMER_PRODUCT;
    $payment->itemId = $userPerformer->id;
    $payment->modelId = $userPerformer->id;
    $payment->tokens = $token;
    $payment->status = PaymentTokensModel::STATUS_PROCESSING;
    $payment->save();

    //reduce user token
    $user->tokens -= $token;
    $user->save();

    //TODO - send mail, create relationship for product tracking
    return Response()->json([
      'success' => true,
      'data' => [
        'message' => 'Purchase successfully!'
      ]
    ]);
  }
}