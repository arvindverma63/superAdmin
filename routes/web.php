<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
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


Route::get('/', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login/api', [AuthController::class, 'loginController']);
Route::get('/otp/page', [PageController::class, 'otpPage'])->name('verify.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

Route::middleware(['auth.token'])->group(function () {

    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
});

Route::get('/logout',[AuthController::class,'logout']);
