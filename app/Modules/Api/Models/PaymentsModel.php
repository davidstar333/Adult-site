<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentsModel extends Model {

  protected $table = "payments";

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  const CANDY_PAYMENT = 'token';
  const VIDEO_PAYMENT = 'video';
  const IMAGE_PAYMENT = 'image';
  const TOKEN_PAYMENT = 'token';
  const STATUS_APPROVED = 'approved';
  const STATUS_REJECTED = 'rejected';
  const STATUS_ERROR = 'error';
  const STATUS_DENIAL = 'denial';

}
