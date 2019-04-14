<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class PerformerModel extends Model {

  protected $table = "performer";
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  
  public function user(){
      return $this->belongsTo(UserModel::class);
  }
  public function country(){
      return $this->hasOne(CountryModel::class, 'id', 'country_id');
  }
  
  public function category(){
      return $this->hasOne(CategoryModel::class, 'id', 'category_id');
  }
}
