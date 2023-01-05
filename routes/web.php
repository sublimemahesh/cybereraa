<?php

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
Route::get('existing-project', 'FrontendController@project')->name('project');
Route::get('upcoming-project', 'FrontendController@upcomingProject')->name('Upcoming-project');
Route::get('how-it-works', 'FrontendController@howToWork')->name('how-to-work');
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

        //Packages
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

        // Strategies
        Route::group(['prefix' => 'strategies', 'controller' => 'Admin\StrategyController', 'as' => 'strategies.'], function () {
            Route::get('withdrawal', 'withdrawal')->name('withdrawal.index');
            Route::patch('withdrawal', 'saveWithdraw');
            Route::patch('withdrawal/fees', 'saveWithdrawFees');

            Route::get('rank-level', 'rankLevel')->name('rank-level.index');
            Route::patch('rank/levels', 'saveRankLevels');
            Route::patch('rank/package-requirements', 'savePackageRequirements');

            Route::get('commissions', 'commissions')->name('commissions.index');
            Route::patch('commissions', 'saveCommissions');

            Route::get('daily-leverages', 'payablePercentage')->name('daily-leverages');
            Route::patch('daily-leverages', 'saveLeverages');
        });
    });

    // USER ROUTES
    Route::group(["prefix" => "user", 'middleware' => ['role:user'], "as" => 'user.'], function () {
        Route::get('dashboard', 'User\DashboardController@index')->name('dashboard');

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
        Route::get('genealogy/new-registration', 'User\GenealogyController@registerForm')->name('genealogy.position.register');
        Route::get('genealogy/{user:username?}', 'User\GenealogyController@index')->name('genealogy');

        Route::group(['prefix' => 'genealogy/{parent:username}/position-{position}'], function () {
            Route::get('', 'User\GenealogyController@managePosition')->name('genealogy.position.manage')->middleware('signed');
            Route::post('', 'User\GenealogyController@assignPosition')->middleware('signed');
        });

        Route::get('transactions', 'User\TransactionController@index')->name('transactions.index');

        Route::get('incomes/commission', 'User\EarningController@commission')->name('incomes.commission');
        Route::get('incomes/rewards', 'User\EarningController@rewards')->name('incomes.rewards');
        Route::get('earnings', 'User\EarningController@index')->name('earnings.index');

        Route::get('wallet', 'User\WalletController@index')->name('wallet.index');
        Route::get('wallet/transfer', 'User\WithdrawController@p2pTransfer')->name('wallet.transfer');
        Route::get('wallet/withdraw', 'User\WithdrawController@withdraw')->name('wallet.withdraw');

        Route::post('wallet/transfer/filter/users/{user:username}', 'User\WithdrawController@findUser');

        Route::post('wallet/transfer/p2p', 'Payment\PayoutController@p2pTransfer');
        Route::post('wallet/withdraw/binance', 'Payment\PayoutController@withdraw');
    });

});
