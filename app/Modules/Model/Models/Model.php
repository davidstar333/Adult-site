<?php

namespace App\Modules\Model\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel {

  /**
   * The name of the "created at" column.
   *
   * @var string
   */
  const CREATED_AT = 'createdAt';

  /**
   * The name of the "updated at" column.
   *
   * @var string
   */
  const UPDATED_AT = 'updatedAt';

  //
}
