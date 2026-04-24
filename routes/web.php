<?php

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

Route::get('/login', [HomeController::class, 'login'])->name('auth.login');
Route::get('/sign', [HomeController::class, 'sign'])->name('auth.sign');
