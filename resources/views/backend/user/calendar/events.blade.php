<x-backend.layouts.app>
    @section('title', 'Calendar')
    @section('header-title', 'My Calendar' )
    @section('plugin-styles')
        @vite(['resources/css/app-jetstream.css','resources/css/fullcalendar.css', 'resources/js/fullcalendar.js'])
    @endsection

    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/calendar.css') }}">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">My Calendar</li>
    @endsection
    <div class="row dark">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>My Calendar & Events</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="calendarEl"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('modals')
        <!-- Modal -->
        <div class="modal fade" id="events-modal">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="event-modal-title">Notes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">


                        <div class="schedules-area pd-top-110 pd-bottom-120">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-xl-7 col-lg-8">
                                        <div class="section-title text-center">
                                            <h2>Event Schedules</h2>
                                            <button class="btn btn-primary mb-4" id="new-event">
                                                <i class="fa fa-plus fs-22 fw-normal me-2 lh-1"></i>Add New Note
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="new-event-add-container" style="display: none">
                                    <div class="col-sm-8 m-auto">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5>Add New Event</h5>
                                                <form id="new-event-form">
                                                    <div class="mb-3 mt-2">
                                                        <label class="text-white" for="title">Title</label>
                                                        <input id="title" name="title" type="text" placeholder="Title" class="form-control"/>
                                                    </div>
                                                    <div class="mb-3 mt-2">
                                                        <label class="text-white" for="start_time">Start Time</label>
                                                        <input id="start_time" name="start_time" type="time" placeholder="Title" class="form-control"/>
                                                    </div>
                                                    <div class="mb-3 mt-2 d-none">
                                                        <label class="text-white" for="end_time">End Time</label>
                                                        <input id="end_time" name="end_time" type="time" placeholder="Title" class="form-control"/>
                                                    </div>
                                                    <div class="mb-3 mt-2">
                                                        <label class="text-white" for="description">Description</label>
                                                        <textarea id="description" name="description" rows="3" placeholder="Description" class="form-control h-auto"></textarea>
                                                    </div>
                                                    <button type="submit" id="add-new-event" class="btn btn-sm btn-success mb-2">
                                                        Add
                                                    </button>
                                                    <button type="submit" id="close-add-new-event" class="btn btn-sm btn-secondary mb-2">
                                                        Cancel
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="events-container">
                                    <!-- Events -->
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    @endpush
    @push('scripts')
        <script !src="">
            $(document).ready(function () {
                const events = {!! json_encode($events,JSON_THROW_ON_ERROR) !!};

                const eventsModal = new bootstrap.Modal('#events-modal', {
                    backdrop: 'static',
                })

                let clickedDateInfo = null;
                let calendar = FullCalendar.init(FullCalendar.calendarEl, {
                    events: [...events],
                    eventDidMount: function (info) {
                        console.log(info)
                        $(info.el).tooltip({
                            title: info.event.extendedProps.description,
                            placement: "top",
                            trigger: "hover",
                            container: "body",
                        });
                    },
                    dateClick: function (info) {
                        console.log(info, moment(info.dateStr).format('HH:mm'))
                        clickedDateInfo = info;
                        loader()
                        axios.post(`${APP_URL}/user/calendar/${moment(info.dateStr).format('YYYY-MM-DD')}/events`)
                            .then(response => {
                                $('#event-modal-title').html(`${moment(info.dateStr).format('YYYY-MM-DD')} Notes`)
                                $('#events-container').html(response.data.html)
                                eventsModal.show();
                            })
                            .catch(e => {
                                console.log(e)
                                Toast.fire({
                                    title: 'Something went wrong',
                                    text: e.response.data.message,
                                })
                            })
                            .finally(() => Swal.close())
                    }
                })
                calendar.render()

                $(document).on('click', '#new-event', function (e) {
                    e.preventDefault()
                    console.log(`click #new-event: `, clickedDateInfo)
                    showAddNewEvent(clickedDateInfo)
                })
                $(document).on('click', '#add-new-event', function (e) {
                    e.preventDefault()
                    if (clickedDateInfo !== null) {
                        let form = $('#new-event-form')[0]
                        let form_data = new FormData(form);

                        axios.post(`${APP_URL}/user/calendar/${clickedDateInfo.dateStr}/events/new`, form_data)
                            .then(response => {
                                // {
                                //     title: response.data.event,
                                //     start: clickedDateInfo.dateStr,
                                //     allDay: true
                                // }
                                calendar.addEvent(response.data.event);
                                Toast.fire({
                                    icon: response.data.icon, title: response.data.message,
                                })
                                $('#new-event-form')[0].reset()
                                hideAddNewEvent()
                                eventsModal.hide();
                            }).catch(error => {
                            Toast.fire({
                                icon: 'error', title: error.response.data.message || "Something went wrong!",
                            })
                        })
                    }
                })
                $(document).on('click', '#close-add-new-event', function (e) {
                    e.preventDefault()
                    hideAddNewEvent()
                })

                document.getElementById('events-modal').addEventListener('hidden.bs.modal', event => {
                    clickedDateInfo = null;
                    hideAddNewEvent()
                    $('#events-container').empty()
                    $('#new-event-form')[0].reset()
                    console.log(`#events-modal hidden: `, clickedDateInfo)
                })
            })

            function showAddNewEvent(clickedDateInfo) {
                if (clickedDateInfo !== null) {
                    $('#start_time').val(moment(clickedDateInfo.dateStr).format('HH:mm'))
                }
                $('#new-event-add-container').show();
                $('#new-event').hide();
                $('#events-container').hide();
            }

            function hideAddNewEvent() {
                $('#new-event-add-container').hide();
                $('#new-event').show();
                $('#events-container').show();
            }
        </script>
    @endpush
</x-backend.layouts.app>
