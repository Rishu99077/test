<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
	<title>Work Jackpot</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 ">
	<meta name="format-detection" content="telephone=no">
	<!--[if !mso]><!-->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
	<!--<![endif]-->
	</head>
	 
	<body class="em_body" style="margin:0px; padding:0px;" bgcolor="#efefef">
	<table class="em_full_wrap" valign="top" width="600px" cellspacing="0" cellpadding="0" border="0" bgcolor="#efefef" align="center">
	    <tbody>
	    	<?php $image =  asset('assets/images/site_icon.png'); ?>
	    	<tr style="text-align: left; background-color: #19286B">
	          <td ><img style="height:60px; width: 120px;padding: 20px;" src="<?php echo $image; ?>" /> </td>
	        </tr>
	  		<tr>
	          <td style="padding:50px 70px 15px;font-size: 16px;" class="em_padd" valign="top" bgcolor="#f6f7f8" align="left">User Name <b><?php echo $data['first_name'].' '.$data['family_name']; ?></b>
	          </td>
	        </tr>
	       
	        <tr>
	          <td style="padding:5px 70px 15px;" class="em_padd" valign="top" bgcolor="#f6f7f8" align="left">Phone : <?php echo $data['phone']; ?></td>
	        </tr>
	        <tr>
	          <td style="padding:15px 70px 35px;font-size: 16px;" class="em_padd" valign="top" bgcolor="#f6f7f8" align="center">Thanks</td>
	        </tr>
	        <tr>
	          <td style="padding:35px 70px 35px;color:#fff;background-color: black; font-size: 16px;" class="em_padd" valign="top" bgcolor="##3c8dbc" align="center">Copyright © <?php echo date('Y') ?> Work Jackpot. All rights reserved.</td>
	        </tr>
	        
		</tbody>
	</table>
	</body>
	</html>