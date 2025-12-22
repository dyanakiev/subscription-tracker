<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css'])
    @livewireStyles
</head>
<body class="bg-slate-100 text-slate-900 dark:bg-slate-950 dark:text-slate-100 min-h-screen transition-colors nativephp-safe-area">
    
    <native:top-bar title="{{ $title ?? config('app.name') }}" :show-navigation-icon="false"></native:top-bar>

    <div class="max-w-5xl mx-auto p-6 space-y-8">
        {{ $slot }}
    </div>
    
    <native:bottom-nav label-visibility="labeled">
        <native:bottom-nav-item
            id="subscriptions"
            icon="home"
            label="Subscriptions"
            url="{{ route('subscriptions') }}"
            actitve="{{ request()->routeIs('subscriptions') }}"
        />
        <native:bottom-nav-item
            id="Add Subscription"
            icon="plus"
            label="Add Subscription"
            url="{{ route('add-subscription') }}"
            actitve="{{ request()->routeIs('add-subscription') }}"
        />
        <native:bottom-nav-item
            id="settings"
            icon="settings"
            label="Settings"
            url="{{ route('settings') }}"
            actitve="{{ request()->routeIs('settings') }}"
        />
    </native:bottom-nav>

    @livewireScripts
</body>
</html>

