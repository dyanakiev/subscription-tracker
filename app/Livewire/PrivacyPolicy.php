<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class PrivacyPolicy extends Component
{
    public function render(): View
    {
        return view('livewire.privacy-policy', [
            'title' => __('app.settings.privacy_policy'),
            'effectiveDate' => 'December 24, 2025',
        ]);
    }
}
