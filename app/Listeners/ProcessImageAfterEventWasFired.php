<?php

namespace App\Listeners;

use App\Modules\Api\Models\AttachmentModel;
use App\Events\ConvertImage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use Image;

class ProcessImageAfterEventWasFired {

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
   * @param  ConvertImage  $event
   * @return void
   */
  public function handle(ConvertImage $event) {
    //
    $image = AttachmentModel::find($event->id);
    $destinationPath = 'uploads/models/' . Carbon::now()->format('Y/m/d'); // upload path
    $mineType = $image->type;
    $extension = str_replace('image/', '', $mineType);
    $fileNameLarge = "/image-large-" . $image->id . "-800x600." . $extension;

    $fileNameMedium = "/image-medium-" . $image->id . "-400x300." . $extension;
    $fileNameSmall = "/image-small-" . $image->id . "-100x100." . $extension;
    $thumbnail260 = "/thumbnail-" . $image->id . "-260x200." . $extension;
    $thumbnail230 = "/thumbnail-" . $image->id . "-230x172." . $extension;
    $thumbnail75 = "/thumbnail-" . $image->id . "-75x100." . $extension;

    // resizing an uploaded file
    Image::make($image->path)->fit(800, 600)->save(public_path($destinationPath . $fileNameLarge));
    Image::make($image->path)->fit(400, 300)->save(public_path($destinationPath . $fileNameMedium));
    Image::make($image->path)->fit(100, 100)->save(public_path($destinationPath . $fileNameSmall));
    Image::make($image->path)->fit(260, 200)->save(public_path($destinationPath . $thumbnail260));
    Image::make($image->path)->fit(230, 172)->save(public_path($destinationPath . $thumbnail230));
    Image::make($image->path)->fit(75, 100)->save(public_path($destinationPath . $thumbnail75));

    $imageArr = array(
      'imageLarge' => $destinationPath . $fileNameLarge,
      'imageMedium' => $destinationPath . $fileNameMedium,
      'imageSmall' => $destinationPath . $fileNameSmall,
      'normal' => $image->path,
      'thumbnail260' => $destinationPath . $thumbnail260,
      'thumbnail230' => $destinationPath . $thumbnail230,
      'thumbnail75' => $destinationPath . $thumbnail75
    );
    $image->mediaMeta = serialize($imageArr);
//    $image->path = $destinationPath . $fileNameMedium;
    $image->status = AttachmentModel::ACTIVE;
    if (!$image->save()) {

      return false;
    }
    return true;
  }

}
