<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recheck extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Recheckadmin','',TRUE);
		$this->load->library('session');
		$this->load->library('pagination');			
    } 

	public function index(){

		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];		

		$data['heading_title']='Re-check';
		$data['active']='recheck';
		$data['submenuactive']='recheck';

		$Crop = $this->input->get('Crop');
		$Supplier = $this->input->get('Supplier');

		if ($Crop || $Supplier){
   			$total_rows = $this->Recheckadmin->filter_get_recheck_count($data['userrole'],$Crop,$Supplier);
   		}else{
   			$total_rows = $this->Recheckadmin->get_recheck_count($data['userrole']);
   		}

		$config = array();
		if ($Crop || $Supplier) 
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['use_page_numbers'] = false;
		// $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
		$config['base_url'] = base_url() .'admin/recheck/';
		$config['total_rows'] = $total_rows;
		$config['per_page'] = 20;
		$config['uri_segment'] = 3;
		$config['num_links'] = 4;
		$config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        if($this->uri->segment(3) > 0){
		    $start = $this->uri->segment(3)+1;
		    $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) + $config['per_page'];
		}else{
		    $start= (int)$this->uri->segment(3) * $config['per_page']+1;
		    $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
		}
		$data['result_count']= "Showing ".$start." - ".$end." of ".$config['total_rows']." Results";

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links"] = $this->pagination->create_links();

        if ($Crop || $Supplier){
   			$get_recheck = $this->Recheckadmin->filter_get_recheck($data['userrole'],$Crop,$Supplier,$config["per_page"], $page);
   		}else{
       		$get_recheck = $this->Recheckadmin->get_recheck($config["per_page"], $page,$data['userrole']);
       	}

        $rechecks =array();
        foreach ($get_recheck as $key => $value) {
        	$ttl_Numberofseeds = 0;
	        $recheck =array();
			$recheck['RecheckID'] = $value['RecheckID'];
			$recheck['EvaluationID'] = $value['EvaluationID'];
			$recheck['recheckstatus'] = $value['recheckstatus'];

			$recheck['Crop'] = '';
			$recheck['Supplier'] = '';	
			$recheck['Variety'] = '';

			if($value['EvaluationID']){
				$get_evaluation = $this->Recheckadmin->get_evaluation($value['EvaluationID']);
				if($get_evaluation){
					$Internalsamplecode = $get_evaluation['Internalsamplecode'];
					if($Internalsamplecode){
						$get_sampling = $this->Recheckadmin->get_sampling($Internalsamplecode);
						if($get_sampling){
							$get_crop = $this->Recheckadmin->get_crop($get_sampling['Crop']);
							$get_supplier = $this->Recheckadmin->get_supplier($get_sampling['SupplierID']);
							$get_seed = $this->Recheckadmin->get_seed($get_sampling['Seed']);

							if($get_crop){
								$recheck['Crop'] = $get_crop['Title'];
							}
							if($get_supplier){
								$recheck['Supplier'] = $get_supplier['Name'];
							}

							if($get_seed){
								$recheck['Variety'] = $get_seed['Variety'];
								$recheck['SeedID'] = $get_seed['SeedID'];
							}

						// total
							$get_samplings = $this->Recheckadmin->get_recheck_sampling(@$recheck['SeedID']);								
							$samplings = array();
							foreach ($get_samplings as $key => $get_sampling) {
								$sampling = array();
								$sampling['Internalsamplingcode'] = $get_sampling['Internalsamplingcode'];
								$sampling['get_evaluation'] = $this->Recheckadmin->get_recheck_evaluation($get_sampling['Internalsamplingcode']);
							
								$samplings[] = $sampling;
							
							}
							$data['Numebrofseedsrequast'] = $samplings;

							foreach ($data['Numebrofseedsrequast'] as $key => $evaluation_value) {
								$get_evaluation = $evaluation_value['get_evaluation'];
								foreach ($get_evaluation as $key => $number_value) {
									$ttl_Numberofseeds += $number_value['Numberofseeds'];
								}
							}
						// total		
						}
					}
				}
			}else{
				$get_crop = $this->Recheckadmin->get_crop($value['Crop']);
				$get_supplier = $this->Recheckadmin->get_supplier($value['Supplier']);

				if($get_crop){
					$recheck['Crop'] = $get_crop['Title'];
				}
				if($get_supplier){
					$recheck['Supplier'] = $get_supplier['Name'];
				}
				$recheck['Variety'] = $value['Variety'];
				
				$get_seed = $this->Recheckadmin->get_seed_id($value['Variety']);
				$recheck['SeedID'] = $get_seed['SeedID'];
				$get_seed_number = $this->Recheckadmin->get_seed_number($recheck['SeedID']);
			}
			$get_date = $this->Recheckadmin->get_date($value['EvaluationID']);

			$requestDate  = '';
			if($get_date!=''){
				foreach ($get_date as $value_get_date){				
					  $date = $value_get_date['requestDate'];  
	                    $exdate = explode("/",$date); 
	                    $newDate = $exdate[2].'-'.$exdate[1].'-'.$exdate[0];
	                    $NewrequestDate   =   date("d-F-Y", strtotime($newDate));
					$requestDate  .= $NewrequestDate."<br>";
				}
			}


			if($requestDate!=''){
				$requestDate = trim($requestDate,'<br>');
			}
		
			$recheck['requestDate'] = $requestDate;
			$recheck['is_deleted'] = $value['is_deleted'];
			$recheck['Bywhen'] = $value['Bywhen'];
			$recheck['request_count'] = $value['request_count'];
			// $recheck['requestDate'] = $value['requestDate'];
			$recheck['receivedDate'] = $value['receivedDate'];
			$recheck['ttl_Numberofseeds'] = $ttl_Numberofseeds;
			$rechecks[] = $recheck;
		}
		
		$get_crops = $this->Recheckadmin->get_crops();
		$crops = array();
		foreach ($get_crops as $value) {
			$crops[$value['CropID']] = $value['Title'];
		}
		//asort($crops);

		$get_suppliers = $this->Recheckadmin->get_suppliers();
		$suppliers = array();
		foreach ($get_suppliers as $value) {
			$suppliers[$value['SupplierID']] = $value['Name'];
		}
		//asort($suppliers);
		$data["crops"] = $crops;
		$data["suppliers"] = $suppliers;	
		$data["recheck"] = $rechecks;
		$this->load->view('recheck',$data);
	}

	public function recheckedit(){

		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$error = array();
		// $error['Internalcode'] = '';
		$error['Crop'] = '';
		$error['Variety'] = '';
		$error['Supplier'] = '';
		$error['Numebrofseedsrequast'] = '';
		$error['Bywhen'] = '';
		$RecheckID = @$_GET['RecheckID'];


		$get_single_recheck =array();
		$get_single_recheck['EvaluationID'] = '';
		// $get_single_recheck['Internalcode'] = '';
		$get_single_recheck['UserID'] = '';
		$get_single_recheck['Crop'] = '';
		$get_single_recheck['Variety'] = '';
		$get_single_recheck['Supplier'] = '';
		$get_single_recheck['Numebrofseedsrequast'] = '';
		$get_single_recheck['Bywhen'] = '';

		if($RecheckID!=''){			
			$data['heading_title']='Edit Re-check';
			$get_single_recheck = $this->Recheckadmin->get_single_recheck($RecheckID);
			if($get_single_recheck['EvaluationID']){
				$get_evaluation = $this->Recheckadmin->get_evaluation($get_single_recheck['EvaluationID']);
				if($get_evaluation){
					$Internalsamplecode = $get_evaluation['Internalsamplecode'];
					if($Internalsamplecode){
						$get_sampling = $this->Recheckadmin->get_sampling($Internalsamplecode);
						if($get_sampling){
							$get_single_recheck['Crop'] = $get_sampling['Crop'];
							$get_single_recheck['Supplier'] = $get_sampling['SupplierID'];

							$get_seed = $this->Recheckadmin->get_seed($get_sampling['Seed']);
							if($get_seed){
								$get_single_recheck['Variety'] = $get_seed['Variety'];
							}

							$get_single_recheck['SeedID'] = $get_sampling['Seed'];
							if($get_seed){
								$get_single_recheck['Seed'] = $get_seed['Variety'];
							}else{
								$get_single_recheck['Seed'] ='';
							}

						}
					}
				}
			}
		}else{
			$data['heading_title']='Add Re-check';
		}

		if (($this->input->server('REQUEST_METHOD') == 'POST')){
			$this->load->library('form_validation');
			// $this->form_validation->set_rules('Internalcode', 'Internal code', 'required|trim');
			$this->form_validation->set_rules('Crop', 'Crop', 'required|trim');
			$this->form_validation->set_rules('Variety', 'Variety', 'required|trim');
			$this->form_validation->set_rules('Supplier', 'Supplier', 'required|trim');
			$this->form_validation->set_rules('Numebrofseedsrequast', 'Numebr of seeds requast', 'required|trim');
			$this->form_validation->set_rules('Bywhen', 'By when', 'required|trim');

			if ($this->form_validation->run() == FALSE) {
				// if(form_error('Internalcode')){
				// 	$error['Internalcode']  =form_error('Internalcode');
				// }
				if(form_error('Crop')){
					$error['Crop']  =form_error('Crop');
				}
				if(form_error('Variety')){
					$error['Variety']  =form_error('Variety');
				}
				if(form_error('Supplier')){
					$error['Supplier']  =form_error('Supplier');
				}
				if(form_error('Numebrofseedsrequast')){
					$error['Numebrofseedsrequast']  =form_error('Numebrofseedsrequast');
				}
				if(form_error('Bywhen')){
					$error['Bywhen']  =form_error('Bywhen');
				}
			}else{

				$datalog = array();
				$datalog['UserID'] = $this->session->userdata('UserID');
				
				if($RecheckID!=''){
					$getsinglerecheck = $this->Recheckadmin->get_single_recheck($RecheckID);

					$datapost = $this->input->post();
					$data_post = array();

					if($getsinglerecheck['EvaluationID']){

					}else{
						$data_post['Crop'] = $this->input->post('Crop',true);
						$data_post['Variety'] = $this->input->post('Variety',true);
						$data_post['Supplier'] = $this->input->post('Supplier',true);
					}


					$data_post['Numebrofseedsrequast'] = $this->input->post('Numebrofseedsrequast',true);
					$data_post['Bywhen'] = $this->input->post('Bywhen',true);

					$this->Recheckadmin->update_recheck($data_post,$RecheckID);
					$this->session->set_flashdata('success', 'Re-check update successfully.');

					$datalog['Activity'] = 'Update';
					$datalog['Title'] = 'Re-check Update Variety: '.$this->input->post('Variety',true);
					$datalog['Data'] = json_encode($getsinglerecheck);
				}else{
					$datapost = $this->input->post();
					$datapost['UserID'] = $this->session->userdata('UserID');
					// $datapost['Internalcode'] = $this->input->post('Internalcode',true);
					$data_post['Numebrofseedsrequast'] = $this->input->post('Numebrofseedsrequast',true);
					$Numebrofseedsrequast = $data_post['Numebrofseedsrequast'];
					$datapost['Variety'] = $this->input->post('Variety',true);
					$get_seed_id = $this->Recheckadmin->get_seed_id($datapost['Variety']); 
					$SeedID = $get_seed_id['SeedID'];

					$get_internalsamplingcode = $this->Recheckadmin->get_internalsamplingcode($SeedID);
					// echo "<pre>";
					// print_r($get_internalsamplingcode);
					// echo "</pre>";
					
					$Internalsamplecode = $get_internalsamplingcode['Internalsamplingcode'];
					
					$get_evaluation = $this->Recheckadmin->get_recheck_evaluation($Internalsamplecode);
					
					if (!empty($get_evaluation)) {
						foreach ($get_evaluation as $key => $value) {
							$datapost['EvaluationID'] = $value['EvaluationID'];
							$datapost['Numebrofseedsrequast'] = $value['Numberofseeds']+$Numebrofseedsrequast;				
						}
						$dataevaluation['Numberofseeds'] =  $datapost['Numebrofseedsrequast'];

						$this->Recheckadmin->update_evaluation($dataevaluation,$datapost['EvaluationID']);						
					 	$get_supplier_id = $this->Recheckadmin->get_supplier_id($datapost['Supplier']);
					 	$datapost['Supplier'] = $get_supplier_id['SupplierID'];
					 	$get_recheck = $this->Recheckadmin->get_recheck_info($datapost['EvaluationID']);
					 	if (!empty($get_recheck)) {
					 		$this->Recheckadmin->update_recheck_evaluations($datapost,$datapost['EvaluationID']);
					 	}else{
							$RecheckID = $this->Recheckadmin->insert_recheck($datapost);
					 	}
						$this->session->set_flashdata('success', 'Re-check added successfully.');
					}else{
						$this->session->set_flashdata('success', 'This Code has no Evaluations Done.');
						redirect('admin/recheckedit');
					}	
					


					$datalog['Activity'] = 'Insert';
					$datalog['Title'] = 'Re-check added Variety: '.$this->input->post('Variety',true);
					$datalog['Data'] = json_encode($this->input->post());

				}
				$this->Recheckadmin->insert_log($datalog);	
				redirect('admin/recheck');
				exit();
			}

			$get_single_recheck['Crop'] = $this->input->post('Crop',true);
			$get_single_recheck['Variety'] = $this->input->post('Variety',true);
			$get_single_recheck['Supplier'] = $this->input->post('Supplier',true);
			$get_single_recheck['Numebrofseedsrequast'] = $this->input->post('Numebrofseedsrequast',true);
			$get_single_recheck['Bywhen'] = $this->input->post('Bywhen',true);
		}
		$all_get_seeds = $this->Recheckadmin->get_seeds();
	    $all_seeds = array();
	    foreach($all_get_seeds as $all_get_seed){
	        $all_seeds[$all_get_seed['SeedID']]= $all_get_seed['Variety'];
	    }
	    asort($all_seeds);
    	$data["seeds"] = $all_seeds;

		$data["crops"] = $this->Recheckadmin->get_crops();
		$data["suppliers"] = $this->Recheckadmin->get_suppliers();

		$data['error']=$error;
		$data['active']='recheck';
		$data['submenuactive']='recheckedit';
		$data['get_single_recheck']= $get_single_recheck;
		$this->load->view('recheckedit',$data);
	}

	public function checkinternalcode(){
		$Internalcode = $this->input->post('Internalcode',true);
		$get_sampling = $this->Trialadmin->get_single_sampling($Internalcode); // Abhishek
		$get_crop = $this->Trialadmin->get_crop_by_cropid($get_sampling['Crop']); // Abhishek
		$get_receiver = $this->Trialadmin->get_crop_by_receiverid($get_sampling['Receiver']);

		$result = $this->Trialadmin->get_sampling_count($Internalcode);
		if($result){
			$response = 'This Internal code not exits';
		}else{
			//$response = '';
			$response = 'Valid Code For: '.$get_crop['Title'].'<br>location is: '.$get_sampling['Location'].' 	<br> Receiver is: '.$get_receiver['Name']; // Abhishek
		}
		echo $response;
		die;
	}

	public function rechecksummary(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		
		$error = array();
		$error['Crop'] = '';
		$error['Supplier'] = '';
		$error['Variety'] = '';
		$error['Checkvariety'] = '';
		$error['Dateofrecivedsampel'] = '';
		$error['Status'] = '';
		$error['Stockquantityfor'] = '';
		$error['Stockquantity'] = '';
		$error['Note'] = '';
		$error['TechnicalData'] = '';
		$error['Attachment'] = '';
		$SeedID = @$_GET['SeedID'];
		$Variety = @$_GET['Variety'];

		$get_seed =array();
		$get_seed['SeedID'] = '';
		$get_seed['Crop'] = '';
		$get_seed['Supplier'] = '';
		$get_seed['Variety'] = '';
		$get_seed['Dateofrecivedsampel'] = '';
		$get_seed['Status'] = '';
		$get_seed['Stockquantityfor'] = '';
		$get_seed['Stockquantity'] = '';
		$get_seed['Note'] = '';
		$get_seed['TechnicalData'] = '';
		$get_seed['Attachment'] = '';
	
		$get_seeds = $this->Recheckadmin->get_seed($SeedID);
		$get_samplings = $this->Recheckadmin->get_recheck_sampling($SeedID);


		$samplings = array();
		foreach ($get_samplings as $get_sampling) {
			$sampling = array();
			$sampling['Internalsamplingcode'] = $get_sampling['Internalsamplingcode'];
			// $sampling['Stockquantity'] = $get_sampling['Stockquantity'];

			// $get_recheck_id = $this->Recheckadmin->get_recheck_id($data['userrole'],$Variety);
			// echo "<pre>";
			// print_r($get_recheck_id);
			// echo "</pre>";
			
			// foreach ($get_recheck_id as  $value) {
			// 	$sampling['Numebrofseedsrequast'] = $value['Numebrofseedsrequast'];
			// 	$sampling['Bywhen'] = $value['Bywhen'];
			// }
			$get_evaluation = $this->Recheckadmin->get_recheck_evaluation($get_sampling['Internalsamplingcode']);
			foreach ($get_evaluation as  $evaluation_value) {
				$sampling['Numberofseeds'] = $evaluation_value['Numberofseeds'];
				$sampling['ByWhen'] = $evaluation_value['ByWhen'];
 				$sampling['Status'] = $evaluation_value['Status'];
				$sampling['AddedDate'] = $evaluation_value['AddedDate'];	
				$sampling['UserID'] = $evaluation_value['UserID'];

				$get_users = $this->Recheckadmin->get_users($sampling['UserID']);
				$sampling['Fullname'] = $get_users['firstname'].' '.$get_users['lastname'];

				if ($sampling['Status']=='Re-check') {
					$sampling['UserID'] = $get_sampling['UserID'];
					$sampling['Location'] = $get_sampling['Location'];
					$sampling['SupplierID'] = $get_sampling['SupplierID'];

					$get_supplier = $this->Recheckadmin->get_supplier($get_sampling['SupplierID']);
					$sampling['SupplierName'] = $get_supplier['Name'];
					// $get_trail = $this->Recheckadmin->get_trail($get_sampling['Internalsamplingcode']);
					
					// $get_trail_counts = $this->Recheckadmin->get_trail_counts($get_sampling['Internalsamplingcode']);
					// $get_evaluation_counts = $this->Recheckadmin->get_evaluation_counts($get_sampling['Internalsamplingcode']);
					// $sampling['trailcount'] = $get_trail_counts;
					// $sampling['evaluationcount'] = $get_evaluation_counts;

					$samplings[] = $sampling;
				}
			}

		}

		$data['heading_title']='Recheck Summary';
		$data["crops"] = $this->Recheckadmin->get_crops();
		$data["suppliers"] = $this->Recheckadmin->get_suppliers();
		
		$data['error']=$error;
		$data['active']='recheck';
		$data['submenuactive']='recheck';
		$data['sampling']= $samplings;
		$data['get_seed']= $get_seed;
		$data['baseurl']= base_url();
		$this->load->view('rechecksummary',$data);
	}

	public function recheckstatus(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		
		$RecheckID = $_POST['RecheckID'];
		$recheckstatus = $_POST['recheckstatus'];
			// echo $recheckstatus;
			// die();

		// if (($this->input->server('REQUEST_METHOD') == 'POST')){
		// 	$RecheckID = $this->uri->segment(4);
			if($RecheckID){
				// $recheckstatus = $this->input->post('recheckstatus',true);
				// echo "<pre>";
				// print_r($recheckstatus);
				// echo "</pre>";
				$receivedStatus = $this->input->post('receivedStatus',true);
				$closeStatus = $this->input->post('closeStatus',true);
				
				$get_single_recheck = $this->Recheckadmin->get_single_recheck($RecheckID);
				// echo "<pre>";
				// print_r($get_single_recheck);
				// echo "</pre>";
				if($recheckstatus=='3'){


					if($get_single_recheck['EvaluationID']){
						$get_evaluation = $this->Recheckadmin->get_evaluation($get_single_recheck['EvaluationID']);
				
						if($get_evaluation){

							$Internalsamplecode = $get_evaluation['Internalsamplecode'];
							$Numberofseeds = $get_evaluation['Numberofseeds'];
							if($Internalsamplecode){
								$get_sampling = $this->Recheckadmin->get_sampling($Internalsamplecode);
								if($get_sampling){
									$get_seed = $this->Recheckadmin->get_seed($get_sampling['Seed']);
									if($get_seed){
										$get_seed_Stockquantity = $get_seed['Stockquantity'];
										$Total_get_seed_Stockquantity = $get_seed_Stockquantity+$Numberofseeds;
								
										$data_post_seed = array(); 
										$data_post_seed['Stockquantity'] = $Total_get_seed_Stockquantity;
										// $data_post_seed['closeStatus'] = $closeStatus; 

										$this->Recheckadmin->update_seed($data_post_seed,$get_sampling['Seed']);
									}
								}
							}
						}
					}
					// $data_post['closeStatus'] = $closeStatus;
					// $this->Recheckadmin->update_recheck($data_post,$RecheckID);
					$this->Recheckadmin->deleterecheck($RecheckID,'1');
					$this->session->set_flashdata('success', 'Re-check seed stock update successfully.');
				}elseif($recheckstatus=='1'){
					$get_single_recheck = $this->Recheckadmin->get_single_recheck($RecheckID);
					$EvaluationID = $get_single_recheck['EvaluationID'];
					$date = date('d/m/y');

					$data_date_post['EvaluationID'] = $EvaluationID;
					$data_date_post['requestDate'] = $date;
					$data_date_post['RecheckID'] = $RecheckID;	

					$data_post['recheckstatus'] = $recheckstatus;
					// $data_post['requestDate'] = $date;
					$this->Recheckadmin->insert_requestdate($data_date_post); 
					$this->Recheckadmin->update_recheck_status($data_post,$RecheckID);
					$this->session->set_flashdata('success', 'Re-check status update successfully.');
				}elseif($recheckstatus=='2'){
					$date = date('d/m/y');
					// echo $date;
					// die();	
					$data_post['recheckstatus'] = $recheckstatus;
					$data_post['receivedDate'] = $date;
					$data_post['receivedStatus'] = $receivedStatus;
					$this->Recheckadmin->update_recheck($data_post,$RecheckID);
					$this->session->set_flashdata('success', 'Re-check status update successfully.');
				}	
			}	
			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Update Status';
			$datalog['Title'] = 'Re-check Update Status: '.$get_single_recheck['RecheckID'];
			$datalog['Data'] = json_encode($get_single_recheck);
			$this->Recheckadmin->insert_log($datalog);	
			redirect('admin/recheck');
		// }		
		exit();	
	}

	public function seed_recheck(){
		$Crop = $this->input->post('Crop',true);
		$Seedselect = $this->input->post('Seedselect',true);
		$get_seed = $this->Recheckadmin->get_seed_by_crop($Crop);

		$response = array();

		$html = '';
		if(count($get_seed)>0){
          	$html .= '<select class="form-control select2box" id="Variety_drop" name="Variety">';	
          	$html .= '<option value="">Please Select Seed</option>';
                foreach ($get_seed as $value) {
             		$html .='<option value="'.$value['Variety'].'" ';
             		if ($value['Variety'] == $Seedselect ){
             			$html .='selected' ;
             		}
             		$html .='>'.$value['Variety'].'</option>';
                }
            $html .='</select>';
        }else{
        	$html = 'Seeds Not Found.';
        }

        $response['seed'] = $html;        
		echo json_encode($response);
		die;
	}

	public function supplier_recheck(){
		$Variety = $this->input->post('Variety',true);
		
		$Crop = $this->input->post('Crop',true);
		$Seedselect = $this->input->post('Seedselect',true);
		$get_variety = $this->Recheckadmin->get_variety($Variety);
		$Supplier = $get_variety['Supplier']; 
		
		$get_supplier = $this->Recheckadmin->get_supplier($Supplier);
		

		$response = array();

		$html = '';
		$html .= ' <input type="text" class="form-control" id="Supplier" name="Supplier" value="'.$get_supplier['Name'].'">';
		// $html .= ''.$get_supplier['Name'].'';

        $response['supplier'] = $html;        
		echo json_encode($response);
		die;
	}

	public function deleterecheck_old(){

		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$RecheckID = $this->uri->segment(3);
		if($RecheckID){
			$getsinglerecheck = $this->Recheckadmin->get_single_recheck($RecheckID);
			
			$this->Recheckadmin->deleterecheck($RecheckID,$data['userrole']);
			$this->session->set_flashdata('success', 'Re-check been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');

			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Re-check Delete Variety: '.$getsinglerecheck['Variety'];
			$datalog['Data'] = json_encode($getsinglerecheck);

			$this->Recheckadmin->insert_log($datalog);
		}
		redirect('admin/recheck');
		exit();
	}

	public function deleterecheck(){

		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$RecheckID = $_POST['DeleteID'];
		if($RecheckID){
			$getsinglerecheck = $this->Recheckadmin->get_single_recheck($RecheckID);
			
			$this->Recheckadmin->deleterecheck($RecheckID,$data['userrole']);
			$this->session->set_flashdata('success', 'Re-check been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');

			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Re-check Delete Variety: '.$getsinglerecheck['Variety'];
			$datalog['Data'] = json_encode($getsinglerecheck);

			$this->Recheckadmin->insert_log($datalog);
		}
		
	}

	public function restorerecheck(){

		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$RecheckID = $this->uri->segment(3);
		if($RecheckID){
			$getsinglerecheck = $this->Recheckadmin->get_single_recheck($RecheckID);
			
			$datapost = array();
			$datapost['is_deleted'] = '0';

			$this->Recheckadmin->update_recheck($datapost,$RecheckID);
			$this->session->set_flashdata('success', 'Re-check been Restore successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');

			$datalog['Activity'] = 'Restore';
			$datalog['Title'] = 'Re-check Restore Variety: '.$getsinglerecheck['Variety'];
			$datalog['Data'] = json_encode($getsinglerecheck);

			$this->Recheckadmin->insert_log($datalog);
		}
		redirect('admin/recheck');
		exit();
	}

	private function validateLogin(){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			redirect('admin/logout');
			exit();   
		}
		$get_user_detail=$this->Recheckadmin->get_user_detail($this->session->userdata('UserID'));
		$userrole= $get_user_detail['userrole'];
		$user_permission= $get_user_detail['userpermission'];
		if($userrole!='1' AND $userrole!='4'){
			redirect('admin/logout');
			exit();  
		}
		if($user_permission!=''){
			$userpermission= json_decode($user_permission);
		}else{	
			$userpermission= array();
		}
		$data['userpermission'] = $userpermission;
		$data['userrole'] = $userrole;
		return $data;
	} 
}