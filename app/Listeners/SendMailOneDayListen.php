<?php

namespace App\Listeners;

use App\Events\SendMailOneDayEvent;
use App\Mail\MailOneDay;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\CustomerService;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendMailOneDayListen 
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
    public function handle(SendMailOneDayEvent $event): void
    {
        $day = Carbon::now()->addDay(1)->startOfDay();
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
                Mail::to($item->email)->send(new MailOneDay($item));
            }
        }
    }
}
