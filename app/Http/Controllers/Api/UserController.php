<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreUserRequest;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::all();

        try {
            return response()->json([
                'success' => true,
                'message' => 'List of all users',
                'data' => UserResource::collection($users),
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => UserResource::make($user),
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $payload = $this->prepareEmailVerification($request->validated());

            $user = User::create($payload)->fresh();

            return response()->json([
                'success' => true,
                'message' => 'User created successfully.',
                'data' => UserResource::make($user),
            ], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database error: Failed to create user.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred.',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            if (in_array($user->username, ['admin', 'superadmin'], true)
                && $request->filled('role')
                && $request->input('role') !== ($user->role instanceof UserRole ? $user->role->value : $user->role)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden: Role cannot be changed.',
                    'errors' => 'Role cannot be changed for admin or superadmin users.',
                ], Response::HTTP_FORBIDDEN);
            }

            if (in_array($user->username, ['admin', 'superadmin'], true)
                && $request->has('email_verified_at')
                && ! $request->boolean('email_verified_at')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden: Email verification status cannot be changed.',
                    'errors' => 'Email verification status cannot be changed for admin or superadmin users unless setting to verified.',
                ], Response::HTTP_FORBIDDEN);
            }

            $payload = $this->prepareEmailVerification($request->validated(), $user);

            if (empty($payload['password'])) {
                unset($payload['password']);
            }

            $user->update($payload);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully.',
                'data' => UserResource::make($user->fresh()),
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
                'error' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred.',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            if (in_array($user->username, ['admin', 'superadmin'], true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin or Superadmin username cannot be deleted.',
                    'errors' => 'Forbidden: Admin or Superadmin username cannot be deleted.',
                ], Response::HTTP_FORBIDDEN);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully.',
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
                'error' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred.',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function me(Request $request): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'User details/My profile',
                'data' => UserResource::make(Auth::user()),
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateMyProfile(ProfileUpdateRequest $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $user->fill($request->validated());

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => [
                    'status' => 'profile-updated',
                    'text' => 'Profile updated successfully.',
                    'message' => 'Please verify your email address.',
                ],
                'data' => UserResource::make($user),
            ], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Password does not match.',
                'error' => $e->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateMyPhotoProfile(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'photo_profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $file = $request->file('photo_profile');
            $timestamp = now()->timestamp;
            $randomString = uniqid();
            $extension = $file->getClientOriginalExtension();
            $newFileName = $timestamp . '_' . $randomString . '.' . $extension;

            $user = Auth::user();

            if ($user->profile_photo_path && ! in_array($user->profile_photo_path, ['/assets/img/profile/user.png', '/assets/img/profile/admin.png'], true)) {
                $oldPhotoPath = public_path($user->profile_photo_path);

                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }

            $file->storeAs('profile_photos', $newFileName, 'public');
            $path = '/storage/profile_photos/' . $newFileName;

            $user->profile_photo_path = $path;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile photo updated successfully.',
                'data' => UserResource::make($user),
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error.',
                'error' => $e->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroyMyAccount(Request $request): JsonResponse
    {
        try {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);

            $user = User::findOrFail(Auth::id());

            $currentToken = $request->user()->currentAccessToken();
            if ($currentToken) {
                $request->user()->tokens()->where('id', $currentToken->id)->delete();
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully.',
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
                'error' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Password does not match.',
                'error' => $e->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred.',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function prepareEmailVerification(array $validated, ?User $user = null): array
    {
        if (! array_key_exists('email_verified_at', $validated)) {
            return $validated;
        }

        $shouldVerify = (bool) $validated['email_verified_at'];

        if ($shouldVerify) {
            if ($user && $user->email_verified_at) {
                unset($validated['email_verified_at']);
            } else {
                $validated['email_verified_at'] = now();
            }
        } else {
            $validated['email_verified_at'] = null;
        }

        return $validated;
    }
}
