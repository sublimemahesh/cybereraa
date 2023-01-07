<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketCategory;
use App\Models\SupportTicketPriority;
use App\Models\SupportTicketStatus;
use Auth;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    /**
     * @throws AuthorizationException
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', SupportTicket::class);


        if ($request->wantsJson()) {

            $tickets = SupportTicket::with(['user', 'category', 'priority', 'status'])
                ->filterTickets()
                ->latest();

            return DataTables::of($tickets)
                ->addColumn('id', static function ($ticket) {
                    return "#" . str_pad($ticket->id, 6, 0, STR_PAD_LEFT);
                })
                ->addColumn('category', static function ($ticket) {
                    return '<span style="color:' . $ticket->category->color . '">' . $ticket->category->name . '</span>';
                })
                ->addColumn('priority', static function ($ticket) {
                    return '<span style="color:' . $ticket->priority->color . '">' . $ticket->priority->name . '</span>';
                })
                ->addColumn('status', static function ($ticket) {
                    return '<span style="color:' . $ticket->status->color . '">' . $ticket->status->name . '</span>';
                })->addColumn('subject', static function ($ticket) {
                    return '<span class="text-wrap">' . $ticket->subject . '</span>';
                })
                ->addColumn('attachment', static function ($ticket) {
                    if (!empty($ticket->attachment)) {
                        return '<img src="https://img.icons8.com/fluency/48/000000/pdf-mail.png"  alt=""/> 
                            <a href="' . storage("supports/tickets/" . $ticket->attachment) . '" target="blank">
                                View File
                            </a>';
                    }
                    return '';
                })
                ->addColumn('actions', static function (SupportTicket $ticket) {
                    return view('backend.admin.tickets.components.actions', compact('ticket'));
                })
                ->rawColumns(['actions', 'subject', 'attachment', 'category', 'priority', 'status'])
                ->make(true);
        }

        $filter_category = SupportTicketCategory::all();
        $filter_priority = SupportTicketPriority::all();
        $filter_status = SupportTicketStatus::all();
        return view('backend.admin.tickets.index', compact('filter_category', 'filter_priority', 'filter_status'));
    }

    /**
     * @throws AuthorizationException
     */
    public function show(SupportTicket $ticket)
    {
        $this->authorize('view', $ticket);
        $ticket->load('status', 'priority', 'category', 'user');
        return view('backend.admin.tickets.show', compact('ticket'));
    }

    public function close(SupportTicket $ticket): \Illuminate\Http\JsonResponse
    {
        if (Auth::user()->cannot('close', $ticket)) {
            return response()->json(['403', 'message' => 'Forbidden'], ResponseAlias::HTTP_FORBIDDEN);
        }
        $ticket->status()->associate(3); // closed
        $ticket->save();
        return response()->json(['success']);
    }

    public function reopen(SupportTicket $ticket): \Illuminate\Http\JsonResponse
    {
        if (Auth::user()->cannot('reopen', $ticket)) {
            return response()->json(['403', 'message' => 'Forbidden'], ResponseAlias::HTTP_FORBIDDEN);
        }
        $ticket->status()->associate(1); // open
        $ticket->save();
        return response()->json(['success']);
    }

    public function priority(SupportTicket $ticket, $priority): \Illuminate\Http\JsonResponse
    {
        if (Auth::user()->cannot($priority . 'Priority', $ticket)) {
            return response()->json(['403', 'message' => 'Forbidden'], ResponseAlias::HTTP_FORBIDDEN);
        }
        switch ($priority) {
            case 'low':
                $ticket->priority()->associate(1); // lowPriority
                break;
            case 'medium':
                $ticket->priority()->associate(2); // mediumPriority
                break;
            case 'high':
                $ticket->priority()->associate(3); // highPriority
                break;
            default:
                break;
        }
        $ticket->save();
        return response()->json(['message' => 'success']);
    }
}
