<?php

use App\Models\User;
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

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::get('test', function () {
    $nodeId = 3;
    // Find the ancestor with the fewest children
    $ancestors = User::findAvailableSubLevel($nodeId);
    dd($ancestors);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
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

        // Page
        Route::resource('pages', 'Admin\PageController')->only('index', 'edit', 'destroy');
        Route::resource('pages/sections', 'Admin\PageSectionController')->only('index')->middleware('signed');
        // Blog
        Route::resource('blogs', 'Admin\BlogController')->only('index', 'edit', 'destroy');
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

        // My Genealogy
        Route::get('genealogy/{user:username?}', 'User\GenealogyController@index')->name('genealogy');

        Route::group(['prefix' => 'genealogy/{parent:username}/position-{position}'], function () {
            Route::get('', 'User\GenealogyController@managePosition')->name('genealogy.position.manage')->middleware('signed');
            Route::post('', 'User\GenealogyController@assignPosition')->middleware('signed');
            Route::get('new-registration', 'User\GenealogyController@registerForm')->name('genealogy.position.register')->middleware('signed');
        });
    });

});