@if (Auth::check())
    @php
        $user = Auth::user();
    @endphp
    <div class="iq-sidebar  sidebar-default blur-shadow ">

        <div class="data-scrollbar" data-scroll="1">
            <nav class="iq-sidebar-menu">
                <ul id="iq-sidebar-toggle" class="iq-menu">



                    @if ($user->level == '6')
                        <li class="{{ request()->is('dashboard*') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                    fill="currentColor">
                                    <path
                                        d="M14 21C13.4477 21 13 20.5523 13 20V12C13 11.4477 13.4477 11 14 11H20C20.5523 11 21 11.4477 21 12V20C21 20.5523 20.5523 21 20 21H14ZM4 13C3.44772 13 3 12.5523 3 12V4C3 3.44772 3.44772 3 4 3H10C10.5523 3 11 3.44772 11 4V12C11 12.5523 10.5523 13 10 13H4ZM9 11V5H5V11H9ZM4 21C3.44772 21 3 20.5523 3 20V16C3 15.4477 3.44772 15 4 15H10C10.5523 15 11 15.4477 11 16V20C11 20.5523 10.5523 21 10 21H4ZM5 19H9V17H5V19ZM15 19H19V13H15V19ZM13 4C13 3.44772 13.4477 3 14 3H20C20.5523 3 21 3.44772 21 4V8C21 8.55228 20.5523 9 20 9H14C13.4477 9 13 8.55228 13 8V4ZM15 5V7H19V5H15Z">
                                    </path>
                                </svg>
                                <span class="mh-2">{{ __('Dashboard') }} </span>
                            </a>
                        </li>
                    @endif
                    @if ($user->level != '3')
                        <li
                            class="{{ request()->is('facilities*') || Route::current()->getName() == 'createFacility' ? 'active' : '' }}">
                            <a href="{{ route('facilities') }}" class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                    height="24" fill="currentColor">
                                    <path
                                        d="M21 19H23V21H1V19H3V4C3 3.44772 3.44772 3 4 3H14C14.5523 3 15 3.44772 15 4V19H19V11H17V9H20C20.5523 9 21 9.44772 21 10V19ZM5 5V19H13V5H5ZM7 11H11V13H7V11ZM7 7H11V9H7V7Z">
                                    </path>
                                </svg>
                                <span class="mh-2">{{ __('Facilities') }} </span>
                            </a>
                        </li>
                    @endif


                    <li class="{{ request()->is('bookings*') || request()->is('booking-details*') ? 'active' : '' }}">
                        <a href="{{ route('bookings') }}" class="svg-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                fill="currentColor">
                                <path
                                    d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM11 13V17H6V13H11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z">
                                </path>
                            </svg>
                            <span class="mh-2">{{ __('Bookings') }} </span>
                        </a>
                    </li>



                    <li class="{{ request()->is('maintenance*') ? 'active' : '' }}">
                        <a href="{{ route('maintenance') }}" class="svg-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                fill="currentColor">
                                <path
                                    d="M7 3V1H9V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V9H20V5H17V7H15V5H9V7H7V5H4V19H10V21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7ZM17 12C14.7909 12 13 13.7909 13 16C13 18.2091 14.7909 20 17 20C19.2091 20 21 18.2091 21 16C21 13.7909 19.2091 12 17 12ZM11 16C11 12.6863 13.6863 10 17 10C20.3137 10 23 12.6863 23 16C23 19.3137 20.3137 22 17 22C13.6863 22 11 19.3137 11 16ZM16 13V16.4142L18.2929 18.7071L19.7071 17.2929L18 15.5858V13H16Z">
                                </path>
                            </svg>
                            <span class="mh-2">{{ __('Maintenance') }} </span>
                        </a>
                    </li>

                    {{-- @if ($user->level == '6')
                        <li class="{{ request()->is('admins*') ? 'active' : '' }}">
                            <a href="{{ route('admins') }}" class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                    height="24" fill="currentColor">
                                    <path
                                        d="M14 14.252V16.3414C13.3744 16.1203 12.7013 16 12 16C8.68629 16 6 18.6863 6 22H4C4 17.5817 7.58172 14 12 14C12.6906 14 13.3608 14.0875 14 14.252ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11ZM17.7929 19.9142L21.3284 16.3787L22.7426 17.7929L17.7929 22.7426L14.2574 19.2071L15.6716 17.7929L17.7929 19.9142Z">
                                    </path>
                                </svg>
                                <span class="mh-2">{{ __('Admins') }} </span>
                            </a>
                        </li>
                    @endif --}}

                    @if ($user->level == '6')
                        <li class="{{ request()->is('reports*') ? 'active' : '' }}">
                            <a href="{{ route('reports') }}" class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                    height="24" fill="currentColor">
                                    <path
                                        d="M11 7H13V17H11V7ZM15 11H17V17H15V11ZM7 13H9V17H7V13ZM15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z">
                                    </path>
                                </svg>
                                <span class="mh-2">{{ __('Reports') }} </span>
                            </a>
                        </li>
                    @endif
                    @if ($user->level == '6')
                        <li class="{{ request()->is('logs*') ? 'active' : '' }}">
                            <a href="{{ route('logs') }}" class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                    height="24" fill="currentColor">
                                    <path
                                        d="M20.0049 2C21.1068 2 22 2.89821 22 3.9908V20.0092C22 21.1087 21.1074 22 20.0049 22H4V18H2V16H4V13H2V11H4V8H2V6H4V2H20.0049ZM8 4H6V20H8V4ZM20 4H10V20H20V4Z">
                                    </path>
                                </svg>
                                <span class="mh-2">{{ __('Logs') }} </span>
                            </a>
                        </li>
                    @endif

                    {{-- @if ($user->level == '6' || $user->see_users == '1')
                        <li class="{{ request()->is('users*') ? 'active' : '' }}">
                            <a href="{{ route('users') }}" class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                    height="24" fill="currentColor">
                                    <path
                                        d="M2 22C2 17.5817 5.58172 14 10 14C14.4183 14 18 17.5817 18 22H16C16 18.6863 13.3137 16 10 16C6.68629 16 4 18.6863 4 22H2ZM10 13C6.685 13 4 10.315 4 7C4 3.685 6.685 1 10 1C13.315 1 16 3.685 16 7C16 10.315 13.315 13 10 13ZM10 11C12.21 11 14 9.21 14 7C14 4.79 12.21 3 10 3C7.79 3 6 4.79 6 7C6 9.21 7.79 11 10 11ZM18.2837 14.7028C21.0644 15.9561 23 18.752 23 22H21C21 19.564 19.5483 17.4671 17.4628 16.5271L18.2837 14.7028ZM17.5962 3.41321C19.5944 4.23703 21 6.20361 21 8.5C21 11.3702 18.8042 13.7252 16 13.9776V11.9646C17.6967 11.7222 19 10.264 19 8.5C19 7.11935 18.2016 5.92603 17.041 5.35635L17.5962 3.41321Z">
                                    </path>
                                </svg>
                                <span class="mh-2">{{ __('Users') }}</span>
                            </a>
                        </li>
                    @endif --}}


                    @if ($user->level == '6')
                        <li class="{{ request()->is('clients*') || request()->is('admins*') ? 'active' : '' }}">
                            <a href="#users" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                    height="24" fill="currentColor">
                                    <path
                                        d="M2 22C2 17.5817 5.58172 14 10 14C14.4183 14 18 17.5817 18 22H16C16 18.6863 13.3137 16 10 16C6.68629 16 4 18.6863 4 22H2ZM10 13C6.685 13 4 10.315 4 7C4 3.685 6.685 1 10 1C13.315 1 16 3.685 16 7C16 10.315 13.315 13 10 13ZM10 11C12.21 11 14 9.21 14 7C14 4.79 12.21 3 10 3C7.79 3 6 4.79 6 7C6 9.21 7.79 11 10 11ZM18.2837 14.7028C21.0644 15.9561 23 18.752 23 22H21C21 19.564 19.5483 17.4671 17.4628 16.5271L18.2837 14.7028ZM17.5962 3.41321C19.5944 4.23703 21 6.20361 21 8.5C21 11.3702 18.8042 13.7252 16 13.9776V11.9646C17.6967 11.7222 19 10.264 19 8.5C19 7.11935 18.2016 5.92603 17.041 5.35635L17.5962 3.41321Z">
                                    </path>
                                </svg>
                                <span class="mh-2">{{ __('Users') }} </span>
                                <i
                                    class="ri-arrow-{{ app()->getlocale() == 'ar' ? 'left' : 'right' }}-s-line iq-arrow-right arrow-active"></i>

                                <i class="ri-arrow-down-s-line iq-arrow-right arrow-hover"></i>
                            </a>
                            <ul id="users"
                                class="iq-submenu  {{ request()->is('clients*') || request()->is('admins*') ? 'collapsed' : 'collapse' }}"
                                data-parent="#iq-sidebar-toggle">
                                <li class="{{ request()->is('clients*') ? 'active' : ' ' }}">
                                    <a href="{{ route('clients') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" fill="currentColor">
                                            <path
                                                d="M8.5 7C8.5 8.10457 7.60457 9 6.5 9C5.39543 9 4.5 8.10457 4.5 7C4.5 5.89543 5.39543 5 6.5 5C7.60457 5 8.5 5.89543 8.5 7ZM2.5 7C2.5 9.20914 4.29086 11 6.5 11C8.70914 11 10.5 9.20914 10.5 7C10.5 4.79086 8.70914 3 6.5 3C4.29086 3 2.5 4.79086 2.5 7ZM9 16.5C9 15.1193 7.88071 14 6.5 14C5.11929 14 4 15.1193 4 16.5V19H9V16.5ZM11 21H2V16.5C2 14.0147 4.01472 12 6.5 12C8.98528 12 11 14.0147 11 16.5V21ZM19.5 7C19.5 8.10457 18.6046 9 17.5 9C16.3954 9 15.5 8.10457 15.5 7C15.5 5.89543 16.3954 5 17.5 5C18.6046 5 19.5 5.89543 19.5 7ZM13.5 7C13.5 9.20914 15.2909 11 17.5 11C19.7091 11 21.5 9.20914 21.5 7C21.5 4.79086 19.7091 3 17.5 3C15.2909 3 13.5 4.79086 13.5 7ZM20 16.5C20 15.1193 18.8807 14 17.5 14C16.1193 14 15 15.1193 15 16.5V19H20V16.5ZM13 19V16.5C13 14.0147 15.0147 12 17.5 12C19.9853 12 22 14.0147 22 16.5V21H13V19Z">
                                            </path>
                                        </svg> <span class="mh-1">{{ __('Clients') }}</span>
                                    </a>
                                </li>
                                <li class="{{ request()->is('admins*') ? 'active' : ' ' }}">
                                    <a href="{{ route('admins') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" fill="currentColor">
                                            <path
                                                d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H4ZM13 16.083V20H17.6586C16.9423 17.9735 15.1684 16.4467 13 16.083ZM11 20V16.083C8.83165 16.4467 7.05766 17.9735 6.34141 20H11ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.2104 11 16 9.21043 16 7C16 4.78957 14.2104 3 12 3C9.78957 3 8 4.78957 8 7C8 9.21043 9.78957 11 12 11Z">
                                            </path>
                                        </svg><span class="mh-1">{{ __('Admins') }}</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endif
                    @if ($user->level == '6')
                        <li class="{{ request()->is('settings*') ? 'active' : '' }}">
                            <a href="#settings" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                    height="24" fill="currentColor">
                                    <path
                                        d="M2 11.9998C2 11.1353 2.1097 10.2964 2.31595 9.49631C3.40622 9.55283 4.48848 9.01015 5.0718 7.99982C5.65467 6.99025 5.58406 5.78271 4.99121 4.86701C6.18354 3.69529 7.66832 2.82022 9.32603 2.36133C9.8222 3.33385 10.8333 3.99982 12 3.99982C13.1667 3.99982 14.1778 3.33385 14.674 2.36133C16.3317 2.82022 17.8165 3.69529 19.0088 4.86701C18.4159 5.78271 18.3453 6.99025 18.9282 7.99982C19.5115 9.01015 20.5938 9.55283 21.6841 9.49631C21.8903 10.2964 22 11.1353 22 11.9998C22 12.8643 21.8903 13.7032 21.6841 14.5033C20.5938 14.4468 19.5115 14.9895 18.9282 15.9998C18.3453 17.0094 18.4159 18.2169 19.0088 19.1326C17.8165 20.3043 16.3317 21.1794 14.674 21.6383C14.1778 20.6658 13.1667 19.9998 12 19.9998C10.8333 19.9998 9.8222 20.6658 9.32603 21.6383C7.66832 21.1794 6.18354 20.3043 4.99121 19.1326C5.58406 18.2169 5.65467 17.0094 5.0718 15.9998C4.48848 14.9895 3.40622 14.4468 2.31595 14.5033C2.1097 13.7032 2 12.8643 2 11.9998ZM6.80385 14.9998C7.43395 16.0912 7.61458 17.3459 7.36818 18.5236C7.77597 18.8138 8.21005 19.0652 8.66489 19.2741C9.56176 18.4712 10.7392 17.9998 12 17.9998C13.2608 17.9998 14.4382 18.4712 15.3351 19.2741C15.7899 19.0652 16.224 18.8138 16.6318 18.5236C16.3854 17.3459 16.566 16.0912 17.1962 14.9998C17.8262 13.9085 18.8225 13.1248 19.9655 12.7493C19.9884 12.5015 20 12.2516 20 11.9998C20 11.7481 19.9884 11.4981 19.9655 11.2504C18.8225 10.8749 17.8262 10.0912 17.1962 8.99982C16.566 7.90845 16.3854 6.65378 16.6318 5.47605C16.224 5.18588 15.7899 4.93447 15.3351 4.72552C14.4382 5.52844 13.2608 5.99982 12 5.99982C10.7392 5.99982 9.56176 5.52844 8.66489 4.72552C8.21005 4.93447 7.77597 5.18588 7.36818 5.47605C7.61458 6.65378 7.43395 7.90845 6.80385 8.99982C6.17376 10.0912 5.17754 10.8749 4.03451 11.2504C4.01157 11.4981 4 11.7481 4 11.9998C4 12.2516 4.01157 12.5015 4.03451 12.7493C5.17754 13.1248 6.17376 13.9085 6.80385 14.9998ZM12 14.9998C10.3431 14.9998 9 13.6567 9 11.9998C9 10.343 10.3431 8.99982 12 8.99982C13.6569 8.99982 15 10.343 15 11.9998C15 13.6567 13.6569 14.9998 12 14.9998ZM12 12.9998C12.5523 12.9998 13 12.5521 13 11.9998C13 11.4475 12.5523 10.9998 12 10.9998C11.4477 10.9998 11 11.4475 11 11.9998C11 12.5521 11.4477 12.9998 12 12.9998Z">
                                    </path>
                                </svg>
                                <span class="mh-2">{{ __('Settings') }} </span>
                                <i
                                    class="ri-arrow-{{ app()->getlocale() == 'ar' ? 'left' : 'right' }}-s-line iq-arrow-right arrow-active"></i>

                                <i class="ri-arrow-down-s-line iq-arrow-right arrow-hover"></i>
                            </a>
                            <ul id="settings"
                                class="iq-submenu  {{ request()->is('settings*') ? 'collapsed' : 'collapse' }}"
                                data-parent="#iq-sidebar-toggle">
                                <li class="{{ request()->is('settings/notifications*') ? 'active' : ' ' }}">
                                    <a href="{{ route('settings.notifications') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                            height="18" fill="currentColor">
                                            <path
                                                d="M18 10C18 6.68629 15.3137 4 12 4C8.68629 4 6 6.68629 6 10V18H18V10ZM20 18.6667L20.4 19.2C20.5657 19.4209 20.5209 19.7343 20.3 19.9C20.2135 19.9649 20.1082 20 20 20H4C3.72386 20 3.5 19.7761 3.5 19.5C3.5 19.3918 3.53509 19.2865 3.6 19.2L4 18.6667V10C4 5.58172 7.58172 2 12 2C16.4183 2 20 5.58172 20 10V18.6667ZM9.5 21H14.5C14.5 22.3807 13.3807 23.5 12 23.5C10.6193 23.5 9.5 22.3807 9.5 21Z">
                                            </path>
                                        </svg> <span class="mh-1">{{ __('Notification') }}</span>
                                    </a>
                                </li>
                                <li class="{{ request()->is('settings/attachments*') ? 'active' : ' ' }}">
                                    <a href="{{ route('settings.attachments') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                            height="18" fill="currentColor">
                                            <path
                                                d="M14 13.5V8C14 5.79086 12.2091 4 10 4C7.79086 4 6 5.79086 6 8V13.5C6 17.0899 8.91015 20 12.5 20C16.0899 20 19 17.0899 19 13.5V4H21V13.5C21 18.1944 17.1944 22 12.5 22C7.80558 22 4 18.1944 4 13.5V8C4 4.68629 6.68629 2 10 2C13.3137 2 16 4.68629 16 8V13.5C16 15.433 14.433 17 12.5 17C10.567 17 9 15.433 9 13.5V8H11V13.5C11 14.3284 11.6716 15 12.5 15C13.3284 15 14 14.3284 14 13.5Z">
                                            </path>
                                        </svg><span class="mh-1">{{ __('Attachments') }}</span>
                                    </a>
                                </li>
                                <li class="{{ request()->is('settings/languages*') ? 'active' : ' ' }}">
                                    <a href="{{ route('settings.languages') }}" class="active">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                            height="18" fill="currentColor">
                                            <path
                                                d="M5 15V17C5 18.0544 5.81588 18.9182 6.85074 18.9945L7 19H10V21H7C4.79086 21 3 19.2091 3 17V15H5ZM18 10L22.4 21H20.245L19.044 18H14.954L13.755 21H11.601L16 10H18ZM17 12.8852L15.753 16H18.245L17 12.8852ZM8 2V4H12V11H8V14H6V11H2V4H6V2H8ZM17 3C19.2091 3 21 4.79086 21 7V9H19V7C19 5.89543 18.1046 5 17 5H14V3H17ZM6 6H4V9H6V6ZM10 6H8V9H10V6Z">
                                            </path>
                                        </svg><span class="mh-1">{{ __('Languages') }}</span>
                                    </a>
                                </li>
                                <li class="{{ request()->is('settings/facilityTypes*') ? 'active' : ' ' }}">
                                    <a href="{{ route('settings.facility.types') }}" class="active">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" fill="currentColor">
                                            <path
                                                d="M15 8.48216V15.518L8.96922 12.0001L15 8.48216ZM16.248 5.43872L5.74033 11.5682C5.50181 11.7073 5.42124 12.0135 5.56038 12.252C5.60384 12.3265 5.66583 12.3885 5.74033 12.432L16.248 18.5615C16.4865 18.7006 16.7927 18.62 16.9318 18.3815C16.9764 18.305 17 18.2181 17 18.1296V5.87061C17 5.59446 16.7761 5.37061 16.5 5.37061C16.4114 5.37061 16.3245 5.39411 16.248 5.43872Z">
                                            </path>
                                        </svg><span class="mh-1">{{ __('Facility Types') }}</span>
                                    </a>
                                </li>
                                <li class="{{ request()->is('settings/subFacilityTypes*') ? 'active' : ' ' }}">
                                    <a href="{{ route('settings.subfacility.types') }}" class="active">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" fill="currentColor">
                                            <path
                                                d="M15 8.48216V15.518L8.96922 12.0001L15 8.48216ZM16.248 5.43872L5.74033 11.5682C5.50181 11.7073 5.42124 12.0135 5.56038 12.252C5.60384 12.3265 5.66583 12.3885 5.74033 12.432L16.248 18.5615C16.4865 18.7006 16.7927 18.62 16.9318 18.3815C16.9764 18.305 17 18.2181 17 18.1296V5.87061C17 5.59446 16.7761 5.37061 16.5 5.37061C16.4114 5.37061 16.3245 5.39411 16.248 5.43872Z">
                                            </path>
                                        </svg><span class="mh-1">{{ __('Sub Facility Types') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif



                </ul>
            </nav>
        </div>
    </div>
@elseif(Auth::guard('client')->check())
    @php
        $user = Auth::guard('client')->user();
    @endphp
    <div class="iq-sidebar  sidebar-default blur-shadow ">

        <div class="data-scrollbar" data-scroll="1">
            <nav class="iq-sidebar-menu">
                <ul id="iq-sidebar-toggle" class="iq-menu">
                    <li
                        class="{{ request()->is('facilities*') || Route::current()->getName() == 'createFacility' ? 'active' : '' }}">
                        <a href="{{ route('facilities') }}" class="svg-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                height="24" fill="currentColor">
                                <path
                                    d="M21 19H23V21H1V19H3V4C3 3.44772 3.44772 3 4 3H14C14.5523 3 15 3.44772 15 4V19H19V11H17V9H20C20.5523 9 21 9.44772 21 10V19ZM5 5V19H13V5H5ZM7 11H11V13H7V11ZM7 7H11V9H7V7Z">
                                </path>
                            </svg>
                            <span class="mh-2">{{ __('Facilities') }} </span>
                        </a>
                    </li>


                    <li
                        class="{{ request()->is('mybookings*') || request()->is('booking-details*') ? 'active' : '' }}">
                        <a href="{{ route('mybookings') }}" class="svg-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                height="24" fill="currentColor">
                                <path
                                    d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM11 13V17H6V13H11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z">
                                </path>
                            </svg>
                            <span class="mh-2">{{ __('My Bookings') }} </span>
                        </a>
                    </li>



                    {{-- <li class="{{ request()->is('maintenance*') ? 'active' : '' }}">
                        <a href="{{ route('maintenance') }}" class="svg-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                height="24" fill="currentColor">
                                <path
                                    d="M7 3V1H9V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V9H20V5H17V7H15V5H9V7H7V5H4V19H10V21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7ZM17 12C14.7909 12 13 13.7909 13 16C13 18.2091 14.7909 20 17 20C19.2091 20 21 18.2091 21 16C21 13.7909 19.2091 12 17 12ZM11 16C11 12.6863 13.6863 10 17 10C20.3137 10 23 12.6863 23 16C23 19.3137 20.3137 22 17 22C13.6863 22 11 19.3137 11 16ZM16 13V16.4142L18.2929 18.7071L19.7071 17.2929L18 15.5858V13H16Z">
                                </path>
                            </svg>
                            <span class="mh-2">{{ __('Maintenance') }} </span>
                        </a>
                    </li> --}}


                </ul>
            </nav>
        </div>
    </div>

@endif
