<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

// Static Pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/pricing', [PageController::class, 'pricing'])->name('pricing');
Route::get('/help', [PageController::class, 'help'])->name('help');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/docs', [PageController::class, 'docs'])->name('docs');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// App - Authenticated
Route::middleware('auth')->group(function () {
    Route::get('/prompt/{conversation}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/prompt/new', [ChatController::class, 'store'])->name('chat.store');
    Route::put('/prompt/{conversation}', [ChatController::class, 'update'])->name('chat.update');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
});

// App - Public/Guest Accessible
Route::get('/prompt', [ChatController::class, 'index'])->name('chat.index');
Route::post('/chat/stream', [ChatController::class, 'stream'])->name('chat.stream');

// Subscription Routes
Route::get('/subscription/checkout', [SubscriptionController::class, 'showCheckout'])->name('subscription.checkout');
Route::post('/subscription/process', [SubscriptionController::class, 'processPayment'])->name('subscription.process');
Route::post('/subscription/contact-sales', [SubscriptionController::class, 'contactSales'])->name('subscription.contact');
Route::get('/upgrade-to-pro', [SubscriptionController::class, 'upgradeToPro'])->name('subscription.upgrade');