<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\ChatThreadModel;
use App\Modules\Api\Models\ChatThreadUserModel;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\FavoriteModel;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Helpers\Helper as AppHelper;
use App\Helpers\Session as AppSession;
use DB;
use Carbon\Carbon;

class ChatThreadController extends Controller {

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function getOnline(Request $req) {
    $userData = AppSession::getLoginData();
    $uid = ($userData->id) ? $userData->id : 0;

    $onlineUsers = ChatThreadModel::select("u.username", 'u.id', 'u.birthdate', 'p.age', "chatthreads.id as threadId", "chatthreads.lastStreamingTime", "chatthreads.isStreaming", DB::raw("(SELECT f.status from favorites f where f.favoriteId=chatthreads.ownerId and f.status='" . FavoriteModel::LIKE . "' and f.ownerId={$uid} limit 1) as favorite"))
      ->join('performer as p', 'p.user_id', '=', 'chatthreads.ownerId')
      ->join('users as u', 'u.id', '=', 'chatthreads.ownerId')
      ->where('chatthreads.type', ChatThreadModel::TYPE_PUBLIC)
      ->where('u.role', UserModel::ROLE_MODEL);
    if ($req->has('keyword') && !empty($req->get('keyword'))) {
      $onlineUsers = $onlineUsers->where('u.username', 'like', $req->get('keyword') . '%');
    }
//      ->where('chatthreads.isStreaming', 1)
    $onlineUsers = $onlineUsers->orderBy('chatthreads.isStreaming', 'desc')
      ->paginate(LIMIT_PER_PAGE);
    //check the latest image of streaming & show as the image
    foreach ($onlineUsers as $user) {
      if (file_exists(PUBLIC_PATH . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'rooms' . DIRECTORY_SEPARATOR . $user->threadId . '.png')) {
        $user->lastCaptureImage = $user->threadId . '.png';
      } else {
        $user->lastCaptureImage = null;
      }
      $user->DiffToNow = AppHelper::getDiffToNow($user->lastStreamingTime);
    }

    return response()->json($onlineUsers);
  }

  /**
   *
   * @return Response count
   */
  public function countOnline(Request $req) {
    return ChatThreadModel::join('users as u', 'u.id', '=', 'chatthreads.ownerId')
        ->where('chatthreads.type', ChatThreadModel::TYPE_PUBLIC)
        ->where('u.role', UserModel::ROLE_MODEL)
        ->where('chatthreads.isStreaming', 1)
        ->count();
  }

  /**
   * check model in room is online or offline
   * @param int $roomId 
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return boolen 
   */
  public function checkOnline($chatType, $roomId) {
//    $room = ChatThreadModel::select('isStreaming');
//    if ($chatType == ChatThreadModel::TYPE_GROUP || $chatType == ChatThreadModel::TYPE_PUBLIC) {
//      $room = $room->where('id', $roomId);
//    } else {
//      $room = $room->where('type', $chatType)
//        ->where('ownerId', $roomId);
//    }
    $room = ChatThreadModel::select('isStreaming')
      ->where('id', $roomId)
      ->where('type', $chatType)
      ->first();

    $userData = AppSession::getLoginData();

    if ($room) {

      if (!$room->isStreaming && $userData) {
        //update user streaming time
        $threadUser = ChatThreadUserModel::where('threadId', $roomId)
          ->where('userId', $userData->id)
          ->first();
        if ($threadUser) {
          $now = new \DateTime();
          $date = new \DateTime($threadUser->lastStreamingTime);
          $interval = $now->diff($date)->i;

          $threadUser->increment('streamingTime', intval($interval));
          $threadUser->isStreaming = 0;
          if ($threadUser->save()) {
            return $room->isStreaming;
          }
        }
      }
      return $room->isStreaming;
    }


    return null;
  }

  /**
   * @param int $id model id
   * @return response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function setMemberFavorite() {
    if (!Input::has('model')) {
      return Response()->json(['success' => false, 'message' => 'Model not exist.']);
    }
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(['success' => false, 'message' => 'Please, login to add this to your favorite list']);
    }
    //check model
    $model = UserModel::where('id', Input::get('model'))
      ->where('role', UserModel::ROLE_MODEL)
      ->first();
    if (!$model) {
      return Response()->json(['success' => false, 'message' => 'Model not exist.']);
    }

    $favorite = FavoriteModel::where('ownerId', $userData->id)
      ->where('favoriteId', $model->id)
      ->first();
    if (!$favorite) {
      $favorite = new FavoriteModel;
      $favorite->ownerId = $userData->id;
      $favorite->status = FavoriteModel::LIKE;
    } else {
      $favorite->status = ($favorite->status == FavoriteModel::LIKE) ? FavoriteModel::UNLIKE : FavoriteModel::LIKE;
    }
    $favorite->favoriteId = $model->id;
    if ($favorite->save()) {
      return Response()->json(['success' => true, 'message' => '', 'favorite' => $favorite->status]);
    }
    return Response()->json(['success' => false, 'message' => 'System error.']);
  }

}
