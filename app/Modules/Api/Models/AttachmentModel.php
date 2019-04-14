<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class AttachmentModel extends Model {

  protected $table = "attachment";

  const PROCESSING = 'processing';
  const ACTIVE = 'active';
  const INACTIVE = 'inactive';
  const ERROR = 'error';
  const TYPE_PROFILE = 'profile';
  const VIDEO = 'video';
  const TRAILER = 'trailer';
  const POSTER = 'poster';
  const FEED = 'feed';
  const IMAGE = 'image';
  const MAIN_YES = 'yes';
  const MAIN_NO = 'no';
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';

  public static function createMedia($userId, $path, $mimeType, $size, $mediaType, $parentId) {
    $attachment = new AttachmentModel();
    $attachment->owner_id = $userId;
    $attachment->path = $path;
    $attachment->type = $mimeType;
    $attachment->size = $size;
    $attachment->media_type = $mediaType;
    $attachment->parent_id = $parentId;
    $attachment->status = AttachmentModel::PROCESSING;
    $attachment->main = 'no';
    $attachment->save();
    return $attachment;
  }

  //get media of model
  public static function getModelImages($modelId, $options = array()) {
    $limit = ($options['limit']) ? $options['limit'] : LIMIT_PER_PAGE;
    $orderBy = isset($options['orderBy']) ? $options['orderBy'] : 'createdAt';
    $sort = isset($options['sort']) ? $options['sort'] : 'desc';
    return AttachmentModel::select('id')
        ->where('owner_id', $modelId)
        ->where('media_type', 'image')
        ->orderBy($orderBy, $sort)
        ->paginate($limit);
  }

}
