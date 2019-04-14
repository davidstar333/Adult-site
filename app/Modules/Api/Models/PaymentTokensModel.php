<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Modules\Api\Models\EarningModel;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\EarningSettingModel;

class PaymentTokensModel extends Model {

  protected $table = "paymenttokens";

  const OTHERMEMBER = 'otherMember';
  const REFERREDMEMBER = 'referredMember';
  const PERFORMERMEMBER = 'performerSiteMember';
  const ITEM_VIDEO = 'video';
  const ITEM_IMAGE = 'image';
  const ITEM_INSTANT = 'instant';
  const ITEM_PREMIUM = 'premium';
  const ITEM_OFFLINE_TIP = 'offline_tip';
  const ITEM_PRIVATE = 'private';
  const ITEM_GROUP = 'group';
  const ITEM_PUBLIC = 'public';
  const ITEM_TIP = 'tip';
  const ITEM_MESSAGE = 'message';
  const ITEM_PERFORMER_PRODUCT = 'performer_product';
  const ITEM_PERFORMER_SOCIAL = 'performer_social';
  const STATUS_APPROVED = 'approved';
  const STATUS_PROCESSING = 'processing';
  const STATUS_REJECT = 'reject';
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';

  public static function checkOwner($userData, $item, $itemId) {
    return PaymentTokensModel::where('ownerId', $userData->id)
                    ->where('item', $item)
                    ->where('status', '<>', PaymentTokensModel::STATUS_REJECT)
                    ->where('itemId', $itemId)
                    ->first();
  }

  public function user() {
    return $this->belongsTo(UserModel::class);
  }

  /**
   * relation with product
   *
   * @return
   */
  public function product() {
    return $this->hasOne(\App\Modules\Model\Models\PerformerProduct::class, 'id', 'itemId');
  }

  public static function approvePayment($id){
    $payment = PaymentTokensModel::where('id',$id)->where('status', PaymentTokensModel::STATUS_PROCESSING)->first();
    
    if (!$payment) {
      return [
        'success' => false,
        'message' => 'Payment not found'
      ];
    }
    $member = UserModel::find($payment->ownerId);
    if(!$member){
      return [
        'success' => false,
        'message' => 'Member not found.'
      ];      
    }
    
    $commission = UserModel::select(
          'p.id as paymentId', 'p.ownerId as payFrom', 'p.item as paymentItem', 'p.tokens as paymentTokens', 'users.id as modelId', 'u1.id as studioId', 'u2.id as adminId', 
      DB::raw("(SELECT CASE u3.role WHEN '" . UserModel::ROLE_MODEL . "' THEN es.performerSiteMember WHEN '" . UserModel::ROLE_MEMBER . "' THEN es.referredMember ELSE otherMember END FROM earningsettings es, users u3 WHERE es.userId = users.id and u3.id=users.id) as modelPercent"), 
      DB::raw("(SELECT CASE u4.role WHEN '" . UserModel::ROLE_MODEL . "' THEN es1.performerSiteMember WHEN '" . UserModel::ROLE_MEMBER . "' THEN es1.referredMember ELSE otherMember END FROM earningsettings es1, users u4 WHERE es1.userId = u1.id and u4.id=users.id) as studioPercent"), 
      DB::raw("(SELECT CASE u5.role WHEN '" . UserModel::ROLE_MODEL . "' THEN es2.performerSiteMember WHEN '" . UserModel::ROLE_MEMBER . "' THEN es2.referredMember ELSE otherMember END FROM earningsettings es2, users u5 WHERE es2.userId = u2.id and u5.id=users.id) as adminPercent"),
      DB::raw("(SELECT CASE u6.role WHEN '" . UserModel::ROLE_MODEL . "' THEN '" . EarningModel::PERFORMERSITEMEMBER . "' WHEN '" . UserModel::ROLE_MEMBER . "' THEN '" . EarningModel::REFERREDMEMBER . "' ELSE '" . EarningModel::OTHERMEMBER . "' END FROM users u6 WHERE u6.id=p.ownerId) as type")
        )
        ->leftJoin('users as u1', 'u1.id', '=', 'users.parentId')
        ->leftJoin('users as u2', 'u2.id', '=', 'u1.parentId')
        ->join('paymenttokens as p', 'p.itemId', '=', DB::raw("CASE WHEN p.item = '".PaymentTokensModel::ITEM_VIDEO."' THEN (SELECT v.id FROM videos v WHERE v.ownerId=users.id AND v.id=p.itemId) WHEN p.item = '".PaymentTokensModel::ITEM_IMAGE."' THEN (SELECT g.id FROM galleries g WHERE g.ownerId=users.id AND g.id=p.itemId) ELSE users.id END"))
        ->where('users.id', DB::raw("CASE WHEN p.item = '".PaymentTokensModel::ITEM_VIDEO."' OR p.item='".PaymentTokensModel::ITEM_IMAGE."' THEN users.id ELSE p.itemId END"))
        ->where('users.role', 'model')
        ->where('p.status', 'processing')
        ->where('p.id', $id)
        ->whereNotIn('p.id', function($q) {
          $q->select('itemId')->distinct()->from('earnings');
        })->first();
        if(!$commission){
            return back()->with('msgError', 'Approve error.');
        }
        $error = false;
        $commissionPercent = 0;
        $paymentTokens = $commission->paymentTokens;
        /* This is loginal from Edgar, so we don't use it for now

        // if model was managed by studio, the studio will get money from admin with studio's commission
        // eg. studio is set 20% for commission, he'll get 0.2 * kisses from member
        $studio = null;
        if ($commission->studioId){
          $studioModel = UserModel::find($commission->studioId);
          if($studioModel && $studioModel->role === UserModel::ROLE_STUDIO){
            $studio = $studioModel;
          }
        }
        if ($studio && !$error) {
          $earningSettingStudio = EarningSettingModel::where('userId', $commission->studioId)->first();
          if($commission->type === EarningModel::REFERREDMEMBER){
            $commissionPercent = $earningSettingStudio->referredMember;
          }else if ($commission->type === EarningModel::PERFORMERSITEMEMBER){
            $commissionPercent = $earningSettingStudio->performerSiteMember;
          }else if ($commission->type === EarningModel::OTHERMEMBER){
            $commissionPercent = $earningSettingStudio->otherMember;
          }
          
          //studio tokens 
          $studio = UserModel::find($commission->studioId);
          if($studio){
            $studio->increment('tokens', ((intval($commissionPercent) / 100) * $paymentTokens));
            if ($studio->save()) {
              $earning = new EarningModel;
              $earning->item = $commission->paymentItem;
              $earning->itemId = $commission->paymentId;
              $earning->payFrom = $commission->payFrom;
              $earning->payTo = $commission->studioId;
              $earning->tokens = ((intval($commissionPercent) / 100) * $paymentTokens);
              $earning->percent = intval($commissionPercent);
              $earning->type = $commission->type;
              if (!$earning->save()) {
                //TODO process error here  
                $error = true;
              }
            }
          }
        }
        // 
        if ($commission->modelId) {
           // if there's a studio, model will receive: model's commission * studio's money
          if($studio){
            $paymentTokens = ((intval($commissionPercent) / 100) * $paymentTokens);
          }
          $earningSettingModel = EarningSettingModel::where('userId', $commission->modelId)->first();
          if($commission->type === EarningModel::REFERREDMEMBER){
            $commissionPercent = $earningSettingModel->referredMember;
          }else if ($commission->type === EarningModel::PERFORMERSITEMEMBER){
            $commissionPercent = $earningSettingModel->performerSiteMember;
          }else if ($commission->type === EarningModel::OTHERMEMBER){
            $commissionPercent = $earningSettingModel->otherMember;
          }
         
          $model = UserModel::find($commission->modelId);
          if($model){
            $model->increment('tokens', (intval($commissionPercent) / 100) * $paymentTokens);
            if ($model->save()) {
              $earning = new EarningModel;
              $earning->item = $commission->paymentItem;
              $earning->itemId = $commission->paymentId;
              $earning->payFrom = $commission->payFrom;
              $earning->payTo = $commission->modelId;
              $earning->tokens = (($commissionPercent / 100) * $paymentTokens);
              $earning->percent = intval($commissionPercent);
              $earning->type = $commission->type;
              if (!$earning->save()) {
                //TODO process error here  
                $error = true;
              }
            }
          }
        }
        */
        // new logic from GK https://trello.com/c/RoVs2l7f/147-commission-setup-scenario
        $studio = null;
        $commissionPercentModel = null;
        if ($commission->modelId) {
          $earningSettingModel = EarningSettingModel::where('userId', $commission->modelId)->first();
          if($commission->type === EarningModel::REFERREDMEMBER){
            $commissionPercentModel = $earningSettingModel->referredMember;
          }else if ($commission->type === EarningModel::PERFORMERSITEMEMBER){
            $commissionPercentModel = $earningSettingModel->performerSiteMember;
          }else if ($commission->type === EarningModel::OTHERMEMBER){
            $commissionPercentModel = $earningSettingModel->otherMember;
          }
         
          $model = UserModel::find($commission->modelId);
          if($model){
            $model->increment('tokens', (intval($commissionPercentModel) / 100) * $paymentTokens);
            if ($model->save()) {
              $earning = new EarningModel;
              $earning->item = $commission->paymentItem;
              $earning->itemId = $commission->paymentId;
              $earning->payFrom = $commission->payFrom;
              $earning->payTo = $commission->modelId;
              $earning->tokens = (($commissionPercentModel / 100) * $paymentTokens);
              $earning->percent = intval($commissionPercentModel);
              $earning->type = $commission->type;
              if (!$earning->save()) {
                //TODO process error here  
                $error = true;
              }
            }
          }
        }
        if ($commission->studioId){
          $studioModel = UserModel::find($commission->studioId);
          if($studioModel && $studioModel->role === UserModel::ROLE_STUDIO){
            $studio = $studioModel;
          }
        }
        if ($studio && !$error) {
          $earningSettingStudio = EarningSettingModel::where('userId', $commission->studioId)->first();
          if($commission->type === EarningModel::REFERREDMEMBER){
            $commissionPercentStudio = $earningSettingStudio->referredMember;
          }else if ($commission->type === EarningModel::PERFORMERSITEMEMBER){
            $commissionPercentStudio = $earningSettingStudio->performerSiteMember;
          }else if ($commission->type === EarningModel::OTHERMEMBER){
            $commissionPercentStudio = $earningSettingStudio->otherMember;
          }
          
          //studio tokens 
          $studio = UserModel::find($commission->studioId);
          if($commissionPercentModel) {
            $commissionPercentStudio = $commissionPercentStudio - $commissionPercentModel;
          }
          if($studio){
            $studio->increment('tokens', ((intval($commissionPercentStudio) / 100) * $paymentTokens));
            if ($studio->save()) {
              $earning = new EarningModel;
              $earning->item = $commission->paymentItem;
              $earning->itemId = $commission->paymentId;
              $earning->payFrom = $commission->payFrom;
              $earning->payTo = $commission->studioId;
              $earning->tokens = ((intval($commissionPercentStudio) / 100) * $paymentTokens);
              $earning->percent = intval($commissionPercentStudio);
              $earning->type = $commission->type;
              if (!$earning->save()) {
                //TODO process error here  
                $error = true;
              }
            }
          }
        }
      if(!$error){
      //change payment status to approved
      
        $payment->status = PaymentTokensModel::STATUS_APPROVED;
        if($payment->save()){
          return [
            'success' => true,
            'message' => 'Payment was successfully approved'
          ];
        }
      }else{
          EarningModel::where('item', $commission->paymentItem)
                ->where('itemId', $commission->paymentId)
                ->delete();
      }
      return [
        'success' => false,
        'message' => 'Approve error'
      ];
  }
  public static function getMyEarned($userdata, $filter = 'today', $type = '') {
    $payment = PaymentTokensModel::select(DB::raw('sum(tokens) as totalTokens'))
      ->where('modelId', $userdata->id);

    if($type){
      $payment = $payment->where('item', $type);
    }
    if ($filter == 'today') {
      $payment = $payment->where(DB::raw("DATE_FORMAT(paymenttokens.createdAt, '%Y-%m-%d')"), date('Y-m-d'));
    } else if ($filter == 'week') {
      $payment = $payment->whereBetween('createdAt', [
        Carbon\Carbon::parse('last monday')->startOfDay(),
        Carbon\Carbon::parse('next sunday')->endOfDay()
      ]);
    }
    return $payment->first();
  }

}
