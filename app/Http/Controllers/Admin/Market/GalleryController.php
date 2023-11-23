<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Models\Market\Gallery;
use App\Models\Market\Product;
use App\Services\Image\ImageService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        return view('admin.market.products.galleries.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        return view('admin.market.products.galleries.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product, ImageService $imageService)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg,gif',
        ]);
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-gallery');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.market.products.galleries.index', $product->id)->with('swal-error', __('admin.There was an error uploading the image'));
            }
            $inputs['image'] = $result;
            $inputs['product_id'] = $product->id;
            $gallery = Gallery::create($inputs);
            return redirect()->route('admin.market.products.galleries.index', $product->id)->with('swal-success', __('admin.New image has been successfully registered'));
        }
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Gallery $gallery)
    {
        $result = $gallery->delete();
        return redirect()->route('admin.market.products.galleries.index', $product->id)->with('swal-success', __('admin.The image has been successfully removed'));
    }
}
