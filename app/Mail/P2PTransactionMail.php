<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class P2PTransactionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public bool $isSender;
    public User $sender;
    public User $receiver;
    public Withdraw $withdraw;

    public function __construct(bool $isSender, User $sender, User $receiver, Withdraw $withdraw)
    {
        $this->isSender = $isSender;
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->withdraw = $withdraw;
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope()
    {
        if ($this->isSender) {
            return new Envelope(
                subject: 'P2P Transaction Successful',
            );
        }

        return new Envelope(
            subject: "You have received P2P funds",
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
            view: 'email.p2p-success',
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
