<?php

namespace App\Modules\Studio\Models;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Facades\Mail;

/**
 * Description
 *
 * @author tuongtran
 */
class StudioPayoutRequestComment extends BaseModel {
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
  
  protected $table = 'studio_payout_request_comments';
  protected $fillable = ['sentBy', 'senderId', 'payoutRequestId', 'text'];

  public function sender() {
    return $this->hasOne('App\Modules\Api\Models\UserModel', 'id', 'senderId');
  }

  public function request() {
    return $this->hasOne('App\Modules\Api\Models\StudioPayoutRequest', 'id', 'payoutRequestId');
  }

  public function save(array $options = array()) {
    parent::save($options);

    //find recipinent
    //$request = $this->request;
    $email = $this->sentBy === 'studio' ? $this->sender->email : env('ADMIN_EMAIL');

    $comment = $this;
    Mail::send('email.new_comment', [
      'comment' => $this,
      'sender' => $this->sender
    ], function($message) use($email, $comment) {
      $siteName = app('settings')->siteName;
      $message
        ->from(env('FROM_EMAIL') , app('settings')->siteName)
        ->to($email)
        ->subject("New comment for request #{$comment->payoutRequestId} | {$siteName}");
    });

    return true;
  }
}
