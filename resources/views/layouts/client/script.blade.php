@if (session('Responseerror') != null && session('Responseerror') == '1')
    <script>
        Swal.fire({
            icon: 'error',
            // title: "{{ __('Something Wrong') }}",
            text: "{{ session('responseTxt') }}",
            confirmButtonText: 'حسنا',
            toast: true,
            position: "top-start",
            showConfirmButton: false,
            timer: 2500
        });
    </script>
@endif
@if (session('Responsesuccess') != null && session('Responsesuccess') == '1')
    <script>
        Swal.fire({
            icon: 'success',
            // title: "{{ __('Done') }}",
            text: "{{ session('responseTxt') }}",
            confirmButtonText: 'حسنا',
            toast: true,
            position: "top-start",
            showConfirmButton: false,
            timer: 2500
        });
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.info('loaded client');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const Calendar = tui.Calendar;
        const months = [
            "{{ __('messages.Jan') }}",
            "{{ __('messages.Feb') }}",
            "{{ __('messages.March') }}",
            "{{ __('messages.Apr') }}",
            "{{ __('messages.May') }}",
            "{{ __('messages.Jun') }}",
            "{{ __('messages.July') }}",
            "{{ __('messages.Aug') }}",
            "{{ __('messages.Sep') }}",
            "{{ __('messages.Oct') }}",
            "{{ __('messages.Nov') }}",
            "{{ __('messages.Dec') }}",
        ];

        var selectedDates = [];
        var events = [];

        $('.EditBooking').click(function() {
            $.ajax({
                type: 'POST',
                url: "{{ route('booking.showedit') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: $(this).attr('id'),
                    number: $(this).attr('number'),
                },
                success: function(data) {


                    if (data.status == 'true') {
                        $("#EditBookingModel").html(data.html);
                    } else {
                        showError();
                    }

                },
                error: function() {
                    showError();
                }
            });
        });
        $('.CancelBooking').click(function() {
            $.ajax({
                type: 'POST',
                url: "{{ route('booking.showcancel') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: $(this).attr('id'),
                    number: $(this).attr('number'),
                },
                success: function(data) {


                    if (data.status == 'true') {
                        $("#CancelBookingModel").html(data.html);
                    } else {
                        showError();
                    }

                },
                error: function() {
                    showError();
                }
            });
        });



        function showEventModel(id) {

            Swal.fire({
                showClass: {
                    popup: ` animate__animated animate__zoomInRight animate__faster `
                },
                hideClass: {
                    popup: ` animate__animated animate__zoomOutRight animate__faster `
                },
                width: '42em',
                showConfirmButton: false,
                color: "#716add",
                html: `<div id="bookingDetail"> `,
                didOpen: () => {
                    Swal.showLoading();
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('bookings.getDetails') }}",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            id: id,
                        },
                        success: function(data) {
                            Swal.hideLoading();
                            if (data.status == 'true') {
                                Swal.update({
                                    html: `<div id="bookingDetail">${data.html}</div>`
                                });
                            } else {
                                Swal.update({
                                    html: `<div  class="text-center" id="bookingDetail">{{ __('No details available') }}</div>`
                                });
                            }
                        },
                        error: function() {
                            Swal.update({
                                html: `<div class="text-center" id="bookingDetail">{{ __('Failed to load details') }}</div>`
                            });
                        }
                    });
                },
            });




        }

        function createCards(events, id) {
            var html = '';
            events.forEach(function(event) {
              
                html = html +
                    `<div class="card facilityCard" id="` + event.id + `">
                        <div class="d-flex justify-content-between align-items-center p-2">
                            <div>
                                <div style="border-radius: 4px;width:20px;height:20px;background:` + event.bgColor + `"></div>
                            </div>
                            <div class="d-inline text-center  "> 
                                ` + event.facility + ` <br>
                                 <p class='h5'>` + event.title + `</p>
                            </div>
                            ` + event.htmlstatus + `
                            <small>` + event.start.replace("T", " ").substr(0, 16) + " <br>" + event.end.replace("T",
                        " ").substr(0, 16) + `</small>
                        </div>
                    </div>`;
            });

            $('#' + id).html(html);
            $('#' + id).on('click', '.facilityCard', function() {
                showEventModel($(this).attr('id'));
            });
        }

        function setTitle(passedcalender, bookingandMin = '0') {

            var date = new Date(passedcalender.getDate());

            var month = months[date.getMonth()];
            var year = date.getFullYear();
            $("#calender_title").html(month + " / " + year);



            var csrfToken = $('meta[name="csrf-token"]').attr('content');


            $.ajax({
                type: 'POST',
                url: "{{ route('mybookings.get') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    i: {{ isset($facility) ? $facility->id : '-1' }},
                    n: {{ isset($facility) ? $facility->number : (app('request')->has('fa') ? app('request')->input('fa') : '-1') }},

                    m: (date.getMonth() + 1).toString().padStart(2, '0'),
                    y: year,
                    all: bookingandMin
                },
                success: function(data) {
                   
                    events.forEach(function(event) {
                        passedcalender.deleteSchedule(event.id, event.calendarId);



                    });
                    events = [];
                    events = data.events;
                    passedcalender.createSchedules(events);

                    @if (Route::current()->getName() == 'mybookings')
                        createCards(events, 'cardsSection')
                    @endif



                }
            });
        }

        function clearSelectedDates(passedcalender) {
            selectedDates.forEach(function(date) {
                passedcalender.deleteSchedule(date.id, date.calendarId);
            });
            selectedDates = [];
        }

        function hasEventsOnDates(startTime, endTime) {
            var startDate = normalizeDate(startTime);
            var endDate = normalizeDate(endTime);

            return events.some(function(event) {
                var eventStartDate = normalizeDate(event.start);
                var eventEndDate = normalizeDate(event.end);

                return (eventStartDate <= endDate && eventEndDate >= startDate);
            });
        }

        function normalizeDate(dateString) {
            var date = new Date(dateString);
            return new Date(date.getFullYear(), date.getMonth(), date.getDate()); // Normalize to just the date
        }

        function getDaysBetween(start, end) {

            var startDate = new Date(start);
            var endDate = new Date(end);
            startDate.setHours(0, 0, 0, 0);
            endDate.setHours(0, 0, 0, 0);
            var timeDifference = endDate - startDate;
            var dayDifference = (timeDifference / (1000 * 60 * 60 * 24)) + 1;

            return Math.ceil(dayDifference);
        }

        function showError() {
            Swal.fire({
                icon: 'error',
                text: "{{ __('Something Wrong') }}",
                toast: true,
                position: "top-start",
                showConfirmButton: false,
                timer: 2500
            });
        }

        @if (Route::current()->getName() == 'facility.details')

            var detailscalendar = new Calendar('#calendar', {
                defaultView: 'month', // Set default view to 'month'
                useCreationPopup: false,
                useDetailPopup: false,
                calendars: [{
                    id: '1',
                    name: '{{ __('Facility Calendar') }}',
                    color: '#ffffff',
                    bgColor: '#ff5583',
                    dragBgColor: '#ff5583',
                    borderColor: '#ff5583'
                }],

            });
            setTitle(detailscalendar, '1');

            $('#cal-next').on('click', function() {

                detailscalendar.next();
                setTitle(detailscalendar, '1');
            })

            $('#cal-prev').on('click', function() {

                detailscalendar.prev();
                setTitle(detailscalendar, '1');

            })


            detailscalendar.on('beforeCreateSchedule', function(event) {
                var startTime = event.start;
                var endTime = event.end;
                clearSelectedDates(detailscalendar);
                if (hasEventsOnDates(startTime, endTime)) {

                    Swal.fire({
                        icon: 'error',
                        title: "{{ __('Booked') }}",
                        text: "{{ __('Sorry there is event') }}",
                        confirmButtonText: 'حسنا',
                        toast: true,
                        position: "top-start",
                        showConfirmButton: false,
                        timer: 2500
                    });

                    return;
                } else {
                    var newSchedule = {
                        id: String(Date.now()),
                        calendarId: '1',
                        title: '{{ __('Book Now') }}',
                        category: 'allday',
                        dueDateClass: '',
                        bgColor: '#8A1538',
                        borderColor: '#8A1538',
                        start: startTime,
                        end: endTime,
                        isReadOnly: true
                    };

                    selectedDates.push(newSchedule);
                    detailscalendar.createSchedules([newSchedule]);
                }
            });

            detailscalendar.on('clickSchedule', function(event) {
                var schedule = event.schedule;
                if (schedule.title == '{{ __('Book Now') }}') {
                    var days = getDaysBetween(schedule.start, schedule.end);
                    var startDate = new Date(schedule.start).toLocaleDateString();
                    var endDate = new Date(schedule.end).toLocaleDateString();
                    if (days > 1) {
                        if (days == 2) {
                            $("#bookingdays").val(" {{ __('messages.Two Days') }}");
                        }
                        if (days > 2) {
                            $("#bookingdays").val(days + " {{ __('messages.Days') }}");

                        }
                        if (days > 10) {

                            $("#bookingdays").val(days +
                                " {{ __('messages.morethan10Days') }}");
                        }
                        $("#booking_from_date").val(startDate);
                        $("#booking_to_date").val(endDate);
                        $("#booking_date").val('');
                        $("#booking_type").val('2');
                        $("#oneday").hide();
                        $("#manydays").show();
                    } else {
                        $("#booking_days").val('1');
                        $("#booking_type").val('1');
                        $("#bookingdays").val(" {{ __('messages.One Day') }}");
                        $("#booking_from_date").val('');
                        $("#booking_to_date").val('');
                        $("#booking_date").val(startDate);
                        $("#oneday").show();
                        $("#manydays").hide();
                    }
                    $("#booking_days").val(days);
                    $("#new_booking_model").modal('show');
                } else if (schedule.title == '{{ __('Maintenance') }}') {
                    console.log('min');
                } else if (schedule.id == -100) {
                    console.log('booked');

                } else {
                    showEventModel(schedule.id)
                }
            });
        @endif

        @if (Route::current()->getName() == 'mybookings')

            var maincalendar = new Calendar('#bookingscalendar', {
                defaultView: 'month',
                useCreationPopup: false,
                useDetailPopup: false,
                calendars: [{
                    id: '1',
                    name: '{{ __('My Bookings Calendar') }}',
                    color: '#ffffff',
                    bgColor: '#ff5583',
                    dragBgColor: '#ff5583',
                    borderColor: '#ff5583'
                }],

            });

            setTitle(maincalendar);


            $('#cal-next').on('click', function() {
                maincalendar.next();
                setTitle(maincalendar);
            })

            $('#cal-prev').on('click', function() {

                maincalendar.prev();
                setTitle(maincalendar);

            })


            maincalendar.on('beforeCreateSchedule', function(event) {
                event.guide.clearGuideElement();
            });
            maincalendar.on('clickSchedule', function(event) {
                var schedule = event.schedule;
                showEventModel(schedule.id);
            });
        @endif

    });
</script>
