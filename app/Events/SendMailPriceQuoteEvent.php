<?php

namespace App\Events;

use App\Models\Customer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMailPriceQuoteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pdfContent;
    public $email;
    public $content;

    public function __construct($pdfContent, $email, $content)
    {
        $this->pdfContent = $pdfContent;
        $this->email = $email;
        $this->content = $content;
    }
}
