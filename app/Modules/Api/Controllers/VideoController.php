<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;
use App\Modules\Api\Models\VideoModel;
use App\Modules\Api\Models\GalleryModel;
use App\Modules\Api\Models\UserModel;
//use DispatchesJobs;
use App\Jobs\ProcessConvertVideo;
use DB;

class VideoController extends Controller {

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function index() {

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  array
   * @method post methodName(type $paramName) Description
   * @return Response
   */
  public function create() {

  }

  /**
   * get videos image by model
   * @param int $id model id
   */
  public function getModelVideos($id) {
  
    return VideoModel::select('videos.id','videos.title', 'videos.seo_url', 'a.mediaMeta as posterMeta')
        ->leftJoin('attachment as a', 'a.id', '=', 'videos.poster')
        ->where('videos.ownerId', $id)
        ->where('videos.status', VideoModel::ACTIVE)
        ->orderBy('videos.createdAt', 'desc')
        ->paginate(6);
  }

  /**
   *
   * @return post
   * @author Phong Le <pt.hongphong@gmail.com>
   * @param string $title video title
   * @param string $description video description
   * @param int $price video price
   * @param int $galleryId video gallery id
   * @param int $poster video main poster id (attachment field)
   * @param int $trailer video trailer id  (attachment field)
   * @param int $fullMovie movie id ( attachment field )
   */
  public function store() {
    //get form data
    $input = Input::all();
    $validation = Validator::make($input, array(
    'title' => 'required|Unique:videos|Min:5|Max:124',
    'description' => 'required|Min:5|Max:500',
    'galleryId' => 'required',
    'price' => 'Integer|Min:0',
    'poster' => 'Required',
    'trailer' => 'Required',
    'fullMovie' => 'Required'
  ));

    if (!$validation->passes()) {
      return Response()->json(array('success' => false, 'errors' => $validation->errors()));
    }
//      $tokenDecode = AppJwt::getTokenDecode($input['token']);
    $userData = AppSession::getLoginData();
    if (!$userData || $userData->role == UserModel::ROLE_MEMBER) {
      return Response()->json(array('success' => false, 'errors' => 'Please login with model role', 'message' => 'Please, login with model role.'));
    }
    $video = new VideoModel();
    $video->title = $input['title'];
    $video->seo_url = str_slug($input['title']);
    $video->description = $input['description'];
    $video->fullMovie = $input['fullMovie'];
    $video->galleryId = $input['galleryId'];
    $video->poster = $input['poster'];
    $video->trailer = $input['trailer'];
    $video->price = (Input::has('price')) ? $input['price'] : 0;
    if ($userData->role == UserModel::ROLE_MODEL) {
      $video->ownerId = $userData->id;
    } else if (Input::has('ownerId')) {
      $video->ownerId = $input['ownerId'];
    }
    $video->status = VideoModel::PROCESSING;
    if ($video->save()) {
      $url = ($userData->role == UserModel::ROLE_MODEL) ? BASE_URL . 'models/dashboard/media/videos' : BASE_URL . 'admin/manager/video-gallery/' . $video->ownerId;

      return Response()->json(array('success' => true, 'errors' => '', 'message' => 'Video was successfully created.', 'id' => $video->id, 'url' => $url));
    }
    return Response()->json(array('success' => false, 'errors' => '', 'message' => 'Save event error, please trial again.'));
  }

  /**
   *
   * @return json
   * @author Phong Le <pt.hongphong@gmail.com>
   * @param string $title video title
   * @param string $description video description
   * @param int $price video price
   * @param int $galleryId video gallery id
   *
   */
  public function update() {
//
    //get form data
    $input = Input::all();
    if(!Input::has('id')){
        return Response()->json(array('success' => false, 'message'=> 'Video does not found.'));
    }
    $validation = Validator::make($input, array(
        'title' => 'required|Unique:videos,title,'.$input['id'].'|Min:5|Max:124',
        'description' => 'required|Min:5|Max:500',
        'galleryId' => 'required',
        'price' => 'Integer|Min:0'
      ));
    

    if ($validation->passes()) {
      $userData = AppSession::getLoginData();
      if (!$userData || $userData->role == UserModel::ROLE_MEMBER) {
        return Response()->json(array('success' => false, 'errors' => array(), 'message' => 'Please login with model role'));
      }

      $video = VideoModel::where('id', $input['id']);
      if ($userData->role == UserModel::ROLE_MODEL) {
        $video = $video->where('ownerId', $userData->id);
      }
      $video = $video->first();
      $video->title = $input['title'];
      $video->seo_url = str_slug($input['title']);
      $video->description = $input['description'];
      $video->price = $input['price'];
      $video->galleryId = $input['galleryId'];
      if ($video->save()) {
        $url = ($userData->role == UserModel::ROLE_MODEL) ? BASE_URL . 'models/dashboard/media/view-video/' . $video->id : BASE_URL . 'admin/manager/video-gallery/' . $video->ownerId;
        return Response()->json(array('success' => true, 'errors' => '', 'message' => 'Update successfully.', 'id' => $video->id, 'url' => $url));
      }
      return Response()->json(array('success' => false, 'errors' => '', 'message' => 'Save data error.'));
    } else {
      return Response()->json(array('success' => false, 'errors' => $validation->errors()));
    }
  }

  public function findVideoName(Request $req) {
    $userData = AppSession::getLoginData();

    if (!$userData) {
      return Response()->json(array('success' => false, 'message' => 'Please, login to add Video'));
    }

    $videoTitle = (Input::has('title')) ? $req->get('title') : null;
    $galleryId = (Input::has('gallery')) ? $req->get('gallery') : null;
    $videoId = ($req->get('id')) ? $req->get('id') : null;
    $check = VideoModel::where('title', '=', $videoTitle)
      ->where('galleryId', $galleryId);
    if ($videoId) {
      $check = $check->where('id', '<>', $videoId);
    }
    $check = $check->first();
    if ($check) {
      return Response()->json(array('success' => true, 'message' => 'Video name already existed'));
    }
  }

  /**
   * @param id $id video id
   * @author Phong Le <pt.hongphong@gmail.com>
   * status : active: show on member or inactive hidden it
   * * */
  public function setVideoStatus($id) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(array('success' => false, 'message' => 'Please, login again.'));
    }
    $media = VideoModel::where('id', $id)
      ->where('ownerId', $userData->id)
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

  /**
   * @param int $id video id
   * @return Response
   * @author Phong Le <pt.hongphong@gmail.com>
   * @access public
   * @group admin
   */
  public function getVideoById($id) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(['success' => false, 'error' => 'Please login.']);
    }
    $video = VideoModel::where('id', $id);
    if ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN) {
      $video = $video->where('ownerId', $userData->id);
    }
    $video = $video->first();
    if (!$video) {
      return Response()->json(['success' => false, 'error' => 'Video not exist.']);
    }
    return Response()->json(['success' => true, 'video' => $video]);
  }

}
