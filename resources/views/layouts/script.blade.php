@if (session('Responseerror') != null && session('Responseerror') == '1')
    <script>
        Swal.fire({
            icon: 'error',
            text: "{{ session('responseTxt') }}",
            confirmButtonText: 'حسنا',
            toast: true,
            position: "top-start",
            showConfirmButton: false,
            timer: 3500
        });
    </script>
@endif
@if (session('Responsesuccess') != null && session('Responsesuccess') == '1')
    <script>
        Swal.fire({
            icon: 'success',
            text: "{{ session('responseTxt') }}",
            confirmButtonText: 'حسنا',
            toast: true,
            position: "top-start",
            showConfirmButton: false,
            timer: 2500
        });
    </script>
@endif










@if (Route::current()->getName() == 'createFacility')
    <script>
        $('.AddSub').click(function() {
            @php
                $subFacilityOptions = \App\Models\SubFacilityTypes::where('status', '1')->get();
            @endphp
            var options = `
                    @foreach ($subFacilityOptions as $subtype)
                        <option value="{{ $subtype->id }}">{{ $subtype->name }}</option>
                    @endforeach
                `;

            var table = $("#subTable");
            var count = $('#subTable tr:last').attr('count');
            var id = 'subTableTr' + (parseInt(count) + 1);
            var newTR = `<tr id="` + id + `" count="` + (parseInt(count) + 1) + `">
                                            <td>
                                                <input type="text" class="form-control required" name="subarname` + (
                    parseInt(count) + 1) + `"
                                                    placeholder="{{ __('Ar Name') }} *" />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control required" name="subenname` + (
                    parseInt(count) + 1) + `"
                                                    placeholder="{{ __('En Name') }} *" />
                                            </td>
                                            <td>
                                                <select name="subtype` + (parseInt(count) + 1) + `" class="form-control required">
                                                    <option disabled selected value="">{{ __('Type') }} *</option>
                                                    ` + options + `
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control required" name="subcapacitpy` +
                (parseInt(count) + 1) + `"
                                                    placeholder="{{ __('Capacity') }} *" />
                                            </td>
                                            <td width="25%">
                                                <textarea type="text" rows="3" name="subcdesc` + (parseInt(count) +
                    1) + `" class="form-control  " placeholder="{{ __('Description') }}" /></textarea>
                                            </td>
                                            <td>
                                                <input type="file" accept=".png,.jpg,.jpeg" name="subfiles` + (
                    parseInt(count) + 1) + `[]" multiple
                                                    class="form-control required" placeholder="{{ __('Images') }} *" />
                                            </td>
                                            <td>
                                                <button type="button" class="btn removeSub" id="` + (parseInt(count) +
                    1) + `"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24" fill="rgba(245,4,4,1)">
                                                        <path
                                                            d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM18 8H6V20H18V8ZM9 11H11V17H9V11ZM13 11H15V17H13V11ZM9 4V6H15V4H9Z">
                                                        </path>
                                                    </svg></button>
                                            </td>
                                        </tr>`;
            table.append(newTR);
            $("#count").val(parseInt($("#count").val()) + 1);

        });
    </script>
@endif




<script>
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    const Calendar = tui.Calendar;
    const chartmonths = [
        "",
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
</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {



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
                html: `<div id="bookingDetail">{{ __('Loading') }}`,
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
            var imagelink = "{{ config('app.url') }}"+"public";
            events.forEach(function(event) {
                var link = imagelink + "/booking-details/" + event.id;

                // html = html +
                //     `<div class="card facilityCard" id="` + event.id +
                //     `"style="color:#fff;background:` + event.bgColor + `">
                //         <div class="d-flex justify-content-between align-items-center p-2">
                //             <p class='h5'>` + event.title + `</p>
                //             <small>` + event.start.replace("T", " ").substr(0, 16) + " <br>" + event.end.replace("T",
                //         " ").substr(0, 16) + `</small>
                //             </div>
                //         </div>`;

                html = html +
                    `<div class="card p-3" >
                        <div class="d-flex justify-content-between align-items-center p-2 facilityCard" id="` + event
                    .id + `">
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
                        <a href="` + link + `"
            class="btn btn-block btn-outline-primary ">{{ __('Details') }}</a>
                    </div>`;
            });
            $('#' + id).html(html);


            $('#' + id).on('click', '.facilityCard', function() {

                showEventModel($(this).attr('id'));

            });

        }

        function createLegends(events, id) {
            var html = '<div class="row p-2">';
            var innerhtml = '';
            var lengds = [];
            events.forEach(function(event) {
                let index = lengds.findIndex((item) => item.facility === event.facility);
                if (index === -1) {

                    lengds.push(event)
                }
            });

            lengds.forEach(function(event) {

                innerhtml = innerhtml +
                    `
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div  style="border-radius: 4px;width:20px;height:20px;background:` + event.bgColor + `"> </div>
                            <div class="mh-2"> ` + event.facility + ` 
                                <br>
                                <div class="mh-2"> ` + event.work + ` </div>
                            </div>
                            
                        </div>
                    </div>`;


            });
            html = html + innerhtml + `</div>`;
            $('#' + id).html(html);
        }

        function setMinTitle(passedcalender) {

            var date = new Date(passedcalender.getDate());

            var month = months[date.getMonth()];
            var year = date.getFullYear();
            $("#calender_title").html(month + " / " + year);



            var csrfToken = $('meta[name="csrf-token"]').attr('content');


            $.ajax({
                type: 'POST',
                url: "{{ route('maintenance.get') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    i: {{ isset($facility) ? $facility->id : '-1' }},
                    n: {{ isset($facility) ? $facility->number : (app('request')->has('fa') ? app('request')->input('fa') : '-1') }},

                    m: (date.getMonth() + 1).toString().padStart(2, '0'),
                    y: year
                },
                success: function(data) {

                    events.forEach(function(event) {
                        passedcalender.deleteSchedule(event.id, event.calendarId);



                    });
                    events = [];
                    events = data.events;
                    passedcalender.createSchedules(events);

                    @if (Route::current()->getName() == 'bookings')
                        createCards(events, 'cardsSection')
                    @endif

                    @if (Route::current()->getName() == 'maintenance' && app('request')->input('fa') == null)

                        createLegends(events, 'cardsSection')
                    @endif


                }
            });
        }

        function setTitle(passedcalender, bookingandMin = false) {

            var date = new Date(passedcalender.getDate());

            var month = months[date.getMonth()];
            var year = date.getFullYear();
            $("#calender_title").html(month + " / " + year);



            var csrfToken = $('meta[name="csrf-token"]').attr('content');


            $.ajax({
                type: 'POST',
                url: "{{ route('bookings.get') }}",
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

                    @if (Route::current()->getName() == 'bookings')
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
            return new Date(date.getFullYear(), date.getMonth(), date
                .getDate()); // Normalize to just the date
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

        var selectedDates = [];
        var events = [];

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
            setTitle(detailscalendar, true);

            $('#cal-next').on('click', function() {

                detailscalendar.next();
                setTitle(detailscalendar, true);
            })

            $('#cal-prev').on('click', function() {

                detailscalendar.prev();
                setTitle(detailscalendar, true);

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
                    var level = {{ auth()->user()->level }}
                    if (level == '1') {


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
                    } else {
                        event.guide.clearGuideElement();
                    }
                    return;
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
                } else {
                    showEventModel(schedule.id)

                }
            });
        @endif

        @if (Route::current()->getName() == 'bookings')
            var maincalendar = new Calendar('#bookingscalendar', {
                defaultView: 'month', // Set default view to 'month'
                useCreationPopup: false,
                useDetailPopup: false,
                calendars: [{
                    id: '1',
                    name: '{{ __('Bookings Calendar') }}',
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
        @if (Route::current()->getName() == 'maintenance')
            var maintenancecalendar = new Calendar('#maintenancecalendar', {
                defaultView: 'month',
                useCreationPopup: false,
                useDetailPopup: true,
                calendars: [{
                    id: '1',
                    name: '{{ __('Maintenance Calendar') }}',
                    color: '#ffffff',
                    bgColor: '#ff5583',
                    dragBgColor: '#ff5583',
                    borderColor: '#ff5583'

                }],

            });

            setMinTitle(maintenancecalendar);

            $('#cal-next').on('click', function() {

                maintenancecalendar.next();
                setMinTitle(maintenancecalendar);
            })

            $('#cal-prev').on('click', function() {

                maintenancecalendar.prev();
                setMinTitle(maintenancecalendar);

            })


            maintenancecalendar.on('beforeCreateSchedule', function(event) {

                event.guide.clearGuideElement();
            });
            maintenancecalendar.on('clickSchedule', function(event) {
                // var schedule = event.schedule;
                // showEventModel(schedule.id);
            });
        @endif

        $('#FacilityFilter').on('change', function() {
            var v = document.getElementsByClassName(
                'item-content animate__animated animate__fadeIn active')[0].id;
            var selectedValue = ($(this).val());
            if (selectedValue != '') {
                window.location.href = window.location.href.split('?')[0] + "?fa=" + selectedValue +
                    "&v=" + v;

            } else {
                window.location.href = window.location.href.split('?')[0] + "?v=" + v;
            }



        });



    });
</script>








<script>
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



    @if (auth()->user()->level == '1' || auth()->user()->level == '6')
        $('#ReportFromDate').on('change', function() {
            var startDate = $(this).val();
            if (startDate) {
                $('#ReportToDate').attr('min', startDate);
                $('#ReportToDate').val('');
            } else {
                $('#ReportToDate').removeAttr('min');
            }
        });
        $('body').on('click', '#PrintReport', function() {
            printDiv($(this).attr('divname'), $(this).attr('fileName'));
            // saveDivAsPDF($(this).attr('divname'), $(this).attr('fileName'));
        });

        $('body').on('click', '.ExportTable', function() {


            $('.hidewhenexport').hide();
            var id = $(this).attr('tableid');
            var filename = $(this).attr('filename');
            var table = document.getElementById(id);

            var ws = XLSX.utils.table_to_sheet(table, {
                display: true
            });
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
            XLSX.writeFile(wb, filename + ".xlsx");

            $('.hidewhenexport').show();


        });
        $('#GenerateReport').on('click', function() {
            var facility = $("#ReportFacility").val();
            var reportType = $("#ReportType").val();
            var fromDate = $("#ReportFromDate").val();
            var toDate = $("#ReportToDate").val();
            var status = $("#ReportStatus").val();
            var booker = $("#booker").val();

            Swal.showLoading();

            $.ajax({
                type: 'POST',
                url: "{{ route('report.generate') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    facility: facility,
                    reportType: reportType,
                    booker: booker,
                    fromDate: fromDate,
                    toDate: toDate,
                    status: status
                },
                success: function(data) {
                    Swal.close();


                    if (data.status == 'true') {
                        $("#ReportResult").html(data.html);
                    } else {
                        showError();
                    }
                },
                error: function() {
                    Swal.close();

                }
            });

        });

        function printDiv(divName, filename) {
            $('.ExportTable').hide();
            var originalTitle = document.title;
            document.title = filename;
            var buttons = document.getElementById(divName).querySelectorAll('button');
            buttons.forEach(button => {
                button.style.display = 'none';
            });
            $('#imageDiv').show();
            $('.hidewhenexport').hide();
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
            document.title = originalTitle;
            var buttons = document.getElementById(divName).querySelectorAll('button');
            buttons.forEach(button => {
                button.style.display = 'unset';
            });
            $('#imageDiv').hide();
            $('.hidewhenexport').show();
            $('.ExportTable').show();
        }

        function saveDivAsPDF(divId, fileName) {
            var element = document.getElementById(divId);
            var buttons = element.querySelectorAll('button');
            buttons.forEach(button => {
                button.style.display = 'none';
            });


            $('#imageDiv').show();


            Swal.fire({
                title: 'جاري إنشاء الملف',
                html: 'الرجاء الإنتظار حتى يتم تحميل الملف',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });


            setTimeout(() => {
                var opt = {
                    padding: 0.2,
                    margin: 0.2,
                    pagebreak: {
                        mode: ['avoid-all', 'css', 'legacy']
                    },
                    filename: fileName,
                    image: {
                        type: 'jpeg',
                        quality: 1
                    },
                    html2canvas: {
                        scale: 1
                    },
                    jsPDF: {
                        unit: 'cm',
                        format: 'a4',
                        orientation: 'landscape'
                    }
                };



                var doc = new jsPDF(opt.jsPDF);
                doc.setLanguage("ar-SA");
                doc.setR2L(true);
                doc.setFont('Lusail', 'normal');
                html2pdf().set(opt).from(element).output('blob')
                    .then(blob => {

                        Swal.close();

                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = fileName;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        buttons.forEach(button => {
                            button.style.display = 'unset';
                        });
                        $('#imageDiv').hide();
                    })
                    .catch(error => {
                        console.error('Error during PDF generation:', error);
                        Swal.close();
                    });


            }, 500);
        }

        $('.DeleteFacility').on('click', function() {
            var id = $(this).attr('id');
            var number = $(this).attr('number');
            $.ajax({
                type: 'POST',
                url: "{{ route('facility.showdelete') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: id,
                    number: number,
                },
                success: function(data) {
                    if (data.status == 'true') {
                        $("#DeleteFacilityModel").html(data.html);
                    } else {
                        showError();
                    }
                },
                error: function() {

                }
            });
        });


        $('#ReportType').on('change', function() {
            var type = $(this).val();
            switch (type) {
                case '':
                    $(".forBookings").show();
                    break;
                case 'bookings':
                    $(".forBookings").show();
                    break;
                case 'maintenance':
                    $(".forBookings").hide();
                    $(".forBookings").hide();
                    $("#booker").val("").change();
                    $("#ReportStatus").val("").change();


                    break;

                default:
                    break;
            }
        });
    @endif

    @if (auth()->user()->level == '2')
        $('.DeleteMin').on('click', function() {
            var id = $(this).attr('id');
            var number = $(this).attr('number');
            $.ajax({
                type: 'POST',
                url: "{{ route('min.showdelete') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: id,
                    number: number,
                },
                success: function(data) {
                    if (data.status == 'true') {
                        $("#DeleteMinModel").html(data.html);
                    } else {
                        showError();
                    }
                },
                error: function() {

                }
            });
        });
        $('.EditMin').on('click', function() {
            var id = $(this).attr('id');
            var number = $(this).attr('number');
            $.ajax({
                type: 'POST',
                url: "{{ route('min.showedit') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: id,
                    number: number,
                },
                success: function(data) {
                    if (data.status == 'true') {
                        $("#DeleteMinModel").html(data.html);
                    } else {
                        showError();
                    }
                },
                error: function() {

                }
            });
        });
        
    @endif
    @if (auth()->user()->level == '6')

        $('#userLevel').on('change', function() {
            var level = $(this).val();
            if (level == '3') {
                $('#clubselect').show();
                $('#userClub').attr('required', 'true');

            } else {
                $('#clubselect').hide();
                $('#userClub').attr('required', 'false');
            }
        });
        $('body').on('change', '#userEditLevel', function() {

            var level = $(this).val();
            if (level == '3') {
                $('#editclubselect').show();
                $('#userEditClub').attr('required', 'true');

            } else {
                $('#editclubselect').hide();
                $('#userEditClub').attr('required', 'false');
            }
        });


        $('.EditUser').click(function() {

            $.ajax({
                type: 'POST',
                url: "{{ route('user.showedit') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: $(this).attr('userid'),
                    number: $(this).attr('usernumber'),
                },
                success: function(data) {



                    if (data.status == 'true') {
                        $("#editUserModel").html(data.html);
                    } else {
                        showError();
                    }

                },
                error: function() {

                }
            });
        });
        $('.ResetClient').click(function() {
            $("#usernameToreset").html($(this).attr('displayname'));
            $("#useridToreset").val($(this).attr('userid'));
            $("#usernumberToreset").val($(this).attr('usernumber'));
        });
        $('.EditClient').click(function() {

            $.ajax({
                type: 'POST',
                url: "{{ route('client.showedit') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: $(this).attr('userid'),

                    number: $(this).attr('usernumber'),
                },
                success: function(data) {


                    if (data.status == 'true') {
                        $("#editClientModel").html(data.html);
                    } else {
                        showError();
                    }

                },
                error: function() {

                }
            });
        });
        $('.DeleteUser').click(function() {

            $.ajax({
                type: 'POST',
                url: "{{ route('client.showdelete') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: $(this).attr('userid'),
                    number: $(this).attr('usernumber'),
                },
                success: function(data) {
                    if (data.status == 'true') {
                        $("#deleteClientModel").html(data.html);
                    } else {
                        showError();
                    }

                },
                error: function() {

                }
            });
        });
    @endif
</script>

<script>
    $('.langBtn').click(function() {
        $("#LangForm").submit();
    });
</script>
@if (Route::current()->getName() == 'createFacility')
    <script>
        $('body').on('change', '.locationValue', function() {
            $("#zoneinput").css('border', '');
            $("#streetinput").css('border', '');
            $("#bulidinginput").css('border', '');
            $("#errorLoc").hide();
            $("#locationpass").val('0');
            var zone = $("#zoneinput").val();
            var street = $("#streetinput").val();
            var buliding = $("#bulidinginput").val();
            if (zone != '' && street != '' && buliding != '') {
                checkLocation(zone, street, buliding);

            }

        });








        function check() {
            var isValid = true;
            isValid = $("#locationpass").val() == '1';


            if (!isValid) {
                event.preventDefault();
                $("#addressDiv").focus();
            }
        }
        async function checkLocation(zone, street, buliding) {
            $.ajax({
                type: 'POST',
                url: "{{ route('location.check') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    zone: zone,
                    street: street,
                    buliding: buliding,
                },
                success: function(data) {

                    if (data.status == 'true') {
                        var status = data.result;
                        if (status == 'good') {
                            $("#zoneinput").css('border', '');
                            $("#streetinput").css('border', '');
                            $("#bulidinginput").css('border', '');
                            $("#errorLoc").hide();
                            $("#locationpass").val('1');
                        } else {
                            $("#locationpass").val('0');
                            $("#zoneinput").css('border', '1px solid red').focus();
                            $("#streetinput").css('border', '1px solid red').focus();
                            $("#bulidinginput").css('border', '1px solid red').focus();
                            $("#errorLoc").show();
                        }
                    } else {
                        return 'error';
                    }

                },
                error: function() {
                    return 'error';
                }
            });
        }
    </script>
@endif
@if (Route::current()->getName() == 'settings.notifications')
    <script>
        $("#TestMailBtn").click(function() {
            var input = $("#testmail");

            if (input.val().trim() == '') {
                input.css('border', '1px solid red').focus();
                return;
            } else {
                input.css('border', '');

            }


            $.ajax({
                type: 'POST',
                url: "{{ route('settings.sendtestmail') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    email: input.val(),
                    locale: $("#testmaillocale").val(),
                },
                success: function(data) {
                    if (data.status = 'true') {
                        Swal.fire({
                            icon: 'success',
                            text: data.result,
                            toast: true,
                            position: "top-start",
                            showConfirmButton: false,
                            timer: 4500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: "{{ __('Something Wrong') }}",
                            toast: true,
                            position: "top-start",
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        text: "{{ __('Something Wrong') }}",
                        toast: true,
                        position: "top-start",
                        showConfirmButton: false,
                        timer: 2500
                    });
                }
            });
        });

        $("#TemplateSelector").change(function() {
            $.ajax({
                type: 'POST',
                url: "{{ route('settings.showtemplate') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    name: $(this).val(),
                },
                success: function(data) {


                    if (data.status == 'true') {
                        $("#TemplateDetails").html(data.html);
                    } else {
                        showError();
                    }

                },
                error: function() {

                }
            });

        });
    </script>
@endif
@if (Route::current()->getName() == 'dashboard')
    <script>
        const mainctx = document.getElementById('bookingMinChart');
        const ctx = document.getElementById('bookingsChart');

        const ctx2 = document.getElementById('minChart');



        $.ajax({
            type: 'POST',
            url: "{{ route('getTotals') }}",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {

            },
            success: function(data) {


                if (data.status == 'true') {
                    var bnames = data.bnames;



                    var bvalues = data.bvalues;
                    var mbvalues = data.mbvalues;
                    var mmvalues = data.mmvalues;
                    var bcolors = data.bcolors;

                    var mnames = data.mnames;
                    var mvalues = data.mvalues;
                    var mcolors = data.mcolors;


                    new Chart(mainctx, {
                        type: 'bar',
                        data: {
                            labels: chartmonths.slice(1),
                            datasets: [{
                                    label: '{{ __('No of Bookings') }}',
                                    data: mbvalues.slice(1),

                                    backgroundColor: '#8A1538'
                                },
                                {
                                    label: '{{ __('No of Maintenance') }}',
                                    data: mmvalues.slice(1),

                                    backgroundColor: 'grey'
                                },
                            ]
                        },
                        options: {
                            plugins: {
                                legend: {
                                    labels: {
                                        // This more specific font property overrides the global property
                                        font: {
                                            family: "Lusail",
                                            size: 14
                                        }
                                    }
                                }
                            },
                        },
                    });
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: bnames,
                            datasets: [{
                                label: '{{ __('No of Bookings') }}',
                                data: bvalues,

                                backgroundColor: bcolors
                            }]
                        },

                        options: {
                            plugins: {
                                legend: {
                                    labels: {
                                        // This more specific font property overrides the global property
                                        font: {
                                            family: "Lusail",
                                            size: 14
                                        }
                                    }
                                }
                            },
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });


                    new Chart(ctx2, {
                        type: 'doughnut',
                        data: {
                            labels: mnames,
                            datasets: [{
                                label: '{{ __('No of Maintenance') }}',
                                data: mvalues,
                                borderWidth: 1,
                                backgroundColor: mcolors
                            }]
                        },

                        options: {
                            plugins: {
                                legend: {
                                    labels: {
                                        // This more specific font property overrides the global property
                                        font: {
                                            family: "Lusail",
                                            size: 14
                                        }
                                    }
                                }
                            },
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    display: false,

                                },
                                y: {
                                    display: false,

                                }
                            }
                        }
                    });
                }

            },
            error: function() {
                return 'error';
            }
        });
    </script>
@endif
<script>
    $(".changeReq").change(function() {

        var newvalue = $(this).prop("checked");
        var id = $(this).data('id');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'POST',
            url: ' {{ route('changeReq') }}',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                id: id,
                newvalue: newvalue
            },
            success: function(data) {
                Swal.fire({
                    toast: true,
                    position: "top-start",
                    icon: "success",
                    title: "{{ __('Updated') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            error: function(error) {
                Swal.fire({
                    toast: true,
                    position: "top-start",
                    icon: "error",
                    title: "{{ __('Something Wrong') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });


    });
    $(document).ready(function() {
        $('.EditAttach').click(function() {
            var arname = $(this).attr('arname');
            var enname = $(this).attr('enname');
            var accept = $(this).attr('accept');
            var id = $(this).attr('id');
            var max = $(this).attr('max');

            $("#attachid").val(id);
            $("#attachmax").val(max);
            $("#attacharname").val(arname);
            $("#attachenname").val(enname);
            var valuesArray = accept.split(',');
            $('#attachaccept').val(valuesArray).trigger('change');

        });

        $('.EditFacilityType').click(function() {

            var id = $(this).attr('id');
            var arname = $(this).attr('arname');
            var enname = $(this).attr('enname');
            $("#facilitytypeid").val(id);
            $("#facilitytypearname").val(arname);
            $("#facilitytypeenname").val(enname);
        });
        $('.EditSubFacilityType').click(function() {
            var id = $(this).attr('id');
            var arname = $(this).attr('arname');
            var enname = $(this).attr('enname');
            $("#subfacilitytypeid").val(id);
            $("#subfacilitytypearname").val(arname);
            $("#subfacilitytypeenname").val(enname);
        });
    });
</script>
