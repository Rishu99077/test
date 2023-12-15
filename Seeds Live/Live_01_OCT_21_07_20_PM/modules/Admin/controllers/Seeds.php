<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Seeds extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('Seedsadmin','',TRUE);
		$this->load->library('session');
		$this->load->library('pagination');			
    } 

	public function index(){
		$validateLogin = $this->validateLogin('seeds','list');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];	


		$data['heading_title']='Seeds';
		$data['active']='seeds';
		$data['submenuactive']='seeds';

		$Crop = $this->input->get('Crop');
   		$Supplier = $this->input->get('Supplier');
   		$Variety = $this->input->get('Variety');
   		$getStatus = $this->input->get('Status');
   		$FromDate = $this->input->get('FromDate');
   		$ToDate = $this->input->get('ToDate');


   		if ($Crop || $Supplier || $Variety || $getStatus != '' || $FromDate || $ToDate){
   			$total_rows = $this->Seedsadmin->filter_seeds_num_row($data['userrole'],$Crop,$Supplier,$Variety,$getStatus,$FromDate,$ToDate);
   		}else{
   			$total_rows = $this->Seedsadmin->get_seeds_count($data['userrole']);
   		}

		
		$config = array();
		if ($Crop || $Supplier || $Variety || $getStatus != '' || $FromDate || $ToDate) $config['suffix'] = '?' . http_build_query($_GET, '', "&");

		$config['base_url'] = base_url() .'admin/seeds/';
		$config['use_page_numbers'] = false;
		$config['total_rows'] = $total_rows;
		$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
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

		$Status = array();
		// $Status[] = '-- Select Status --';
		$Status[] = 'New Sample';
		$Status[] = 'Re-check 1';
		$Status[] = 'Re-check 2';
		$Status[] = 'Re-check 3';
		$Status[] = 'Pre-commercial';
		$Status[] = 'Commercial or control variety';
		$Status[] = 'Drop';

		if ($Crop || $Supplier || $Variety || $getStatus !='' || $FromDate || $ToDate){
   			$get_seeds = $this->Seedsadmin->get_filter_seeds($data['userrole'],$Crop,$Supplier,$Variety,$config["per_page"], $page,$getStatus,$FromDate,$ToDate);
   		}else{
   			$get_seeds = $this->Seedsadmin->get_seeds($config["per_page"], $page,$data['userrole']);
   		}
   		
		$seeds = array();
		foreach ($get_seeds as  $get_seed) {
			$seed = array();
			$get_crop = $this->Seedsadmin->get_crop($get_seed['Crop']);
			$get_supplier = $this->Seedsadmin->get_supplier($get_seed['Supplier']);

			$seed['SeedID'] = $get_seed['SeedID'];
			$seed['Crop'] = $get_crop['Title'];
			$seed['Supplier'] = $get_supplier['Name'];
			$seed['Variety'] = $get_seed['Variety'];
			$seed['Dateofrecivedsampel'] = $get_seed['Dateofrecivedsampel'];
			$seed['Status'] = $Status[$get_seed['Status']];
			$seed['AddedDate'] = $get_seed['AddedDate'];	
			$seed['is_deleted'] = $get_seed['is_deleted'];
			// $get_samplings = $this->Seedsadmin->get_sampling($get_seed['SeedID']);
			// foreach ($get_samplings as $key => $value) {
			// 	@$seed['Location'] = $value['Location'];
			// }
			$seeds[] = $seed;
		}
		$data["seeds"] = $seeds;

		if($Crop!='' || $Supplier!=''){
        	$all_seeds = $this->Seedsadmin->get_filter_variety_seeds($Crop,$Supplier);
    	}else{
			$all_seeds = $this->Seedsadmin->get_seeds_all();
		}
		$allseeds = array();
		foreach ($all_seeds as  $value) {
			$allseeds[] = $value['Variety'];
		}
		asort($allseeds);
		$data["allseeds"] = $allseeds;

		$get_crops = $this->Seedsadmin->get_crops();
		$crops = array();
		foreach ($get_crops as $value) {
			$crops[$value['CropID']] = $value['Title'];
		}
		//asort($crops);

		$get_suppliers = $this->Seedsadmin->get_suppliers();
		$suppliers = array();
		foreach ($get_suppliers as $value) {
			$suppliers[$value['SupplierID']] = $value['Name'];
		}
		//asort($suppliers);

        $data["links"] = $this->pagination->create_links();
        $data["crops"] = $crops;
        $data["suppliers"] = $suppliers;

        // asort($Status);
        $data["statusall"] = $Status;
		$this->load->view('seeds',$data);
	}

	public function seededit(){
		$validateLogin = $this->validateLogin('seeds','seededit');
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
		$error['TechnicalData']='';
		$error['Attachment'] = '';
		$SeedID = @$_GET['SeedID'];

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
		$get_seed['TechnicalData']='';
		$get_seed['Attachment'] = '';


		$Status = array();
		$Status[] = 'New Sample';
		$Status[] = 'Re-check 1';
		$Status[] = 'Re-check 2';
		$Status[] = 'Re-check 3';
		$Status[] = 'Pre-commercial';
		$Status[] = 'Commercial or control variety';
		$Status[] = 'Drop';

		$stockedit = true;

		if($SeedID){		
			$get_seed = $this->Seedsadmin->get_seed($SeedID);
			$data['heading_title']='Edit Seed';
			$get_sampling_count = $this->Seedsadmin->get_sampling_count($SeedID);
			if($get_sampling_count>1){
				$stockedit = false;
			}
		}else{
			$data['heading_title']='Add Seed';
		}
		$data['stockedit']=$stockedit;

		if (($this->input->server('REQUEST_METHOD') == 'POST')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('Crop', 'Crop', 'required|trim');
			$this->form_validation->set_rules('Supplier', 'Supplier', 'required|trim');
			if ($SeedID) {
			$this->form_validation->set_rules('Variety', 'Variety', 'required|trim');
			}else{
			$this->form_validation->set_rules('Variety', 'Variety', 'required|trim|is_unique[seeds.Variety]',array('is_unique' => 'This %s is Already exists.'));
			}
			$this->form_validation->set_rules('Dateofrecivedsampel', 'Date of recived sampel', 'required|trim');
			$this->form_validation->set_rules('Status', 'Status', 'required|trim');
			$this->form_validation->set_rules('Stockquantityfor', 'Stock quantity for', 'required|trim');
			$this->form_validation->set_rules('Stockquantity', 'Stock quantity', 'required|trim');


			if ($this->form_validation->run() == FALSE) {
				if(form_error('Crop')){
					$error['Crop']  =form_error('Crop');
				}
				if(form_error('Supplier')){
					$error['Supplier']  =form_error('Supplier');
				}
				if(form_error('Variety')){
					$error['Variety']  =form_error('Variety');
				}
				if(form_error('Dateofrecivedsampel')){
					$error['Dateofrecivedsampel']  =form_error('Dateofrecivedsampel');
				}
				if(form_error('Status')){
					$error['Status']  =form_error('Status');
				}
				if(form_error('Stockquantityfor')){
					$error['Stockquantityfor']  =form_error('Stockquantityfor');
				}
				if(form_error('Stockquantity')){
					$error['Stockquantity']  =form_error('Stockquantity');
				}
				
			}else{
				$datapost =array();			
				$datapost['Crop'] = $this->input->post('Crop',true);
				$datapost['Supplier'] = $this->input->post('Supplier',true);
				$datapost['Variety'] = $this->input->post('Variety',true);
				$datapost['Dateofrecivedsampel'] = $this->input->post('Dateofrecivedsampel',true);
				$datapost['Status'] = $this->input->post('Status',true);
				$datapost['Stockquantityfor'] = $this->input->post('Stockquantityfor',true);
				$datapost['Stockquantity'] = $this->input->post('Stockquantity',true);
				$datapost['Note'] = $this->input->post('Note',true);
				$datapost['TechnicalData'] = $this->input->post('TechnicalData',true);

							
				$upload_filename = '';
				if( $this->input->post('img_exits') != '' ){
                    $img_exits_array  = $this->input->post('img_exits');
                    foreach($img_exits_array as $img_exits_value)
                    {
                         $img_exits_value;
                         $upload_filename .=$img_exits_value.",";
                    }
                }
				if(@$_FILES["files"]["name"] != ''){
                    $targetDir = "uploads/Seeds/";
                    $allowTypes = array('jpg','png','jpeg','gif','pdf');

                    $images_arr = array();
                    foreach($_FILES['files']['name'] as $key=>$val){

                        $image_name = time()."_".$key."_".$_FILES['files']['name'][$key];
                        $tmp_name   = $_FILES['files']['tmp_name'][$key];
                        $size       = $_FILES['files']['size'][$key];
                        $type       = $_FILES['files']['type'][$key];
                        $error      = $_FILES['files']['error'][$key];
                        // File upload path
                        $fileName = basename($image_name);
                        $file_Name = str_replace(' ', '_', $fileName);
                        $targetFilePath = $targetDir . $file_Name;
                        // Check whether file type is valid
                        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                        //if(in_array($fileType, $allowTypes)){    
                            // Store file on the server
                            if(move_uploaded_file($_FILES['files']['tmp_name'][$key],$targetFilePath)){
                                $images_arr[] = $targetFilePath;
                                if (!$fileType=='pdf') {
                               		 $this->resizeImage($file_Name);  
                                }
                            	
                            	$upload_filename .=$file_Name.",";
                            }
                        //}
                    }
                    $upload_filename = trim($upload_filename,",");
                    $upload_filename = str_replace(' ', '_', $upload_filename);

                    //print_r($upload_filename);
                }
                
	            $datapost['Attachment'] = $upload_filename;


	            $datalog = array();
	            $datalog['UserID'] = $this->session->userdata('UserID');
				if($SeedID){
					$getseed = $this->Seedsadmin->get_seed($SeedID);

					$this->Seedsadmin->update_seed($datapost,$SeedID);
					$this->session->set_flashdata('success', 'Seed update successfully.');

					$datalog['Activity'] = 'Update';
					$datalog['Title'] = 'Seed Update Variety: '.$this->input->post('Variety',true);
					$datalog['Data'] = json_encode($getseed);

				}else{
					$datapost['UserID'] = $this->session->userdata('UserID');
					// development
					$get_users = $this->Seedsadmin->get_users($datapost['UserID']);
					$datapost['userrole'] = $get_users['userrole'];
					$SeedID = $this->Seedsadmin->insert_seed($datapost);
					$this->session->set_flashdata('success', 'Seed added successfully.');

					$datalog['Activity'] = 'Insert';
					$datalog['Title'] = 'Seed added Variety: '.$this->input->post('Variety',true);
					$datalog['Data'] = json_encode($this->input->post());
				}
				$this->Seedsadmin->insert_log($datalog);	
				//redirect('admin/seeds');
				if(@$_GET['rediret_url']!=''){
					redirect($_GET['rediret_url']);
				}else{
					redirect('admin/seeds');
				}
				exit();
			}

			$get_seed['Crop'] = $this->input->post('Crop',true);
			$get_seed['Supplier'] = $this->input->post('Supplier',true);
			$get_seed['Variety'] = $this->input->post('Variety',true);
			$get_seed['Dateofrecivedsampel'] = $this->input->post('Dateofrecivedsampel',true);
			$get_seed['Stockquantityfor'] = $this->input->post('Stockquantityfor',true);
			$get_seed['Stockquantity'] = $this->input->post('Stockquantity',true);
			$get_seed['Status'] = $this->input->post('Status',true);
			$get_seed['Note'] = $this->input->post('Note',true);
			$get_seed['TechnicalData'] = $this->input->post('TechnicalData',true);
		}
		
		$Stockquantityfor = array();
		$Stockquantityfor[] = 'Gram';
		$Stockquantityfor[] = 'Kg';
		$Stockquantityfor[] = 'Seed';


		$data["crops"] = $this->Seedsadmin->get_crops();
		$data["suppliers"] = $this->Seedsadmin->get_suppliers();
		
		$data['error']=$error;
		$data['active']='seeds';
		$data['submenuactive']='seededit';
		$data['get_seed']= $get_seed;
		$data['Status']= $Status;
		$data['Stockquantityfor']= $Stockquantityfor;
		$data['baseurl']= base_url();
		$this->load->view('seededit',$data);
	}

	public function seedsadd(){
		$validateLogin = $this->validateLogin('seeds','seedsadd');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$error = array();
		$error['Crop'] = '';
		$error['Variety'] = '';
		$error['Supplier'] = '';
		$error['Checkvariety'] = '';
		$error['Dateofrecivedsampel'] = '';
		$error['Stockquantityfor'] = '';
		$error['Stockquantity'] = '';
		$SeedID = @$_GET['SeedID'];

		$get_seed =array();
		$get_seed['SeedID'] = '';
		$get_seed['Crop'] = '';
		$get_seed['Supplier'] = '';
		$get_seed['Variety'] = '';
		$get_seed['Dateofrecivedsampel'] = '';
		$get_seed['Stockquantityfor'] = '';
		$get_seed['Stockquantity'] = '';

		$stockedit = true;

			
		$get_seed = $this->Seedsadmin->get_seed($SeedID);
		$data['heading_title']='Add New Seed';
		$get_sampling_count = $this->Seedsadmin->get_sampling_count($SeedID);
		if($get_sampling_count>1){
			$stockedit = false;
		}
		

		$data['stockedit']=$stockedit;

		if (($this->input->server('REQUEST_METHOD') == 'POST')){
			$this->load->library('form_validation');
			// $this->form_validation->set_rules('Crop', 'Crop', 'required|trim');
			if ($SeedID) {
			$this->form_validation->set_rules('Variety', 'Variety', 'required|trim');
			}else{
			$this->form_validation->set_rules('Variety', 'Variety', 'required|trim|is_unique[seeds.Variety]',array('is_unique' => 'This %s is Already exists.'));
			}
			$this->form_validation->set_rules('Dateofrecivedsampel', 'Date of recived sampel', 'required|trim');
			$this->form_validation->set_rules('Stockquantityfor', 'Stock quantity for', 'required|trim');
			$this->form_validation->set_rules('Stockquantity', 'Stock quantity', 'required|trim');


			if ($this->form_validation->run() == FALSE) {
				// if(form_error('Crop')){
				// 	$error['Crop']  =form_error('Crop');
				// }
				
				
				if(form_error('Variety')){
					$error['Variety']  =form_error('Variety');
				}
				if(form_error('Dateofrecivedsampel')){
					$error['Dateofrecivedsampel']  =form_error('Dateofrecivedsampel');
				}
				if(form_error('Stockquantityfor')){
					$error['Stockquantityfor']  =form_error('Stockquantityfor');
				}
				if(form_error('Stockquantity')){
					$error['Stockquantity']  =form_error('Stockquantity');
				}
				
			}else{

				$datapost =array();			
				// $datapost['Crop'] = $this->input->post('Crop',true);
				// $datapost['Supplier'] = $this->input->post('Supplier',true);
				$datapost['Variety'] = $this->input->post('Variety',true);
				$datapost['Dateofrecivedsampel'] = $this->input->post('Dateofrecivedsampel',true);
				$datapost['Stockquantityfor'] = $this->input->post('Stockquantityfor',true);
				$datapost['Stockquantity'] = $get_seed['Stockquantity']+$this->input->post('Stockquantity',true);


				$datastock = array();

				$datastock['SeedID'] = $SeedID;
				$datastock['Dateofrecivedsampel'] = $this->input->post('Dateofrecivedsampel',true);
				$datastock['Stockquantityfor'] = $this->input->post('Stockquantityfor',true);
				$datastock['Stockquantity'] = $this->input->post('Stockquantity',true);
				$datastock['AddedDate'] = date('Y-m-d H:i:s');
				$datastock['AddedBy'] = $this->session->userdata('UserID');

				$this->Seedsadmin->insert_seedstock($datastock);

	            $datalog = array();
	            $datalog['UserID'] = $this->session->userdata('UserID');
				if($SeedID){
					$getseed = $this->Seedsadmin->get_seed($SeedID);

					$this->Seedsadmin->update_seed($datapost,$SeedID);
					$this->session->set_flashdata('success', 'Seed Stock update successfully.');

					$datalog['Activity'] = 'Update';
					$datalog['Title'] = 'Seed Update Variety: '.$this->input->post('Variety',true);
					$datalog['Data'] = json_encode($getseed);

				}
				$this->Seedsadmin->insert_log($datalog);	
				//redirect('admin/seeds');
				if(@$_GET['rediret_url']!=''){
					redirect($_GET['rediret_url']);
				}else{
					redirect('admin/seeds');
				}
				exit();
			}

			$get_seed['Crop'] = $this->input->post('Crop',true);
			$get_seed['Supplier'] = $this->input->post('Supplier',true);
			$get_seed['Variety'] = $this->input->post('Variety',true);
			$get_seed['Dateofrecivedsampel'] = $this->input->post('Dateofrecivedsampel',true);
			$get_seed['Stockquantityfor'] = $this->input->post('Stockquantityfor',true);
			$get_seed['Stockquantity'] = $this->input->post('Stockquantity',true);

		}
		
		$Stockquantityfor = array();
		$Stockquantityfor[] = 'Gram';
		$Stockquantityfor[] = 'Kg';
		$Stockquantityfor[] = 'Seed';


		$data["crops"] = $this->Seedsadmin->get_crops();
		$data["suppliers"] = $this->Seedsadmin->get_suppliers();

		$data['error']=$error;
		$data['active']='seeds';
		$data['submenuactive']='seededit';
		$data['get_seed']= $get_seed;
		$data['Stockquantityfor']= $Stockquantityfor;
		$data['baseurl']= base_url();
		$this->load->view('seedsadd',$data);
	}

	public function seedstatus(){
		$validateLogin = $this->validateLogin('seeds','seedstatus');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$error = array();
		$error['Crop'] = '';
		$error['Variety'] = '';
		$error['Supplier'] = '';
		$error['Checkvariety'] = '';
		$error['Dateofrecivedsampel'] = '';
		$error['Status'] = '';
		
		$SeedID = @$_GET['SeedID'];


		$get_seed =array();
		$get_seed['SeedID'] = '';
		$get_seed['Crop'] = '';
		$get_seed['Supplier'] = '';
		$get_seed['Variety'] = '';
		$get_seed['Dateofrecivedsampel'] = '';
		$get_seed['Status'] = '';


		$Status = array();
		$Status[] = 'New Sample';
		$Status[] = 'Re-check 1';
		$Status[] = 'Re-check 2';
		$Status[] = 'Re-check 3';
		$Status[] = 'Pre-commercial';
		$Status[] = 'Commercial or control variety';
		$Status[] = 'Drop';


		$stockedit = true;

			
		$get_seed = $this->Seedsadmin->get_seed($SeedID);
		$data['heading_title']='Change Status';
		$get_sampling_count = $this->Seedsadmin->get_sampling_count($SeedID);
		if($get_sampling_count>1){
			$stockedit = false;
		}
		

		$data['stockedit']=$stockedit;

		if (($this->input->server('REQUEST_METHOD') == 'POST')){
			$this->load->library('form_validation');
			// $this->form_validation->set_rules('Crop', 'Crop', 'required|trim');
			if ($SeedID) {
			$this->form_validation->set_rules('Variety', 'Variety', 'required|trim');
			}else{
			$this->form_validation->set_rules('Variety', 'Variety', 'required|trim|is_unique[seeds.Variety]',array('is_unique' => 'This %s is Already exists.'));
			}
			$this->form_validation->set_rules('Dateofrecivedsampel', 'Date of recived sampel', 'required|trim');
			$this->form_validation->set_rules('Status', 'Status', 'required|trim');


			if ($this->form_validation->run() == FALSE) {
				if(form_error('Variety')){
					$error['Variety']  =form_error('Variety');
				}
				if(form_error('Dateofrecivedsampel')){
					$error['Dateofrecivedsampel']  =form_error('Dateofrecivedsampel');
				}
				if(form_error('Status')){
					$error['Status']  =form_error('Status');
				}
				
			}else{

				$datapost =array();			
				// $datapost['Crop'] = $this->input->post('Crop',true);
				// $datapost['Supplier'] = $this->input->post('Supplier',true);
				$datapost['Variety'] = $this->input->post('Variety',true);
				$datapost['Dateofrecivedsampel'] = $this->input->post('Dateofrecivedsampel',true);
				$datapost['Status'] = $this->input->post('Status',true);

	            $datalog = array();
	            $datalog['UserID'] = $this->session->userdata('UserID');
				if($SeedID){
					$getseed = $this->Seedsadmin->get_seed($SeedID);

					$this->Seedsadmin->update_seed($datapost,$SeedID);
					$this->session->set_flashdata('success', 'Seed Status update successfully.');

					$datalog['Activity'] = 'Update';
					$datalog['Title'] = 'Seed Update Status: '.$this->input->post('Variety',true);
					$datalog['Data'] = json_encode($getseed);

				}
				$this->Seedsadmin->insert_log($datalog);	
				//redirect('admin/seeds');
				if(@$_GET['rediret_url']!=''){
					redirect($_GET['rediret_url']);
				}else{
					redirect('admin/seeds');
				}
				exit();
			}

			$get_seed['Crop'] = $this->input->post('Crop',true);
			$get_seed['Supplier'] = $this->input->post('Supplier',true);
			$get_seed['Variety'] = $this->input->post('Variety',true);
			$get_seed['Dateofrecivedsampel'] = $this->input->post('Dateofrecivedsampel',true);
			$get_seed['Status'] = $this->input->post('Status',true);

		}

		$data["crops"] = $this->Seedsadmin->get_crops();
		$data["suppliers"] = $this->Seedsadmin->get_suppliers();

		$data['error']=$error;
		$data['active']='seeds';
		$data['submenuactive']='seeds';
		$data['Status']= $Status;
		$data['get_seed']= $get_seed;
		$data['baseurl']= base_url();
		$this->load->view('seedstatus',$data);
	}

	public function seedrecord(){
		$validateLogin = $this->validateLogin('seeds','list');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];	
		$SeedID = @$_GET['SeedID'];

		$data['heading_title']='Seeds Stock Record';
		$data['active']='seeds';
		$data['submenuactive']='seeds';

   		$total_rows = $this->Seedsadmin->get_seedsrecord_count($data['userrole'],$SeedID);

		
		$config = array();

		$config['base_url'] = base_url() .'admin/seeds/';
		$config['use_page_numbers'] = false;
		$config['total_rows'] = $total_rows;
		$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
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
		
   		$get_seedrecord = $this->Seedsadmin->get_seedrecord($config["per_page"], $page,$data['userrole'],$SeedID);
		$seedsrecords = array();
		foreach ($get_seedrecord as  $value) {
			$seed = array();	
			$get_cropid = $this->Seedsadmin->get_cropid($value['SeedID']);
			$CropID = $get_cropid['Crop'];
			$get_crop = $this->Seedsadmin->get_crop($CropID);
			$seedrecord['Crop'] = $get_crop['Title'];
			$seedrecord['SeedID'] = $value['SeedID'];
			$seedrecord['Dateofrecivedsampel'] = $value['Dateofrecivedsampel'];
			$seedrecord['Stockquantityfor'] = $value['Stockquantityfor'];
			$seedrecord['Stockquantity'] = $value['Stockquantity'];
			$seedrecord['AddedDate'] = $value['AddedDate'];	
			$get_user_detail=$this->Seedsadmin->get_user_detail($value['AddedBy']);
			$seedrecord['AddedBy'] = $get_user_detail['firstname'].''.$get_user_detail['lastname'];	

			$seedsrecords[] = $seedrecord;
		}
   		
		$data["seedsrecords"] = $seedsrecords;

        $data["links"] = $this->pagination->create_links();
      
		$this->load->view('seedrecord',$data);
	}

	public function seedview(){
		$validateLogin = $this->validateLogin('seeds','seededit');
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


		$Status = array();
		$Status[] = 'New Sample';
		$Status[] = 'Re-check 1';
		$Status[] = 'Re-check 2';
		$Status[] = 'Re-check 3';
		$Status[] = 'Pre-commercial';
		$Status[] = 'Commercial or control variety';
		$Status[] = 'Drop';

		$stockedit = true;

		if($SeedID){
			$get_seed = $this->Seedsadmin->get_seed($SeedID);
			$data['get_seed_images'] = $this->Seedsadmin->get_seed_images($SeedID);
			$get_sampling_count = $this->Seedsadmin->get_sampling_count($SeedID);
			if($get_sampling_count>1){
				$stockedit = false;
			}
		}else{
		}


		$data['heading_title']='View Seed';
		$data['stockedit']=$stockedit;		
		
		$Stockquantityfor = array();
		$Stockquantityfor[] = 'Gram';
		$Stockquantityfor[] = 'Kg';
		$Stockquantityfor[] = 'Seed';


		$data["crops"] = $this->Seedsadmin->get_crops();
		$data["suppliers"] = $this->Seedsadmin->get_suppliers();
		
		$data['error']=$error;
		$data['active']='seeds';
		$data['submenuactive']='seededit';
		$data['get_seed']= $get_seed;
		$data['Status']= $Status;
		$data['Stockquantityfor']= $Stockquantityfor;
		$data['baseurl']= base_url();
		$this->load->view('seedview',$data);
	}

	public function seedsummary(){
		$validateLogin = $this->validateLogin('seeds','seededit');
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

		$Status = array();
		// $Status[] = '-- Select Status --';
		$Status[] = 'New Sample';
		$Status[] = 'Re-check 1';
		$Status[] = 'Re-check 2';
		$Status[] = 'Re-check 3';
		$Status[] = 'Pre-commercial';
		$Status[] = 'Commercial or control variety';
		$Status[] = 'Drop';
	
		$get_seeds = $this->Seedsadmin->get_seed_summary($SeedID);

		$get_samplings = $this->Seedsadmin->get_sampling($SeedID);
		$samplings = array();
		foreach ($get_samplings as $get_sampling) {
		
			$sampling = array();
			$sampling['Internalsamplingcode'] = $get_sampling['Internalsamplingcode'];
			$sampling['Location'] = $get_sampling['Location'];
			$get_trail = $this->Seedsadmin->get_trail($get_sampling['Internalsamplingcode']);
			$get_evaluation = $this->Seedsadmin->get_evaluation($get_sampling['Internalsamplingcode']);


			$get_trail_counts = $this->Seedsadmin->get_trail_counts($get_sampling['Internalsamplingcode']);
			$get_evaluation_counts = $this->Seedsadmin->get_evaluation_counts($get_sampling['Internalsamplingcode']);
			$sampling['trailcount'] = $get_trail_counts;
			$sampling['evaluationcount'] = $get_evaluation_counts;
			
			$get_seed = $this->Seedsadmin->get_seed($get_sampling['Seed']);
			$sampling['SeedVariety'] = $get_seed['Variety'];

			$get_supplier = $this->Seedsadmin->get_supplier($get_seed['Supplier']);
			$sampling['SupplierName'] = $get_supplier['Name'];

			$get_crop = $this->Seedsadmin->get_crop($get_sampling['Crop']);
			$sampling['CropTitle'] = $get_crop['Title'];
			$sampling['Status'] = $Status[$get_seed['Status']];
			
			$get_close = $this->Seedsadmin->get_close($get_sampling['Internalsamplingcode']);
			$sampling['get_close'] = $get_close;
			foreach ($get_evaluation as  $value) {
				$sampling['EvaluationStatus'] = $value['Status'];
				$sampling['EvaluationID'] = $value['EvaluationID'];	
			}	

			$samplings[] = $sampling;
		}

		$data['heading_title']='Seed Summary';
		$data["crops"] = $this->Seedsadmin->get_crops();
		$data["suppliers"] = $this->Seedsadmin->get_suppliers();
		
		$data['error']=$error;
		$data['active']='seeds';
		$data['submenuactive']='seeds';
		$data['sampling']= $samplings;
		$data['get_seed']= $get_seed;
		$data['baseurl']= base_url();
		$this->load->view('seedsummary',$data);
	}

	public function seed_images_edit(){
		
		if (($this->input->server('REQUEST_METHOD') == 'POST')){
			$datapost=array();          
			$datapost['SeedID'] = $this->input->post('SeedID',true);
			if(@$_FILES["SeedPicture"]["name"] != ''){	
	        	$config['upload_path']   = 'uploads/SeedPictures';
	            $config['allowed_types'] = 'jpg|png|doc|pdf';
	            //$config['max_size'] = '3072';
	            $config['file_name'] = time()."".rand(1,1000)."_".trim(preg_replace('/\s+/', ' ', $_FILES['SeedPicture']['name']));

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if($this->upload->do_upload('SeedPicture')){
	                $uploadData = $this->upload->data();
	                //$this->resizeImage($uploadData['file_name']);       
	                $image = $uploadData['file_name'];
				}else{
	        		$image = '';
	        	}
	        }elseif ($this->input->post('GetSeedPicture',true)!='') {
	        	$image = $this->input->post('GetSeedPicture',true);
	        }else{
	        	$image = '';
	        }
	        $datapost['SeedImage'] = $image;
	        $SeedID = $this->Seedsadmin->insert_seeds_images($datapost);
	        $this->session->set_flashdata('success', 'Image upload successfully.');
	        if($SeedID){
	        	echo '1';
	        }else{
	        	echo '0';
	        }
		}
		//$data['heading_title']='Add Product';
		//$this->load->view('productslist',$data);
	}

	public function checkvariety(){
		$this->validateLogin('seeds','seededit');
		$result = $this->Seedsadmin->checkvariety($this->input->post());
		$Variety = $this->input->post('Variety',true);
		$SeedID = $this->input->post('SeedID',true);

		$Status = array();
		$Status[] = 'New Sample';
		$Status[] = 'Re-check 1';
		$Status[] = 'Re-check 2';
		$Status[] = 'Re-check 3';
		$Status[] = 'Pre-commercial';
		$Status[] = 'Commercial or control variety';
		$Status[] = 'Drop';

		$Status_Text = 'This is new Variety';
		if(count($result)>0){
			$data_arr = array();
			foreach ($result as $value) {
				if($value['SeedID']!=$SeedID){
					$data_arr[$value['Status']] = $value['Status'];
				}
			}
			$StatusText = '';
			foreach ($data_arr as $value) {
				$StatusText .= $Status[$value].',';
			}
			$StatusText = trim($StatusText,",");
			if($StatusText!=''){
				$Status_Text = $Variety.' Variety already exists with '.$StatusText.' status';
			}
		}
		echo $Status_Text; die;
	}	

	public function deleteseed_old(){
		$validateLogin = $this->validateLogin('seeds');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$SeedID = $this->uri->segment(3);
		if($SeedID){
			$getseed = $this->Seedsadmin->get_seed($SeedID);
			
			$this->Seedsadmin->deleteseed($SeedID,$data['userrole']);
			$this->session->set_flashdata('success', 'Seed been Deleted successfully.');
			
			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');

			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Seed Delete Variety: '.$getseed['Variety'];
			$datalog['Data'] = json_encode($getseed);

			$this->Seedsadmin->insert_log($datalog);

		}
		redirect('admin/seeds');
		exit();
	}

	public function deleteseed(){
		$validateLogin = $this->validateLogin('seeds');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$SeedID = $_POST['DeleteID'];
		if($SeedID){
			$getseed = $this->Seedsadmin->get_seed($SeedID);
			
			$this->Seedsadmin->deleteseed($SeedID,$data['userrole']);
			$this->session->set_flashdata('success', 'Seed been Deleted successfully.');
			
			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');

			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Seed Delete Variety: '.$getseed['Variety'];
			$datalog['Data'] = json_encode($getseed);

			$this->Seedsadmin->insert_log($datalog);

		}
	}

	public function restoreseed(){
		$validateLogin = $this->validateLogin('seeds');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$SeedID = $this->uri->segment(3);
		if($SeedID){
			$getseed = $this->Seedsadmin->get_seed($SeedID);
			
			$datapost = array();
			$datapost['is_deleted'] = '0';

			$this->Seedsadmin->update_seed($datapost,$SeedID);
			$this->session->set_flashdata('success', 'Seed been Restore successfully.');
			
			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');

			$datalog['Activity'] = 'Restore';
			$datalog['Title'] = 'Seed Restore variety: '.$getseed['Variety'];
			$datalog['Data'] = json_encode($getseed);

			$this->Seedsadmin->insert_log($datalog);

		}
		redirect('admin/seeds');
		exit();
	}

	public function resizeImage($filename){
      $source_path = UPLOADROOT . 'Seeds/' . $filename;
      $target_path = UPLOADROOT . 'Seeds/thumbnail/';
      $config_manip = array(
          'image_library' => 'gd2',
          'source_image' => $source_path,
          'new_image' => $target_path,
          'maintain_ratio' => TRUE,
          'create_thumb' => TRUE,
          'thumb_marker' => '',
          'width' => 280,
          'height' => 280
      );

      $this->load->library('image_lib', $config_manip);
      $this->image_lib->initialize($config_manip);
      if (!$this->image_lib->resize()) {
          echo $this->image_lib->display_errors();
      }
      $this->image_lib->clear();
   	}


   	public function stocks(){
		$validateLogin = $this->validateLogin('seeds','list');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$data['heading_title']='Stock management';
		$data['active']='seeds';
		$data['submenuactive']='stocks';
		
		$Crop = $this->input->get('Crop');
   		$Variety = $this->input->get('Variety');
   		$Supplier = $this->input->get('Supplier');
   		
   		if ($Crop || $Variety || $Supplier){
   			$total_rows = $this->Seedsadmin->filter_seeds_num_row($data['userrole'],$Crop,$Supplier,$Variety);
   		}else{
   			$total_rows = $this->Seedsadmin->get_seeds_count($data['userrole']);
   		}

		$config = array();
		if ($Crop || $Variety || $Supplier) $config['suffix'] = '?' . http_build_query($_GET, '', "&");

		$config['base_url'] = base_url() .'admin/stocks/';
		$config['use_page_numbers'] = false;
        $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
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
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['result_count']= "Showing ".$start." - ".$end." of ".$config['total_rows']." Results";

		$this->pagination->initialize($config);

		$Stockquantityfor = array();
		$Stockquantityfor[] = 'Gram';
		$Stockquantityfor[] = 'Kg';
		$Stockquantityfor[] = 'Seed';

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$limit = $config['per_page'];

		if ($Crop || $Supplier || $Variety){
   			$get_seeds = $this->Seedsadmin->get_filter_seeds($data['userrole'],$Crop,$Supplier,$Variety,$limit, $offset);
   		}else{
			$get_seeds = $this->Seedsadmin->get_seeds($config["per_page"], $page,$data['userrole']);
		}
		$seeds = array();
		foreach ($get_seeds as  $get_seed) {
			$seed = array();
			$get_crop = $this->Seedsadmin->get_crop($get_seed['Crop']);
			$get_supplier = $this->Seedsadmin->get_supplier($get_seed['Supplier']);

			$seed['SeedID'] = $get_seed['SeedID'];
			$seed['Crop'] = $get_crop['Title'];
			$seed['Supplier'] = $get_supplier['Name'];
			$seed['Variety'] = $get_seed['Variety'];
			$seed['Stockquantityfor'] = $Stockquantityfor[$get_seed['Stockquantityfor']];
			/*$seed['Stockquantity'] = $get_seed['Stockquantity'];*/

			
			$get_samplingstock_count = $this->Seedsadmin->get_samplingstock_count($get_seed['SeedID']);

			$count = $get_samplingstock_count['count'];
			$cnt = $get_samplingstock_count['cnt'];
			$htmlSamplingstock = '';

			$htmlStockquantity = '';

			if($get_seed['Stockquantityfor']=='2'){
				$htmlSamplingstock = $count.' Seeds';

				$count_seed = $get_seed['Stockquantity'];
				$Available_seed = $count_seed-$count;
				$Availableseed = 0;
				if($Available_seed>0){
					$Availableseed =  $Available_seed;
				}
				//$htmlStockquantity = $Availableseed.' Seeds';
				$htmlStockquantity = $get_seed['Stockquantity'].' Seeds';

			}elseif($get_seed['Stockquantityfor']=='1'){
				$count1 = $count/1000;
				$htmlSamplingstock = $count1.' Kg';	

				$htmlStockquantity = $get_seed['Stockquantity'].' Kg';
				
			}else{
				$htmlSamplingstock = $count.' Gram';

				$count_seed = $get_seed['Stockquantity'];
				$Available_seed = $count_seed-$count;
				$Availableseed = 0;
				if($Available_seed>0){
					$Availableseed =  $Available_seed;
				}
				$htmlStockquantity = $get_seed['Stockquantity'].' Gram';

			}

			$seed['Stockquantity'] = $htmlStockquantity;

			$seed['Samplingstock'] = $htmlSamplingstock;
			$seed['NoofSampling'] = $cnt;

			$seeds[] = $seed;
		}
		$data["seeds"] = $seeds;
        $data["links"] = $this->pagination->create_links();
        $get_seeds_all = $this->Seedsadmin->get_seeds_all();
     
        $seeds_all = array();
		foreach ($get_seeds_all as  $get_seed_all) {
			$seed_all = array();
			$get_crop = $this->Seedsadmin->get_crop($get_seed_all['Crop']);

			$seed_all['SeedID'] = $get_seed_all['SeedID'];
			$seed_all['Crop'] = $get_crop['Title'];
			$seeds_all[] = $seed_all;
		}
		$data["seeds_all"] = $seeds_all;
		

		if($Crop!='' || $Supplier!=''){
        	$all_seeds = $this->Seedsadmin->get_filter_variety_seeds($Crop,$Supplier);
    	}else{
			$all_seeds = $this->Seedsadmin->get_seeds_all();
		}
		$allseeds = array();
		foreach ($all_seeds as  $value) {
			$allseeds[] = $value['Variety'];
		}
		asort($allseeds);
		$data["allseeds"] = $allseeds;

		$get_crops = $this->Seedsadmin->get_crops();
		$crops = array();
		foreach ($get_crops as $value) {
			$crops[$value['CropID']] = $value['Title'];
		}
		asort($crops);

		$get_suppliers = $this->Seedsadmin->get_suppliers();
		$suppliers = array();
		foreach ($get_suppliers as $value) {
			$suppliers[$value['SupplierID']] = $value['Name'];
		}
		asort($suppliers);

		$data["crops"] = $crops;
		$data["suppliers"] = $suppliers;
		$this->load->view('stocks',$data);
	}
	public function getstock(){
		$validateLogin = $this->validateLogin('seeds','list');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$Stockquantityfor = array();
		$Stockquantityfor[] = 'Gram';
		$Stockquantityfor[] = 'Kg';
		$Stockquantityfor[] = 'Seed';

		$SeedID = $this->input->post('SeedID',true);
		$get_seed = $this->Seedsadmin->get_seed($SeedID);
		$html 	= '';
		$html 	.= '<div class="col-md-3"><div class="form-group" 
					id="InputStockquantityfor">
                    <label for="" class="required">Stock quantity for</label>
                      <br>';
                      	foreach ($Stockquantityfor as $key => $value){ 
                          if($get_seed['Stockquantityfor']==$key){
                            $checked = 'checked="checked"';
                          }else{
                            $checked = '';
                          }
        $html 	.=        '<input type="radio" 
        					class="formcontrol" id="Stockquantityfor'.$key.'" name="Stockquantityfor" value="'.$key.'" '.$checked.'>
                      			<label for="Stockquantityfor'.$key.'">'.$value.'</label>';
                      	} 
        $html 	.=  '</div> 
                    <div class="form-group" id="InputStockquantity">
                      	<label for="" class="required">Stock quantity</label>
                      <input type="text" class="form-control" id="Stockquantity" name="Stockquantity" placeholder="Stock quantity" value="'.$get_seed['Stockquantity'].'">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    </div>';
		echo $html; 
		die;
	}

	public function updateseed(){
		$validateLogin = $this->validateLogin('seeds','list');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$SeedID = $this->input->post('SeedID',true);
		$Stockquantity = $this->input->post('Stockquantity',true);
		$Stockquantityfor = $this->input->post('Stockquantityfor',true);


		$getseed = $this->Seedsadmin->get_seed($SeedID);
		$get_crop = $this->Seedsadmin->get_crop($getseed['Crop']);

		$datalog = array();
	    $datalog['UserID'] = $this->session->userdata('UserID');
	    $datalog['Activity'] = 'Update';
		$datalog['Title'] = 'Stock Update Crop: '.$get_crop['Title'];
		$datalog['Data'] = json_encode($getseed);
		$this->Seedsadmin->insert_log($datalog);

		$datapost = array();
		$datapost['Stockquantity'] = $Stockquantity;
		$datapost['Stockquantityfor'] = $Stockquantityfor;
		$this->Seedsadmin->update_seed($datapost,$SeedID);
	}

	function seedsexport(){
		$validateLogin = $this->validateLogin('seeds','list');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$Crop = $this->input->get('Crop');
   		$Variety = $this->input->get('Variety');
   		$Supplier = $this->input->get('Supplier');
   		$getStatus = $this->input->get('Status');
   		$FromDate = $this->input->get('FromDate');
   		$ToDate = $this->input->get('ToDate');

   		if($Crop!='' || $Variety!='' || $Supplier!='' || $getStatus!='' || $FromDate!='' || $ToDate!=''){
			$get_seeds_export = $this->Seedsadmin->get_seeds_export($data['userrole'],$Crop,$Variety,$Supplier,$getStatus,$FromDate,$ToDate);
		}else{
			$get_seeds_export = $this->Seedsadmin->get_seeds_export($data['userrole']);
		}	

		$Status = array();
		$Status[] = 'New Sample';
		$Status[] = 'Re-check 1';
		$Status[] = 'Re-check 2';
		$Status[] = 'Re-check 3';
		$Status[] = 'Pre-commercial';
		$Status[] = 'Commercial or control variety';
		$Status[] = 'Drop';

		$Stockquantityfor = array();
		$Stockquantityfor[] = 'Gram';
		$Stockquantityfor[] = 'Kg';
		$Stockquantityfor[] = 'Seed';

		$seeds = array();
		foreach ($get_seeds_export as  $get_seed) {
			$seed = array();
			$get_crop = $this->Seedsadmin->get_crop($get_seed['Crop']);
			$get_supplier = $this->Seedsadmin->get_supplier($get_seed['Supplier']);
			$seed['Crop'] = $get_crop['Title'];
			$seed['Supplier'] = $get_supplier['Name'];
			$seed['Variety'] = $get_seed['Variety'];
			$seed['Dateofrecivedsampel'] = $get_seed['Dateofrecivedsampel'];
			$seed['Status'] = $Status[$get_seed['Status']];
			$seed['Stockquantityfor'] = $Stockquantityfor[$get_seed['Stockquantityfor']];
			$seed['Stockquantity'] = $get_seed['Stockquantity'];
			$seed['Note'] = $get_seed['Note'];
			$seed['TechnicalData'] = $get_seed['TechnicalData'];
			$seeds[] = $seed;
		}
        
		if(count($seeds)>0){
			$this->ExportFileSeeds($seeds);
		}
		redirect('admin/seeds');
		exit(); 
	}	

	function ExportFileSeeds($records){
		require_once dirname(__FILE__) . '/../../../../PHPExcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("SHIMI YAZD Co.")
							 ->setLastModifiedBy("SHIMI YAZD Co.")
							 ->setTitle("SeedsReport")
							 ->setSubject("SeedsReport")
							 ->setDescription("SeedsReport")
							 ->setKeywords("SeedsReport")
							 ->setCategory("SeedsReport");

		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0,1,'Crop')
            ->setCellValueByColumnAndRow(1,1,'Supplier')
            ->setCellValueByColumnAndRow(2,1,'Variety')
            ->setCellValueByColumnAndRow(3,1,'Date of recived sampel')
            ->setCellValueByColumnAndRow(4,1,'Status')
            ->setCellValueByColumnAndRow(5,1,'Stock quantity for')
            ->setCellValueByColumnAndRow(6,1,'Stock quantity')
            ->setCellValueByColumnAndRow(7,1,'Note');

        $row = 2;
		foreach($records as $rec) {
			$col = 0;   
		    foreach ($rec as $value) {  
        		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
        		$col++;  
    		}   
		    $row++;
		} 
		    
        $objPHPExcel->getActiveSheet()->setTitle('SeedsReport');
        $objPHPExcel->setActiveSheetIndex(0);
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8');
		header('Content-Disposition: attachment;filename="SeedsReport.csv"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		$objWriter->save('php://output');
		exit;				 
	}


	function stocksexport(){
		$validateLogin = $this->validateLogin('seeds','list');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$get_seeds_all = $this->Seedsadmin->get_seeds_all($data['userrole']);

		$seeds = array();
		foreach ($get_seeds_all as  $get_seed) {
			$seed = array();
			$get_crop = $this->Seedsadmin->get_crop($get_seed['Crop']);
			$get_supplier = $this->Seedsadmin->get_supplier($get_seed['Supplier']);
			$seed['Crop'] = $get_crop['Title'];
			$seed['Supplier'] = $get_supplier['Name'];
			$seed['Variety'] = $get_seed['Variety'];
			$seed['Stockquantity'] = $get_seed['Stockquantity'];

			$get_samplingstock_count = $this->Seedsadmin->get_samplingstock_count($get_seed['SeedID']);
			$count = $get_samplingstock_count['count'];
			$cnt = $get_samplingstock_count['cnt'];
			$htmlSamplingstock = '';
			if($get_seed['Stockquantity']=='2'){
				$htmlSamplingstock = $count.' Seeds';
			}elseif($get_seed['Stockquantity']=='1'){
				$count1 = $count/1000;
				$htmlSamplingstock = $count1.' Kg';	
			}else{
				$htmlSamplingstock = $count.' Gram';
			}

			$seed['Samplingstock'] = $htmlSamplingstock;
			$seed['NoofSampling'] = $cnt;

			$seeds[] = $seed;
		}
        
		if(count($seeds)>0){
			$this->ExportFileStocks($seeds);
		}
		redirect('admin/stocks');
		exit(); 
	}	

	function ExportFileStocks($records){
		require_once dirname(__FILE__) . '/../../../../PHPExcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("SHIMI YAZD Co.")
							 ->setLastModifiedBy("SHIMI YAZD Co.")
							 ->setTitle("StocksReport")
							 ->setSubject("StocksReport")
							 ->setDescription("StocksReport")
							 ->setKeywords("StocksReport")
							 ->setCategory("StocksReport");

		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0,1,'Crop')
            ->setCellValueByColumnAndRow(1,1,'Supplier')
            ->setCellValueByColumnAndRow(2,1,'Variety')
            ->setCellValueByColumnAndRow(3,1,'Available stock')
            ->setCellValueByColumnAndRow(4,1,'Total Sampling done')
            ->setCellValueByColumnAndRow(5,1,'No. of Sampling');

        $row = 2;
		foreach($records as $rec) {
			$col = 0;   
		    foreach ($rec as $value) {  
        		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
        		$col++;  
    		}   
		    $row++;
		} 
		    
        $objPHPExcel->getActiveSheet()->setTitle('StocksReport');
        $objPHPExcel->setActiveSheetIndex(0);
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8');
		header('Content-Disposition: attachment;filename="StocksReport.csv"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		$objWriter->save('php://output');
		exit;				 
	}

	private function validateLogin($module='',$type=''){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			redirect('admin/logout');
			exit();   
		}
		$get_user_detail=$this->Seedsadmin->get_user_detail($this->session->userdata('UserID'));
		$userrole= $get_user_detail['userrole'];
		$user_permission= $get_user_detail['userpermission'];
		if($user_permission!=''){
			$userpermission= json_decode($user_permission);
		}else{	
			$userpermission= array();
		}

		if($userrole!='1' AND $userrole!='2' AND $userrole!='3' AND $userrole!='4'){
			redirect('admin/logout');
			exit();  
		}elseif (!in_array($module, $userpermission) AND ($userrole=='2' || $userrole=='3')){
			redirect('admin/logout');
			exit();  
		}elseif ($type=='' AND ($userrole=='2' || $userrole=='3')){
			redirect('admin/logout');
			exit();  
		}
		$data['userpermission'] = $userpermission;
		$data['userrole'] = $userrole;
		return $data;
	} 

	public function summaryexport(){

		$validateLogin = $this->validateLogin('seeds','list');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];	


		$data['heading_title']='Seeds';
		$data['active']='seeds';
		$data['submenuactive']='seeds';
		$SeedID = @$_GET['SeedID'];

		$Status = array();
		// $Status[] = '-- Select Status --';
		$Status[] = 'New Sample';
		$Status[] = 'Re-check 1';
		$Status[] = 'Re-check 2';
		$Status[] = 'Re-check 3';
		$Status[] = 'Pre-commercial';
		$Status[] = 'Commercial or control variety';
		$Status[] = 'Drop';

		$date = date('d_m_y');

    		$get_seeds = $this->Seedsadmin->get_seed_summary($SeedID);

			$get_samplings = $this->Seedsadmin->get_sampling($SeedID);
			$samplings = array();
			foreach ($get_samplings as $get_sampling) {
			
				$sampling = array();
				$sampling['Internalsamplingcode'] = $get_sampling['Internalsamplingcode'];

				$get_trail = $this->Seedsadmin->get_trail($get_sampling['Internalsamplingcode']);
				$get_evaluation = $this->Seedsadmin->get_evaluation($get_sampling['Internalsamplingcode']);


				$get_trail_counts = $this->Seedsadmin->get_trail_counts($get_sampling['Internalsamplingcode']);
				$get_evaluation_counts = $this->Seedsadmin->get_evaluation_counts($get_sampling['Internalsamplingcode']);
				$sampling['trailcount'] = $get_trail_counts;
				$sampling['evaluationcount'] = $get_evaluation_counts;
				
				$get_seed = $this->Seedsadmin->get_seed($get_sampling['Seed']);
				
				$sampling['SeedVariety'] = $get_seed['Variety'];

				$get_supplier = $this->Seedsadmin->get_supplier($get_seed['Supplier']);
				$sampling['SupplierName'] = $get_supplier['Name'];

				$get_crop = $this->Seedsadmin->get_crop($get_sampling['Crop']);
				$sampling['CropTitle'] = $get_crop['Title'];
				$sampling['Status'] = $Status[$get_seed['Status']];
				
				$get_close = $this->Seedsadmin->get_close($get_sampling['Internalsamplingcode']);
				$sampling['get_close'] = $get_close;
				foreach ($get_evaluation as  $value) {
					$sampling['EvaluationStatus'] = $value['Status'];
					$sampling['EvaluationID'] = $value['EvaluationID'];	
				}	

				$samplings[] = $sampling;
			}
			$data = $samplings;
    
	    $htmlContent = "";
	    $htmlContent .= '<h2 style="color:orange;">Seeds Summary :</h2>';
	    $htmlContent .= '<table border="1" cellspacing="1" cellpadding="2">';
	    $htmlContent .= '<thead>
	            <tr style="background-color:#A3E316; color:white; font-weight: bold; text-align:center;">
	              <td style="font-size:12px;">Crop</td>
	              <td style="font-size:12px;">Variety</td>
	              <td style="font-size:12px;">Supplier Name</td> 	
	              <td style="font-size:12px;">Sampling </td>
	              <td style="font-size:12px;">Trail Count</td>
	              <td style="font-size:12px;">Evaluation Count</td>
	              <td style="font-size:12px;">Result</td>
	              <td style="font-size:12px;">Close Status</td>
	            </tr>
	          </thead>';
	    $htmlContent .= '<tbody>';
	          if(count($data) > 0) {
	            foreach ($data as $value) {
	        	    if($value['evaluationcount']==0){ 
	                   $evaluationcount = "No";
	                }elseif($value['evaluationcount']>=1) {
	                   $evaluationcount = "Yes";
	                }


	                // if($value['Status']=='Pre-commercial' || $value['Status']=='Commercial or control variety'){
	                //           $Status = $value['Status'];
	                // }elseif($value['evaluationcount']==0){
	                //   $Status = "No Status";
	                // }elseif($value['Status']=='New Sample' || $value['Status']=='Re-check 1' || $value['Status']=='Re-check 2' || $value['Status']=='Re-check 3' ||$value['Status']=='Drop'){
	                //   $Status = $value['EvaluationStatus'];
	                // }

	                if ($value['evaluationcount']!=0) {
		                if($value['EvaluationStatus']=='')
		                {
		                    if($value['Status']=='Pre-commercial' || $value['Status']=='Commercial or control variety'){
		                      $Status = $value['Status'];
		                    }
		                }
		                else{
		                  $Status = $value['EvaluationStatus'];  
		                }
		              }else{
		                $Status = "No Status";
		              }

	                if ($value['get_close']>=1) {
	                      $close = "Closed";
	                }else{
	                  $close = "Open";
	                }  

	    $htmlContent .= '<tr>
	    			<td style="font-size:12px;">'.$value['CropTitle'].'</td>
	                <td style="font-size:12px;">'.$value['SeedVariety'].'</td>
	                <td style="font-size:12px;">'.$value['SupplierName'].'</td>
	                <td style="font-size:12px;">'.$value['Internalsamplingcode'].'</td>
	                <td style="font-size:12px;">'.$value['trailcount'].'</td>
	                <td style="font-size:12px;">'.$evaluationcount.'</td>
	                <td style="font-size:12px;">'.$Status.'</td>
	                <td style="font-size:12px;">'.$close.'</td>
	              </tr>';
	              } }   
		    $htmlContent .= '</tbody>';
		    $htmlContent .= '</table>';

		    $this->load->library('Pdf');
		    $pdf = new Pdf('P', '2500', 'A3', true, 'UTF-8', false);
		    $pdf->SetTitle('Summary_'.$value['CropTitle'].'_'.$value['SeedVariety'].'_'.$date);
		    $pdf->SetHeaderMargin(7);
		    // $pdf->Setxy()
		    $pdf->SetTopMargin(7);
		    $pdf->setFooterMargin(7);
		    $pdf->SetAuthor('Author');
		    $pdf->SetDisplayMode('real', 'default');
		    $pdf->SetMargins(7, 7, 7);
		    $pdf->SetAutoPageBreak(TRUE, 7);

		    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		    $pdf->AddPage();

		    $pdf->writeHTML($htmlContent, true, 0, true, 0);
		    $pdf->Output('Summary_'.$value['CropTitle'].'_'.$value['SeedVariety'].'_'.$date.'.pdf', 'D');
	}
}