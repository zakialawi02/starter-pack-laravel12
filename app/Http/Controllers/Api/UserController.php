<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Database\QueryException;
use App\Http\Requests\Api\StoreUserRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\Api\UpdateUserRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    protected $roles;

    public function __construct()
    {
        // Inisialisasi nilai enum dari model
        $this->roles = implode(',', User::getRoleOptions());
    }

    public function index(): JsonResponse
    {
        $users = User::all();

        try {
            return response()->json([
                'success' => true,
                'message' => 'List of all users',
                'data' => UserResource::collection($users),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => new UserResource($user)
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
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
            $user = User::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'User created successfully.',
                'data' => new UserResource($user),
            ], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database error: Failed to create user.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        try {
            if (empty($request['password'])) {
                unset($request['password']);
            } else {
                $request['password'] = bcrypt($request['password']);
            }
            $user = User::findOrFail($id);
            // Cek jika username adalah admin atau superadmin dan mencoba mengubah role
            if (in_array($user->username, ['admin', 'superadmin']) && $request->has('role') && $request->role !== $user->role) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden: Role cannot be changed.',
                    'errors' => 'Role cannot be changed for admin or superadmin users.',
                ], 403);
            }
            // Cek jika username adalah admin atau superadmin dan mencoba mengubah email_verified_at selain ke true
            if (in_array($user->username, ['admin', 'superadmin']) && isset($request['email_verified_at']) && $request['email_verified_at'] != 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden: Email verification status cannot be changed.',
                    'errors' => 'Email verification status cannot be changed for admin or superadmin users unless setting to verified.',
                ], 403);
            }
            if ($request['email_verified_at'] == "1") {
                if (is_null($user->email_verified_at)) {
                    $request['email_verified_at'] = now();
                } else {
                    unset($request['email_verified_at']);
                }
            } elseif ($request['email_verified_at'] == "0") {
                $request['email_verified_at'] = null;
            }
            $user->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully.',
                'data' => new UserResource($user),
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


    // MY PROFILE

    /**
     * Retrieve the authenticated user's profile details.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'User details/My profile',
                'data' => new UserResource($request->user()),
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
            $request->user()->fill($request->validated());
            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }
            $request->user()->save();
            return response()->json([
                'success' => true,
                'message' => [
                    'status' => 'profile-updated',
                    'text' => 'Profile updated successfully.',
                    'message' => 'Please verify your email address.',
                ],
                'data' => new UserResource($request->user()),
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

            // Mengambil file yang diupload
            $file = $request->file('photo_profile');
            $timestamp = now()->timestamp;
            $randomString = uniqid();
            $extension = $file->getClientOriginalExtension();
            $newFileName = $timestamp . '_' . $randomString . '.' . $extension;

            // Cek jika pengguna sudah memiliki foto profil yang lama
            $user = $request->user();
            if ($user->profile_photo_path && $user->profile_photo_path != '/assets/img/profile/user.png' && $user->profile_photo_path != '/assets/img/profile/admin.png') {
                // Cek apakah file foto lama ada di direktori penyimpanan publik dan hapus
                $oldPhotoPath = public_path($user->profile_photo_path);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath); // Hapus foto lama
                }
            }

            // Menyimpan file ke storage publik dengan nama baru
            $file->storeAs('profile_photos', $newFileName, 'public');
            $path = '/storage/profile_photos/' . $newFileName;
            // Update path foto profil di database
            $user->profile_photo_path = $path;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile photo updated successfully.',
                'data' => new UserResource($user),
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

            $id = $request->user()->id;
            $user = User::findOrFail($id);
            $request->user()->currentAccessToken()->delete();
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
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred.',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
