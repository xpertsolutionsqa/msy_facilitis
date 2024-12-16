@extends('layouts.app')

@section('content')
    <div class="wrapper">

        <div class="iq-top-navbar-{{ app()->getLocale() }} w-100">
            @include('layouts.header')
        </div>
        <div class="content-page" style="margin-right:0px;margin-left:0px">
            <div class="container-fluid  ">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header shadow-bottom d-flex align-items-center justify-content-between">
                                <a href="{{ route('facilities') }}"
                                    class="btn btn-outline-info"><back-icon></back-icon>{{ __('Go Back') }} </a>
                                <h3 class="text-center">{{ $facility->getTranslation('title', app()->getLocale()) }}
                                    #{{ $facility->number }} </h3>
                                <div>
                                </div> 
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="card card-block card-stretch card-height h-100">
                                            <div class="card-header ">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <a href="#" id="cal-prev"
                                                        class="text-dark mr-2 font-size-18"><back-c-icon></a>
                                                    <h5 class="mh-3" id="calender_title"> </h5>
                                                    <div class="mt-1">

                                                        <a href="#" id="cal-next"
                                                            class="text-dark font-size-18"><front-c-icon></a>
                                                    </div>
                                                </div>
                                                {{-- <div class="d-flex align-items-center">
                                                    <select name="cal_type" class="selectpicker calender-select"
                                                        id="cal-type">
                                                        <option value="month">Month</option>
                                                        <option value="week">Week</option>
                                                        <option value="day">Day</option>
                                                    </select>

                                                </div> --}}
                                            </div>
                                            <div class="card-body">
                                                <div id="calendar"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="card h-100">
                                            <div class="card-header text-center">
                                                {{ __('Facility Details') }}
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-6 col-xl-6 col-xl-6 h-100">
                                                        <div class="swiper facilityswiper">

                                                            <div class="swiper-wrapper">
                                                                @foreach ($facility->images as $image)
                                                                    <div class="swiper-slide"> <img
                                                                            src="{{ config('app.url') }}/public/{{ $image->url }}"
                                                                            alt="" srcset="">
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <div class="swiper-pagination"></div>



                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card card-block card-stretch  ">
                                                            <div class="card-body p-3">
                                                                <div
                                                                    class="row d-flex justify-content-around align-items-start text-center py-2">
                                                                    <div class="  col-xl-3 col-sm-6 mb-3 mb-sm-0">
                                                                        <div
                                                                            class="profile-icon icon m-auto rounded bg-info">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 24 24" width="24"
                                                                                height="24" fill="currentColor">
                                                                                <path
                                                                                    d="M9.55 11.5C8.30736 11.5 7.3 10.4926 7.3 9.25C7.3 8.00736 8.30736 7 9.55 7C10.7926 7 11.8 8.00736 11.8 9.25C11.8 10.4926 10.7926 11.5 9.55 11.5ZM10 19.748V16.4C10 15.9116 10.1442 15.4627 10.4041 15.0624C10.1087 15.0213 9.80681 15 9.5 15C7.93201 15 6.49369 15.5552 5.37091 16.4797C6.44909 18.0721 8.08593 19.2553 10 19.748ZM4.45286 14.66C5.86432 13.6168 7.61013 13 9.5 13C10.5435 13 11.5431 13.188 12.4667 13.5321C13.3447 13.1888 14.3924 13 15.5 13C17.1597 13 18.6849 13.4239 19.706 14.1563C19.8976 13.4703 20 12.7471 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 12.9325 4.15956 13.8278 4.45286 14.66ZM18.8794 16.0859C18.4862 15.5526 17.1708 15 15.5 15C13.4939 15 12 15.7967 12 16.4V20C14.9255 20 17.4843 18.4296 18.8794 16.0859ZM12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM15.5 12.5C14.3954 12.5 13.5 11.6046 13.5 10.5C13.5 9.39543 14.3954 8.5 15.5 8.5C16.6046 8.5 17.5 9.39543 17.5 10.5C17.5 11.6046 16.6046 12.5 15.5 12.5Z">
                                                                                </path>
                                                                            </svg>
                                                                        </div>
                                                                        <h5 class="mb-2 mt-3 icon-text-info">
                                                                            {{ $facility->capacity }}</h5>
                                                                        <p class="mb-0">{{ __('Capacity') }}</p>
                                                                    </div>
                                                                    <div class="profile-info col-xl-3 col-sm-6">
                                                                        <div
                                                                            class="profile-icon icon m-auto rounded bg-success">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 24 24" width="24"
                                                                                height="24" fill="currentColor">
                                                                                <path
                                                                                    d="M12 2L16.2426 6.24264L14.8284 7.65685L12 4.82843L9.17157 7.65685L7.75736 6.24264L12 2ZM2 12L6.24264 7.75736L7.65685 9.17157L4.82843 12L7.65685 14.8284L6.24264 16.2426L2 12ZM22 12L17.7574 16.2426L16.3431 14.8284L19.1716 12L16.3431 9.17157L17.7574 7.75736L22 12ZM12 14C10.8954 14 10 13.1046 10 12C10 10.8954 10.8954 10 12 10C13.1046 10 14 10.8954 14 12C14 13.1046 13.1046 14 12 14ZM12 22L7.75736 17.7574L9.17157 16.3431L12 19.1716L14.8284 16.3431L16.2426 17.7574L12 22Z">
                                                                                </path>
                                                                            </svg>
                                                                        </div>
                                                                        <h5 class="mb-2 mt-3 icon-text-success">
                                                                            {{ $facility->space }}</h5>
                                                                        <p class="mb-0">{{ __('Space') }}</p>
                                                                    </div>
                                                                </div>
                                                                <a class="btn btn-block btn-outline-primary"
                                                                    href="{{ $facility->location }}" target="_blank">
                                                                    {{ __('Open The Location on Google Maps') }} <svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" width="24" height="24"
                                                                        fill="currentColor">
                                                                        <path
                                                                            d="M2 5L9 2L15 5L21.303 2.2987C21.5569 2.18992 21.8508 2.30749 21.9596 2.56131C21.9862 2.62355 22 2.69056 22 2.75827V19L15 22L9 19L2.69696 21.7013C2.44314 21.8101 2.14921 21.6925 2.04043 21.4387C2.01375 21.3765 2 21.3094 2 21.2417V5ZM16 19.3955L20 17.6812V5.03308L16 6.74736V19.3955ZM14 19.2639V6.73607L10 4.73607V17.2639L14 19.2639ZM8 17.2526V4.60451L4 6.31879V18.9669L8 17.2526Z">
                                                                        </path>
                                                                    </svg></a>
                                                            </div>
                                                        </div>
                                                        <div class="row text-center">
                                                            <h6 class="p-2"> {{ __('Sub Facilities') }} </h6>
                                                        </div>




                                                    </div>
                                                </div>


                                                <div class="swiper mySubSwiper p-2">

                                                    <div class="swiper-wrapper">
                                                        @foreach ($facility->subfacilities as $sub)
                                                            <div class="swiper-slide  ">
                                                                <div class="card">
                                                                    <div class="card-header p-2">
                                                                        <div
                                                                            class="d-flex justify-content-between align-items-center ">
                                                                            <div class="badge border border-dark text-dark">
                                                                                {{ $sub->size }}
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    viewBox="0 0 24 24" width="24"
                                                                                    height="24" fill="currentColor">
                                                                                    <path
                                                                                        d="M9.55 11.5C8.30736 11.5 7.3 10.4926 7.3 9.25C7.3 8.00736 8.30736 7 9.55 7C10.7926 7 11.8 8.00736 11.8 9.25C11.8 10.4926 10.7926 11.5 9.55 11.5ZM10 19.748V16.4C10 15.9116 10.1442 15.4627 10.4041 15.0624C10.1087 15.0213 9.80681 15 9.5 15C7.93201 15 6.49369 15.5552 5.37091 16.4797C6.44909 18.0721 8.08593 19.2553 10 19.748ZM4.45286 14.66C5.86432 13.6168 7.61013 13 9.5 13C10.5435 13 11.5431 13.188 12.4667 13.5321C13.3447 13.1888 14.3924 13 15.5 13C17.1597 13 18.6849 13.4239 19.706 14.1563C19.8976 13.4703 20 12.7471 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 12.9325 4.15956 13.8278 4.45286 14.66ZM18.8794 16.0859C18.4862 15.5526 17.1708 15 15.5 15C13.4939 15 12 15.7967 12 16.4V20C14.9255 20 17.4843 18.4296 18.8794 16.0859ZM12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM15.5 12.5C14.3954 12.5 13.5 11.6046 13.5 10.5C13.5 9.39543 14.3954 8.5 15.5 8.5C16.6046 8.5 17.5 9.39543 17.5 10.5C17.5 11.6046 16.6046 12.5 15.5 12.5Z">
                                                                                    </path>
                                                                                </svg>
                                                                            </div>
                                                                            <p>{{ $sub->title }}</p>
                                                                            <div class="badge border border-info text-info">
                                                                                {{ $sub->type }}
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="card-body">


                                                                        <div class="swiper facilityswiper">

                                                                            <div class="swiper-wrapper">
                                                                                @foreach ($sub->images as $simage)
                                                                                    <div class="swiper-slide"> <img
                                                                                            src="{{ config('app.url') }}/public/{{ $simage->url }}"
                                                                                            alt="" srcset="">
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>



                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        @endforeach


                                                    </div>

                                                    <div class="swiper-pagination"></div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    {{-- <div class="col-md-6">

                                        @php
                                            $urls = rtrim($facility->images, ',');
                                            $images = explode(',', $urls);
                                        @endphp
                                        <div class="swiper mySwiper ">
                                            <div class="swiper-wrapper">
                                                @foreach ($images as $image)
                                                    <div class="swiper-slide"> <img
                                                            src="{{config('app.url')}}/public/{{ $image }}" alt=""
                                                            srcset=""></div>
                                                @endforeach
                                            </div>

                                            <div class="swiper-pagination"></div>
                                        </div>

                                        <br><br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header text-center">{{ __('Facility Details') }}</div>
                                                    <div class="card-body">
                                                        <div class="badge   border border-dark text-dark h6 ">

                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="32" height="32" fill="currentColor">
                                                                <path
                                                                    d="M12 20.8995L16.9497 15.9497C19.6834 13.2161 19.6834 8.78392 16.9497 6.05025C14.2161 3.31658 9.78392 3.31658 7.05025 6.05025C4.31658 8.78392 4.31658 13.2161 7.05025 15.9497L12 20.8995ZM12 23.7279L5.63604 17.364C2.12132 13.8492 2.12132 8.15076 5.63604 4.63604C9.15076 1.12132 14.8492 1.12132 18.364 4.63604C21.8787 8.15076 21.8787 13.8492 18.364 17.364L12 23.7279ZM12 13C13.1046 13 14 12.1046 14 11C14 9.89543 13.1046 9 12 9C10.8954 9 10 9.89543 10 11C10 12.1046 10.8954 13 12 13ZM12 15C9.79086 15 8 13.2091 8 11C8 8.79086 9.79086 7 12 7C14.2091 7 16 8.79086 16 11C16 13.2091 14.2091 15 12 15Z">
                                                                </path>
                                                            </svg>
                                                            {{ __('Address') }} : {{ $facility->fulladdress }}
                                                        </div>
                                                        <div class="badge   border border-danger text-danger h5">

                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="32" height="32" fill="currentColor">
                                                                <path
                                                                    d="M5 19H19V5H5V19ZM3 4C3 3.44772 3.44772 3 4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4ZM8 10L12 6L16 10H13V14H16L12 18L8 14H11V10L8 10Z">
                                                                </path>
                                                            </svg>
                                                            {{ __('Space') }} : {{ $facility->space }}
                                                        </div>
                                                        <div class="badge  border border-success text-success h5">

                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="32" height="32" fill="currentColor">
                                                                <path
                                                                    d="M9.55 11.5C8.30736 11.5 7.3 10.4926 7.3 9.25C7.3 8.00736 8.30736 7 9.55 7C10.7926 7 11.8 8.00736 11.8 9.25C11.8 10.4926 10.7926 11.5 9.55 11.5ZM10 19.748V16.4C10 15.9116 10.1442 15.4627 10.4041 15.0624C10.1087 15.0213 9.80681 15 9.5 15C7.93201 15 6.49369 15.5552 5.37091 16.4797C6.44909 18.0721 8.08593 19.2553 10 19.748ZM4.45286 14.66C5.86432 13.6168 7.61013 13 9.5 13C10.5435 13 11.5431 13.188 12.4667 13.5321C13.3447 13.1888 14.3924 13 15.5 13C17.1597 13 18.6849 13.4239 19.706 14.1563C19.8976 13.4703 20 12.7471 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 12.9325 4.15956 13.8278 4.45286 14.66ZM18.8794 16.0859C18.4862 15.5526 17.1708 15 15.5 15C13.4939 15 12 15.7967 12 16.4V20C14.9255 20 17.4843 18.4296 18.8794 16.0859ZM12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM15.5 12.5C14.3954 12.5 13.5 11.6046 13.5 10.5C13.5 9.39543 14.3954 8.5 15.5 8.5C16.6046 8.5 17.5 9.39543 17.5 10.5C17.5 11.6046 16.6046 12.5 15.5 12.5Z">
                                                                </path>
                                                            </svg>
                                                            {{ __('Capacity') }} : {{ $facility->capacity }}
                                                        </div>
                                                        <a class="btn btn-block btn-outline-primary"
                                                            href="{{ $facility->location }}" target="_blank"> <svg
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="32" height="32" fill="currentColor">
                                                                <path
                                                                    d="M2 5L9 2L15 5L21.303 2.2987C21.5569 2.18992 21.8508 2.30749 21.9596 2.56131C21.9862 2.62355 22 2.69056 22 2.75827V19L15 22L9 19L2.69696 21.7013C2.44314 21.8101 2.14921 21.6925 2.04043 21.4387C2.01375 21.3765 2 21.3094 2 21.2417V5ZM16 19.3955L20 17.6812V5.03308L16 6.74736V19.3955ZM14 19.2639V6.73607L10 4.73607V17.2639L14 19.2639ZM8 17.2526V4.60451L4 6.31879V18.9669L8 17.2526Z">
                                                                </path>
                                                            </svg>{{ __('Open The Location on Google Maps') }}</a>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header text-center">
                                                        {{ __('Sub Facilities') }}
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="swiper2 mySubSwiper">
                                                            <div class="swiper-wrapper">
                                                                @foreach ($facility->subfacilities as $sub)
                                                                    @php
                                                                        $suburls = rtrim($sub->images, ',');
                                                                        $subimages = explode(',', $suburls);
                                                                    @endphp

                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <div class="swiper2 mySubSwiper">
                                                                                <div class="swiper-wrapper">
                                                                                    @foreach ($subimages as $subimage)
                                                                                        <div class="swiper-slide"> <img
                                                                                                src="{{config('app.url')}}/public/{{ $subimage }}"
                                                                                                alt=""
                                                                                                srcset="">
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                                <div class="swiper-pagination"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div
                                                                                class="d-flex justify-content-between align-items-center">
                                                                                <div
                                                                                    class="badge border border-dark text-dark">
                                                                                    {{ $sub->size }}
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        viewBox="0 0 24 24" width="24"
                                                                                        height="24" fill="currentColor">
                                                                                        <path
                                                                                            d="M9.55 11.5C8.30736 11.5 7.3 10.4926 7.3 9.25C7.3 8.00736 8.30736 7 9.55 7C10.7926 7 11.8 8.00736 11.8 9.25C11.8 10.4926 10.7926 11.5 9.55 11.5ZM10 19.748V16.4C10 15.9116 10.1442 15.4627 10.4041 15.0624C10.1087 15.0213 9.80681 15 9.5 15C7.93201 15 6.49369 15.5552 5.37091 16.4797C6.44909 18.0721 8.08593 19.2553 10 19.748ZM4.45286 14.66C5.86432 13.6168 7.61013 13 9.5 13C10.5435 13 11.5431 13.188 12.4667 13.5321C13.3447 13.1888 14.3924 13 15.5 13C17.1597 13 18.6849 13.4239 19.706 14.1563C19.8976 13.4703 20 12.7471 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 12.9325 4.15956 13.8278 4.45286 14.66ZM18.8794 16.0859C18.4862 15.5526 17.1708 15 15.5 15C13.4939 15 12 15.7967 12 16.4V20C14.9255 20 17.4843 18.4296 18.8794 16.0859ZM12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM15.5 12.5C14.3954 12.5 13.5 11.6046 13.5 10.5C13.5 9.39543 14.3954 8.5 15.5 8.5C16.6046 8.5 17.5 9.39543 17.5 10.5C17.5 11.6046 16.6046 12.5 15.5 12.5Z">
                                                                                        </path>
                                                                                    </svg>
                                                                                </div>
                                                                                <h6>{{ $sub->getTranslation('title', app()->getLocale()) }}
                                                                                </h6>
                                                                                <div
                                                                                    class="badge border border-info text-info">
                                                                                    {{ $sub->type }}
                                                                                </div>
                                                                            </div>

                                                                            <p>
                                                                                {{ $sub->description }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach

                                                            </div>
                                                            <div class="swiper-pagination"></div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                        </div> --}}
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>



    <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="new_booking_model">
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bttom">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title">{{ __('New Booking') }} </h3>
                </div>
                    @php
                        $user = Auth::guard('client')->user();
                    @endphp
                <form class="BookingForm" action="{{ route('booking.create') }}" method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body" id="imageview">
                        <input type="hidden" name="subs" id="subs">
                        <input type="hidden" name="booking_type" id="booking_type">
                        <input type="hidden" name="booking_days" id="booking_days">
                        <input type="hidden" name="FaId" value="{{ $facility->id }}">
                        <input type="hidden" name="FaNum" value="{{ $facility->number }}">
                        <input type="hidden" name="UID" value="{{ $user->id }}">

                        <div class="row">
                            <div class="col-md-12">
                                <label class="required-label" for="">{{ __('Facility') }}</label>
                                <input class="form-control" type="text"
                                    value="{{ $facility->getTranslation('title', app()->getLocale()) }}" readonly>
                            </div>
                            <div class="col-md-12">
                                <label class="required-label" for="">{{ __('Booker Name') }}</label>
                                <input class="form-control" type="text" id=""
                                    value="{{ $user->displayname }}" {{ $user->displayname != '' ? 'readonly' : '' }}>
                            </div>
                        </div>




                        <div class="row d-flex justify-content-center align-items-center">

                            <div class="col-md-12 card  ">
                                <label class="required-label" for="">{{ __('Booker Type') }}</label>
                                <div class="row d-flex justify-content-start align-items-center p-2">

                                    @foreach (\App\Models\UserType::all() as $type)
                                        <div class="d-flex">
                                            <input id="{{ $type->id }}" name="type"
                                                {{ $user->type != null ? 'disabled' : '' }}
                                                {{ $user->type == $type->id ? 'checked' : '' }}
                                                class="form-control FaType smallcheck" type="radio"><span
                                                class="space">
                                                {{ $type->getTranslation('title', app()->getlocale()) }} </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row card p-2">
                            <div class="col-md-12">
                                <label for="">{{ __('Requierd Sub Facilities') }}</label>
                                <div class="row d-flex justify-content-center align-items-center">


                                    @foreach ($facility->SubFacilities as $sub)
                                        @if ($sub->status == '1')
                                            <div class="d-flex">
                                                <input id="{{ $sub->id }}" class="form-control subFa smallcheck"
                                                    type="checkbox"><span class="space">
                                                    {{ $sub->getTranslation('title', app()->getlocale()) }} </span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="required-label" for="">{{ __('Event') }}</label>
                                <input class="form-control required" type="text" name="event_name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="required-label" for="">{{ __('Expected Participants No') }}</label>
                                <input class="form-control required" type="nubmer" min="1"
                                    name="expected_number">
                            </div>
                            <div class="col-md-6">
                                <label class="required-label" for="">{{ __('Requierd Days No') }}</label>

                                <input id="bookingdays" type="text" class="form-control required" readonly
                                    aria-describedby="basic-addon2">



                            </div>
                        </div>
                        <div id="manydays" class="row">
                            <div class="col-md-6">
                                <label class="required-label" for="">{{ __('From Date') }}</label>
                                <input type="text" class="form-control" name="from_date" readonly
                                    id="booking_from_date">
                            </div>
                            <div class="col-md-6">
                                <label class="required-label" for="">{{ __('To Date') }}</label>
                                <input type="text" class="form-control" name="to_date" readonly id="booking_to_date">
                            </div>
                        </div>

                        <div id="oneday" class="row">
                            <div class="col-md-12">
                                <label class="required-label" for="">{{ __('Booking Date') }}</label>
                                <input type="text" class="form-control" name="booking_date" readonly
                                    id="booking_date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="required-label" for="">{{ __('From Time') }}</label>
                                <input type="time" class="form-control required " name="from_time">
                            </div>
                            <div class="col-md-6">
                                <label class="required-label" for="">{{ __('To Time') }}</label>
                                <input type="time" class="form-control required " name="to_time">
                            </div>
                        </div>

                        <div class="card p-3">

                            <h6>{{ __('Contact Information') }}</h6>

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="required-label" for="">{{ __('Name') }}</label>
                                    <input type="text" name="cname" class="form-control required">
                                </div>
                                <div class="col-md-4">
                                    <label class="required-label" for="">{{ __('Phone') }}</label>
                                    <input type="text" name="cphone" class="form-control required">
                                </div>
                                <div class="col-md-4">
                                    <label class="required-label" for="">{{ __('Email') }}</label>
                                    <input type="email" name="cemail" class="form-control required">
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="">{{ __('Notes') }}</label>
                                <textarea name="notes" class="form-control" cols="5" rows="3"></textarea>
                            </div>

                        </div>
                        @if (\App\Models\Attachment::where('status', '1')->count() > 0)
                            <div class="row">
                                @foreach (App\Models\Attachment::where('status', '1')->get() as $item)
                                    <div class="col-md-6">
                                        <label class="{{ $item->required == '1' ? 'required-label' : '' }}"
                                            for="">{{ $item->name }}</label>

                                        <input type="file" accept="{{ $item->accept }}"
                                            name="attach_file{{ $item->id }}"
                                            class="form-control  {{ $item->required == '1' ? 'required' : '' }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <br>
                        <div class="row pr-2 pl-2">
                            <input type="checkbox" class="form-controll smallcheck" name="" id="acceptTerms">

                            <a class="mr-2 ml-2" href="{{ route('terms') }}"
                                target="_blank">{{ __('Agree Terms') }}</a>
                        </div>




                </div>
                <div class="model-footer p-2">
                    <div class="row p-2">

                        <div class="col-md-3">
                            <button class="btn btn-block btn-outline-secondary close"
                                data-dismiss="modal">{{ __('Cancel') }}</button>
                        </div>
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-block btn-outline-primary" id="createBo"
                                style="display: none">{{ __('Book') }}</button>
                        </div>
                    </div>

                </div>
                </form>
            </div>
        </div>
    </div>




@endsection
