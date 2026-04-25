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

Route::get('/login', [AccountController::class, 'login'])->name('auth.login');
Route::post('/login', [AccountController::class, 'authenticate'])->name('auth.authenticate');
Route::get('/sign', [AccountController::class, 'sign'])->name('auth.sign');
Route::post('/account-register', [AccountController::class, 'processRegistraction'])->name('account.processRegistraction');
