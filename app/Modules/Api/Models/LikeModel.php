<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class LikeModel extends Model {

  protected $table = "likes";

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  const LIKE = 'like';
  const DISLIKE = 'dislike';
  const TYPE_MODEL = 'model';
  const TYPE_VIDEO = 'video';

//total likes
  public static function countMe($item, $id) {
    $count = LikeModel::where('item_id', $id)
        ->where('item', $item)
        ->where('status', 'like')->count();

    return $count;
  }

//check current user like or dislike
  public static function checkMe($itemId, $item, $ownerId) {
    $count = LikeModel::where('item_id', $itemId)
      ->where('status', 'like')
      ->where('owner_id', $ownerId)
      ->where('item', $item)
      ->count();

    return $count;
  }

  public static function checkExist($ownerId, $item_id, $item) {
    $check = LikeModel::where('owner_id', $ownerId)
      ->where('item_id', $item_id)
      ->where('item', $item)
      ->first();
    return $check;
  }

//like me
  public static function likeMe($itemId, $item, $ownerId, $status) {

    $checkExist = LikeModel::checkExist($ownerId, $itemId, $item);
    if ($checkExist) {
      $like = LikeModel::find($checkExist->id);
      $like->status = ($checkExist->status == 'like') ? 'unlike' : 'like';
      if ($like->save()) {
        return $like;
      }
    } else {
      $like = new LikeModel;
      $like->owner_id = $ownerId;
      $like->item_id = $itemId;
      $like->item = $item;
      $like->status = 'like';
      if ($like->save()) {
        return $like;
      }
    }
    return null;
  }

}
