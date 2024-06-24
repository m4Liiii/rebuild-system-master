<?php

namespace App\Http\Controllers\Permission;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionResource;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 1);

        $query = Role::query();

        if ($searchTerm = $request->input('search')) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $roles = $query->orderBy('id', 'desc')
                      ->paginate($perPage)
                      ->appends([
                          'search' => $request->input('search'),
                          'perPage' => $perPage
                      ]);

        $rolesResource = RoleResource::collection($roles);

        return inertia('Permission/Index', [
            'roles' => $rolesResource
        ]);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create() :Response
    {
        return inertia('Permission/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {

       $role = Role::create([
            'name' => $request->name,

        ]);

        return to_route('roles.edit' , $role->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): Response
    {
        $role->load('permissions');
        return inertia('Permission/Edit',
        [
            'role' => new RoleResource($role),
            'permissions' => PermissionResource::collection(Permission::all())
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {

        $role->update([
            'name' => $request->name,
        ]);
        $role->syncPermissions($request->input('permission'));
        logger($request->all());

        return to_route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return back();
    }

}
