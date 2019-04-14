<?php

namespace App\Listeners;

use App\Events\SetVideoStatus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessSetVideoStatusAfterEventWasFired
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
     * @param  SetVideoStatus  $event
     * @return void
     */
    public function handle(SetVideoStatus $event)
    {
        //
    }
}
