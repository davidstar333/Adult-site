<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class PageModel extends Model {

  protected $table = "pages";

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  const STATUS_ACTIVE = 'active';
  const STATUS_INACTIVE = 'inactive';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'title', 'description'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  
  public function getRouteKeyName() {
      return 'alias';
  }
}
