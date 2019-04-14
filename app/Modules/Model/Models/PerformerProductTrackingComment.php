<?php

namespace App\Modules\Model\Models;
use App\Modules\Api\Models\PerformerModel;
use App\Modules\Api\Models\UserModel;
use Illuminate\Support\Facades\Mail;

/**
 * Description of PerformerProduct
 *
 * @author tuongtran
 */
class PerformerProductTrackingComment extends Model {

  protected $table = 'performer_product_tracking_comments';
  protected $fillable = ['performerId', 'userId', 'productId', 'orderId', 'text'];

  public function product() {
    return $this->hasOne('App\Modules\Model\Models\PerformerProduct', 'id', 'productId');
  }

  public function order() {
    return $this->hasOne('App\Modules\Model\Models\PerformerProductTracking', 'id', 'orderId');
  }

  public function sender() {
    return $this->hasOne('App\Modules\Api\Models\UserModel', 'id', 'senderId');
  }

  public function save(array $options = array()) {
    parent::save($options);

    //find recipinent
    $order = $this->order;
    if ($this->senderId == $order->userId) {
      $performer = PerformerModel::where(['id' => $order->performerId])->with('user')->first();
      $recipient = $performer->user;
    } else {
      $recipient = UserModel::where(['id' => $order->userId])->first();
    }

    $email = $recipient->email;
    Mail::send('email.product.new_product_tracking_comment', [
      'sender' => $this->sender,
      'recipient' => $recipient,
      'order' => $order,
      'comment' => $this
    ], function($message) use($email, $order) {
      $siteName = app('settings')->siteName;
      $message
        ->from(env('FROM_EMAIL') , app('settings')->siteName)
        ->to($email)
        ->subject("New comment for order {$order->id}| {$siteName}");
    });

    return true;
  }
}
