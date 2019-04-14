<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class PerformerChatModel extends Model {

  protected $table = "performerchats";
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  public static function getPerformerChat($role, $modelId) {
    $data = PerformerChatModel::where('model_id', '=', $modelId)->first();
    if ($data) {
      return $data;
    } else {
      return null;
    }
  }

  public static function updatePerformerChat($data) {
    $data = PerformerChatModel::where('model_id', $data['model_id'])
      ->update($data);
    if ($data) {
      return $data;
    } else {
      return null;
    }
  }

}
