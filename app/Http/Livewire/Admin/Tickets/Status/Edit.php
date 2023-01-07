<?php

namespace App\Http\Livewire\Admin\Tickets\Status;

use App\Models\SupportTicketStatus;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
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

    public function save()
    {
        $this->validate();
        $this->status->save();
        session()->flash('message', 'Status has been updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin.tickets.status.edit');
    }
}
