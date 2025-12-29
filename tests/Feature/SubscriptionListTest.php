<?php

use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Native\Mobile\Facades\Dialog;

uses(RefreshDatabase::class);

it('shows only active subscriptions by default', function () {
    $active = Subscription::factory()->create(['name' => 'Spotify', 'is_active' => true]);
    $inactive = Subscription::factory()->create(['name' => 'Game Pass', 'is_active' => false]);

    $response = $this->get('/subscriptions');

    $response->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Subscriptions/Index')
            ->where('statusFilter', 'active')
            ->where('subscriptions', function ($subscriptions) use ($active, $inactive) {
                $names = collect($subscriptions)->pluck('name');

                return $names->contains($active->name) && ! $names->contains($inactive->name);
            }));
});

it('can filter inactive subscriptions', function () {
    $active = Subscription::factory()->create(['name' => 'Prime', 'is_active' => true]);
    $inactive = Subscription::factory()->create(['name' => 'YouTube Premium', 'is_active' => false]);

    $response = $this->get('/subscriptions?status=inactive');

    $response->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Subscriptions/Index')
            ->where('statusFilter', 'inactive')
            ->where('subscriptions', function ($subscriptions) use ($active, $inactive) {
                $names = collect($subscriptions)->pluck('name');

                return $names->contains($inactive->name) && ! $names->contains($active->name);
            }));
});

it('sorts subscriptions by price', function () {
    $low = Subscription::factory()->create(['name' => 'Apple TV', 'price' => 5, 'is_active' => true]);
    $high = Subscription::factory()->create(['name' => 'Adobe', 'price' => 25, 'is_active' => true]);

    $response = $this->get('/subscriptions');

    $response->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Subscriptions/Index')
            ->where('sortOrder', 'desc')
            ->where('subscriptions.0.name', $high->name)
            ->where('subscriptions.1.name', $low->name));

    $response = $this->get('/subscriptions?sort=asc');

    $response->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Subscriptions/Index')
            ->where('sortOrder', 'asc')
            ->where('subscriptions.0.name', $low->name)
            ->where('subscriptions.1.name', $high->name));
});

it('deletes a subscription when confirmed', function () {
    $subscription = Subscription::factory()->create(['name' => 'Dropbox', 'is_active' => true]);

    Dialog::shouldReceive('toast')->once()->andReturnNull();

    $response = $this->delete("/subscriptions/{$subscription->id}");

    $response->assertRedirect('/subscriptions');

    expect(Subscription::query()->whereKey($subscription->id)->exists())->toBeFalse();
});
