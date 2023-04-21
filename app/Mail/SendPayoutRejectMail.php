<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Withdraw;
use DragonCode\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendPayoutRejectMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;

    public Withdraw $withdraw;

    public function __construct(Withdraw $withdraw)
    {
        $this->withdraw = $withdraw;
        $this->user = $withdraw->user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rejection of Withdrawal Request',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.payouts.reject',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
