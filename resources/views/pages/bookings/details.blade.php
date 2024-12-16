@extends('layouts.app')

@section('content')
    <div class="wrapper">

        @include('layouts.sidebar')
        <div class="iq-top-navbar-{{ app()->getLocale() }}">
            @include('layouts.header')
        </div>
        <div class="content-page">
            <div class="container-fluid">

                <div class="card-header shadow-bottom d-flex align-items-center justify-content-between">
                    <a href="{{ route('bookings') }}" class="btn btn-outline-info"><back-icon></back-icon>{{ __('Go Back') }}
                    </a>
                    <div class="text-center">
                        <h3 class="text-center">{{ $booking->event_name }}
                            #{{ $booking->number }} </h3>
                        <p class="text-center">
                            {{ __('Days') }} &nbsp; <b>{{ $booking->days }} &nbsp;&nbsp;</b> :
                            {{ __('From Date') }} &nbsp;&nbsp;&nbsp; <b>{{ $booking->fullstart }} &nbsp;&nbsp;</b>
                            {{ __('To Date') }} &nbsp;&nbsp;&nbsp; <b> {{ $booking->fullend }}</b>
                        </p>
                        <p class="text-center">

                        </p>
                    </div>

                    <div class="d-flex">


                    </div>

                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6 ">
                            <div class="card ">
                                <div class="card-header d-flex justify-content-between">
                                    <h4>{{ __('Request Details') }}</h4>
                                    <div class="text-center">
                                        {!! $booking->htmlstatus !!}
                                        @if ($booking->status == '0')
                                            <br>
                                            <div class="badge text-center">
                                                {{ $booking->reject_comment }}
                                            </div>
                                        @endif
                                    </div>
                                    <small>{{ __('Request Date') }} {{ $booking->created_at }}</small>
                                </div>
                                <div class="card-body">
                                    <h6>{{ __('Requester Details') }}</h6>
                                    <div class="d-flex justify-content-between p-1 text-center">
                                        @php
                                            $req = $booking->UserOrClient();

                                        @endphp
                                        @if ($req)
                                            <small>{{ __('Number') }} :
                                                {{ $req->number ?? $req->usernumber }}</small>
                                            <small>{{ __('Name') }} : {{ $req->displayname }}</small>
                                            <small>{{ __('Email') }} : {{ $req->email }}</small>
                                            <small>{{ __('Phone') }} : {{ $req->phone }}</small>
                                        @else
                                            <p>{{ __('Sorry Couldnt get User Data') }}</small>
                                        @endif

                                    </div>
                                    <h6>{{ __('Contact Information') }}</h6>

                                    <div class="d-flex justify-content-between p-1">
                                        <small>{{ __('Name') }} : {{ $booking->cname }}</small>
                                        <small>{{ __('Email') }} : {{ $booking->cemail }}</small>
                                        <small>{{ __('Phone') }} : {{ $booking->cphone }}</small>
                                    </div>
                                    <h6>{{ __('Attachments') }}</h6>
                                    <div class="d-flex justify-content-evenly m-1 p-1">
                                        @if (count($booking->files) > 0)
                                            @foreach ($booking->files as $file)
                                                @php
                                                    $extension = pathinfo($file->url, PATHINFO_EXTENSION) ?? 'unknown';
                                                @endphp
                                                <button class="btn m-1 filebtn btn-outline-success"
                                                    extension="{{ $extension }}" filepath = "{{ $file->url }}">
                                                    @switch($extension)
                                                        @case('rar')
                                                        @case('zip')
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="24" height="24" fill="rgba(127,127,127,1)">
                                                                <path
                                                                    d="M20 22H4C3.44772 22 3 21.5523 3 21V3C3 2.44772 3.44772 2 4 2H20C20.5523 2 21 2.44772 21 3V21C21 21.5523 20.5523 22 20 22ZM19 20V4H5V20H19ZM14 12V17H10V14H12V12H14ZM12 4H14V6H12V4ZM10 6H12V8H10V6ZM12 8H14V10H12V8ZM10 10H12V12H10V10Z">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @case('pdf')
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="24" height="24" fill="rgba(127,127,127,1)">
                                                                <path
                                                                    d="M5 4H15V8H19V20H5V4ZM3.9985 2C3.44749 2 3 2.44405 3 2.9918V21.0082C3 21.5447 3.44476 22 3.9934 22H20.0066C20.5551 22 21 21.5489 21 20.9925L20.9997 7L16 2H3.9985ZM10.4999 7.5C10.4999 9.07749 10.0442 10.9373 9.27493 12.6534C8.50287 14.3757 7.46143 15.8502 6.37524 16.7191L7.55464 18.3321C10.4821 16.3804 13.7233 15.0421 16.8585 15.49L17.3162 13.5513C14.6435 12.6604 12.4999 9.98994 12.4999 7.5H10.4999ZM11.0999 13.4716C11.3673 12.8752 11.6042 12.2563 11.8037 11.6285C12.2753 12.3531 12.8553 13.0182 13.5101 13.5953C12.5283 13.7711 11.5665 14.0596 10.6352 14.4276C10.7999 14.1143 10.9551 13.7948 11.0999 13.4716Z">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @case('docx')
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="24" height="24" fill="rgba(127,127,127,1)">
                                                                <path
                                                                    d="M16 8V16H14L12 14L10 16H8V8H10V13L12 11L14 13V8H15V4H5V20H19V8H16ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @case('xls')
                                                        @case('xlsx')
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="24" height="24" fill="rgba(127,127,127,1)">
                                                                <path
                                                                    d="M13.2 12L16 16H13.6L12 13.7143L10.4 16H8L10.8 12L8 8H10.4L12 10.2857L13.6 8H15V4H5V20H19V8H16L13.2 12ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @case('png')
                                                        @case('jpeg')
                                                        @case('jpg')
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="24" height="24" fill="rgba(127,127,127,1)">
                                                                <path
                                                                    d="M15 8V4H5V20H19V8H15ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918ZM11 9.5C11 10.3284 10.3284 11 9.5 11C8.67157 11 8 10.3284 8 9.5C8 8.67157 8.67157 8 9.5 8C10.3284 8 11 8.67157 11 9.5ZM17.5 17L13.5 10L8 17H17.5Z">
                                                                </path>
                                                            </svg>
                                                        @break

                                                        @default
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="24" height="24" fill="rgba(127,127,127,1)">
                                                                <path
                                                                    d="M13 12H16L12 16L8 12H11V8H13V12ZM15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z">
                                                                </path>
                                                            </svg>
                                                    @endswitch
                                                    {{ $file->filename }}
                                                </button>
                                            @endforeach
                                        @else
                                            <p>{{ __('No Attachment') }}</p>
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6  ">
                            <div class=" card p-3">
                                <div class="text-center">
                                    <label class="text-primary text-center"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                            <path
                                                d="M21 19H23V21H1V19H3V4C3 3.44772 3.44772 3 4 3H14C14.5523 3 15 3.44772 15 4V19H19V11H17V9H20C20.5523 9 21 9.44772 21 10V19ZM5 5V19H13V5H5ZM7 11H11V13H7V11ZM7 7H11V9H7V7Z">
                                            </path>
                                        </svg> {{ __('Facility') }} : {{ $booking->facility->title }} </label>
                                </div>
                                <div class=" p-3">
                                    <label class="text-primary"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            width="24" height="24" fill="currentColor">
                                            <path
                                                d="M8.00008 6V9H5.00008V6H8.00008ZM3.00008 4V11H10.0001V4H3.00008ZM13.0001 4H21.0001V6H13.0001V4ZM13.0001 11H21.0001V13H13.0001V11ZM13.0001 18H21.0001V20H13.0001V18ZM10.7072 16.2071L9.29297 14.7929L6.00008 18.0858L4.20718 16.2929L2.79297 17.7071L6.00008 20.9142L10.7072 16.2071Z">
                                            </path>
                                        </svg> {{ __('Requierd Sub Facilities') }} :
                                        {{ $booking->facility->title }}
                                    </label>
                                    <ul>
                                        @php
                                            $ids = explode(',', $booking->sub_facility_ids);

                                        @endphp
                                        @foreach (\App\Models\SubFacility::whereIn('id', $ids)->get() as $sub)
                                            <li>{{ $sub->title }}</li>
                                        @endforeach
                                    </ul>

                                </div>
                                <div class=" p-3">
                                    <p class="text-primary"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            width="24" height="24" fill="currentColor">
                                            <path
                                                d="M17.5858 5H14V3H21V10H19V6.41421L14.7071 10.7071L13.2929 9.29289L17.5858 5ZM3 14H5V17.5858L9.29289 13.2929L10.7071 14.7071L6.41421 19H10V21H3V14Z">
                                            </path>
                                        </svg> {{ __('Capacity') }} :
                                        <b> {{ $booking->facility->capacity }}</b>
                                    </p>
                                    <p class="text-danger"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            width="24" height="24" fill="currentColor">
                                            <path
                                                d="M9.55 11.5C8.30736 11.5 7.3 10.4926 7.3 9.25C7.3 8.00736 8.30736 7 9.55 7C10.7926 7 11.8 8.00736 11.8 9.25C11.8 10.4926 10.7926 11.5 9.55 11.5ZM10 19.748V16.4C10 15.9116 10.1442 15.4627 10.4041 15.0624C10.1087 15.0213 9.80681 15 9.5 15C7.93201 15 6.49369 15.5552 5.37091 16.4797C6.44909 18.0721 8.08593 19.2553 10 19.748ZM4.45286 14.66C5.86432 13.6168 7.61013 13 9.5 13C10.5435 13 11.5431 13.188 12.4667 13.5321C13.3447 13.1888 14.3924 13 15.5 13C17.1597 13 18.6849 13.4239 19.706 14.1563C19.8976 13.4703 20 12.7471 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 12.9325 4.15956 13.8278 4.45286 14.66ZM18.8794 16.0859C18.4862 15.5526 17.1708 15 15.5 15C13.4939 15 12 15.7967 12 16.4V20C14.9255 20 17.4843 18.4296 18.8794 16.0859ZM12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM15.5 12.5C14.3954 12.5 13.5 11.6046 13.5 10.5C13.5 9.39543 14.3954 8.5 15.5 8.5C16.6046 8.5 17.5 9.39543 17.5 10.5C17.5 11.6046 16.6046 12.5 15.5 12.5Z">
                                            </path>
                                        </svg> {{ __('Expected Participants No') }} :
                                        {{ $booking->particpations }}
                                    </p>



                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4> {{ __('Notes') }}</h4>
                                </div>
                                <div class=" card-body">
                                    <p> {{ $booking->notes }} </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    {{ __('Same Month Bookings') }}
                                </div>
                                <div class="card-body ">
                                    @if (count($otherBookings) > 0)
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    {{-- <th>#</th> --}}
                                                    <th>{{ __('Created At') }}</th>
                                                    <th>{{ __('Requester') }}</th>
                                                    <th>{{ __('Event') }}</th>
                                                    <th>{{ __('From Date') }}</th>
                                                    <th>{{ __('To Date') }}</th>
                                                    <th>{{ __('Status') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($otherBookings as $b => $book)
                                                    @php
                                                        $reqester = $book->UserOrClient();
                                                    @endphp
                                                    <tr>
                                                        {{-- <td>{{ $b + 1 }}</td> --}}
                                                        <td>{{ $book->created_at }}</td>
                                                        <td>{{ $reqester->displayname }}</td>
                                                        <td>{{ $book->event_name }} #{{ $book->number }}</td>
                                                        <td>{{ $book->fullstart }}</td>
                                                        <td>{{ $book->fullend }}</td>
                                                        <td>{!! $book->htmlstatus !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p>{{ __('No Month Bookings') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6  ">
                            <div class="card">
                                <div class="card-header">
                                    {{ __('Same Month Maintenance') }}
                                </div>
                                <div class="card-body">

                                    @if (count($otherMaintenance) > 0)
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('Created At') }}</th>
                                                    <th>{{ __('Maintenance Agenda') }}</th>
                                                    <th>{{ __('Requester') }}</th>
                                                    <th>{{ __('From Date') }}</th>
                                                    <th>{{ __('To Date') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($otherMaintenance as $m => $min)
                                                    <tr>
                                                        <td>{{ $m + 1 }}</td>
                                                        <td>{{ $min->created_at }}</td>
                                                        <td>{{ $min->user->displayname }}</td>
                                                        <td>{{ $min->description }}</td>
                                                        <td>{{ $min->startDate }}</td>
                                                        <td>{{ $min->endDate }}</td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p>{{ __('No Month Maintenance') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4> {{ __('Assets Comment') }}</h4>
                                    @if (isset($assetsComment))
                                        <small> {{ $assetsComment->created_at }} </small>
                                    @endif
                                </div>
                                <div class="card-body">
                                    @if (isset($assetsComment))
                                        <p style="color: {{ $assetsComment->type == '1' ? 'green' : 'red' }}">
                                            {{ $assetsComment->comment }} </p><br>
                                    @else
                                        <p class="text-primary"><b> {{ __('Waiting') }} </b> </p><br>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4> {{ __('Facility Employee Comment') }}</h4>
                                    @if (isset($facilityComment))
                                        <small> {{ $facilityComment->created_at }} </small>
                                    @endif
                                </div>
                                <div class="card-body  ">
                                    @if (isset($facilityComment))
                                        <p style="color: {{ $facilityComment->type == '1' ? 'green' : 'red' }}">
                                            {{ $facilityComment->comment }} </p><br>
                                    @else
                                        <p class="text-primary"><b> {{ __('Waiting') }} </b> </p>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    @if (count($booking->comments)>0)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        {{ __('Employee Comments') }}
                                    </div>
                                    <div class="card-body">
                                        <div class="row p-2">
                                            @foreach ($booking->comments as $comment)
                                                @if ($comment->userlevel != '2' && $comment->userlevel != '3')
                                                    <div class="card col-md-4 p-2">
                                                        <label for="">{{ __('Name') }} :
                                                            <b>{{ $comment->username }}
                                                                ({{ $comment->user->usertype }})
                                                            </b></label>
                                                        <p class="h6 text-center p-2">{{ $comment->comment }}</p>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($booking->canAct())
                        <div class="row p-4 m-5">
                            @if (auth()->user()->level == '1' || auth()->user()->level == '5')
                                <div class="{{ auth()->user()->level == '5' ? 'col-md-3' : 'col-md-6' }}">
                                    <button type="button" data-toggle-extra="tab" data-target="#return_booking_model"
                                        data-toggle="modal"
                                        class="btn btn-block btn-outline-warning">{{ __('Send Back To Edit') }}</button>
                                </div>
                                @if (auth()->user()->level == '5')
                                    <div class="col-md-3">
                                        <button type="button" data-toggle-extra="tab"
                                            data-target="#reject_booking_model" data-toggle="modal"
                                            class="btn btn-block btn-outline-danger">{{ __('Reject') }}</button>
                                    </div>
                                @endif
                            @else
                                <div class="col-md-6">
                                    <button type="button" data-toggle-extra="tab" data-target="#reject_booking_model"
                                        data-toggle="modal"
                                        class="btn btn-block btn-outline-danger">{{ __('Reject') }}</button>
                                </div>
                            @endif


                            <div class="col-md-6">
                                <button type="button" data-toggle-extra="tab" data-target="#approve_booking_model"
                                    data-toggle="modal"
                                    class="btn btn-block btn-outline-success">{{ __('Approve') }}</button>
                            </div>
                        </div>
                    @endif

                    @if ($booking->CanComment())
                        <div class="row p-4 m-5">


                            <div class="col-md-6">
                                <button type="button" data-toggle-extra="tab"
                                    data-target="#reject_comment_booking_model" data-toggle="modal"
                                    class="btn btn-block btn-outline-danger">{{ __('Reject') }}</button>
                            </div>


                            <div class="col-md-6">
                                <button type="button" data-toggle-extra="tab"
                                    data-target="#approve_comment_booking_model" data-toggle="modal"
                                    class="btn btn-block btn-outline-success">{{ __('Approve') }}</button>
                            </div>
                        </div>
                    @endif





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
                            @if (auth()->user()->level == '5')
                                <input type="hidden" name="toEdit" value="1">
                            @endif
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
        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="reject_booking_model">
            <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title"> {{ __('Reject Booking Requeset') }} </h3>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('booking.reject') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $booking->id }}" id="">
                            <input type="hidden" name="number" value="{{ $booking->number }}" id="">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">{{ __('Rejection Reason') }}</label>
                                    <textarea name="reject_reason" class="form-control required  " id=""></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-block btn-danger m-3">{{ __('Reject') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="approve_booking_model">
            <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title"> {{ __('Approve Booking Requeset') }} </h3>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('booking.approve') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $booking->id }}" id="">
                            <input type="hidden" name="number" value="{{ $booking->number }}" id="">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">{{ __('Comment') }}</label>
                                    <textarea name="comment" class="form-control required  " id=""></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-block btn-success m-3">{{ __('Approve') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="reject_comment_booking_model">
            <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title"> {{ __('Reject Booking Requeset') }} </h3>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('booking.approve') }}" method="post">
                            @csrf
                            <input type="hidden" name="type" value="2">
                            <input type="hidden" name="id" value="{{ $booking->id }}" id="">
                            <input type="hidden" name="number" value="{{ $booking->number }}" id="">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">{{ __('Rejection Reason') }}</label>
                                    <textarea name="comment" class="form-control required  " id=""></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-block btn-danger m-3">{{ __('Reject') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="approve_comment_booking_model">
            <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title"> {{ __('Approve Booking Requeset') }} </h3>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('booking.approve') }}" method="post">
                            @csrf
                            <input type="hidden" name="type" value="1">
                            <input type="hidden" name="id" value="{{ $booking->id }}" id="">
                            <input type="hidden" name="number" value="{{ $booking->number }}" id="">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">{{ __('Comment') }}</label>
                                    <textarea name="comment" class="form-control required  " id=""></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-block btn-success m-3">{{ __('Approve') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
