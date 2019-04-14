<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class HelpCategoriesModel extends Model {

  protected $table = "helpcategories";
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  const ACTIVE = 'active';
  const INACTIVE = 'inactive';

}
