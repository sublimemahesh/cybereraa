<?php

namespace App\Http\Livewire\Admin\Tickets\Category;

use App\Models\SupportTicketCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    public SupportTicketCategory $category;

    public Collection $categories;

    protected function rules()
    {
        return [
            'category.name' => [
                'required',
                Rule::unique('support_ticket_categories', 'name')
            ],
            'category.color' => ['required',],
        ];
    }

    public function updated()
    {
        $this->validate();
    }

    public function confirmRequest($category)
    {
        // if (Auth::user()->cannot('destroy', $this->category)) return;
        // $this->validate();
        $this->emitSelf('showConfirmation', $category);
    }

    public function save()
    {
        $this->validate();
        $this->category->save();
        $this->categories = SupportTicketCategory::orderBy('name')->get();
        $this->category = new SupportTicketCategory;
        session()->flash('message', 'Category has been created successfully!');
    }

    public function destroy($category)
    {
        SupportTicketCategory::find($category)->delete();
        $this->categories = SupportTicketCategory::orderBy('name')->get();
    }

    public function mount()
    {
        $this->category = new SupportTicketCategory;
        $this->categories = SupportTicketCategory::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.admin.tickets.category.create');
    }
}
