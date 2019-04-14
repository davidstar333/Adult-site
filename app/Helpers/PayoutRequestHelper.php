<?php
namespace App\Helpers;

use App\Modules\Studio\Models\StudioPayoutRequest;
use App\Modules\Api\Models\PerformerModel;
use App\Modules\Model\Models\PerformerPayoutRequest;
use App\Modules\Api\Models\EarningModel;

class PayoutRequestHelper {
  public static function getEarningByRequestedDate($options){    
    if($options['startDate'] && $options['endDate']){
      $startDate = $options['startDate'];
      $endDate = date('Y-m-d', strtotime("+1 day", strtotime($options['endDate'])));
      $wherePayment = '(earnings.createdAt between "'.$startDate.'" and "'.$endDate.'")'
              . ' AND earnings.payTo='.$options['userId']
              . ' AND earnings.status IS NULL';
      $earning = EarningModel::selectRaw('ROUND(SUM(earnings.tokens),2) as amount')
              ->join('users as u', 'u.id', '=', 'earnings.payTo')   
              ->whereRaw($wherePayment)              
              ->groupBy('earnings.payTo')
              ->first();
      return ($earning)?$earning->amount : 0;      
    } 
    return 0;
  }

  public static function getLastestRequestPayout($options){        
    if($options['type'] === 'performer'){
      $performerModel = PerformerModel::where('user_id', $options['userId'])->first();
      $requestPayout = PerformerPayoutRequest::where('performerId', $performerModel->id)->where('status', PerformerPayoutRequest::STATUS_APPROVE)->orderBy('id', 'DESC')->first();
    }else if($options['type'] === 'studio'){
      $requestPayout = StudioPayoutRequest::where('studioId', $options['userId'])->where('status', PerformerPayoutRequest::STATUS_APPROVE)->orderBy('id', 'DESC')->first();
    } 
    
    $payout = 0;
    if($requestPayout && $requestPayout->payout){
      $payout = $requestPayout->payout;
    }
    return $payout;
  }

  public static function getTotalPendingBalance($options){
    $wherePayment = 'earnings.payTo='. $options['userId']
                  . ' AND earnings.status IS NULL';
    $earning = EarningModel::selectRaw('ROUND(SUM(earnings.tokens),2) as amount')
              ->join('users as u', 'u.id', '=', 'earnings.payTo')   
              ->whereRaw($wherePayment)              
              ->groupBy('earnings.payTo')
              ->first();
    return ($earning)?$earning->amount : 0;    
  }
}