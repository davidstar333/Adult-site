<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentPackageModel extends Model {


  protected $table = "paymentpackages";
  protected $fillable = ['price', 'description', 'tokens'];

  const YES = 'yes';
  const NO = 'no';

  const CANDY_PAYMENT = 'candy';
  const VIDEO_PAYMENT = 'video';
  const IMAGE_PAYMENT = 'image';

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';

}
