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
                    <img src="{{ asset('image/logo.png')}}" style="width:250px;">
                </td>
            </tr>
            <tr
                style='color: #313131;text-align: left;position: relative;font-weight: bold;font-size: 18px;line-height: 28px;'>
                <td width='4%'></td>
                <td width='92%' style='padding: 0px 0 30px;'></td>
                <td width='4%'></td>
            </tr>
            <tr>
                <td valign="top" style="padding: 20px;width: 86%;">
                    <h1 style="margin: 0; width: 100%; font-size:28px; color:#27433c;line-height: 42px; ">
                        24JE CARDS 
                    </h1>
                    <br>
                    <h3 style="margin: 0;color: #27433c;line-height: 18px;">
                        Hello {{ $name }} Your otp is {{ $otp }}.
                    </h3> 
                </td>
            </tr>
            <tr>
                <td width='4%'></td>
                <td width='92%' style='padding: 0px 0 5px;'>
                    <br>
                </td>
                <td width='4%'></td>
            </tr>
        </table>
    </div>
</body>
