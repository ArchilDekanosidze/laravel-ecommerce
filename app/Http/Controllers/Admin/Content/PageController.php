<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PageRequest;
use App\Models\Content\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.content.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.content.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageRequest $request)
    {
        $inputs = $request->all();
        $page = Page::create($inputs);
        return redirect()->route('admin.content.pages.index')->with('swal-success', __('admin.New page has been successfully registered'));
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
    public function edit(Page $page)
    {
        return view('admin.content.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageRequest $request, Page $page)
    {
        $inputs = $request->all();
        // $inputs['slug'] = null;
        $page->update($inputs);
        return redirect()->route('admin.content.pages.index')->with('swal-success', __('admin.The page has been successfully edited'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $result = $page->delete();
        return redirect()->route('admin.content.pages.index')->with('swal-success', __('admin.The page has been successfully removed'));
    }

    public function status(Page $page)
    {

        $page->status = $page->status == 0 ? 1 : 0;
        $result = $page->save();
        if ($result) {
            if ($page->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }

    }
}
