<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class PrivacyPolicyController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('PrivacyPolicy', [
            'effectiveDate' => 'December 24, 2025',
            'title' => __('app.settings.privacy_policy'),
        ]);
    }
}
