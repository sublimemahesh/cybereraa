<?php

namespace App\Http\Livewire\Admin\Testimonial;

use App\Models\Testimonial;
use Carbon;
use Livewire\Component;
use Str;

class Edit extends Component
{
    public Testimonial $testimonial;
    public $image;

    protected $image_config = [
        'image_resize' => true,
        'image_ratio_crop' => 'C',
        'image_x' => 250,
        'image_y' => 250,
    ];

    protected $rules = [
        'testimonial.name' => 'required|max:200',
        'testimonial.title' => 'required|max:200',
        'image' => 'sometimes|base64image',
        'testimonial.comment' => 'required|max:200',
        'testimonial.is_active' => 'required|bool'
    ];

    public function updated($name)
    {
        $this->validateOnly($name);
    }

    public function save()
    {
        $this->validate();
        //  save
        if (!empty($this->image)) {
            $imageName = $this->testimonial->image ?: Str::random(8) . '-' . Carbon::now()->timestamp;
            $imageName = store($this->image, 'testimonials', $imageName, $this->image_config, ['update' => $this->testimonial->image !== null]);
            $this->testimonial->image = $imageName;
        }

        $this->testimonial->save();
        session()->flash('message', 'Testimonials created successfully!');

        redirect()->route('admin.testimonials.index');

    }

    public function render()
    {
        return view('livewire.admin.testimonial.edit');
    }
}
