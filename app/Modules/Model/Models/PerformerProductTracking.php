<?php

namespace App\Modules\Model\Models;

use Illuminate\Support\Facades\Mail;

/**
 * Description of PerformerProduct
 *
 * @author tuongtran
 */
class PerformerProductTracking extends Model {

  protected $table = 'performer_product_tracking';
  protected $fillable = ['performerId', 'userId', 'productId', 'productName', 'quantity', 'token', 'purchaseStatus', 'shippingStatus', 'shippingAddress1', 'shippingAddress2'];

  public function product() {
    return $this->hasOne('App\Modules\Model\Models\PerformerProduct', 'id', 'productId');
  }

  public function buyer() {
    return $this->hasOne('\App\Modules\Api\Models\UserModel', 'id', 'userId');
  }

  public function performer() {
    return $this->hasOne('\App\Modules\Api\Models\PerformerModel', 'id', 'performerId');
  }

  public function save(array $options = array()) {
    $changed = $this->isDirty() ? $this->getDirty() : false;

    parent::save($options);

    //check and send email if status or shipping status is change
    $isStatusChanged = false;
    if ($changed) {
      foreach ($changed as $key => $attr) {
        if ($key == 'status' || $key == 'shippingStatus') {
          $isStatusChanged = true;
        }
      }
    }

    if ($isStatusChanged) {
      $email = $this->buyer->email;
      $order = $this;
      Mail::send('email.product.order_status_changed', [
          'performer' => $this->performer,
          'buyer' => $this->buyer,
          'order' => $this
              ], function($message) use($email, $order) {
        $siteName = app('settings')->siteName;
        $message
          ->from(env('FROM_EMAIL') , app('settings')->siteName)
          ->to($email)
          ->subject("Status changed for order {$order->id}| {$siteName}");
      });
    }

    return true;
  }

  public function getAllAttributes() {
    return $this->attributes;
  }

}
