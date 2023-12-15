<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">
    <title></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&amp;display=swap"
        rel="stylesheet">
    <style>
        body,
        table,
        tbody,
        tr,
        td,
        ul,
        li,
        a,
        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        div {
            font-family: Poppins, sans-serif;
        }

        :root {
            color-scheme: light dark;
            supported-color-schemes: light dark;
        }

        #outlook a {
            padding: 0;
        }

        body[yahoo] {
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            mso-table-lspace: 0;
            mso-table-rspace: 0;
            empty-cells: show;
        }

        .faux-absolute {
            max-height: 0;
            position: relative;
            opacity: 0.999;
        }

        .faux-position {
            margin-top: 0;
            margin-left: 20%;
            display: inline-block;
            text-align: center;
        }

        body[data-outlook-cycle] .image {
            width: 300px;
        }

        @media only screen and (max-width: 414px) {
            .reset {
                width: 100% !important;
                height: auto !important;
            }

            .hide {
                display: none !important;
            }

            .over-mob {
                max-height: 170px !important;
            }

            .hero-textbox {
                width: 80% !important;
            }

            .left {
                text-align: left !important;
            }
        }
    </style>
</head>
@php
    $url = env('APP_URL');
@endphp

<body class="body">
    <table style="font-size:1rem; background-color: #F8F8F8;width: 700px;margin: 0 auto;" role="presentation"
        align="center" bgcolor="#E4E4E4" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
            <tr style="position: relative; text-align: center;width: 100%;background: #fff;">
                <td style="text-align: center;padding: 20px 10px;;">
                    <img
                        src="{{ get_setting_data('header_logo') != '' ? url('assets/uploads/setting', get_setting_data('header_logo')) : asset('assets/images/logo.png') }}">
                </td>
            </tr>
            <tr>
                <td valign="top" colspan="3" style="padding:25px;">
                    <table class="tourtastique_thanks">
                        <tr>
                            <td style="color: #000;font-size: 16px;font-weight: 500;width: 30%;">Dear
                                {{ $username }}
                            </td>
                            <td style="color: #000;font-size: 14px;font-weight: 500;width: 70%;text-align: right;">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-size:14px;">
                                Welcome to mytket.com
                                {{-- , the ultimate platform for crafting and sharing unforgettable
                                event invitations! We're excited to have you on board and can't wait to see the
                                incredible events you'll create --}}

                            </td>
                        </tr>

                        <tr>
                            <td colspan="2"
                                style="width: 100%;font-size:16px;color: #000;font-weight: 600;padding-top: 25px;">
                                Thank you for choosing mytket.com. Let's make your product truly
                                extraordinary!

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 100%;padding:5px">

                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="width: 100%;font-size:14px;color: #000;">
                                Best regards,
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 100%;font-size:14px;color: #000;">
                                The mytket.com Team
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="width: 100%;padding:5px">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 100%;font-size:14px;color: #000;">
                                Username : {{ $username }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 100%;font-size:14px;color: #000;">
                                Email : {{ $email }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 100%;font-size:14px;color: #000;">
                                Password : {{ $password }}
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="background-color:#F1590C;text-align:center;padding: 10px;">
                    <table style="width: 100%;background-color: #F1590C;">
                        <tbody>
                            <tr>
                                <td style="width: 100%;padding: 25px;" colspan="5"></td>
                            </tr>
                            <tr>
                                <td style="width: 5%;"></td>
                                <td style="width: 35%;">
                                    <img
                                        src="{{ get_setting_data('mail_logo') != '' ? url('uploads/setting', get_setting_data('mail_logo')) : asset('assets/images/logo.png') }}">
                                </td>
                                <td style="width: 20%;"></td>
                                <td style="width: 35%;">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width: 30px;"> <img
                                                    src="{{ asset('uploads/placeholder/globe.png') }}"> </td>
                                            <td
                                                style="color: #fff; font-weight:500; font-size: 14px; line-height: 18px;">
                                                <a href="{{ $url }}"
                                                    style="color: #fff;">&nbsp;www.mytket.com</a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 5%;"></td>
                            </tr>

                            <tr>
                                <td style="width: 100%;padding: 10px;" colspan="5"></td>
                            </tr>

                            <tr>
                                <td style="width: 5%;"></td>
                                <td
                                    style="width: 35%;color: #fff; font-weight:500;  font-family: Cera Pro medium; font-size: 14px; line-height: 18px;opacity: 0.8;">
                                    {!! get_setting_data('footer_description') !!}
                                </td>
                                <td style="width: 20%;"></td>
                                <td style="width: 35%;">
                                    <table>
                                        <tr>
                                            <td colspan="5"
                                                style="color: #fff;  font-weight:bold; font-size: 14px; line-height: 18px">
                                                Follow
                                                Us </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px;" colspan="5"></td>
                                        </tr>
                                        <tr>

                                            <td>
                                                @if (get_setting_data('facebook_link') != '')
                                                    <a href="{{ get_setting_data('facebook_link') }}">
                                                        <img src="{{ asset('uploads/placeholder/facebook.png') }}">
                                                    </a>
                                                @endif
                                            </td>
                                            <td style="padding-left: 10px;">
                                                @if (get_setting_data('twitter_link') != '')
                                                    <a href="{{ get_setting_data('twitter_link') }}">
                                                        <img src="{{ asset('uploads/placeholder/twitter.png') }}">
                                                    </a>
                                                @endif
                                            </td>
                                            <td style="padding-left: 10px;">
                                                @if (get_setting_data('instagram_link') != '')
                                                    <a href="{{ get_setting_data('instagram_link') }}"> <img
                                                            src="{{ asset('uploads/placeholder/instagram_logo.png') }}">
                                                    </a>
                                                @endif
                                            </td>
                                            <td style="padding-left: 10px;">
                                                @if (get_setting_data('linkedin_link') != '')
                                                    <a href="{{ get_setting_data('linkedin_link') }}"> <img
                                                            style="width:38px;height:38px;"
                                                            src="{{ asset('uploads/placeholder/linkedin.png') }}">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 5%;"></td>
                            </tr>

                            <tr>
                                <td style="width: 100%;padding: 25px;" colspan="5"></td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="background-color: #F1590C; width: 100%; padding: 10px;">
                        <tr>
                            <td
                                style="text-align: center; color: #FFFFFF; font-weight:500;  font-family: Cera Pro medium; font-size: 12px;padding: 15px;">
                                {{ get_setting_data('copyright') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
