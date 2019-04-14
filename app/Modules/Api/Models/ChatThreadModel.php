<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ChatThreadModel extends Model {

  protected $table = "chatthreads";
  
  const TYPE_PRIVATE = 'private';
  const TYPE_GROUP = 'group';
  const TYPE_PUBLIC = 'public';
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';

  public static function checkRoom($modelId, $type = 'group', $options = []) {
    $check = ChatThreadModel::where('ownerId', '=', $modelId)->where('type', '=', $type);
    if(isset($options['requesterId'])){
      $check = $check->where('requesterId', $options['requesterId']);
    }
      
     $check = $check->first();
    return $check ? $check->id : 0;
  }
  
  public static function createRoom($params){
    $thread = new ChatThreadModel;
    $thread->type = $params['type'];
    $thread->ownerId = $params['modelId'];
    $thread->requesterId = isset($params['requesterId']) ? $params['requesterId'] : null;
    
    $thread->save();
    return $thread;
    
  }
  public static function getStreamingTime($modelId, $type) {
    $model = self::select(DB::raw('sum(streamingTime) as totalStreaming'))
      ->where('ownerId', $modelId);
    if($type){
      $model = $model->where('type', $type);
    }
    
    return $model->first();
  }

}
