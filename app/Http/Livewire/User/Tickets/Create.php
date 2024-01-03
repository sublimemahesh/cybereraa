<?php

namespace App\Http\Livewire\User\Tickets;

use App\Models\SupportTicket;
use App\Models\SupportTicketCategory;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;

class Create extends Component
{

    use WithFileUploads;

    public bool $edit = false;

    public $attachment;

    public string|null $category;

    public SupportTicket $ticket;

    public Collection $categories;

    protected function rules()
    {
        return [
            'ticket.support_ticket_category_id' => ['required'],
            'ticket.subject' => ['required', 'max:250'],
            'ticket.body' => ['required'],
            'attachment' => ['nullable', 'file', 'mimes:jpeg,bmp,png,gif,svg,pdf'],
        ];
    }

    protected $validationAttributes = [
        'attachment' => "Support Ticket attachments",
    ];

    public function updated()
    {
        $this->validate();
    }

    public function save()
    {
        $this->validate();

        $this->ticket->user()->associate(Auth::user());

        $this->ticket->priority()->associate(2);
        $this->ticket->status()->associate(1);
        if (!empty($this->attachment)) {
            $attachment_name = $this->attachment->getClientOriginalName() . "-" . \Str::random(20) . "-" . Carbon::now()->timestamp . '.' . $this->attachment->extension();
            if (!empty($this->ticket->attachment)) {
                Storage::delete('supports/tickets/' . $this->ticket->attachment);
            }
            $this->attachment->storeAs('supports/tickets', $attachment_name);
            $this->ticket->attachment = $attachment_name;
        }
        $this->ticket->save();
        $this->attachment = null;
        if (!$this->edit) {
            $this->ticket = new SupportTicket;
        }
        session()->flash('message', 'SupportTicket Created Successfully!');
    }

    public function mount(bool|null $edit = null)
    {
        $edit ??= false;
        $this->edit = $edit;
        $this->categories = SupportTicketCategory::all();
        $category = request()->input('category');
        if (!$edit) {
            $this->ticket = new SupportTicket;
            if ($category !== null) {
                $this->category = $category;
                $this->ticket->support_ticket_category_id = $this->categories->where('slug', $category)->first()->id;
                $this->ticket->subject = "Reschedule Plan Request - " . Auth::user()->username;
                $this->ticket->body = "I am writing to request a rescheduling of my investment plan for OnmaxDT";
            }
        }
    }

    public function render()
    {
        return view('livewire.user.tickets.create');
    }
}
