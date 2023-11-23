<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\TicketPriorityRequest;
use App\Models\Ticket\TicketPriority;

class TicketPriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ticketPriorities = TicketPriority::all();
        return view('admin.tickets.priorities.index', compact('ticketPriorities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tickets.priorities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketPriorityRequest $request)
    {
        $inputs = $request->all();
        $ticketPriority = TicketPriority::create($inputs);
        return redirect()->route('admin.ticket.priorities.index')->with('swal-success', __('admin.New priority has been successfully registered'));
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
    public function edit(TicketPriority $ticketPriority)
    {
        return view('admin.tickets.priorities.edit', compact('ticketPriority'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketPriorityRequest $request, TicketPriority $ticketPriority)
    {
        $inputs = $request->all();
        $ticketPriority->update($inputs);
        return redirect()->route('admin.ticket.priorities.index')->with('swal-success', __('admin.The priority has been successfully edited'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketPriority $ticketPriority)
    {
        $result = $ticketPriority->delete();
        return redirect()->route('admin.ticket.priorities.index')->with('swal-success', __('admin.The priority has been successfully removed'));
    }

    public function status(TicketPriority $ticketPriority)
    {

        $ticketPriority->status = $ticketPriority->status == 0 ? 1 : 0;
        $result = $ticketPriority->save();
        if ($result) {
            if ($ticketPriority->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }

    }
}
