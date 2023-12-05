<?php

namespace App\Services\Category;

use Illuminate\Http\Request;
use App\Services\Image\ImageService;
use App\Models\Market\ProductCategory;
use App\Services\Category\Contracts\CategoryInterface;
use App\Http\Requests\Admin\Market\ProductCategoryRequest;

class ProductCategoryService implements CategoryInterface
{
    private $imageService;
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function simplePaginate()
    {
        return ProductCategory::orderBy('created_at', 'desc')->simplePaginate(15);
    }
    public function getAllCategories()
    {
        return ProductCategory::all();
    }
    public function store(Request $request)
    {
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $this->imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-category');
            $result = $this->imageService->createIndexAndSave($request->file('image'));
        }
        if ($result === false) {
            return self::UPLOAD_IMAGE_FAILED;
        }
        $inputs['image'] = $result;
        $productCategory = ProductCategory::create($inputs);
        return self::SUCCESS;
    }
    public function getOtherParents($productCategory)
    {
        return ProductCategory::where('parent_id', null)->get()->except($productCategory->id);
    }
    public function update(Request $request, $productCategory)
    {
        $inputs = $request->all();

        if ($request->hasFile('image')) {
            if (!empty($productCategory->image)) {
                $this->imageService->deleteDirectoryAndFiles($productCategory->image['directory']);
            }
            $this->imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-category');
            $result = $this->imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return self::UPLOAD_IMAGE_FAILED;;
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($productCategory->image)) {
                $image = $productCategory->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }
        $productCategory->update($inputs);
        return self::SUCCESS;
    }
    public function destroy($productCategory)
    {
        return $productCategory->delete();
    }
}
