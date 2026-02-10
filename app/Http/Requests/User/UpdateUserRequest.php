<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->resolveUserId();

        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:4', 'max:25', 'regex:/^[a-z0-9_]+$/', 'lowercase', Rule::unique('users', 'username')->ignore($userId)],
            'role' => ['required', 'string', 'exists:roles,name'],
            'email' => ['required', 'string', 'email:filter', 'indisposable', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'email_verified_at' => ['nullable', 'boolean'],
            'password' => ['nullable', 'string', 'min:6'],
        ];
    }

    protected function resolveUserId(): string|int|null
    {
        $user = $this->route('user');

        return $user instanceof User ? $user->getKey() : $user;
    }
}
