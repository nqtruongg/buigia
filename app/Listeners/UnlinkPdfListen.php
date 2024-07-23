<?php

namespace App\Listeners;

use App\Events\UnlinkPdfEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnlinkPdfListen implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UnlinkPdfEvent $event): void
    {
        unlink($event->path);
    }
}
