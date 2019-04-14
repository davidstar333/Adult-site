<?php

namespace App\Listeners;

use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\SettingModel;
use App\Events\UpdateExtendMember;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessUpdateExtendMemberAfterEventWasFired {

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
   * @param  UpdateExtendMember  $event
   * @return void
   */
  public function handle(UpdateExtendMember $event) {
    //
    $user = UserModel::find($event->id);
    $settings = SettingModel::first();
    if ($user && $user->role == UserModel::ROLE_MEMBER && $settings) {
      $user->tokens = $settings->memberJoinBonus;
      if ($user->save()) {
        return true;
      }
      return false;
    }
  }

}
