<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Session as AppSession;
use Carbon\Carbon;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\AttachmentModel;
use App\Events\ConvertImage;
use App\Jobs\ProcessConvertVideo;
use App\Helpers\Helper as AppHelper;

class MediaHelper {

	public static function upload($userData, $uploadFile, $mediaType, $parentId, $modelId){
	    $file = array('items' => $uploadFile);
	    $mediaType = ($mediaType) ? $mediaType : null;

	    $rules = array(
	      'items' => 'required',
	    );
	    $validator = Validator::make($file, $rules);
	  
	    if (count($_FILES) === 0 || empty($_FILES['myFiles']['tmp_name'])) {
	      return array('success' => false, 'message' => 'The uploaded file was too large. You must upload a file smaller than ' . ini_get("post_max_size"), 'error' => '', 'file' => '');
	    }


	    if ($validator->fails()) {
	      return array('success' => false, 'error' => $validator->errors()->all()[0], 'message' => $validator->errors()->all()[0], 'file' => '');
	    } else {
	      if ($uploadFile->isValid()) {
	        $destinationPath = 'uploads/models/' . Carbon::now()->format('Y/m/d'); // upload path
	        $extension = $uploadFile->getClientOriginalExtension(); // getting image extension
	        $fileName = 'original-' . substr(MD5(time()), 0, 10) . '-' . str_slug($file['items']->getClientOriginalName()).'.'.$extension;
	        $size = $uploadFile->getSize();
	        if ($uploadFile->getMimeType() === 'application/octet-stream') {
	          $mimeType = 'video/mp4';
	        } else {
	          $mimeType = $uploadFile->getMimeType();
	        }

	        $uploadFile->move($destinationPath, $fileName); // uploading file to given path
	        $path = $destinationPath . '/' . $fileName;
	        $parentId = $parentId;

	        $ownerId = $userData->id;
	        if (($userData->role == UserModel::ROLE_ADMIN || $userData->role == UserModel::ROLE_SUPERADMIN) && $modelId) {
	          $ownerId = $modelId;
	        }
	        $attachment = AttachmentModel::createMedia($ownerId, $path, $mimeType, $size, $mediaType, $parentId);

	        if (strpos($mimeType, 'image') !== false) {
	          \Event::fire(new ConvertImage($attachment));
	        }
	        $uploadFile = AttachmentModel::find($attachment->id);
	        return array('success' => true, 'error' => '', 'message' => 'Upload successfully', 'file' => $uploadFile);
	      } else {
	        return array('success' => false, 'error' => 'uploaded file is not valid', 'message' => '', 'file' => '');
	      }
	    }
	}
	public static function setProfileImage($userData, $attachmentId){
	    $image = AttachmentModel::where('id', $attachmentId)
	        ->where('owner_id', $userData->id)->first();
	    $image->status = 'Profile picture';
	    $image->save();
	    $avatar = $image->mediaMeta;
	    $preProfile = AttachmentModel::where('owner_id', $userData->id)
	      ->where('status', 'Profile picture')
	      ->where('id', '<>', $attachmentId)
	      ->first();
	    if ($preProfile) {
	      $preProfile->status = 'active';
	      $preProfile->save();
	    }
	    //check image exist
	    if(!AppHelper::is_serialized($avatar)){
	        return array('success' => false, 'message' => 'Image format error');
	    }
	    $imageMeta = unserialize($avatar);
	    if(!file_exists(public_path($imageMeta[IMAGE_SMALL]))){
	        return array('success' => false, 'message' => 'Image not exist.');
	    }

	    $user = UserModel::find($userData->id);
	    $user->avatar = $avatar;
	    $user->smallAvatar = $imageMeta[IMAGE_SMALL];

	    if($user->save()){
	        AppSession::setAvatar($user->smallAvatar);
	        return array('success' => true, 'message' => 'Success! The image was set as default profile image.');
	    }
	    return array('success' => false, 'message' => 'System error. Profile does not save.');
	}
}