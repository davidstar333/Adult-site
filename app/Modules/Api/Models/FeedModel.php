<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class FeedModel extends Model {

  protected $guarded = array();
  public static $rules = array(
    'title' => 'required',
    'text' => 'required'
  );

  protected $table = "posts";

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';

  public static function findMe($params) {
    $data = FeedModel::select('posts.id as feedId', 'users.id as userId', 'users.username', 'users.firstname', 'users.lastname', 'users.avatar', 'posts.title', 'posts.text', 'posts.owner_id', 'posts.createdAt', 'posts.updatedAt')->join('users', 'users.id', '=', 'posts.owner_id')->where('posts.id', '=', $params['id'])->first();
    return $data;
  }

  //save comment
  public static function addComment($params) {
    $comment = new FeedModel;

    $comment->text = $params['comment'];
    $comment->item_id = $params['itemId'];
    $comment->owner_id = $params['owner_id'];
    $comment->parent_id = $params['parent_id'];
    $comment->item = $params['item'];

    $comment->save();

    return CommentModel::findMyComment($comment->id);
  }

}
