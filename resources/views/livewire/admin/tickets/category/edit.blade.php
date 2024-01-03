<div>
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <form wire:submit.prevent="save" class="theme-form" enctype="multipart/form-data">
        <div class="form-group row mb-2">
            <label class="col-sm-3 col-form-label" for="name">Ticket category</label>
            <div class="col-sm-9">
                @if($category->slug === 'reschedule-plan')
                    <div class="form-control">{{ $category->name }}</div>
                @else
                    <input wire:model.lazy="category.name" id="name" class="form-control" placeholder="Enter name" type="text" required>
                @endif

                @error('category.name')
                <span class="text-danger mt-2">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-group row mb-2">
            <label class="col-sm-3 col-form-label" for="color">Color</label>
            <div class="col-sm-9">
                <input wire:model.lazy="category.color" id="color" class="form-control" placeholder="Enter name" type="color" required>
                @error('category.color')
                <span class="text-danger mt-2">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </form>
</div>
