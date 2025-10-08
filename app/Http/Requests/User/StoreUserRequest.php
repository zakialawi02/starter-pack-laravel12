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

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:4', 'max:25', 'alpha_num', 'lowercase', 'unique:users,username'],
            'role' => ['required', new Enum(UserRole::class)],
            'email' => ['required', 'string', 'email:filter', 'indisposable', 'max:255', 'unique:users,email'],
            'email_verified_at' => ['nullable', 'boolean'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }
}
