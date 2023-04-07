<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOTPMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;
    public int $otp;
    public array $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, int $otp, array $data)
    {
        $this->user = $user;
        $this->otp = $otp;
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'One Time Password (OTP)',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content()
    {
        return new Content(
            view: 'email.otp',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
