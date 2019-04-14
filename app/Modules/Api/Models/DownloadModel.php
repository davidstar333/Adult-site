<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class DownloadModel extends Model {

  protected $table = "download";

  const ITEM_VIDEO = 'video';
  const ITEM_IMAGE = 'image';
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';

}
