<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Profile\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('customer.profiles.profile');
    }

    public function update(UpdateProfileRequest $request)
    {
        $inputs = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,
        ];
        $user = auth()->user();
        $user->update($inputs);
        return redirect()->route('customer.profiles.profile')->with('success', __('public.Profile edited successfully'));
    }
}
