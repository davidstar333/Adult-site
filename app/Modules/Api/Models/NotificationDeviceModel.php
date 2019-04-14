<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationDeviceModel extends Model {

  protected $table = "notificationdevices";
  
  const PUSH_YES = 'YES';
  const PUSH_NO = 'NO';
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  
}
