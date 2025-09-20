<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $roles;

    public function __construct()
    {
        // Inisialisasi nilai enum dari model
        $this->roles = implode(',', User::getRoleOptions());
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = User::query();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<button href="#" class="btn bg-primary edit-user" data-id="' . $data->id . ' "><span class="ri-edit-box-line" title="Edit"></span></button>
                <button type="submit" class="btn bg-error delete-user" data-id="' . $data->id . ' "><span class="ri-delete-bin-line" title="Delete"></span></button>';
                })
                ->addColumn('photo', function ($data) {
                    return '<img src="' . asset($data->profile_photo_path) . '" width="30">';
                })
                ->rawColumns(['photo', 'action'])
                ->removeColumn(['profile_photo_path', 'updated_at', 'id'])
                ->make(true);
        }

        $data = [
            'title' => __('messages.users_management'),
        ];

        // Ambil data enum role dari model
        $roles = explode(',', $this->roles);

        return view('pages.dashboard.users.index', compact('data', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:4|max:25|alpha_num|lowercase|unique:users,username',
            'role' => 'required|in:' . $this->roles,
            'email' => 'required|email|unique:users,email',
            'email_verified_at' => 'nullable',
            'password' => 'required|min:6',
        ]);
        $user = User::create($validated);
        $data = User::where('id', $user->id)->first();
        $data['created_at'] = $data->created_at->format('d M Y');

        return response()->json([
            'user' => $data,
            'message' => __('messages.user_created_success'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:4|max:25|alpha_num|lowercase|unique:users,username,' . $user?->id,
            'role' => 'required|in:' . $this->roles,
            'email' => 'required|email|indisposable|unique:users,email,' . $user?->id,
            'email_verified_at' => 'nullable',
            'password' => 'nullable|min:6',
        ]);
        // Cek jika username adalah admin atau superadmin dan mencoba mengubah role
        if (in_array($user->username, ['admin', 'superadmin']) && $request->has('role') && $request->role !== $user->role) {
            return response()->json([
                'success' => false,
                'message' => __('messages.role_change_error'),
                'errors' => ['403' => [__('messages.role_change_error')]],
            ], 403);
        }
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }
        $userFromDB = User::where('id', $user->id)->first();
        // Cek jika username adalah admin atau superadmin dan mencoba mengubah email_verified_at selain ke true
        if (in_array($user->username, ['admin', 'superadmin']) && isset($validated['email_verified_at']) && $validated['email_verified_at'] !== "1") {
            return response()->json([
                'success' => false,
                'message' => __('messages.email_verification_change_error'),
                'errors' => ['403' => [__('messages.email_verification_change_error')]],
            ], 403);
        }
        if ($validated['email_verified_at'] == "1") {
            if (is_null($userFromDB->email_verified_at)) {
                $validated['email_verified_at'] = now();
            } else {
                unset($validated['email_verified_at']);
            }
        } elseif ($validated['email_verified_at'] == "0") {
            $validated['email_verified_at'] = null;
        }

        $user->update($validated);
        $user = User::where('id', $user->id)->first();

        return response()->json([
            'user' => $user,
            'status' => $userFromDB->email_verified_at?->toDateTimeString() ?? false,
            'message' => __('messages.user_updated_success'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Check if the user is admin or superadmin
        if (in_array($user->username, ['admin', 'superadmin'])) {
            return response()->json([
                'success' => false,
                'message' => __('messages.admin_delete_error'),
                'errors' => 'Forbidden: ' . __('messages.admin_delete_error'),
            ], 403);
        }

        $user->delete();

        return response()->json(['message' => __('messages.user_deleted_success')]);
    }
}
