<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\Api\Models\VideoModel;
use App\Modules\Api\Models\AttachmentModel;
use DB;

class Video extends Command {

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'video';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Update video status';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle() {
    
    $videos = VideoModel::select('videos.id as videoId')
      ->join('attachment as a', 'a.id', '=', 'videos.trailer')
      ->join('attachment as a1', 'a1.id', '=', 'videos.fullMovie')
      ->where('a.status', AttachmentModel::ACTIVE)
      ->where('a1.status', AttachmentModel::ACTIVE)
      ->where('videos.status', VideoModel::PROCESSING)
      ->where('a.media_type', AttachmentModel::TRAILER)
      ->where('a1.media_type', AttachmentModel::VIDEO)
      ->get();
      
    foreach ($videos as $item) {
      $video = VideoModel::find($item->videoId);
      $video->status = VideoModel::ACTIVE;
      if ($video->save()) {
        \Log::info('Video ID: ' . $item->videoId);
      }
    }
  }

}
