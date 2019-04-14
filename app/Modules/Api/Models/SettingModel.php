<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model {

  protected $table = "settings";

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';

}
