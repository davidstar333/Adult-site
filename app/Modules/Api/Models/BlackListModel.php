<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class BlackListModel extends Model {

  protected $table = "blacklist";

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  const LOCK_YES = 'yes';
  const LOCK_NO = 'no';

}
