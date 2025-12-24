<?php

use App\Livewire\PrivacyPolicy;

it('has a privacy policy page', function () {
    $response = $this->get('/privacy-policy');

    $response->assertSuccessful()
        ->assertSeeLivewire(PrivacyPolicy::class)
        ->assertSee('Privacy Policy')
        ->assertSee('Effective date')
        ->assertSee('December 24, 2025')
        ->assertSee('does not collect, transmit, or sell personal information')
        ->assertSee('Data retention and deletion')
        ->assertSee('Third-party services')
        ->assertSee('Your rights')
        ->assertSee('Contact')
        ->assertSee('Track your expenses');
});
