<?php

namespace App\Mail;

use App\Models\CustomerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailThirtyDay extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $customer;
    /**
     * Create a new message instance.
     */
    public function __construct(CustomerService $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.mail_thirty_day')
            ->subject('Mail 30 ngày')
            ->with('customer', $this->customer);
    }
}
