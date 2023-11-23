<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PostCategoryRequest;
use App\Models\Content\PostCategory;
use App\Services\Image\ImageService;

class CategoryController extends Controller
{

    public function index()
    {
        $postCategories = PostCategory::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.content.categories.index', compact('postCategories'));
    }
    public function create()
    {
        // $imageCache = new ImageCacheService();
        // return $imageCache->cache('1.png');
        return view('admin.content.categories.create');
    }
    public function store(PostCategoryRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();

        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post-category');
            // $result = $imageService->save($request->file('image'));
            // $result = $imageService->fitAndSave($request->file('image'), 600, 150);
            // exit;
            $result = $imageService->createIndexAndSave($request->file('image'));
        }
        if ($result === false) {
            return redirect()->route('admin.content.categories.index')->with('swal-error', __('admin.There was an error uploading the image'));
        }
        $inputs['image'] = $result;
        $postCategory = PostCategory::create($inputs);
        return redirect()->route('admin.content.categories.index')->with('swal-success', __('admin.New Category has been successfully registered'));
    }
    public function show(PostCategory $postCategory)
    {
        //
    }
    public function edit(PostCategory $postCategory)
    {
        return view('admin.content.categories.edit', compact('postCategory'));
    }
    public function update(PostCategoryRequest $request, PostCategory $postCategory, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            if (!empty($postCategory->image)) {
                $imageService->deleteDirectoryAndFiles($postCategory->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post-category');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.content.category.index')->with('swal-error', __('admin.There was an error uploading the image'));
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($postCategory->image)) {
                $image = $postCategory->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }
        $postCategory->update($inputs);
        return redirect()->route('admin.content.categories.index')->with('swal-success', __('admin.The Category has been successfully edited'));
    }
    public function destroy(PostCategory $postCategory)
    {
        $result = $postCategory->delete();
        return redirect()->route('admin.content.categories.index')->with('swal-success', __('admin.The Category has been successfully edited'));
    }

    public function status(PostCategory $postCategory)
    {
        $postCategory->status = 1 - $postCategory->status;
        $result = $postCategory->save();
        if ($result) {
            if ($postCategory->status == 0) {
                return response()->json(['status' => 'true', 'checked' => false]);
            } else {
                return response()->json(['status' => 'true', 'checked' => true]);
            }
        } else {
            return response()->json(['status' => 'false']);
        }
    }
}
