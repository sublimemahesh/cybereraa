<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicketCategory;
use App\Models\SupportTicketPriority;
use App\Models\SupportTicketStatus;

class TicketOptionsController extends Controller
{
    public function category()
    {
        return view('backend.admin.tickets.category.index');
    }

    public function categoryEdit(SupportTicketCategory $category)
    {
        return view('backend.admin.tickets.category.edit', compact('category'));
    }

    public function priority()
    {
        return view('backend.admin.tickets.priority.index');
    }

    public function priorityEdit(SupportTicketPriority $priority)
    {
        return view('backend.admin.tickets.priority.edit', compact('priority'));
    }

    public function status()
    {
        return view('backend.admin.tickets.status.index');
    }

    public function statusEdit(SupportTicketStatus $status)
    {
        return view('backend.admin.tickets.status.edit', compact('status'));
    }
}
