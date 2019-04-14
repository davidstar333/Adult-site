<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class NotifiSettingModel extends Model {
  protected $table = "notifisetting";
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
}
