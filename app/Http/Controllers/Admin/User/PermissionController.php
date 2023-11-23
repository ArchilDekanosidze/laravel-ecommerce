<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\PermissionRequest;
use App\Models\User\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.user.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
        $inputs = $request->all();
        $permission = Permission::create($inputs);
        return redirect()->route('admin.user.permissions.index')->with('swal-success', __('admin.New permission has been successfully registered'));
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
    public function edit(Permission $permission)
    {
        return view('admin.user.permissions.edit', compact('permission'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        $inputs = $request->all();
        $permission->update($inputs);
        return redirect()->route('admin.user.permissions.index')->with('swal-success', __('admin.The permission has been successfully edited'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $result = $permission->delete();
        return redirect()->route('admin.user.permissions.index')->with('swal-success', __('admin.The permission has been successfully removed'));
    }
}
