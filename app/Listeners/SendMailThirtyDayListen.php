<?php

namespace App\Listeners;

use App\Events\SendMailThirtyDayEvent;
use App\Mail\MailThirtyDay;
use App\Models\CustomerService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailThirtyDayListen
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
    public function handle(SendMailThirtyDayEvent $event): void
    {
        $day = Carbon::now()->addDay(30)->startOfDay();
        $notifications = CustomerService::select(
            'customer_service.id',
            'customer_service.ended_at',
            'services.name as name',
            'customers.email as email',
        )
            ->leftjoin('services', 'services.id', 'customer_service.service_id')
            ->leftjoin('customers', 'customers.id', 'customer_service.customer_id')
            ->whereDate('customer_service.ended_at', $day)
            ->get();

        if ($notifications->count() > 0) {
            foreach ($notifications as $item) {
                Mail::to($item->email)->send(new MailThirtyDay($item));
            }
        }
    }
}
