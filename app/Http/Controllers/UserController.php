<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = User::query();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function (User $user) {
                    return '<button href="#" class="btn bg-primary edit-user" data-id="' . $user->id . ' "><span class="ri-edit-box-line" title="Edit"></span></button>
                <button type="submit" class="btn bg-error delete-user" data-id="' . $user->id . ' "><span class="ri-delete-bin-line" title="Delete"></span></button>';
                })
                ->addColumn('photo', function (User $user) {
                    return '<img src="' . asset($user->profile_photo_path) . '" width="30">';
                })
                ->editColumn('role', fn (User $user) => $user->getRoleNames()->first() ?? ($user->role instanceof UserRole ? $user->role->value : $user->role))
                ->rawColumns(['photo', 'action'])
                ->removeColumn(['profile_photo_path', 'updated_at', 'id'])
                ->make(true);
        }

        $data = [
            'title' => __('messages.users_management'),
        ];

        return view('pages.dashboard.users.index', [
            'data' => $data,
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $validated = $this->prepareEmailVerification($request->validated());

        $user = User::create($validated)->fresh();

        // Assign Spatie role
        if (! empty($validated['role'])) {
            $user->syncRoles([$validated['role']]);
        }

        return response()->json([
            'user' => UserResource::make($user)->toArray($request),
            'message' => __('messages.user_created_success'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json(UserResource::make($user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        if (in_array($user->username, ['admin', 'superadmin'], true)
            && $request->filled('role')
            && $request->input('role') !== ($user->role instanceof UserRole ? $user->role->value : $user->role)) {
            return response()->json([
                'success' => false,
                'message' => __('messages.role_change_error'),
                'errors' => ['403' => [__('messages.role_change_error')]],
            ], 403);
        }

        if (in_array($user->username, ['admin', 'superadmin'], true)
            && $request->has('email_verified_at')
            && ! $request->boolean('email_verified_at')) {
            return response()->json([
                'success' => false,
                'message' => __('messages.email_verification_change_error'),
                'errors' => ['403' => [__('messages.email_verification_change_error')]],
            ], 403);
        }

        $validated = $this->prepareEmailVerification($request->validated(), $user);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);
        $user->refresh();

        // Sync Spatie role
        if (! empty($validated['role'])) {
            $user->syncRoles([$validated['role']]);
        }

        return response()->json([
            'user' => UserResource::make($user)->toArray($request),
            'status' => $user->email_verified_at?->toDateTimeString() ?? false,
            'message' => __('messages.user_updated_success'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        if (in_array($user->username, ['admin', 'superadmin'], true)) {
            return response()->json([
                'success' => false,
                'message' => __('messages.admin_delete_error'),
                'errors' => 'Forbidden: ' . __('messages.admin_delete_error'),
            ], 403);
        }

        $user->delete();

        return response()->json(['message' => __('messages.user_deleted_success')]);
    }

    /**
     * Normalise the email verification input for persistence.
     *
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
