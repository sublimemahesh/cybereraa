<?php

namespace App\Http\Livewire\Admin\Tickets\Priority;

use App\Models\SupportTicketPriority;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    use AuthorizesRequests;

    public SupportTicketPriority $priority;

    protected function rules()
    {
        return [
            'priority.name' => [
                'required',
                Rule::unique('support_ticket_priorities', 'name')->ignoreModel($this->priority, 'id')
            ],
            'priority.color' => ['required',],
        ];
    }

    public function updated()
    {
        $this->validate();
    }

    /**
     * @throws AuthorizationException
     */
    public function save()
    {
        $this->validate();
        $this->authorize('support_ticket.priority.update');
        $this->priority->save();
        session()->flash('message', 'Priority has been updated successfully!');
    }


    public function render()
    {
        return view('livewire.admin.tickets.priority.edit');
    }
}
