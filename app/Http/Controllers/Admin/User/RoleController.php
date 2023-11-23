<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\RoleRequest;
use App\Models\User\Permission;
use App\Models\User\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.user.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.user.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $inputs = $request->all();
        $role = Role::create($inputs);
        $inputs['permissions'] = $inputs['permissions'] ?? [];
        $role->permissions()->sync($inputs['permissions']);
        return redirect()->route('admin.user.roles.index')->with('swal-success', __('admin.New role has been successfully registered'));
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
    public function edit(Role $role)
    {
        return view('admin.user.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $inputs = $request->all();
        $role->update($inputs);
        return redirect()->route('admin.user.roles.index')->with('swal-success', __('admin.The role has been successfully edited'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $result = $role->delete();
        return redirect()->route('admin.user.roles.index')->with('swal-success', __('admin.The role has been successfully removed'));
    }

    public function permissionForm(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.user.roles.set-permission', compact('role', 'permissions'));

    }

    public function permissionUpdate(RoleRequest $request, Role $role)
    {
        $inputs = $request->all();
        $inputs['permissions'] = $inputs['permissions'] ?? [];
        $role->permissions()->sync($inputs['permissions']);
        return redirect()->route('admin.user.roles.index')->with('swal-success', __('admin.The role has been successfully edited'));

    }
}
