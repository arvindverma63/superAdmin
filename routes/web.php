<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\UserController;
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
    Route::get('/user',[PageController::class,'addUserPage'])->name('user');
    Route::post('/addUser',[UserController::class,'addUser']);
    Route::get('/socialMedia',[PageController::class,'socialMedia'])->name('social');
    Route::post('/add-influencers',[SocialMediaController::class,'addData'])->name('influencer.store');
    Route::put('/update-permission',[UserController::class,'updatePermission']);
});

Route::get('/logout',[AuthController::class,'logout']);
