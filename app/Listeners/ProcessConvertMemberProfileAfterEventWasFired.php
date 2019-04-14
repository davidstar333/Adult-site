<?php

namespace App\Listeners;

use App\Events\ConvertMemberProfile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use App\Modules\Api\Models\UserModel;
use Image;
use App\Helpers\Helper as AppHelper;

class ProcessConvertMemberProfileAfterEventWasFired {

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
   * @param  ConvertMemberProfile  $event
   * @return void
   */
  public function handle(ConvertMemberProfile $event) {
    //
    $avatar = explode('.', $event->path);
    $username = $event->username;
    $id = $event->id;
    
    if(count($avatar) < 2 ){
      return null;
    }
    $extension = end($avatar);
    
    $destinationPath = 'uploads/members/' . Carbon::now()->format('Y/m/d'); // upload path
    
    $fileNameLarge = "/image-large-" . $id . "-800x600.". $username .'.'. $extension;

    $fileNameMedium = "/image-medium-" . $id . "-400x300." . $username .'.'. $extension;
    $fileNameSmall = "/image-small-" . $id . "-100x100." . $username .'.'. $extension;
    $thumbnail260 = "/thumbnail-" . $id . "-260x200." . $username .'.'. $extension;
    $thumbnail230 = "/thumbnail-" . $id . "-230x172." . $username .'.'. $extension;
    $thumbnail75 = "/thumbnail-" . $id . "-75x100." . $username .'.'. $extension;

    // resizing an uploaded file
    // Image::make($event->path)->resize(800, 600,)->save(public_path($destinationPath . $fileNameLarge));
    // Image::make($event->path)->resize(400, 300)->save(public_path($destinationPath . $fileNameMedium));
    // Image::make($event->path)->resize(100, 100)->save(public_path($destinationPath . $fileNameSmall));
    // Image::make($event->path)->resize(260, 200)->save(public_path($destinationPath . $thumbnail260));
    // Image::make($event->path)->resize(230, 172)->save(public_path($destinationPath . $thumbnail230));
    // Image::make($event->path)->resize(75, 100)->save(public_path($destinationPath . $thumbnail75));

    Image::make($event->path)->fit(800, 600)->save(public_path($destinationPath . $fileNameLarge));
    Image::make($event->path)->fit(400, 300)->save(public_path($destinationPath . $fileNameMedium));
    Image::make($event->path)->fit(100, 100)->save(public_path($destinationPath . $fileNameSmall));
    Image::make($event->path)->fit(260, 200)->save(public_path($destinationPath . $thumbnail260));
    Image::make($event->path)->fit(230, 172)->save(public_path($destinationPath . $thumbnail230));
    Image::make($event->path)->fit(75, 100)->save(public_path($destinationPath . $thumbnail75));
    $imageArr = array(
      'imageLarge' => $destinationPath . $fileNameLarge,
      'imageMedium' => $destinationPath . $fileNameMedium,
      'imageSmall' => $destinationPath . $fileNameSmall,
      'normal' => $event->path,
      'thumbnail260' => $destinationPath . $thumbnail260,
      'thumbnail230' => $destinationPath . $thumbnail230,
      'thumbnail75' => $destinationPath . $thumbnail75
    );
    
    $serAvatar = serialize($imageArr);
    if(AppHelper::is_serialized($serAvatar)){
      return $serAvatar;
    }
    return null;
  }

}
