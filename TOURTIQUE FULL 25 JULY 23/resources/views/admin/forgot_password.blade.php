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
    <link href="{{ asset('assets/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('assets/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('assets/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    <link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet" id="style-default">
</head>

<body>
    <main class="main" id="top">
        <div class="container-fluid">
            <div class="row min-vh-100 flex-center g-0 login-bg">
                <div class="col-lg-8 col-xxl-5 py-3 position-relative">
                    <div class="card overflow-hidden z-index-1">
                        <div class="card-body p-0">
                            <div class="row g-0 h-100">
                                <div class="col-md-5 text-center bg-card-gradient">
                                    <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                                        <div class="bg-holder bg-auth-card-shape"
                                            style="background-image:url({{ asset('assets/img/icons/spot-illustrations/half-circle.png') }});">
                                        </div>
                                        <div class="z-index-1 position-relative">
                                            <a class="font-sans-serif fw-bolder fs-4 z-index-1 position-relative link-light light"
                                                href="{{ route('login') }}">{{ get_setting_data('web_title') }}</a>
                                            <p class="opacity-75 text-white">Lorem Ipsum is simply dummy text of the
                                                printing and typesetting industry
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7 d-flex flex-center">
                                    <div class="p-4 p-md-5 flex-grow-1 mb-5">
                                        <img src="{{ get_setting_data('header_logo') != '' ? url('uploads/setting', get_setting_data('header_logo')) : asset('front_assets/images/logo.png') }}"
                                            class="img-fluid logo_img mb-5">
                                        <div class="row mt-4 flex-between-center">
                                            <div class="col-auto">
                                                <h4>Forgot Password</h4>
                                            </div>
                                        </div>
                                        <form class="row g-3 needs-validation" method="post"
                                            action="{{ route('forgot_pasword') }}" novalidate="">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label" for="card-email">Email</label>
                                                <input class="form-control" value="{{ old('email') }}" name="email"
                                                    required="" value="" id="card-email" type="text" />
                                                <div class="invalid-feedback">
                                                    Please Enter Email.
                                                    @if ($errors->has('email'))
                                                        {{ $errors->first('email') }}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row flex-between-center">
                                                <div class="col-auto">
                                                    <a class="fs--1" href="{{ Route('login') }}">
                                                        Login
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="mb-3"><button class="btn btn-primary d-block w-100 mt-3"
                                                    type="submit" name="submit">Send </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/plugins/notify.js') }}"></script>
    <script src="{{ asset('assets/plugins/notify.min.js') }}"></script>
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
            $.notify("{{ $errors->first('success') }}", "success");
        </script>
    @endif
    @if ($errors->has('error'))
        <script>
            $.notify("{{ $errors->first('error') }}", "error");
        </script>
    @endif

</body>

</html>
