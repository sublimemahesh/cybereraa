<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReminderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;

    public string $title;

    public string $notice;

    public function __construct(User $user, string $title)
    {
        $this->user = $user;
        $this->title = $title;
        $this->notice = view('email.followup-content', compact('user'))->render();
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Have you made up your mind ?',
        );
    }

    public function content()
    {
        return new Content(
            view: 'email.notice',
        );
    }

}
