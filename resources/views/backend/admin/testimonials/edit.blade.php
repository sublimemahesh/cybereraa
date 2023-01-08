<x-backend.layouts.app>
    @section('title', 'Edit | Testimonial')
    @section('header-title', 'Edit Testimonial' )
    @section('plugin-styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.testimonials.index') }}">Testimonials</a>
        </li>
        <li class="breadcrumb-item active">Edit</li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <livewire:admin.testimonial.edit :testimonial="$testimonial"/>
        </div>
    </div>
</x-backend.layouts.app>