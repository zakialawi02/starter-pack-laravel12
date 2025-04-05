<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateUserRequest extends FormRequest
{
    protected $roles;
    public function prepareForValidation()
    {
        // Ambil ID user dari route
        $userId = $this->route('user');
        // Jika user tidak ditemukan, langsung return response JSON
        if (!User::find($userId)) {
            abort(response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], Response::HTTP_NOT_FOUND));
        }
        // Inisialisasi nilai enum dari model
        $this->roles = implode(',', User::getRoleOptions());
    }


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
        $userId = $this->route('user'); // Ambil ID user dari URL
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:4|max:25|alpha_dash|unique:users,username,' . $userId,
            'role' => 'required|in:' . $this->roles,
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:6', // Password tidak wajib diupdate
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $validator->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new ValidationException($validator, $response);
    }
}
