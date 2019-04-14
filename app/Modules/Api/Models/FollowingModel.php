<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class FollowingModel extends Model {


  protected $table = "following";

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  const FOLLOW = 'follow';
  const DIS_FOLLOW = 'disfollow';
  const TYPE_MODEL ='model';

}
