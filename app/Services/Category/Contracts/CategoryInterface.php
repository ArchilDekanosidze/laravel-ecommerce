<?php

namespace App\Services\Category\Contracts;

use Illuminate\Http\Request;
use App\Models\Market\ProductCategory;
use App\Services\Uploader\Image\Contracts\ImageServiceInterface;

interface CategoryInterface
{
    const UPLOAD_IMAGE_FAILED = 'upload.image.failed';
    const SUCCESS = 'success';

    public function __construct(ImageServiceInterface $imageService, Request $request);
    public function simplePaginate();
    public function getAllCategories();
    public function store();
    public function getOtherParents($category);
    public function update($category);
    public function destroy($category);
}
