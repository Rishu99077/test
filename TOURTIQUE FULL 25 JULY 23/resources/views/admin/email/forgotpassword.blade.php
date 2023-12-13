<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ get_setting_data('web_title')}}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body class="em_body" style="margin:0px; padding:0px;" bgcolor="#efefef">
    <table class="em_full_wrap" valign="top" width="600px" cellspacing="0" cellpadding="0" border="0"
        bgcolor="#efefef" align="center">
        <tbody>
            <tr style="text-align: left; background-color: #19286B">

            </tr>
            <tr>
                <td style="padding:50px 70px 15px;font-size: 16px;" class="em_padd" valign="top" bgcolor="#f6f7f8"
                    align="left">User Name <b><?php echo $name; ?></b>
                </td>
            </tr>

            <tr>
                <td style="padding:5px 70px 15px;" class="em_padd" valign="top" bgcolor="#f6f7f8" align="left">Email 
                    : <?php echo $email; ?> </td>
            </tr>
            <tr>
                <td style="padding:15px 70px 35px;font-size: 16px;" class="em_padd" valign="top" bgcolor="#f6f7f8"
                    align="center">Please <a href="{{ route('reset_password', $token_) }}">click here</a>
                    to reset your password </td>
            </tr>
            <tr>
                <td style="padding:35px 70px 35px;color:#fff;background-color: black; font-size: 16px;" class="em_padd"
                    valign="top" bgcolor="##3c8dbc" align="center">Copyright © <?php echo date('Y'); ?> Education . All
                    rights reserved.</td>
            </tr>

        </tbody>
    </table>
</body>

</html>
