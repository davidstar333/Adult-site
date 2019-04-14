<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\EarningModel;
use App\Modules\Api\Models\EarningSettingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Helpers\Session as AppSession;
use DB;
use App\Modules\Model\Models\PerformerPayoutRequest;

class EarningController extends Controller {

  /**
   * @param Request $Start start Date (yyyy-mm-dd) filter
   * @param Request $end $end End date filter
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return query fiter query use for find report and pagination below
   * return earning data 
   * @param request $start Date Start
   * @param Request $End Date end
   * */
  public function findReport() {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return null;
    }
    $filter = Input::all();
    $userId = $userData->id;
    if(Input::get('performerId')){
      $userId = Input::get('performerId');
    }
    $filterStart = (Input::has('start') && $filter['start'] != 'null') ? $filter['start'] : null;
    $filterEnd = (Input::has('end') && $filter['end'] != 'null') ? $filter['end'] : null;


    $group = (Input::has('group')) ? $filter['group'] : 'day';
//    $query = EarningController::filterQuery($filter, $userData);
    $page = (Input::has('page')) ? $filter['page'] : 0;
    $take = (Input::has('take')) ? $filter['take'] : LIMIT_PER_PAGE;
//    $skip = (Input::has('skip')) ? $filter['skip'] : ($page * $take);
//    $query .= " LIMIT {$skip}, {$take}";
    if ($group == 'day') {
      $earnings = EarningModel::select(DB::raw("SUM(tokens) AS totalTokens"), DB::raw("DATE_FORMAT(createdAt, '%Y-%m-%d') as datetime"))
        ->where('payTo', $userId)->whereNull('earnings.status');
      ;
      if ($filterStart && $filterEnd) {
        $earnings = $earnings->whereBetween(DB::raw("DATE_FORMAT(earnings.createdAt, '%Y-%m-%d')"), array($filterStart, $filterEnd));
      }
      $earnings = $earnings->groupBy(DB::raw("DATE_FORMAT(createdAt, '%Y-%m-%d')"));
      $earnings = $earnings->orderBy('createdAt', 'desc');
      return $earnings->paginate($take);
    }if ($group == 'month') {
      $earnings = EarningModel::select(DB::raw("SUM(tokens) AS totalTokens"), DB::raw("DATE_FORMAT(createdAt, '%Y-%m') as datetime"))
        ->where('payTo', $userId)->whereNull('earnings.status');
      if ($filterStart && $filterEnd) {
        $earnings->whereBetween(DB::raw("DATE_FORMAT(earnings.createdAt, '%Y-%m-%d')"), array($filterStart, $filterEnd));
      }
      $earnings->groupBy(DB::raw("DATE_FORMAT(createdAt, '%Y-%m')"));
      $earnings->orderBy('createdAt', 'desc');
      return $earnings->paginate($take);
    }
    $earnings = EarningModel::select('earnings.id', 'earnings.tokens', 'earnings.status', 'earnings.type', 'u.username', 'earnings.item', 'earnings.itemId', DB::raw("DATE_FORMAT(earnings.createdAt, '%Y-%m-%d') AS datetime"))
      ->join('users as u', 'u.id', '=', 'earnings.payFrom')
      ->where('earnings.payTo', $userId)
      ->whereNull('earnings.status');

    if ($filterStart && $filterEnd) {
      $earnings = $earnings->whereBetween(DB::raw("DATE_FORMAT(earnings.createdAt, '%Y-%m-%d')"), array($filterStart, $filterEnd));
    }
    $earnings = $earnings->groupBy('earnings.id')
        ->orderBy('earnings.createdAt', 'DESC')->paginate($take);
    return $earnings;
  }

  /*
   * Check gallery or video item before delete it
   * @params: item id: gallery id,
   * @params: type: gallery type(image, video)
   * @author: Phong Le <pt.hongphong@gmail.com>
   * @return integer
   */

  public function countPaidGallery(Request $req) {
    $item = $req->get('item');
    $itemId = $req->get('item-id');
    if ($item == 'video') {
      return EarningModel::leftJoin('videos', 'videos.id', '=', 'earnings.itemId')
          ->where('videos.galleryId', $itemId)
          ->where('item', 'video')
          ->count();
    } else {
      return EarningModel::leftJoin('galleries', 'galleries.id', '=', 'earnings.itemId')
          ->where('earnings.item', 'image')
          ->where('galleries.type', 'image')
          ->where('galleries.id', $itemId)
          ->where('earnings.itemId', $itemId)
          ->count();
    }
  }

  /*
   * Check image or video item before delete it
   * @params: item id: video or image id,
   * @params: type: type(image, video)
   * @author: Phong Le <pt.hongphong@gmail.com>
   * @return integer
   */

  public function countPaidItem(Request $req) {
    $item = $req->get('item');
    $itemId = $req->get('item-id');

    if ($item == 'video') {
      return EarningModel::where('earnings.itemId', $itemId)
          ->where('item', 'video')
          ->count();
    } else {
      return EarningModel::leftJoin('attachment', 'attachment.parent_id', '=', 'earnings.itemId')
          ->where('attachment.media_type', 'image')
          ->where('earnings.item', 'image')
          ->where('attachment.id', $itemId)
          ->count();
    }
  }

  /*
   * return []
   * date: filter by this date
   */

  public function getDetail(Request $req) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return null;
    }
    if ($req->get('by') == 'day') {
      $day = $req->get('filter');
      // return EarningModel::select('earnings.id', 'earnings.tokens', 'earnings.status', 'earnings.type', 'u.username', DB::raw('concat(u.firstName, " ", u.lastName) as fromName'), 'earnings.item', 'earnings.itemId', DB::raw('concat(u1.firstName, " ", u1.lastName) as modelName'), 'earnings.createdAt')
      //     ->join('users as u', 'u.id', '=', 'earnings.payFrom')
      //     ->join('paymenttokens as p', 'p.id', '=', 'earnings.itemId')
      //     ->join('users as u1', 'u1.id', '=', 'p.itemId')
      //     ->where("earnings.createdAt", 'like', $day . '%')
      //     ->where('earnings.payTo', $userData->id)
      //     ->orderBy('earnings.createdAt', 'desc')
      //     ->get();
       return EarningModel::select('earnings.id', 'earnings.tokens', 'earnings.status', 'earnings.type', 'u.username', DB::raw('concat(u.firstName, " ", u.lastName) as fromName'), 'earnings.item', 'earnings.itemId', 'earnings.createdAt')
          ->join('users as u', 'u.id', '=', 'earnings.payFrom')
          ->where("earnings.createdAt", 'like', $day . '%')
          ->where('earnings.payTo', $userData->id)
          ->orderBy('earnings.createdAt', 'desc')
          ->get();
    } else {
      $id = $req->get('filter');

      $detail = EarningModel::select('earnings.id', 'earnings.tokens', 'earnings.status', 'earnings.type', 'u.username',  DB::raw('concat(u.firstName, " ", u.lastName) as fromName'), 'earnings.item', DB::raw('concat(u1.firstName, " ", u1.lastName) as modelName'), 'earnings.itemId', 'earnings.createdAt')
        ->join('users as u', 'u.id', '=', 'earnings.payFrom')
        ->join('paymenttokens as p', 'p.id', '=', 'earnings.itemId')
        ->join('users as u1', 'u1.id', '=', 'p.itemId')
        ->where('earnings.id', $id)
        ->orderBy('earnings.createdAt', 'desc')
        ->first();

      return $detail;
    }
  }

  /**
   * return json 
   * params: model commission 
   */
  public function ModelEarningCommission() {
    $userData = AppSession::getLoginData();

    if ($userData && $userData->role == 'model') {
      $commission = EarningSettingModel::where('userId', $userData->id)
        ->first();
      return $commission;
    }
  }

  /**
   * @param int $id payment id
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   * 
   */
  public function getEarningByItem($item, $id) {
    $earning = EarningModel::select('u.username', 'earnings.item', 'earnings.tokens', 'earnings.percent')
      ->join('users as u', 'u.id', '=', 'earnings.payTo')
      ->where('itemId', $id)
      ->where('item', $item)
      ->get();
    if (count($earning) > 0) {
      return Response()->json(['success' => true, 'results' => $earning]);
    }
    return Response()->json(['success' => false, 'message' => 'Earning detail not found.']);
  }

  /**
   * @return Response 
   * @author Phong Le
   */
  public function getStatics() {
    $userLogin = AppSession::getLoginData();
    if (!$userLogin) {
      return null;
    }

    return EarningModel::select('earnings.*', 'paymenttokens.tokens as earned')
        ->where('users.id', '=', $userLogin->id)
        ->join('users', 'users.id', '=', 'earnings.payTo')
        ->join('paymenttokens', 'paymenttokens.id', '=', 'earnings.itemId')
        ->get()->toArray();
  }

}
