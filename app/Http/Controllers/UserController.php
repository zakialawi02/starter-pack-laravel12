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
                    return '<button href="#" class="btn bg-primary editUser" data-id="' . $data->id . ' "><span class="ri-edit-box-line" title="Edit"></span></button>
                <button type="submit" class="btn bg-error deleteUser" data-id="' . $data->id . ' "><span class="ri-delete-bin-line" title="Delete"></span></button>';
                })
                ->addColumn('photo', function ($data) {
                    return '<img src="' . asset($data->profile_photo_path) . '" width="30">';
                })
                ->editColumn('role', function ($data) {
                    return '<span class="badge bg-' .
                        ($data->role === 'superadmin' ? 'success' : ($data->role === 'admin' ? 'primary' : 'secondary'))
                        . '">' . $data->role . '</span>';
                })
                ->rawColumns(['role', 'photo', 'action'])
                ->removeColumn(['profile_photo_path', 'updated_at', 'id'])
                ->make(true);
        }

        $data = [
            'title' => 'Users Management',
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
            'username' => 'required|min:4|max:25|alpha_dash|unique:users,username',
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
            'message' => 'User created successfully',
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
            'username' => 'required|min:4|max:25|alpha_dash|unique:users,username,' . $user?->id,
            'role' => 'required|in:' . $this->roles,
            'email' => 'required|email|unique:users,email,' . $user?->id,
            'email_verified_at' => 'nullable',
            'password' => 'nullable|min:6',
        ]);
        // Cek jika username adalah admin atau superadmin dan mencoba mengubah role
        if (in_array($user->username, ['admin', 'superadmin']) && $request->has('role') && $request->role !== $user->role) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden: Role cannot be changed.',
                'errors' => ['403' => ['Role cannot be changed for admin or superadmin users.']],
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
                'message' => 'Forbidden: Email verification status cannot be changed.',
                'errors' => ['403' => ['Email verification status cannot be changed for admin or superadmin users unless setting to verified.']],
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
            'message' => 'User updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $admin = User::where('username', 'admin')->first();

        User::where('id', $user->id)->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
