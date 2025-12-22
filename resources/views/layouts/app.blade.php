<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css'])
    @livewireStyles
</head>
<body class="min-h-screen text-slate-900 dark:text-slate-100 antialiased bg-gradient-to-br from-amber-50 via-slate-50 to-sky-100 dark:from-slate-950 dark:via-slate-950 dark:to-slate-900 transition-colors relative overflow-x-hidden nativephp-safe-area">
    <div class="pointer-events-none fixed inset-0 -z-10">
        <div class="absolute -top-24 -left-24 h-72 w-72 rounded-full bg-amber-200/60 blur-3xl dark:bg-amber-500/10"></div>
        <div class="absolute top-20 -right-16 h-80 w-80 rounded-full bg-sky-300/50 blur-3xl dark:bg-sky-500/10"></div>
        <div class="absolute bottom-10 left-1/3 h-64 w-64 rounded-full bg-rose-200/40 blur-3xl dark:bg-rose-500/10"></div>
    </div>

    <header class="max-w-5xl mx-auto px-5 pt-6">
        <div class="app-card-strong px-5 py-4 flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Track your expenses</p>
                <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">
                    Subscription Tracker
                </h1>
            </div>
            <div class="h-10 w-10 rounded-full bg-slate-900 text-white dark:bg-white dark:text-slate-900 flex items-center justify-center">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M6 7.5H18C19.1046 7.5 20 8.39543 20 9.5V17C20 18.1046 19.1046 19 18 19H6C4.89543 19 4 18.1046 4 17V9.5C4 8.39543 4.89543 7.5 6 7.5Z" stroke="currentColor" stroke-width="1.5" />
                    <path d="M8 7.5V6.25C8 5.00736 9.00736 4 10.25 4H13.75C14.9926 4 16 5.00736 16 6.25V7.5" stroke="currentColor" stroke-width="1.5" />
                    <path d="M7.5 12.5H11.5" stroke="currentColor" stroke-linecap="round" stroke-width="1.5" />
                    <path d="M7.5 15.5H14.5" stroke="currentColor" stroke-linecap="round" stroke-width="1.5" />
                </svg>
            </div>
        </div>
    </header>

    <div class="max-w-5xl mx-auto px-5 pt-6 pb-28 space-y-8">
        {{ $slot }}
    </div>
    
    <native:bottom-nav label-visibility="labeled">
        <native:bottom-nav-item
            id="subscriptions"
            icon="home"
            label="Subscriptions"
            url="{{ route('subscriptions') }}"
            active="{{ request()->routeIs('subscriptions') }}"
        />
        <native:bottom-nav-item
            id="Add Subscription"
            icon="plus"
            label="Add Subscription"
            url="{{ route('add-subscription') }}"
            active="{{ request()->routeIs('add-subscription') }}"
        />
        <native:bottom-nav-item
            id="settings"
            icon="settings"
            label="Settings"
            url="{{ route('settings') }}"
            active="{{ request()->routeIs('settings') }}"
        />
    </native:bottom-nav>

    @livewireScripts
</body>
</html>
