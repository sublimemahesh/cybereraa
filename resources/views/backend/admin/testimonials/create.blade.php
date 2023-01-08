<x-backend.layouts.app>
    @section('title', 'Create | Testimonial')
    @section('header-title', 'Create Testimonial' )
    @section('plugin-styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.testimonials.index') }}">Testimonials</a>
        </li>
        <li class="breadcrumb-item active">Create</li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <livewire:admin.testimonial.create/>
        </div>
    </div>
</x-backend.layouts.app>