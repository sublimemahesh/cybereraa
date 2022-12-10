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

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::group(["prefix" => "", 'middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified']], function () {

    Route::group(["prefix" => "super-admin", 'middleware' => ['role:super_admin'], "as" => 'super.admin.'], function () {
        Route::view('/dashboard', 'backend.super_admin.dashboard')->name('dashboard');
    });

    Route::group(["prefix" => "admin", 'middleware' => ['role:admin'], "as" => 'admin.'], function () {
        Route::view('/dashboard', 'backend.admin.dashboard')->name('dashboard');
    });

    Route::group(["prefix" => "user", 'middleware' => ['role:user'], "as" => 'user.'], function () {
        Route::view('/dashboard', 'backend.user.dashboard')->name('dashboard');
    });

});