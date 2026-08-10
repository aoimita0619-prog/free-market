<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StripeWebhookController;



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

Route::get('/', [DashboardController::class, 'index'])->name('top');
Route::get('/search', [DashboardController::class, 'search'])->name('search');
Route::get('/item/{id}', [DashboardController::class, 'show'])->name('item.show');
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');


Route::middleware(['auth','verified'])->group(function(){
    Route::get('/mypage/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/mypage/profile', [DashboardController::class, 'update'])->name('profile.update');
    Route::get('/sell', [DashboardController::class, 'create'])->name('sell');
    Route::post('/sell', [DashboardController::class, 'store'])->name('item.store');
    Route::post('/item/{item}/favorite', [FavoriteController::class, 'store'])->name('favorite.store');
    Route::delete('/item/{item}/favorite', [FavoriteController::class, 'destroy'])->name('favorite.destroy');
    Route::post('/item/{item}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::get('/purchase/{item}', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::get('/purchase/address/{item}', [PurchaseController::class, 'editAddress'])
    ->name('purchase.address.edit');
    Route::post('/purchase/address/{item}', [PurchaseController::class, 'updateAddress'])
    ->name('purchase.address.update');
    Route::post('/purchase/{item}/checkout', [PurchaseController::class, 'checkout'])->name('purchase.checkout');
    Route::get('/purchase/{item}/success', [PurchaseController::class, 'success'])->name('purchase.success');
    Route::get('/purchase/{item}/cancel', [PurchaseController::class, 'cancel'])->name('purchase.cancel');
    Route::get('/mypage', [DashboardController::class, 'mypage'])->name('mypage');
    
});

Route::middleware('auth')->group(function(){
    Route::get('/email/verify', [DashboardController::class, 'send'])->name('verification.notice');
});

Route::middleware(['auth', 'signed'])->group(function(){
    Route::get('/email/verify/{id}/{hash}', [DashboardController::class, 'verifyEmail'])->name('verification.verify');
});

Route::middleware(['auth', 'throttle:6,1'])->group(function(){
    Route::post('/email/verification-notification', [DashboardController::class, 'resend'])->name('verification.send');
});

