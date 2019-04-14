<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\ChatThreadModel;
use Illuminate\Http\Request;
use Image;

class RoomController extends Controller {

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function checkRoom($roomId) {
    $roomData = ChatThreadModel::checkRoom($roomId);
    if ($roomData != NULL) {
      return $roomData;
    }
  }

  public function setCaptureImage(Request $req, $roomId) {
    //TODO - allow model of this room only

    //if (!$req->get('base64')) { return; }

     
    // $image = public_path('images/rooms/'.$roomId.'.png';
    // $ifp = fopen($image), "wb"); 

     $data = explode(',', $req->get('base64'));

    // fwrite($ifp, base64_decode($data[1])); 
    // fclose($ifp); 

     // return $data; 
     if(!is_dir(public_path('images/rooms'))){
      mkdir(public_path('images/rooms'), 0777, true);
     }
     file_put_contents(join(DIRECTORY_SEPARATOR, [public_path(), 'images', 'rooms', $roomId . '.png']), base64_decode($data[1]));
     file_put_contents(join(DIRECTORY_SEPARATOR, [public_path(), 'images', 'rooms', $roomId.'-'.$req->get('shotNumber') . '.png']), base64_decode($data[1]));
     
  }
}
