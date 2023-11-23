<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\AdminUserRequest;
use App\Models\User;
use App\Models\User\Permission;
use App\Models\User\Role;
use App\Services\Image\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::where('user_type', 1)->get();
        return view('admin.user.admin-users.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.admin-users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminUserRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('profile_photo_path')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'users');
            $result = $imageService->save($request->file('profile_photo_path'));

            if ($result === false) {
                return redirect()->route('admin.user.admin-users.index')->with('swal-error', __('admin.There was an error uploading the image'));
            }
            $inputs['profile_photo_path'] = $result;
        }
        $inputs['password'] = Hash::make($request->password);
        $inputs['user_type'] = 1;
        $user = User::create($inputs);
        return redirect()->route('admin.user.admin-users.index')->with('swal-success', __('admin.New admin has been successfully registered'));
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
    public function edit(User $admin)
    {
        return view('admin.user.admin-users.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminUserRequest $request, User $admin, ImageService $imageService)
    {
        $inputs = $request->all();

        if ($request->hasFile('profile_photo_path')) {
            if (!empty($admin->profile_photo_path)) {
                $imageService->deleteImage($admin->profile_photo_path);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'users');
            $result = $imageService->save($request->file('profile_photo_path'));
            if ($result === false) {
                return redirect()->route('admin.user.admin-users.index')->with('swal-error', __('admin.There was an error uploading the image'));
            }
            $inputs['profile_photo_path'] = $result;
        }
        $admin->update($inputs);
        return redirect()->route('admin.user.admin-users.index')->with('swal-success', __('admin.The admin has been successfully edited'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        $result = $admin->forceDelete();
        return redirect()->route('admin.user.admin-users.index')->with('swal-success', __('admin.The admin has been successfully removed'));
    }

    public function status(User $user)
    {

        $user->status = $user->status == 0 ? 1 : 0;
        $result = $user->save();
        if ($result) {
            if ($user->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }

    }

    public function activation(User $user)
    {
        $user->activation = $user->activation == 0 ? 1 : 0;
        $result = $user->save();
        if ($result) {
            if ($user->activation == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }

    }

    public function roles(User $admin)
    {
        $roles = Role::all();
        return view('admin.user.admin-users.roles', compact('admin', 'roles'));

    }

    public function rolesStore(Request $request, User $admin)
    {
        $validated = $request->validate([
            'roles' => 'required|exists:roles,id|array',
        ]);

        $admin->roles()->sync($request->roles);
        return redirect()->route('admin.user.admin-users.index')->with('swal-success', __('admin.The role has been successfully edited'));

    }

    public function permissions(User $admin)
    {
        $permissions = Permission::all();

        return view('admin.user.admin-users.permissions', compact('admin', 'permissions'));

    }

    public function permissionsStore(Request $request, User $admin)
    {
        $validated = $request->validate([
            'permissions' => 'required|exists:permissions,id|array',
        ]);

        $admin->permissions()->sync($request->permissions);
        return redirect()->route('admin.user.admin-users.index')->with('swal-success', __('admin.The permission has been successfully edited'));

    }
}
