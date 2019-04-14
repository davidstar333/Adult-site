<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class VideoModel extends Model {

  protected $guarded = array();
  public static $rules = array(
    'title' => 'required',
    'description' => 'required',
    'galleryId' => 'required',
    'price' => 'Integer|Min:0'
  );
  protected $table = "videos";

  const PROCESSING = 'processing';
  const SUCCESS = 'success';
  const ACTIVE = 'active';
  const INACTIVE = 'inactive';
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';

  public static function getModelVideos($modelId, $options = array()) {
    $limit = ($options['limit']) ? $options['limit'] : LIMIT_PER_PAGE;
    $orderBy = isset($options['orderBy']) ? $options['orderBy'] : 'createdAt';
    $sort = isset($options['sort']) ? $options['sort'] : 'desc';
    return VideoModel::select('videos.*', 'a.mediaMeta as posterMeta')
        ->join('attachment as a', 'a.id', '=', 'videos.poster')
        ->where('videos.status', VideoModel::ACTIVE)
        ->orderBy($orderBy, $sort)
        ->paginate($limit);
  }

}
