<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Modules\Api\Models\VideoModel;
use App\Modules\Api\Models\GalleryModel;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\AttachmentModel;
use DB;
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;

class MediaController extends Controller {

  const HDQUALITY = 'hd';
  const SDQUALITY = 'sd';

  //
  /**
   * Create a response that will force a image to be displayed inline.
   *
   * @param string $path Path to the image
   * @param string $name Filename
   * @param int $lifetime Lifetime in browsers cache
   * @return Response
   */
  public function show($type, $id) {

    if ($type == 'video') {
      $media = VideoModel::select('videos.id as videoId', 'attachment.media_type', 'videos.price', 'videos.ownerId as modelId', 'attachment.type as mime', 'attachment.mediaMeta')
          ->join('attachment', 'attachment.id', '=', DB::raw("CASE media_type WHEN 'trailer' THEN videos.trailer WHEN 'video' THEN videos.fullMovie END"))
          ->where('attachment.id', $id)->first();
    } else {
      $media = GalleryModel::select('attachment.type as mime', 'attachment.media_type', 'galleries.price', 'galleries.ownerId as modelId', 'galleries.id as galleryId', 'attachment.mediaMeta', 'attachment.path')
        ->join('attachment', 'attachment.parent_id', '=', 'galleries.id')
        ->where('attachment.media_type', 'image')
        ->where('galleries.type', 'image')
        ->where('attachment.id', $id)
        ->first();
    }

    if (!$media || !AppHelper::is_serialized($media->mediaMeta)) {
      header("HTTP/1.1 404 Not Found");
      return;
    }
//    if ($media->price > 0 && $media->media_type != AttachmentModel::TRAILER) {
//      $userData = AppSession::getLoginData();
//      if (!$userData) {
//        return null;
//      }
//      if ($userData->role != UserModel::ROLE_ADMIN && $userData->id != $media->modelId && !AppHelper::checkPaymentPaidItem($id, $type)) {
//        return redirect('/')->with('msgError', 'You have not permission on this media.');
//      }
//    }
    $mediaMeta = unserialize($media->mediaMeta);
    if ($type == 'video') {
      $quality = (\Request::has('q')) ? \Request::get('q') : MediaController::SDQUALITY;
      if (isset($mediaMeta['hd']) && $quality == MediaController::HDQUALITY) {
        if (isset($mediaMeta['hd']['mp4'])) {
          $path = $mediaMeta['hd']['mp4'];
        }
      } else if ((isset($mediaMeta['sd']) && $quality == MediaController::SDQUALITY) || !isset($mediaMeta['hd'])) {
        //sd video
        if (isset($mediaMeta['sd']['mp4'])) {
          $path = $mediaMeta['sd']['mp4'];
        }
      }
    } else {
      $quality = (\Request::has('q')) ? \Request::get('q') : IMAGE_THUMBNAIL260;

      if (isset($mediaMeta[$quality])) {
        $path = $mediaMeta[$quality];
      } else {
        $path = $media->path;
      }
    }

    if (!isset($path) || !file_exists($path)) {
      header("HTTP/1.1 404 Not Found");
      return;
    }
    $mime = $media->mime;
    $length = filesize($path);

    $name = basename($path);
    $filetime = filemtime($path);
    $etag = md5($filetime . $path);
    $time = gmdate('r', $filetime);
    $expires = gmdate('r', $filetime + 0);
    $length = filesize($path);



    if ($type == 'video') {
      $fm = @fopen($path, 'rb');
      if (!$fm) {
        header("HTTP/1.1 505 Internal server error");
        return;
      }
      $begin = 0;
      $end = $length - 1;

      if (isset($_SERVER['HTTP_RANGE'])) {
        if (preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches)) {
          $begin = intval($matches[1]);
          if (!empty($matches[2])) {
            $end = intval($matches[2]);
          }
        }
      }
      if (isset($_SERVER['HTTP_RANGE'])) {
        header('HTTP/1.1 206 Partial Content');
      } else {
        header('HTTP/1.1 200 OK');
      }
//
      header("X-Sendfile: $name");
      header("Content-Type: application/octet-stream");

//      header("content-type: $mime");
//      header("content-length: $length");
//      header("Content-Disposition: inline; filename=$name");
      header("Cache-Control: public, must-revalidate, max-age=0");
      header('Accept-Ranges: bytes');
      header('Content-Length:' . (($end - $begin) + 1));
      if (isset($_SERVER['HTTP_RANGE'])) {
        header("Content-Range: bytes $begin-$end/$length");
      }
      header("Content-Transfer-Encoding: binary");
      header("Last-Modified: $time");
      header("Expires: $expires");
      header("Prama: public");
      header("Etag: $etag");
      $cur = $begin;
      fseek($fm, $begin, 0);

      while (!feof($fm) && $cur <= $end && (connection_status() == 0)) {
        print fread($fm, min(1024 * 16, ($end - $cur) + 1));
        $cur += 1024 * 16;
      }
    } else {
// @TODO: Cache images generated from this php file
      header("X-Sendfile: $name");
      header("Content-Type: application/octet-stream");
//      header("content-type: $mime");
      header("content-length: $length");
//      header("Content-Disposition: inline; filename=$name");
      header("Cache-Control: public, must-revalidate, max-age=0");
      header("Prama: public");
      header("Etag: $etag");

      return readfile($path);
    }
    die();
  }

}
