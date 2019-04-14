<?php

  namespace App\Modules\Api\Models;

  use Illuminate\Database\Eloquent\Model;

  class GeoBlockingModel extends Model {

      protected $table = "geo_blockings";
      protected $fillable = array('userId', 'iso_code', 'isBlock');
      
      const isBlock = 1;
      
      const CREATED_AT = 'createdAt';
      const UPDATED_AT = 'updatedAt';

  }