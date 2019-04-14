<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class PicturesModel extends Model {
  protected $table = "pictures";
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
}
