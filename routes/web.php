<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\front\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('jobs/{slug}-{id}', [HomeController::class, 'show'])->name('job.show');

Route::post('/login', [AccountController::class, 'authenticate'])->name('auth.authenticate');



Route::prefix('account/')->group(function () {

    // GUEST
    Route::group(['middleware' => 'guest'], function () {
        Route::get('register', [AccountController::class, 'sign'])->name('auth.sign');
        Route::post('register', [AccountController::class, 'processRegistraction'])->name('account.processRegistraction');
        Route::get('login', [AccountController::class, 'login'])->name('auth.login');
    });

    // AUTH

    Route::group(['middleware' => 'auth'], function () {
        // Account
        Route::get('profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::put('update-profile', [AccountController::class, 'update'])->name('account.update');
        Route::put('update-password', [AccountController::class, 'updatePassword'])->name('account.update_password');
        Route::post('update-picture-profile', [AccountController::class, 'pictureProfile'])->name('account.picture_profile');
        Route::post('account-logout', [AccountController::class, 'logout'])->name('account.logout');
    });

});