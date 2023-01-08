<div class="card">
    <div class="card-body">
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif
        <form class="theme-form" enctype="multipart/form-data" wire:submit.prevent="save">
            <div class="form-group row mb-3">
                <label class="col-sm-12 col-form-label" for="title">Title</label>
                <div class="col-sm-12">
                    <input class="form-control" id="title" placeholder="Title" type="text" wire:model.lazy="testimonial.title">
                    @error('testimonial.title') <span class="text-danger mt-2">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-12 col-form-label" for="name">Name</label>
                <div class="col-sm-12">
                    <input class="form-control" id="name" placeholder="name" type="text" wire:model.lazy="testimonial.name">
                    @error('testimonial.name') <span class="text-danger mt-2">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-12 col-form-label" for="image">Image</label>
                <div class="col-sm-12">
                    <input class="form-control" id="image" type="file" accept="image/*" placeholder="Select Image">
                    @error('image') <span class="text-danger mt-2">{{ $message }}</span> @enderror

                    @if ($image && !$errors->has('image'))
                        <img class="img-thumbnail mt-2" src="{{ $image }}" width="300" alt="">
                    @elseif (!empty($testimonial->image))
                        <img class="img-thumbnail mt-2" src="{{ storage('testimonials/' . $testimonial->image) }}" width="300" alt="">
                    @endif
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-sm-12">
                    <label for="comment">Comment</label>
                    <textarea class="form-control" id="comment" cols="30" rows="5" wire:model.lazy="testimonial.comment" placeholder="Customer comment"></textarea>
                </div>
            </div>
            @error('testimonial.comment') <span class="text-danger mt-2">{{ $message }}</span> @enderror

            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label" for="is_active">IS ACTIVE</label>
                <div class="col-sm-3">
                    <div class="form-check custom-checkbox mb-3 check-xs">
                        <input type="checkbox" wire:model.lazy="testimonial.is_active" class="form-check-input" name="is_active" id="is_active">
                        <label class="form-check-label" for="is_active"></label>
                    </div>
                </div>
                @error('testimonial.is_active') <span class="text-danger mt-2">{{ $message }}</span> @enderror
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary" wire:loading.remove>Add</button>
                </div>
            </div>
        </form>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/canvasResize/binaryajax.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/exif.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/canvasResize.js') }}"></script>

        <script>
            let image = document.getElementById('image')
            // Upload a file:
            image.addEventListener("change", (e) => {
                let file = e.target.files[0];
                canvasResize(file, {
                    width: 300,
                    height: 300,
                    crop: false,
                    quality: 80,
                    //rotate: 90,
                    callback: function (data, width, height) {
                        @this.
                        set('image', data)
                        image.value = ''
                    }
                });
            });

        </script>
    @endpush
</div>

