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
                <input wire:model.lazy="category.name" class="form-control" id="name" placeholder="Enter name" type="text" required>
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
                <button type="submit" class="btn btn-dark rounded">Create</button>
            </div>
        </div>
    </form>

    <hr class="py-2">
    <div class="table-responsive">
        <table class="table table-striped table-bordered dt-responsive nowrap display" id="tickets" style="min-width: 845px">
            <thead>
            <tr>
                <th>ACTIONS</th>
                <th>NAME</th>
                <th>COLOR</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>
                        @can('support_ticket.category.update')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.support.tickets.category.edit', $category) }}">
                                Edit
                            </a>
                        @endcan

                        @can('support_ticket.category.delete')
                            <a class="btn btn-xs btn-danger" wire:click.prevent="confirmRequest({{ $category->id }})" href="javascript:void(0)">
                                Delete
                            </a>
                        @endcan
                    </td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <span class="badge" style="background-color:{{ $category->color }}">{{ $category->color }}</span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div x-data x-init="@this.on('showConfirmation', (category) => {
       Swal.fire({
           title: 'Are you sure?',
           text: 'Are you sure you want to delete this category?',
           type: 'warning',
           showCancelButton: true,
           confirmButtonColor: 'var(--danger)',
           cancelButtonColor: 'var(--secondary)',
           confirmButtonText: 'Submit!'
       }).then((result) => {
           if (result.value) {
               @this.call('destroy', category)
           }
       });
   });"></div>
</div>
