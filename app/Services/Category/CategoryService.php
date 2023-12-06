<?php

namespace App\Services\Category;

use Illuminate\Http\Request;
use App\Models\Market\ProductCategory;
use App\Services\Category\Contracts\CategoryInterface;
use App\Services\Uploader\Image\Contracts\ImageServiceInterface;

class CategoryService implements CategoryInterface
{
    private $imageService;
    private $request;
    public function __construct(ImageServiceInterface $imageService, Request $request)
    {
        $this->imageService = $imageService;
        $this->request = $request;
    }
    public function simplePaginate()
    {
        return ProductCategory::orderBy('created_at', 'desc')->simplePaginate(15);
    }
    public function getAllCategories()
    {
        return ProductCategory::all();
    }
    public function store()
    {
        $inputs = $this->request->all();
        $result = $this->saveImage();
        $inputs['image'] = $result;
        ProductCategory::create($inputs);
        return self::SUCCESS;
    }
    public function getOtherParents($productCategory)
    {
        return ProductCategory::where('parent_id', null)->get()->except($productCategory->id);
    }
    public function update($productCategory)
    {
        $inputs = $this->request->all();

        $inputs = $this->updateImage($productCategory, $inputs);

        $productCategory->update($inputs);
        return self::SUCCESS;
    }
    public function destroy($productCategory)
    {
        return $productCategory->delete();
    }

    protected function saveImage()
    {
        if ($this->request->hasFile('image')) {
            return $this->saveImageProccess();
        }
    }

    protected function updateImage($productCategory, $inputs)
    {
        if ($this->request->hasFile('image')) {
            if (!empty($productCategory->image)) {
                $this->imageService->deleteFiles($productCategory->image['indexArray']);
            }

            $result = $this->saveImageProccess();

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
    protected function saveImageProccess()
    {
        $this->imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-category');
        return $this->imageService->createIndexAndSave($this->request->file('image'));
    }
}
