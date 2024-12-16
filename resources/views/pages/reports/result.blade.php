<style>
    table {
        border: 1px solid #f7f7f7 !important;
        border-radius: 5px !important;
    }

    th {
        word-wrap: break-word !important;
        font-size: 15px !important;
        padding: 3px !important;
        vertical-align: middle !important;

        color: #fff !important;
    }

    @media print {

        @page {
            size: landscape;
        }
    }
</style>
<div class="card">
    <div class="h-100">
        <div id="imageDiv" style="display: none">
            <div class="d-flex justify-content-center align-items-center p-3">
                <img style="height: 150px" src="{{ asset('assets/images/logo/msy_logo.png') }}" alt=""
                    srcset="">
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center p-3 ">
            <h4  style="line-height: 2"> {!! $title !!}</h4>
            @if (count($bookings) > 0 || count($maintenance))
                <button type="button" id="PrintReport" divname="ReportResult" fileName="MSY_REPORT_{{ now() }}"
                    class="btn btn-outline-primary">
                    {{ __('Print The Report') }}  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M17 2C17.5523 2 18 2.44772 18 3V7H21C21.5523 7 22 7.44772 22 8V18C22 18.5523 21.5523 19 21 19H18V21C18 21.5523 17.5523 22 17 22H7C6.44772 22 6 21.5523 6 21V19H3C2.44772 19 2 18.5523 2 18V8C2 7.44772 2.44772 7 3 7H6V3C6 2.44772 6.44772 2 7 2H17ZM16 17H8V20H16V17ZM20 9H4V17H6V16C6 15.4477 6.44772 15 7 15H17C17.5523 15 18 15.4477 18 16V17H20V9ZM8 10V12H5V10H8ZM16 4H8V7H16V4Z"></path></svg> </button>
            @endif
        </div>

        <div class="row">
            <div class="col-md-12 pr-3 pl-3">
                @if ($showBookings)
                    <div class="shadow  ">
                        <div class="d-flex justify-content-between align-items-center p-3 ">
                            <h6>{{ __('Bookings') }}</h6>
                            <button type="button" class="btn btn-outline-success ExportTable"
                                tableid="reportBookingsTable" filename="MSY_BookingReport_{{ now() }}">
                                {{ __('Save As Excel') }} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    width="24" height="24" fill="currentColor">
                                    <path
                                        d="M2.85858 2.87732L15.4293 1.0815C15.7027 1.04245 15.9559 1.2324 15.995 1.50577C15.9983 1.52919 16 1.55282 16 1.57648V22.4235C16 22.6996 15.7761 22.9235 15.5 22.9235C15.4763 22.9235 15.4527 22.9218 15.4293 22.9184L2.85858 21.1226C2.36593 21.0522 2 20.6303 2 20.1327V3.86727C2 3.36962 2.36593 2.9477 2.85858 2.87732ZM4 4.73457V19.2654L14 20.694V3.30599L4 4.73457ZM17 19H20V4.99997H17V2.99997H21C21.5523 2.99997 22 3.44769 22 3.99997V20C22 20.5523 21.5523 21 21 21H17V19ZM10.2 12L13 16H10.6L9 13.7143L7.39999 16H5L7.8 12L5 7.99997H7.39999L9 10.2857L10.6 7.99997H13L10.2 12Z">
                                    </path>
                                </svg> </button>
                        </div>
                        @if (count($bookings) == 0)
                            <div class="text-center p-5 m-5">
                                <b> {{ __('No Bookings Founded') }} </b>
                            </div>
                        @else
                            <div class="card-body p-2">
                                <table id="reportBookingsTable" class="table rounded">
                                    <thead>
                                        <th style=" background-color: #89173E !important;">#</th>
                                        <th style=" background-color: #89173E !important;">{{ __('Request Date') }}</th>
                                        <th style=" background-color: #89173E !important;">{{ __('Number') }}</th>
                                        @if (!isset($user) && !isset($client))
                                            <th style=" background-color: #89173E !important;"> {{ __('Booker Name') }}
                                            </th>
                                        @endif
                                        <th style=" background-color: #89173E !important;">{{ __('Event') }}</th>
                                        <th style=" background-color: #89173E !important;">
                                            {{ __('Contact Information') }}</th>
                                        <th style=" background-color: #89173E !important;">{{ __('From Date') }}</th>
                                        <th style=" background-color: #89173E !important;">{{ __('To Date') }}</th>
                                        <th style=" background-color: #89173E !important;">{{ __('Requierd Days No') }}
                                        </th>
                                        <th style=" background-color: #89173E !important;">
                                            {{ __('Expected Participants No') }}</th>

                                        <th style=" background-color: #89173E !important;">{{ __('Status') }}</th>

                                    </thead>
                                    <tbody>
                                        @foreach ($bookings as $i => $booking)
                                            <tr>

                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $booking->created_at }}</td>
                                                <td>{{ $booking->number }}</td>
                                                @if (!isset($user) && !isset($client))
                                                    <td>@php
                                                        $req = $booking->UserOrClient();

                                                    @endphp
                                                        @if ($req)
                                                            {{ $req->displayname }}
                                                        @else
                                                            <p>{{ __('Sorry Couldnt get User Data') }}</small>
                                                        @endif
                                                    </td>
                                                @endif
                                                <td>{{ $booking->event_name }}</td>
                                                <td>{{ $booking->cname }} <br> {{ $booking->cphone }} <br>
                                                    {{ $booking->cemail }} </td>
                                                <td>{{ $booking->start_date . ' ' . $booking->start_time }}
                                                </td>
                                                <td>{{ $booking->end_date . ' ' . $booking->end_time }}
                                                </td>
                                                <td>{{ $booking->days }}</td>
                                                <td>{{ $booking->particpations }}</td>
                                                <td> {!! $booking->fullhtmlstatus !!}
                                                </td>



                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>


                            </div>
                        @endif
                    </div>
                @endif
                <br>
                @if ($showMaintenance)
                    <div class="shadow p-3  ">
                        <div class="d-flex justify-content-between align-items-center p-3 ">
                            <h6>{{ __('Maintenance') }}</h6>
                            <button type="button" class="btn btn-outline-success ExportTable" tableid="reportMinTable"
                                filename="MSY_MaintenanceReport_{{ now() }}">
                                {{ __('Save As Excel') }} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    width="24" height="24" fill="currentColor">
                                    <path
                                        d="M2.85858 2.87732L15.4293 1.0815C15.7027 1.04245 15.9559 1.2324 15.995 1.50577C15.9983 1.52919 16 1.55282 16 1.57648V22.4235C16 22.6996 15.7761 22.9235 15.5 22.9235C15.4763 22.9235 15.4527 22.9218 15.4293 22.9184L2.85858 21.1226C2.36593 21.0522 2 20.6303 2 20.1327V3.86727C2 3.36962 2.36593 2.9477 2.85858 2.87732ZM4 4.73457V19.2654L14 20.694V3.30599L4 4.73457ZM17 19H20V4.99997H17V2.99997H21C21.5523 2.99997 22 3.44769 22 3.99997V20C22 20.5523 21.5523 21 21 21H17V19ZM10.2 12L13 16H10.6L9 13.7143L7.39999 16H5L7.8 12L5 7.99997H7.39999L9 10.2857L10.6 7.99997H13L10.2 12Z">
                                    </path>
                                </svg> </button>
                        </div>

                        @if (count($maintenance) == 0)
                            <div class="text-center p-5 m-5">
                                <b> {{ __('No Maintenance Founded') }} </b>
                            </div>
                        @else
                            <div class="card-body p-2">
                                <table id="reportMinTable" class="table rounded">
                                    <thead>
                                        <th style="background-color: #89173E !important;">#</th>
                                        <th style="background-color: #89173E !important;">{{ __('Created At') }}</th>
                                        <th style="background-color: #89173E !important;">{{ __('Number') }}</th>
                                        @if (!isset($facility)  || 1==1)
                                            <th style="background-color: #89173E !important;">{{ __('Facility') }}</th>
                                        @endif
                                        <th style=" background-color: #89173E !important;">{{ __('From Date') }}</th>
                                        <th style=" background-color: #89173E !important;">{{ __('To Date') }}</th>
                                        <th style=" background-color: #89173E !important;">{{ __('Days') }}</th>
                                        <th style=" background-color: #89173E !important;"> {{ __('Maintenance Agenda') }}</th>
                                        <th style=" background-color: #89173E !important;">{{ __('Maintenance Team') }} </th>

                                    </thead>
                                    <tbody>
                                        @foreach ($maintenance as $i => $min)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $min->created_at }}</td>
                                                <td>{{ $min->number }}</td>
                                                @if (!isset($facility) || 1==1)
                                                    <td>{{ $min->facility->title }}</td>
                                                @endif
                                                <td>{{ $min->startDate }}</td>
                                                <td>{{ $min->endDate }} </td>
                                                <td>{{ $min->days }} </td>
                                                <td>{{ $min->description }} </td>
                                                <td>{{ $min->team }} </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
