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
                                    <h5>{{ __('Maintenance') }}</h5>
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
                                                class=" {{ $gridactive }}">
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
                <div id="grid" class="item-content animate__animated animate__fadeIn  {{ $gridactive }}"
                    data-toggle-extra="tab-content">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between shadow-bottom">
                            <div class="h6"> {{ __('Maintenance Calender') }}</div>

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
                                    <div id="maintenancecalendar"></div>
                                </div>
                                <div class="col-md-4 " id="cardsSection">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="list" class="item-content animate__animated animate__fadeIn  {{ $listactive }}"
                    data-toggle-extra="tab-content">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between shadow-bottom">
                            <div class="h6"> {{ __('Maintenance List') }}</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        @if (count($maintenances) == 0)
                                            <div class="text-center p-5 m-5">
                                                <b> {{ __('No Maintenance') }} </b>
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
                                                        <th>{{ __('Date') }}</th>
                                                        <th>{{ __('Number') }}</th>
                                                        @if ((auth()->check() && auth()->user()->level != 3) || auth()->guard('client')->check())
                                                            <th>{{ __('Facility') }}</th>
                                                        @endif

                                                        <th>{{ __('From Date') }}</th>
                                                        <th>{{ __('To Date') }}</th>
                                                        <th>{{ __('Days') }}</th>
                                                        <th>{{ __('Maintenance Agenda') }}</th>
                                                        <th>{{ __('Maintenance Team') }}</th>

                                                        <th>{{ __('Status') }}</th>
                                                        @if (auth()->check())
                                                            @if (auth()->user()->level == '2' || auth()->user()->level == '6')
                                                                <th></th>
                                                            @endif
                                                        @endif
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($maintenances as $i => $maintenance)
                                                            <tr>

                                                                <td>{{ $i + 1 }}</td>
                                                                <td>{{ $maintenance->created_at }}</td>
                                                                <td>{{ $maintenance->number }}</td>
                                                                @if ((auth()->check() && auth()->user()->level != 3) || auth()->guard('client')->check())
                                                                    <td>{{ $maintenance->facility->title }}</td>
                                                                @endif
                                                                <td>{{ $maintenance->startDate }}</td>
                                                                <td>{{ $maintenance->endDate }} </td>
                                                                <td>{{ $maintenance->days }} </td>
                                                                <td>{{ $maintenance->description }} </td>
                                                                <td>{{ $maintenance->team }} </td>



                                                                <td> @switch($maintenance->status)
                                                                        @case('1')
                                                                            <span
                                                                                class="badge badge-success">{{ __('Approved') }}</span>
                                                                        @break

                                                                        @case('2')
                                                                            <span
                                                                                class="badge badge-warning">{{ __('Pending') }}</span>
                                                                        @break

                                                                        @case('3')
                                                                            <span
                                                                                class="badge badge-warning">{{ __('Pending') }}</span>
                                                                        @break

                                                                        @case('4')
                                                                            <span
                                                                                class="badge badge-danger">{{ __('Rejected') }}</span>
                                                                        @break

                                                                        @case('5')
                                                                            <span
                                                                                class="badge badge-info">{{ __('Canceled') }}</span>
                                                                        @break

                                                                        @default
                                                                            <span
                                                                                class="badge badge-info">{{ $maintenance->status }}</span>
                                                                    @endswitch
                                                                </td> 
                                                                @if (auth()->check())
                                                                    @if (auth()->user()->level == '2' || auth()->user()->level == '6')
                                                                        <td>
                                                                            <button
                                                                                class="btn btn-outline-danger DeleteMin" number="{{$maintenance->number}}" id="{{$maintenance->id}}">{{ __('Delete') }}</button>
                                                                            <button
                                                                            <button
                                                                                class="btn btn-outline-dark EditMin" number="{{$maintenance->number}}" id="{{$maintenance->id}}">{{ __('Edit') }}</button>

                                                                             {{--<button
                                                                                class="btn btn-outline-primary">{{ __('Details') }}</button>--}}
                                                                        </td> 
                                                                    @endif
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
@endsection
