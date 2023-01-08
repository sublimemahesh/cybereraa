<?php

namespace App\Http\Livewire\Admin\Testimonial;

use App\Models\Testimonial;
use Auth;
use Carbon;
use Livewire\Component;
use Str;

class Create extends Component
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
        'image' => 'required|base64image',
        'testimonial.comment' => 'required|max:200',
        'testimonial.is_active' => 'nullable|bool'
    ];

    public function mount(Testimonial $testimonial)
    {
        $this->testimonial = $testimonial;
    }

    public function updated($name)
    {
        $this->validateOnly($name);
    }

    public function save()
    {
        $this->validate();
        //  save
        $this->testimonial->user_id = Auth::user()->id;

        if (!empty($this->image)) {
            $imageName = Str::random(8) . '-' . Carbon::now()->timestamp;
            $imageName = store($this->image, 'testimonials', $imageName, $this->image_config);
            $this->testimonial->image = $imageName;
        }

        $this->testimonial->save();

        $this->testimonial = new Testimonial();
        $this->image = '';

        session()->flash('message', 'Testimonials created successfully!');
    }

    public function render()
    {
        return view('livewire.admin.testimonial.create');
    }
}
