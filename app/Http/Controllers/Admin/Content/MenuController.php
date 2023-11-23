<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\MenuRequest;
use App\Models\Content\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::orderBy('created_at', 'desc')->simplePaginate(15);
        // dd($menus[0]->children, $menus[1]->parent->parent);
        return view('admin.content.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = Menu::where('parent_id', null)->get();
        return view('admin.content.menus.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuRequest $request)
    {
        $inputs = $request->all();
        $menu = Menu::create($inputs);
        return redirect()->route('admin.content.menus.index')->with('swal-success', __('admin.New menu has been successfully registered'));
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
    public function edit(Menu $menu)
    {
        $parent_menus = Menu::where('parent_id', null)->get()->except($menu->id);
        return view('admin.content.menus.edit', compact('menu', 'parent_menus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        $inputs = $request->all();
        $menu->update($inputs);
        return redirect()->route('admin.content.menus.index')->with('swal-success', __('admin.The menu has been successfully edited'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $result = $menu->delete();
        return redirect()->route('admin.content.menus.index')->with('swal-success', __('admin.The menu has been successfully removed'));
    }

    public function status(Menu $menu)
    {

        $menu->status = $menu->status == 0 ? 1 : 0;
        $result = $menu->save();
        if ($result) {
            if ($menu->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }

    }
}
