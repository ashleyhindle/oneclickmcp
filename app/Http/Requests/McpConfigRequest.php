<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class McpConfigRequest extends FormRequest
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
            'name' => 'required|string|max:255|regex:/^[a-zA-Z0-9\-_.]+$/',
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
            'name.regex' => 'Server name can only contain letters, numbers, hyphens, underscores, and dots.',
            'url.required' => 'Server URL is required.',
            'url.url' => 'Please enter a valid URL.',
            'url.regex' => 'URL must start with http:// or https://',
        ];
    }
}
