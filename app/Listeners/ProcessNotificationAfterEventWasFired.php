<?php

namespace App\Listeners;

use App\Events\MakeNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessNotificationAfterEventWasFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MakeNotification  $event
     * @return void
     */
    public function handle(MakeNotification $event)
    {
        //
    }
}
