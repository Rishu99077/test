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
                        <form class="md-float-material" method="post" action="{{ route('forgot_password') }}">
                            @csrf
                            <div class="text-center">
                                <img src="{{ get_setting_data('login_logo_image') != '' ? url('uploads/setting', get_setting_data('login_logo_image')) : asset('assets/images/logo-white.png') }}"
                                    alt="{{ get_setting_data('web_title') }}" style="max-width: 300px;">
                            </div>
                            <div class="auth-box">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-left">{{ translate('Change Your Password') }} </h3>
                                    </div>
                                </div>
                                <input type="hidden" name="token" value="{{ $user_id }}">
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

                                <div class="form-group {{ $errors->has('confirm_password') ? 'has-danger' : '' }}">
                                    <input type="confirm_password"
                                        class="form-control {{ $errors->has('confirm_password') ? 'form-control-danger' : '' }}"
                                        name="confirm_password" placeholder="{{ translate('confirm_Password') }}">
                                    <span class="md-line"></span>
                                    <div class=".col-form-alert-label">
                                        @if ($errors->has('confirm_password'))
                                            {{ $errors->first('confirm_password') }}
                                        @endif
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit"
                                            class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">{{ translate('Update Password') }}</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="{{ route('login') }}">{{ translate('Back to login') }}</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="{{ route('signup') }}">{{ translate('Back to Signup') }}</a>
                                    </div>
                                </div>

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
