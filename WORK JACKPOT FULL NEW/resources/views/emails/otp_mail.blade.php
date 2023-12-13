<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | workjackpot </title>
    <link rel="shortcut icon" href="{{ asset('favicon.png')}}" type="image/x-icon">  
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/toast-master/css/jquery.toast.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/style.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  </head>
	 
	<body class="em_body" style="margin:0px; padding:0px;" bgcolor="#efefef">
	<table class="em_full_wrap" valign="top" width="600px" cellspacing="0" cellpadding="0" border="0" bgcolor="#efefef" align="center">
	    <tbody>
	    	<?php $image =  asset('assets/images/site_icon.png'); ?>
	    	<tr style="text-align: left; background-color: #19286B">
              <td ><img style="height:60px; width: 120px;padding: 20px;" src="<?php echo $image; ?>" /> </td>
            </tr>
	  		<tr>
	          <td style="padding:50px 70px 15px;font-size: 16px;" class="em_padd" valign="top" bgcolor="#f6f7f8" align="left">User Name <b><?php echo $name; ?></b>
	          </td>
	        </tr>
	       
	        <tr>
	          <td style="padding:5px 70px 15px;" class="em_padd" valign="top" bgcolor="#f6f7f8" align="left">Email : {{$email}} </td>
	        </tr>
	        <tr>
	          <td style="padding:15px 70px 35px;font-size: 16px;" class="em_padd" valign="top" bgcolor="#f6f7f8" align="center">This is Your Otp {{$otp}} </td>
	        </tr>
	        <tr>
	          <td style="padding:35px 70px 35px;color:#fff;background-color: black; font-size: 16px;" class="em_padd" valign="top" bgcolor="##3c8dbc" align="center">Copyright © <?php echo date('Y') ?> WorkJackpot. All rights reserved.</td>
	        </tr>
	        
		</tbody>
	</table>
	</body>
	</html>