<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Mail;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Modules\Api\Models\PerformerChatModel;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\ChatThreadModel;
use App\Modules\Api\Models\VideoModel;
use App\Modules\Api\Models\GalleryModel;
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;
use Illuminate\Http\Request;
use App\Events\SendTokensEvent;
use App\Events\SendPaidTokensEvent;
use DB;

class PaymentTokensController extends Controller {

  /**
   * 
   * @param Request $require(roomId, tokens)
   * @return json
   * @author Phong Le <pt.hongphong@gmail.com>
   * 
   */
  public function sendTokens() {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return response()->json([
          'success' => false,
          'message' => 'Please, Login to send tokens.'
      ]);
    }

    // get user tokens
    $postData = Input::all();

    //TODO check commission percent
    if (!Input::has('modelId')) {
      return response()->json([
          'success' => false,
          'message' => 'Model does not exist.'
      ]);
    }
    if (!Input::has('tokens')) {
      return response()->json([
          'success' => false,
          'message' => 'Tokens is required'
      ]);
    }



    $totalTokens = UserModel::find($userData->id);

    if ($totalTokens->tokens < $postData['tokens']) {
      return response()->json([
          'success' => false,
          'message' => 'Your tokens do not enough, Please, buy more.',
          'tokens' => $totalTokens
      ]);
    }
    $totalTokens->decrement('tokens', $postData['tokens']);

    if ($totalTokens->save()) {
      //TODO get premium token and spy price from db

      $send = \Event::fire(new SendTokensEvent($postData, $userData));
      if (!$send) {
        $totalTokens->increment('tokens', $postData['tokens']);
        if ($totalTokens->save()) {
          return response()->json([
              'success' => true,
              'message' => 'Have some error, your Tokens does not send.'
          ]);
        }
      }


      return response()->json([
          'success' => true,
          'message' => 'Send ' . $postData['tokens'] . ' tokens'
      ]);
    } else {
      return response()->json([
          'success' => false,
          'message' => 'Send tokens error. please trial again later'
      ]);
    }
  }

  /**
   * 
   * @param Request $require(roomId, tokens)
   * @return json
   * @author Phong Le <pt.hongphong@gmail.com>
   * 
   */
  public function sendPaidTokens() {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return response()->json([
          'success' => false,
          'message' => 'Please, Login to send tokens.'
      ]);
    }

    // get user tokens
    $postData = Input::all();

    //TODO check commission percent
    if (!Input::has('modelId') || !Input::has('chatType')) {
      return response()->json([
          'success' => false,
          'message' => 'Send tokens error.'
      ]);
    }
    if (Input::get('chatType') != ChatThreadModel::TYPE_GROUP && Input::get('chatType') != ChatThreadModel::TYPE_PRIVATE) {
      return;
    }

    $modelSetting = PerformerChatModel::where('model_id', $postData['modelId'])->first();
    if (!$modelSetting) {
      return Response()->json(['success' => false, 'message' => 'Model setting not found.']);
    }
    if (Input::get('chatType') == ChatThreadModel::TYPE_GROUP) {
      $tokens = ($modelSetting->group_price > 0) ? $modelSetting->group_price : app('settings')->group_price;
    }
    if (Input::get('chatType') == ChatThreadModel::TYPE_PRIVATE) {
      $tokens = ($modelSetting->private_price > 0) ? intval($modelSetting->private_price) : intval(app('settings')->private_price);
    }

    $totalTokens = UserModel::find($userData->id);

    if ($totalTokens->tokens < $tokens) {
      return response()->json([
          'success' => false,
          'message' => 'Your tokens do not enough, Please, buy more.',
          'tokens' => $totalTokens->tokens
      ]);
    }


    $totalTokens->decrement('tokens', $tokens);

    if ($totalTokens->save()) {
      //TODO get premium token and spy price from db

      $send = \Event::fire(new SendPaidTokensEvent($postData, $tokens, $userData));
      if (!$send) {
        $totalTokens->increment('tokens', $tokens);
        if ($totalTokens->save()) {
          return response()->json([
              'success' => false,
              'message' => 'Have some error, your Tokens does not send.',
              'tokens' => $totalTokens->tokens
          ]);
        }
      }


      return response()->json([
          'success' => true,
          'message' => 'Send ' . $tokens . ' tokens',
          'tokens'  => $totalTokens->tokens,
          'spend'   => $tokens
      ]);
    } else {
      return response()->json([
          'success' => false,
          'message' => 'Send tokens error. please trial again later',
          'tokens'  => $totalTokens->tokens
      ]);
    }
  }


  /**
   * 
   * @param Request $require(roomId)
   * @return json
   * @author Phong Le <pt.hongphong@gmail.com>
   * pay tokens per each chat message
   */
  public function sendTipTokens($roomId = null) {

    $userData = AppSession::getLoginData();
    if (!$userData) {
      return response()->json([
          'success' => false,
          'message' => 'Please, Login.'
      ]);
    }

    //TODO Check room exist.
    $room = ChatThreadModel::select('chatthreads.*')
      ->join('users as u', 'u.id', '=', 'chatthreads.ownerId')
      ->where('u.role', UserModel::ROLE_MODEL)
      ->where('chatthreads.id', $roomId)
      ->first();
    if (!$room) {
      return response()->json([
          'success' => false,
          'message' => 'Room or model does not exist.'
      ]);
    }

    //TODO get user token from db
    $min_tip_amount = app('settings')->min_tip_amount;
    $tokens = (Input::has('tokens')) ? Input::get('tokens') : null;

    if (!$tokens || $min_tip_amount > $tokens) {
      return Response()->json([
          'success' => false,
          'message' => "Please, enter at least {$min_tip_amount} Tokens"
      ]);
    }
    //Check member tokens
    $userDataDB = UserModel::find($userData->id);

    if ($userDataDB->tokens < $tokens) {
      return response()->json([
          'success' => false,
          'message' => 'Your tokens do not enough, Please, buy more.',
          'tokens' => $userDataDB->tokens
      ]);
    }
    $userDataDB->decrement('tokens', $tokens);

    if ($userDataDB->save()) {
      $params = array(
        'tokens' => $tokens,
        'modelId' => $room->ownerId,
        'options' => array(
          'type' => 'tip'
        )
      );
      $send = \Event::fire(new SendTokensEvent($params, $userData));
      if (!$send) {
        $userDataDB->increment('tokens', $tokens);
        if ($userDataDB->save()) {
          return response()->json([
              'success' => false,
              'message' => 'Have some error, your Tokens does not send.'
          ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Refund tokens error'
        ]);
      }


      return response()->json([
          'success' => true,
          'message' => 'You sent ' . $tokens . ' tokens'
      ]);
    } else {
      return response()->json([
          'success' => false,
          'message' => 'Send tokens error. please trial again later'
      ]);
    }
  }

  /**
   * @param int $id item id
   * @param string $item 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function buyItem() {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(['success' => false, 'message' => 'Please, login to buy this item.']);
    }

    if (!Input::has('item') || !Input::has('id')) {
      return Response()->json(['success' => false, 'message' => 'Item not exist.']);
    }
    $item = Input::get('item');
    $itemId = Input::get('id');
    //TODO check owner

    $check = PaymentTokensModel::checkOwner($userData, $item, $itemId);
    $url = ($item == PaymentTokensModel::ITEM_IMAGE) ? BASE_URL . 'media/image-gallery/preview/' . $itemId : BASE_URL . 'media/video/watch/' . $itemId;
    if ($check) {
      //TODO item was bought
      return Response()->json(['success' => true, 'message' => 'Item was bought.', 'url' => $url]);
    }
    //get item
    $chooseItem = self::getPaidItem($item, $itemId);
    if (!$chooseItem) {
      return Response()->json(['success' => false, 'message' => 'This item not exist or private gallery']);
    }
    //TODO check user tokens
    $user = UserModel::find($userData->id);
    if ($user->tokens < intval($chooseItem->price)) {
      return Response()->json(['success' => false, 'message' => 'Your Tokens are not enough to buy this item.']);
    }
    //TODO process buy item here
    $user->decrement('tokens', intval($chooseItem->price));
    if ($user->save()) {
      $payment = new PaymentTokensModel;
      $payment->item = $item;
      $payment->itemId = $itemId;
      $payment->ownerId = $user->id;
      $payment->tokens = intval($chooseItem->price);
      $payment->status = PaymentTokensModel::STATUS_PROCESSING;
      if ($payment->save()) {

        return Response()->json(['success' => true, 'message' => 'The item was successfully bought.', 'url' => $url]);
      }
      $user->increment('tokens', intval($chooseItem->price));
      if ($user->save()) {
        return response()->json([
            'success' => false,
            'message' => 'Have some error, your Tokens can not buy.'
        ]);
      }
    }
    return Response()->json(['success' => false, 'message' => 'System eror.']);
  }

  /**
   * @return response
   * 
   */
  public function getPaidItem($item, $itemId) {
    if ($item == PaymentTokensModel::ITEM_VIDEO) {
      return VideoModel::select('videos.price')
          ->join('galleries as g', 'g.id', '=', 'videos.galleryId')
          ->where('videos.id', $itemId)
          ->where('g.type', $item)
          ->where('g.status', GalleryModel::PUBLICSTATUS)
          ->first();
    }
    return GalleryModel::select('price')
        ->where('type', $item)
        ->where('status', GalleryModel::PUBLICSTATUS)
        ->where('id', $itemId)
        ->first();
  }

  /**
   * @return response 
   * @param int $galleryId
   * @param string $paymentItem 
   * */
  public function paidAllbumImage() {
    if (!Input::has('galleryId') || !Input::has('paymentItem')) {
      return Response()->json(['success' => false, 'message' => 'Gallery or item does not exist.']);
    }
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(['success' => false, 'message' => 'Please, login to buy this item.']);
    }

    $item = Input::get('paymentItem');
    $itemId = Input::get('galleryId');
    //TODO check owner

    $check = PaymentTokensModel::checkOwner($userData, $item, $itemId);
    if ($check) {
      //TODO item was bought
      return Response()->json(['success' => true, 'message' => 'Item was bought.']);
    }
    //get item
    $chooseItem = self::getPaidItem($item, $itemId);
    if (!$chooseItem) {
      return Response()->json(['success' => false, 'message' => 'This item not exist or private gallery']);
    }
    //TODO check user tokens
    $user = UserModel::find($userData->id);
    if ($user->tokens < $chooseItem->price) {
      return Response()->json(['success' => false, 'message' => 'Your Tokens are not enough to buy this item.']);
    }
    //TODO process buy item here
    $user->decrement('tokens', $chooseItem->price);
    if ($user->save()) {
      $payment = new PaymentTokensModel;
      $payment->item = $item;
      $payment->itemId = $itemId;
      $payment->ownerId = $user->id;
      $payment->tokens = $chooseItem->price;
      $payment->status = PaymentTokensModel::STATUS_PROCESSING;
      if ($payment->save()) {
        return Response()->json(['success' => true, 'message' => 'The item was successfully bought.']);
      }
      $user->increment('tokens', $chooseItem->price);
      if ($user->save()) {
        return response()->json([
            'success' => false,
            'message' => 'Have some error, your Tokens can not buy.'
        ]);
      }
    }
    return Response()->json(['success' => false, 'message' => 'System eror.']);
  }

}
