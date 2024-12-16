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
                                <div class="d-flex   align-items-center justify-content-between ">
                                    <div class="text-cetnter">
                                        <h5>{{ __('Reports') }}</h5>
                                    </div>

                                    <div class="d-flex align-items-center">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="FacilityFilter">{{ __('Facility') }} </label>
                                        <select class="form-control" id="ReportFacility">
                                            <option value="">{{ __('All Facilities') }} </option>
                                            @foreach (\App\Models\Facility::where('status', '1')->get() as $item)
                                                <option {{ app('request')->input('fa') == $item->number ? 'selected' : '' }}
                                                    value="{{ $item->number }}">{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="FacilityFilter">{{ __('Bookings - Maintenance') }} </label>
                                        <select class="form-control  " id="ReportType">
                                            <option value="">{{ __('Both') }} </option>
                                            <option value="bookings">{{ __('Bookings') }} </option>
                                            <option value="maintenance">{{ __('Maintenance') }} </option>

                                        </select>
                                    </div>
                                    <div class="col-md-4 forBookings">
                                        <label for="booker">{{ __('Booked By') }} </label>
                                        <select class="form-control select2 " id="booker">
                                            <option value="">{{ __('All') }} </option>
                                            @foreach (\App\Models\Client::where('status', '1')->get() as $client)
                                                <option value="1|{{ $client->number }}">{{ $client->displayname }}
                                                </option>
                                            @endforeach
                                            @foreach (\App\Models\User::where('status', '1')->where('level', '1')->get() as $user)
                                                <option value="2|{{ $user->usernumber }}">{{ $user->displayname }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="row pr-4 pl-4 pt-2">
                                    <div class="col-md-4">
                                        <label for=" ">{{ __('From Date') }} </label>
                                        <input type="date" class="form-control" id="ReportFromDate">
                                    </div>
                                    <div class="col-md-4">
                                        <label for=" ">{{ __('To Date') }} </label>
                                        <input type="date" class="form-control" id="ReportToDate">
                                    </div>
                                    <div class="col-md-4 forBookings">
                                        <label for=" ">{{ __('Status') }} </label>
                                        <select class="form-control" id="ReportStatus">
                                            <option value="">{{ __('All') }} </option>
                                            <option value="1">{{ __('New') }} </option>
                                            <option value="2">{{ __('Div Manger Approval') }} </option>
                                            <option value="3">{{ __('Dep Manger Approval') }} </option>
                                            <option style="color: green;" value="4">{{ __('Approved') }} </option>
                                            <option style="color: red;" value="5">{{ __('Rejected') }} </option>
                                            <option style="color: rgb(128, 128, 52);" value="0">
                                                {{ __('Retreuned For Edit') }} </option>
                                            <option style="color: rgb(126, 24, 24);" value="6">{{ __('Canceled') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row p-3">
                                    <div class="col-md-12">
                                        <button class="btn btn-block btn-outline-success"
                                            id="GenerateReport">{{ __('Create') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="ReportResult" style="font-family: 'Times New Roman', Times, serif !important">
                    <div class="row p-1">
                        <div class="col-md-12">
                            <div class="card h-100  d-flex justify-content-center align-items-center">
                                <div class="text-center p-5">
                                    <h5 class="p-5">{{ __('Please Generate Report') }} </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endsection
