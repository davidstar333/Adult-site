<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Api\Models\DocumentModel;
use App\Modules\Api\Models\UserModel;
use App\Helpers\Session as AppSession;
use Response;

class DocumentController extends Controller {

    
    /**
   * @param int $id model id
   * @return response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function getDetail($id) {
    
    $model = UserModel::find($id);
    $document = DocumentModel::where('ownerId', $id)->first();
    return view('Admin::identification', compact('document', 'model'));
  }
  
  
  /**
   * @param int $id model id
   * @return response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function readFile($id) {
    
    $document = DocumentModel::find($id);
    if (!$document) {
      return Redirect('admin/manager/performers')->with('msgError', 'Document not exist');
    }
    
    $extention = last(explode('.', $document->releaseForm));
    if(!file_exists(public_path($document->releaseForm))){
        die('Release form does not exists.');
    }
    if ($extention == 'pdf') {
      return Response::make(file_get_contents(URL($document->releaseForm)), 200, [
          'Content-Type' => 'application/' . $extention,
          'Content-Disposition' => 'inline; ' . "document" . $extention,
      ]);
    }
    return response()->download(public_path($document->releaseForm));
  }

}
