<?php

use App\Livewire\PrivacyPolicy;
use App\Livewire\Settings;
use App\Livewire\SubscriptionForm;
use App\Livewire\SubscriptionList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('subscriptions');
});

Route::get('/subscriptions', SubscriptionList::class)->name('subscriptions');

Route::get('/add-subscription', SubscriptionForm::class)->name('add-subscription');

Route::get('/settings', Settings::class)->name('settings');

Route::get('/privacy-policy', PrivacyPolicy::class)->name('privacy-policy');
