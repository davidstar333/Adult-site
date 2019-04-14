<?php

namespace App\Modules\Api\Models;
use App\Modules\Api\Models\UserModel;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper as AppHelper;


class MessageModel extends Model {
    protected $table = "messages";
    const SENT  = 'sent';
    const RECEIVED  = 'received';
    const TRASH  = 'trash';
    const DELETE  = 'delete';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
  
}
