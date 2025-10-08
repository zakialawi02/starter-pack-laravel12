<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\User\UpdateUserRequest as BaseUpdateUserRequest;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class UpdateUserRequest extends BaseUpdateUserRequest
{
    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $userId = $this->resolveUserId();

        if ($userId && ! User::query()->whereKey($userId)->exists()) {
            abort(response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], Response::HTTP_NOT_FOUND));
        }
    }

    /**
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $validator->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new ValidationException($validator, $response);
    }
}
