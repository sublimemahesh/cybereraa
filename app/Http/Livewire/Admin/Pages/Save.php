<?php

namespace App\Http\Livewire\Admin\Pages;

use App\Models\Page;
use Carbon\Carbon;
use Livewire\Component;

class Save extends Component
{
    public Page $parent;

    public Page $page;

    public ?string $image = null;

    protected $rules = [
        'page.title' => 'required',
        'image' => 'sometimes|base64image',
        'page.content' => 'required',
        'page.parent_id' => 'sometimes'
    ];

    public $image_config = [
        'image_ratio_crop' => 'C',
        'image_resize' => true,
        'image_ratio_y' => true,
        'image_x' => 1980,
    ];

    public function mount(Page $page, Page $parent)
    {
        $this->page = $page;
        $this->parent = $parent;
        $this->page->parent_id = $parent->id;
    }

    public function updated($name)
    {
        $this->validateOnly($name);
    }

    public function save()
    {
        $this->validate();

        //  save
        if (!empty($this->image)) {
            $imageName = $this->page->image ?: $this->page->replicate()->slug . '-' . Carbon::now()->timestamp;
            $imageName = store($this->image, 'pages', $imageName, $this->image_config, ['update' => !is_null($this->page->image)]);
            $this->page->image = $imageName;
        }

        $this->page->save();

        session()->flash('message', 'Page has been created successfully!');
        //  cleanup
        if (!is_null($this->parent->id)) {
            redirect()->signedRoute('admin.sections.index', ['page' => $this->parent->slug]);
        } else {
            redirect()->route('admin.pages.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.pages.save');
    }
}
