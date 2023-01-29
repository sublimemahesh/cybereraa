<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicketCategory;
use App\Models\SupportTicketPriority;
use App\Models\SupportTicketStatus;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class TicketOptionsController extends Controller
{
    public function category()
    {
        abort_if(Gate::denies('support_ticket.category.viewAny'), Response::HTTP_FORBIDDEN);

        return view('backend.admin.tickets.category.index');
    }

    public function categoryEdit(SupportTicketCategory $category)
    {
        abort_if(Gate::denies('support_ticket.category.update'), Response::HTTP_FORBIDDEN);

        return view('backend.admin.tickets.category.edit', compact('category'));
    }

    public function priority()
    {
        abort_if(Gate::denies('support_ticket.priority.viewAny'), Response::HTTP_FORBIDDEN);

        return view('backend.admin.tickets.priority.index');
    }

    public function priorityEdit(SupportTicketPriority $priority)
    {
        abort_if(Gate::denies('support_ticket.priority.update'), Response::HTTP_FORBIDDEN);

        return view('backend.admin.tickets.priority.edit', compact('priority'));
    }

    public function status()
    {
        abort_if(Gate::denies('support_ticket.status.viewAny'), Response::HTTP_FORBIDDEN);
        return view('backend.admin.tickets.status.index');
    }

    public function statusEdit(SupportTicketStatus $status)
    {
        abort_if(Gate::denies('support_ticket.status.update'), Response::HTTP_FORBIDDEN);
        return view('backend.admin.tickets.status.edit', compact('status'));
    }
}
