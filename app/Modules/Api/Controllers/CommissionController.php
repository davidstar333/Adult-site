<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Api\Models\UserModel;
use App\Helpers\Session as AppSession;
use DB;

class CommissionController extends Controller {

  /**
   * @author Phong Le <pt.hongphong@gmail.com>

   * @return Response
   */
  public function detail($id) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
//      return redirect::to('admin/login')->with('msgError', 'Please login with admin role');
      return null;
    }
//    /SELECT e.*, u.parentId,u.username, u1.username as childName FROM users u inner join earningsettings e on u.id = e.userId left join users u1 on u1.parentId = u.id where u.role='admin'
    $commission = UserModel::select('e.*', 'users.username', 'users.parentId', 'u1.username as studioName', DB::raw('(SELECT e1.referredMember FROM earningsettings e1 where e1.userId=u1.id) AS studioReferredMember'), DB::raw('(SELECT e2.performerSiteMember FROM earningsettings e2 where e2.userId=u1.id) AS studioPerformerSiteMember'), DB::raw('(SELECT e3.otherMember FROM earningsettings e3 where e3.userId=u1.id) AS studioOtherMember'), 'u2.username as modelName', DB::raw('(SELECT e4.referredMember FROM earningsettings e4 where e4.userId=u2.id) AS modelReferredMember'), DB::raw('(SELECT e5.performerSiteMember FROM earningsettings e5 where e5.userId=u2.id) AS modelPerformerSiteMember'), DB::raw('(SELECT e6.otherMember FROM earningsettings e6 where e6.userId=u2.id) AS modelOtherMember'))
        ->join('earningsettings as e', 'users.id', '=', 'e.userId')
        ->leftJoin('users as u1', 'u1.parentId', '=', 'users.id')
        ->leftJoin('users as u2', 'u2.parentId', '=', 'u1.id')
        ->where('e.id', $id)
        ->where('users.role', '=', 'admin')->first();



    return Response()->json(array('success' => true, 'data' => $commission));
  }

}
