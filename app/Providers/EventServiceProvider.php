<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

  /**
   * The event listener mappings for the application.
   *
   * @var array
   */
  protected $listen = [
    'App\Events\ConvertVideo' => [
      'App\Listeners\ProcessVideoAfterEventWasFired',
    ],
    'App\Events\ConvertImage' => [
      'App\Listeners\ProcessImageAfterEventWasFired',
    ],
    'App\Events\ConvertMemberProfile' => [
      'App\Listeners\ProcessConvertMemberProfileAfterEventWasFired',
    ],
    'App\Events\DeleteVideo' => [
      'App\Listeners\ProcessDeleteVideoAfterEventWasFired',
    ],
    'App\Events\DeleteImage' => [
      'App\Listeners\ProcessDeleteImageAfterEventWasFired',
    ],
    'App\Events\DeleteImageGallery' => [
      'App\Listeners\ProcessDeleteImageGalleryAfterEventWasFired',
    ],
    'App\Events\LikeItemEvent' => [
      'App\Listeners\ProcessLikeItemAfterEventWasFired',
    ],
    'App\Events\SendTokensEvent' => [
      'App\Listeners\ProcessSendTokensAfterEventWasFired',
    ],
    'App\Events\SendPaidTokensEvent' => [
      'App\Listeners\ProcessSendPaidTokensAfterEventWasFired',
    ],
    'App\Events\PodcastWasRegistered' => [
      'App\Listeners\ProcessMemberAfterWasFired',
    ],
    'App\Events\AddModelPerformerChatEvent' => [
      'App\Listeners\ProcessPerformerChatAfterEventWasFired',
    ],
    'App\Events\AddModelScheduleEvent' => [
      'App\Listeners\ProcessPerformerScheduleAfterEventWasFired',
    ],
    'App\Events\AddEarningSettingEvent' => [
      'App\Listeners\ProcessEarningSettingAfterEventWasFired',
    ],
    'App\Events\AddModelPerformerEvent' => [
      'App\Listeners\ProcessPerformerSettingAfterEventWasFired',
    ],
    'App\Events\UpdateExtendMember' => [
      'App\Listeners\ProcessUpdateExtendMemberAfterEventWasFired',
    ],
    'App\Events\SetReadMail' => [
      'App\Listeners\SetReadMailAfterEventWasFired',
    ],
    'App\Events\MakeChatRoomEvent' => [
      'App\Listeners\MakeChatRoomAfterEventWasFired',
    ]
  ];

  /**
   * Register any other events for your application.
   *
   * @param  \Illuminate\Contracts\Events\Dispatcher  $events
   * @return void
   */
  public function boot(DispatcherContract $events) {
    parent::boot($events);
    
  }

}
