<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [
    Commands\Inspire::class,
    Commands\Video::class,
    Commands\Commission::class,
    Commands\MessageCommission::class,
    Commands\Notification::class,
    // Commands\DeleteDownloaded::class,
    Commands\ConvertVideos::class
  ];

  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule) {
    $schedule->command('inspire')
      ->hourly();
    $schedule->command('ConvertVideos')
    ->everyFiveMinutes();
    $schedule->command('video')
      ->everyMinute();
    $schedule->command('commission')
      ->everyMinute();
    $schedule->command('message')
      ->everyMinute();

    // $schedule->command('download')->daily();
//    $schedule->command('notification')->daily();
  }

}
