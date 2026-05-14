<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = User::query()
                ->when(request('role'), function ($q) {
                    return $q->where('role', request('role'));
                });

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function (User $user) {
                    if ($user->username === 'admin' || $user->id === auth()->id()) {
                        return '';
                    }
                    return '<input type="checkbox" class="user-checkbox size-4 rounded border-border text-primary focus:ring-primary cursor-pointer" value="' . $user->id . '">';
                })
                ->addColumn('action', function (User $user) {
                    $actions = '<div class="flex items-center gap-2">';
                    $actions .= '<button class="text-primary hover:text-primary/70 edit-user" data-id="' . $user->id . '" title="Edit User"><i class="ri-pencil-line text-lg"></i></button>';

                    if ($user->username !== 'admin' && $user->id !== auth()->id()) {
                        $actions .= '<button class="text-error hover:text-error/70 delete-user" data-id="' . $user->id . '" title="Delete User"><i class="ri-delete-bin-line text-lg"></i></button>';
                    }

                    $actions .= '</div>';
                    return $actions;
                })
                ->addColumn('user_info', function (User $user) {
                    $avatar = $user->profile_photo_path
                        ? asset($user->profile_photo_path)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random';

                    return '
                        <div class="flex items-center gap-3">
                            <img src="' . $avatar . '" class="size-10 rounded-full object-cover">
                            <div class="flex flex-col">
                                <span class="text-foreground font-semibold">' . $user->name . '</span>
                                <span class="text-muted-foreground text-xs">' . $user->email . '</span>
                            </div>
                        </div>
                    ';
                })
                ->editColumn('role', function (User $user) {
                    return $user->role instanceof UserRole ? $user->role->value : $user->role;
                })
                ->addColumn('verified', function (User $user) {
                    return $user->email_verified_at;
                })
                ->addColumn('social_login', function (User $user) {
                    return $user->provider_name;
                })
                ->orderColumn('verified', 'email_verified_at')
                ->editColumn('created_at', function (User $user) {
                    return $user->created_at;
                })
                ->filterColumn('user_info', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%")
                            ->orWhere('email', 'like', "%{$keyword}%");
                    });
                })
                ->orderColumn('user_info', 'name')
                ->rawColumns(['checkbox', 'user_info', 'role', 'verified', 'social_login', 'action'])
                ->make(true);
        }

        $data = [
            'title' => __('messages.users_management'),
        ];

        return view('pages.dashboard.users.index', [
            'data' => $data,
            'roles' => UserRole::cases(),
        ]);
    }

    /**
     * Export users to CSV.
     */
    public function export(Request $request)
    {
        $query = User::query()
            ->when($request->role, function ($q) use ($request) {
                return $q->where('role', $request->role);
            })
            ->when($request->search, function ($q) use ($request) {
                $search = $request->search;
                return $q->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                });
            });

        $users = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users_export_' . now()->format('Ymd_His') . '.csv"',
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Username', 'Email', 'Role', 'Status', 'Joined At']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->username,
                    $user->email,
                    $user->role instanceof UserRole ? $user->role->value : $user->role,
                    $user->email_verified_at ? 'Active' : 'Pending',
                    $user->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download CSV template for import.
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users_import_template.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['name', 'username', 'email', 'role', 'password']);
            fputcsv($file, ['John Doe', 'johndoe', 'john@example.com', 'user', 'password123']);
            fputcsv($file, ['Jane Admin', 'janeadmin', 'jane@example.com', 'admin', 'password123']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Preview import data.
     */
    public function importPreview(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $rows = [];
        $header = null;
        $seenUsernames = [];
        $seenEmails = [];

        if (($handle = fopen($file->getRealPath(), 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (!$header) {
                    $header = $data;
                    continue;
                }

                $row = array_combine($header, $data);

                // Use rules from StoreUserRequest
                $rules = (new StoreUserRequest())->rules();

                if (!isset($row['email_verified_at'])) {
                    unset($rules['email_verified_at']);
                }

                $validator = Validator::make($row, $rules);
                $errors = [];
                if ($validator->fails()) {
                    $errors = $validator->errors()->all();
                }

                // Check for duplicates within the CSV file
                if (!empty($row['username']) && in_array(strtolower($row['username']), $seenUsernames)) {
                    $errors[] = 'Duplicate username in this file';
                }
                if (!empty($row['email']) && in_array(strtolower($row['email']), $seenEmails)) {
                    $errors[] = 'Duplicate email in this file';
                }

                // Track seen values (using lowercase for comparison)
                if (!empty($row['username'])) $seenUsernames[] = strtolower($row['username']);
                if (!empty($row['email'])) $seenEmails[] = strtolower($row['email']);

                $rows[] = [
                    'data' => $row,
                    'errors' => $errors,
                    'is_valid' => count($errors) === 0,
                ];
            }
            fclose($handle);
        }

        return response()->json([
            'rows' => $rows,
            'summary' => [
                'total' => count($rows),
                'valid' => count(array_filter($rows, fn($r) => $r['is_valid'])),
                'invalid' => count(array_filter($rows, fn($r) => !$r['is_valid'])),
            ]
        ]);
    }

    /**
     * Confirm import.
     */
    public function importConfirm(Request $request)
    {
        $data = $request->input('users');
        if (empty($data)) {
            return response()->json(['message' => 'No data to import'], 400);
        }

        $count = 0;
        DB::beginTransaction();
        try {
            foreach ($data as $userData) {
                // Final validation before creation
                $validator = Validator::make($userData, (new StoreUserRequest())->rules());

                if ($validator->fails()) {
                    continue; // Skip invalid rows
                }

                User::create([
                    'name' => $userData['name'],
                    'username' => strtolower($userData['username']),
                    'email' => $userData['email'],
                    'role' => $userData['role'],
                    'password' => Hash::make($userData['password']),
                    'email_verified_at' => now(), // Auto verify for batch import
                ]);
                $count++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Import failed: ' . $e->getMessage()], 500);
        }

        return response()->json(['message' => "$count users imported successfully"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $validated = $this->prepareEmailVerification($request->validated());

        $user = User::create($validated)->fresh();

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
        if (
            $user->username === 'admin'
            && $request->filled('role')
            && $request->input('role') !== ($user->role instanceof UserRole ? $user->role->value : $user->role)
        ) {
            return response()->json([
                'success' => false,
                'message' => __('messages.role_change_error'),
                'errors' => ['403' => [__('messages.role_change_error')]],
            ], 403);
        }

        if (
            $user->username === 'admin'
            && $request->filled('username')
            && $request->input('username') !== $user->username
        ) {
            return response()->json([
                'success' => false,
                'message' => __('messages.username_change_error'),
                'errors' => ['403' => [__('messages.username_change_error')]],
            ], 403);
        }

        if (
            $user->username === 'admin'
            && $request->has('email_verified_at')
            && !$request->boolean('email_verified_at')
        ) {
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
        if ($user->username === 'admin' || $user->id === auth()->id()) {
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
     * Remove multiple resources from storage.
     */
    public function batchDestroy(Request $request): JsonResponse
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return response()->json(['message' => 'No users selected'], 400);
        }

        $users = User::whereIn('id', $ids)->get();
        $count = 0;

        foreach ($users as $user) {
            if ($user->username !== 'admin' && $user->id !== auth()->id()) {
                $user->delete();
                $count++;
            }
        }

        if ($count === 0) {
            return response()->json(['message' => 'No users could be deleted (protected accounts or invalid IDs)'], 400);
        }

        return response()->json(['message' => "$count users deleted successfully"]);
    }

    /**
     * Normalise the email verification input for persistence.
     *
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function prepareEmailVerification(array $validated, ?User $user = null): array
    {
        if (!array_key_exists('email_verified_at', $validated)) {
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
