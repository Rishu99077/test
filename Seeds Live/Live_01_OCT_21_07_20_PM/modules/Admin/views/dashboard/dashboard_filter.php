



<form role="form" id="dashbord" action="<?php echo base_url(); ?>admin" method="get" enctype="multipart/form-data" accept-charset="utf-8" name="formdashbord">

	<?php 

	$modules = array();

	if($userrole=='1' || $userrole=='4'){

		$modules['Crops'] = 'Crops';

	}



	if($userrole=='1' || $userrole=='4' || $userrole=='7'  || in_array("evaluation", $userpermission)){

		$modules['Evaluation'] = 'Evaluation';

	}



	if($userrole=='1' || $userrole=='4'){

		$modules['Precommercial'] = 'Pre-commercial';

		$modules['Recheck'] = 'Re-check';

	}



	if($userrole=='1' || $userrole=='4'){

		$modules['Receivers'] = 'Receivers';

	}



	if($userrole=='1' || $userrole=='4' || in_array("sampling", $userpermission)){

		$modules['Sampling'] = 'Sampling';

	}	

	if($userrole=='1' || $userrole=='4' || in_array("seeds", $userpermission)){

		$modules['Seeds'] = 'Seeds';

	}

	if($userrole=='1' || $userrole=='4'){

		$modules['Suppliers'] = 'Suppliers';

	}



	if($userrole=='1' || $userrole=='4'){

		$modules['Techncialteam'] = 'Techncial team';

	}

	if($userrole=='1' || $userrole=='4' || $userrole=='7' || in_array("trial", $userpermission)){	

		$modules['Trial'] = 'Trial';

	}

	

	

	$type = @$_GET['type'];

	$search = @$_GET['search'];

	$page = @$_GET['page'];

	?>

	<div class="row">

	    <div class="col-md-3">

	    	<div class="form-group " id="InputReceiver">

                <label for="type" class="required">Type</label>

                <select class="form-control"  name="type" id="type">

		    		<option value="">Please Select Type</option>

		    		<?php foreach ($modules as $key => $value) { ?>

		    		<option value="<?php echo $key; ?>" <?php if ($type == $key ) echo 'selected' ; ?> ><?php echo $value; ?></option>

		    		<?php } ?>

		    	</select>

		    </div>	

		</div>

		<div class="col-md-3">

	    	<div class="form-group " id="InputReceiver">

                <label for="search" class="required">Search</label>

                <input type="text" class="form-control"  name="search" id="search" value="<?php echo $search; ?>">

		    </div>	

		</div>

		<div class="col-md-3">

	    	<button type="submit" class="btn btn-primary" style="float: left;margin-top: 25px;">Find</button>	

		</div>     	

	</div>

	<?php 

		if($type!='' AND $search!=''){

			if($userrole=='1' || $userrole=='4'){



				if($type=='Crops'){

					include('crops.php');

				}elseif($type=='Controlvariety'){ 

				  	include('controlvariety.php'); 

				}elseif($type=='Suppliers'){ 

				  	include('suppliers.php');

				}elseif($type=='Receivers'){ 

				  	include('receivers.php');

				}elseif($type=='Techncialteam'){ 

				  	include('techncialteam.php');

				}

			}	



			if($userrole=='1' || $userrole=='4' || in_array("seeds", $userpermission)){

				if($type=='Seeds'){ 

				  	include('seeds.php');

				}

			}

			if($userrole=='1' || $userrole=='4' || in_array("sampling", $userpermission)){	

				if($type=='Sampling'){ 

				  	include('sampling.php');

				}

			}

			if($userrole=='1' || $userrole=='4' || in_array("trial", $userpermission)){	

				if($type=='Trial'){ 

				  	include('trial.php');

				}

			}	

			if($userrole=='1' || $userrole=='4' || in_array("evaluation", $userpermission)){

				if($type=='Evaluation'){ 

				  	include('evaluation.php');

				}

			}	



			if($userrole=='1' || $userrole=='4'){

				if($type=='Recheck'){ 

				  	include('recheck.php');

				}elseif($type=='Precommercial'){ 

				  	include('precommercial.php');

				}

			}



	        



		}	 

	?>	

</form>