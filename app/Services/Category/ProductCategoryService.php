<?php

namespace App\Services\Category;

use Illuminate\Http\Request;
use App\Models\Market\ProductCategory;
use App\Services\Category\Contracts\CategoryInterface;
use App\Services\Uploader\Image\Contracts\ImageServiceInterface;

class ProductCategoryService implements CategoryInterface
{
    private $imageService;
    public function __construct(ImageServiceInterface $imageService)
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
        $result = $this->saveImage($request);
        $inputs['image'] = $result;
        ProductCategory::create($inputs);
        return self::SUCCESS;
    }
    public function getOtherParents($productCategory)
    {
        return ProductCategory::where('parent_id', null)->get()->except($productCategory->id);
    }
    public function update(Request $request, $productCategory)
    {
        $inputs = $request->all();

        $inputs = $this->updateImage($request, $productCategory, $inputs);

        $productCategory->update($inputs);
        return self::SUCCESS;
    }
    public function destroy($productCategory)
    {
        return $productCategory->delete();
    }

    protected function saveImage($request)
    {
        if ($request->hasFile('image')) {
            return $this->saveImageProccess($request);
        }
    }

    protected function updateImage($request, $productCategory, $inputs)
    {
        if ($request->hasFile('image')) {
            if (!empty($productCategory->image)) {
                $this->imageService->deleteFiles($productCategory->image['indexArray']);
            }

            $result = $this->saveImageProccess($request);

            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($productCategory->image)) {
                $image = $productCategory->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }
        return $inputs;
    }
    protected function saveImageProccess($request)
    {
        $this->imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-category');
        return $this->imageService->createIndexAndSave($request->file('image'));
    }
}
