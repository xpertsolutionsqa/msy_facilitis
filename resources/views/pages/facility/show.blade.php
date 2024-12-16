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
                                <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                                    <h5>{{ __('Facilities') }}</h5>

                                    <form class="    ph-2  w-40" action="" method="get">
                                        <input type="hidden" name="v" id="currentview">
                                        <div class="d-flex align-items-center">
                                            <span class="ph-2"> {{ __('From Date') }}</span>
                                            <input type="date" id="DateStartSearch" placeholder="Start Date"
                                                class="form-control-sm ph-2" name="start"
                                                value="{{ app('request')->input('start') }}">
                                            <span class="ph-2"> {{ __('To Date') }} </span>
                                            <input type="date" id="DateEndSearch" class="form-control-sm" name="end"
                                                value="{{ app('request')->input('end') }}">
                                            &nbsp;
                                            &nbsp;
                                            <select name="type" id="" class="form-control-sm">
                                                <option value="">{{ __('Type') }}</option>
                                                @foreach (\App\Models\FacilityTypes::where('status', '1')->get() as $item)
                                                    <option
                                                        {{ app('request')->input('type') == $item->id ? 'selected' : '' }}
                                                        value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn"><svg xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                                    <path
                                                        d="M21 4V6H20L15 13.5V22H9V13.5L4 6H3V4H21ZM6.4037 6L11 12.8944V20H13V12.8944L17.5963 6H6.4037Z">
                                                    </path>
                                                </svg></button>
                                            @if (app('request')->input('type') != '' || app('request')->input('start') != '' || app('request')->input('end') != '')
                                                <a href="{{ route('facilities') }}" class="btn  "><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24" fill="currentColor">
                                                        <path
                                                            d="M6.92893 0.514648L21.0711 14.6568L19.6569 16.071L15.834 12.2486L15 13.4999V21.9999H9V13.4999L4 5.99993H3V3.99993L7.585 3.99965L5.51472 1.92886L6.92893 0.514648ZM9.585 5.99965L6.4037 5.99993L11 12.8944V19.9999H13V12.8944L14.392 10.8066L9.585 5.99965ZM21 3.99993V5.99993H20L18.085 8.87193L16.643 7.42893L17.5963 5.99993H15.213L13.213 3.99993H21Z">
                                                        </path>
                                                    </svg></a>
                                            @endif

                                        </div>
                                    </form>

                                    <div class="d-flex align-items-center">
                                        <div class="list-grid-toggle d-flex align-items-center mr-3">
                                            <div data-toggle-extra="tab" data-target-extra="#grid"
                                                class="{{ $gridactive }}">
                                                <div class="grid-icon ">
                                                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <rect x="3" y="3" width="7" height="7"></rect>
                                                        <rect x="14" y="3" width="7" height="7"></rect>
                                                        <rect x="14" y="14" width="7" height="7"></rect>
                                                        <rect x="3" y="14" width="7" height="7"></rect>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div data-toggle-extra="tab" data-target-extra="#list"
                                                class="{{ $listactive }}">
                                                <div class="grid-icon">
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
                                        @if (auth()->check())
                                            @if (auth()->user()->inlevel(['2']))
                                                <div class="p-2"></div>
                                                <div class="p-2 border-left  border-right"></div>
                                                <a class="btn   btn-outline-primary"
                                                    href="{{ route('createFacility') }}">{{ __('Create New Facility') }}</a>
                                            @endif
                                        @endif


                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <div id="grid" class="item-content animate__animated animate__fadeIn {{ $gridactive }}"
                    data-toggle-extra="tab-content">

                    <div class="">
                        <div class="card-body w-100 h-100 ">
                            @if (count($facilities) == 0)
                                <div class="text-center p-5">
                                    <h5><b>{{ __('Sorry No Facility Availabel To book') }}</b></h5>
                                </div>
                            @else
                                <div class="row p-2">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <input placeholder="{{ __('Search') }}" class="form-control" type="text"
                                            name="" id="SearchGrid">
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <div class="row">
                                    @foreach ($facilities as $facility)
                                        <div class="facilityCard card col-lg-3 col-md-8 mh-2"
                                            name="{{ $facility->title }}">
                                            <div class=" card-block  ">
                                                <div class="swiper Mainswiper">
                                                    <div class="swiper-wrapper">
                                                        @foreach ($facility->images as $image)
                                                            <div class="swiper-slide"> <img
                                                                    src="{{config('app.url')}}/public/{{ $image->url }}"
                                                                    alt="" srcset="">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    {{-- <div class="swiper-pagination"></div> --}}
                                                </div>
                                                <div class="card-body text-center p-0 ">

                                                    <div class="item">


                                                        <div class="  rounded">

                                                            <h4 class="p-3 mb-2">
                                                                <small>{{ $facility->club->name }}</small><br><br>

                                                                {{ $facility->title }}
                                                            </h4>

                                                            <ul class="list-unstyled mb-3">


                                                                <li class=" border border-info text-info p-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" width="24" height="24"
                                                                        fill="currentColor">
                                                                        <path
                                                                            d="M9.55 11.5C8.30736 11.5 7.3 10.4926 7.3 9.25C7.3 8.00736 8.30736 7 9.55 7C10.7926 7 11.8 8.00736 11.8 9.25C11.8 10.4926 10.7926 11.5 9.55 11.5ZM10 19.748V16.4C10 15.9116 10.1442 15.4627 10.4041 15.0624C10.1087 15.0213 9.80681 15 9.5 15C7.93201 15 6.49369 15.5552 5.37091 16.4797C6.44909 18.0721 8.08593 19.2553 10 19.748ZM4.45286 14.66C5.86432 13.6168 7.61013 13 9.5 13C10.5435 13 11.5431 13.188 12.4667 13.5321C13.3447 13.1888 14.3924 13 15.5 13C17.1597 13 18.6849 13.4239 19.706 14.1563C19.8976 13.4703 20 12.7471 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 12.9325 4.15956 13.8278 4.45286 14.66ZM18.8794 16.0859C18.4862 15.5526 17.1708 15 15.5 15C13.4939 15 12 15.7967 12 16.4V20C14.9255 20 17.4843 18.4296 18.8794 16.0859ZM12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM15.5 12.5C14.3954 12.5 13.5 11.6046 13.5 10.5C13.5 9.39543 14.3954 8.5 15.5 8.5C16.6046 8.5 17.5 9.39543 17.5 10.5C17.5 11.6046 16.6046 12.5 15.5 12.5Z">
                                                                        </path>
                                                                    </svg>
                                                                    {{ __('Capacity') }} : {{ $facility->capacity }}
                                                                </li>
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center  pt-1 pb-1">

                                                                    <div class=" border border-primary text-primary p-1 ">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 24 24" width="24"
                                                                            height="24" fill="currentColor">
                                                                            <path
                                                                                d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM11 13V17H6V13H11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z">
                                                                            </path>
                                                                        </svg>
                                                                        {{ __('Bookings') }} :
                                                                        {{ count($facility->bookings) }}
                                                                    </div>
                                                                    <div
                                                                        class="border border-secondary text-secondary p-1 ">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 24 24" width="24"
                                                                            height="24" fill="currentColor">
                                                                            <path
                                                                                d="M12 2L16.2426 6.24264L14.8284 7.65685L12 4.82843L9.17157 7.65685L7.75736 6.24264L12 2ZM2 12L6.24264 7.75736L7.65685 9.17157L4.82843 12L7.65685 14.8284L6.24264 16.2426L2 12ZM22 12L17.7574 16.2426L16.3431 14.8284L19.1716 12L16.3431 9.17157L17.7574 7.75736L22 12ZM12 14C10.8954 14 10 13.1046 10 12C10 10.8954 10.8954 10 12 10C13.1046 10 14 10.8954 14 12C14 13.1046 13.1046 14 12 14ZM12 22L7.75736 17.7574L9.17157 16.3431L12 19.1716L14.8284 16.3431L16.2426 17.7574L12 22Z">
                                                                            </path>
                                                                        </svg>
                                                                        {{ __('Space') }} : {{ $facility->space }}
                                                                    </div>
                                                                </div>
                                                                <li class="border border-dark text-dark  p-1">

                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" width="24" height="24"
                                                                        fill="currentColor">
                                                                        <path
                                                                            d="M12 20.8995L16.9497 15.9497C19.6834 13.2161 19.6834 8.78392 16.9497 6.05025C14.2161 3.31658 9.78392 3.31658 7.05025 6.05025C4.31658 8.78392 4.31658 13.2161 7.05025 15.9497L12 20.8995ZM12 23.7279L5.63604 17.364C2.12132 13.8492 2.12132 8.15076 5.63604 4.63604C9.15076 1.12132 14.8492 1.12132 18.364 4.63604C21.8787 8.15076 21.8787 13.8492 18.364 17.364L12 23.7279ZM12 13C13.1046 13 14 12.1046 14 11C14 9.89543 13.1046 9 12 9C10.8954 9 10 9.89543 10 11C10 12.1046 10.8954 13 12 13ZM12 15C9.79086 15 8 13.2091 8 11C8 8.79086 9.79086 7 12 7C14.2091 7 16 8.79086 16 11C16 13.2091 14.2091 15 12 15Z">
                                                                        </path>
                                                                    </svg>
                                                                    {{ $facility->fulladdress }}
                                                                </li>
                                                            </ul>
                                                            <div class="pt-3 border-top pb-5">
                                                                <a href="{{ route('facility.details', ['FaNumber' => $facility->number]) }}"
                                                                    class="btn btn-block btn-primary">{{ __('Details') }}</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>



                </div>
            </div>
            <div id="list" class="item-content animate__animated animate__fadeIn  {{ $listactive }} "
                data-toggle-extra="tab-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            @if (count($facilities) == 0)
                                <div class="text-center p-5 m-5">
                                    <b> {{ __('No Facilities') }} </b>
                                </div>
                            @else
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8">

                                        </div>
                                        <div class="col-md-4">
                                            <input id="myInput" onkeyup="myFunction(1,[1,3,4,8]);" type="text"
                                                placeholder="{{ __('Search') }}" class="form-control">
                                        </div>
                                    </div>
                                    <br>

                                    <table id="myTable" class="table table-border ">
                                        <thead>

                                            <th>#</th>
                                            <th>{{ __('Number') }}</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Address') }}</th>
                                            <th>{{ __('Space') }}</th>
                                            <th>{{ __('Capacity') }}</th>
                                            <th>{{ __('Bookings') }}</th>
                                            <th>{{ __('Sub Facilities') }}</th>


                                            <th></th>
                                        </thead>
                                        <tbody>
                                            @foreach ($facilities as $i => $facility)
                                                <tr data-id="{{ $facility->id }}">

                                                    <td> {{ $i + 1 }} </td>
                                                    <td> <b>{{ $facility->number }}</b></td>
                                                    <td> {{ $facility->FacilitiyType->getTranslation('name', app()->getLocale()) }}
                                                    </td>
                                                    <td>{{ $facility->getTranslation('title', app()->getLocale()) }}
                                                    </td>
                                                    <td>{{ $facility->fulladdress }}
                                                    <td>{{ $facility->space }}
                                                    <td>{{ $facility->capacity }}
                                                    <td>{{ count($facility->bookings) }}
                                                    </td>
                                                    <td>
                                                        <ul>
                                                            @foreach ($facility->subfacilities as $item)
                                                                <li>
                                                                    {{ $item->getTranslation('title', app()->getLocale()) }}
                                                                </li>
                                                            @endforeach
                                                        </ul>

                                                    </td>


                                                    <td>
                                                        @if (auth()->check() && auth()->user()->level=='2'  && !count($facility->bookings) > 0)
                                                            <button class="btn btn-outline-danger DeleteFacility"
                                                                number="{{ $facility->number }}"
                                                                id="{{ $facility->id }}">
                                                                {{ __('Delete') }}
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24" width="24" height="24"
                                                                    fill="currentColor">
                                                                    <path
                                                                        d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM18 8H6V20H18V8ZM9 11H11V17H9V11ZM13 11H15V17H13V11ZM9 4V6H15V4H9Z">
                                                                    </path>
                                                                </svg></button>
                                                        @endif

                                                        @if (auth()->check() && auth()->user()->level=='2'   )
                                                            <form class="d-inline"
                                                                action="{{ $facility->status == '1' ? route('facility.disable') : route('facility.enable') }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="faId"
                                                                    value="{{ $facility->id }}">
                                                                <input type="hidden" name="faNumber"
                                                                    value="{{ $facility->number }}">
                                                                <button type="submit"
                                                                    class="btn {{ $facility->status == '1' ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                                                    {{ $facility->status == '1' ? __('Disable') : __('Enable') }}
                                                                    @if ($facility->status == '1')
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 24 24" width="24" height="24"
                                                                            fill="currentColor">
                                                                            <path
                                                                                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z">
                                                                            </path>
                                                                        </svg>
                                                                    @else
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 24 24" width="24" height="24"
                                                                            fill="currentColor">
                                                                            <path
                                                                                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z">
                                                                            </path>
                                                                        </svg>
                                                                    @endif
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <a href="{{ route('facility.details', ['FaNumber' => $facility->number]) }}"
                                                            class="mr-5  btn btn-outline-primary">{{ __('See details') }}
                                                            @if (app()->getLocale() == 'ar')
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24" width="24" height="24"
                                                                    fill="currentColor">
                                                                    <path
                                                                        d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z">
                                                                    </path>
                                                                </svg>
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24" width="24" height="24"
                                                                    fill="currentColor">
                                                                    <path
                                                                        d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                                                                    </path>
                                                                </svg>
                                                            @endif
                                                        </a>
                                                    </td>
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
@endsection
