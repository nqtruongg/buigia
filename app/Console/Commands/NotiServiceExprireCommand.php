<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\NotiServiceExpireEmailsSending;
use App\Events\SendMailOneDayEvent;
use App\Events\SendMailSevenDayEvent;
use App\Events\SendMailThirtyDayEvent;
use App\Mail\MailOneDay;
use Illuminate\Support\Facades\Event;

class NotiServiceExprireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:noti-service-expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to customers whose service is about to expire';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        event(new SendMailThirtyDayEvent());
        event(new SendMailSevenDayEvent());
        event(new SendMailOneDayEvent());
    }
}
