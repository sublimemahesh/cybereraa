<?php

namespace App\Providers;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Page;
use App\Models\PurchasedPackage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('backend.layouts.app', function ($view) {
            $roles = Auth::user()->getRoleNames()->toArray();
            if (in_array('user', $roles, true)) {
                $folder = 'user';
            } elseif (in_array('super_admin', $roles, true)) {
                $folder = 'super_admin';
            } else {
                $folder = 'admin';
            }
            $view->with('folder', $folder);
        });

        View::composer('frontend.layouts.header', function ($view) {
            $currency = Currency::all();
            $view->with('header_currency', $currency);
        });

        View::composer('frontend.layouts.footer', function ($view) {
            $social_media_links = Page::where('slug', 'footer-social-media-links')->firstOrNew();
            $today_registrations = User::whereDate('created_at', date('Y-m-d'))->count();
            $active_accounts = User::whereHas('activePackages')->count();
            $daily_transactions = PurchasedPackage::activePackages()->whereDate('created_at', date('Y-m-d'))->count();
            $support_countries = Country::count();
            $view->with('footer_numbers', compact('social_media_links', 'today_registrations', 'daily_transactions', 'active_accounts', 'support_countries'));
        });


    }
}