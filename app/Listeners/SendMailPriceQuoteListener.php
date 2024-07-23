<?php

namespace App\Listeners;

use App\Events\SendMailPriceQuoteEvent;
use App\Mail\MailPriceQuote;
use App\Mail\PriceQuoteMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailPriceQuoteListener
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
    public function handle(SendMailPriceQuoteEvent $event): void
    {
        Mail::to($event->email)->send(new MailPriceQuote($event->pdfContent, $event->content));
    }
}
