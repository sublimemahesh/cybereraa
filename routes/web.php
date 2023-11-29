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
Route::get('staking-packages', 'FrontendController@staking')->name('staking-pricing');

Route::get('faq', 'FrontendController@faq')->name('faq');
// Route::get('contact', 'FrontendController@contact')->name('contact');
Route::get('news', 'FrontendController@news')->name('news');
Route::get('news/{news:slug}', 'FrontendController@showNews')->name('news.show');

Route::get('terms-and-conditions', 'FrontendController@termsConditions')->name('terms&Conditions');
Route::get('disclaimer', 'FrontendController@disclaimer')->name('disclaimer');
Route::get('privacy-and-policy', 'FrontendController@privacyAndPolicy')->name('privacy-and-policy');

Route::get('how-it-work', 'FrontendController@howItWorkPage')->name('how-it-work');

Route::post('filter/sponsors/{search_text}', 'RegisteredUserController@findUsers');

Route::get('contact', 'ContactController@index')->name('contact');
Route::post('contact-us/send-mail', 'ContactController@sendMail')->name('send.mail');


// Register custom routes
Route::group(['prefix' => 'register', 'middleware' => 'guest:' . config('fortify.guard')], function () {
    Route::get('/', 'RegisteredUserController@create')->name('register');
});

Route::group(['middleware' => 'guest:' . config('fortify.guard')], function () {
    Route::post('/forgot-password', 'Auth\PasswordResetLinkController@store')->name('password.email');
    Route::get('/reset-password/{token}', [\Laravel\Fortify\Http\Controllers\NewPasswordController::class, 'create'])
        ->name('password.reset')
        ->middleware('signed');
    Route::post('/reset-password', 'Auth\NewPasswordController@store')->name('password.update')->middleware('signed');
});

Route::get('test', function () {

});

Route::get('payments/binancepay/response', 'Payment\BinancePayController@response');
Route::get('payments/binancepay/fallback', 'Payment\BinancePayController@fallback');

Route::group(["prefix" => "", 'middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified','active_user', 'has_any_role']], function () {

    Route::withoutMiddleware('mobile_verified')->group(static function () {
        Route::get('verify/mobile', 'MobileVerifyController@index')->name('mobile.verification.notice');
        Route::post('verify/mobile/send-verify-code', 'MobileVerifyController@sendVerifyCode');
        Route::post('verify/mobile', 'MobileVerifyController@verifyPhone');
    });

    Route::get('staking-packages/{package}/fetch-plans', 'Admin\Staking\StakingPlanController@fetchPlans');

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
        Route::match(['get', 'post'], 'users/{user}/change-sponsor', 'SuperAdmin\UserController@changeSponsor')->name('users.change-sponsor');
        Route::post('users/{user}', 'SuperAdmin\UserController@update')->name('users.update');
        Route::delete('users/{user}', 'SuperAdmin\UserController@destroy')->name('users.destroy');
        Route::post('filter/users/{search_text}', 'SuperAdmin\UserController@findUsers');

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
        Route::get('users/kycs/{kyc}/document/{document}/reject', 'Admin\KycController@reject')->name('users.kycs.document.reject');
        Route::post('users/kyc-documents/{document}/status', 'Admin\KycController@status');

        // Profile
        Route::get('/users/{user:username}/profile', 'Admin\UserController@profileShow')->name('users.profile.show');

        Route::match(['get', 'post'], 'genealogy/{user:username?}', 'Admin\GenealogyController@index')->name('genealogy')->middleware('signed');

        // RANK GIFtS
        Route::get('ranks/gifts', 'Admin\RankGiftController@index')->name('ranks.gifts');
        Route::post('ranks/gifts/{gift}/qualify', 'Admin\RankGiftController@makeQualify');
        Route::match(['get', 'post'], 'ranks/gifts/{gift}/issue', 'Admin\RankGiftController@issueGift')->name('ranks.gifts.issue');
        // Route::post('ranks/gifts/{gift}/issue', 'Admin\RankGiftController@issueGift');

        //Packages
        Route::get('packages/arrange', 'Admin\PackageController@sort')->name('packages.arrange');
        Route::post('packages/arrange', 'Admin\PackageController@storeSort')->name('packages.arrange.store');
        Route::resource('packages', 'Admin\PackageController')->except('create', 'show');

        //STAKING Package

        // Route::get('staking/dashboard', 'Admin\Staking\DashboardController@index')->name('staking.dashboard');
        // Route::get('staking-packages/arrange', 'Admin\Staking\StakingPackageController@sort')->name('staking-packages.arrange');
        // Route::post('staking-packages/arrange', 'Admin\Staking\StakingPackageController@storeSort')->name('staking-packages.arrange.store');
        // Route::resource('staking-packages', 'Admin\Staking\StakingPackageController')->except('create', 'show');

        // Route::resource('staking-packages.plans', 'Admin\Staking\StakingPlanController')->except('create', 'show')
        //     ->parameters([
        //         'staking-packages' => 'package'
        //     ])->shallow();
        // Route::get('staking-packages/{package}/arrange', 'Admin\Staking\StakingPlanController@sort')->name('staking-packages.plans.arrange');
        // Route::post('plans/arrange', 'Admin\Staking\StakingPlanController@storeSort')->name('plans.arrange.store');

        // STAKING END

        // topup
        Route::get('wallet/topup', 'Admin\WalletTopupHistoryController@index')->name('wallet.topup');
        Route::get('wallet/topup/history', 'Admin\WalletTopupHistoryController@history')->name('wallet.topup.history');
        Route::post('topup/wallet', 'Admin\WalletTopupHistoryController@topup');
        Route::match(['get', 'post'], 'wallet/topup/{topupHistory}/confirm-requests', 'Admin\WalletTopupHistoryController@confirmTopupRequest')->name('wallet.topup.confirm-requests');
        Route::post('filter/users/{search_text}', 'Admin\WalletTopupHistoryController@findUsers');

        //Route::get('packages/buy-package', 'Admin\PackageController@buypackage')->name('packages.buyBackage');

        //Country
        Route::resource('countries', 'Admin\CountryController')->except('create', 'show');

        // Page
        Route::resource('pages', 'Admin\PageController')->only('index', 'edit', 'destroy');
        Route::resource('pages/sections', 'Admin\PageSectionController')->only('index')->middleware('signed');

        // Blog
        Route::resource('blogs', 'Admin\BlogController')->only('index', 'edit', 'destroy');

        // PopupNotices
        Route::resource('popup-notices', 'Admin\PopupNoticeController')->only('index', 'edit', 'destroy')
            ->parameter('popup-notices', 'popup');

        //Currency
        Route::resource('currencies', 'Admin\CurrencyController')->except('create', 'show');


        Route::group(['prefix' => 'reports'], function () {

            // Admin Wallets
            Route::get('wallets/profits', 'Admin\AdminWalletController@index')->name('admin-wallet-profits');
            Route::get('wallets/profits/history', 'Admin\AdminWalletTransactionController@index')->name('admin-wallet-transaction.index');
            Route::match(['get', 'post'], 'wallets/profits/withdraw/{wallet}', 'Admin\AdminWalletWithdrawalController@withdraw')->name('admin-wallet-withdraw');
            Route::get('wallets/profits/withdrawal/history', 'Admin\AdminWalletWithdrawalController@index')->name('admin-wallet-withdrawal.index');

            // Ranks
            Route::get('ranks', 'Admin\RankController@index')->name('ranks');

            // Ranks Bonus Summary
            Route::get('ranks/benefits/summery', 'Admin\RankBenefitSummeryController@index')->name('ranks.benefits.summery');
            Route::get('ranks/benefits/requirements', 'Admin\RankBenefitSummeryController@requirements')->name('ranks.benefits.requirements');

            // Earnings
            Route::get('users/earnings', 'Admin\EarningController@index')->name('earnings.index');
            Route::post('users/earnings/calculate-profit', 'Admin\EarningController@calculateProfit');
            Route::post('users/rewards/calculate-bonus', 'Admin\EarningController@issueMonthlyRankBonuses');
            Route::post('users/earnings/calculate-commission', 'Admin\EarningController@calculateCommission');
            Route::post('users/earnings/release-staking-interest', 'Admin\EarningController@releaseStakingInterest');

            // Transactions
            Route::get('users/purchased-packages', 'Admin\PurchasedPackageController@index')->name('purchased-packages');

            // STAKING
            Route::get('users/staking-purchased-packages', 'Admin\Staking\PurchasedStakingPlanController@index')->name('staking-purchased-packages');
            Route::get('users/staking/transactions', 'Admin\TransactionController@index')->name('staking.transactions.index');
            Route::get('users/staking/earnings', 'Admin\EarningController@index')->name('staking.earnings.index');
            Route::get('users/staking/transfers/withdrawals', 'Admin\WithdrawController@withdrawals')->name('staking.transfers.withdrawals');

            Route::get('users/staking-purchased-packages/{purchase}/cancellations', 'Admin\Staking\StakingCancelRequestController@index')->name('staking-cancel-request.index');
            Route::post('users/staking-purchased-packages/cancellations/{cancelRequest}/process', 'Admin\Staking\StakingCancelRequestController@process')->name('staking-cancel-request.process');
            Route::match(['get', 'post'], 'users/staking-purchased-packages/cancellations/{cancelRequest}/approve', 'Admin\Staking\StakingCancelRequestController@approve')->name('staking-cancel-request.approve');
            Route::match(['get', 'post'], 'users/staking-purchased-packages/cancellations/{cancelRequest}/reject', 'Admin\Staking\StakingCancelRequestController@reject')->name('staking-cancel-request.reject');
            // STAKING END

            Route::get('users/transactions', 'Admin\TransactionController@index')->name('transactions.index');
            Route::get('users/transactions/{transaction}/summery', 'Admin\TransactionController@summery')->name('transactions.summery');
            Route::match(['get', 'post'], 'users/transactions/{transaction}/approve', 'Admin\TransactionController@approve')->name('transactions.approve');
            Route::match(['get', 'post'], 'users/transactions/{transaction}/reject', 'Admin\TransactionController@reject')->name('transactions.reject');

            // Incomes
            Route::get('users/incomes/commission', 'Admin\IncomeController@commission')->name('incomes.commission');
            Route::get('users/incomes/rewards', 'Admin\IncomeController@rewards')->name('incomes.rewards');

            // withdraws
            Route::get('users/transfers/p2p', 'Admin\WithdrawController@p2p')->name('transfers.p2p');
            Route::get('users/transfers/withdrawals', 'Admin\WithdrawController@withdrawals')->name('transfers.withdrawals');
            Route::get('users/transfers/wallets', 'Admin\WalletTransferController@index')->name('transfers.wallets');
            Route::get('users/transfers/withdrawals/{withdraw}/summery', 'Admin\WithdrawController@show')->name('transfers.withdrawals.view');
            Route::match(['get', 'post'], 'users/transfers/withdrawals/{withdraw}/approve', 'Admin\WithdrawController@approve')->name('transfers.withdrawals.approve');
            Route::match(['get', 'post'], 'users/transfers/withdrawals/{withdraw}/reject', 'Admin\WithdrawController@rejectWithdraw')->name('transfers.withdrawals.reject');
            Route::post('users/transfers/withdrawals/{withdraw}/process', 'Admin\WithdrawController@process');
        });

        // Strategies
        Route::group(['prefix' => 'strategies', 'controller' => 'Admin\StrategyController', 'as' => 'strategies.'], function () {
            Route::get('withdrawal', 'withdrawal')->name('withdrawal.index');
            Route::patch('withdrawal', 'saveWithdraw');
            Route::patch('withdrawal/fees', 'saveWithdrawFees');

            Route::get('rank-level', 'rankLevel')->name('rank-level.index');
            Route::get('rank-gifts-levels', 'rankGiftLevel')->name('rank-gift-level.index');
            Route::patch('rank/levels', 'saveRankLevels');
            Route::patch('rank/package-requirements', 'savePackageRequirements');
            Route::patch('rank/gift-requirements', 'saveRankGiftInvestmentRequirement');

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
    Route::group(["prefix" => "user", 'middleware' => ['role:user'/*, 'mobile_verified'*/], "as" => 'user.'], function () {
        Route::get('dashboard', 'User\DashboardController@index')->name('dashboard');

        // KYC
        Route::get('kyc', 'User\KycController@index')->name('kyc.index');
        Route::get('kyc/entry/{kyc}', 'User\KycController@show')->name('kyc.show');
        Route::post('kyc/new-entry', 'User\KycController@storeNewEntry');
        Route::post('kyc/{kyc}/documents-upload', 'User\KycController@update');
        Route::post('kyc/{kyc}/documents/{document}/upload', 'User\KycDocumentController@update')->scopeBindings();

        // PACKAGES

        // BinancePay
        Route::post('binancepay/order/create', 'Payment\BinancePayController@initiateBinancePay');

        Route::get('packages', 'User\PackageController@index')->name('packages.index');
        Route::get('packages/active', 'User\PackageController@active')->name('packages.active');
        Route::get('packages/{package:slug}/{purchase_for?}', 'User\PackageController@manualPurchase')->name('packages.manual.purchase');

        // STAKING PLANS START

        // Route::get('staking-packages', 'User\Staking\StakingPackageController@index')->name('staking-packages.index');
        // Route::get('staking-packages/{package:slug}/plans', 'User\Staking\StakingPackageController@plans')->name('staking-packages.purchase');
        // Route::post('staking-packages/order/create', 'User\Staking\PaymentController@initiatePayment');

        // Route::get('staking-dashboard', 'User\Staking\StakingPackageController@dashboard')->name('staking-packages.dashboard');
        // Route::get('staking/purchased-plans/{purchase}/cancellations', 'User\Staking\StakingCancelRequestController@index')->name('staking-cancel-request.index');
        // Route::match(['get', 'post'], 'staking/purchased-plans/{purchase}/cancellations/request', 'User\Staking\StakingCancelRequestController@request')->name('staking-cancel-request.request');
        // Route::match(['get', 'post'], 'staking/purchased-plans/cancellations/{cancelRequest}/reverse', 'User\Staking\StakingCancelRequestController@reverse')->name('staking-cancel-request.reverse');

        // STAKING PLANS END


        // RANK GIFtS

        // Route::get('ranks/gifts', 'User\RankGiftController@index')->name('ranks.gifts');
        // Route::match(['get', 'post'], 'ranks/gifts/{gift}/shipping-info', 'User\RankGiftController@shippingInfo')->name('ranks.gifts.shipping-info');

        Route::get('ranks/summery', 'User\RankController@RankSummary')->name('ranks.summery');
        Route::get('ranks/benefits/summery', 'User\RankBenefitSummeryController@index')->name('ranks.benefits.summery');
        Route::get('ranks/benefits/requirements', 'User\RankBenefitSummeryController@requirements')->name('ranks.benefits.requirements');
        Route::get('ranks/team/rankers', 'User\RankController@teamRankers')->name('ranks.team-rankers');

        // My Genealogy
        Route::get('genealogy/new-registration', 'User\GenealogyController@registerForm')->name('genealogy.position.register');
        Route::match(['get', 'post'], 'genealogy/{user:username?}', 'User\GenealogyController@index')->name('genealogy');

        Route::group(['prefix' => 'genealogy/{parent:username}/position-{position}'], function () {
            Route::get('', 'User\GenealogyController@managePosition')->name('genealogy.position.manage')->middleware('signed');
            Route::post('', 'User\GenealogyController@assignPosition')->middleware('signed');
        });

        Route::get('transactions', 'User\TransactionController@index')->name('transactions.index');
        Route::get('transactions/purchased/history', 'User\TransactionController@purchaseHistory')->name('transactions.purchased.history');
        Route::get('transactions/{transaction}/retry-payment', 'Payment\BinancePayController@retryPayment')->name('transactions.retry-payment');
        Route::get('transactions/invoice/{transaction}', 'Payment\InvoiceController@showPurchaseInvoice')->name('transactions.invoice')->middleware('signed');
        Route::get('transactions/invoice/steam/{transaction}', 'Payment\InvoiceController@streamPurchaseInvoice')->name('transactions.invoice.stream')->middleware('signed');

        Route::get('incomes/commission', 'User\EarningController@commission')->name('incomes.commission');
        Route::get('incomes/rewards', 'User\EarningController@rewards')->name('incomes.rewards');
        Route::get('earnings', 'User\EarningController@index')->name('earnings.index');
        Route::get('earnings/summary-report', 'User\EarningController@earningSummary')->name('earnings.summary-report');

        Route::get('team/users-list', 'User\GenealogyController@teamList')->name('team.users-list');
        Route::get('team/income-levels', 'User\GenealogyController@IncomeLevels')->name('team.income-levels');
        Route::get('team/incomes/commission', 'User\EarningController@teamCommissionsIncome')->name('team.incomes.commission');
        Route::get('team/incomes/earnings', 'User\EarningController@teamHighestEarnings')->name('earnings.team-income');
        Route::match(['get', 'post'], 'earnings/summarize-yearly-income', 'User\EarningController@incomeChart')->name('earnings.yearly-income-chart');

        Route::post('wallet/transfer/filter/users/{user:username}', 'User\WithdrawController@findUser');
        Route::post('filter/users/{search_text}', 'User\WithdrawController@findUsers');

        Route::get('wallet', 'User\WalletController@index')->name('wallet.index');
        Route::match(['get', 'post'], 'wallet/transfer/to-wallet', 'User\WalletTransferController@transfer')->name('wallet.transfer.to-wallet');
        Route::get('wallet/transfer', 'User\WithdrawController@p2pTransfer')->name('wallet.transfer');
        Route::post('wallet/transfer/p2p/2ft-verify', 'Payment\PayoutController@twoftVerifyP2P');
        Route::post('wallet/transfer/p2p', 'Payment\PayoutController@p2pTransfer');
        Route::match(['get', 'post'], 'wallet/transfer/p2p/{p2p}/confirmation', 'User\WithdrawController@p2pConfirm')->name('withdraw.confirm-p2p');

        Route::get('wallet/withdraw', 'User\WithdrawController@withdraw')->name('wallet.withdraw');
        Route::get('wallet/withdraws/{withdraw}/summery', 'User\WithdrawController@show')->name('wallet.withdraw.view');
        Route::post('wallet/withdraws/2ft-verify', 'Payment\PayoutController@twoftVerifyWithdraw');
        Route::post('wallet/withdraw/binance', 'Payment\PayoutController@withdraw');
        Route::match(['get', 'post'], 'wallet/withdraws/{withdraw}/cancel-request', 'User\WithdrawController@cancelWithdraw')->name('wallet.withdraw.cancel');

        Route::get('wallet/transfers/p2p/history', 'User\WithdrawController@p2pHistory')->name('transfers.p2p');
        Route::get('wallet/transfers/withdrawals/history', 'User\WithdrawController@withdrawalsHistory')->name('transfers.withdrawals');
        Route::get('wallet/transfers/staking-withdrawals/history', 'User\WithdrawController@withdrawalsHistory')->name('staking.transfers.withdrawals');

        Route::get('wallet/transfer/invoice/{withdraw}', 'Payment\InvoiceController@showPayoutInvoice')->name('wallet.transfer.invoice')->middleware('signed');
        Route::get('wallet/transfer/invoice/steam/{withdraw}', 'Payment\InvoiceController@streamPayoutInvoice')->name('wallet.transfer.invoice.stream')->middleware('signed');

        // Topup Request
        Route::match(['get', 'post'], 'wallet/request-topup-balance', 'User\WalletTopupHistoryController@index')->name('wallet.request-topup-balance');
        Route::get('wallet/topup-requests/history', 'User\WalletTopupHistoryController@history')->name('wallet.topup-request.history');


        // Tutorial Request
        Route::get('tutorials', 'User\TutorialController@index')->name('tutorials.index');



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
