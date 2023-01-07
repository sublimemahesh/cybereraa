<?php

namespace App\Http\Livewire\Admin\Tickets\Priority;

use App\Models\SupportTicketPriority;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Create extends Component
{

    public Collection $priorities;

    public function mount()
    {
        $this->priorities = SupportTicketPriority::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.admin.tickets.priority.create');
    }
}
