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
                        <div class="card">
                            <div class="card-body">

                                <h3>{{ __('Notification') }}</h3>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="row">
                                <div class="col-xl-12">


                                    <div class="shadow-bottom p-2">
                                        <form action="{{ route('settings.notification.save') }}" method="post">
                                            @csrf
                                            <div class="row  d-flex align-items-center">
                                                <div class="col-md-2">
                                                    <div
                                                        class="custom-control custom-switch custom-switch-text custom-control-inline">
                                                        <div class="custom-switch-inner">
                                                            <p class="mb-0"> {{ __('Email Notification') }} </p>
                                                            <input name="email_enabled" type="checkbox"
                                                                class="custom-control-input" id="customSwitch-11"
                                                                {{ $email_enabled == 'on' ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="customSwitch-11"
                                                                data-on-label="On" data-off-label="Off">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label> {{ __('Email Host') }} </label>

                                                    <input class="form-control" type="text" name="email_host"
                                                        id="" value="{{ $email_host }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label> {{ __('Email Port') }} </label>

                                                    <input class="form-control" type="text" name="email_port"
                                                        id="" value="{{ $email_port }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label> {{ __('Email From') }} </label>

                                                    <input class="form-control" type="email" name="email_fromaddress"
                                                        id="" value="{{ $email_fromaddress }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label> {{ __('Email Username') }} </label>

                                                    <input class="form-control" type="text" name="email_smtp_username"
                                                        id="" value="{{ $email_smtp_username }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label> {{ __('Email Password') }} </label>

                                                    <input class="form-control" type="text" name="email_smtp_password"
                                                        id="" value="{{ $email_smtp_password }}">
                                                </div>

                                            </div>
                                            <div class="row p-3">
                                                <div class="col-md-12">
                                                    <button type="submit"
                                                        class="btn btn-block btn-outline-success">{{ __('Update') }}</button>
                                                </div>
                                            </div>
                                        </form>



                                        <div class="row">
                                            
                                            <div class="col-md-4"><input class="form-control" type="email" id="testmail">
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control" id="testmaillocale">

                                                    <option selected value="ar">Ar</option>
                                                    <option value="en">En</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4"><button type="button" id="TestMailBtn"
                                                    class="btn btn-block btn-outline-primary">{{ __('Send Test Email') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row p-5">
                                        <div class="col-md-10">
                                            <h3>{{ __('Templates') }}</h3>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-control" id="TemplateSelector">
                                                <option value="">{{ __('Please Select') }}</option>
                                                <option value="new_client">{{ __('messages.New Client Created') }}
                                                </option>
                                                <option value="reset_password">
                                                    {{ __('messages.Client Password Rested') }}</option>
                                                <option value="new_booking">{{ __('messages.New Booking Created') }}
                                                </option>
                                                <option value="booking_approved">
                                                    {{ __('messages.Booking Status Approved') }}</option>
                                                <option value="booking_returned">
                                                    {{ __('messages.Booking Returend For Edit') }}</option>
                                                <option value="booking_rejected">
                                                    {{ __('messages.Booking Status Rejected') }}</option>
                                                <option value="booking_status_changed">
                                                    {{ __('messages.booking_status_changed') }}</option>
                                                <option value="booking_comment_added">
                                                    {{ __('messages.booking_comment_added') }}</option>
                                                <option value="booking_edited">
                                                    {{ __('messages.booking_edited') }}</option>
                                                 
                                                {{-- <option value="new_booking_for_employee">new_booking_for_employee</option>
                                                    <option value="booking_reminder">booking_reminder</option> --}}
                                                {{-- <option value="booking_canceled">{{ __('messages.Booking Status Canceled') }}</option>  --}}

                                            </select>
                                        </div>

                                    </div>

                                    <div class="row  ">
                                        <div class="col-md-12">
                                            <div id="TemplateDetails">
                                                <div class="p-3 text-center">
                                                    <p>{{ __('Please Select Template') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
