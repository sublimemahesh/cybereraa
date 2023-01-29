<?php

namespace App\Http\Livewire\User\Tickets;

use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;
use Str;

class Reply extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public SupportTicket $ticket;

    public SupportTicketReply $reply;

    public $attachment;

    protected function rules()
    {
        return [
            'reply.reply' => ['required'],
            'attachment' => ['nullable', 'file', 'mimes:jpeg,bmp,png,gif,svg,pdf'],
        ];
    }

    public function reply()
    {
        $this->validate();
        $this->authorize('reply', $this->ticket);
        $this->reply->ticket()->associate($this->ticket);
        if (Auth::user()->hasRole('user')) {
            $this->reply->user()->associate(Auth::user()); // $this->ticket->user_id
            $this->ticket->status()->associate(1); // open
        } else {
            $this->reply->admin()->associate(Auth::user());
            $this->ticket->status()->associate(2); // hold
        }
        $this->ticket->save();
        if (!empty($this->attachment)) {
            $attachment_name = Str::limit($this->attachment->getClientOriginalName()) . "-" . $this->attachment->hashName() . "-" . Carbon::now()->timestamp . '.' . $this->attachment->extension();
            if (!empty($this->reply->attachment)) {
                Storage::delete('supports/tickets/reply/' . $this->reply->attachment);
            }
            $this->attachment->storeAs('supports/tickets/reply', $attachment_name);
            $this->reply->attachment = $attachment_name;
        }
        $this->reply->save();
        $this->ticket->load('replies.user');
        $this->reply = new SupportTicketReply;
        $this->attachment = null;
    }

    public function mount()
    {
        $this->reply = new SupportTicketReply;
        $this->ticket->load('replies.user');
    }

    public function render()
    {
        return view('livewire.user.tickets.reply');
    }
}
