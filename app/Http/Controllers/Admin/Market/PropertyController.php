<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\CategoryAttributeRequest;
use App\Models\Market\CategoryAttribute;
use App\Models\Market\ProductCategory;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category_attributes = CategoryAttribute::all();
        return view('admin.market.properties.index', compact('category_attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productCategories = ProductCategory::all();
        return view('admin.market.properties.create', compact('productCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryAttributeRequest $request)
    {
        $inputs = $request->all();
        $attribute = CategoryAttribute::create($inputs);
        return redirect()->route('admin.market.properties.index')->with('swal-success', __('admin.New property has been successfully registered'));
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
    public function edit(CategoryAttribute $categoryAttribute)
    {
        $productCategories = ProductCategory::all();
        return view('admin.market.properties.edit', compact('categoryAttribute', 'productCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryAttributeRequest $request, CategoryAttribute $categoryAttribute)
    {
        $inputs = $request->all();
        $categoryAttribute->update($inputs);
        return redirect()->route('admin.market.properties.index')->with('swal-success', __('admin.The property has been successfully edited'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryAttribute $categoryAttribute)
    {
        $result = $categoryAttribute->delete();
        return redirect()->route('admin.market.properties.index')->with('swal-success', __('admin.The property has been successfully removed'));
    }
}
