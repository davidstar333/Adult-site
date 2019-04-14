<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Api\Models\AttachmentModel;
use DB;
use Carbon;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Modules\Api\Models\EarningSettingModel;
class EarningModel extends Model {

  protected $table = "earnings";

  const REFERREDMEMBER = 'referredMember';
  const PERFORMERSITEMEMBER = 'performerSiteMember';
  const OTHERMEMBER = 'otherMember';
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';

  public static function getGalleryImagePoster($parentId = null, $modelId = null) {
    $ImagePoster = AttachmentModel::where('owner_id', '=', $modelId)
        ->where('parent_id', '=', $parentId)->where('main', '=', 'yes')->first();
    if (!empty($ImagePoster)) {
      $countItems = AttachmentModel::where('owner_id', '=', $modelId)
          ->where('parent_id', '=', $parentId)->count();
      return [
        'ImagePoster' => PATH_UPLOAD . $ImagePoster->path,
        'countItems' => $countItems
      ];
    } else {
      $countItems = AttachmentModel::where('owner_id', '=', $modelId)
          ->where('parent_id', '=', $parentId)->count();
      return [
        'ImagePoster' => PATH_IMAGE . 'upload/model/no-image.png',
        'countItems' => $countItems
      ];
    }
  }

  public static function getMyEarned($userdata, $filter = 'today', $type = '') {
    $earning = EarningModel::select(DB::raw('sum(tokens) as totalTokens'))
      ->where('payTo', $userdata->id);

    if($type){
      $earning = $earning->where('item', $type);
    }
    if ($filter == 'today') {
      $earning = $earning->where(DB::raw("DATE_FORMAT(earnings.createdAt, '%Y-%m-%d')"), date('Y-m-d'));
    } else if ($filter == 'week') {
      $earning = $earning->whereBetween('createdAt', [
        Carbon\Carbon::parse('last monday')->startOfDay(),
        Carbon\Carbon::parse('next sunday')->endOfDay()
      ]);
    }
    return $earning->first();
  }
  public static function getAdminEarned($userdata, $commission, $convensionRate = 1){
    $payment = PaymentTokensModel::select(DB::raw('sum(tokens) as totalTokens'))
      ->where('modelId', $userdata->id)->first();
    return ($payment->totalTokens*((100 - $commission)/100))*$convensionRate;
  }
  public static function getStudioEarned($userdata, $commission){
    // get total token from model
    $payment = PaymentTokensModel::select(DB::raw('sum(tokens) as totalTokens'))
      ->where('modelId', $userdata->id)->first();
    $commissionStudio = $commission - $userdata->referredMember;
    return ($payment->totalTokens*($commissionStudio/100));
  }
}
