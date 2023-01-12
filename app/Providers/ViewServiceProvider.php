<?php
 
namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Currency;


 
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
       
        View::composer('frontend.layouts.header', function ($view) {
           $currency = Currency::all();
           $view->with('header_currency',$currency);
        });



      
    }
}