<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Frontend\User\DashboardController;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('index', [HomeController::class, 'index'])->name('mainindex');

Route::get('order/new', [HomeController::class, 'newOrder'])->name('newOrder');
Route::get('orders', [HomeController::class, 'orders'])->name('orders');
Route::get('contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact/send', [ContactController::class, 'send'])->name('contact.send');

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::get('/', [HomeController::class, 'new'])->name('index');
    
    
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        
        Route::get('new', [HomeController::class, 'new'])->name('new');
        Route::get('orders', [HomeController::class, 'orders'])->name('orders');
        
        
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // User Account Specific
        Route::get('account', [AccountController::class, 'index'])->name('account');

        // User Profile Specific
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });
});
