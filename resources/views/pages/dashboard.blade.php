@extends('layouts.app')

@section('content')
    <div class="wrapper">

        <div class="iq-top-navbar-{{ app()->getLocale() }}">
            @include('layouts.header')
        </div>
        <div class="content-page w-100 mr-0 ml-0">
            <div class="container-fluid">
                <!-- Trigger element -->
               

                <!-- Popover Content (you can place this anywhere in the document) -->
                

                <div class="text-center p-2">
                    <h1 class="headerText" for="">{{ __('Services Links') }}</h1>
                </div>
                <div class="row p-3">
                    <div class="col-md-2 ">
                        <div class="rounded card p-2 text-center clickableCard" data-url="{{ route('facilities') }}">
                            <div class="text-center">
                                <div class="border p-2 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64"
                                        height="64" fill="currentColor">
                                        <path
                                            d="M21 19H23V21H1V19H3V4C3 3.44772 3.44772 3 4 3H14C14.5523 3 15 3.44772 15 4V19H19V11H17V9H20C20.5523 9 21 9.44772 21 10V19ZM5 5V19H13V5H5ZM7 11H11V13H7V11ZM7 7H11V9H7V7Z">
                                        </path>
                                    </svg>
                                    <div class="p-2"></div>
                                    <h5>{{ __('Facilities') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <div class="rounded card p-2 text-center clickableCard" data-url="{{ route('bookings') }}">
                            <div class="text-center">
                                <div class="border p-2 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64"
                                        height="64" fill="currentColor">
                                        <path
                                            d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM11 13V17H6V13H11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z">
                                        </path>
                                    </svg>
                                    <div class="p-2"></div>
                                    <h5>{{ __('Bookings') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <div class="rounded card p-2 text-center clickableCard" data-url="{{ route('maintenance') }}">
                            <div class="text-center">
                                <div class="border p-2 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64"
                                        height="64" fill="currentColor">
                                        <path
                                            d="M7 3V1H9V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V9H20V5H17V7H15V5H9V7H7V5H4V19H10V21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7ZM17 12C14.7909 12 13 13.7909 13 16C13 18.2091 14.7909 20 17 20C19.2091 20 21 18.2091 21 16C21 13.7909 19.2091 12 17 12ZM11 16C11 12.6863 13.6863 10 17 10C20.3137 10 23 12.6863 23 16C23 19.3137 20.3137 22 17 22C13.6863 22 11 19.3137 11 16ZM16 13V16.4142L18.2929 18.7071L19.7071 17.2929L18 15.5858V13H16Z">
                                        </path>
                                    </svg>
                                    <div class="p-2"></div>
                                    <h5>{{ __('Maintenance') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <div class="rounded card p-2 text-center clickableCard" data-url="{{ route('reports') }}">
                            <div class="text-center">
                                <div class="border p-2 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64"
                                        height="64" fill="currentColor">
                                        <path
                                            d="M11 7H13V17H11V7ZM15 11H17V17H15V11ZM7 13H9V17H7V13ZM15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z">
                                        </path>
                                    </svg>
                                    <div class="p-2"></div>
                                    <h5>{{ __('Reports') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <div class="rounded card p-2 text-center clickableCard" data-url="{{ route('clients') }}">
                            <div class="text-center">
                                <div class="border p-2 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64"
                                        height="64" fill="currentColor">
                                        <path
                                            d="M8.5 7C8.5 8.10457 7.60457 9 6.5 9C5.39543 9 4.5 8.10457 4.5 7C4.5 5.89543 5.39543 5 6.5 5C7.60457 5 8.5 5.89543 8.5 7ZM2.5 7C2.5 9.20914 4.29086 11 6.5 11C8.70914 11 10.5 9.20914 10.5 7C10.5 4.79086 8.70914 3 6.5 3C4.29086 3 2.5 4.79086 2.5 7ZM9 16.5C9 15.1193 7.88071 14 6.5 14C5.11929 14 4 15.1193 4 16.5V19H9V16.5ZM11 21H2V16.5C2 14.0147 4.01472 12 6.5 12C8.98528 12 11 14.0147 11 16.5V21ZM19.5 7C19.5 8.10457 18.6046 9 17.5 9C16.3954 9 15.5 8.10457 15.5 7C15.5 5.89543 16.3954 5 17.5 5C18.6046 5 19.5 5.89543 19.5 7ZM13.5 7C13.5 9.20914 15.2909 11 17.5 11C19.7091 11 21.5 9.20914 21.5 7C21.5 4.79086 19.7091 3 17.5 3C15.2909 3 13.5 4.79086 13.5 7ZM20 16.5C20 15.1193 18.8807 14 17.5 14C16.1193 14 15 15.1193 15 16.5V19H20V16.5ZM13 19V16.5C13 14.0147 15.0147 12 17.5 12C19.9853 12 22 14.0147 22 16.5V21H13V19Z">
                                        </path>
                                    </svg>
                                    <div class="p-2"></div>
                                    <h5>{{ __('Clients') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <div class="rounded card p-2 text-center clickableCard"
                            data-url="{{ route('settings.notifications') }}">
                            <div class="text-center">
                                <div class="border p-2 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64"
                                        height="64" fill="currentColor">
                                        <path
                                            d="M2 11.9998C2 11.1353 2.1097 10.2964 2.31595 9.49631C3.40622 9.55283 4.48848 9.01015 5.0718 7.99982C5.65467 6.99025 5.58406 5.78271 4.99121 4.86701C6.18354 3.69529 7.66832 2.82022 9.32603 2.36133C9.8222 3.33385 10.8333 3.99982 12 3.99982C13.1667 3.99982 14.1778 3.33385 14.674 2.36133C16.3317 2.82022 17.8165 3.69529 19.0088 4.86701C18.4159 5.78271 18.3453 6.99025 18.9282 7.99982C19.5115 9.01015 20.5938 9.55283 21.6841 9.49631C21.8903 10.2964 22 11.1353 22 11.9998C22 12.8643 21.8903 13.7032 21.6841 14.5033C20.5938 14.4468 19.5115 14.9895 18.9282 15.9998C18.3453 17.0094 18.4159 18.2169 19.0088 19.1326C17.8165 20.3043 16.3317 21.1794 14.674 21.6383C14.1778 20.6658 13.1667 19.9998 12 19.9998C10.8333 19.9998 9.8222 20.6658 9.32603 21.6383C7.66832 21.1794 6.18354 20.3043 4.99121 19.1326C5.58406 18.2169 5.65467 17.0094 5.0718 15.9998C4.48848 14.9895 3.40622 14.4468 2.31595 14.5033C2.1097 13.7032 2 12.8643 2 11.9998ZM6.80385 14.9998C7.43395 16.0912 7.61458 17.3459 7.36818 18.5236C7.77597 18.8138 8.21005 19.0652 8.66489 19.2741C9.56176 18.4712 10.7392 17.9998 12 17.9998C13.2608 17.9998 14.4382 18.4712 15.3351 19.2741C15.7899 19.0652 16.224 18.8138 16.6318 18.5236C16.3854 17.3459 16.566 16.0912 17.1962 14.9998C17.8262 13.9085 18.8225 13.1248 19.9655 12.7493C19.9884 12.5015 20 12.2516 20 11.9998C20 11.7481 19.9884 11.4981 19.9655 11.2504C18.8225 10.8749 17.8262 10.0912 17.1962 8.99982C16.566 7.90845 16.3854 6.65378 16.6318 5.47605C16.224 5.18588 15.7899 4.93447 15.3351 4.72552C14.4382 5.52844 13.2608 5.99982 12 5.99982C10.7392 5.99982 9.56176 5.52844 8.66489 4.72552C8.21005 4.93447 7.77597 5.18588 7.36818 5.47605C7.61458 6.65378 7.43395 7.90845 6.80385 8.99982C6.17376 10.0912 5.17754 10.8749 4.03451 11.2504C4.01157 11.4981 4 11.7481 4 11.9998C4 12.2516 4.01157 12.5015 4.03451 12.7493C5.17754 13.1248 6.17376 13.9085 6.80385 14.9998ZM12 14.9998C10.3431 14.9998 9 13.6567 9 11.9998C9 10.343 10.3431 8.99982 12 8.99982C13.6569 8.99982 15 10.343 15 11.9998C15 13.6567 13.6569 14.9998 12 14.9998ZM12 12.9998C12.5523 12.9998 13 12.5521 13 11.9998C13 11.4475 12.5523 10.9998 12 10.9998C11.4477 10.9998 11 11.4475 11 11.9998C11 12.5521 11.4477 12.9998 12 12.9998Z">
                                        </path>
                                    </svg>
                                    <div class="p-2"></div>
                                    <h5>{{ __('Settings') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>





                </div>
                <div class="text-center p-2">
                    <h1 class="headerText" for="">{{ __('Statistics') }}</h1>
                </div>
                <div class="p-2"></div>

                <div class="row">

                    <div class="col-md-6 col-lg-3">
                        <div class="   card card-block card-stretch card-height">
                            <div class="card-body justify-content-between d-flex align-items-center transparent"
                                style="background-color: transparent">
                                <div class="p-2">
                                    <h5>{{ __('Count Of Facilities') }}</h5>
                                    <br>
                                    <h3><span class="counter"
                                            style="visibility: visible;">{{ \App\Models\Facility::count() }}</span>
                                        {{ \App\Models\Utility::getFacCount(\App\Models\Facility::count()) }}</h3>
                                </div>

                                <span class="badge badge-primary"><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" width="48" height="48" fill="currentColor">
                                        <path
                                            d="M21 19H23V21H1V19H3V4C3 3.44772 3.44772 3 4 3H14C14.5523 3 15 3.44772 15 4V19H19V11H17V9H20C20.5523 9 21 9.44772 21 10V19ZM5 5V19H13V5H5ZM7 11H11V13H7V11ZM7 7H11V9H7V7Z">
                                        </path>
                                    </svg></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body justify-content-between d-flex align-items-center">
                                <div class="p-2">
                                    <h5>{{ __('Confirmed Bookings') }}</h5>
                                    <br>
                                    <h3><span class="counter"
                                            style="visibility: visible;">{{ \App\Models\Booking::where('status', '4')->count() }}</span>
                                        {{ \App\Models\Utility::getBookingsCount(\App\Models\Booking::where('status', '4')->count()) }}
                                    </h3>
                                </div>

                                <span class="badge badge-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48"
                                        height="48" fill="currentColor">
                                        <path
                                            d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 10H4V19H20V10ZM15.0355 11.136L16.4497 12.5503L11.5 17.5L7.96447 13.9645L9.37868 12.5503L11.5 14.6716L15.0355 11.136ZM7 5H4V8H20V5H17V6H15V5H9V6H7V5Z">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body justify-content-between d-flex align-items-center">
                                <div class="p-2">
                                    <h5>{{ __('Under Process Bookings') }}</h5>
                                    <br>
                                    <h3><span class="counter"
                                            style="visibility: visible;">{{ \App\Models\Booking::whereNotIn('status', [ '4','5','6','7'])->count() }}</span>
                                        {{ \App\Models\Utility::getBookingsCount(\App\Models\Booking::whereNotIn('status', [ '4','5','6','7'])->count()) }}
                                    </h3>
                                </div>

                                <span class="badge badge-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48"
                                        height="48" fill="currentColor">
                                        <path
                                            d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM8 13V15H6V13H8ZM13 13V15H11V13H13ZM18 13V15H16V13H18ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body justify-content-between d-flex align-items-center">
                                <div class="p-2">
                                    <h5>{{ __('Maintenance Work') }}</h5>
                                    <br>
                                    <h3><span class="counter"
                                            style="visibility: visible;">{{ \App\Models\Maintenance::where('status', '1')->count() }}</span>
                                        {{-- {{ \App\Models\Utility::getBookingsCount(\App\Models\Maintenance::where('status', '1')->count()) }} --}}
                                    </h3>
                                </div>

                                <span class="badge badge-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48"
                                        height="48" fill="currentColor">
                                        <path
                                            d="M9 3V1H7V3H3C2.44772 3 2 3.44772 2 4V20C2 20.5523 2.44772 21 3 21H21C21.5523 21 22 20.5523 22 20V4C22 3.44772 21.5523 3 21 3H17V1H15V3H9ZM4 10H20V19H4V10ZM4 5H7V6H9V5H15V6H17V5H20V8H4V5ZM9.87862 10.9644L12 13.0858L14.1212 10.9644L15.5355 12.3785L13.4142 14.5001L15.5354 16.6212L14.1213 18.0354L12 15.9143L9.87855 18.0354L8.46442 16.6211L10.5857 14.5001L8.46436 12.3785L9.87862 10.9644Z">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-6 ">
                        <div class="d-flex justify-content-between">
                            <div class="card p-3 w-50  ">
                                <p class="h6">{{ __('Bookings Count Per Facility') }}</p>
                                <div style="height: 350px">
                                    <canvas id="bookingsChart"></canvas>
                                </div>
                            </div>

                            <div class="card p-3 mr-3 ml-3 w-50">
                                <p class="h6">{{ __('Maintenance Count Per Facility') }}</p>
                                <div style="height: 350px">
                                    <canvas id="minChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="card shadow  p-3 ">
                            <p class="h6">{{ __('Month View For Bookings And Maintenance') }}</p>
                            <canvas style="height: 360px" id="bookingMinChart"></canvas>
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64"
                                            height="64" fill="currentColor">
                                            <path
                                                d="M21 19H23V21H1V19H3V4C3 3.44772 3.44772 3 4 3H14C14.5523 3 15 3.44772 15 4V19H19V11H17V9H20C20.5523 9 21 9.44772 21 10V19ZM5 5V19H13V5H5ZM7 11H11V13H7V11ZM7 7H11V9H7V7Z">
                                            </path>
                                        </svg>
                                        <h5>{{ __('Facilities') }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64"
                                            height="64" fill="currentColor">
                                            <path
                                                d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM11 13V17H6V13H11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z">
                                            </path>
                                        </svg>
                                        <h5>{{ __('Bookings') }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                </div>











                {{-- <div class="col-xl-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-header"> الحجوزات الأخيرة </div>
                            <div class="card-body">
                                <div class="card border-bottom shadow-none">
                                    @foreach (\App\Models\Booking::with(['user', 'facility'])->orderBy('created_at', 'DESC')->limit(3)->get() as $booking)
                                        <div class="rounded shadow m-2 card-list">
                                            <div class="card-body">
                                                <small style="color: grey;font-size:10px"> {{ $booking->created_at }}</small>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 style="color:{{ $booking->facility->color }}" class="mb-1">
                                                        {{ $booking->facility->title }}</h5>
                                                    <small class="mb-0"> {{ $booking->start_date }} --
                                                        {{ $booking->end_date }}</small>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="mb-1">{{ $booking->event_name }}</p>
                                                    <small class="mb-0">
                                                        {{ $booking->cname }}<br>{{ $booking->cphone }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach



                                </div>


                            </div>
                        </div>
                    </div> --}}

            </div>

        </div>
    </div>
    </div>
@endsection
