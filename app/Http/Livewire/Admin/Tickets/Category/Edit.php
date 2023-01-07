<?php

namespace App\Http\Livewire\Admin\Tickets\Category;

use App\Models\SupportTicketCategory;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public SupportTicketCategory $category;

    protected function rules()
    {
        return [
            'category.name' => [
                'required',
                Rule::unique('support_ticket_categories', 'name')->ignore($this->category->id, 'id')
            ],
            'category.color' => ['required',],
        ];
    }

    public function updated()
    {
        $this->validate();
    }

    public function save()
    {
        $this->validate();
        $this->category->save();
        session()->flash('message', 'Category has been updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin.tickets.category.edit');
    }
}
