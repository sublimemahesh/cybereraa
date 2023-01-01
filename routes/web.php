<?php

use App\Models\User;
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
Route::get('packages', 'FrontendController@pricing')->name('pricing');
Route::get('faq', 'FrontendController@faq')->name('faq');
Route::get('contact', 'FrontendController@contact')->name('contact');
Route::get('news', 'FrontendController@news')->name('news');
Route::get('news/{news:slug}', 'FrontendController@showNews')->name('news.show');


// Register custom routes
Route::group(['prefix' => 'register', 'middleware' => 'guest:' . config('fortify.guard')], function () {
    Route::get('/', 'RegisteredUserController@create')->name('register');
    Route::post('/', 'RegisteredUserController@store');
});

Route::get('test', function (Request $request) {
    //$user = User::find(3);
    //User::upgradeAncestorsRank($user, 1);
    //dd(Rank::all(), collect(User::getUpgradeRequirements())->where(fn($value, $key) => $value >= 500)->keys()->toArray());

    $available_parent_id = User::findAvailableSubLevel(1);
    if (empty($available_parent_id->id)) {
        logger()->warning("routes/web.php : user: " . 1 . " | No parent found with available nodes" . $available_parent_id->id);
        return;
    }
    $parent = User::find($available_parent_id->id);
    $children = $parent->children;
    $filled__position = $children->pluck('position')->toArray();
    $available__position = array_diff([1, 2, 3, 4, 5], $filled__position);
    sort($available__position);
    $available__position = Arr::first($available__position);

    dd($available_parent_id->id, $available_parent_id, $filled__position, $available__position);
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
        Route::post('users/earnings/calculate-commission', 'Admin\EarningController@calculateCommission');
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

        Route::get('transactions', 'User\TransactionController@index')->name('transactions.index');

        Route::get('earnings', 'User\EarningController@index')->name('earnings.index');

        Route::get('wallet', 'User\WalletController@index')->name('wallet.index');
    });

});
