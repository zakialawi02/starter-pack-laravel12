<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:4', 'max:25', 'regex:/^[a-z0-9_]+$/', 'lowercase', 'unique:users,username'],
            'role' => ['required', 'string', 'exists:roles,name'],
            'email' => ['required', 'string', 'email:filter', 'indisposable', 'max:255', 'unique:users,email'],
            'email_verified_at' => ['nullable', 'boolean'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }
}
