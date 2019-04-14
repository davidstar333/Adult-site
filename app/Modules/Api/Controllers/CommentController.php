<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Modules\Api\Models\CommentModel;
use App\Modules\Api\Models\FeedModel;
use Illuminate\Http\Request;
use App\Helpers\Session as AppSession;
use Widget;
use App\Jobs\MakeCommentNotification;
use App\Helpers\Helper as AppHelper;
use DB;

class CommentController extends Controller {

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function index() {
    
  }

  public function countMe(Request $req) {
    $itemId = $req->get('itemId');
    $item = $req->get('item');

    $data = CommentModel::where('item', $item)
      ->where('item_id', $itemId)
      ->count();
    return $data;
  }

  public function findAll(Request $req) {
    $itemId = (Input::has('itemId')) ? $req->get('itemId') : null;
    $item = (Input::has('item')) ? $req->get('item') : null;
    $orderBy = (Input::has('orderBy')) ? $req->get('orderBy') : 'createdAt';
    $sort = (input::has('sort')) ? $req->get('sort') : 'desc';
    $limit = (Input::has('limit')) ? $req->get('limit') : 10;
    $parentId = (Input::has('parentId')) ? $req->get('parentId') : 0;
    $userData = AppSession::getLoginData();
    $ownerId = ($userData) ? $userData->id : 0;
    return Widget::run('commentswg', array('item' => $item, 'id' => $itemId, 'parent' => $parentId, 'showComment' => true, 'ownerItemId' => $ownerId, 'isLoadMore' => true));
//    $comments = CommentModel::select('comments.id as commentId', 'users.role', 'users.id as userId', 'users.username', 'users.firstname', 'users.lastname', 'users.avatar', 'comments.text', 'comments.total_likes', 'comments.item', 'comments.item_id', 'comments.createdAt', 'comments.parent_id')
//      ->join('users', 'users.id', '=', 'comments.owner_id')
//      ->where('parent_id', $parentId)
//      ->where('parent_id', $itemId)
//      ->where('item_id', '=', $itemId)
//      ->where('item', $item)
//      ->orderBy($orderBy, $sort)
//      ->paginate($limit);


    return CommentModel::select('comments.id as commentId', 'users.role', 'users.id as userId', 'users.username', 'users.firstname', 'users.lastname', 'users.avatar', 'comments.text', 'comments.total_likes', 'comments.item', 'comments.item_id', 'comments.createdAt', 'comments.parent_id', 'comments.total_likes', DB::raw('(SELECT COUNT(likes.status) FROM likes WHERE likes.item_id=comments.id and likes.item="comment" AND likes.status="like" AND likes.owner_id = ' . $ownerId . ') AS liked'))
        ->join('users', 'users.id', '=', 'comments.owner_id')
        ->where('comments.parent_id', $parentId)
        ->where('comments.item_id', '=', $itemId)
        ->where('comments.item', $item)
        ->orderBy('comments.createdAt', 'DESC')
        ->paginate(LIMIT_PER_PAGE);
  }

  public function subComments(Request $req) {
    $itemId = (Input::has('itemId')) ? $req->get('itemId') : null;
    $item = (Input::has('item')) ? $req->get('item') : null;
    $orderBy = (Input::has('orderBy')) ? $req->get('orderBy') : 'createdAt';
    $sort = (input::has('sort')) ? $req->get('sort') : 'desc';
    $limit = (Input::has('limit')) ? $req->get('limit') : 10;
    $parentId = (Input::has('parentId')) ? $req->get('parentId') : 0;

    return Widget::run('commentswg', array('item' => $item, 'id' => $itemId, 'parent' => $parentId, 'showComment' => true, 'ownerItemId' => 1));
    // $commentData = CommentModel::subComments($req);
//    return $commentData;
  }

  //add new comment
  public function addComment() {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return response()->json(['status' => 'error', 'message' => 'Please, you have to login before']);
    }

    $params = Input::all();

    $validation = Validator::make(Input::all(), array(
        'item' => 'required',
        'text' => 'required',
        'item_id' => 'required'
    ));
    if ($validation->passes()) {
      $comment = new CommentModel;

      $comment->text = strip_tags($params['text']);
      $comment->item_id = $params['item_id'];
      $comment->owner_id = $userData->id;
      $comment->parent_id = $params['parent_id'];
      $comment->item = $params['item'];

      if ($comment->save()) {

        $job = (new MakeCommentNotification($comment, $userData));

        $this->dispatch($job);

        return '<li class="comment" id="comment-box-' . $comment->id . '" comment-id="' . $comment->id . '">
          <div class="row well well-sm">
            <div class="col-xs-12">
              <div class="pull-left"><a><font><font class=""><strong id="total-likes-' . $comment->id . '">0</strong> people</font></font></a><font><font class=""> like this</font></font></div>
            </div>
          </div>

          <div class="row well well-sm ' . $userData->role . '-role">
            <div class="col-xs-2 cm-avatar">
              <img src="' . AppHelper::getMyProfileAvatar() . '" alt="">
            </div>
            <div class="col-xs-10">
              <div class="comment_text">
                <div class="col-sm-12" >
                  <a class="cm-action" id="delete-comment-' . $comment->id . '">
                    <i class="fa fa-remove icon"></i>
                  </a>
                  <strong>Me</strong>
                </div>
                ' . htmlentities($comment->text, ENT_QUOTES, 'UTF-8', false) . '
              </div>
              <ul class="comment_panel">
                <li><a class="like-this-box" item-id="' . $comment->id . '" item="comment" id="like-thumb-' . $comment->id . '"><span>Like</span></a></li>
                <li><a class="show-comment-box" parent="' . $comment->id . '" item="comment" item-id="' . $comment->item_id . '">Answer</a></li>
              </ul>
              <div class="form-group reply-enter-box hidden" id="reply-enter-box-' . $comment->id . '">
                <input class="form-control enter-comment-form" item="comment" item-id="' . $comment->item_id . '" parent="' . $comment->id . '" autocomplete="off" placeholder="Add a comment" id="replyText-' . $comment->id . '" name="replyText-' . $comment->id . '" type="text" ng-required="true">

              </div>


            </div>
          </div>
          <div class="col-sm-12" id="show-comment-box-' . $comment->id . '"></div>


          <ul class="comments-list" id="parent-comment-box-' . $comment->id . '"></ul>


        </li>';
      } else {
        return Response()->json(array('success' => false, 'error' => '', 'message' => 'Save comment error. Please trial again later.'));
      }
    } else {
      return Response()->json(array('success' => false, 'errors' => $validation->errors()->first('text'), 'message' => $validation->errors()->first('text')));
    }
  }

  //destroy comment
  public function destroy($id) {
    $userData = AppSession::getLoginData();
    if ($userData) {
      $data = CommentModel::find($id);
      if ($data && $data->owner_id == $userData->id) {
        if ($data->parent_id != 0) {
          $data->delete();
        } else {
          $subComment = CommentModel::where('parent_id', $id);
          $subComment->delete();
          $data->delete();
        }
        return $data;
      } else if ($data) {
        $checkOwnerPost = FeedModel::where('id', $data->item_id)->where('owner_id', $userData->id)->first();
        if ($checkOwnerPost) {
          if ($data->parent_id != 0) {
            $data->delete();
          } else {
            $subComment = CommentModel::where('parent_id', $id);
            $subComment->delete();
            $data->delete();
          }
        }
        return $data;
      }
    }
  }

}
