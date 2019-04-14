<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\LikeModel;
use Illuminate\Http\Request;
use App\Events\LikeItemEvent;
use App\Jobs\MakeNotification;
use App\Helpers\Session as AppSession;

class LikeController extends Controller {

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function index() {
    
  }

  public function countMe(Request $req) {
    if (!$req->has('itemId') || !$req->has('item')) {
      return null;
    }
    return LikeModel::countMe($req->get('item'), $req->get('itemId'));
  }

  public function checkMe(Request $req) {

    $userdata = AppSession::getLoginData();
    if (!$userdata) {
      return null;
    }

    $owner_id = $userdata->id;
    $item = $req->get('item');
    $itemId = $req->get('itemId');
    return LikeModel::checkMe($itemId, $item, $owner_id);
  }

  //like or dislike
  public function likeMe(Request $req) {
    $userdata = AppSession::getLoginData();
    if (!$userdata) {
      return response()->json(['status' => 'error', 'message' => 'Please, you have to login before']);
    }
    $owner_id = $userdata->id;
    $item = $req->get('item');
    $item_id = $req->get('itemId');
    $status = ($req->get('status') == 1) ? 'dislike' : 'like';

    $like = LikeModel::likeMe($item_id, $item, $owner_id, $status);
    if ($like) {
      \Event::fire(new LikeItemEvent($like));
      $job = (new MakeNotification($like, $userdata));

      $this->dispatch($job);
      return $like;
    }
    return response()->json(['status' => 'error', 'message' => 'Like event error, please trial again later.']);
  }

}
