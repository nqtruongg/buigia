<?php

namespace App\Providers;

use App\Events\NotiServiceExpireEmailsSending;
use App\Events\SendMailOneDayEvent;
use App\Events\SendMailPriceQuoteEvent;
use App\Events\SendMailSevenDayEvent;
use App\Events\SendMailThirtyDayEvent;
use App\Events\UnlinkPdfEvent;
use App\Listeners\SendMailNotiServiceExpire;
use App\Listeners\SendMailOneDayListen;
use App\Listeners\SendMailPriceQuoteListener;
use App\Listeners\SendMailSevenDayListen;
use App\Listeners\SendMailThirtyDayListen;
use App\Listeners\UnlinkPdfListen;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\SendMailDeadline' => [
            'App\Listeners\SendMailDeadlineProject',
        ],
        SendMailOneDayEvent::class => [
            SendMailOneDayListen::class,
        ],
        SendMailSevenDayEvent::class => [
            SendMailSevenDayListen::class,
        ],
        SendMailThirtyDayEvent::class => [
            SendMailThirtyDayListen::class,
        ],
        SendMailPriceQuoteEvent::class => [
            SendMailPriceQuoteListener::class,
        ],
        UnlinkPdfEvent::class => [
            UnlinkPdfListen::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
