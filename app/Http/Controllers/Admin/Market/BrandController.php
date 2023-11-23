<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\BrandRequest;
use App\Models\Market\Brand;
use App\Services\Image\ImageService;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.market.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.market.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('logo')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'brand');
            $result = $imageService->createIndexAndSave($request->file('logo'));
        }
        if ($result === false) {
            return redirect()->route('admin.market.brands.index')->with('swal-error', __('admin.There was an error uploading the image'));
        }
        $inputs['logo'] = $result;
        $brand = Brand::create($inputs);
        return redirect()->route('admin.market.brands.index')->with('swal-success', __('admin.New brand has been successfully registered'));
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
    public function edit(Brand $brand)
    {
        return view('admin.market.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, Brand $brand, ImageService $imageService)
    {
        $inputs = $request->all();

        if ($request->hasFile('logo')) {
            if (!empty($brand->logo)) {
                $imageService->deleteDirectoryAndFiles($brand->logo['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'brand');
            $result = $imageService->createIndexAndSave($request->file('logo'));
            if ($result === false) {
                return redirect()->route('admin.market.brands.index')->with('swal-error', __('admin.There was an error uploading the image'));
            }
            $inputs['logo'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($brand->logo)) {
                $image = $brand->logo;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['logo'] = $image;
            }
        }
        $brand->update($inputs);
        return redirect()->route('admin.market.brands.index')->with('swal-success', __('admin.The brand has been successfully edited'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $result = $brand->delete();
        return redirect()->route('admin.market.brands.index')->with('swal-success', __('admin.The brand has been successfully removed'));
    }
}
