<?php

namespace App\Modules\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\AttachmentModel;
use App\Modules\Api\Models\VideoModel;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\PaymentTokensModel;
use Carbon\Carbon;
//use App\Events\ConvertVideo;
use App\Jobs\ProcessConvertVideo;
use App\Events\DeleteVideo;
use App\Events\ConvertImage;
use App\Events\DeleteImage;
use DB;
use App\Helpers\MediaHelper;

class MediaController extends Controller {

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function index() {
    
  }

  public function setMainImage($id) {
    $userData = AppSession::getLoginData();
    if (!$userData || $userData->role == UserModel::ROLE_MEMBER) {
      return Response()->json(array('success' => false, 'error' => 'Please, login with model role.', 'message' => 'Please, login with model role.'));
    }

    $image = AttachmentModel::where('id', $id)
      ->where('media_type', AttachmentModel::IMAGE);
    if ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN) {
      $image = $image->where('owner_id', $userData->id);
    }
    $image = $image->first();
    if (!$image) {
      return Response()->json(array('success' => false, 'error' => 'Image not found.', 'message' => ''));
    }
    $currentMain = AttachmentModel::where('parent_id', $image->parent_id)
      ->where('main', AttachmentModel::MAIN_YES)
      ->update(['main' => AttachmentModel::MAIN_NO]);

    $image->main = AttachmentModel::MAIN_YES;
    if($image->save()){
        return Response()->json(array('success' => true, 'error' => '', 'message' => 'Update successfully.'));
    }
    return Response()->json(array('success' => false, 'error' => 'System error.', 'message' => 'System error.'));
  }

  /**
   * @param id $id media id (image or video id)
   * @author Phong Le <pt.hongphong@gmail.com>
   * media status : active: show on member or inactive hidden it
   * * */
  public function setMediaStatus($id) {
    $userData = AppSession::getLoginData();
    if ($userData) {
      $media = AttachmentModel::where('id', $id)
        ->where('owner_id', $userData->id)
        ->first();
      if ($media) {
        $post = \Request::all();
        $status = ($post['status'] == 'active') ? 'inactive' : 'active';
        $media->status = $status;
        $media->save();
        return Response()->json(array('success' => true, 'status' => $media->status, 'message' => 'The status was successfully changed.'));
      } else {
        return Response()->json(array('success' => false, 'message' => 'Change status error.'));
      }
    }
  }

  public function findMyMediaGallery(Request $req) {
    $userData = AppSession::getLoginData();
    if (!$userData || $userData->role == UserModel::ROLE_MEMBER) {
      return Response()->json(['success' => false, 'error' => 'Please login with model role']);
    }
    if (!$req->has('type') || !$req->has('galleryId')) {
      return Response()->json(['success' => false, 'error' => 'Missing filter data']);
    }

    $limit = ($req->get('limit')) ? $req->get('limit') : LIMIT_PER_PAGE;
    $images = AttachmentModel::select('id', 'type', 'media_type', 'status', 'owner_id', 'parent_id', 'size', 'main')
      ->where('media_type', $req->get('type'))
      ->where('parent_id', $req->get('galleryId'));
    if ($userData->role == UserModel::ROLE_MODEL) {
      $images = $images->where('owner_id', $userData->id);
    }

    return $images->paginate($limit);
  }

  public function findMyVideoGallery(Request $req) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect('login');
    }
    if($req->get('modelId')) {
      $userData = UserModel::find($req->get('modelId'));
    }
    $galleryId = $req->get('galleryId');
    $limit = ($req->get('limit')) ? $req->get('limit') : LIMIT_PER_PAGE;


    $videos = VideoModel::select('videos.*', DB::raw("(select ap.mediaMeta from attachment ap where ap.media_type = 'poster' AND ap.id = videos.poster limit 1) as posterData"));
    if ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN) {
      $videos = $videos->where('videos.ownerId', $userData->id);
    }
    if($galleryId) {
      $videos = $videos->where('videos.galleryId', $galleryId);
    }
    return $videos->paginate(LIMIT_PER_PAGE);
  }

  public function findMyProfileImages(Request $req) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect('login');
    }
    $type = $req->get('type');
    $mediaType = $req->get('mediaType');
    $limit = ($req->has('limit')) ? $req->get('limit') : LIMIT_PER_PAGE;
    return AttachmentModel::where('media_type', $mediaType)
      ->where('owner_id', $userData->id)
      ->paginate($limit);
    
  }

//upload model image or video
  public function uploadItems(Request $req) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(array('success' => false, 'message' => 'Please, login again.'));
    }
    $data = MediaHelper::upload($userData, Input::file('myFiles'), $req->get('mediaType'), $req->get('parent-id'), Input::get('model-id'));
    if ($data['success'] && strpos($req->get('mediaType'), 'video') !== false) {
      $job = (new ProcessConvertVideo($data['file']->id));
      $this->dispatch($job);
    }
    return Response()->json(array('success' => $data['success'], 'error' =>  $data['error'], 'message' => $data['message'], 'file' => $data['file']));
  }

  public function countMe(Request $req) {
    $itemId = $req->get('itemId');
    $item = $req->get('item');
    return LikeModel::countMe($item, $itemId);
  }

  public function checkMe(Request $req) {
    $userData = AppSession::getLoginData();

    if(!$userData){
      return null;
    }    
    $user = json_decode(\Session::get('UserLogin'));
    $owner_id = $user->id;
    $item = $req->get('item');
    $itemId = $req->get('itemId');
    return LikeModel::checkMe($itemId, $item, $owner_id);
  }

//like or dislike
  public function likeMe(Request $req) {
    if (\Session::has('UserLogin')) {
      $user = json_decode(\Session::get('UserLogin'));
      $owner_id = $user->id;
      $item = $req->get('item');
      $item_id = $req->get('itemId');
      $status = ($req->get('status') == 1) ? 'dislike' : 'like';
      $like = LikeModel::likeMe($item_id, $item, $owner_id, $status);
      return $like;
    } else {
      return response()->json(['status' => 'error', 'message' => 'Please, you have to login before']);
    }
  }

//destroy
  public function destroyImage($id) {
    $userData = AppSession::getLoginData();
    if (!$userData || $userData->role == UserModel::ROLE_MEMBER) {
      return Response()->json(['success' => false, 'message' => 'Please login with model role', 'error' => 'Please login with model role']);
    }
    $file = AttachmentModel::where('id', $id);
    if ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN) {
      $file = $file->where('owner_id', $userData->id);
    }
    $file = $file->first();

    if ($file && $file->main == 'yes') {
      return Response()->json(array('success' => false, 'error' => 'Please, remove main image before you can delete it.', 'message' => ''));
    }
    if($file->status === 'Profile picture'){
      $user = UserModel::find($file->owner_id);
      if($user) {
        $user->avatar = null;
        $user->smallAvatar = null;
        $user->save();
      }
    }
    if ($file) {
        \Event::fire(new DeleteImage($file->id));
        if(file_exists($file->path)){
            \File::Delete($file->path);
        }
      if ($file->delete()) {
//TODO Delete comment, like
        return Response()->json(array('success' => true, 'error' => '', 'message' => 'This picture was successfully deleted.'));
      }
      return Response()->json(array('success' => false, 'error' => 'Delete media error.', 'message' => ''));
    }
    return Response()->json(array('success' => false, 'error' => 'Image not exist.', 'message' => ''));
  }

  public function destroyVideo($id) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(array('success' => false, 'error' => 'Please login again.', 'message' => 'Please login again.'));
    }
    $video = VideoModel::where('id', $id);
    if ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN) {
      $video = $video->where('ownerId', $userData->id);
    }
    $video = $video->first();
    if (!$video) {
      return Response()->json(array('success' => false, 'error' => 'Video not exist.', 'message' => 'Video not exist.'));
    }
    \Event::fire(new DeleteVideo($video));
    ////TODO Delete comment, like
    if ($video->delete()) {
      return Response()->json(array('success' => true, 'error' => '', 'message' => 'The Video was successfully deleted.'));
    }
    return Response()->json(array('success' => false, 'error' => 'System error.', 'message' => ''));
  }

  /**
   * check media owner
   * @param int $id media id
   * @param int $type (video, gallery)
   */
  public function checkOwner() {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(['success' => false, 'message' => 'Your session was expired.']);
    }

    $id = Input::has('id') ? Input::get('id') : null;
    
    $check = PaymentTokensModel::where('ownerId', $userData->id)
      ->where('paymenttokens.item', PaymentTokensModel::ITEM_IMAGE)
      ->where('paymenttokens.itemId', $id)
      ->where('paymenttokens.status', '<>', PaymentTokensModel::STATUS_REJECT)
      ->count();

    return Response()->json(['success' => true, 'owner' => $check, 'id' => '', 'message' => '']);
  }

}
