<div class="space-y-8">
    <header class="space-y-4 animate-fade-up">
        <div class="inline-flex items-center gap-2 rounded-full border border-violet-200/70 bg-violet-100/70 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-violet-700 dark:border-violet-500/40 dark:bg-violet-500/10 dark:text-violet-200">
            <span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span>
            Preferences
        </div>
        <h1 class="text-3xl font-semibold tracking-tight text-slate-900 dark:text-white">Personalize your tracker</h1>
        <p class="text-slate-600 dark:text-slate-400 mt-2">Manage your application preferences.</p>
    </header>

    <div class="app-card-strong p-6 animate-fade-up animation-delay-150">
        <h3 class="text-xl font-semibold mb-6">Display Settings</h3>

        <div class="space-y-4">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-900 dark:text-slate-100">Compact View</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Show subscriptions in a more compact layout</p>
                </div>
                <button
                    wire:click="toggleCompactView"
                    class="inline-flex items-center gap-2 rounded-full border border-slate-200/80 dark:border-slate-700 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-100 bg-white dark:bg-slate-900/50 shadow-sm transition-colors hover:bg-slate-50 dark:hover:bg-slate-800"
                >
                    <span class="h-2 w-2 rounded-full {{ $compactView ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                    {{ $compactView ? 'Enabled' : 'Disabled' }}
                </button>
            </div>
        </div>
    </div>
</div>
