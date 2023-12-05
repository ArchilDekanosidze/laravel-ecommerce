<?php

namespace App\Services\Category\Contracts;

use Illuminate\Http\Request;
use App\Models\Market\ProductCategory;

interface CategoryInterface
{
    const UPLOAD_IMAGE_FAILED = 'upload.image.failed';
    const SUCCESS = 'success';

    public function simplePaginate();
    public function getAllCategories();
    public function store(Request $request);
    public function getOtherParents($category);
    public function update(Request $request, $category);
    public function destroy($category);
}
