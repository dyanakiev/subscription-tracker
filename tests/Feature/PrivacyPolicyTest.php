<?php

use Inertia\Testing\AssertableInertia as Assert;

it('has a privacy policy page', function () {
    $response = $this->get('/privacy-policy');

    $response->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('PrivacyPolicy')
            ->where('effectiveDate', 'December 24, 2025'))
        ->assertSee('Privacy Policy')
        ->assertSee('December 24, 2025')
        ->assertSee('Track your expenses');
});
