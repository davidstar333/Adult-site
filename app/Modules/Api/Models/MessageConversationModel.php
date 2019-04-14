<?php

namespace App\Modules\Api\Models;
use App\Modules\Api\Models\UserModel;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper as AppHelper;


class MessageConversationModel extends Model {
    protected $table = "messageconversation";
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    const TRASH  = 'trash';
    const ACTIVE  = 'active';
    const DELETE  = 'delete';
}
