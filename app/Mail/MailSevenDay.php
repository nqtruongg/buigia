<?php

namespace App\Mail;

use App\Models\CustomerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailSevenDay extends Mailable implements ShouldQueue
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
        return $this->view('mails.mail_seven_day')
            ->subject('Mail 7 ngày')
            ->with('customer', $this->customer);
    }
}
