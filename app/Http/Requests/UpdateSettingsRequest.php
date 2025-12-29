<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'compact_view' => ['sometimes', 'boolean'],
            'locale' => [
                'sometimes',
                'string',
                Rule::in(array_keys(config('languages.supported', ['en' => 'English']))),
            ],
            'currency' => [
                'sometimes',
                'string',
                Rule::in(array_keys(config('currencies.supported', ['EUR' => '€']))),
            ],
        ];
    }
}
