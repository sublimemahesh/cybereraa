<?php

namespace App\Http\Livewire\Admin\Tickets\Category;

use App\Models\SupportTicketCategory;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    use AuthorizesRequests;

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
        if (Auth::user()->cannot('support_ticket.category.delete', $this->category)) {
            return;
        }
        // $this->validate();
        $this->emitSelf('showConfirmation', $category);
    }

    /**
     * @throws AuthorizationException
     */
    public function save()
    {
        $this->validate();
        $this->authorize('support_ticket.category.create');
        $this->category->save();
        $this->categories = SupportTicketCategory::orderBy('name')->get();
        $this->category = new SupportTicketCategory;
        session()->flash('message', 'Category has been created successfully!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($category)
    {
        $this->authorize('support_ticket.category.delete');
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
