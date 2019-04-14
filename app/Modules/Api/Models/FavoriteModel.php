<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteModel extends Model {

  protected $table = "favorites";

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  const LIKE = 'like';
  const UNLIKE = 'unlike';

}
