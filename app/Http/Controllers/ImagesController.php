<?php 


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Image;
use App\Modules\Api\Models\AttachmentModel;
use App\Modules\Api\Models\GalleryModel;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Modules\Api\Models\UserModel;
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;

class ImagesController extends Controller {

    public function show($id, $year, $month, $day, $slug)
    {
    	//check public image
    	$media = AttachmentModel::select('g.*', 'attachment.status as imageStatus')
    	->join('galleries as g', 'g.id', '=', 'attachment.parent_id')
    	->where('attachment.id', $id)
    	->where('g.status', '<>', GalleryModel::INVISIBLESTATUS)
    	->first();
    	if(!$media){
    		$storagePath = 'images/no_image_thumb.png';
    	}else{


	    	if($media->status == GalleryModel::PUBLICSTATUS){
	    		$storagePath = 'uploads/models/' . $year  . '/' . $month . '/' . $day . '/' . $slug;
	    	}

	    	//check owner if gallery is private
	    	if($media->status = GalleryModel::PRIVATESTATUS){
	    		$userData = AppSession::getLoginData();
	    		if($userData && $userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN && $userData->id != $media->ownerId){
		    		$payment = PaymentTokensModel::where('itemId', $media->id)
		    		->where('item', PaymentTokensModel::ITEM_IMAGE)
		    		->where('ownerId', $userData->id)
		    		->count();
		    		if($payment > 0){
		    			$storagePath = 'uploads/models/' . $year  . '/' . $month . '/' . $day . '/' . $slug;
		    		}

		    	}else if($userData && $userData->id = $media->ownerId){
		    		$storagePath = 'uploads/models/' . $year  . '/' . $month . '/' . $day . '/' . $slug;
		    	}else{
		    		$storagePath = 'images/no_image_thumb.png';
		    	}
	    	}
	    }

    	if(!file_exists(public_path($storagePath))){
    		$storagePath = 'images/no_image_thumb.png';
    	}

        return Image::make($storagePath)->response();

    }

    public function showById($id, Request $req)
    {

    	//check public image
    	$media = AttachmentModel::select('g.*', 'attachment.status as imageStatus', 'attachment.mediaMeta', 'attachment.path')
    	->join('galleries as g', 'g.id', '=', 'attachment.parent_id')
    	->where('attachment.id', $id)
    	// ->where('g.status', '<>', GalleryModel::INVISIBLESTATUS)
    	->first();

    	$size = IMAGE_MEDIUM;
    	if($req->has('size')){
    		$size = $req->get('size');
    	}
    	if(!$media || !AppHelper::is_serialized($media->mediaMeta)){

    		$storagePath = 'images/no_image_thumb_'.$size.'.png';
    	}

    	if($media && AppHelper::is_serialized($media->mediaMeta) ){ 
    		$mediaMeta = unserialize($media->mediaMeta);

    		if (isset($mediaMeta[$size])) {
		        $path = $mediaMeta[$size];

		      } else {

		        $path = $media->path;
		      }

	    	if($media->status == GalleryModel::PUBLICSTATUS){


	    		$storagePath = $path;
	    	}

	    	//check owner if gallery is private
	    	else {

	    		$userData = AppSession::getLoginData();
	    		
	    		if($userData && $userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN && $userData->id != $media->ownerId){
		    		$payment = PaymentTokensModel::where('itemId', $media->id)
		    		->where('item', PaymentTokensModel::ITEM_IMAGE)
		    		->where('ownerId', $userData->id)
		    		->count();
		    		if($payment > 0){
		    			$storagePath = $path;
		    		}

		    	}else if($userData && $userData->id = $media->ownerId){
		    		$storagePath = $path;
		    	}else{
		    		$storagePath = 'images/no_image_thumb_'.$size.'.png';
		    	}
	    	}
	    }
	    
    	if(!file_exists(public_path($storagePath))){
    		if(file_exists(public_path('images/no_image_thumb_'.$size.'.png'))){
    			$storagePath = 'images/no_image_thumb_'.$size.'.png';
    		}else{
    			$storagePath = 'images/no_image_thumb.png';
    		}
    	}


        return Image::make($storagePath)->response();

    }
}