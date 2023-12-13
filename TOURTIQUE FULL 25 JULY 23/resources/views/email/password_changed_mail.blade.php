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

    .ExternalClass {
        width: 100%;
    }

    .ExternalClass,
    .ExternalClass p,
    .ExternalClass span,
    .ExternalClass font,
    .ExternalClass td,
    .ExternalClass div {
        line-height: 100%;
    }

    table {
        border-collapse: collapse;
        mso-table-lspace: 0;
        mso-table-rspace: 0;
        empty-cells: show;
    }

    #MessageViewBody {
        width: 100vw !important;
        min-width: 100vw !important;
        padding: 0 !important;
        margin: 0 !important;
        zoom: 1 !important;
    }

    #MessageViewBody a {
        color: inherit;
        font-size: inherit;
        font-family: inherit;
        font-weight: inherit;
        line-height: inherit;
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
    <div style="max-height:0;overflow:hidden;mso-hide:all;" aria-hidden="true">
        
    </div>
    <div role="article" aria-roledescription="email" aria-label="email name" lang="en"
        style="font-size:1rem; background-color: #F8F8F8;width: 600px;margin: 0 auto;">
        <table role="presentation" align="center" bgcolor="#FAFAFA" border="0" cellpadding="0" cellspacing="0"
            width="100%">
            <tr style="position: relative; text-align: center;width: 100%;background: #fff;">
                <td style="padding:15px" colspan="3">
                    <img src="{{ get_setting_data('header_logo') != '' ? url('uploads/setting', get_setting_data('header_logo')) : "" }}"
                        style="width:250px;">
                </td>
            </tr>
            <tr
                style='color: #313131;text-align: left;position: relative;font-weight: bold;font-size: 18px;line-height: 28px;'>
                <td width='4%'></td>
                <td width='92%' style='padding: 0px 0 30px;'></td>
                <td width='4%'></td>
            </tr>
            <tr
                style='color: #313131;text-align: left;position: relative;font-weight: bold;font-size: 18px;line-height: 28px;'>
                <td width='4%'></td>
                <td width='92%'>
                    <table
                        style='background: #fff;font-size: 14px;line-height: 18px;padding: 10px 20px 20px;border: 1px solid #E5E5E5;border-radius: 4px;margin-top:10px;margin:0 auto'>
                        <tbody>
                            <tr>
                                <td valign="top" style="padding: 20px;">
                                    <h1 style="margin: 0;  font-size:28px; color:#27433c;line-height: 42px; ">
                                        {{ $title }}
                                    </h1>
                                    <br>
                                    <h3 style="margin: 0;color: #27433c;line-height: 18px;">
                                        Hello {{ $name }} 
                                    </h3>
                                    <p style="margin-top: 5px;font-size: 13px;line-height: 18px;">
                                        Your Account Password Changed Successfull
                                    </p>
                                    {{-- <p style="margin-top: 5px; font-size: 13px; line-height: 18px;">
                                        This Your Verficatio Otp.
                                    </p> --}}
                                    <br>
                                    <a href="javascript:void(0)" style="color: #fff;background-color: #000337; text-decoration: none; padding: 15px;display: block;margin: 0 auto;font-weight: 600;font-size: 16px;text-align: center;">
                                        Your  Password Was Changed Successfully  </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width='4%'></td>
            </tr>
            <tr>
                <td width='4%'></td>
                <td width='92%' style='padding: 0px 0 5px;'>
                    <br>
                </td>
                <td width='4%'></td>
            </tr>
            {{-- <tr>
                <td colspan="3"
                    style="background-color:#262A49;text-align:center;background-image: url('https://dev.infosparkles.com/slowmovers/admin/uploads/email/footer_bg.png');
                background-position: center;background-repeat: no-repeat;background-size: cover;">
                    <table>
                        <tr>
                            <td colspan="2" style="padding:35px 20px 35px 20px;">
                                <img src="https://dev.infosparkles.com/slowmovers/admin/uploads/email/footer_logo.png">
                                <p style="font-size: 12px;margin: 0 auto;color: #ffffffb5;padding-top: 30px;">Lorem
                                    Ipsum
                                    is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                                    the
                                    industry's standard dummy text ever since the 1500s, when an unknown</p>
                            </td>
                        </tr>
                        <tr>
                            <td width='65%' style='padding: 0px 0px 0px 20px;'>
                                <p style='color: #FFFFFF;font-size: 14px;font-weight: 400;text-align: left;'><span
                                        style='position: relative;top: 5px;margin-right: 5px;'>
                                        <img src="https://dev.infosparkles.com/slowmovers/admin/uploads/email/email_icon.png"
                                            style='width: 20px;'></span>slowmovers&deadstock@gmail.com
                                </p>
                            </td>
                            <td width='35%'style='padding: 0px 0px 0px 20px;'>
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
                                                src="http://collectiveaid.com/stg/wp-content/uploads/2022/02/twitter-iocn.png">
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
                                            <img src="images/pintrest.png">
                                        </a>
                                    </li>
                                    <li style="display: inline-block;margin-right: 10px;margin-left: 0;">
                                        <a href="#">
                                            <img src="images/linkedin.png">
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr style="border-bottom:1px solid #fff;">
                            <td colspan="2" style="padding:15px"></td>
                        </tr>
                        <tr>
                            <td colspan="2"
                                style=" padding: 15px 15px;text-align: center;font-size: 12px;line-height: 18px;color: #FFFFFF;">
                                Copyright © 2021 by Slowmovers & Deadstock All Rights Reserved.</td>
                        </tr>
                    </table>
                </td>
            </tr> --}}
        </table>
    </div>
</body>
