<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProfileModifyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;

    public array $dirty;

    public function __construct($user, $dirty)
    {
        $this->user = $user;
        $this->dirty = $dirty;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Profile Details Updated',
        );
    }

    public function content()
    {
        return new Content(
            view: 'email.profile-update',
        );
    }

    public function attachments()
    {
        return [];
    }
}
