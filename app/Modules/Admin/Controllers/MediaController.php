<?php

  namespace App\Modules\Admin\Controllers;

  use App\Http\Requests;
  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;
  use App\Modules\Api\Models\VideoModel;
  use App\Modules\Api\Models\UserModel;
  use App\Helpers\Session as AppSession;


  class MediaController extends Controller {

      /**
       * @param int $modelId owner gallery id
       * @param int $galleryId selected gallery
       * @return Response 
       * @author Phong Le <pt.hongphong@gmail.com>
       */
      public function uploadNewVideo($modelId, $galleryId) {

          return view('Admin::upload_new_video')->with('galleryId', $galleryId)->with('modelId', $modelId);
      }

      /**
       * @param int $videoId
       * @return Response 
       * @author Phong Le <pt.hongphong@gmail.com>
       */
      public function editVideoInfo($id) {
          $video = VideoModel::find($id);
          if (!$video) {
              return Back()->with('msgError', 'Video not exist.');
          }
          return view('Admin::admin_edit_video_info')->with('video', $video);
      }
      public function uploadVideo($modelId) {
        $model = UserModel::find($modelId);
        if (!$model) {
          return Back()->with('msgError', 'Model does not exist!');
        }
        return view('Admin::upload_video')->with('modelId', $modelId);

      }
      public function editVideo($modelId, $id) {
        $userData = AppSession::getLoginData();
        if ($userData) {
          $video = VideoModel::where('id', $id)
            ->where('ownerId', $modelId)
            ->first();

          if ($video) {
            return view('Admin::edit_video')->with('video', $video)->with('modelId', $modelId);
          } else {
            return Back()->with('msgError', 'Video does not exist!');
          }
        }
      }

  }
  