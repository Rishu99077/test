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
                                {{ $user_name }}
                            </td>
                        </tr>
                    </table>
                    <table class="tourtastique_thanks">
                        <tr>
                            <td colspan="2"
                                style="width: 100%;font-size:16px;color: #000;font-weight: 600;padding-top: 25px;">
                                Thank you for choosing mytket.com.
                            </td>
                        </tr>

                        <tr>
                            <td style="color: #000;font-size: 16px;font-weight: 500;width: 30%;">
                                Order ID : {{ $orders['order_id'] }}
                            </td>
                        </tr>

                    </table>

                    <table class="tourtastique_thanks table-bodred" border="1">
                        <tbody>
                            <tr>
                                <td style="padding: 0px 15px;font-size: 14px;margin-top: 10px;margin-bottom: -10px;">
                                    Tour</td>
                                <td style="padding: 0px 15px;font-size: 14px;margin-top: 10px;margin-bottom: -10px;">
                                    Activity Type</td>
                                <td style="padding: 0px 15px;font-size: 14px;margin-top: 10px;margin-bottom: -10px;">
                                    Booking date</th>
                                <td style="padding: 0px 15px;font-size: 14px;margin-top: 10px;margin-bottom: -10px;">
                                    Price</th>
                                <td style="padding: 0px 15px;font-size: 14px;margin-top: 10px;margin-bottom: -10px;">
                                    Total Price</td>
                            </tr>

                        </tbody>
                        @if (isset($products->detail))
                            @foreach ($products->detail as $key => $value)
                                <tbody>
                                    <tr>
                                        <td
                                            style="padding: 0px 15px;font-size: 14px;margin-top: 10px;margin-bottom: -10px;">
                                            <div class="all-prd-info">

                                                <div class="prd-info-detail">
                                                    <p class="tag_p_table"> <b>{{ $value->title }}</b> </p>
                                                    <span class="tag_span_table">{{ $value->location }}</span>
                                                </div>
                                        </td>
                                        <td
                                            style="padding: 0px 15px;font-size: 14px;margin-top: 10px;margin-bottom: -10px;">
                                            {{ $value->activity_type }} </td>
                                        <td> {{ $value->time_slot }} {{ $value->date }}</td>

                                        <td
                                            style="padding: 0px 15px;font-size: 14px;margin-top: 10px;margin-bottom: -10px;">
                                            @if (isset($value->price_brakdown))
                                                @foreach ($value->price_brakdown as $key2 => $value_brakdown)
                                                    <p>{{ $value_brakdown->totalParticipants }}
                                                        {{ $value_brakdown->title }} X
                                                        {{ $value_brakdown->title == 'Participants' ? get_price_front('', '', '', '', $value_brakdown->pricePerPerson / $value_brakdown->totalParticipants) : get_price_front('', '', '', '', $value_brakdown->pricePerPerson) }}
                                                        :
                                                        {{ $value_brakdown->totalPrice }}</p>
                                                @endforeach
                                            @endif
                                        </td
                                            style="padding: 0px 15px;font-size: 14px;margin-top: 10px;margin-bottom: -10px;">

                                        <td
                                            style="padding: 0px 15px;font-size: 14px;margin-top: 10px;margin-bottom: -10px;">
                                            <span class="text-icon-color">$</span> {{ $value->totalAmount }}
                                            @if (isset($value->tax))
                                                @foreach ($value->tax as $key3 => $value_tax)
                                                    <p class="mb-0">{{ $value_tax->title }}
                                                        @if ($value_tax->type == 'percentage')
                                                            ({{ $value_tax->basic }} %)
                                                        @endif: <span
                                                            class="text-icon-color">{{ $value_tax->format_amount }}</span>
                                                    </p>
                                                @endforeach
                                            @endif
                                            @php
                                                $coupon_amount = 0;
                                            @endphp
                                            @if (isset($value->couponText) && isset($value->coupon_amount))
                                                @php
                                                    $coupon_amount = $value->coupon_amount;
                                                @endphp
                                                <p class="mb-0">{{ $value->couponText }} :
                                                    <span>{{ $value->coupon_amount }}</span>
                                                </p>
                                            @endif

                                            @if (isset($value->affilliate_commission))
                                                <p class="mb-0">Affiliate Commission
                                                    ({{ $value->affilliate_commission->commission }} %)
                                                    : <span class="text-icon-color">
                                                        <?php echo get_price_front('', '', '', '', $value->affilliate_commission->commission_amount); ?></span></p>
                                            @endif

                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        @else
                            <tbody>
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <h3>{{ config('adminconfig.record_not_found') }}</h3>
                                    </td>
                                </tr>
                            <tbody>
                        @endif

                        <tbody>
                            @if (isset($commissions['total']))
                                <tr>
                                    <td style="padding: 0px 15px;font-size: 14px;margin-top: 10px;margin-bottom: -10px;"
                                        scope="row" colspan="4">Total Commission</td>
                                    <td
                                        style="padding: 0px 15px;font-size: 14px;margin-top: 10px;margin-bottom: -10px;">
                                        <?php echo get_price_front('', '', '', '', $commissions['total']); ?></td>
                                </tr>
                            @endif
                        </tbody>

                        @if (isset($products->checkout))
                            @foreach ($products->checkout as $key => $value_check)
                                <tbody class="checkout_body">
                                    <tr>
                                        <td style="padding: 0px 15px;font-size: 14px;margin-top: 10px;margin-bottom: -10px;"
                                            scope="row" colspan="4">{{ $value_check->title }}</td>
                                        <td
                                            style="padding: 0px 15px;font-size: 14px;margin-top: 10px;margin-bottom: -10px;">
                                            {{ $value_check->amount }}</td>
                                    </tr>
                                </tbody>
                            @endforeach
                        @endif
                    </table>

                    <table class="tourtastique_thanks">

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
                                                    src="{{ asset('uploads/placeholder/globe.png') }}">
                                            </td>
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
