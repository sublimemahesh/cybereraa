<?php

namespace App\Events;

use App\Mail\NewDownlineMail;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendUserRegisteredWelcomeNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function handle(Registered $event)
    {
        if ($event->user instanceof User) {
            Mail::to($event->user->email)->send(new WelcomeMail($event->user));
            Mail::to($event->user->sponsor->email)->send(new NewDownlineMail($event->user));
        }
    }
}
