<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Precommercial extends MX_Controller {

	function __construct()   {
		parent::__construct();
		$this->load->model('Precommercialadmin','',TRUE);
		$this->load->library('session');
		$this->load->library('pagination');
    } 

	public function index(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$data['heading_title']='Pre-commercial';
		$data['active']='precommercial';
		$data['submenuactive']='precommercial';

		$Crop = $this->input->get('Crop');
		$Supplier = $this->input->get('Supplier');

		if ($Crop || $Supplier){
   			$total_rows = $this->Precommercialadmin->filter_get_precommercial_count($data['userrole'],$Crop,$Supplier);
   		}else{
   			$total_rows = $this->Precommercialadmin->get_precommercial_count($data['userrole']);
   		}

		$config = array();

		if ($Crop || $Supplier) 
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['use_page_numbers'] = false;
		$config['base_url'] = base_url() .'admin/precommercial/';
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

		if ($Crop || $Supplier){
   			$get_precommercial = $this->Precommercialadmin->filter_get_precommercial($data['userrole'],$Crop,$Supplier,$config["per_page"], $page);
   		}else{
			$get_precommercial = $this->Precommercialadmin->get_precommercial($config["per_page"], $page,$data['userrole']);
		}
		$getprecommercials =array();
		foreach ($get_precommercial as $key => $value) {
			$getprecommercial =array();
			$getprecommercial['PrecommercialID'] = $value['PrecommercialID'];
			$getprecommercial['EvaluationID'] = $value['EvaluationID'];
			$getprecommercial['Marketsize'] = $value['Marketsize'];
			$getprecommercial['Competitors'] = $value['Competitors'];
			$getprecommercial['Numebrofseedsrequast'] = $value['Numebrofseedsrequast'];
			$getprecommercial['Bywhen'] = $value['Bywhen'];
			$getprecommercial['Suggestedcommerical'] = $value['Suggestedcommerical'];
			$getprecommercial['is_deleted'] = $value['is_deleted'];

			$getprecommercial['Crop'] = '';
			$getprecommercial['Supplier'] = '';	
			$getprecommercial['Variety'] = '';

			if($value['EvaluationID']){
				$get_evaluation = $this->Precommercialadmin->get_evaluation($value['EvaluationID']);

				if($get_evaluation){
					$Internalsamplecode = $get_evaluation['Internalsamplecode'];
					if($Internalsamplecode){

						$get_sampling = $this->Precommercialadmin->get_sampling($Internalsamplecode);
						if($get_sampling){

							$get_crop = $this->Precommercialadmin->get_crop($get_sampling['Crop']);
							
							$get_supplier = $this->Precommercialadmin->get_supplier($get_sampling['SupplierID']);
							$get_seed = $this->Precommercialadmin->get_seed($get_sampling['Seed']);
							if($get_crop){
								$getprecommercial['Crop'] = $get_crop['Title'];
							}
							if($get_supplier){
								$getprecommercial['Supplier'] = $get_supplier['Name'];
							}

							if($get_seed){
								$getprecommercial['Variety'] = $get_seed['Variety'];
							}
						}
					}
				}
			}else{
				$get_crop = $this->Precommercialadmin->get_crop($value['Crop']);
				$get_supplier = $this->Precommercialadmin->get_supplier($value['Supplier']);

				if($get_crop){
					$getprecommercial['Crop'] = $get_crop['Title'];
				}
				if($get_supplier){
					$getprecommercial['Supplier'] = $get_supplier['Name'];
				}
				$getprecommercial['Variety'] = $value['Variety'];
			}


			$getprecommercials[] = $getprecommercial;
		}

		$get_crops = $this->Precommercialadmin->get_crops();
		$crops = array();
		foreach ($get_crops as $value) {
			$crops[$value['CropID']] = $value['Title'];
		}
		//asort($crops);

		$get_suppliers = $this->Precommercialadmin->get_suppliers();
		$suppliers = array();
		foreach ($get_suppliers as $value) {
			$suppliers[$value['SupplierID']] = $value['Name'];
		}
		//asort($suppliers);
		$data["crops"] = $crops;
		$data["suppliers"] = $suppliers;

		
		$data["precommercial"] = $getprecommercials;
        $data["links"] = $this->pagination->create_links();
		$this->load->view('precommercial',$data);
	}



	public function precommercialedit(){

		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$error = array();

		
		$error['Crop'] = '';
		$error['Variety'] = '';
		$error['Supplier'] = '';
		$error['Marketsize'] = '';
		$error['Numebrofseedsrequast'] = '';
		$error['Bywhen'] = '';

		$PrecommercialID = @$_GET['PrecommercialID'];

		$get_single_precommercial =array();

		$get_single_precommercial['EvaluationID'] = '';
		$get_single_precommercial['Crop'] = '';
		$get_single_precommercial['Variety'] = '';
		$get_single_precommercial['Supplier'] = '';
		$get_single_precommercial['Marketsize'] = '';
		$get_single_precommercial['Numebrofseedsrequast'] = '';
		$get_single_precommercial['Bywhen'] = '';
		$get_single_precommercial['Competitors'] = '';
		$get_single_precommercial['Suggestedcommerical'] = '';
		
		if($PrecommercialID){			
			$get_single_precommercial = $this->Precommercialadmin->get_single_precommercial($PrecommercialID);
			if($get_single_precommercial['EvaluationID']){
				$get_evaluation = $this->Precommercialadmin->get_evaluation($get_single_precommercial['EvaluationID']);
				if($get_evaluation){
					$Internalsamplecode = $get_evaluation['Internalsamplecode'];
					if($Internalsamplecode){
						$get_sampling = $this->Precommercialadmin->get_sampling($Internalsamplecode);
						if($get_sampling){
							$get_single_precommercial['Crop'] = $get_sampling['Crop'];
							$get_single_precommercial['Supplier'] = $get_sampling['SupplierID'];

							$get_seed = $this->Precommercialadmin->get_seed($get_sampling['Seed']);
							if($get_seed){
								$get_single_precommercial['Variety'] = $get_seed['Variety'];
							}
						}
					}
				}
			}

			$data['heading_title']='Edit precommercial';
		}else{
			$data['heading_title']='Add precommercial';
		}

		if (($this->input->server('REQUEST_METHOD') == 'POST')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('Crop', 'Crop', 'required|trim');
			$this->form_validation->set_rules('Variety', 'Variety', 'required|trim');
			$this->form_validation->set_rules('Supplier', 'Supplier', 'required|trim');
			$this->form_validation->set_rules('Marketsize', 'Market size', 'required|trim');
			$this->form_validation->set_rules('Numebrofseedsrequast', 'Numebr of seeds requast', 'required|trim');
			$this->form_validation->set_rules('Bywhen', 'By when', 'required|trim');
			if ($this->form_validation->run() == FALSE) {
				if(form_error('Crop')){
					$error['Crop']  =form_error('Crop');
				}
				if(form_error('Variety')){
					$error['Variety']  =form_error('Variety');
				}
				if(form_error('Supplier')){
					$error['Supplier']  =form_error('Supplier');
				}
				if(form_error('Marketsize')){
					$error['Marketsize']  =form_error('Marketsize');
				}
				if(form_error('Numebrofseedsrequast')){
					$error['Numebrofseedsrequast']  =form_error('Numebrofseedsrequast');
				}
				if(form_error('Bywhen')){
					$error['Bywhen']  =form_error('Bywhen');
				}
			}else{

				$datapost =array();			
				$datapost['Crop'] = $this->input->post('Crop',true);
				$datapost['Variety'] = $this->input->post('Variety',true);
				$datapost['Supplier'] = $this->input->post('Supplier',true);
				$datapost['Marketsize'] = $this->input->post('Marketsize',true);
				$datapost['Numebrofseedsrequast'] = $this->input->post('Numebrofseedsrequast',true);
				$datapost['Bywhen'] = $this->input->post('Bywhen',true);
				$Competitorsname = $this->input->post('Competitorsname',true);
				$Competitorsprices = $this->input->post('Competitorsprices',true);
				$Competitorspagaking = $this->input->post('Competitorspagaking',true);
				
				$Competitors = array();
				if($Competitorsname!=''){
					foreach ($Competitorsname as $key => $value) {
						$Competitor = array();
						$Competitor['Name'] = $Competitorsname[$key];
						$Competitor['Prices'] = $Competitorsprices[$key];
						$Competitor['Pagaking'] = $Competitorspagaking[$key];
						$Competitors[] = $Competitor;
					}
				}
				$CompetitorsData = json_encode($Competitors);
				$datapost['Competitors'] = $CompetitorsData;

				$Suggestedcommericalname = $this->input->post('Suggestedcommericalname',true);
				
				$upload_filename = array();

				if( $this->input->post('img_exits') != '' ){
                    $img_exits_array  = $this->input->post('img_exits');
                    foreach($img_exits_array as $img_exits_value)
                    {
                         $upload_filename[] =$img_exits_value;
                    }
                }
				if(@$_FILES["Suggestedcommericalfiles"]["name"] != ''){
                    $targetDir = "uploads/Suggestedcommericalfiles/";
                    $allowTypes = array('jpg','png','jpeg','gif');

                    $images_arr = array();
                    foreach($_FILES['Suggestedcommericalfiles']['name'] as $key=>$val){
                    	if($_FILES['Suggestedcommericalfiles']['name'][$key]==''){
                    		 $upload_filename[] = '';
	                    }else{
	                        $image_name = time()."_".$_FILES['Suggestedcommericalfiles']['name'][$key];
	                        $tmp_name   = $_FILES['Suggestedcommericalfiles']['tmp_name'][$key];
	                        $size       = $_FILES['Suggestedcommericalfiles']['size'][$key];
	                        $type       = $_FILES['Suggestedcommericalfiles']['type'][$key];
	                        $error      = $_FILES['Suggestedcommericalfiles']['error'][$key];
	                        // File upload path
	                        $fileName = basename($image_name);
	                        $file_Name = str_replace(' ', '_', $fileName);
	                        $targetFilePath = $targetDir . $file_Name;
	                        // Check whether file type is valid
	                        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
	                        //if(in_array($fileType, $allowTypes)){    
	                            // Store file on the server
	                            if(move_uploaded_file($_FILES['Suggestedcommericalfiles']['tmp_name'][$key],$targetFilePath)){
	                                $images_arr[] = $targetFilePath;
	                            }
	                            $upload_filename[] =$file_Name;
	                        //}
	                    }
                    }
                }

				$Suggestedcommerical = array();
				if($Suggestedcommericalname!=''){
					foreach ($Suggestedcommericalname as $key => $value) {
						$Competitor = array();
						$Competitor['Name'] = $Suggestedcommericalname[$key];
						$Competitor['Image'] = $upload_filename[$key];
						$Suggestedcommerical[] = $Competitor;
					}
				}	

				$SuggestedcommericalData = json_encode($Suggestedcommerical);
				$datapost['Suggestedcommerical'] = $SuggestedcommericalData;


				$datalog = array();
				$datalog['UserID'] = $this->session->userdata('UserID');
				if($PrecommercialID){
					$getsingleprecommercial = $this->Precommercialadmin->get_single_precommercial($PrecommercialID);

					if($getsingleprecommercial['EvaluationID']){
						$datapost['Crop'] = '';
						$datapost['Variety'] = '';
						$datapost['Supplier'] = '';
					}
					
					$this->Precommercialadmin->update_precommercial($datapost,$PrecommercialID);
					$this->session->set_flashdata('success', 'Pre-commercial update successfully.');

					$datalog['Activity'] = 'Update';
					$datalog['Title'] = 'Pre-commercial Update Variety: '.$this->input->post('Variety',true);
					$datalog['Data'] = json_encode($getsingleprecommercial);
				}else{
					$datapost['UserID'] = $this->session->userdata('UserID');
					$PrecommercialID = $this->Precommercialadmin->insert_precommercial($datapost);
					$this->session->set_flashdata('success', 'Pre-commercial added successfully.');

					$datalog['Activity'] = 'Insert';
					$datalog['Title'] = 'Pre-commercial added Variety: '.$this->input->post('Variety',true);
					$datalog['Data'] = json_encode($datapost);
				}
				$this->Precommercialadmin->insert_log($datalog);

				redirect('admin/precommercial');
				exit();
			}	

			$get_single_precommercial['Crop'] = $this->input->post('Crop',true);
			$get_single_precommercial['Variety'] = $this->input->post('Variety',true);
			$get_single_precommercial['Supplier'] = $this->input->post('Supplier',true);
			$get_single_precommercial['Marketsize'] = $this->input->post('Marketsize',true);
			$get_single_precommercial['Numebrofseedsrequast'] = $this->input->post('Numebrofseedsrequast',true);
			$get_single_precommercial['Bywhen'] = $this->input->post('Bywhen',true);
		}

		


		$data["crops"] = $this->Precommercialadmin->get_crops();
		$data["suppliers"] = $this->Precommercialadmin->get_suppliers();
		
		$data['error']=$error;
		$data['active']='precommercial';
		$data['submenuactive']='precommercialedit';
		$data['get_single_precommercial']= $get_single_precommercial;
		$this->load->view('precommercialedit',$data);
	}

	public function deleteprecommercial_old(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$PrecommercialID = $this->uri->segment(3);

		if($PrecommercialID){
			$getsingleprecommercial = $this->Precommercialadmin->get_single_precommercial($PrecommercialID);

			$this->Precommercialadmin->deleteprecommercial($PrecommercialID,$data['userrole']);
			$this->session->set_flashdata('success', 'Pre-commercial been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');

			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Pre-commercial Delete Variety: '.$getsingleprecommercial['Variety'];
			$datalog['Data'] = json_encode($getsingleprecommercial);
			$this->Precommercialadmin->insert_log($datalog);
		}
		redirect('admin/precommercial');
		exit();
	}

	public function deleteprecommercial(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$PrecommercialID = $_POST['DeleteID'];

		if($PrecommercialID){
			$getsingleprecommercial = $this->Precommercialadmin->get_single_precommercial($PrecommercialID);

			$this->Precommercialadmin->deleteprecommercial($PrecommercialID,$data['userrole']);
			$this->session->set_flashdata('success', 'Pre-commercial been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');

			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Pre-commercial Delete Variety: '.$getsingleprecommercial['Variety'];
			$datalog['Data'] = json_encode($getsingleprecommercial);
			$this->Precommercialadmin->insert_log($datalog);
		}
		
	}


	public function restoreprecommercial(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$PrecommercialID = $this->uri->segment(3);

		if($PrecommercialID){
			$getsingleprecommercial = $this->Precommercialadmin->get_single_precommercial($PrecommercialID);

			$datapost = array();
			$datapost['is_deleted'] = '0';

			$this->Precommercialadmin->update_precommercial($datapost,$PrecommercialID);
			$this->session->set_flashdata('success', 'Pre-commercial been Restore successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');

			$datalog['Activity'] = 'Restore';
			$datalog['Title'] = 'Pre-commercial Restore Variety: '.$getsingleprecommercial['Variety'];
			$datalog['Data'] = json_encode($getsingleprecommercial);
			$this->Precommercialadmin->insert_log($datalog);
		}
		redirect('admin/precommercial');
		exit();
	}

	private function validateLogin(){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			redirect('admin/logout');
			exit();   
		}
		$get_user_detail=$this->Precommercialadmin->get_user_detail($this->session->userdata('UserID'));
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