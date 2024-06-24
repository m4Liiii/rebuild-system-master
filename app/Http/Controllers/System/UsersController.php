<?php

namespace App\Http\Controllers\System;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\System\UsersRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\System\UsersResource;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) :Response
    {

        $users = User::search([
            'name' => $request->input('search')
        ])
        ->orderBy('id', 'desc')
        ->paginateQuery();

        $users = $users->appends([
            'search' => $request->input('search'),
            'perPage' => $request->input('perPage')
        ]);

        $usersResource = UsersResource::collection($users);


        return inertia('System/Users/Index', ['users' => $usersResource]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create() :Response
    {

        return inertia('System/Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UsersRequest $request)
    {

       $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return to_route('users.edit' , $user->id);
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
    public function edit(User $user): Response
    {


        $user->load(['roles' , 'permissions']);
        return inertia('System/Users/Edit' , [
            'user' => new UsersResource($user),
            'roles' => RoleResource::collection(Role::all()),
            'permissions' => PermissionResource::collection(Permission::all()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UsersRequest $request, User $user)
    {
        $user->update(['name' => $request->name]);
        $user->syncRoles($request->input('roles'));
        $user->syncPermissions($request->input('permissions'));

        return to_route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

        $user->delete();

        return back();
    }
}
