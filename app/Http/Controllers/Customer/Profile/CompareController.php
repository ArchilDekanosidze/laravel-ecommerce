<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;

class CompareController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('customer.profiles.my-compares');
    }
}
