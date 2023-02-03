<?php

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
Route::get('existing-projects', 'FrontendController@project')->name('project');
Route::get('upcoming-projects', 'FrontendController@upcomingProject')->name('Upcoming-project');

Route::get('packages', 'FrontendController@pricing')->name('pricing');
Route::get('faq', 'FrontendController@faq')->name('faq');
// Route::get('contact', 'FrontendController@contact')->name('contact');
Route::get('news', 'FrontendController@news')->name('news');
Route::get('news/{news:slug}', 'FrontendController@showNews')->name('news.show');

Route::get('terms-and-conditions', 'FrontendController@termsConditions')->name('terms&Conditions');
Route::get('disclaimer', 'FrontendController@disclaimer')->name('disclaimer');
Route::post('filter/sponsors/{search_text}', 'RegisteredUserController@findUsers');

Route::get('contact', 'ContactController@index')->name('contact');
Route::post('contact-us/send-mail', 'ContactController@sendMail')->name('send.mail');


// Register custom routes
Route::group(['prefix' => 'register', 'middleware' => 'guest:' . config('fortify.guard')], function () {
    Route::get('/', 'RegisteredUserController@create')->name('register');
});

Route::group(['middleware' => 'guest:' . config('fortify.guard')], function () {
    Route::post('/forgot-password', 'Auth\PasswordResetLinkController@store')->name('password.email');
    Route::post('/reset-password', 'Auth\NewPasswordController@store')->name('password.update');
});

Route::get('test', function () {

});

Route::get('payments/binancepay/response', 'Payment\BinancePayController@response');
Route::get('payments/binancepay/fallback', 'Payment\BinancePayController@fallback');

Route::group(["prefix" => "", 'middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified', 'active_user', 'has_any_role']], function () {

    Route::withoutMiddleware('mobile_verified')->group(static function () {
        Route::get('verify/mobile', 'MobileVerifyController@index')->name('mobile.verification.notice');
        Route::post('verify/mobile/send-verify-code', 'MobileVerifyController@sendVerifyCode');
        Route::post('verify/mobile', 'MobileVerifyController@verifyPhone');
    });

    Route::group(["prefix" => "super-admin", 'middleware' => ['has_any_admin_role'], "as" => 'super_admin.'], function () {
        Route::get('dashboard', 'SuperAdmin\DashboardController@index')->name('dashboard');

        ////////////////////////// Permissions  route  /////////////////////

        Route::get('permissions', 'SuperAdmin\PermissionController@index')->name('permissions.index');

        ////////////////////////// Roles route  /////////////////////

        Route::get('roles', 'SuperAdmin\RolesController@index')->name('roles.index');
        Route::get('roles/create', 'SuperAdmin\RolesController@create')->name('roles.create');
        Route::post('roles/store', 'SuperAdmin\RolesController@store')->name('roles.store');
        Route::get('roles/{role}/edit', 'SuperAdmin\RolesController@edit')->name('roles.edit');
        Route::post('roles/{role}', 'SuperAdmin\RolesController@update')->name('roles.update');
        Route::delete('roles/{role}', 'SuperAdmin\RolesController@destroy')->name('roles.destroy');

        ////////////////////////// Users route  /////////////////////

        Route::get('users', 'SuperAdmin\UserController@index')->name('users.index');
        Route::get('users/create', 'SuperAdmin\UserController@create')->name('users.create');
        Route::post('users/store', 'SuperAdmin\UserController@store')->name('users.store');
        Route::get('users/{user}/edit', 'SuperAdmin\UserController@edit')->name('users.edit');
        Route::post('users/{user}', 'SuperAdmin\UserController@update')->name('users.update');
        Route::delete('users/{user}', 'SuperAdmin\UserController@destroy')->name('users.destroy');

        Route::get('users/{user}/change-password', 'SuperAdmin\UserController@changePassword')->name('users.changePassword');
        Route::post('users/{user}/save-password', 'SuperAdmin\UserController@savePassword')->name('users.savePassword');

        Route::get('users/{user}/view-permissions', 'SuperAdmin\UserController@showPermissions')->name('users.show-permissions');
        Route::get('users/{user}/manage-permission', 'SuperAdmin\UserController@managePermissions')->name('users.manage');
        Route::post('users/{user}/store-permissions', 'SuperAdmin\UserController@savePermissions')->name('users.store-permissions');

    });

    Route::group(["prefix" => "admin", 'middleware' => ['has_any_admin_role'], "as" => 'admin.'], function () {
        Route::get('dashboard', 'Admin\DashboardController@index')->name('dashboard');

        Route::get('users', 'Admin\UserController@index')->name('users.index');

        Route::post('users/{user}/suspend', 'Admin\UserController@suspendUser')->name('users.suspend');
        Route::post('users/{user}/activate', 'Admin\UserController@activateUser')->name('users.activate');

        Route::get('users/{user:username}/kycs', 'Admin\KycController@index')->name('users.kycs.index');
        Route::get('users/kycs/{kyc}', 'Admin\KycController@show')->name('users.kycs.show');
        Route::post('users/kyc-documents/{document}/status', 'Admin\KycController@status');

        // Profile
        Route::get('/users/{user:username}/profile', 'Admin\UserController@profileShow')->name('users.profile.show');

        Route::get('genealogy/{user:username?}', 'Admin\GenealogyController@index')->name('genealogy')->middleware('signed');

        // RANK GIFtS
        Route::get('ranks/gifts', 'Admin\RankGiftController@index')->name('ranks.gifts');
        Route::get('ranks/gifts/{gift}/issue', 'Admin\RankGiftController@issueGift')->name('ranks.gifts.issue');
        Route::post('ranks/gifts/{gift}/issue', 'Admin\RankGiftController@issueGift');

        //Packages
        Route::get('packages/arrange', 'Admin\PackageController@sort')->name('packages.arrange');
        Route::post('packages/arrange', 'Admin\PackageController@storeSort')->name('packages.arrange.store');
        Route::resource('packages', 'Admin\PackageController')->except('create', 'show');

        // topup
        Route::get('wallet/topup', 'Admin\WalletTopupHistoryController@index')->name('wallet.topup');
        Route::get('wallet/topup/history', 'Admin\WalletTopupHistoryController@history')->name('wallet.topup.history');
        Route::post('topup/wallet', 'Admin\WalletTopupHistoryController@topup');
        Route::post('filter/users/{search_text}', 'Admin\WalletTopupHistoryController@findUsers');

        //Route::get('packages/buy-package', 'Admin\PackageController@buypackage')->name('packages.buyBackage');
        //Route::get('users/transfers/withdrawals/form', 'Admin\WithdrawController@withdrawalsForm')->name('transfers.withdrawals.form');

        //Country
        Route::resource('countries', 'Admin\CountryController')->except('create', 'show');

        // Page
        Route::resource('pages', 'Admin\PageController')->only('index', 'edit', 'destroy');
        Route::resource('pages/sections', 'Admin\PageSectionController')->only('index')->middleware('signed');

        // Blog
        Route::resource('blogs', 'Admin\BlogController')->only('index', 'edit', 'destroy');

        //Currency
        Route::resource('currencies', 'Admin\CurrencyController')->except('create', 'show');


        Route::group(['prefix' => 'reports'], function () {
            // Earnings
            Route::get('users/earnings', 'Admin\EarningController@index')->name('earnings.index');
            Route::post('users/earnings/calculate-profit', 'Admin\EarningController@calculateProfit');
            Route::post('users/earnings/calculate-commission', 'Admin\EarningController@calculateCommission');

            // Transactions
            Route::get('users/transactions', 'Admin\TransactionController@index')->name('transactions.index');

            // Incomes
            Route::get('users/incomes/commission', 'Admin\IncomeController@commission')->name('incomes.commission');
            Route::get('users/incomes/rewards', 'Admin\IncomeController@rewards')->name('incomes.rewards');

            // withdraws
            Route::get('users/transfers/p2p', 'Admin\WithdrawController@p2p')->name('transfers.p2p');
            Route::get('users/transfers/withdrawals', 'Admin\WithdrawController@withdrawals')->name('transfers.withdrawals');
        });

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

        // support tickets
        Route::group(['prefix' => 'support/tickets', 'as' => 'support.tickets.'], function () {
            Route::controller('Admin\TicketController')->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('view/{ticket:slug}', 'show')->name('show');
                Route::patch('{ticket}/close', 'close');
                Route::patch('{ticket}/reopen', 'reopen');
                Route::patch('{ticket}/priority-ticket/{priority}', 'priority');
            });

            Route::controller('Admin\TicketOptionsController')->group(function () {
                Route::get('category/create', 'category')->name('category.create');
                Route::get('category/{category}/edit', 'categoryEdit')->name('category.edit');

                Route::get('priority/create', 'priority')->name('priority.create');
                Route::get('priority/{priority}/edit', 'priorityEdit')->name('priority.edit');

                Route::get('status/create', 'status')->name('status.create');
                Route::get('status/{status}/edit', 'statusEdit')->name('status.edit');
            });
        });

        // Testimonial
        Route::resource('testimonials', 'Admin\TestimonialController')->only(['index', 'create', 'edit', 'destroy']);

    });

    // USER ROUTES
    Route::group(["prefix" => "user", 'middleware' => ['role:user', 'mobile_verified'], "as" => 'user.'], function () {
        Route::get('dashboard', 'User\DashboardController@index')->name('dashboard');

        // KYC
        Route::get('kyc', 'User\KycController@index')->name('kyc.index');
        Route::get('kyc/entry/{kyc}', 'User\KycController@show')->name('kyc.show');
        Route::post('kyc/new-entry', 'User\KycController@storeNewEntry');
        Route::post('kyc/{kyc}/documents-upload', 'User\KycController@update');
        Route::post('kyc/{kyc}/documents/{document}/upload', 'User\KycDocumentController@update')->scopeBindings();

        // BinancePay
        Route::post('binancepay/order/create', 'Payment\BinancePayController@initiateBinancePay');

        // Packages
        Route::get('packages', 'User\PackageController@index')->name('packages.index');
        Route::get('packages/active', 'User\PackageController@active')->name('packages.active');

        // RANK GIFtS
        Route::get('ranks/gifts', 'User\RankGiftController@index')->name('ranks.gifts');

        // My Genealogy
        Route::get('genealogy/new-registration', 'User\GenealogyController@registerForm')->name('genealogy.position.register');
        Route::get('genealogy/{user:username?}', 'User\GenealogyController@index')->name('genealogy');

        Route::group(['prefix' => 'genealogy/{parent:username}/position-{position}'], function () {
            Route::get('', 'User\GenealogyController@managePosition')->name('genealogy.position.manage')->middleware('signed');
            Route::post('', 'User\GenealogyController@assignPosition')->middleware('signed');
        });

        Route::get('transactions', 'User\TransactionController@index')->name('transactions.index');
        Route::get('transactions/{transaction}/retry-payment', 'Payment\BinancePayController@retryPayment')->name('transactions.retry-payment');
        Route::get('transactions/invoice/{transaction}', 'Payment\InvoiceController@showPurchaseInvoice')->name('transactions.invoice')->middleware('signed');
        Route::get('transactions/invoice/steam/{transaction}', 'Payment\InvoiceController@streamPurchaseInvoice')->name('transactions.invoice.stream')->middleware('signed');

        Route::get('incomes/commission', 'User\EarningController@commission')->name('incomes.commission');
        Route::get('incomes/rewards', 'User\EarningController@rewards')->name('incomes.rewards');
        Route::get('earnings', 'User\EarningController@index')->name('earnings.index');

        Route::get('wallet', 'User\WalletController@index')->name('wallet.index');
        Route::get('wallet/transfer', 'User\WithdrawController@p2pTransfer')->name('wallet.transfer');
        Route::get('wallet/withdraw', 'User\WithdrawController@withdraw')->name('wallet.withdraw');

        Route::post('wallet/transfer/filter/users/{user:username}', 'User\WithdrawController@findUser');
        Route::post('filter/users/{search_text}', 'User\WithdrawController@findUsers');

        Route::post('wallet/transfer/p2p', 'Payment\PayoutController@p2pTransfer');
        Route::post('wallet/withdraw/binance', 'Payment\PayoutController@withdraw');

        Route::get('wallet/transfers/p2p/history', 'User\WithdrawController@p2pHistory')->name('transfers.p2p');
        Route::get('wallet/transfers/withdrawals/history', 'User\WithdrawController@withdrawalsHistory')->name('transfers.withdrawals');

        Route::get('wallet/transfer/invoice/{withdraw}', 'Payment\InvoiceController@showPayoutInvoice')->name('wallet.transfer.invoice')->middleware('signed');
        Route::get('wallet/transfer/invoice/steam/{withdraw}', 'Payment\InvoiceController@streamPayoutInvoice')->name('wallet.transfer.invoice.stream')->middleware('signed');


        // support tickets
        Route::group(['prefix' => 'support/tickets', 'controller' => 'User\TicketController', 'as' => 'support.tickets.'], static function () {
            Route::get('', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('{ticket:slug}', 'show')->name('show');
            Route::delete('{ticket}/delete', 'destroy');
            Route::patch('{ticket}/close', 'close');
            Route::patch('{ticket}/reopen', 'reopen');
            Route::get('{ticket}/edit', 'edit')->name('edit');
        });

    });

});
