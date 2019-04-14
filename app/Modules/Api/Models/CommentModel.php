<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CommentModel extends Model {

  protected $table = "comments";
  protected $guarded = array();
  public static $rules = array(
    'item' => 'required',
    'text' => 'required',
    'item_id' => 'required'
  );

  const FEED_ITEM = 'feed';
  const VIDEO_ITEM = 'video';
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';

  //find all parent comment
  public static function findAll($params) {
    $comments = CommentModel::select('comments.id as commentId', 'users.id as userId', 'users.username', 'users.firstname', 'users.lastname', 'users.avatar', 'comments.text', 'comments.total_likes', 'comments.item', 'comments.item_id', 'comments.createdAt', 'comments.parent_id')->join('users', 'users.id', '=', 'comments.owner_id')->where('parent_id', 0)->where('item', '=', $params['item'])->where('item_id', '=', $params['id'])->get();

    return $comments;
  }

  public static function CommentsByParent($params) {
    $comments = CommentModel::select('comments.id as commentId', 'users.id as userId', 'users.username', 'users.firstname', 'users.lastname', 'users.avatar', 'comments.text', 'comments.total_likes', 'comments.item', 'comments.item_id', 'comments.createdAt', 'comments.parent_id')->join('users', 'users.id', '=', 'comments.owner_id')->where('parent_id', 0)->where('item_id', '=', $params['itemId'])->where('item', $params['item'])->orderBy($params['orderBy'], $params['sort'])->paginate($params['limit']);

    return $comments;
  }

  public static function subComments($params) {
    $comments = CommentModel::select('comments.id as commentId', 'users.role', 'users.id as userId', 'users.username', 'users.firstname', 'users.lastname', 'users.avatar', 'comments.text', 'comments.total_likes', 'comments.item', 'comments.item_id', 'comments.createdAt', 'comments.parent_id')->join('users', 'users.id', '=', 'comments.owner_id')->where('parent_id', $params['parentId'])->where('item_id', '=', $params['itemId'])->where('comments.item', 'comment')->orderBy($params['orderBy'], $params['sort'])->paginate($params['limit']);

    return $comments;
  }

  //find all childrend comments
  public static function findChildren($params) {
    $comments = CommentModel::select('comments.id as commentId', 'users.id as userId', 'users.username', 'users.firstname', 'users.lastname', 'users.avatar', 'comments.text', 'comments.total_likes', 'comments.item', 'comments.item_id', 'comments.createdAt', 'comments.parent_id')->join('users', 'users.id', '=', 'comments.owner_id')->where('parent_id', $params['parent_id'])->where('item', '=', $params['item'])->where('item_id', '=', $params['id'])->get();

    return $comments;
  }

  public static function findMyComment($commentId) {
    $data = CommentModel::select('comments.id as commentId', 'users.role', 'users.id as userId', 'users.username', 'users.firstname', 'users.lastname', 'users.avatar', 'comments.text', 'comments.total_likes', 'comments.item', 'comments.item_id', 'comments.createdAt', 'comments.parent_id')->join('users', 'users.id', '=', 'comments.owner_id')->where('comments.id', '=', $commentId)->first();
    return $data;
  }

}
