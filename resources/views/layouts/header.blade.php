@if (Auth::guard('client')->check())
    @php
        $user = Auth::guard('client')->user();
    @endphp
    <div class="iq-navbar-custom">
        <nav class="d-flex navbar navbar-expand-lg navbar-light p-0 justify-content-between p-3">
            <div class="  iq-navbar-logo d-flex align-items-center justify-content-between">
                <i class="ri-menu-line wrapper-menu"></i>
                <a href="{{ route('facilities') }}" class="header-logo">
                    <h4 class="logo-title text-uppercase"> </h4>

                </a>
            </div>

            <a href="{{ route('dashboard') }}"> <img
                    class="{{ app()->getLocale() == 'ar' ? 'border-left' : 'border-right ' }} pr-3  pl-3"
                    style="width: 250px" src="{{ asset('assets/images/logo/msy_new_logo.png') }}" alt="logo"></a>
            <div>
                <p>
                    @php

                        $date = Carbon\Carbon::now()->addHour(3);
                        $locale = app()->getLocale();
                        $formattedDateEn = $date->locale('en')->translatedFormat('l j F Y');
                        $timeInEnglish = $date->format('g:i A');
                        $formattedDateAr = $date->locale('ar')->translatedFormat('l j F Y');
                        $timeInArabic = $date->format('h:i') . ' ' . ($date->format('A') === 'AM' ? 'صباحا' : 'مساءا');
                        $todaysDate = $locale === 'ar' ? $formattedDateAr : $formattedDateEn;
                        $todaysTime = $locale === 'ar' ? $timeInArabic : $timeInEnglish;
                    @endphp

                    {{ $todaysDate }} - {{ $todaysTime }} &nbsp;&nbsp;&nbsp;

                    <button class="btn" type="button" id="popoverButton">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32"
                            fill="currentColor">
                            <path
                                d="M9.98392 5.05991C11.1323 3.22236 13.1734 2 15.5 2C19.0899 2 22 4.91015 22 8.5C22 9.58031 21.7365 10.5991 21.2701 11.4955C22.3351 12.4985 23 13.9216 23 15.5C23 18.5376 20.5376 21 17.5 21H9C4.58172 21 1 17.4183 1 13C1 8.58172 4.58172 5 9 5C9.33312 5 9.66149 5.02036 9.98392 5.05991ZM12.0554 5.60419C14.0675 6.43637 15.6662 8.06578 16.4576 10.0986C16.7951 10.0339 17.1436 10 17.5 10C18.2351 10 18.9366 10.1442 19.5776 10.4059C19.8486 9.82719 20 9.18128 20 8.5C20 6.01472 17.9853 4 15.5 4C14.1177 4 12.8809 4.6233 12.0554 5.60419ZM17.5 19C19.433 19 21 17.433 21 15.5C21 13.567 19.433 12 17.5 12C16.5205 12 15.6351 12.4023 14.9998 13.0507C14.9999 13.0338 15 13.0169 15 13C15 9.68629 12.3137 7 9 7C5.68629 7 3 9.68629 3 13C3 16.3137 5.68629 19 9 19H17.5Z">
                            </path>
                        </svg>
                    </button>


                </p>

            </div>


            <div class="d-flex align-items-center">
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-label="Toggle navigation">
                    <i class="ri-menu-3-line"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent"
                    style="font-family: 'Line Awesome Free'">
                    <ul class="navbar-nav ml-auto navbar-list align-items-center">

                        <li class="nav-item nav-icon dropdown caption-content">
                            <a href="#" class="search-toggle dropdown-toggle  d-flex align-items-center"
                                id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">

                                <div class="caption mh-3">
                                    <h6 class="mb-0 line-height">{{ $user->displayname }} <svg
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" fill="currentColor">
                                            <path
                                                d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                            </path>
                                        </svg>
                                    </h6>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-left border-none"
                                aria-labelledby="dropdownMenuButton">
                                <li class="dropdown-item  d-flex svg-icon border-top">

                                    @php
                                        $string = request()->route()->getName();
                                        $modifiedString = str_replace('.', '_', $string);
                                    @endphp

                                    <div data-target="#edit_password_model" data-toggle="modal" class="ph-3 active">
                                        {{ __('Edit your password') }} <i class="ri-key-2-line"></i>
                                    </div>

                                </li>
                                <li class="dropdown-item  d-flex svg-icon border-top">
                                    @if (app()->getLocale() == 'ar')
                                        <a class="btn  " href="{{ route('lang.switch', 'en') }}"><i
                                                class="ri-translate"></i> Change
                                            To English</a>
                                    @else
                                        <div class="ph-3">
                                            <a class="text-center btn" href="{{ route('lang.switch', 'ar') }}">تغيير
                                                للغة للعربيه <i class="ri-translate"></i></a>
                                        </div>
                                    @endif
                                </li>
                                <li class="dropdown-item  d-flex svg-icon border-top">

                                    <form method="POST" action="{{ route('client.logout') }}">
                                        @csrf
                                        <button class=" btn " type="submit">{{ __('Logout') }}</button>
                                    </form>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                        height="24" fill="currentColor">
                                        <path
                                            d="M4 18H6V20H18V4H6V6H4V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V18ZM6 11H13V13H6V16L1 12L6 8V11Z">
                                        </path>
                                    </svg>

                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
@elseif(Auth::check())
    @php
        $user = Auth::user();
    @endphp
    <div class="iq-navbar-custom">
        <nav class="d-flex navbar navbar-expand-lg navbar-light p-0 justify-content-between p-3">
            <div class="  iq-navbar-logo d-flex align-items-center justify-content-between ">

                <i class="ri-menu-line wrapper-menu"></i>
                <a href="{{ route('facilities') }}" class="header-logo">
                    <h4 class="logo-title text-uppercase"> </h4>

                </a>
            </div>
            <a href="{{ route('dashboard') }}"> <img
                    class="{{ app()->getLocale() == 'ar' ? 'border-left' : 'border-right ' }} pr-3  pl-3"
                    style="width: 250px" src="{{ asset('assets/images/logo/msy_new_logo.png') }}" alt="logo"></a>
            <div>
                <p>
                    @php

                        $date = Carbon\Carbon::now()->addHour(3);
                        $locale = app()->getLocale();
                        $formattedDateEn = $date->locale('en')->translatedFormat('l j F Y');
                        $timeInEnglish = $date->format('g:i A');
                        $formattedDateAr = $date->locale('ar')->translatedFormat('l j F Y');
                        $timeInArabic = $date->format('h:i') . ' ' . ($date->format('A') === 'AM' ? 'صباحا' : 'مساءا');
                        $todaysDate = $locale === 'ar' ? $formattedDateAr : $formattedDateEn;
                        $todaysTime = $locale === 'ar' ? $timeInArabic : $timeInEnglish;
                    @endphp

                    {{ $todaysDate }} - {{ $todaysTime }} &nbsp;&nbsp;&nbsp;

                    <button class="btn" type="button" id="popoverButton">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32"
                            fill="currentColor">
                            <path
                                d="M9.98392 5.05991C11.1323 3.22236 13.1734 2 15.5 2C19.0899 2 22 4.91015 22 8.5C22 9.58031 21.7365 10.5991 21.2701 11.4955C22.3351 12.4985 23 13.9216 23 15.5C23 18.5376 20.5376 21 17.5 21H9C4.58172 21 1 17.4183 1 13C1 8.58172 4.58172 5 9 5C9.33312 5 9.66149 5.02036 9.98392 5.05991ZM12.0554 5.60419C14.0675 6.43637 15.6662 8.06578 16.4576 10.0986C16.7951 10.0339 17.1436 10 17.5 10C18.2351 10 18.9366 10.1442 19.5776 10.4059C19.8486 9.82719 20 9.18128 20 8.5C20 6.01472 17.9853 4 15.5 4C14.1177 4 12.8809 4.6233 12.0554 5.60419ZM17.5 19C19.433 19 21 17.433 21 15.5C21 13.567 19.433 12 17.5 12C16.5205 12 15.6351 12.4023 14.9998 13.0507C14.9999 13.0338 15 13.0169 15 13C15 9.68629 12.3137 7 9 7C5.68629 7 3 9.68629 3 13C3 16.3137 5.68629 19 9 19H17.5Z">
                            </path>
                        </svg>
                    </button>


                </p>

            </div>
            @if (Route::current()->getName() == 'settings.languages')
                <button class="btn btn-success langBtn">{{ __('Update') }} </button>
            @endif

            <div class="d-flex align-items-center">
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-label="Toggle navigation">
                    <i class="ri-menu-3-line"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent"
                    style="font-family: 'Line Awesome Free'">
                    <ul class="navbar-nav ml-auto navbar-list align-items-center">
                        <li class="nav-item nav-icon nav-item-icon dropdown">
                            <a href="#" class="search-toggle dropdown-toggle {{count($user->unreadNotifications) > 0 && count($user->undeleteNotifications) > 0 ? 'unreadIcon' : ''}} "
                                id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="true">

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                    height="24" fill="currentColor">
                                    <path
                                        d="M5 18H19V11.0314C19 7.14806 15.866 4 12 4C8.13401 4 5 7.14806 5 11.0314V18ZM12 2C16.9706 2 21 6.04348 21 11.0314V20H3V11.0314C3 6.04348 7.02944 2 12 2ZM9.5 21H14.5C14.5 22.3807 13.3807 23.5 12 23.5C10.6193 23.5 9.5 22.3807 9.5 21Z">
                                    </path>
                                </svg>
                            </a>
                            <div class="iq-sub-dropdown dropdown-menu  " aria-labelledby="dropdownMenuButton2"
                                style="width: 300px !important;border-radius: 0px; {{ app()->getLocale() == 'ar' ? 'right: -200px;' : '' }} ">
                                <div class="card shadow-none m-0">
                                    <div class="card-body p-0 ">
                                        <div class="cust-title p-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h5 class="mb-0">{{ __('Notifications') }}</h5>
                                                @if (count($user->unreadNotifications) > 0 && count($user->undeleteNotifications) > 0)
                                                    <span class="badge badge-primary badge-card"
                                                        href="#">{{ count($user->unreadNotifications) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="sub-card" style="height: 200px;overflow: scroll !important;">
                                            @if (count($user->undeleteNotifications) == 0)
                                                <div class="d-flex justify-content-center align-items-center p-5">
                                                    <p class="   "> {{ __('No New Notifications') }} </p>
                                                </div>
                                            @else
                                                @foreach ($user->undeleteNotifications as $notifiy)
                                                    <div class="d-flex iq-sub-card  align-items-center {{ $notifiy->read == '0' ? 'unread' : '' }} "
                                                        id="notificationCard_{{ $notifiy->id }}">

                                                        <div data-url="{{ $notifiy->url != null ? $notifiy->url : '#' }}"
                                                            class="notificationLink media align-items-center cust-card px-2 py-3 border-bottom"
                                                            style="{{ $notifiy->url != null ? 'cursor: pointer' : '' }} ">
                                                            <div class="media-body  text-center">
                                                                <div
                                                                    class="d-flex align-items-center justify-content-between">
                                                                    <h6 class="mb-0 unreadnotificationTitle">
                                                                        {{ $notifiy->title }}
                                                                    </h6>

                                                                    <small
                                                                        class="text-dark"><b>{{ $notifiy->created_at }}</b>

                                                                    </small>
                                                                </div>
                                                                <small class="mb-0">{{ $notifiy->content }}</small>


                                                            </div>
                                                        </div>
                                                        <div class="px-1">
                                                            <svg class="Deletenotification"
                                                                notifid="{{ $notifiy->id }}"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="18" height="18"
                                                                fill="rgba(236,12,12,1)">
                                                                <path
                                                                    d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 10.5858L9.17157 7.75736L7.75736 9.17157L10.5858 12L7.75736 14.8284L9.17157 16.2426L12 13.4142L14.8284 16.2426L16.2426 14.8284L13.4142 12L16.2426 9.17157L14.8284 7.75736L12 10.5858Z">
                                                                </path>
                                                            </svg>
                                                            @if ($notifiy->read == '0')
                                                                <svg class="readnotification"
                                                                    notifid="{{ $notifiy->id }}"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24" width="18" height="18"
                                                                    fill="rgba(89,89,89,1)">
                                                                    <path
                                                                        d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                                                                    </path>
                                                                </svg>
                                                            @endif

                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item nav-icon dropdown caption-content">
                            <a href="#" class="search-toggle dropdown-toggle  d-flex align-items-center"
                                id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">

                                <div class="caption mh-3">
                                    <h6 class="mb-0 line-height">{{ $user->displayname }} <svg
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" fill="currentColor">
                                            <path
                                                d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                            </path>
                                        </svg>
                                    </h6>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right border" aria-labelledby="dropdownMenuButton">


                                <li class="dropdown-item  d-flex svg-icon  ">
                                    @if (app()->getLocale() == 'ar')
                                        <a class="btn  " href="{{ route('lang.switch', 'en') }}"><i
                                                class="ri-translate"></i> Change
                                            To English</a>
                                    @else
                                        <div class="ph-3">
                                            <a class="text-center btn" href="{{ route('lang.switch', 'ar') }}">تغيير
                                                للغة للعربيه <i class="ri-translate"></i></a>
                                        </div>
                                    @endif
                                </li>
                                <li class="dropdown-item  d-flex svg-icon border-top">

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class=" btn " type="submit">{{ __('Logout') }}</button>
                                    </form>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                        height="24" fill="currentColor">
                                        <path
                                            d="M4 18H6V20H18V4H6V6H4V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V18ZM6 11H13V13H6V16L1 12L6 8V11Z">
                                        </path>
                                    </svg>

                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
        <style>
        .unreadIcon {
            position: relative !important;
        }

        .unreadIcon::before {
            content: '' !important;
            position: absolute !important;
            top: 25px !important; 
            right: 25px !important; 
            width: 10px !important; 
            height: 10px !important; 
            background-color: red !important; 
            border-radius: 50% !important;
            border: 2px solid white !important; 
        }

        .unread {
            border-left: 2px solid #3E40D9;
            background-color: #f7f7f7;
        }
        .Deletenotification{
            cursor: pointer;
        }
        .readnotification{
            cursor: pointer;
        }
    </style>
@endif
