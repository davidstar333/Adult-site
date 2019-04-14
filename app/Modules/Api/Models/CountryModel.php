<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model {

  protected $table = "countries";

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  
  
  public function performer(){
      return $this->belongsTo(PerformerModel::class);
  }
}
