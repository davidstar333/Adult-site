<?php

namespace App\Modules\Model\Models;
use Illuminate\Support\Facades\Mail;
use App\Modules\Api\Models\PerformerModel;
use App\Modules\Api\Models\UserModel;

/**
 * Description
 *
 * @author tuongtran
 */
class PerformerPayoutRequest extends Model {
  const PAYMENTTYPE_PAYPAL = 'paypal';
  const PAYMENTTYPE_PAYONEER = 'payoneer';
  const PAYMENTTYPE_WIRE = 'wire';
  const PAYMENTTYPE_DEPOSIT = 'deposit';
  const PAYMENTTYPE_BITPAY = 'bitpay';
  const PAYMENTTYPE_ISSUE_CHECK_US = 'issue_check_us';
  const STATUS_APPROVE = 'approved';
  const STATUS_PENDING = 'pending';
  protected $table = 'performer_payout_requests';
  protected $fillable = ['performerId', 'payoutAccountId', 'payoutInfo', 'dateFrom', 'dateTo', 'comment', 'note', 'status', 'payout', 'previousPayout', 'pendingBalance', 'paymentAccount', 'studioRequestId'];

  public function save(array $options = array()) {
    $isNew = !$this->exists;
    $changed = $this->isDirty() ? $this->getDirty() : false;

    if ($isNew && !$this->uuid) {
      $this->uuid = uniqid();
    }

    parent::save($options);

    if ($isNew) {
      $performer = PerformerModel::where(['id' => $this->performerId])->first();
      if (!$performer) {
        return false;
      }
      $sendTo = env('ADMIN_EMAIL');
      if($this->studioRequestId){
        $studio = UserModel::find($this->studioRequestId);
        if($studio){
          $sendTo = $studio->email;
        }
      }
      Mail::send('email.new_request', [
        'performer' => $performer,
        'request' => $this
      ], function($message) use ($performer,  $sendTo){
        $siteName = app('settings')->siteName;
        $message
          ->from(env('FROM_EMAIL') , app('settings')->siteName)
          ->to($sendTo)
          ->subject("New payout request from performer #{$performer->id} - {$performer->user->username} | {$siteName}");
      });
    } else {
      $isStatusChanged = false;
      if ($changed) {
        foreach ($changed as $key => $attr) {
          if ($key === 'status') {
            $isStatusChanged = true;
          }
        }
      }
      if ($isStatusChanged) {
        $performer = PerformerModel::where(['id' => $this->performerId])->first();
        $request = $this;
        //alert to requester
        Mail::send('email.update_status', [
          'performer' => $performer,
          'request' => $this
        ], function($message) use ($performer, $request){
          $siteName = app('settings')->siteName;
          $message
            ->from(env('FROM_EMAIL') , app('settings')->siteName)
            ->to($performer->user->email)
            ->subject("Request #{$request->id} has been updated | {$siteName}");
        });
      }
    }

    return true;
  }

  public function performer() {
    return $this->hasOne('App\Modules\Api\Models\PerformerModel', 'id', 'performerId');
  }
}
