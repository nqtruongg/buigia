<?php

namespace App\Listeners;

use App\Events\SendMailDeadline;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Mail;

class SendMailDeadlineProject implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * @param  \App\Event\SendMailDeadline  $event
     */
    public function handle(SendMailDeadline $event): void
    {
        $data = ['user_mail' => $event->sendmail->email];
        Mail::send('mail.mail_deadline', $data, function($email) use($data){
            $email->subject('Thông báo deadline dự án');
            $email->to($data['user_mail']);
        });
    }
}
