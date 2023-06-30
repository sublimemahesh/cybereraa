<?php

namespace App\Http\Livewire\Admin\Popups;

use App\Models\PopupNotice;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Str;

class Save extends Component
{
    use AuthorizesRequests;

    public PopupNotice $popup;

    public string|null $image = null;

    protected function rules()
    {
        return [
            'popup.title' => 'required|max:250',
            // 'image' => [Rule::requiredIf($this->popup->image_name === null), 'nullable', 'base64image'],
            'popup.is_active' => 'nullable|boolean',
            'popup.start_date' => 'required|date|after_or_equal:today',
            'popup.end_date' => 'required|date|after_or_equal:popup.start_date',
            'popup.content' => 'required',
        ];
    }

    public $image_config = [
        'image_ratio_crop' => 'C',
        'image_resize' => true,
        'image_ratio_y' => true,
        'image_x' => 1980,
    ];

    public function mount(PopupNotice $popup)
    {
        $this->popup = $popup;
        $this->popup->start_date = $this->popup->start_date ? \Carbon::parse($this->popup->start_date)->format('Y-m-d') : null;
        $this->popup->end_date = $this->popup->end_date ? \Carbon::parse($this->popup->end_date)->format('Y-m-d') : null;
    }

    public function updated($name)
    {
        $this->validateOnly($name);
    }

    /**
     * @throws AuthorizationException
     */
    public function save()
    {
        $this->validate();
        if ($this->popup->id === null) {
            $this->authorize('create', $this->popup);
        } else {
            $this->authorize('update', $this->popup);
        }
        //  save
        if (!empty($this->image)) {
            $imageName = $this->popup->image_name ?: Str::limit(Str::random(30));
            $imageName = store($this->image, 'popups', $imageName, $this->image_config, ['update' => $this->popup->image_name !== null]);
            $this->popup->image_name = $imageName;
        }

        $this->popup->save();

        session()->flash('message', 'Popup created successfully!');
        //  cleanup
        return redirect()->route('admin.popup-notices.index');
    }

    public function render()
    {
        return view('livewire.admin.popups.save');
    }
}
