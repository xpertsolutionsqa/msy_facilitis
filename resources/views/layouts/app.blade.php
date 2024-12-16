<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ __('APP TITLE') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/msy_logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/backend/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/remixicon/fonts/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="lang" content="{{ app()->getLocale() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.bubble.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css') }}">

    <link rel="stylesheet"
        href="{{ asset('assets/backend/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/backend/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css') }}">

    @if (app()->getLocale() == 'ar')
        <style>
            .page-item:last-child .page-link {
                border-bottom-left-radius: 16px !important;
                border-top-left-radius: 16px !important;
                border-bottom-right-radius: 0px !important;
                border-top-right-radius: 0px !important;
            }

            .page-item:first-child .page-link {
                border-bottom-left-radius: 0px !important;
                border-top-left-radius: 0px !important;
                border-bottom-right-radius: 16px !important;
                border-top-right-radius: 16px !important;
            }
        </style>
    @endif
</head>

<body dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <div id="popoverContent" style="display: none;">
        <div class="rounded" id="ww_7d6ee34968489" v='1.3' loc='auto'
            a='{"t":"horizontal","lang":"{{ app()->getLocale() }}","sl_lpl":1,"ids":["wl4431"],"font":"Lusail","sl_ics":"one","sl_sot":"celsius","cl_bkg":"image","cl_font":"#FFFFFF","cl_cloud":"#FFFFFF","cl_persp":"#81D4FA","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722","el_whr":3}'>
            More forecasts: <a href="https://oneweather.org/fuerteventura/august/" id="ww_7d6ee34968489_u"
                target="_blank">Weather in Fuerteventura August</a></div>
        <script async src="https://app2.weatherwidget.org/js/?id=ww_7d6ee34968489"></script>
    </div>

     <img style="height: 30px;display:none" src="https://msy.gov.qa/sfb/public/assets/images/spinner.gif" alt="Loading..."> 

    @yield('content')



    @if (auth()->guard('client')->check())
        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="edit_password_model">
            <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title">{{ __('Edit your password') }}</h3>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('client.changepassword') }}" id="updatePasswordForm" method="post">
                            @csrf

                            <div class=" row p-3">
                                <div class="form-groug col-4">
                                    <label for="current_pass"
                                        class="col-form-label">{{ __('Your Current Password') }}</label>
                                    <input type="password" class="form-control required" name="current_pass">

                                </div>
                                <div class="form-groug col-4">
                                    <label for="new_pass" class="col-form-label">{{ __('New Password') }}</label>
                                    <input type="password" class="form-control required" id="new_password"
                                        name="new_pass">

                                </div>
                                <div class="form-groug col-4">
                                    <label for="confim_pass"
                                        class="col-form-label">{{ __('Confirm new password') }}</label>
                                    <input type="password" class="form-control required" name="confim_pass"
                                        id="confirm_password">

                                </div>
                            </div>
                            <div class="row">
                                <div class="error-msg" id="pass-error-msg"></div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-secondary btn-block"
                                        data-dismiss="modal" aria-label="Close"> {{ __('Cancel') }} </button>
                                </div>

                                <div class="col-6">
                                    <button class="btn-block btn btn-outline-primary"
                                        type="submit">{{ __('Edit') }}</button>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (auth()->check())
        @if (auth()->user()->level == '1' || auth()->user()->level == '6')
            <div id="DeleteFacilityModel"></div>
        @endif
    @endif

    @if (auth()->check())
        @if (auth()->user()->level == '2' || auth()->user()->level == '6')
            <div id="DeleteMinModel"></div>
        @endif
    @endif


    <div style="z-index: 15000000" class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true"
        id="image_view">
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bttom">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title">{{ __('File View') }} </h3>
                </div>
                <div class="modal-body text-center">
                    <img id="imagesrc">

                </div>
            </div>
        </div>
    </div>






    @include('layouts.footer')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="{{ asset('assets/backend/js/backend-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/table-treeview.js') }}"></script>
    
    <script src="{{ asset('assets/backend/js/admin-site.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/backend/vendor/moment.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/app.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/tui-calendar/tui-code-snippet/dist/tui-code-snippet.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/tui-calendar/tui-calendar/dist/tui-calendar.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>const { jsPDF } = window.jspdf;</script>
    <script src="{{ asset('assets/fonts/Lusail.js') }}"></script>
    {{-- <script src="https://cdn.tiny.cloud/1/7p3tve4gusq7tfykm9xvdo39bbc2fle8go39qbv1mp6edwrf/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script> --}}
    @if (auth()->check())
        @include('layouts.script')
    @endif
    @if (auth()->guard('client')->check())
        @include('layouts.client.script')
    @endif


    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                $('.iq-sub-dropdown').on('click', function(e) {
                    e.stopPropagation(); 
                });
            });
            var weatherWidgetHtml =
                '<div class="weatherwidget-io" data-label_1="TEHRAN" data-label_2="WEATHER" data-theme="original">TEHRAN WEATHER</div>';

            $('#weatherButton').popover({
                content: weatherWidgetHtml,
                trigger: 'click',
                placement: 'bottom',
                html: true
            });

            $('#weatherButton').on('shown.bs.popover', function() {
                if (!document.getElementById('weatherwidget-io-js')) {
                    var script = document.createElement('script');
                    script.id = 'weatherwidget-io-js';
                    script.src = 'https://weatherwidget.io/js/widget.min.js';
                    document.body.appendChild(script);
                }
            });
            $('.Deletenotification').on('click', function() {
                var id = $(this).attr('notifid');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('notification.delete') }}",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        id: id,
                        type: '1'
                    },
                    success: function(data) {
                        if (data.status == 'true') {
                            $("#notificationCard_" + id).remove();
                        } else {
                            console.log(data);

                            showError();
                        }
                    },
                    error: function() {
                    }
                });
            });
            $('.readnotification').on('click', function() {
                var id = $(this).attr('notifid');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('notification.delete') }}",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        id: id,
                        type: '2'
                    },
                    success: function(data) {
                        if (data.status == 'true') {
                            $("#notificationCard_" + id).removeClass('unread');
                            $(this).hide();
                        } else {
                            console.log(data);
    
                            showError();
                        }
                    },
                    error: function() {
                    
                    }
                });
            });
        });
    </script>
</body>


</html>
