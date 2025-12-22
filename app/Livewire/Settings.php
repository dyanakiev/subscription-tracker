<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Native\Mobile\Facades\Dialog;
use Native\Mobile\Facades\SecureStorage;

#[Layout('layouts.app')]
#[Title('Settings')]
class Settings extends Component
{
    public bool $compactView = false;

    public function mount(): void
    {
        try {
            $this->compactView = SecureStorage::get('compact_view') === 'true';
        } catch (\Exception $e) {
            $this->compactView = false;
        }
    }

    public function toggleCompactView(): void
    {
        $this->compactView = ! $this->compactView;

        try {
            SecureStorage::set('compact_view', $this->compactView ? 'true' : 'false');
        } catch (\Exception $e) {
            // Fallback if SecureStorage is not available
        }

        Dialog::toast($this->compactView ? 'Compact view enabled' : 'Compact view disabled');
    }

    public function render()
    {
        return view('livewire.settings');
    }
}
