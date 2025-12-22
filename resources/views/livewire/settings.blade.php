<div class="space-y-8">
    <header class="space-y-2">
        <p class="text-slate-600 dark:text-slate-400 mt-2">Manage your application preferences.</p>
    </header>

    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow p-6">
        <h3 class="text-xl font-semibold mb-6">Display Settings</h3>

        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-900 dark:text-slate-100">Compact View</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Show subscriptions in a more compact layout</p>
                </div>
                <button
                    wire:click="toggleCompactView"
                    class="inline-flex items-center gap-2 rounded-full border border-slate-200 dark:border-slate-700 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-100 bg-white dark:bg-slate-900/50 shadow-sm transition-colors hover:bg-slate-50 dark:hover:bg-slate-800"
                >
                    {{ $compactView ? 'Enabled' : 'Disabled' }}
                </button>
            </div>
        </div>
    </div>
    
</div>