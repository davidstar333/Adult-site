<?php

namespace App\Listeners;

use App\Modules\Api\Models\EarningSettingModel;
use App\Modules\Api\Models\SettingModel;
use App\Events\AddEarningSettingEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessEarningSettingAfterEventWasFired {

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
   * @param  AddModelEarningSettingEvent  $event
   * @return void
   */
  public function handle(AddEarningSettingEvent $event) {
    //
    //add earning settings
    $setting = SettingModel::first();

    $earningSetting = new EarningSettingModel;
    $earningSetting->userId = $event->id;
    if ($event->role == 'model') {
      $earningSetting->referredMember = $setting->modelDefaultReferredPercent;
      $earningSetting->performerSiteMember = $setting->modelDefaultPerformerPercent;
      $earningSetting->otherMember = $setting->modelDefaultOtherPercent;
    }else if($event->role == 'studio'){
      $earningSetting->referredMember = $setting->studioDefaultReferredPercent;
      $earningSetting->performerSiteMember = $setting->studioDefaultPerformerPercent;
      $earningSetting->otherMember = $setting->studioDefaultOtherPercent;
    }
    if (!$earningSetting->save()) {
      echo 'System Error.';
    }
  }

}
