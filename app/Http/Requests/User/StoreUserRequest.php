<?php

namespace App\Http\Requests\User;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (is_string($this->username)) {
            $this->merge([
                'username' => strtolower($this->username),
            ]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:4', 'max:25', 'regex:/^[a-z0-9_]+$/', 'lowercase', 'unique:users,username'],
            'role' => ['required', new Enum(UserRole::class)],
            'email' => ['required', 'string', 'email:filter', 'indisposable', 'max:255', 'unique:users,email'],
            'email_verified_at' => ['nullable', 'boolean'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('Name is required.'),
            'username.required' => __('Username is required.'),
            'username.min' => __('Username must be at least 4 characters long.'),
            'username.max' => __('Username must be at most 25 characters long.'),
            'username.regex' => __('Username must contain only lowercase letters, numbers, and underscores.'),
            'username.unique' => __('Username is already taken.'),
            'role.required' => __('Role is required.'),
            'email.required' => __('Email is required.'),
            'email.email' => __('Email is invalid.'),
            'email.indisposable' => __('Email is invalid.'),
            'email.max' => __('Email must be at most 255 characters long.'),
            'email.unique' => __('Email is already taken.'),
            'email_verified_at.boolean' => __('Email verified at must be a boolean.'),
            'password.required' => __('Password is required.'),
            'password.min' => __('Password must be at least 6 characters long.'),
            'password.confirmed' => __('Passwords do not match.'),
        ];
    }
}
