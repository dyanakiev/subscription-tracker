<?php

it('updates compact view setting', function () {
    $response = $this->put('/settings', [
        'compact_view' => true,
    ]);

    $response->assertRedirect('/settings');
});

it('updates locale setting', function () {
    $languages = config('languages.supported', ['en' => 'English']);
    $locale = array_key_first($languages);

    $response = $this->put('/settings', [
        'locale' => $locale,
    ]);

    $response->assertRedirect('/settings');
});

it('updates currency setting', function () {
    $currencies = config('currencies.supported', ['EUR' => '€']);
    $currency = array_key_first($currencies);

    $response = $this->put('/settings', [
        'currency' => $currency,
    ]);

    $response->assertRedirect('/settings');
});
