<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketPriority extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'status'];
}