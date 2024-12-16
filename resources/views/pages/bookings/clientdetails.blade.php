@extends('layouts.app')

@section('content')
    <div class="wrapper">

        @include('layouts.sidebar')
        <div class="iq-top-navbar-{{ app()->getLocale() }}">
            @include('layouts.header')
        </div>
        <div class="content-page">
            @php
                $disabled = $booking->status == '0' ? '' : 'disabled';
            @endphp
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-header shadow-bottom d-flex align-items-center justify-content-between">
                            <a href="{{ route('mybookings') }}"
                                class="btn btn-outline-info"><back-icon></back-icon>{{ __('Go Back') }} </a>
                            <div class="text-center">
                                <h3 class="text-center">{{ __('Request Details') }} #{{ $booking->number }} </h3>


                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <small>{{ __('Created At') }} : <b>{{ $booking->created_at }}</b> <br>
                                    {!! $booking->htmlstatus !!}</small>
                            </div>

                        </div>
                        <div class="card-body">
                            <form action="{{ route('booking.edit') }}" enctype="multipart/form-data" method="post">
                                @csrf
                                <input type="hidden" id="subs" name="subs"
                                    value="{{ $booking->sub_facility_ids }}">
                                <input type="hidden" name="number" value="{{ $booking->number }}">
                                <input type="hidden" name="id" value="{{ $booking->id }}">
                                <div class="row p-2">
                                    <div class="col-md-4">
                                        <label for="">{{ __('Event') }}</label>
                                        <input type="text" name="event_name" {{ $disabled }}
                                            class="form-control required" value="{{ $booking->event_name }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">{{ __('Facility') }}</label>
                                        <input type="text" name="facility" disabled class="form-control required"
                                            value="{{ $booking->facility->title }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">{{ __('Requierd Sub Facilities') }}</label>
                                        <div class="row d-flex justify-content-start align-items-center">
                                            @php
                                                $ids = explode(',', $booking->sub_facility_ids);
                                            @endphp

                                            @foreach (\App\Models\SubFacility::where('facility_id', $booking->facility_id)->get() as $sub)
                                                @if ($sub->status == '1')
                                                    <div class="d-flex">
                                                        <input id="{{ $sub->id }}" {{ $disabled }}
                                                            @if (in_array($sub->id, $ids)) checked @endif
                                                            class="form-control subFa smallcheck" type="checkbox"><span
                                                            class="space">
                                                            {{ $sub->getTranslation('title', app()->getlocale()) }} </span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>




                                </div>
                                <div class="row p-2">
                                    <div class="col-md-2">
                                        <label for="">{{ __('Expected Participants No') }}</label>
                                        <input type="text" name="particpations" class="form-control required"
                                            value="{{ $booking->particpations }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">{{ __('Days') }}</label>
                                        <input type="text" name="days" id="daysCount" readonly
                                            class="form-control required" value="{{ $booking->days }}">
                                    </div>
                                    <div class="col-md-6">


                                        <div id="timming" class=" rounded">
                                            <div class="d-flex">
                                                <div class="col-md-6">
                                                    <label for="">{{ __('From Date') }}</label>
                                                    <input type="text" name="start" id="startDate"
                                                        class="form-control required" value="{{ $booking->fullstart }}"
                                                        placeholder="{{ __('Select Date and Time') }}">

                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">{{ __('To Date') }}</label>
                                                    <input type="text" name="end" id="endDate"
                                                        class="form-control required" value="{{ $booking->fullend }}"
                                                        placeholder="{{ __('Select Date and Time') }}">
                                                </div>

                                            </div>
                                            <div class="p-3" id="timmingtext" style="color: red;display:none">
                                                {{ __('Sorry there is event') }}
                                            </div>
                                        </div>
                                    </div>



                                </div>

                                <div class="row p-2">
                                    <div class="col-md-4">
                                        <label for=""></label>
                                        <input type="text" name="cname" class=" form-control required"
                                            value="{{ $booking->cname }}" {{ $disabled }}>
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""></label>
                                        <input type="text" name="cemail" class=" form-control required"
                                            value="{{ $booking->cemail }}" {{ $disabled }}>
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""></label>
                                        <input type="text" name="cphone" class=" form-control required"
                                            value="{{ $booking->cphone }}" {{ $disabled }}>
                                    </div>
                                </div>
                                <div class="row p-2">
                                    <label for="">{{ __('Notes') }}</label>
                                    <textarea name="notes" {{ $disabled }} class="form-control required ">{!! $booking->notes !!}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <label for="">{{ __('Attachments') }}</label>
                                            </div>
                                            <div class="card-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>{{ __('Name') }}</th>
                                                            <th>{{ __('File') }}</th>
                                                            @if (!$disabled)
                                                                <th> <small
                                                                        class="text-primary">{{ __('Leave It Empty if you dont want to change it') }}</small>
                                                                </th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $bookingFiles = $booking->files->keyBy('attachId');
                                                        @endphp

                                                        @foreach (App\Models\Attachment::where('status', '1')->get() as $f => $item)
                                                            @php
                                                                $isAttached = $bookingFiles->has($item->id);
                                                                $fileName =
                                                                    $bookingFiles->get($item->id)->filename ?? '';
                                                                $fileUrl = $bookingFiles->get($item->id)->url ?? '';

                                                            @endphp
                                                            <tr>
                                                                <td>{{ $f + 1 }}</td>
                                                                <td> <label
                                                                        class="{{ $item->required == '1' ? 'required-label' : '' }}"
                                                                        for="">{{ $item->name }}</label></td>

                                                                <td>
                                                                    @if ($isAttached)
                                                                        @php
                                                                            $extension =
                                                                                pathinfo(
                                                                                    $fileUrl,
                                                                                    PATHINFO_EXTENSION,
                                                                                ) ?? 'unknown';
                                                                        @endphp
                                                                        <button type="button" title={{ $fileName }}"
                                                                            class="btn filebtn "
                                                                            extension="{{ $extension }}"
                                                                            filepath = "{{ $fileUrl }}">
                                                                            @switch($extension)
                                                                                @case('rar')
                                                                                @case('zip')
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        viewBox="0 0 24 24" width="24"
                                                                                        height="24" fill="rgba(127,127,127,1)">
                                                                                        <path
                                                                                            d="M20 22H4C3.44772 22 3 21.5523 3 21V3C3 2.44772 3.44772 2 4 2H20C20.5523 2 21 2.44772 21 3V21C21 21.5523 20.5523 22 20 22ZM19 20V4H5V20H19ZM14 12V17H10V14H12V12H14ZM12 4H14V6H12V4ZM10 6H12V8H10V6ZM12 8H14V10H12V8ZM10 10H12V12H10V10Z">
                                                                                        </path>
                                                                                    </svg>
                                                                                @break

                                                                                @case('pdf')
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        viewBox="0 0 24 24" width="24"
                                                                                        height="24" fill="rgba(127,127,127,1)">
                                                                                        <path
                                                                                            d="M5 4H15V8H19V20H5V4ZM3.9985 2C3.44749 2 3 2.44405 3 2.9918V21.0082C3 21.5447 3.44476 22 3.9934 22H20.0066C20.5551 22 21 21.5489 21 20.9925L20.9997 7L16 2H3.9985ZM10.4999 7.5C10.4999 9.07749 10.0442 10.9373 9.27493 12.6534C8.50287 14.3757 7.46143 15.8502 6.37524 16.7191L7.55464 18.3321C10.4821 16.3804 13.7233 15.0421 16.8585 15.49L17.3162 13.5513C14.6435 12.6604 12.4999 9.98994 12.4999 7.5H10.4999ZM11.0999 13.4716C11.3673 12.8752 11.6042 12.2563 11.8037 11.6285C12.2753 12.3531 12.8553 13.0182 13.5101 13.5953C12.5283 13.7711 11.5665 14.0596 10.6352 14.4276C10.7999 14.1143 10.9551 13.7948 11.0999 13.4716Z">
                                                                                        </path>
                                                                                    </svg>
                                                                                @break

                                                                                @case('docx')
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        viewBox="0 0 24 24" width="24"
                                                                                        height="24" fill="rgba(127,127,127,1)">
                                                                                        <path
                                                                                            d="M16 8V16H14L12 14L10 16H8V8H10V13L12 11L14 13V8H15V4H5V20H19V8H16ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z">
                                                                                        </path>
                                                                                    </svg>
                                                                                @break

                                                                                @case('xls')
                                                                                @case('xlsx')
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        viewBox="0 0 24 24" width="24"
                                                                                        height="24" fill="rgba(127,127,127,1)">
                                                                                        <path
                                                                                            d="M13.2 12L16 16H13.6L12 13.7143L10.4 16H8L10.8 12L8 8H10.4L12 10.2857L13.6 8H15V4H5V20H19V8H16L13.2 12ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z">
                                                                                        </path>
                                                                                    </svg>
                                                                                @break

                                                                                @case('png')
                                                                                @case('jpg')
                                                                                @case('jpeg')
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        viewBox="0 0 24 24" width="24"
                                                                                        height="24" fill="rgba(127,127,127,1)">
                                                                                        <path
                                                                                            d="M15 8V4H5V20H19V8H15ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918ZM11 9.5C11 10.3284 10.3284 11 9.5 11C8.67157 11 8 10.3284 8 9.5C8 8.67157 8.67157 8 9.5 8C10.3284 8 11 8.67157 11 9.5ZM17.5 17L13.5 10L8 17H17.5Z">
                                                                                        </path>
                                                                                    </svg>
                                                                                @break

                                                                                @default
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        viewBox="0 0 24 24" width="24"
                                                                                        height="24" fill="rgba(127,127,127,1)">
                                                                                        <path
                                                                                            d="M13 12H16L12 16L8 12H11V8H13V12ZM15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z">
                                                                                        </path>
                                                                                    </svg>
                                                                            @endswitch
                                                                        </button>
                                                                    @else
                                                                        {{ __('File No Attached') }}
                                                                    @endif
                                                                </td>

                                                                @if (!$disabled)
                                                                    <td> <input type="file"
                                                                            accept="{{ $item->accept }}"
                                                                            max="{{ $item->max }}"
                                                                            class="form-control {{ !$isAttached && $item->required == '1' ? 'required' : '' }}"
                                                                            name="attach_file{{ $item->id }}"
                                                                            id="">
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($booking->status == '0')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    {{ __('Comment') }}
                                                </div>
                                                <div class="card-body">
                                                    <div class="row p-2">
                                                        {!! $booking->reject_comment !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="editbtn" class="row p-2">
                                        <button type="submit"
                                            class="btn btn-block btn-outline-warning">{{ __('Edit') }}</button>
                                    </div>
                                @endif
                            </form>


                        </div>
                    </div>

                </div>




            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="return_booking_model">
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bttom">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title"> {{ __('Return Booking Requeset') }} </h3>
                </div>
                <div class="modal-body">
                    <form action="{{ route('booking.reject') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $booking->id }}" id="">
                        <input type="hidden" name="number" value="{{ $booking->number }}" id="">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">{{ __('Comment') }}</label>
                                <textarea name="reject_reason" class="form-control required  " id=""></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-block btn-danger m-3">{{ __('Send') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        var start = "{{ $booking->fullstart }}";
        var end = "{{ $booking->fullend }}";
        var startdatepicker = flatpickr("#startDate", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            onChange: function(selectedDates, dateStr, instance) {
                start = dateStr;
                if (dateStr > end) {
                    end = dateStr;
                    enddatepicker.setDate(dateStr);
                }

                enddatepicker.set('minDate', dateStr);
                checkTimming();
            },
        });
        var enddatepicker = flatpickr("#endDate", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            onChange: function(selectedDates, dateStr, instance) {
                end = dateStr;
                checkTimming();
            },
        });

        function calculateDaysDifference() {
            if (start && end) {
              
                var timeDifference = parseDateTime(end).getTime() - parseDateTime(start).getTime();
                var days = Math.ceil(timeDifference / (1000 * 3600 * 24)) + 1;
                $("#daysCount").val(days);
            }
        }

        function parseDateTime(dateTimeStr) {
            return new Date(dateTimeStr.replace(/-/g, '/')); // Replace '-' with '/' for compatibility with Date object
        }

        function checkTimming() {
            calculateDaysDifference();
            $("#timming").css('border', '');
            $("#timmingtext").hide();
            if (start != '' && end != '') {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('bookings.checkAvailablity') }}",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        faid: {{ $booking->facility->id }},
                        bid: {{ $booking->id }},
                        startDate: start,
                        endDate: end,
                    },
                    success: function(data) {
                        Swal.hideLoading();
                        if (data.status == 'true') {
                            $(this).css('border', '');
                            $("#editbtn").show();
                        } else {
                            $("#timming").css('border', '1px solid red').focus();
                            $("#timmingtext").show();
                            $("#editbtn").hide();
                        }
                    },
                    error: function() {
                      
                    }
                });
            }


        }
    </script>
@endsection
