<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Models\Market\Product;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('customer.profiles.my-favorites');
    }

    public function delete(Product $product)
    {
        $user = auth()->user();
        $user->products()->detach($product->id);
        return redirect()->route('customer.profiles.my-favorites')->with('success', __('public.The product has been successfully removed from favorites'));
    }
}
