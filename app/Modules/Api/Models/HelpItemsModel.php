<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class HelpItemsModel extends Model {

  protected $table = "helpitems";
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  const ACTIVE = 'active';
  const INACTIVE = 'inactive';

}
