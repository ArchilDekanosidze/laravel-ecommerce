<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Ticket\TicketAdmin;
use App\Models\User;

class TicketAdminController extends Controller
{
    public function index()
    {
        $admins = User::where('user_type', 1)->get();
        return view('admin.tickets.admins.index', compact('admins'));
    }

    public function set(User $admin)
    {
        TicketAdmin::where('user_id', $admin->id)->first() ? TicketAdmin::where(['user_id' => $admin->id])->forceDelete() : TicketAdmin::create(['user_id' => $admin->id]);
        return redirect()->route('admin.tickets.admins.index')->with('swal-success', __('admin.Your change was successful'));
    }
}
