<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\ChatThreadUserModel;
use Illuminate\Http\Request;

class ChatThreadUserController extends Controller {

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function findByRoom($roomId) {
    $roomData = ChatThreadUserModel::findByRoom($roomId);
    if ($roomData != NULL) {
      return $roomData;
    }
  }

}
