<?php

namespace App\Livewire;

use App\Models\Subscription;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Native\Mobile\Attributes\OnNative;
use Native\Mobile\Events\Alert\ButtonPressed;
use Native\Mobile\Facades\Dialog;
use Native\Mobile\Facades\SecureStorage;

#[Layout('layouts.app')]
#[Title('Subscriptions Tracker')]
class SubscriptionList extends Component
{
    public string $sortOrder = 'desc';

    public bool $compactView = false;

    public function mount(): void
    {
        try {
            $this->compactView = SecureStorage::get('compact_view') === 'true';
        } catch (\Exception $e) {
            $this->compactView = false;
        }
    }

    #[On('subscription-saved')]
    public function refresh(): void
    {
        // Component will automatically re-render when subscriptions change
    }

    public function sortBy(string $order): void
    {
        $this->sortOrder = $order;
    }

    public function delete(int $id): void
    {
        $subscription = Subscription::findOrFail($id);

        Dialog::alert(
            'Delete Subscription',
            "Are you sure you want to delete \"{$subscription->name}\"? This action cannot be undone.",
            ['Cancel', 'Delete']
        )->id("delete-subscription-{$id}")->event(ButtonPressed::class);
    }

    #[OnNative(ButtonPressed::class)]
    public function handleDeleteConfirmation(int $index, string $label, ?string $id = null): void
    {
        if ($index === 1 && $id && str_starts_with($id, 'delete-subscription-')) {
            // User clicked "Delete" (index 1) and this is a delete dialog
            $subscriptionId = (int) str_replace('delete-subscription-', '', $id);
            Subscription::findOrFail($subscriptionId)->delete();
            Dialog::toast('Subscription deleted');
        }
        // If Cancel (index 0) or invalid, do nothing
    }

    public function edit(int $id): void
    {
        $this->redirect(route('add-subscription', ['id' => $id]), navigate: true);
    }

    public function render()
    {
        $subscriptions = Subscription::query()
            ->when($this->sortOrder === 'desc', fn ($query) => $query->orderByDesc('price'))
            ->when($this->sortOrder === 'asc', fn ($query) => $query->orderBy('price'))
            ->get();

        $totalPerMonth = $subscriptions->sum('price');
        $totalPerYear = $totalPerMonth * 12;

        return view('livewire.subscription-list', [
            'subscriptions' => $subscriptions,
            'totalPerMonth' => $totalPerMonth,
            'totalPerYear' => $totalPerYear,
            'compactView' => $this->compactView,
        ]);
    }
}
