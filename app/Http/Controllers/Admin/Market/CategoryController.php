<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Models\Market\ProductCategory;
use App\Services\Category\Contracts\CategoryInterface;
use App\Http\Requests\Admin\Market\ProductCategoryStoreRequest;
use App\Http\Requests\Admin\Market\ProductCategoryUpdateRequest;

class CategoryController extends Controller
{
    private $productCategoryService;
    public function __construct(CategoryInterface $productCategoryService)
    {
        $this->productCategoryService = $productCategoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCategories = $this->productCategoryService->simplePaginate();
        return view('admin.market.categories.index', compact('productCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->productCategoryService->getAllCategories();
        return view('admin.market.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCategoryStoreRequest $request)
    {
        return $this->productCategoryService->store() === $this->productCategoryService::SUCCESS ?
            redirect()->route('admin.market.categories.index')
            ->with('swal-success', __('admin.New category has been successfully registered'))
            : redirect()->route('admin.market.categories.index')
            ->with('swal-error', __('admin.There was an error uploading the image'));
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
    public function edit(ProductCategory $productCategory)
    {
        $parent_categories = $this->productCategoryService->getOtherParents($productCategory);
        return view('admin.market.categories.edit', compact('productCategory', 'parent_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductCategoryUpdateRequest $request, ProductCategory $productCategory)
    {
        return $this->productCategoryService->update($productCategory) === $this->productCategoryService::SUCCESS ?
            redirect()->route('admin.market.categories.index')
            ->with('swal-success', __('admin.The category has been successfully edited'))
            : redirect()->route('admin.market.categories.index')
            ->with('swal-error', __('admin.There was an error uploading the image'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        $this->productCategoryService->destroy($productCategory);
        return redirect()->route('admin.market.categories.index')
            ->with('swal-success', __('admin.The category has been successfully removed'));
    }
}
