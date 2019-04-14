<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class MeetHerModel extends Model {

  protected $table = "meether";

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  const WAITING = 'waiting';
  const ACCEPTED = 'accepted';
  const REFUSED = 'refused';
}
