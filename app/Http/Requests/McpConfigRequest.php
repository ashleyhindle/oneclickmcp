<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class McpConfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|not_regex:/[\'"]/',
            'url' => 'required|url|max:1000|regex:/^https?:\/\//',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Server name is required.',
            'name.not_regex' => 'Server name cannot contain quotes.',
            'url.required' => 'Server URL is required.',
            'url.url' => 'Please enter a valid URL.',
            'url.regex' => 'URL must start with http:// or https://',
        ];
    }
}
