<?php

namespace App\Modules\Studio\Models;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Facades\Mail;
use App\Modules\Model\Models\PerformerPayoutRequest;
use App\Modules\Api\Models\UserModel;
use App\Helpers\PayoutRequestHelper;
use App\Modules\Api\Models\PerformerModel;
/**
 * Description
 *
 * @author tuongtran
 */
class StudioPayoutRequest extends BaseModel {
  /**
   * The name of the "created at" column.
   *
   * @var string
   */
  const CREATED_AT = 'createdAt';

  /**
   * The name of the "updated at" column.
   *
   * @var string
   */
  const UPDATED_AT = 'updatedAt';
  protected $table = 'studio_payout_requests';
  protected $fillable = ['studioId', 'payoutAccountId', 'payoutInfo', 'dateFrom', 'dateTo', 'comment', 'note', 'status', 'payout', 'previousPayout', 'pendingBalance', 'paymentAccount'];

  public $performerIds = [];

  public function save(array $options = array()) {
    $isNew = !$this->exists;
    $changed = $this->isDirty() ? $this->getDirty() : false;

    parent::save($options);

    if ($isNew) {
      $studio = $this->studio;
      if (!$studio) {
        return false;
      }

      Mail::send('email.new_request_studio', [
        'studio' => $studio,
        'request' => $this
      ], function($message) use ($studio){
        $siteName = app('settings')->siteName;
        $message
          ->from(env('FROM_EMAIL') , app('settings')->siteName)
          ->to(env('ADMIN_EMAIL'))
          ->subject("New payout request from studio #{$studio->id} - {$studio->username} | {$siteName}");
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
        $studio = $this->studio;
        $request = $this;
        //alert to requester
        Mail::send('email.updated_status_studio', [
          'studio' => $studio,
          'request' => $this
        ], function($message) use ($studio, $request){
          $siteName = app('settings')->siteName;
          $message
            ->from(env('FROM_EMAIL') , app('settings')->siteName)
            ->to($studio->email)
            ->subject("Request #{$request->id} has been updated | {$siteName}");
        });
      }
    }

    return true;
  }

  public function studio() {
    return $this->hasOne('App\Modules\Api\Models\UserModel', 'id', 'studioId');
  }

  public function getPerformers() {
    $requests = PerformerPayoutRequest::where(['studioRequestId' => $this->id])->get();
    $ids = [];
    foreach ($requests as $request) {
      $performer = PerformerModel::find($request->performerId);
      $ids[] = $performer->user_id;
    }

    return UserModel::whereIn('id', $ids)->get();
  }
}
