<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\CalendarNoteResource;
use App\Models\CalendarNote;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $events = CalendarNoteResource::collection(CalendarNote::where('user_id', \Auth::user()->id)->get());
        return view('backend.user.calendar.events', compact('events'));
    }

    public function addNewEvents(Request $request, string $date)
    {
        $validated = \Validator::make([
            ...$request->all(),
            'date' => $date
        ], [
            'date' => 'required|date|date_format:Y-m-d',
            'title' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after_or_equal:start_time',
            'description' => 'required|string',
        ])->validate();

        $validated['start_time'] = $date . " " . $validated['start_time'];
        $validated['end_time'] = $date . " " . $validated['end_time'];
        unset($validated['date']);

        $event = \DB::transaction(function () use ($validated) {
            $validated['user_id'] = \Auth::user()->id;
            return CalendarNote::create($validated);
        });

        $eventResource = new CalendarNoteResource($event);

        return response()->json([
            'status' => true,
            'message' => 'Success!',
            'icon' => 'success',
            'event' => $eventResource
        ]);
    }

    public function getEvents(Request $request, string $date)
    {
        $validated = \Validator::make(compact('date'), [
            'date' => 'required|date|date_format:Y-m-d',
        ])->validate();
        $events = CalendarNote::where('user_id', \Auth::user()->id)
            ->whereDate('start_time', '>=', $date)
            ->whereDate('end_time', '<=', $date)
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Success!',
            'icon' => 'success',
            'html' => view('backend.user.calendar.components.note-card', compact('events'))->render()
        ]);
    }
}
