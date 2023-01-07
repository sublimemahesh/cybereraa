<?php

namespace App\Http\Livewire\Admin\Tickets\Status;

use App\Models\SupportTicketStatus;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Create extends Component
{

    public Collection $statuses;

    public function mount()
    {
        $this->statuses = SupportTicketStatus::orderBy('name')->get();
    }


    public function render()
    {
        return view('livewire.admin.tickets.status.create');
    }
}
