<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ get_setting_data('web_title') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Phoenixcoded">

    <!-- Favicon icon -->

    <link rel="icon"
        href="{{ get_setting_data('favicon') != '' ? url('uploads/setting', get_setting_data('favicon')) : '' }}"
        type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/icofont/css/icofont.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/color/color-1.css') }}" id="color" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}">
</head>

<body class="fix-menu">
    <section class="login p-fixed d-flex text-center bg-primary common-img-bg" style="background: #fff;">
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                    <div class="login-card card-block auth-body">
                        <form class="md-float-material" method="post" action="{{ route('dologin') }}">
                            @csrf
                            <div class="text-center">
                                <img src="{{ get_setting_data('header_logo') != '' ? url('uploads/setting', get_setting_data('header_logo')) : asset('assets/images/logo.png') }}"
                                    alt="{{ get_setting_data('web_title') }}" style="max-width: 300px;">
                            </div>
                            <div class="auth-box">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-left txt-primary">{{ translate('Sign In') }}</h3>
                                    </div>
                                </div>
                                <hr />
                                <div class="form-group  {{ $errors->has('email') ? 'has-danger' : '' }} ">
                                    <input type="email" value="{{ old('email') }}"
                                        class="form-control {{ $errors->has('email') ? 'form-control-danger' : '' }}"
                                        name="email" placeholder="{{ translate('Your Email Address') }}">
                                    <span class="md-line"></span>
                                    <div class="col-form-alert-label">
                                        @if ($errors->has('email'))
                                            {{ $errors->first('email') }}
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('password') ? 'has-danger' : '' }}">
                                    <input type="password"
                                        class="form-control {{ $errors->has('password') ? 'form-control-danger' : '' }}"
                                        name="password" placeholder="{{ translate('Password') }}">
                                    <span class="md-line"></span>
                                    <div class=".col-form-alert-label">
                                        @if ($errors->has('password'))
                                            {{ $errors->first('password') }}
                                        @endif
                                    </div>

                                </div>
                                <div class="row m-t-25 text-left">
                                    <div class="col-sm-5 col-xs-12">

                                    </div>
                                    <div class="col-sm-7 col-xs-12 forgot-phone text-right">
                                        <a href="{{ route('forgot_password') }}"
                                            class="text-right f-w-600 text-inverse">{{ translate('Forgot Your Password?') }}</a>
                                    </div>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="submit"
                                            class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">{{ translate('Sign In') }}</button>
                                    </div>
                                </div>
                                <hr />

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript" src="{{ asset('assets/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/customjs/notify.min.js') }}"></script>
    <script src="{{ asset('assets/customjs/notify.js') }}"></script>
    <script src="{{ asset('assets/customjs/alert.js') }}"></script>
    @if ($errors->has('success'))
        <script>
            success_msg("{{ $errors->first('success') }}")
        </script>
    @endif
    @if ($errors->has('error'))
        <script>
            danger_msg("{{ $errors->first('error') }}");
        </script>
    @endif
</body>

</html>
