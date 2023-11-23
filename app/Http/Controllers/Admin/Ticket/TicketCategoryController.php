<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\TicketCategoryRequest;
use App\Models\Ticket\TicketCategory;

class TicketCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ticketCategories = TicketCategory::all();
        return view('admin.tickets.categories.index', compact('ticketCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tickets.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketCategoryRequest $request)
    {
        $inputs = $request->all();
        $ticketCategory = TicketCategory::create($inputs);
        return redirect()->route('admin.ticket.categories.index')->with('swal-success', __('admin.New category has been successfully registered'));
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
    public function edit(TicketCategory $ticketCategory)
    {
        return view('admin.tickets.categories.edit', compact('ticketCategory'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketCategoryRequest $request, TicketCategory $ticketCategory)
    {
        $inputs = $request->all();
        $ticketCategory->update($inputs);
        return redirect()->route('admin.ticket.categories.index')->with('swal-success', __('admin.The category has been successfully edited'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketCategory $ticketCategory)
    {
        $result = $ticketCategory->delete();
        return redirect()->route('admin.ticket.categories.index')->with('swal-success', __('admin.The category has been successfully removed'));
    }

    public function status(TicketCategory $ticketCategory)
    {

        $ticketCategory->status = $ticketCategory->status == 0 ? 1 : 0;
        $result = $ticketCategory->save();
        if ($result) {
            if ($ticketCategory->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }

    }
}
