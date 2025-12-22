<div class="space-y-8">
    <header class="space-y-4">
        <p class="text-slate-600 dark:text-slate-400 mt-2">
            {{ $subscription ? 'Edit your subscription details.' : 'Add a new subscription to track.' }}
        </p>
    </header>

    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow p-6">
    <form wire:submit="save" class="space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                Name
            </label>
            <input
                type="text"
                id="name"
                wire:model="name"
                class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                placeholder="e.g., Netflix"
            >
            @error('name')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="price" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                Monthly Price (€)
            </label>
            <input
                type="number"
                id="price"
                wire:model="price"
                step="0.01"
                min="0"
                class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                placeholder="0.00"
            >
            @error('price')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="url" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                URL (optional)
            </label>
            <input
                type="url"
                id="url"
                wire:model="url"
                class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                placeholder="https://example.com"
            >
            @error('url')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="w-full px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg transition-colors"
        >
            {{ $subscription ? 'Update Subscription' : 'Add Subscription' }}
        </button>

        @if($subscription)
            <button
                type="button"
                wire:click="cancel"
                class="w-full px-4 py-2 bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-900 dark:text-slate-100 font-medium rounded-lg transition-colors"
            >
                Cancel
            </button>
        @endif
    </form>
    </div>
</div>
