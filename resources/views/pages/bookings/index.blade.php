@extends('layouts.app')

@section('content')
    <div class="wrapper">
        @include('layouts.sidebar')
        <div class="iq-top-navbar-{{ app()->getLocale() }}">
            @include('layouts.header')
        </div>
        <div class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card blur-shadow">
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                                    <h5>{{ __('Bookings') }}</h5>
                                    <div class="col-md-4">
                                        @if ((auth()->check() && auth()->user()->level != 3) || auth()->guard('client')->check())
                                            <select id="FacilityFilter" name="facility" class="form-control select2">
                                                <option value="">{{ __('All Facilities') }} </option>
                                                @foreach (\App\Models\Facility::where('status', '1')->get() as $item)
                                                    <option
                                                        {{ app('request')->input('fa') == $item->number ? 'selected' : '' }}
                                                        value="{{ $item->number }}">{{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="list-grid-toggle d-flex align-items-center mr-3">
                                            <div data-toggle-extra="tab" data-target-extra="#grid"
                                                class="{{ $gridactive }}">
                                                <div class="grid-icon p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24" fill="currentColor">
                                                        <path
                                                            d="M17 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9V3H15V1H17V3ZM4 9V19H20V9H4ZM6 11H8V13H6V11ZM6 15H8V17H6V15ZM10 11H18V13H10V11ZM10 15H15V17H10V15Z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div data-toggle-extra="tab" data-target-extra="#list"
                                                class="{{ $listactive }}">
                                                <div class="grid-icon p-1">
                                                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <line x1="21" y1="10" x2="3" y2="10">
                                                        </line>
                                                        <line x1="21" y1="6" x2="3" y2="6">
                                                        </line>
                                                        <line x1="21" y1="14" x2="3" y2="14">
                                                        </line>
                                                        <line x1="21" y1="18" x2="3" y2="18">
                                                        </line>
                                                    </svg>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="grid" class="item-content animate__animated animate__fadeIn {{ $gridactive }}  "
                    data-toggle-extra="tab-content">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between shadow-bottom">
                            <div class="h6">
                                @if (auth()->check())
                                    {{ __('Bookings Calender') }}
                                @else
                                    {{ __('My Bookings Calender') }}
                                @endif

                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-8 shadow rounded h-100">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="#" id="cal-prev"
                                            class="text-dark mr-2 font-size-18"><back-c-icon></a>
                                        <h5 class="mh-3" id="calender_title"> </h5>
                                        <div class="mt-1">

                                            <a href="#" id="cal-next"
                                                class="text-dark font-size-18"><front-c-icon></a>
                                        </div>
                                    </div>
                                    <div id="bookingscalendar"></div>
                                </div>
                                <div class="col-md-4 " id="cardsSection">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="list" class="item-content animate__animated animate__fadeIn {{ $listactive }} "
                    data-toggle-extra="tab-content">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between shadow-bottom">
                            <div class="h6">
                                @if (auth()->check())
                                    {{ __('Bookings List') }}
                                @else
                                    {{ __('My Bookings List') }}
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        @if (count($bookings) == 0)
                                            <div class="text-center p-5 m-5">
                                                <b> {{ __('No Bookings') }} </b>
                                            </div>
                                        @else
                                            <div class="row">
                                                <div class="col-8">

                                                </div>
                                                <div class="col-md-4">
                                                    <input id="myInput" onkeyup="myFunction(1,[2,3,4,5,6]);"
                                                        type="text" placeholder="{{ __('Search') }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <br>
                                            <div class="card-body p-2">
                                                <table id="myTable" class="table rounded">
                                                    <thead>
                                                        <th>#</th>
                                                        <th>{{ __('Request Date') }}</th>
                                                        <th>{{ __('Number') }}</th>
                                                        <th>{{ __('Event') }}</th>
                                                        <th>{{ __('Contact Information') }}</th>
                                                        <th>{{ __('From Date') }}</th>
                                                        <th>{{ __('To Date') }}</th>
                                                        <th>{{ __('Requierd Days No') }}</th>
                                                        <th>{{ __('Expected Participants No') }}</th>
                                                        {{-- <th>{{ __('Requierd Sub Facilities') }}</th> --}}
                                                        <th>{{ __('Attachments') }}</th>
                                                        <th>{{ __('Status') }}</th>
                                                        <th></th>

                                                        <th> </th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($bookings as $i => $booking)
                                                            <tr>

                                                                <td>{{ $i + 1 }}</td>
                                                                <td>{{ $booking->created_at }}</td>
                                                                <td>{{ $booking->number }}</td>
                                                                <td>{{ $booking->event_name }}</td>
                                                                <td>{{ $booking->cname }} <br> {{ $booking->cphone }} <br>
                                                                    {{ $booking->cemail }} </td>
                                                                <td>{{ $booking->start_date . ' ' . $booking->start_time }}
                                                                </td>
                                                                <td>{{ $booking->end_date . ' ' . $booking->end_time }}
                                                                </td>
                                                                <td>{{ $booking->days }}</td>
                                                                <td>{{ $booking->particpations }}</td>
                                                                {{-- <td>
                                                                    @foreach ($booking->subs as $item)
                                                                        <p> {{ $item->title . ' : (' . $item->type . ')' }}
                                                                        </p>
                                                                    @endforeach
                                                                </td> --}}
                                                                <td>


                                                                    @foreach ($booking->files as $index => $file)
                                                                        @php
                                                                            $extension =
                                                                                pathinfo(
                                                                                    $file->url,
                                                                                    PATHINFO_EXTENSION,
                                                                                ) ?? 'unknown';
                                                                        @endphp

                                                                        <button title="{{ $file->filename }}"
                                                                            class="btn filebtn "
                                                                            extension={{ $extension }}
                                                                            filepath = "{{ $file->url }}">
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
                                                                                @case('jpeg')
                                                                                @case('jpg')
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
                                                                    @endforeach
                                                                </td>
                                                                <td> {!! $booking->fullhtmlstatus !!}
                                                                </td>
                                                                @if (auth()->check())
                                                                    <td>
                                                                        {{-- <button
                                                                    class="btn btn-outline-danger">{{ __('Reject') }}</button>
                                                                <button
                                                                    class="btn btn-outline-success">{{ __('Approve') }}</button> --}}
                                                                        <a href="{{ route('booking.details', $booking->number) }}"
                                                                            class="btn btn-outline-primary">{{ __('Details') }}</a>
                                                                    </td>
                                                                @endif
                                                                @if (auth()->guard('client')->check() && $booking->status != '5' && $booking->status != '6')
                                                                    <td>
                                                                        @if ($booking->status == '1')
                                                                            {{-- <button type="button"
                                                                                number = "{{ $booking->number }}"
                                                                                id = "{{ $booking->id }}"
                                                                                data-target="#edit_booking_model"
                                                                                data-toggle="modal"
                                                                                class="  btn   btn-outline-warning EditBooking">{{ __('Edit') }}</button> --}}
                                                                            <button type="button"
                                                                                number = "{{ $booking->number }}"
                                                                                id = "{{ $booking->id }}"
                                                                                data-target="#cancel_booking_model"
                                                                                data-toggle="modal"
                                                                                class="  btn   btn-outline-danger CancelBooking">{{ __('Cancel') }}</button>
                                                                        @endif

                                                                        {{-- 
                                                                    <button
                                                                        class="btn btn-outline-success">{{ __('Approve') }}</button> --}}
                                                                        <a href="{{ route('booking.details', $booking->number) }}"
                                                                            class="mt-2 btn btn-outline-primary">{{ __('Details') }}</a>
                                                                    </td>
                                                                @endif

                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>


                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="CancelBookingModel"></div>
    <div id="EditBookingModel"></div>
@endsection
