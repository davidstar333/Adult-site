<?php

namespace App\Modules\Media\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Modules\Api\Models\VideoModel;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\GalleryModel;
use App\Modules\Api\Models\AttachmentModel;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Modules\Api\Models\DownloadModel;
use App\Helpers\Session as AppSession;
use DB;

class MediaController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function getVideos(Request $req) {
    $userData = AppSession::getLoginData();
    $ownerId = ($userData) ? $userData->id : 0;
    $videos = VideoModel::select('videos.*', 'a.mediaMeta as posterMeta', 'a1.mediaMeta as videoMeta', 'u.username')
      ->where('videos.status', VideoModel::ACTIVE)
      ->join('attachment as a', 'a.id', '=', 'videos.poster')
      ->join('attachment as a1', 'a1.id', '=', 'videos.fullMovie')
      ->join('users as u', 'u.id', '=', 'videos.ownerId')
      ->join('galleries as g', 'g.id', '=', 'videos.galleryId')
      ->where('g.status', GalleryModel::PUBLICSTATUS)
      ->where('u.accountStatus', UserModel::ACCOUNT_ACTIVE)
      ->where('u.role', UserModel::ROLE_MODEL);

    if ($req->has('q')) {
      $videos = $videos->where('videos.title', 'like', '%' . $req->get('q') . '%');
    }
    if ($req->has('gallery')) {
      $videos = $videos->where('videos.galleryId', $req->get('gallery'));
    }
    if ($req->has('model')) {
      $videos = $videos->where('u.username', $req->get('model'));
    }
    $videos = $videos->paginate(LIMIT_PER_PAGE);
    return view("Media::media_list_videos", compact('videos'));
  }
  
  /**
   * gallery videos
   */
  public function getVideosByGallery($slug, Request $req){
      
      $userData = AppSession::getLoginData();
    $ownerId = ($userData) ? $userData->id : 0;
    //check gallery
    $gallery = GalleryModel::select('galleries.*', 'u.username', 'u.firstName', 'u.lastName')
            ->join('users as u', 'u.id', '=', 'galleries.ownerId')
            ->where('u.role', UserModel::ROLE_MODEL)
            ->where('u.accountStatus', UserModel::ACCOUNT_ACTIVE)
            ->where('slug', $slug)
            ->where('galleries.status', GalleryModel::PUBLICSTATUS)
            ->first();
    
    if(!$gallery){
        return Redirect('videos')->with('msgError', 'Gallery does not exist or not available.');
    }
    
    $videos = VideoModel::select('videos.*', 'a.mediaMeta as posterMeta', 'a1.mediaMeta as videoMeta', 'u.username')
      ->where('videos.status', VideoModel::ACTIVE)
      ->join('attachment as a', 'a.id', '=', 'videos.poster')
      ->join('attachment as a1', 'a1.id', '=', 'videos.fullMovie')
      ->join('users as u', 'u.id', '=', 'videos.ownerId')
      ->where('u.accountStatus', UserModel::ACCOUNT_ACTIVE)
      ->where('u.role', UserModel::ROLE_MODEL)
      ->where('videos.galleryId', $gallery->id);
    if ($req->has('q')) {
      $videos = $videos->where('videos.title', 'like', '%' . $req->get('q') . '%');
    }
    if ($req->has('gallery')) {
      $videos = $videos->where('videos.galleryId', $req->get('gallery'));
    }
    if ($req->has('model')) {
      $videos = $videos->where('u.username', $req->get('model'));
    }
    $videos = $videos->paginate(LIMIT_PER_PAGE);
    
    return view("Media::media_gallery_videos", compact('videos', 'gallery'));
  }

  /*
   * view settings page
   */

  public function getVideoDetail($slug) {
    $userData = AppSession::getLoginData();
    $ownerId = ($userData) ? $userData->id : 0;
    $video = VideoModel::select('videos.*', 'a.mediaMeta as posterMeta', 'a1.mediaMeta as trailerMeta', 'a2.mediaMeta as videoMeta', 'u.username', DB::raw("(SELECT p.id FROM paymenttokens p where p.itemId=videos.id AND p.item='" . PaymentTokensModel::ITEM_VIDEO . "' AND p.status <> '".PaymentTokensModel::STATUS_REJECT."' AND p.ownerId={$ownerId}) AS bought"))
      ->where('videos.status', VideoModel::ACTIVE)
      ->join('attachment as a', 'a.id', '=', 'videos.poster')
      ->join('attachment as a1', 'a1.id', '=', 'videos.trailer')
      ->join('attachment as a2', 'a2.id', '=', 'videos.fullMovie')
      ->join('users as u', 'u.id', '=', 'videos.ownerId')
      ->where('videos.seo_url', $slug)
      ->first();
    if (!$video) {
      return Back()->with('msgError', 'Video not exist or not available.');
    }
    return view("Media::media_video_detail", [
      'video' => $video
    ]);
  }

  /*
   * view settings page
   */

  public function downloadVideo($id) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('/')->with('msgError', 'Please, login before download this video');
    }
    $video = VideoModel::select('videos.*', 'a.path')
      ->where('videos.status', VideoModel::ACTIVE)
      ->join('attachment as a', 'a.id', '=', 'videos.fullMovie')
      ->join('users as u', 'u.id', '=', 'videos.ownerId')
      ->join('paymenttokens as p', 'p.itemId', '=', 'videos.id')
      ->where('p.ownerId', $userData->id)
      ->where('videos.id', $id)
      ->first();
    if (!$video) {
      return Back()->with('msgError', 'Video not exist or you does not buy it yet.');
    }
    $videoDownload = VideoModel::find($id);
    $videoDownload->increment('download', 1);
    if ($videoDownload->save()) {
      $zip = new \ZipArchive();
      $zip_name = 'uploads/' . md5(time()) . ".zip"; // Zip name
      $zip->open($zip_name, \ZipArchive::CREATE);
      if (file_exists($video->path)) {
        $zip->addFromString(basename($video->path), file_get_contents($video->path));
      } else {
        echo"file does not exist";
      }

      $zip->close();

      $downloadZip = new DownloadModel;
      $downloadZip->path = $zip_name;
      $downloadZip->ownerId = $userData->id;
      $downloadZip->item = DownloadModel::ITEM_VIDEO;
      $downloadZip->save();

      return response()->download(public_path($zip_name))->deleteFileAfterSend(true);
    }
    return Redirect('/')->with('msgError', 'System error');
  }

  /**
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function getImageGalleries() {
    $galleries = GalleryModel::select('galleries.*', DB::raw("(SELECT a.mediaMeta FROM attachment a WHERE a.parent_id=galleries.id AND a.main='" . AttachmentModel::MAIN_YES . "' AND a.status='".AttachmentModel::ACTIVE."' limit 1) as mainImage"), DB::raw("(SELECT a.mediaMeta FROM attachment a WHERE a.parent_id=galleries.id AND a.status='".AttachmentModel::ACTIVE."'  limit 1) as subImage"))
      ->join('users as u', 'u.id', '=', 'galleries.ownerId')
      ->where('galleries.status', '!=', GalleryModel::INVISIBLESTATUS)
      
      ->where('galleries.type', GalleryModel::IMAGE)
      ->where('u.accountStatus', UserModel::ACCOUNT_ACTIVE);
    
     
     
    if (Input::has('q') && !empty(Input::get('q'))) {
      $galleries = $galleries->where('galleries.name', 'like', Input::get('q') . '%');
    }
    $galleries = $galleries->paginate(LIMIT_PER_PAGE);
    return view("Media::media_image_galleries")->with('galleries', $galleries);
  }

  /**
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function getImageGallery($slug) {
    $userData = AppSession::getLoginData();
    $ownerId = ($userData) ? $userData->id : 0;
    //check model or member
    $gallery = GalleryModel::where('slug', $slug)
            ->where('type', GalleryModel::IMAGE)
            ->first();
    if(!$gallery){
        return Redirect('media/image-galleries')->with('msgError', 'Gallery does not exist.');
    }
    
    if ($gallery && $gallery->status == GalleryModel::PRIVATESTATUS) {
      $currentGallery = $gallery;
      $gallery = GalleryModel::join('paymenttokens as p', 'p.itemId', '=', 'galleries.id')
        ->where('galleries.id', $gallery->id)
        ->where('p.item', PaymentTokensModel::ITEM_IMAGE)
        ->where('p.ownerId', $ownerId)
        ->where('p.status', '<>', PaymentTokensModel::STATUS_REJECT)
        ->first()
      ;
      if (!$gallery) {
          
          //TODO request puy gallery here 
          //
        return view("Media::media_image_preview")->with('owner', false)->with('gallery', $currentGallery);
        
      }
    }
    
    
    $images = AttachmentModel::select('attachment.id', 'g.name as galleryName')
      ->join('galleries as g', 'g.id', '=', 'attachment.parent_id')
      ->where('attachment.status', AttachmentModel::ACTIVE)
      ->where('g.slug', $slug)
      ->paginate(LIMIT_PER_PAGE);

    return view("Media::media_image_preview")->with('images', $images)->with('gallery', $gallery);
  }
  
  /**
   * Buy image gallery
   */
  public function buyImageGallery($id){
      
      $userData = AppSession::getLoginData();
      
      if(!$userData){
          
          $cookie = \Cookie::make('backUri', \Request::path(), 5);
          
          return redirect('login')->withCookie($cookie);
          
      }
      
      $gallery = GalleryModel::where('id', $id)
            ->where('type', GalleryModel::IMAGE)
            ->first();
      if(!$gallery){
          return Redirect('media/image-galleries')->with('msgError', 'Gallery does not exist.');
      }
      
      
      //check bought
      $payment = PaymentTokensModel::where('paymenttokens.item', PaymentTokensModel::ITEM_IMAGE)
              ->where('paymenttokens.ownerId', $userData->id)
              ->where('paymenttokens.status', '!=', PaymentTokensModel::STATUS_REJECT)
              ->where('paymenttokens.itemId', $id)
              ->first();
      
      
      if($payment){
          
         return Redirect('media/image-gallery/preview/'.$gallery->slug)->with('msgWarning', 'You have already bought this gallery.');     
      }
      
      //check user tokens.
      $member = UserModel::find($userData->id);
      if(!$member){
          Cookie::queue('backUri', \Request::url(), 15);
          AppSession::getLogout();
      }
      if($member->tokens < intval($gallery->price)){
          return redirect('members/my-candies')->with('msgInfo', 'Your tokens do not enough, please buy more.');
      }

      $member->decrement('tokens', intval($gallery->price));
      if($member->save()){
          
          $buy = new PaymentTokensModel();
          $buy->tokens = intval($gallery->price);
          $buy->item = PaymentTokensModel::ITEM_IMAGE;
          $buy->status = PaymentTokensModel::STATUS_PROCESSING;
          $buy->itemId = $id;
          $buy->modelId = $gallery->ownerId;
          $buy->ownerId = $member->id;
          
          if($buy->save()){
              
              return redirect('media/image-gallery/preview/'.$gallery->slug)->with('msgInfo', 'Thank for your payment');
          }else{
              $member->increment('tokens', intval($gallery->price));
              $member->save();
          }
      }
      
      return redirect('media/image-gallery/preview/'.$gallery->slug)->with('msgError', 'Payment process error. Please try again later.');
      
      
  }
  /**
  * buy video
  */
  public function buyVideo($id){

      $userData = AppSession::getLoginData();
      
      if(!$userData){
          
          $cookie = \Cookie::make('backUri', \Request::path(), 5);
          
          return redirect('login')->withCookie($cookie);
          
      }
      
      $video = VideoModel::where('id', $id)
            ->where('status', VideoModel::ACTIVE)
            ->first();

      if(!$video){
          return Redirect('videos')->with('msgError', 'Video does not exist or not available.');
      }
      
      //check bought
      $payment = PaymentTokensModel::where('paymenttokens.item', PaymentTokensModel::ITEM_VIDEO)
              ->where('paymenttokens.ownerId', $userData->id)
              ->where('paymenttokens.status', '!=', PaymentTokensModel::STATUS_REJECT)
              ->where('paymenttokens.itemId', $id)
              ->first();
      
      
      if($payment){
          
         return Redirect('media/video/watch/'.$video->seo_url)->with('msgWarning', 'You have already bought this video.');
      }
      
      //check user tokens.
      $member = UserModel::find($userData->id);
      if(!$member){
          Cookie::queue('backUri', \Request::url(), 15);
          AppSession::getLogout();
      }
      if($member->tokens < $video->price){
          return redirect('members/my-candies')->with('msgInfo', 'Your tokens do not enough, please buy more.');
      }
      
      $member->decrement('tokens', $video->price);
      if($member->save()){
          $buy = new PaymentTokensModel();
          $buy->tokens = $video->price;
          $buy->item = PaymentTokensModel::ITEM_VIDEO;
          $buy->status = PaymentTokensModel::STATUS_PROCESSING;
          $buy->itemId = $id;
          $buy->modelId = $video->ownerId;
          $buy->ownerId = $member->id;
          if($buy->save()){
              return redirect('media/video/watch/'.$video->seo_url)->with('msgInfo', 'Thank for your payment');
          }else{
              $member->increment('tokens', $video->price);
              $member->save();
          }
      }
      return redirect('media/video/watch/'.$video->seo_url)->with('msgError', 'Payment process error. Please try again later.');
  }

  /**
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function downloadImageGallery($id) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('/')->with('msgError', 'Please, login before download this gallery.');
    }

    //check model or member
    $gallery = GalleryModel::where('ownerId', $userData->id)
      ->where('id', $id);
    if (!$gallery) {
      $gallery = GalleryModel::join('paymenttokens as p', 'p.itemId', '=', 'galleries.id')
        ->where('galleries.id', $id)
        ->where('p.item', PaymentTokensModel::ITEM_IMAGE)
        ->where('p.ownerId', $ownerId)
        ->first()
      ;
      if (!$gallery) {
        return Redirect('media/image-galleries')->with('msgError', 'You does not have permission on this gallery');
      }
    }
    $download = GalleryModel::find($id);
    $download->increment('download', 1);
    if ($download->save()) {
      $images = AttachmentModel::select('attachment.id', 'g.name as galleryName', 'attachment.path')
        ->join('galleries as g', 'g.id', '=', 'attachment.parent_id')
        ->where('attachment.status', AttachmentModel::ACTIVE)
        ->where('g.id', $id)
        ->get();
      $zip = new \ZipArchive();
      $zip_name = $zip_name = 'uploads/' . md5(time()) . ".zip"; // Zip name
      $zip->open($zip_name, \ZipArchive::CREATE);
      foreach ($images as $file) {
        if (file_exists($file->path)) {
          $zip->addFromString(basename($file->path), file_get_contents($file->path));
        } else {
          echo"file does not exist";
        }
      }

      $zip->close();
      $downloadZip = new DownloadModel;
      $downloadZip->path = $zip_name;
      $downloadZip->ownerId = $userData->id;
      $downloadZip->item = DownloadModel::ITEM_IMAGE;
      $downloadZip->save();

      return response()->download(public_path($zip_name))->deleteFileAfterSend(true);
    }
    return Redirect('/')->with('msgError', 'System error');
  }

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

}
