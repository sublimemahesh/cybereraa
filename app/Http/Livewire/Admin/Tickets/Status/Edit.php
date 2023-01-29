<?php

namespace App\Http\Livewire\Admin\Tickets\Status;

use App\Models\SupportTicketStatus;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    use AuthorizesRequests;

    public SupportTicketStatus $status;

    protected function rules()
    {
        return [
            'status.name' => [
                'required',
                Rule::unique('support_ticket_statuses', 'name')->ignoreModel($this->status, 'id')
            ],
            'status.color' => ['required',],
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
        $this->authorize('support_ticket.status.update');
        $this->status->save();
        session()->flash('message', 'Status has been updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin.tickets.status.edit');
    }
}
