<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Native\Mobile\Facades\Dialog;
use Native\Mobile\Facades\SecureStorage;

class SubscriptionController extends Controller
{
    public function index(Request $request): Response
    {
        $statusFilter = $request->string('status', 'active')->toString();
        if (! in_array($statusFilter, ['active', 'inactive', 'all'], true)) {
            $statusFilter = 'active';
        }

        $sortOrder = $request->string('sort', 'desc')->toString();
        if (! in_array($sortOrder, ['asc', 'desc'], true)) {
            $sortOrder = 'desc';
        }

        $subscriptions = Subscription::query()
            ->when($statusFilter === 'active', fn ($query) => $query->where('is_active', true))
            ->when($statusFilter === 'inactive', fn ($query) => $query->where('is_active', false))
            ->when($sortOrder === 'desc', fn ($query) => $query->orderByDesc('price'))
            ->when($sortOrder === 'asc', fn ($query) => $query->orderBy('price'))
            ->get();

        $totalPerMonth = (float) $subscriptions->sum('price');
        $totalPerYear = $totalPerMonth * 12;

        return Inertia::render('Subscriptions/Index', [
            'subscriptions' => $subscriptions->map(fn (Subscription $subscription) => [
                'id' => $subscription->id,
                'name' => $subscription->name,
                'price' => (float) $subscription->price,
                'url' => $subscription->url,
                'isActive' => $subscription->is_active,
            ]),
            'totalPerMonth' => $totalPerMonth,
            'totalPerYear' => $totalPerYear,
            'currencySymbol' => $this->resolveCurrencySymbol(),
            'compactView' => $this->resolveCompactView(),
            'statusFilter' => $statusFilter,
            'sortOrder' => $sortOrder,
            'trackedLabel' => trans_choice('app.subscriptions.tracked', $subscriptions->count(), [
                'count' => $subscriptions->count(),
            ]),
            'title' => __('app.titles.subscriptions'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Subscriptions/Form', [
            'subscription' => null,
            'currencySymbol' => $this->resolveCurrencySymbol(),
            'title' => __('app.titles.add_subscription'),
        ]);
    }

    public function edit(Subscription $subscription): Response
    {
        return Inertia::render('Subscriptions/Form', [
            'subscription' => [
                'id' => $subscription->id,
                'name' => $subscription->name,
                'price' => (string) $subscription->price,
                'url' => $subscription->url,
                'isActive' => $subscription->is_active,
            ],
            'currencySymbol' => $this->resolveCurrencySymbol(),
            'title' => __('app.titles.edit_subscription'),
        ]);
    }

    public function store(StoreSubscriptionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (array_key_exists('url', $data)) {
            $data['url'] = $data['url'] ?: null;
        }
        $data['is_active'] = true;

        Subscription::create($data);

        Dialog::toast(__('app.toasts.subscription_added'));

        return redirect()->route('subscriptions');
    }

    public function update(UpdateSubscriptionRequest $request, Subscription $subscription): RedirectResponse
    {

        $data = $request->validated();
        if (array_key_exists('url', $data)) {
            $data['url'] = $data['url'] ?: null;
        }

        $subscription->update($data);

        Dialog::toast(__('app.toasts.subscription_updated'));

        return redirect()->route('subscriptions');
    }

    public function destroy(Subscription $subscription): RedirectResponse
    {
        $subscription->delete();

        Dialog::toast(__('app.toasts.subscription_deleted'));

        return redirect()->route('subscriptions');
    }

    protected function resolveCurrencySymbol(): string
    {
        $currencies = config('currencies.supported', ['EUR' => '€']);

        try {
            $storedCurrency = SecureStorage::get('currency');
        } catch (\Exception $e) {
            $storedCurrency = null;
        }

        $currency = $storedCurrency ?: array_key_first($currencies);

        return $currencies[$currency] ?? '€';
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
