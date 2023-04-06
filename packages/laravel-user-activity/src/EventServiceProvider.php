<?php

namespace Haruncpi\LaravelUserActivity;

use Haruncpi\LaravelUserActivity\Listeners\FailedListener;
use Haruncpi\LaravelUserActivity\Listeners\LockoutListener;
use Haruncpi\LaravelUserActivity\Listeners\LoginListener;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            LoginListener::class
        ],
        Lockout::class => [
            LockoutListener::class
        ],
        Failed::class => [
            FailedListener::class
        ]
    ];

    public function boot()
    {
        parent::boot();
    }
}
