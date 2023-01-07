<?php

namespace App\Http\Livewire\User\Tickets;

use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use Auth;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;

class Reply extends Component
{
    use WithFileUploads;

    public SupportTicket $ticket;

    public $user_role;

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

        $this->reply->ticket()->associate($this->ticket);
        if ($this->user_role === 'admin' || $this->user_role === 'super_admin') {
            $this->reply->admin()->associate(Auth::user());
            $this->ticket->status()->associate(2); // hold
        } else {
            $this->reply->user()->associate(Auth::user());
            $this->ticket->status()->associate(1); // open
        }
        $this->ticket->save();
        if (!empty($this->attachment)) {
            $attachment_name = $this->attachment->getClientOriginalName() . "-" . \Str::random(20) . "-" . Carbon::now()->timestamp . '.' . $this->attachment->extension();
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
        $this->user_role = Auth::user()->getRoleNames()->first();
        $this->reply = new SupportTicketReply;
        $this->ticket->load('replies.user');
    }

    public function render()
    {
        return view('livewire.user.tickets.reply');
    }
}
