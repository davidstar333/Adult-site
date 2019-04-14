<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\AttachmentModel;
use Carbon\Carbon;
use App\Events\ActionGenerate;

class UploadController extends Controller {

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function index() {

  }

  public function uploadPhotos(Request $req) {

  }

  public function findMyMedia(Request $req) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect('login');
    }
    $type = $req->get('type');
    $images = AttachmentModel::where('type', 'like', $type . '/%')
        ->where('owner_id', $userData->id)
        ->where('parent_id', 0)->paginate(10);
    return $images;
  }

//upload model image or video
  public function uploadItems(Request $req) {

// getting all of the post data
    $file = array('images' => Input::file('myFiles'));
// setting up rules
    $rules = array('images' => 'required'); //mimes:jpeg,bmp,png and for max size max:10000
// doing the validation, passing post data, rules and the messages
    $validator = Validator::make($file, $rules);
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect('/login');
    }

    if ($validator->fails()) {
// send back to the page with the input data and errors
//return Redirect::to('upload')->withInput()->withErrors($validator);

      return Response()->json(array('success' => false, 'error' => $validator, 'message' => ''));
    } else {
// checking file is valid.
      if (Input::file('myFiles')->isValid()) {
        $destinationPath = 'uploads/models/' . Carbon::now()->format('Y/m/d'); // upload path
        $extension = Input::file('myFiles')->getClientOriginalExtension(); // getting image extension
        $fileName = MD5(time()) . '.' . $extension; // renameing image
        $size = Input::file('myFiles')->getSize();
        $mimeType = Input::file('myFiles')->getMimeType();
        Input::file('myFiles')->move($destinationPath, $fileName); // uploading file to given path
// sending back with message
//store attachment
        $path = $destinationPath . '/' . $fileName;

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
          // 'This is a server using Windows!';
          $commands = array(
            '-i ' . $path,
            '-vcodec copy',
            '-acodec ac3',
            '-ab 384k ' . $destinationPath . 'test.mpg',
            '-acodec mp2',
            '-ab 192k',
            '-newaudio'
          );

          exec('D:\WWW\wamp\www\phpffmpeg\ffmpeg\bin\ffmpeg.exe\\' . implode(' ', $commands), $output);
        } else {
          // 'This is a server not using Windows!';
          if (strpos($mimeType, 'video')) {
            $commands = array(
              '-i ' . $path,
              '-vcodec copy',
              '-acodec ac3',
              '-ab 384k ' . $destinationPath . '/test.mpg',
              '-acodec mp2',
              '-ab 192k',
              '-newaudio'
            );

            shell_exec("ffmpeg" . implode(' ', $commands));
          }
        }



//
        $attachment = new AttachmentModel;
        $attachment->owner_id = $userData->id;
        $attachment->path = $path;
        $attachment->type = $mimeType;
        $attachment->size = $size;
        $attachment->save();

//        event(new ActionGenerate($attachment));

        return Response()->json(array('success' => true, 'errors' => '', 'message' => 'Upload successfully', 'file' => $attachment));
//return Redirect::to('upload');
      } else {
// sending back with error message.
        return Response()->json(array('success' => false, 'error' => 'uploaded file is not valid', 'message' => ''));
      }
    }
  }

  public function countMe(Request $req) {
    $itemId = $req->get('itemId');
    $item = $req->get('item');
    $total = LikeModel::countMe($item, $itemId);
    return $total;
  }

  public function checkMe(Request $req) {
    $check = null;
    if (\Session::has('UserLogin')) {
      $user = json_decode(\Session::get('UserLogin'));
      $owner_id = $user->id;
      $item = $req->get('item');
      $itemId = $req->get('itemId');
      $check = LikeModel::checkMe($itemId, $item, $owner_id);
    }
    return $check;
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
  public function destroy($id) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('/login');
    }
    $file = AttachmentModel::where('id', $id)->where('owner_id', $userData->id)->first();

    if ($file) {
      \File::Delete($file->path);
      $file->delete();

//TODO Delete comment, like
      return Response()->json(array('success' => true, 'error' => '', 'message' => 'Success! The was successfully deleted.'));
    }
    return Response()->json(array('success' => false, 'error' => 'File not exist.', 'message' => ''));
  }

}
