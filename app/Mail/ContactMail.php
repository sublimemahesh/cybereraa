<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public array $details;

    public function __construct(array $details)
    {
        $this->details = $details;

    }

    public function envelope()
    {
        return new Envelope(
            subject: $this->details['name'] . ' | ' . $this->details['subject'] . ' | ' . config('app.name', 'Cyber Eraa'),
        );
    }


    public function build()
    {

        return $this->replyTo($this->details['email'], $this->details['name'])
            //->subject('Customer Inquiry : ' . config('app.name', 'cyber Eraa'))
            ->from(config('mail.from.address'), $this->details['name'])
            ->view('email.inquiry');

    }

}
