<div class="space-y-8">
    <header class="space-y-4">
        <p class="text-slate-600 dark:text-slate-400 mt-2">See where your recurring money goes every month and year.</p>
    </header>
    <section class="bg-white dark:bg-slate-900 rounded-2xl shadow p-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-slate-500 dark:text-slate-400 text-sm uppercase">Total per month</p>
            <p class="text-3xl font-semibold mt-1 text-slate-900 dark:text-white">
                {{ number_format($totalPerMonth, 2, '.', ',') }} €
            </p>
        </div>
        <div>
            <p class="text-slate-500 dark:text-slate-400 text-sm uppercase">Total per year</p>
            <p class="text-3xl font-semibold mt-1 text-slate-900 dark:text-white">
                {{ number_format($totalPerYear, 2, '.', ',') }} €
            </p>
        </div>
    </section>

    <section>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-4">
            <h2 class="text-2xl font-semibold">Active subscriptions</h2>
            <div class="inline-flex rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 overflow-hidden text-sm">
                <button
                    wire:click="sortBy('desc')"
                    class="px-4 py-2 font-medium transition-colors {{ $sortOrder === 'desc' ? 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-100' : 'bg-transparent text-slate-500 dark:text-slate-300 hover:text-slate-800 dark:hover:text-slate-100' }}"
                >
                    High → Low
                </button>
                <button
                    wire:click="sortBy('asc')"
                    class="px-4 py-2 font-medium transition-colors {{ $sortOrder === 'asc' ? 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-100' : 'bg-transparent text-slate-500 dark:text-slate-300 hover:text-slate-800 dark:hover:text-slate-100' }}"
                >
                    Low → High
                </button>
            </div>
        </div>
        @if($compactView)
            <div class="space-y-4">
                @forelse($subscriptions as $subscription)
                    @php
                        $percentage = $totalPerMonth > 0 ? ($subscription->price / $totalPerMonth) * 100 : 0;
                        $faviconUrl = '';
                        if ($subscription->url) {
                            try {
                                $hostname = parse_url($subscription->url, PHP_URL_HOST);
                                $faviconUrl = $hostname ? "https://favicone.com/{$hostname}" : '';
                            } catch (\Exception $e) {
                                $faviconUrl = '';
                            }
                        }
                    @endphp
                    <div class="subscription-card bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-4 flex items-center justify-between hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            @if($faviconUrl)
                                <img src="{{ $faviconUrl }}" alt="{{ $subscription->name }} icon" class="w-8 h-8 rounded-full bg-white/40 p-1 shrink-0">
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-base font-semibold text-slate-900 dark:text-slate-100 truncate">{{ $subscription->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ number_format($percentage, 1) }}% of monthly spend</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 ml-4">
                            <div class="text-right">
                                <p class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ number_format($subscription->price, 2, '.', ',') }} €</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">/ month</p>
                            </div>
                            <div class="flex gap-2">
                                <button
                                    wire:click="edit({{ $subscription->id }})"
                                    aria-label="Edit {{ $subscription->name }}"
                                    title="Edit"
                                    class="w-10 h-10 rounded-full bg-sky-100 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 hover:bg-sky-200 dark:hover:bg-sky-800 flex items-center justify-center transition-colors shrink-0"
                                    style="aspect-ratio: 1 / 1;"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button
                                    wire:click="delete({{ $subscription->id }})"
                                    aria-label="Delete {{ $subscription->name }}"
                                    title="Delete"
                                    class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-800 flex items-center justify-center transition-colors shrink-0"
                                    style="aspect-ratio: 1 / 1;"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <p class="text-slate-500 dark:text-slate-400">No subscriptions yet. Add your first subscription!</p>
                    </div>
                @endforelse
            </div>
        @else
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($subscriptions as $subscription)
                    @php
                        $percentage = $totalPerMonth > 0 ? ($subscription->price / $totalPerMonth) * 100 : 0;
                        $colors = match (true) {
                            $subscription->price >= 30 => [
                                'card' => 'bg-gradient-to-br from-rose-500 via-rose-400 to-rose-600 text-white',
                                'accent' => 'text-white/80',
                            ],
                            $subscription->price >= 15 => [
                                'card' => 'bg-gradient-to-br from-amber-400 via-orange-400 to-orange-500 text-white',
                                'accent' => 'text-white/80',
                            ],
                            $subscription->price >= 8 => [
                                'card' => 'bg-gradient-to-br from-sky-500 via-indigo-500 to-indigo-600 text-white',
                                'accent' => 'text-white/80',
                            ],
                            default => [
                                'card' => 'bg-white text-slate-900 border border-slate-200 dark:bg-slate-900 dark:text-slate-100 dark:border-slate-800',
                                'accent' => 'text-slate-500 dark:text-slate-400',
                            ],
                        };
                        $faviconUrl = '';
                        if ($subscription->url) {
                            try {
                                $hostname = parse_url($subscription->url, PHP_URL_HOST);
                                $faviconUrl = $hostname ? "https://favicone.com/{$hostname}" : '';
                            } catch (\Exception $e) {
                                $faviconUrl = '';
                            }
                        }
                    @endphp
                    <div class="subscription-card rounded-2xl shadow p-5 flex flex-col justify-between {{ $colors['card'] }}" style="min-height: 210px;">
                        <div>
                            <p class="text-sm uppercase tracking-wide {{ $colors['accent'] }}">Monthly</p>
                            <p class="text-3xl font-bold">{{ number_format($subscription->price, 2, '.', ',') }} €</p>
                            <p class="text-sm {{ $colors['accent'] }}">{{ number_format($percentage, 1) }}% of monthly spend</p>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                @if($faviconUrl)
                                    <img src="{{ $faviconUrl }}" alt="{{ $subscription->name }} icon" class="w-6 h-6 rounded-full bg-white/40 p-1">
                                @endif
                                <p class="text-lg font-semibold">{{ $subscription->name }}</p>
                            </div>
                            <p class="text-sm {{ $colors['accent'] }}">{{ number_format($subscription->price * 12, 2, '.', ',') }} € / year</p>
                            <div class="flex gap-2 mt-2">
                                <button
                                    wire:click="edit({{ $subscription->id }})"
                                    aria-label="Edit {{ $subscription->name }}"
                                    title="Edit"
                                    class="w-10 h-10 rounded-full bg-sky-500/10 dark:bg-sky-400/20 text-sky-600 dark:text-sky-300 hover:bg-sky-500/20 dark:hover:bg-sky-400/30 flex items-center justify-center transition-colors shrink-0"
                                    style="aspect-ratio: 1 / 1;"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button
                                    wire:click="delete({{ $subscription->id }})"
                                    aria-label="Delete {{ $subscription->name }}"
                                    title="Delete"
                                    class="w-10 h-10 rounded-full bg-red-500/10 dark:bg-red-400/20 text-red-600 dark:text-red-300 hover:bg-red-500/20 dark:hover:bg-red-400/30 flex items-center justify-center transition-colors shrink-0"
                                    style="aspect-ratio: 1 / 1;"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-slate-500 dark:text-slate-400">No subscriptions yet. Add your first subscription!</p>
                    </div>
                @endforelse
            </div>
        @endif
    </section>

    <style>
        .subscription-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .subscription-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }
    </style>
</div>
