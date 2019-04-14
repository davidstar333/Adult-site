<?php

namespace App\Modules\Model\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Api\Models\UserModel;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\AttachmentModel;
use App\Modules\Api\Models\GalleryModel;
use App\Modules\Api\Models\VideoModel;
use App\Modules\Api\Models\LikeModel;
use DB;

class MediaController extends Controller {

  /** Add image gallery
   * return @gallery param
   * author: Phong Le <pt.hongphong@gmail.com>
   * **/
  public function addImageGallery() {
    return view('Model::model_dashboard_gallery_new')->with('galleryType', 'image');
  }

  public function addImage() {
    return view('Model::model_dashboard_image_new');
  }

  /**Add video gallery
   * return @gallery param
   * author: Phong Le <pt.hongphong@gmail.com>
   * **/
  public function addVideoGallery() {
    return view('Model::model_dashboard_gallery_new')->with('galleryType', 'video');
  }

  /**
   * return @gallery param
   * author: Phong Le <pt.hongphong@gmail.com>
   * **/
  public function editVideoGallery($id) {
    $userData = AppSession::getLoginData();
    if ($userData) {
      $gallery = GalleryModel::select('galleries.*', 'attachment.mediaMeta')
        ->where('galleries.id', $id)
        ->leftJoin('attachment', 'attachment.id', '=', 'galleries.previewImage')
        ->where('galleries.ownerId', $userData->id)
        ->first();

      if ($gallery) {
        return view('Model::model_dashboard_gallery_edit')->with('gallery', $gallery);
      } else {
        return redirect('models/dashboard/media/video-galleries');
      }
    }
  }

  /**edit image gallery
   * return @gallery param
   * author: Phong Le <pt.hongphong@gmail.com>
   * **/
  public function editImageGallery($id) {
    $userData = AppSession::getLoginData();
    if ($userData) {
      $gallery = GalleryModel::where('id', $id)
        ->where('ownerId', $userData->id)
        ->first();

      if ($gallery) {
        return view('Model::model_dashboard_gallery_edit')->with('gallery', $gallery);
      } else {
        return redirect('models/dashboard/media/image-galleries');
      }
    }
  }

  /**edit image gallery
   * return @gallery param
   * author: Phong Le <pt.hongphong@gmail.com>
   * **/
  public function editImage($id) {
    $userData = AppSession::getLoginData();
    if ($userData) {
      $gallery = GalleryModel::where('id', $id)
        ->where('ownerId', $userData->id)
        ->first();

      if ($gallery) {
        $attachment = AttachmentModel::where('parent_id', $gallery->id)->first();
        return view('Model::model_dashboard_image_edit')->with('gallery', $gallery)->with('attachment', $attachment);
      } else {
        return redirect('models/dashboard/media/image-galleries');
      }
    }
  }

  /*   * *

   * * */

  public function myImages() {
    return view('Model::model_dashboard_images');
  }

  public function myImageGalleries() {
    return view('Model::model_dashboard_image_galleries');
  }

  public function myVideoGalleries() {


    return view('Model::model_dashboard_video_galleries');
  }

  public function viewVideoDetail($id) {
    $userData = AppSession::getLoginData();

    if ($userData && $userData->role == 'model') {
      $video = DB::select(DB::raw("SELECT *, (select ap.mediaMeta from attachment ap where ap.media_type = 'poster' AND ap.id = v.poster limit 1) as posterMeta, (SELECT at.mediaMeta FROM attachment at WHERE at.media_type='trailer' AND at.id=v.trailer) as trailerMeta, (SELECT am.mediaMeta FROM attachment am WHERE am.media_type='video' AND am.id=v.fullMovie) as fullMeta FROM videos v WHERE v.ownerId = {$userData->id} AND v.id={$id}"));
      if ($video) {
        return view('Model::model_dashboard_view_video_detail')->with('video', $video[0]);
      } else {
        return redirect('models/dashboard/media/video-galleries');
      }
    } else {
      return redirect('/');
    }
  }

  public function editVideo($id) {
    $userData = AppSession::getLoginData();
    if ($userData) {
      $video = VideoModel::where('id', $id)
        ->where('ownerId', $userData->id)
        ->first();

      if ($video) {
        return view('Model::model_dashboard_video_gallery_edit')->with('video', $video);
      } else {
        return redirect('models/dashboard/media/videos');
      }
    }
  }

  /**

    /***

   * * */
  public function myVideos() {
    return view('Model::model_dashboard_videos');
  }

  /**
    TODO: Member Dashboard profile
   * */
  public function getMyProfile() {
    $getUserLogin = AppSession::getLoginData();
    if (!$getUserLogin) {
      return redirect('login');
    }
    $getMember = UserModel::find($getUserLogin->id);
    return view('Model::model_dashboard_profile')->with('getMember', $getMember);
  }

  /**
    TODO: Member Dashboard profile
   * */
  public function getProfileImages() {
    $getUserLogin = AppSession::getLoginData();
    if (!$getUserLogin) {
      return redirect('login');
    }
    $profileImages = AttachmentModel::where('media_type', 'profile')
      ->where('owner_id', $getUserLogin->id)
      ->get();

    return view('Model::model_dashboard_profile_view_images')->with('profileImages', $profileImages);
  }


  public function myImageGallery($id) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect('/login');
    }
    $gallery = GalleryModel::where('id', $id)
      ->where('type', 'image')
      ->where('ownerId', $userData->id)
      ->first();
    return view('Model::model_dashboard_image_gallery')->with('gallery', $gallery);
  }

  public function myVideoGallery($id) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect('/login');
    }
    $gallery = GalleryModel::where('id', $id)
      ->where('type', 'video')
      ->where('ownerId', $userData->id)
      ->first();
    return view('Model::model_dashboard_video_gallery')->with('gallery', $gallery);
  }

  //upload video
  public function uploadVideo(Request $req) {
    $userData = AppSession::getLoginData();
    if ($userData && $userData->role == 'model') {
      return view('Model::model_dashboard_video_gallery_upload');
    } else {
      return redirect('login');
    }
  }

  /**
    TODO: Get Gallery View
   * */
  public function getGalleryView($username, $id) {
    $getModel = UserModel::where('username', '=', $username)->first();
    if (!empty($getModel)) {
      $checkGalleryExisting = GalleryModel::find($id);
      if (!empty($checkGalleryExisting)) {
        $galleryRelates = GalleryModel::where('id', '<>', $id)->where('ownerId', '=', $getModel->id)->where('type', '=', 'image')->take(5)->orderbyRaw('RAND()')->get();
        $getImageGallery = AttachmentModel::where('owner_id', '=', $getModel->id)->where('parent_id', '=', $id)->where('status', '=', 'active')->get();
        return view('Model::view_pictures_detail')
            ->with('model', $getModel)
            ->with('action', 'pictures')
            ->with('modelGallery', $getImageGallery)
            ->with('galleryInfo', $checkGalleryExisting)
            ->with('galleryRelates', $galleryRelates);
      } else {
        return redirect('profile/' . $getModel->username . '?view=pictures')->with('msgError', 'Gallery not found!');
      }
    } else {
      return redirect('community')->with('msgError', 'Request not allowed!.');
    }
  }

/**
  * action  video view detail
  * @return response
  * @author LongPham <long.it.stu@gmail.com>
  **/
  public function getVideoView($username,$id){
    $getModel = UserModel::where('username', '=', $username)->first();
    if (!empty($getModel)) {
      $checkGalleryExisting = GalleryModel::find($id);
      if (!empty($checkGalleryExisting)) {
        $modelVideo = AttachmentModel::where('owner_id', '=', $getModel->id)->where('parent_id', '=', $id)->where('status', '=', 'active')->paginate(LIMIT_PER_PAGE);
        return view('Model::view_video_detail')
            ->with('model', $getModel)
            ->with('action', 'videos')
            ->with('modelVideo', $modelVideo)
            ->with('galleryInfo', $checkGalleryExisting);
      } else {
        return redirect('profile/' . $getModel->username . '?view=videos')->with('msgError', 'Gallery not found!');
      }
    } else {
      return redirect('community')->with('msgError', 'Request not allowed!.');
    }
  }

  /**
  * action get video
  * @return response
  * @author LongPham <long.it.stu@gmail.com>
  **/
  // public function getVideo($id){
  //   $checkItemExisting = AttachmentModel::where('id','=',$postItem['itemId'])->where('media_type','=','video')->first();
  //   if(!empty($checkItemExisting)){
  //     $path =$checkItemExisting->path;
  //     header("X-Sendfile: $path");
  //     header("Content-Type: application/octet-stream");
  //     header("Content-Disposition: attachment; filename=\"file.mp4\"");
  //   }
  // }
  /**
  * action get video item
  * @return response
  * @author LongPham <long.it.stu@gmail.com>
  **/
  public function postVideoItem(Request $get){
    if(\Request::ajax()){
      $postItem = $get->only('itemId');
      $checkItemExisting = AttachmentModel::where('id','=',$postItem['itemId'])->where('media_type','=','video')->first();
      $getVideoLike = LikeModel::where('item','=',LikeModel::TYPE_VIDEO)->where('item_id','=',$postItem['itemId'])->count();
      if(!empty($checkItemExisting)){
        return response()->json([
              'success' => true,
              'poster' => unserialize($checkItemExisting->mediaMeta)['jpg'],
              'videoSD' => PATH_UPLOAD.$checkItemExisting->path,
              'videoHD' => '',
              'totalLike'=> $getVideoLike
        ],200);
      }else{
        return response()->json([
              'success' => false,
              'message' => 'Video not found !',
        ],404);
      }
    }else{
      return redirect()->back()->with('msgError','Request not allowed');
    }
  }

  /**
  * action Like video item
  * @return response
  * @author LongPham <long.it.stu@gmail.com>
  **/
  public function postLikeVideoItem(Request $get){
    if(\Request::ajax()){
      if(AppSession::isLogin()){
        $userLogin = AppSession::getLoginData();
        $postItem = $get->only('itemId','ownerId');
        $checkExisting = LikeModel::where('item_id','=',$postItem['itemId'])->where('owner_id','=',$userLogin->id)->where('item','=',LikeModel::TYPE_VIDEO)->first();
        if(!empty($checkExisting)){
          return response()->json([
            'success' => false,
            'message' => 'You liked it.Can not like it again.'
            ],200);
        }else{
          $addLike = new LikeModel();
          $addLike->item = LikeModel::TYPE_VIDEO;
          $addLike->item_id = $postItem['itemId'];
          $addLike->owner_id = $userLogin->id;
          $addLike->status = LikeModel::LIKE;
          if($addLike->save()){
            return response()->json([
              'success' => true,
              'message' => 'Like model successful'
              ],200);
          }
        }
      }else{
       return response()->json([
        'success' => false,
        'message' => 'Request timeout.'
        ],400);
     }
   }else{
    return redirect()->back()->with('msgError','Request not allowed');
  }
}

  //--TODO Move all FeedController function to here.

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id) {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id) {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id) {
    //
  }

  public function myMediaVideos() {
    return view('Model::model_dashboard_media_video');
  }

}
