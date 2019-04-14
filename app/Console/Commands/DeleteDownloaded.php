<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\Api\Models\DownloadModel;
use Carbon\Carbon;

class DeleteDownloaded extends Command {

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'download';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'delete download completed after 1 day.';

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
    //delete 10 record each times
    $downloads = DownloadModel::where('createdAt', '<=', Carbon::now()->subMinutes(60)->toDateTimeString());
    foreach ($downloads->paginate(10) as $download) {
      if (file_exists(public_path($download->path))) {
        \File::Delete(public_path($download->path));
      }
    }
    $downloads->delete();
  }

}
