<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentModel extends Model {

  protected $table = "documents";

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';

}
