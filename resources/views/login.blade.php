<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MSY | {{ __('login') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/msy_logo.png') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('assets/backend/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet"  
        href="{{ asset('assets/backend/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/remixicon/fonts/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/backend/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/backend/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/all.css" />
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-solid.css" />
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-regular.css" />
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-light.css" />

</head>

<body>
    <div class="wrapper">
        <section class="login-content">
            <div class="container">
                <div class="row align-items-center justify-content-center height-self-center">
                    <div class="col-lg-8">
                        <div class="card auth-card">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center auth-content">
                                    <div class="col-lg-6  content-left" style="background-color: #8A1538">
                                        <div class="p-3">
                                            <h2 class="mb-2 text-white text-center">{{ __('login') }}</h2>
                                            <p class="text-white text-center"> {{ __('MSY_SYSTEM') }} </p>
                                            <form method="POST" action="{{ route('user.login') }}">
                                                @csrf
                                                <input type="hidden" name="redirecturl" value="{{ old('url') }}">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class=" form-group">
                                                            <input
                                                                dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
                                                                placeholder="{{ __('username') }}" name="username"
                                                                class=" form-control" type="text" placeholder=" ">
                                                            {{-- <label class="text-white"> {{ __('username') }} </label> --}}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="  form-group">
                                                            <input
                                                                dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
                                                                placeholder="{{ __('password') }}" name="password"
                                                                class=" form-control" type="password" placeholder=" ">
                                                            {{-- <label> {{ __('password') }} </label> --}}
                                                        </div>
                                                    </div>
  
                                                    <div class="d-flex justify-content-center w-100">
                                                        <div class="g-recaptcha p-1  "
                                                            data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}">

                                                        </div>
                                                    </div>



                                                  {{--
                                                    <div style="display: none" class="error-msg"
                                                        id="recaptcha-error-msg">
                                                        الرجاء إدخال ال
                                                        recaptcha</div> --}}


                                                </div>
                                                <button type="submit"
                                                    class="btn btn-block btn-white">{{ __('login') }}</button>

                                            </form>


                                            <div class="border-bottom p-2"></div>

                                            {{-- <div class="row">

                                                
                                                 @if (app()->getLocale() == 'ar')
                                                    <div class="text-right"> <a class="btn btn-outline-secondary"
                                                            href="{{ route('lang.switch', 'en') }}">Change To
                                                            English</a>
                                                    </div>
                                                @else
                                                    <div class="text-right"> <a class="btn btn-outline-secondary"
                                                            href="{{ route('lang.switch', 'ar') }}">تغيير اللغة
                                                            للعربيه</a>
                                                    </div>
                                                @endif 
                                            </div> --}}
                                            <a href="{{ route('auth.redirect') }}" class="col-md-12">
                                                <div
                                                    class="btn btn-white d-flex justify-content-between align-items-center">

                                                    <img style="padding: 0px;margin:0px" width="70px" height="70px"
                                                        src="{{ asset('assets/images/nas.png') }}" alt=""
                                                        srcset="">

                                                    <div class="text-primary">{{ __('Login By Nas') }}</div>
                                                </div>

                                            </a>



                                        </div>
                                    </div>
                                    <div class="col-lg-6 content-right">
                                        <img src="./assets/images/logo/msy_logo.png" alt="logo">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('assets/backend/js/backend-bundle.min.js') }}"></script>

    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('assets/backend/js/table-treeview.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('assets/backend/js/customizer.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('assets/backend/js/app.js') }}"></script>

    <script src="{{ asset('assets/backend/vendor/moment.min.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        @if ($errors->has('login'))
            Swal.fire({
                icon: 'error',
                title: 'عذرا خطأ في تسجيل الدخول',
                text: 'الرجاء التأكد من اسم المستخدم وكلمة المرور المدخلة بشكل صحيح',
                confirmButtonText: 'إعادة المحاوله'
            });
        @endif
        @if ($errors->has('Please login First'))
            Swal.fire({
                toast: true,
                position: "top-start",
                icon: "error",
                title: "{{ __('messages.Please login First') }}",
                showConfirmButton: false,
                timer: 1500
            });
        @endif
        @if ($errors->has('Invalid user'))
            Swal.fire({
                icon: 'error',
                title: 'عذرا خطأ في تسجيل الدخول',
                text: 'الرجاء التأكد من حسابك ما زال فعالا ولم تتم إزالته ',
                confirmButtonText: 'إعادة المحاوله'
            });
        @endif
        @if ($errors->has('reCAPTCHA'))
         
            Swal.fire({
                icon: 'error',
                title: 'خطأ في التحقق ',
                text: 'الرجاء إدخال الreCAPTCHA',
                toast: true,
                position: "top-start",
                showConfirmButton: false,
                timer: 2500
            });
        @endif
    </script>
</body>

</html>
