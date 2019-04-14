<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Api\Models\AttachmentModel;
use App\Helpers\Session as AppSession;

class GalleryModel extends Model {

  protected $guarded = array();
  public static $rules = array(
    'name' => 'required',
    'description' => 'required',
    'type' => 'required'
  );
  protected $table = "galleries";

  const PRIVATESTATUS = 'private';
  const PUBLICSTATUS = 'public';
  const INVISIBLESTATUS = 'invisible';
  const IMAGE = 'image';
  const VIDEO = 'video';
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';

  public static function getGalleryImagePoster($parentId = null, $modelId = null) {
    $ImagePoster = AttachmentModel::where('owner_id', '=', $modelId)
        ->where('parent_id', '=', $parentId)->where('main', '=', 'yes')->first();
    if (!empty($ImagePoster)) {
      $countItems = AttachmentModel::where('owner_id', '=', $modelId)
          ->where('parent_id', '=', $parentId)->count();
      return [
        'ImagePoster' => PATH_UPLOAD . $ImagePoster->path,
        'countItems' => $countItems
      ];
    } else {
      $countItems = AttachmentModel::where('owner_id', '=', $modelId)
          ->where('parent_id', '=', $parentId)->count();
      return [
        'ImagePoster' => PATH_IMAGE . 'upload/model/no-image.png',
        'countItems' => $countItems
      ];
    }
  }
  
  public function user(){
      return $this->belongsTo(UserModel::class);
  }

}
