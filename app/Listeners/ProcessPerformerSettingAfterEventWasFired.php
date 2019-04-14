<?php

namespace App\Listeners;

use App\Modules\Api\Models\PerformerModel;
use App\Events\AddModelPerformerEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessPerformerSettingAfterEventWasFired {

  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct() {
    //
  }

  /**
   * Handle the event.
   *
   * @param  AddModelPerformerEvent  $event
   * @return void
   */
  public function handle(AddModelPerformerEvent $event) {
    //
    $setting = new PerformerModel;
    $setting->user_id = $event->id;
    $setting->category_id = 0;
    $setting->sex = $event->sex;
    $birthdate = new \DateTime($event->birthdate);
    $now = new \DateTime();
    $interval = $birthdate->diff($now);
    $setting->age = intval($interval->y);
    
    if ($setting->save()) {
      return true;
    }
    return false;
  }

}
