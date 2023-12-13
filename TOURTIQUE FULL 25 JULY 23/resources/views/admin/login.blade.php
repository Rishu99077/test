<!DOCTYPE html>
<html lang="en-US" dir="ltr">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ get_setting_data('web_title') }}</title>
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ get_setting_data('favicon') != '' ? url('uploads/setting', get_setting_data('favicon')) : asset('assets/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ get_setting_data('favicon') != '' ? url('uploads/setting', get_setting_data('favicon')) : asset('assets/img/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('assets/img/favicons/mstile-150x150.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('assets/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('assets/css/user.min.css') }}" rel="stylesheet" id="user-style-default">

    <link href="{{ asset('assets/plugins/animate.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet" id="style-default">
</head>

<body>
    <main class="main" id="top">
        <div class="container-fluid">
            <div class="row min-vh-100 bg-100 login-bg">

                <div class="col-sm-10 col-md-6 px-sm-0 align-self-center mx-auto py-5">
                    <div class="row justify-content-center g-0 ">

                        <div class="col-lg-9 col-xl-7 col-xxl-7">
                            <a class="d-flex flex-center mb-4" href="javascript:void(0)">

                                <img class="me-2 w-50"
                                    src="{{ get_setting_data('header_logo') != '' ? url('uploads/setting', get_setting_data('header_logo')) : asset('assets/img/footer.png') }}"
                                    alt="" width="58">
                            </a>
                            <div class="card">

                                <div class="card-body p-4">

                                    <form class="row g-3 needs-validation" method="post" action="{{ route('dologin') }}"
                                        novalidate="">
                                        @csrf
                                        <div>
                                            <label class="form-label" for="card-email">{{ __('admin.text_email') }}
                                                <span class="text-danger">*</span> </label>
                                            <input class="form-control" value="{{ old('email') }}" name="email"
                                                required="" value="" id="card-email" type="text" />
                                            <div class="invalid-feedback">
                                                {{ __('admin.text_please_enter_email') }}
                                                @if ($errors->has('email'))
                                                    {{ $errors->first('email') }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label"
                                                    for="card-password">{{ __('admin.text_password') }} <span
                                                        class="text-danger">*</span> </label>
                                            </div><input class="form-control" name="password" required=""
                                                id="card-password" type="password" />
                                            <div class="invalid-feedback">{{ __('admin.text_please_enter_password') }}
                                            </div>
                                        </div>
                                        <div class="row flex-between-center">

                                            <div class="col-auto">
                                                <a class="fs--1" href="{{ Route('forgot_pasword') }}">
                                                    {{ __('admin.text_forget_password') }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="mb-3"><button class="btn btn-primary d-block w-100 mt-3"
                                                type="submit" name="submit">{{ __('admin.text_login') }}</button>
                                        </div>
                                    </form>
                                    {{-- <div class="position-relative mt-4">
                                        <hr class="bg-300" />
                                        <div class="divider-content-center">or log in with</div>
                                    </div> --}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/plugins/bootstrap-notify.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/alert.js') }}"></script>
    <script src="{{ asset('vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    @if ($errors->has('success'))
        <script>
            success_msg("{{ $errors->first('success') }}");
        </script>
    @endif
    @if ($errors->has('error'))
        <script>
            danger_msg("{{ $errors->first('error') }}");
        </script>
    @endif
</body>

</html>
