<?php

namespace App\Providers;

use App\Services\SumsubService;
use Illuminate\Support\ServiceProvider;

class SumsubServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SumsubService::class, function ($app) {
            return new SumsubService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
