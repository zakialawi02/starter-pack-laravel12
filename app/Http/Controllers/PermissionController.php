<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Permission::query();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('roles', function (Permission $permission) {
                    return $permission->roles->pluck('name')
                        ->map(fn ($name) => '<span class="badge bg-secondary me-1">' . e($name) . '</span>')
                        ->implode(' ');
                })
                ->addColumn('action', function (Permission $permission) {
                    return '<button class="btn bg-primary edit-permission" data-id="' . $permission->id . '"><span class="ri-edit-box-line" title="Edit"></span></button>
                        <button type="submit" class="btn bg-error delete-permission" data-id="' . $permission->id . '"><span class="ri-delete-bin-line" title="Delete"></span></button>';
                })
                ->rawColumns(['roles', 'action'])
                ->make(true);
        }

        $data = [
            'title' => __('Permissions Management'),
        ];

        return view('pages.dashboard.permissions.index', [
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request): JsonResponse
    {
        $permission = Permission::create(['name' => $request->validated('name')]);

        return response()->json([
            'permission' => $permission,
            'message' => __('Permission created successfully.'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission): JsonResponse
    {
        return response()->json([
            'id' => $permission->id,
            'name' => $permission->name,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission): JsonResponse
    {
        $permission->update(['name' => $request->validated('name')]);

        return response()->json([
            'permission' => $permission,
            'message' => __('Permission updated successfully.'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission): JsonResponse
    {
        $permission->delete();

        return response()->json(['message' => __('Permission deleted successfully.')]);
    }
}
