<?php

namespace App\Listeners;

use App\Events\Commented;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCommentedNotification
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
     * @param  Commented  $event
     * @return void
     */
    public function handle(Commented $event)
    {
        dd($event);
    }
}
