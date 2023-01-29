<?php

namespace App\Http\Livewire\Admin\Blogs;

use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Save extends Component
{
    use AuthorizesRequests;

    public Blog $blog;

    public ?string $image = null;

    protected function rules()
    {
        return [
            'blog.title' => 'required|max:250',
            'image' => [Rule::requiredIf($this->blog->image === null), 'nullable', 'base64image'],
            'blog.short_description' => 'required|max:250',
            'blog.description' => 'required'
        ];
    }

    public $image_config = [
        'image_ratio_crop' => 'C',
        'image_resize' => true,
        'image_ratio_y' => true,
        'image_x' => 1980,
    ];

    public function mount(Blog $blog)
    {
        $this->blog = $blog;
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
        if ($this->blog->id === null) {
            $this->authorize('create', $this->blog);
        } else {
            $this->authorize('update', $this->blog);
        }
        //  save
        if (!empty($this->image)) {
            $imageName = $this->blog->image ?: $this->blog->replicate()->slug . '-' . Carbon::now()->timestamp;
            $imageName = store($this->image, 'blogs', $imageName, $this->image_config, ['update' => !is_null($this->blog->image)]);
            $this->blog->image = $imageName;
        }

        $this->blog->save();

        session()->flash('message', 'Blog has been created successfully!');
        //  cleanup
        return redirect()->route('admin.blogs.index');
    }

    public function render()
    {
        return view('livewire.admin.blogs.save');
    }
}
