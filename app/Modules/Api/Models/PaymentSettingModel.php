<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSettingModel extends Model {

  
  protected $table = "paymentsettings";

  const YES = 'yes';
  const NO = 'no';
  
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';

}
