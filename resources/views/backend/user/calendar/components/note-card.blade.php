@forelse($events as $event)
    <div class="col-lg-4 col-md-6">
        <div class="single-schedules-inner">
            <div class="date">
                <i class="fa fa-clock-o"></i>
                {{ Carbon::parse($event->start_time)->format('h:i A') }} - {{ Carbon::parse($event->end_time)->format('h:i A') }}
            </div>
            <h5>{{ $event->title }}</h5>
            <p>{{ $event->description }}</p>
            <div class="media">
                <div class="media-left">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="img">
                </div>
                <div class="media-body align-self-center">
                    {{--<h6>Dr. Ariful Islam Abid</h6>--}}
                    <p>Created At: {{ $event->created_at->format('Y-m-d h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="single-schedules-inner text-center">
            No Events found to display. Please Add New Note.
        </div>
    </div>
@endforelse
{{--
<div class="col-lg-4 col-md-6">
        <div class="single-schedules-inner lunch-schedules text-center">
            <div class="lunch-schedules-inner align-self-center">
                <div class="icons">
                    <img src="https://www.bootdey.com/image/200x200/00FFFF/000000" alt="img">
                </div>
                <h5>Lunch Break</h5>
                <div class="date">
                    <i class="fa fa-clock-o"></i>
                    5:00pm -6:30pm
                </div>
            </div>
        </div>
    </div>
    --}}

