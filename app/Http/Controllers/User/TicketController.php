<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketCategory;
use App\Models\SupportTicketPriority;
use App\Models\SupportTicketStatus;
use Auth;
use Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $tickets = SupportTicket::with(['category', 'priority', 'status'])
            ->where('user_id', $user->id)
            ->filterTickets()
            ->get();

        if ($request->wantsJson()) {

            $tickets = SupportTicket::with(['category', 'priority', 'status'])
                ->where('user_id', $user->id)
                ->filterTickets();


            return DataTables::of($tickets)
                ->addColumn('id', function ($ticket) {
                    return "#" . str_pad($ticket->id, 6, 0, STR_PAD_LEFT);
                })
                ->addColumn('category', function ($ticket) {
                    return '<span style="color:' . $ticket->category->color . '">' . $ticket->category->name . '</span>';
                })
                ->addColumn('priority', function ($ticket) {
                    return '<span style="color:' . $ticket->priority->color . '">' . $ticket->priority->name . '</span>';
                })
                ->addColumn('status', function ($ticket) {
                    return '<span style="color:' . $ticket->status->color . '">' . $ticket->status->name . '</span>';
                })
                ->addColumn('attachment', function ($ticket) {
                    if (!empty($ticket->attachment)) {
                        return '<img src="https://img.icons8.com/fluency/48/000000/pdf-mail.png"  alt=""/>
                            <a href="' . storage("supports/tickets/" . $ticket->attachment) . '" target="blank">
                                View File
                            </a>';
                    }
                    return '';
                })
                ->addColumn('actions', function (SupportTicket $ticket) {
                    return view('backend.user.tickets.components.actions', compact('ticket'));
                })
                ->addColumn('date', function ($ticket) {
                    return Carbon::parse($ticket->created_at)->format('Y-m-d H:i:s');
                })
                ->rawColumns(['actions', 'attachment', 'category', 'priority', 'status'])
                ->make(true);
        }

        $filter_category = SupportTicketCategory::all();
        $filter_priority = SupportTicketPriority::all();
        $filter_status = SupportTicketStatus::all();
        return view('backend.user.tickets.index', compact('filter_category', 'filter_priority', 'filter_status', 'tickets'));
    }

    /**
     * @throws AuthorizationException
     */
    public function create(Request $request)
    {
        $this->authorize('create', SupportTicket::class);

        $category = $request->get('category');
        if ($category === 'reschedule-plan') {
            if (SupportTicket::whereRelation('category', 'slug', $category)->where('user_id', Auth::user()->id)->exists()) {
                return redirect()->route('user.support.tickets.index');
            }
            if (!$request->hasValidSignature()) {
                return redirect()->signedRoute('user.support.tickets.create', ['category' => 'reschedule-plan']);
            }
        }
        return view('backend.user.tickets.create', compact('category'));
    }

    /**
     * @throws AuthorizationException
     */
    public function show(SupportTicket $ticket)
    {
        $this->authorize('view', $ticket);
        $ticket->load('status', 'priority', 'category', 'user');
        return view('backend.user.tickets.show', compact('ticket'));
    }

    public function edit(SupportTicket $ticket)
    {
        $ticket->load('status', 'priority', 'category', 'user');
        return view('backend.user.tickets.edit', compact('ticket'));
    }


    public function destroy(SupportTicket $ticket): \Illuminate\Http\JsonResponse
    {
        if (Auth::user()->cannot('delete', $ticket)) {
            return response()->json(['403', 'message' => 'Forbidden'], ResponseAlias::HTTP_FORBIDDEN);
        }
        $ticket->delete();
        return response()->json(['success']);
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

    public function reopen(SupportTicket $ticket)
    {
        if (Auth::user()->cannot('reopen', $ticket)) {
            return response()->json(['403', 'message' => 'Forbidden'], ResponseAlias::HTTP_FORBIDDEN);
        }
        $ticket->status()->associate(1); // open
        $ticket->save();
        return response()->json(['success']);
    }
}
