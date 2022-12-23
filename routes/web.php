<?php

use App\Models\Earning;
use App\Models\PurchasedPackage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'FrontendController@index')->name('/');
Route::get('about-us', 'FrontendController@about')->name('about');
Route::get('project', 'FrontendController@project')->name('project');
Route::get('how-it-work', 'FrontendController@howToWork')->name('how-to-work');
Route::get('pricing', 'FrontendController@pricing')->name('pricing');
Route::get('faq', 'FrontendController@faq')->name('faq');
Route::get('contact', 'FrontendController@contact')->name('contact');

// Register custom routes
Route::group(['prefix' => 'register', 'middleware' => 'guest:' . config('fortify.guard')], function () {
    Route::get('/', 'RegisteredUserController@create')->name('register');
    Route::post('/', 'RegisteredUserController@store');
});

Route::get('test', function (Request $request) {
    $period = explode(' to ', $request->get('date-range'));
    $date1 = Carbon::createFromFormat('Y-m-d', trim($period[0]));
    $date2 = Carbon::createFromFormat('Y-m-d', trim($period[1]));
    dd($period,$date1&&$date2);
//    $nodeId = 3;
    // Find the ancestor with the fewest children
//    $ancestors = User::findAvailableSubLevel($nodeId);
//    dd($ancestors);
    $user = User::find(3);
    $activePackages = PurchasedPackage::with('user')
        ->where('status', 'active')
        ->whereDate('expired_at', '>=', Carbon::now())
        ->whereDoesntHave('earnings', fn($query) => $query->whereDate('created_at', Carbon::now()->format('Y-m-d')))
        ->get();
//    $exc_time = Carbon::parse('3343343084')->format('Y-m-d H:i:s');
    $now = Carbon::now()->timestamp;
    $purchase = PurchasedPackage::find(1);
    dd(Earning::where('purchased_package_id', $purchase->id)->whereDate('created_at', date('Y-m-d'))->doesntExist(), date('Y-m-d'));

});

Route::get('payments/binancepay/response', 'Payment\BinancePayController@response');
Route::get('payments/binancepay/fallback', 'Payment\BinancePayController@fallback');

Route::group(["prefix" => "", 'middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified']], function () {

    Route::group(["prefix" => "super-admin", 'middleware' => ['role:super_admin'], "as" => 'super_admin.'], function () {
        Route::view('/dashboard', 'backend.super_admin.dashboard')->name('dashboard');

    });

    Route::group(["prefix" => "admin", 'middleware' => ['role:admin'], "as" => 'admin.'], function () {
        Route::view('/dashboard', 'backend.admin.dashboard')->name('dashboard');

        Route::get('users', 'Admin\UserController@index')->name('users.index');
        Route::get('users/{user:username}/kycs', 'Admin\KycController@index')->name('users.kycs.index');
        Route::get('users/kycs/{kyc}', 'Admin\KycController@show')->name('users.kycs.show');
        Route::post('users/kyc-documents/{document}/status', 'Admin\KycController@status');

        //Country
        Route::resource('packages', 'Admin\PackageController')->except('create', 'show');

        //Country
        Route::resource('countries', 'Admin\CountryController')->except('create', 'show');

        // Page
        Route::resource('pages', 'Admin\PageController')->only('index', 'edit', 'destroy');
        Route::resource('pages/sections', 'Admin\PageSectionController')->only('index')->middleware('signed');

        // Blog
        Route::resource('blogs', 'Admin\BlogController')->only('index', 'edit', 'destroy');

        // Earnings
        Route::get('users/earnings', 'Admin\EarningController@index')->name('earnings.index');
        Route::post('users/earnings/calculate-profit', 'Admin\EarningController@calculateProfit');
    });

    // USER ROUTES
    Route::group(["prefix" => "user", 'middleware' => ['role:user'], "as" => 'user.'], function () {
        Route::view('/dashboard', 'backend.user.dashboard')->name('dashboard');

        // KYC
        Route::get('kyc', 'User\KycController@index')->name('kyc.index');
        Route::get('kyc/entry/{kyc}', 'User\KycController@show')->name('kyc.show');
        Route::post('kyc/new-entry', 'User\KycController@storeNewEntry');
        Route::post('kyc/{kyc}/documents/{document}/upload', 'User\KycDocumentController@update')->scopeBindings();

        // BinancePay
        Route::post('binancepay/order/create', 'Payment\BinancePayController@initiateBinancePay');

        // Packages
        Route::get('packages', 'User\PackageController@index')->name('packages.index');
        Route::get('packages/active', 'User\PackageController@active')->name('packages.active');


        // My Genealogy
        Route::get('genealogy/{user:username?}', 'User\GenealogyController@index')->name('genealogy');

        Route::group(['prefix' => 'genealogy/{parent:username}/position-{position}'], function () {
            Route::get('', 'User\GenealogyController@managePosition')->name('genealogy.position.manage')->middleware('signed');
            Route::post('', 'User\GenealogyController@assignPosition')->middleware('signed');
            Route::get('new-registration', 'User\GenealogyController@registerForm')->name('genealogy.position.register')->middleware('signed');
        });

        Route::get('earnings', 'User\EarningController@index')->name('earnings.index');
    });

});