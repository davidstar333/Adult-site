<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\GalleryModel;
use App\Modules\Api\Models\AttachmentModel;

class GalleryController extends Controller {

  /**
   * @param int $id model id
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   * 
   */
  public function getVideoGallery($id) {
    //check login
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect::to('admin/login')->with('message', 'Please login with admin role');
    }
    $model = UserModel::find($id);
    if (!$model) {
      return Back()->with('msgError', 'Model does not exist.');
    }
    return view('Admin::admin_list_video_galleries')->with('user', $model);
  }

  /**
   * @param int $id model id
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   * 
   */
  public function getImageGallery($id) {
    //check login
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return redirect::to('admin/login')->with('message', 'Please login with admin role');
    }
    $model = UserModel::find($id);
    if (!$model) {
      return Back()->with('msgError', 'Model does not exist.');
    }
    return view('Admin::admin_list_image_galleries')->with('user', $model);
  }

  /**
   * @param int $id model id
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   * 
   */
  public function addVideoGallery($modelId) {
    //check login
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return redirect::to('admin/login')->with('message', 'Please login with admin role');
    }
    $model = UserModel::find($modelId);
    if (!$model) {
      return Back()->with('msgError', 'Model does not exist.');
    }
    return view('Admin::admin_add_gallery')->with('user', $model)->with('galleryType', 'video');
  }

  /**
   * @param int $id model id
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   * 
   */
  public function addImageGallery($modelId) {
    //check login
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return redirect::to('admin/login')->with('message', 'Please login with admin role');
    }
    $model = UserModel::find($modelId);
    if (!$model) {
      return Back()->with('msgError', 'Model does not exist.');
    }
    return view('Admin::admin_add_gallery')->with('user', $model)->with('galleryType', 'image');
  }

  public function addImage($modelId) {
    //check login
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return redirect::to('admin/login')->with('message', 'Please login with admin role');
    }
    $model = UserModel::find($modelId);
    if (!$model) {
      return Back()->with('msgError', 'Model does not exist.');
    }
    return view('Admin::admin_add_image')->with('user', $model);
  }

  /**
   * return @gallery param
   * author: Phong Le <pt.hongphong@gmail.com>
   * * */
  public function getEditVideoGallery($id) {

    $gallery = GalleryModel::select('galleries.*', 'attachment.mediaMeta')
      ->where('galleries.id', $id)
      ->leftJoin('attachment', 'attachment.id', '=', 'galleries.previewImage')
      ->first();

    if ($gallery) {
      return view('Admin::admin_edit_gallery')->with('gallery', $gallery);
    } else {
      return Back()->with('msgError', 'Gallery does not exist.');
    }
  }

  /**
   * @param int $id gallery id
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function getListVideos($id) {
    $gallery = GalleryModel::find($id);
    if (!$gallery) {
      return Back()->with('msgError', 'Gallery not found.');
    }
    return view('Admin::admin_list_videos')->with('gallery', $gallery);
  }

  /**
   * @param int $id gallery id
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function getListImages($id) {
    $gallery = GalleryModel::find($id);
    if (!$gallery) {
      return Back()->with('msgError', 'Gallery not found.');
    }
    return view('Admin::admin_list_images')->with('gallery', $gallery);
  }

  /**
   * return @gallery param
   * author: Phong Le <pt.hongphong@gmail.com>
   * * */
  public function getEditImageGallery($id) {

    $gallery = GalleryModel::where('galleries.id', $id)
      ->where('type', GalleryModel::IMAGE)
      ->first();

    if ($gallery) {
      return view('Admin::admin_edit_gallery')->with('gallery', $gallery);
    } else {
      return Back()->with('msgError', 'Gallery does not exist.');
    }
  }

  /**edit image gallery
   * return @gallery param
   * author: Phong Le <pt.hongphong@gmail.com>
   * **/
  public function editImage($modelId, $galleryId) {
    $userData = AppSession::getLoginData();
    if ($userData) {
      $gallery = GalleryModel::where('id', $galleryId)
        ->where('ownerId', $modelId)
        ->first();

      if ($gallery) {
        $attachment = AttachmentModel::where('parent_id', $gallery->id)->first();
        return view('Admin::admin_edit_image')->with('gallery', $gallery)->with('attachment', $attachment)->with('modelId', $modelId);
      } else {
        return redirect('admin/manager/image-gallery/'.$modelId);
      }
    }
  }

}
