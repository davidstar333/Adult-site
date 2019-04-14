<?php

namespace App\Modules\Model\Models;

/**
 * Description of PerformerProduct
 *
 * @author tuongtran
 */
class PerformerProduct extends Model {

  protected $table = 'performer_products';
  protected $fillable = ['performerId', 'name', 'description', 'token', 'isActive', 'imageId', 'inStock'];

  public function image() {
    return $this->hasOne('App\Modules\Api\Models\AttachmentModel', 'id', 'imageId');
  }
}
