<?php

namespace App\Mail;

use App\Models\KycDocument;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KYCRejectMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;
    public KycDocument $document;

    public function __construct(User $user, KycDocument $document)
    {
        $this->user = $user;
        $this->document = $document;
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'KYC Verification rejected',
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
            view: 'email.kyc-rejected',
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
