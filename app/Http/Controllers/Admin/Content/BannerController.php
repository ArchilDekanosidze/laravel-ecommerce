<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\BannerRequest;
use App\Models\Content\Banner;
use App\Services\Image\ImageService;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('created_at', 'desc')->simplePaginate(15);
        $positions = Banner::$positions;
        return view('admin.content.banners.index', compact('banners', 'positions'));
    }

    public function create()
    {
        $positions = Banner::$positions;
        return view('admin.content.banners.create', compact('positions'));
    }

    public function store(BannerRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();

        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'banner');
            $result = $imageService->save($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.content.banners.index')->with('swal-error', __('admin.There was an error uploading the image'));
            }
            $inputs['image'] = $result;
        }
        $banner = Banner::create($inputs);
        return redirect()->route('admin.content.banners.index')->with('swal-success', __('admin.New banner has been successfully registered'));
    }

    public function show($id)
    {
        //
    }

    public function edit(Banner $banner)
    {
        $positions = Banner::$positions;
        return view('admin.content.banners.edit', compact('banner', 'positions'));

    }

    public function update(BannerRequest $request, Banner $banner, ImageService $imageService)
    {

        $inputs = $request->all();

        if ($request->hasFile('image')) {
            if (!empty($banner->image)) {
                $imageService->deleteImage($banner->image);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'banner');
            $result = $imageService->save($request->file('image'));

            if ($result === false) {
                return redirect()->route('admin.content.banners.index')->with('swal-error', __('admin.There was an error uploading the image'));
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($banner->image)) {
                $image = $banner->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }
        $banner->update($inputs);
        return redirect()->route('admin.content.banners.index')->with('swal-success', __('admin.The banner has been successfully edited'));
    }

    public function destroy(Banner $banner)
    {
        $result = $banner->delete();
        return redirect()->route('admin.content.banners.index')->with('swal-success', __('admin.The banner has been successfully removed'));
    }

    public function status(Banner $banner)
    {
        $banner->status = $banner->status == 0 ? 1 : 0;
        $result = $banner->save();
        if ($result) {
            if ($banner->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
