<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Role::with('permissions');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('permissions', function (Role $role) {
                    return $role->permissions->pluck('name')
                        ->map(fn ($name) => '<span class="badge bg-primary me-1">' . e($name) . '</span>')
                        ->implode(' ');
                })
                ->addColumn('users_count', fn (Role $role) => $role->users()->count())
                ->addColumn('action', function (Role $role) {
                    $buttons = '<button class="btn bg-primary edit-role" data-id="' . $role->id . '"><span class="ri-edit-box-line" title="Edit"></span></button>';
                    if (! in_array($role->name, ['superadmin'])) {
                        $buttons .= ' <button type="submit" class="btn bg-error delete-role" data-id="' . $role->id . '"><span class="ri-delete-bin-line" title="Delete"></span></button>';
                    }

                    return $buttons;
                })
                ->rawColumns(['permissions', 'action'])
                ->make(true);
        }

        $data = [
            'title' => __('Roles Management'),
        ];

        return view('pages.dashboard.roles.index', [
            'data' => $data,
            'permissions' => Permission::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        $role = Role::create(['name' => $request->validated('name')]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->input('permissions', []));
        }

        return response()->json([
            'role' => $role->load('permissions'),
            'message' => __('Role created successfully.'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): JsonResponse
    {
        return response()->json([
            'id' => $role->id,
            'name' => $role->name,
            'permissions' => $role->permissions->pluck('name'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        if ($role->name === 'superadmin' && $request->input('name') !== 'superadmin') {
            return response()->json([
                'success' => false,
                'message' => __('Cannot rename the superadmin role.'),
                'errors' => ['name' => [__('Cannot rename the superadmin role.')]],
            ], 403);
        }

        $role->update(['name' => $request->validated('name')]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->input('permissions', []));
        }

        return response()->json([
            'role' => $role->load('permissions'),
            'message' => __('Role updated successfully.'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): JsonResponse
    {
        if ($role->name === 'superadmin') {
            return response()->json([
                'success' => false,
                'message' => __('Cannot delete the superadmin role.'),
            ], 403);
        }

        $role->delete();

        return response()->json(['message' => __('Role deleted successfully.')]);
    }
}
