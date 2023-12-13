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

<body class="body">
    <table style="font-size:1rem; background-color: #F8F8F8;width: 700px;margin: 0 auto;" role="presentation"
        align="center" bgcolor="#E4E4E4" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
            <tr style="position: relative; text-align: center;width: 100%;background: #EAFEEF;">
                <td style="padding:15px;text-align: end;" colspan="3">
                    <img src="{{ get_setting_data('header_logo') != '' ? url('uploads/setting', get_setting_data('header_logo')) : asset('front_assets/images/logo.png') }}"
                        style="width:150px;">
                </td>
            </tr>
            <tr>
                <td valign="top" colspan="3">
                    <div class="over-mob" style="max-height:260px; margin: 0 auto; text-align: center;padding:60px">
                        <img class="reset"
                            src="{{ get_setting_data('header_logo') != '' ? url('uploads/setting', get_setting_data('header_logo')) : asset('front_assets/images/logo.png') }}"
                            border="0" alt="" style="vertical-align: middle;">
                    </div>
                    <table role="presentation" class="faux-absolute reset" align="center" border="0" cellpadding="0"
                        cellspacing="0" width="700" style="position:relative; opacity:0.999;">
                        <tbody>
                            <tr>
                                <td valign="top">
                                    <table role="presentation" class="hero-textbox" border="0" cellpadding="0"
                                        cellspacing="0" width="92%" bgcolor="#FFFFFE" align="center"
                                        style="font-size: 16px;font-weight:600;line-height: 20px;color:#61728D;">
                                        <tbody>
                                            <tr>
                                                <td valign="top"
                                                    style="padding: 10px 15px;background-color:#61728D;color:#fff;"
                                                    colspan="3">
                                                    {{ translate('Your  order') }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td valign="top" style="padding: 15px 0px 0px 15px;">
                                                    {{ translate('Order Id') }} : <span
                                                        style="color: #232A35;padding-left: 10px;">{{ $order_id }}</span>
                                                </td>
                                                <td style="padding: 15px 0px 0px 15px;">{{ translate('Name') }} : <span
                                                        style="color: #232A35;padding-left: 10px;">{{ $full_name }}</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td valign="top" style="padding: 15px 0px 0px 15px;">
                                                    {{ translate('Order Date') }} : <span
                                                        style="color: #232A35;padding-left: 10px;">{{ $order_date }}</span>
                                                </td>
                                                <td valign="top" style="padding: 15px 0px 0px 15px;">
                                                    {{ translate('Email ID') }} : <a
                                                        style="color: #232A35;padding-left: 10px;">{{ $email }}</a>
                                                </td>
                                            </tr>

                                            <tr>
                                                @if($addres !='')
                                                    <td style="padding: 15px 0px 0px 15px;" colspan="">
                                                        {{ translate('Address') }} :
                                                        <span
                                                            style="color: #232A35;padding-left: 10px;">{{ $address }}</span>
                                                    </td>
                                                @endif
                                                
                                                <td style="padding: 15px 0px 0px 15px;" colspan="2">
                                                    {{ translate('Total') }} :
                                                    <span
                                                        style="color: #232A35;padding-left: 10px;">{{ $total }}</span>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td valign="top" colspan="2">
                                                    <br>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding: 15px;">
                                </td>
                            </tr>
                            {{-- <tr>
                                <td valign="top">
                                    <table role="presentation" class="hero-textbox" border="0" cellpadding="0"
                                        cellspacing="0" width="92%" bgcolor="#FFFFFE" align="center"
                                        style="font-size: 16px;font-weight:600;line-height: 20px;color:#313131;">
                                        <tbody>
                                            <tr>
                                                <td valign="top"
                                                    style="padding: 10px 15px;background-color:#61728D;color:#fff;width:50%;">
                                                    Item Description
                                                </td>
                                                <td valign="top"
                                                    style="padding: 10px 15px;background-color:#61728D;color:#fff;width:25%;"
                                                    align="center">
                                                    Quantity
                                                </td>
                                                <td valign="top"
                                                    style="padding: 10px 15px;background-color:#61728D;color:#fff;width:25%;"
                                                    align="center">
                                                    Price
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" style="padding: 10px 15px;width:50%;">
                                                    Test 27 Nov 22 12 48 our list
                                                </td>
                                                <td valign="top" style="padding: 10px 15px;width:25%;"
                                                    align="center">
                                                    01
                                                </td>
                                                <td valign="top" style="padding: 10px 15px;width:25%;"
                                                    align="center">
                                                    $150
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" style="padding: 10px 15px;width:50%;">
                                                    Test 27 Nov 22 12 48 our list
                                                </td>
                                                <td valign="top" style="padding: 10px 15px;width:25%;"
                                                    align="center">
                                                    01
                                                </td>
                                                <td valign="top" style="padding: 10px 15px;width:25%;"
                                                    align="center">
                                                    $150
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" style="padding: 10px 15px;width:50%;">
                                                    Test 27 Nov 22 12 48 our list
                                                </td>
                                                <td valign="top" style="padding: 10px 15px;width:25%;"
                                                    align="center">
                                                    01
                                                </td>
                                                <td valign="top" style="padding: 10px 15px;width:25%;"
                                                    align="center">
                                                    $150
                                                </td>
                                            </tr>

                                            <tr>
                                                <td valign="top" style="padding: 10px 15px 0px;" colspan="3">
                                                    <hr style="border-top:2px solid #7C4292">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td valign="top" style="padding: 10px 15px;width:50%;">
                                                    Subtotal
                                                </td>
                                                <td valign="top" style="padding: 10px 52px 10px 0px;width:50%;"
                                                    align="right" colspan="2">
                                                    <span style="color:#268E43">$</span> 450
                                                </td>
                                            </tr>

                                            <tr>
                                                <td valign="top" style="padding: 10px 15px;width:50%;">
                                                    Shipping
                                                </td>
                                                <td valign="top" style="padding: 10px 52px 10px 0px;width:50%;"
                                                    align="right" colspan="2">
                                                    <span style="color:#268E43">$</span> 7.75 via USPS
                                                </td>
                                            </tr>

                                            <tr>
                                                <td valign="top" style="padding: 10px 15px 20px;width:50%;">
                                                    Payment method
                                                </td>
                                                <td valign="top" style="padding: 10px 52px 20px 0px;width:50%;"
                                                    align="right" colspan="2">
                                                    PayPal Adaptive Split payment
                                                </td>
                                            </tr>

                                            <tr>
                                                <td valign="top"
                                                    style="padding: 10px 15px;width:50%;background-color:#EFEFEF;">
                                                    Total
                                                </td>
                                                <td valign="top"
                                                    style="padding: 10px 52px 10px 0px;width:50%;background-color:#EFEFEF;"
                                                    align="right" colspan="2">
                                                    <span style="color:#268E43">$</span> 457.75
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </td>
                            </tr> --}}
                            <tr>
                                <td valign="top" style="padding: 15px;">
                                </td>
                            </tr>

                            <tr>
                                <td valign="top" style="padding: 20px 50px 5px 50px;">
                                    <table role="presentation" class="hero-textbox" border="0" cellpadding="0"
                                        cellspacing="0" width="92%" bgcolor="#FFFFFE" align="center"
                                        style="font-size: 16px;font-weight:600;line-height: 20px;color:#61728D;border-radius: 4px;">
                                        <tbody>
                                            <tr>
                                                <td valign="top"
                                                    style="padding: 10px 15px;background-color:#61728D;color:#fff;text-align: center;"
                                                    colspan="3">
                                                    Your Order Placed Succsessfully
                                                </td>
                                            </tr>



                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr
                                style="background: #fff;color: #313131;text-align: left;position: relative;top: 0px;font-weight: 600;font-size: 18px;line-height: 21px;">
                                <td width="92%" style="padding: 20px 0;">
                                    <h3 style="margin: 0;color: #9E9E9E;font-size: 20px;color:#268E43;font-weight:600;"
                                        align="center">
                                        {{ translate('Click this Link') }}</h3>

                                    <h2 style="margin: 15px 0 0;color:#313131;font-size:16px;font-weight:600;"
                                        align="center">
                                        @if ($type == 'product')
                                            <a href="{{ route('admin.generate_product_voucher', $id) }}">
                                                {{ translate('Your Invoice') }}</a>
                                    </h2>
                                @else
                                    <a href="{{ route('admin.generate_airport_voucher', $id) }}">
                                        {{ translate('Your Invoice') }}</a></h2>
                                    @endif


                                </td>
                            </tr>



                            {{-- <tr>
                                <td valign="top" style="padding: 15px;">
                                </td>
                            </tr> --}}

                            {{-- <tr>
                                <td valign="top">
                                    <table role="presentation" class="hero-textbox" border="0" cellpadding="0"
                                        cellspacing="0" width="92%" bgcolor="#FFFFFE" align="center"
                                        style="font-size: 16px;font-weight:600;line-height: 20px;color:#313131;">
                                        <tbody>
                                            <tr>
                                                <td valign="top"
                                                    style="padding: 10px 15px;background-color:#61728D;color:#fff;">
                                                    Payment transaction
                                                </td>
                                                <td valign="top"
                                                    style="padding:10px 52px 10px 0px;background-color:#61728D;color:#fff;"
                                                    align="right">
                                                    Price
                                                </td>
                                            </tr>

                                            <tr>
                                                <td valign="top"
                                                    style="padding: 10px 15px;border-bottom:1px solid #E5E5E5;">
                                                    Seller donated to neworg-aug5-1
                                                </td>
                                                <td style="padding: 10px 52px 10px 0px;border-bottom:1px solid #E5E5E5;"
                                                    align="right">
                                                    <span style="color:#268E43">$</span>
                                                    15.28
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" style="padding: 10px 15px;">
                                                    Seller keeps
                                                </td>
                                                <td style="padding:10px 52px 10px 0px;" align="right">
                                                    <span style="color:#268E43">$</span>
                                                    137.47
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr> --}}

                            <tr>
                                <td valign="top" style="padding: 5px;">
                                    <br><br>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="background-color:#232A35;text-align:center;padding: 10px;">
                    <table>
                        <tbody>
                            {{-- <tr>
                                <td colspan="2" style="padding: 20px 0 20px;border-bottom:1px solid #fff;">
                                    <img src="http://collectiveaid.com/stg/wp-content/uploads/2022/02/white-logo.png">
                                    <p
                                        style="font-size: 12px;width: 60%;margin: 0 auto;color: #ffffffb5;padding-top: 15px;">
                                        Collectiveaid is a crowdfunding website that lets you raise money for anything
                                        that matters to you. From personal causes and events to projects and more. We’ve
                                        helped people from all over the world raise millions online.</p>
                                    <br>
                                    <ul style="padding: 0;list-style: none;margin: 0 auto;">
                                        <li style="display: inline-block;margin-right: 10px;margin-left: 0;">
                                            <a href="#">
                                                <img
                                                    src="http://collectiveaid.com/stg/wp-content/uploads/2022/02/fb-icon.png">
                                            </a>
                                        </li>
                                        <li style="display: inline-block;margin-right: 10px;margin-left: 0;">
                                            <a href="#">
                                                <img
                                                    src="http://collectiveaid.com/stg/wp-content/uploads/2022/02/insta-icon.png">
                                            </a>
                                        </li>
                                        <li style="display: inline-block;margin-right: 10px;margin-left: 0;">
                                            <a href="#">
                                                <img
                                                    src="http://collectiveaid.com/stg/wp-content/uploads/2022/02/whats-icon.png">
                                            </a>
                                        </li>
                                        <li style="display: inline-block;margin-right: 10px;margin-left: 0;">
                                            <a href="#">
                                                <img
                                                    src="http://collectiveaid.com/stg/wp-content/uploads/2022/02/twitter-iocn.png">
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr> --}}
                            <tr>
                                <td
                                    style="padding: 5px 15px;text-align: left;font-size: 12px;line-height: 18px;color: #fff;">
                                    © {{ date('Y') }} Desert Gate — All Rights Reserved.</td>

                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
