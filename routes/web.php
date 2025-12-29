<?php

use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('subscriptions');
});

Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions');
Route::get('/add-subscription', [SubscriptionController::class, 'create'])->name('add-subscription');
Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
Route::get('/subscriptions/{subscription}/edit', [SubscriptionController::class, 'edit'])->name('subscriptions.edit');
Route::put('/subscriptions/{subscription}', [SubscriptionController::class, 'update'])->name('subscriptions.update');
Route::post('/subscriptions/{subscription}/update', [SubscriptionController::class, 'update'])->name('subscriptions.update.post');
Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');

Route::get('/settings', [SettingsController::class, 'show'])->name('settings');
Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('privacy-policy');
