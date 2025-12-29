<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;
use Inertia\Response;
use Native\Mobile\Facades\Dialog;
use Native\Mobile\Facades\SecureStorage;

class SettingsController extends Controller
{
    public function show(): Response
    {
        $languages = config('languages.supported', ['en' => 'English']);
        $currencies = config('currencies.supported', ['EUR' => '€']);

        return Inertia::render('Settings', [
            'compactView' => $this->resolveCompactView(),
            'languages' => $languages,
            'currencies' => $currencies,
            'locale' => $this->resolveLocale($languages),
            'currency' => $this->resolveCurrency($currencies),
            'title' => __('app.titles.settings'),
        ]);
    }

    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (array_key_exists('compact_view', $data)) {
            $compactView = (bool) $data['compact_view'];
            try {
                SecureStorage::set('compact_view', $compactView ? 'true' : 'false');
            } catch (\Exception $e) {
            }

            Dialog::toast($compactView ? __('app.toasts.compact_enabled') : __('app.toasts.compact_disabled'));
        }

        if (array_key_exists('locale', $data)) {
            $locale = $data['locale'];

            try {
                SecureStorage::set('locale', $locale);
            } catch (\Exception $e) {
            }

            App::setLocale($locale);

            Dialog::toast(__('app.settings.language_updated'));
        }

        if (array_key_exists('currency', $data)) {
            $currency = $data['currency'];

            try {
                SecureStorage::set('currency', $currency);
            } catch (\Exception $e) {
            }

            Dialog::toast(__('app.settings.currency_updated'));
        }

        return redirect()->route('settings');
    }

    /**
     * @param  array<string, string>  $languages
     */
    protected function resolveLocale(array $languages): string
    {
        try {
            $storedLocale = SecureStorage::get('locale');
        } catch (\Exception $e) {
            $storedLocale = null;
        }

        $locale = $storedLocale ?: App::getLocale();

        if (! array_key_exists($locale, $languages)) {
            $locale = App::getLocale();
        }

        App::setLocale($locale);

        return $locale;
    }

    /**
     * @param  array<string, string>  $currencies
     */
    protected function resolveCurrency(array $currencies): string
    {
        try {
            $storedCurrency = SecureStorage::get('currency');
        } catch (\Exception $e) {
            $storedCurrency = null;
        }

        $currency = $storedCurrency ?: array_key_first($currencies);

        if (! array_key_exists($currency, $currencies)) {
            $currency = array_key_first($currencies);
        }

        return $currency;
    }

    protected function resolveCompactView(): bool
    {
        try {
            $storedCompactView = SecureStorage::get('compact_view');
        } catch (\Exception $e) {
            $storedCompactView = null;
        }

        return $storedCompactView === 'true';
    }
}
