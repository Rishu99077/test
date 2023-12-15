<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Trial extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('Trialadmin','',TRUE);
		$this->load->library('session');
		$this->load->library('pagination');			
    } 

	public function index(){
		$validateLogin = $this->validateLogin('trial','list');
		$get_user_detail=$this->Trialadmin->get_user_detail($this->session->userdata('UserID'));
		$userrole= $get_user_detail['userrole'];
		if($userrole=='6'){
			redirect('admin');
			exit();
		} 
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];	
		$data['heading_title']='Trial';
		$data['active']='trial';
		$data['submenuactive']='trial';

		$Crop = $this->input->get('Crop');
		$Supplier = $this->input->get('Supplier');
		$Variety = $this->input->get('Variety');
		$Location = $this->input->get('Location');
		$Techncialteam  = $this->input->get('Techncialteam');
		$FromDate  = $this->input->get('FromDate');
		$ToDate  = $this->input->get('ToDate');

		$SowingFromDate = $this->input->get('SowingFromDate');
   		$SowingToDate = $this->input->get('SowingToDate');

   		$HarvestFromDate  = $this->input->get('HarvestFromDate');
        $HarvestToDate  = $this->input->get('HarvestToDate');

        $TransplantFromDate  = $this->input->get('TransplantFromDate');
        $TransplantToDate  = $this->input->get('TransplantToDate');

		$Internalsamplingcode  = $this->input->get('Internalsamplingcode');

		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $SowingFromDate || $SowingToDate || $HarvestFromDate || $HarvestToDate || $TransplantFromDate || $TransplantToDate || $Internalsamplingcode){
   			$total_rows = $this->Trialadmin->filter_get_trial_count($data['userrole'],$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$SowingFromDate,$SowingToDate,$HarvestFromDate,$HarvestToDate,$TransplantFromDate,$TransplantToDate,$Internalsamplingcode);
   		}else{
   			$total_rows = $this->Trialadmin->get_trial_count($data['userrole']);
   		}

		$config = array();
		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $SowingFromDate || $SowingToDate || $HarvestFromDate || $HarvestToDate || $TransplantFromDate || $TransplantToDate || $Internalsamplingcode) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		
		$config['base_url'] =base_url('admin/trial');
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
		$data['result_count']= "Showing ".$start." - ".$end." of ".$config['total_rows']." Results";

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $SowingFromDate || $SowingToDate || $HarvestFromDate || $HarvestToDate || $TransplantFromDate || $TransplantToDate || $Internalsamplingcode){
   			$get_trials = $this->Trialadmin->filter_get_trial($config["per_page"], $page,$data['userrole'],$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$SowingFromDate,$SowingToDate,$HarvestFromDate,$HarvestToDate,$TransplantFromDate,$TransplantToDate,$Internalsamplingcode);
   		}else{
			$get_trials = $this->Trialadmin->get_trial($config["per_page"], $page,$data['userrole']);

		}	

		$trials = array();
		foreach ($get_trials as $get_trial) {
			$trial = array();
			// $UserID = $get_trial['UserID'];
			$trial['TrialID'] = $get_trial['TrialID'];
			$trial['UserID'] = $get_trial['UserID'];
			$trial['Internalcode'] = $get_trial['Internalcode'];
			$trial['Date'] = $get_trial['Date'];
			$trial['is_deleted'] = $get_trial['is_deleted'];

			$trial['added_location'] = $get_trial['added_location'];
			$trial['latitude'] = $get_trial['latitude'];
			$trial['longitude'] = $get_trial['longitude'];

			if($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $SowingFromDate || $SowingToDate || $HarvestFromDate || $HarvestToDate || $TransplantFromDate || $TransplantToDate || $Internalsamplingcode) {
				$trial['trial_AddedDate'] = $get_trial['trial_AddedDate'];
				}	
			@$trial['AddedDate'] = $get_trial['AddedDate'];


			$get_users = $this->Trialadmin->get_users($get_trial['UserID']);
			$trial['Fullname'] = $get_users['firstname'].' '.$get_users['lastname'];

			$get_sampling = $this->Trialadmin->get_sampling($get_trial['Internalcode']);

			// echo "<pre>";
			// print_r($get_sampling);
			// echo "</pre>";

			$get_seed = $this->Trialadmin->get_seed($get_sampling['Seed']);
			$trial['SeedVariety'] = $get_seed['Variety'];

			$get_supplier = $this->Trialadmin->get_supplier($get_seed['Supplier']);
	
			$trial['SupplierName'] = $get_supplier['Name'];

			$trial['Location'] = $get_sampling['Location'];

			$get_crop = $this->Trialadmin->get_crop($get_sampling['Crop']);
			$trial['CropTitle'] = $get_crop['Title'];

			$trial['Dateofsowing'] = $get_sampling['Dateofsowing'];
			$trial['Dateoftransplanted'] = $get_sampling['Dateoftransplanted'];	
			$trial['Estimatedharvestingdate'] = $get_sampling['Estimatedharvestingdate'];
			$trials[] = $trial;
		}

		$get_crops = $this->Trialadmin->get_crops();
		$crops = array();
		foreach ($get_crops as $value) {
			$crops[$value['CropID']] = $value['Title'];
		}
		//asort($crops);

		$get_suppliers = $this->Trialadmin->get_suppliers();
		$suppliers = array();
		foreach ($get_suppliers as $value) {
			$suppliers[$value['SupplierID']] = $value['Name'];
		}
		//asort($suppliers);

		$get_seeds = $this->Trialadmin->get_seeds();
	    $seeds = array();
	    foreach($get_seeds as $get_seed){
	        $seeds[$get_seed['SeedID']]= $get_seed['Variety'];
	    }
	    asort($seeds);

	    $get_techncialteams = $this->Trialadmin->get_techncialteams();
	    $techncialteams = array();
	    foreach($get_techncialteams as $get_techncialteam){
	        $techncialteams[$get_techncialteam['TechncialteamID']]= $get_techncialteam['Name'];
	    }
	    //asort($techncialteams);

		$data["crops"] = $crops;
		$data["suppliers"] = $suppliers;
		$data["seeds"] = $seeds;
		$data["techncialteams"] = $techncialteams;

		$get_sampling_all = $this->Trialadmin->get_sampling_all_location();
        $locations = array();
        foreach ($get_sampling_all as  $location_value) {
        	$locations[$location_value['Location']] = $location_value['Location'];
        }
        //asort($locations);
        $data["locations"]=$locations;

		$data["trial"] = $trials;
        $data["links"] = $this->pagination->create_links();
		$this->load->view('trial',$data);
	}

	public function trialsummary(){

		$validateLogin = $this->validateLogin('trial','list');
		$get_user_detail=$this->Trialadmin->get_user_detail($this->session->userdata('UserID'));
		$userrole= $get_user_detail['userrole'];
		if($userrole=='6'){
			redirect('admin');
			exit();
		} 
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];	
		$data['heading_title']='Trial Summary';
		$data['active']='seeds';
		$data['submenuactive']='seeds';

		$Crop = $this->input->get('Crop');
		$Supplier = $this->input->get('Supplier');
		$Variety = $this->input->get('Variety');
		$Location = $this->input->get('Location');
		$Techncialteam  = $this->input->get('Techncialteam');
		$FromDate  = $this->input->get('FromDate');
		$ToDate  = $this->input->get('ToDate');
		$Internalsamplingcode  = $this->input->get('Internalsamplingcode');

		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $Internalsamplingcode){
   			$total_rows = $this->Trialadmin->filter_get_trialsummary_count($data['userrole'],$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode);
   		}else{
   			$total_rows = $this->Trialadmin->get_trial_count($data['userrole']);
   		}

		$config = array();
		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $Internalsamplingcode) $config['suffix'] = '?' . http_build_query($_GET, 'Internalsamplingcode', "&");
		
		$config['base_url'] =base_url('admin/trialsummary');
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
		$data['result_count']= "Showing ".$start." - ".$end." of ".$config['total_rows']." Results";

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $Internalsamplingcode){
   			$get_trials = $this->Trialadmin->filter_get_trialsummary($config["per_page"], $page,$data['userrole'],$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode);
   		}else{
			$get_trials = $this->Trialadmin->get_trial($config["per_page"], $page,$data['userrole']);
		}	

		$trials = array();
		foreach ($get_trials as $get_trial) {
			$trial = array();
			// $UserID = $get_trial['UserID'];
			$trial['TrialID'] = $get_trial['TrialID'];
			$trial['UserID'] = $get_trial['UserID'];
			$trial['Internalcode'] = $get_trial['Internalcode'];
			$trial['Date'] = $get_trial['Date'];
			$trial['is_deleted'] = $get_trial['is_deleted'];
			$trial['AddedDate'] = $get_trial['AddedDate'];
			@$trial['trial_AddedDate'] = $get_trial['trial_AddedDate'];


			$get_users = $this->Trialadmin->get_users($get_trial['UserID']);
			$trial['Fullname'] = $get_users['firstname'].' '.$get_users['lastname'];

			$get_sampling = $this->Trialadmin->get_sampling($get_trial['Internalcode']);

			// echo "<pre>";
			// print_r($get_sampling);
			// echo "</pre>";

			$get_Control = $this->Trialadmin->get_seed($get_sampling['Controlvariety']);
			$trial['Controlvariety'] = $get_Control['Variety'];

			$get_seed = $this->Trialadmin->get_seed($get_sampling['Seed']);
			$trial['SeedVariety'] = $get_seed['Variety'];

			$get_supplier = $this->Trialadmin->get_supplier($get_seed['Supplier']);
			$trial['SupplierName'] = $get_supplier['Name'];

			$trial['Location'] = $get_sampling['Location'];

			$get_crop = $this->Trialadmin->get_crop($get_sampling['Crop']);
			$trial['CropTitle'] = $get_crop['Title'];

			$trial['Dateofsowing'] = $get_sampling['Dateofsowing'];
			$trial['Dateoftransplanted'] = $get_sampling['Dateoftransplanted'];	
			$trial['Estimatedharvestingdate'] = $get_sampling['Estimatedharvestingdate'];
			$trials[] = $trial;
		}

		$get_crops = $this->Trialadmin->get_crops();
		$crops = array();
		foreach ($get_crops as $value) {
			$crops[$value['CropID']] = $value['Title'];
		}
		//asort($crops);

		$get_suppliers = $this->Trialadmin->get_suppliers();
		$suppliers = array();
		foreach ($get_suppliers as $value) {
			$suppliers[$value['SupplierID']] = $value['Name'];
		}
		//asort($suppliers);

		$get_seeds = $this->Trialadmin->get_seeds();
	    $seeds = array();
	    foreach($get_seeds as $get_seed){
	        $seeds[$get_seed['SeedID']]= $get_seed['Variety'];
	    }
	    asort($seeds);

	    $get_techncialteams = $this->Trialadmin->get_techncialteams();
	    $techncialteams = array();
	    foreach($get_techncialteams as $get_techncialteam){
	        $techncialteams[$get_techncialteam['TechncialteamID']]= $get_techncialteam['Name'];
	    }
	    //asort($techncialteams);

		$data["crops"] = $crops;
		$data["suppliers"] = $suppliers;
		$data["seeds"] = $seeds;
		$data["techncialteams"] = $techncialteams;

		$get_sampling_all = $this->Trialadmin->get_sampling_all_location();
        $locations = array();
        foreach ($get_sampling_all as  $location_value) {
        	$locations[$location_value['Location']] = $location_value['Location'];
        }
        //asort($locations);
        $data["locations"]=$locations;

		$data["trial"] = $trials;
        $data["links"] = $this->pagination->create_links();
		$this->load->view('trialsummary',$data);
	}

	public function viewtrial(){
		$validateLogin = $this->validateLogin('trial','list');
		$get_user_detail=$this->Trialadmin->get_user_detail($this->session->userdata('UserID'));
		$userrole= $get_user_detail['userrole'];
		if($userrole=='6'){
			redirect('admin');
			exit();
		} 
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];	
		$data['heading_title']='View Trial Close';
		$data['active']='evaluation';
		$data['submenuactive']='evaluationclose';

		$Crop = $this->input->get('Crop');
		$Supplier = $this->input->get('Supplier');
		$Variety = $this->input->get('Variety');
		$Location = $this->input->get('Location');
		$Techncialteam  = $this->input->get('Techncialteam');
		$FromDate  = $this->input->get('FromDate');
		$ToDate  = $this->input->get('ToDate');
		$Internalsamplingcode  = $this->input->get('Internalsamplingcode');

		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $Internalsamplingcode){
   			$total_rows = $this->Trialadmin->filter_get_viewtrial_count($data['userrole'],$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode);
   		}else{
   			$total_rows = $this->Trialadmin->get_viewtrial_count($data['userrole']);
   		}

		$config = array();
		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $Internalsamplingcode) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		
		$config['base_url'] =base_url('admin/trial');
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
		$data['result_count']= "Showing ".$start." - ".$end." of ".$config['total_rows']." Results";

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $Internalsamplingcode){
   			$get_trials = $this->Trialadmin->filter_get_viewtrial($config["per_page"], $page,$data['userrole'],$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode);
   		}else{
			$get_trials = $this->Trialadmin->get_viewtrial($config["per_page"], $page,$data['userrole']);
		}	

		$trials = array();
		foreach ($get_trials as $get_trial) {
			$trial = array();
			// $UserID = $get_trial['UserID'];
			$trial['TrialID'] = $get_trial['TrialID'];
			$trial['UserID'] = $get_trial['UserID'];
			$trial['Internalcode'] = $get_trial['Internalcode'];
			$trial['Date'] = $get_trial['Date'];
			$trial['is_deleted'] = $get_trial['is_deleted'];
			$trial['AddedDate'] = $get_trial['AddedDate'];
			@$trial['trial_AddedDate'] = $get_trial['trial_AddedDate'];


			$get_users = $this->Trialadmin->get_users($get_trial['UserID']);
			$trial['Fullname'] = $get_users['firstname'].' '.$get_users['lastname'];

			$get_sampling = $this->Trialadmin->get_sampling($get_trial['Internalcode']);

			// echo "<pre>";
			// print_r($get_sampling);
			// echo "</pre>";

			$get_seed = $this->Trialadmin->get_seed($get_sampling['Seed']);
			$trial['SeedVariety'] = $get_seed['Variety'];

			$get_supplier = $this->Trialadmin->get_supplier($get_seed['Supplier']);
	
			$trial['SupplierName'] = $get_supplier['Name'];

			$trial['Location'] = $get_sampling['Location'];

			$get_crop = $this->Trialadmin->get_crop($get_sampling['Crop']);
			$trial['CropTitle'] = $get_crop['Title'];

			$trial['Dateofsowing'] = $get_sampling['Dateofsowing'];
			$trial['Dateoftransplanted'] = $get_sampling['Dateoftransplanted'];	
			$trial['Estimatedharvestingdate'] = $get_sampling['Estimatedharvestingdate'];
			$trials[] = $trial;
		}

		$get_crops = $this->Trialadmin->get_crops();
		$crops = array();
		foreach ($get_crops as $value) {
			$crops[$value['CropID']] = $value['Title'];
		}
		//asort($crops);

		$get_suppliers = $this->Trialadmin->get_suppliers();
		$suppliers = array();
		foreach ($get_suppliers as $value) {
			$suppliers[$value['SupplierID']] = $value['Name'];
		}
		//asort($suppliers);

		$get_seeds = $this->Trialadmin->get_seeds();
	    $seeds = array();
	    foreach($get_seeds as $get_seed){
	        $seeds[$get_seed['SeedID']]= $get_seed['Variety'];
	    }
	    asort($seeds);

	    $get_techncialteams = $this->Trialadmin->get_techncialteams();
	    $techncialteams = array();
	    foreach($get_techncialteams as $get_techncialteam){
	        $techncialteams[$get_techncialteam['TechncialteamID']]= $get_techncialteam['Name'];
	    }
	    //asort($techncialteams);

		$data["crops"] = $crops;
		$data["suppliers"] = $suppliers;
		$data["seeds"] = $seeds;
		$data["techncialteams"] = $techncialteams;

		$get_sampling_all = $this->Trialadmin->get_sampling_all_location();
        $locations = array();
        foreach ($get_sampling_all as  $location_value) {
        	$locations[$location_value['Location']] = $location_value['Location'];
        }
        //asort($locations);
        $data["locations"]=$locations;

		$data["trial"] = $trials;
        $data["links"] = $this->pagination->create_links();
		$this->load->view('viewtrial',$data);
	}

	public function trialedit(){

		$TrialID = @$_GET['TrialID'];
		
		$validateLogin = $this->validateLogin('trial','trialedit');

		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$error = array();
		$error['Internalcode'] = '';
		$error['Date'] = '';
		$error['Description'] = '';
		$error['Pictures'] = '';	

		$get_single_trial =array();
		$get_single_trial['Internalcode'] = '';
		$get_single_trial['Date'] = '';
		$get_single_trial['Description'] = '';
		$get_single_trial['Pictures'] = '';
		$Pictures = array();
		if($TrialID){
			
			$get_single_trial = $this->Trialadmin->get_single_trial($TrialID);

			if(!empty($get_single_trial['Pictures'])){
				$jason = json_decode($get_single_trial['Pictures'],true);
				foreach ($jason as $value1) {
					$Picture = array();
					$Picture['url'] = base_url().'uploads/Trial/'.$value1['name'];
					$Picture['type'] = $value1['type'];
					if($value1['type']=='2'){
						$Picture_name_pathinfo =  pathinfo($value1['name']); 
                        $Picture_name = $Picture_name_pathinfo['filename'].'.jpg';
						$Picture['thumbnail'] = base_url().'uploads/Trial/thumbnail/'.$Picture_name;
					}else{
						$Picture['thumbnail'] = base_url().'uploads/Trial/thumbnail/'.$value1['name'];						
					}
					$Picture['name'] = $value1['name'];
					$Pictures[] = $Picture;
				}
			}
			$data['heading_title']='Edit Trial';
		}else{
			$data['heading_title']='Add Trial';
		}

		if (($this->input->server('REQUEST_METHOD') == 'POST')){
			$this ->load->library('form_validation');
			$this->form_validation->set_rules('Internalcode', 'Internal code', 'required|trim');
			$this->form_validation->set_rules('Date', 'Date', 'required|trim');
			if ($this->form_validation->run() == FALSE) {
				if(form_error('Internalcode')){
					$error['Internalcode']  =form_error('Internalcode');
				}
				if(form_error('Date')){
					$error['Date']  =form_error('Date');
				}
			}else{
				$datapost =array();			
				$datapost['Internalcode'] = $this->input->post('Internalcode',true);
				$datapost['Date'] = $this->input->post('Date',true);
				$datapost['Description'] = $this->input->post('Description',true);

				$upload_filename = array();
				if( $this->input->post('img_exits') != '' ){
                    $img_exits_array  = $this->input->post('img_exits');
                    foreach($img_exits_array as $img_exits_value){
                         $img_exits_value;
                         $upload_filename[] =$img_exits_value;
                    }
                }

				if(@$_FILES["files"]["name"] != ''){
                    $targetDir = "uploads/Trial/";
                    $allowTypes = array('jpg','png','jpeg','gif','mp4','mov');
                    $images_arr = array();
                    $date = date('d_m_Y');
                    foreach($_FILES['files']['name'] as $key=>$val){

                        $image_name = time()."_".$key."_".$date."_".$_FILES['files']['name'][$key];
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
                                
	                            $single_file = array();
	                            $single_file['name'] = $file_Name;
	                            if($fileType=='mp4' || $fileType=='mov'){
	                            	$single_file['type'] = 2;
	                            	$this->create_videothumbnail($file_Name);
	                            }else{
	                            	$single_file['type'] = 1;
	                            	$this->resizeImage($file_Name);	
	                            }
	                            $upload_filename[] = $single_file;
                            }
                        //}
                    }
                }

            
                $datapost['Pictures'] = json_encode($upload_filename);

                $datalog = array();
				$datalog['UserID'] = $this->session->userdata('UserID');
				if($TrialID){
					$getsingletrial = $this->Trialadmin->get_single_trial($TrialID);
					$this->Trialadmin->update_trial($datapost,$TrialID);
					$this->session->set_flashdata('success', 'Trial update successfully.');

					$datalog['Activity'] = 'Update';
					$datalog['Title'] = 'Trial Update Internal code: '.$this->input->post('Internalcode',true);
					$datalog['Data'] = json_encode($getsingletrial);

				}else{
					$datapost['UserID'] = $this->session->userdata('UserID');
					// development
					$get_users = $this->Trialadmin->get_users($datapost['UserID']);
					$datapost['userrole'] = $get_users['userrole'];
					$datapost['Source'] = 'ADMIN';
					
					$TrialID= $this->Trialadmin->insert_trial($datapost);
					$this->session->set_flashdata('success', 'Trial added successfully.');

					$datalog['Activity'] = 'Insert';
					$datalog['Title'] = 'Trial added Internal code: '.$this->input->post('Internalcode',true);
					$datalog['Data'] = json_encode($datapost);
				}
				$this->Trialadmin->insert_log($datalog);	
				redirect('admin/trial');
				exit();
			}

			$get_single_trial['Internalcode'] = $this->input->post('Internalcode',true);
			$get_single_trial['Date'] = $this->input->post('Date',true);
			$get_single_trial['Description'] = $this->input->post('Description',true);
		}


		$data['Pictures']= $Pictures;
		$data['error']=$error;
		$data['active']='trial';
		$data['submenuactive']='trialedit';
		$data['get_single_trial']= $get_single_trial;
		$this->load->view('trialedit',$data);
	}

	public function trialreport(){
		$validateLogin = $this->validateLogin('trial','trialedit');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];


		$Crops = array();
		$Crops['Broccoli']='broccoli';
		$Crops['Brussels']='brussels';
		$Crops['Sunflower']='sunflower';
		$Crops['Turnip']='turnip';
		$Crops['Bunching onion']='bunchingonion';
		$Crops['leaf vegetable']='leafvegetable';
		$Crops['Rootstock']='rootstock';
		$Crops['Pumpkin']='pumpkin';
		$Crops['Soybean']='soybean';
		$Crops['Spinach']='spinach';
		$Crops['Celery']='celery';
		$Crops['Corn']='corn';
		$Crops['Cabbage']='cabbage';
		$Crops['Carrot']='carrot';
		$Crops['Cauliflower']='cauliflower';
		$Crops['Cucumber']='cucumber';
		$Crops['Cucumber- Indoor']='cucumber';
		$Crops['Cucumber- Outdoor']='cucumber';
		$Crops['Tomato- Det.']='dettomato';
		$Crops['Tomato- Indet.']='indettomato';
		$Crops['Eggplant']='eggplant';
		$Crops['Lettuce']='lettuce';
		$Crops['Melon']='melon';
		$Crops['Onion']='onion';
		$Crops['Pepper']='pepper';
		$Crops['Squash']='squash';
		$Crops['Sweet Corn']='sweetcorn';
		$Crops['Watermelon']='watermelon';
		$Crops['Beans']='beans';
		$Crops['Beetroot']='beetroot';
		$Crops['Kohlrabi']='kohlrabi';
		$Crops['Pea']='pea';
		$Crops['Radish']='radish';
		$Crops['Chinese cabbage']='chinesecabbage';
		$Crops['Okra']='okra';

		$TrialID = @$_GET['TrialID'];		
		$get_single_trial = $this->Trialadmin->get_single_trial($TrialID);
		$AddDate = $get_single_trial['AddedDate'];
		$Internalcode = $get_single_trial['Internalcode']; 
		$get_sampling_count = $this->Trialadmin->get_sampling_count($Internalcode);
		$get_crop = $this->Trialadmin->get_crop($get_sampling_count[0]['Crop']);
		$getcropTitle = $get_crop['Title'];
		
		$cropview = '';
		if (array_key_exists($getcropTitle,$Crops)){
			$cropview = $Crops[$getcropTitle];
		}else{
			$cropview = 'common';
		}
		
		$trialreportcontent = $this->trialreportcontent($cropview,$get_single_trial,'1');		
		$editor1 = $trialreportcontent;

		$Pictures_1 = array();
		if(!empty($get_single_trial['Pictures'])){
           $getPictures = json_decode($get_single_trial['Pictures']);

           foreach ($getPictures as  $value) {
           		$Picture = array();
            	$Picture['url'] = base_url().'uploads/Trial/'.$value->name;
            	if($value->type=='2'){
            		$Picture_name_pathinfo =  pathinfo($value->name);
            		$Picture_name = $Picture_name_pathinfo['filename'].'.jpg';
					$Picture['thumbnail'] = base_url().'uploads/Trial/thumbnail/'.$Picture_name;
				}else{
					$Picture['thumbnail'] = base_url().'uploads/Trial/thumbnail/'.$value->name;
				}
            	$Pictures_1[] = $Picture;
            } 
		}

		$get_evaluation = $this->Trialadmin->get_evaluation($Internalcode);
		foreach ($get_evaluation as $value) {
			if(!empty($value['Pictures'])){
			$jason = json_decode($value['Pictures'],true);
				foreach ($jason as $value1) {
					$Picture = array();
					$Picture['url'] = base_url().'uploads/Evaluation/'.$value1['name'];
					if($value1['type']=='2'){
						$Picture_name_pathinfo =  pathinfo($value1['name']);
	            		$Picture_name = $Picture_name_pathinfo['filename'].'.jpg';
						$Picture['thumbnail'] = base_url().'uploads/Evaluation/thumbnail/'.$Picture_name;
					}else{
						$Picture['thumbnail'] = base_url().'uploads/Evaluation/thumbnail/'.$value1['name'];
					}
					$Pictures_1[] = $Picture;
				}
			}
		}

		$data['heading_title']='Generate Report';

		$data['active']='trial';
		$data['submenuactive']='';
		$data['AddDate'] = $AddDate;
		$data['Pictures_1']= $Pictures_1;
		// $data['Pictures_2']= $Pictures_2;
		$data['editor1']= $editor1;
		// $data['editor2']= $editor2;
		$this->load->view('trialreport',$data);
	}
	
	public function trialreportcontent($cropview,$data,$editer='1'){
		$TrialID = @$_GET['TrialID'];		
		$get_single_trial = $this->Trialadmin->get_single_trial($TrialID);
		$get_sampling = $this->Trialadmin->get_sampling($get_single_trial['Internalcode']);

		$data['Internalcode'] = $get_single_trial['Internalcode'];
		$get_users = $this->Trialadmin->get_users($get_single_trial['UserID']);
		$data['Fullname'] = $get_users['firstname'].' '.$get_users['lastname'];
		$userrole = $get_users['userrole'];

		$get_date = $get_single_trial['AddedDate'];
		if($get_date){
			$data['AddedDate'] = $get_date;
		}
		$get_description = $get_single_trial['Description'];
		if($get_description){
			$data['Description'] = $get_description;
		}
		$get_seed = $this->Trialadmin->get_seed($get_sampling['Seed']);
		if($get_seed){
			$data['Varity'] = $get_seed['Variety'];
		}
		$get_crop = $this->Trialadmin->get_crop($get_sampling['Crop']);
		if($get_crop){
			$data['Crop'] = $get_crop['Title'];
		}
		$get_Control = $this->Trialadmin->get_seed($get_sampling['Controlvariety']);
		if($get_Control){
			$data['Controlvariety'] = $get_Control['Variety'];
		}
		$get_supplier = $this->Trialadmin->get_supplier($get_sampling['SupplierID']);
		if($get_supplier){
			$data['Supplier'] = $get_supplier['Name'];
		}
		
		$data['Location'] = $get_sampling['Location'];	
		$data['Dateofsowing'] = $get_sampling['Dateofsowing'];
		$data['Dateoftransplanted'] = $get_sampling['Dateoftransplanted'];
		$data['Estimatedharvestingdate'] = $get_sampling['Estimatedharvestingdate'];

		if(@$data['Dateofsowing'] != ''){
         $Dateofsowing = $data['Dateofsowing'];  
         /*$exdate = explode("/",$date); 
         @$newDate = $exdate[2].'-'.$exdate[1].'-'.$exdate[0];*/
         $NewDateofsowing   =   date("d-F-Y", strtotime($Dateofsowing));
        }else{
         $NewDateofsowing = '';
        }

        if(@$data['Dateoftransplanted'] != ''){
        $Dateoftransplanted = $data['Dateoftransplanted'];  
		 /*$exdate = explode("/",$date); 
         @$newDate = $exdate[2].'-'.$exdate[1].'-'.$exdate[0];*/
         $NewDateoftransplanted   =   date("d-F-Y", strtotime($Dateoftransplanted));
        }else{
         $NewDateoftransplanted = '';
        }

        if(@$data['Estimatedharvestingdate'] != ''){
        $Estimatedharvestingdate = $data['Estimatedharvestingdate'];  
         /*$exdate = explode("/",$date); 
         @$newDate = $exdate[2].'-'.$exdate[1].'-'.$exdate[0];*/
         $NewEstimatedharvestingdate   =   date("d-F-Y", strtotime($Estimatedharvestingdate));
        }else{
         $NewEstimatedharvestingdate = '';
        }

		// $Internalsamplecodecontrolvariety = $get_single_trial['Internalsamplecodecontrolvariety'];
		
		$editor = '';
		if($cropview=='broccoli'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Broccoli : </b>'.$data['Dateofvisit'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.$evaluation['Varity'].'</p>';
			$editor .= '<p><b>Control Variety Name : </b>'.@$evaluation['Controlvariety'].'-'.@$evaluation['Supplier'].'</p>';
			$editor .= '<p><b>Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Maturity : </b>'.$data['Maturity'].'</p>';
			
			$editor .= '<p><b>Plant frame size : </b>'.$data['Plantframesize'].'</p>';
            $editor .= '<p><b>Stem thickness : </b>'.$data['Stemthickness'].'</p>';
            $editor .= '<p><b>Head  weight (gr) : </b>'.$data['Headweight'].'</p>';
            $editor .= '<p><b>Curd color : </b>'.$data['Curdcolor'].'</p>';
            $editor .= '<p><b>Head  shape : </b>'.$data['Headshape'].'</p>';
            $editor .= '<p><b>Bead size : </b>'.$data['Beadsize'].'</p>';
            $editor .= '<p><b>Head Uniformity  : </b>'.$data['Headuniformity'].'</p>';
            $editor .= '<p><b>Firmness : </b>'.$data['Firmness_broccoli'].'</p>';
            $editor .= '<p><b>Side shoots : </b>'.$data['Sideshoots'].'</p>';
            $editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
            $editor .= '<p><b>Heat resit./tol. : </b>'.$data['Heatresittol'].'</p>';
            $editor .= '<p><b>Cold resist./tol. : </b>'.$data['Coldresisttol'].'</p>';

			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$data['ByWhen'].'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}else{
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Internal Code : </b>'.$data['Internalcode'].'</p>';
			$editor .= '<p><b>Supplier Name : </b>'.$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';			
			$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
			$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
			$editor .= '<p><b>Date of Sowing : </b>'.@$NewDateofsowing.'</p>';
			$editor .= '<p><b>Date of Transplanted : </b>'.@$NewDateoftransplanted.'</p>';
			$editor .= '<p><b>Date of Harvesting : </b>'.@$NewEstimatedharvestingdate.'</p>';
			$editor .= '<p><b>Description : </b>'.$data['Description'].'</p>';

		}	
		return $editor;
	}

	public function trialview(){

		$TrialID = @$_GET['TrialID'];
		
		$validateLogin = $this->validateLogin('trial','trialedit');

		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$error = array();
		$error['Internalcode'] = '';
		$error['Date'] = '';
		$error['Description'] = '';
		$error['Pictures'] = '';
	

		$get_single_trial =array();
		$get_single_trial['Internalcode'] = '';
		$get_single_trial['Date'] = '';
		$get_single_trial['Description'] = '';
		$get_single_trial['Pictures'] = '';
		$get_single_trial['AddedDate'] = '';

		$get_single_trial = $this->Trialadmin->get_single_trial($TrialID);
		// echo "<pre>";
		// print_r($get_single_trial);
		// echo "</pre>";
		$get_users = $this->Trialadmin->get_users($get_single_trial['UserID']);
		$get_single_trial['Fullname'] = $get_users['firstname'].' '.$get_users['lastname'];

		$get_sampling = $this->Trialadmin->get_sampling($get_single_trial['Internalcode']);


		$get_seed = $this->Trialadmin->get_seed($get_sampling['Seed']);
		$get_single_trial['SeedVariety'] = $get_seed['Variety'];

		$get_supplier = $this->Trialadmin->get_supplier($get_seed['Supplier']);

		$get_single_trial['SupplierName'] = $get_supplier['Name'];

		$get_single_trial['Location'] = $get_sampling['Location'];

		$get_crop = $this->Trialadmin->get_crop($get_sampling['Crop']);
		$get_single_trial['CropTitle'] = $get_crop['Title'];

		$get_single_trial['Dateofsowing'] = $get_sampling['Dateofsowing'];
		$get_single_trial['Dateoftransplanted'] = $get_sampling['Dateoftransplanted'];
		$get_single_trial['Estimatedharvestingdate'] = $get_sampling['Estimatedharvestingdate'];
		$Pictures = array();
		
		
		if(!empty($get_single_trial['Pictures'])){
		$jason = json_decode($get_single_trial['Pictures'],true);
			foreach ($jason as $value1) {
				$Picture = array();
				$Picture['url'] = base_url().'uploads/Trial/'.$value1['name'];
				$Picture['type'] = $value1['type'];
				if($value1['type']=='2'){
					$Picture_name_pathinfo =  pathinfo($value1['name']); 
                    $Picture_name = $Picture_name_pathinfo['filename'].'.jpg';
					$Picture['thumbnail'] = base_url().'uploads/Trial/thumbnail/'.$Picture_name;
				}else{
					$Picture['thumbnail'] = base_url().'uploads/Trial/thumbnail/'.$value1['name'];
				}
				$Pictures[] = $Picture;
			}
		}

		$data['heading_title']='View Trial';
		$data['error']=$error;
		$data['active']='trial';
		$data['submenuactive']='trialedit';
		$data['get_single_trial']= $get_single_trial;
		$data['Pictures']= $Pictures;
		$this->load->view('trialview',$data);
	}

	public function triallocation(){

		$TrialID = @$_GET['TrialID'];
		
		$validateLogin = $this->validateLogin('trial','trialedit');

		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$error = array();
		$error['Internalcode'] = '';
		$error['Date'] = '';
		$error['Description'] = '';
		$error['Pictures'] = '';
	

		$get_single_trial =array();
		$get_single_trial['Internalcode'] = '';
		$get_single_trial['Date'] = '';
		$get_single_trial['Description'] = '';
		$get_single_trial['Pictures'] = '';
		$get_single_trial['AddedDate'] = '';

		$get_single_trial = $this->Trialadmin->get_single_trial($TrialID);
		
		$get_single_trial['added_location'];
		$get_single_trial['latitude'];
		$get_single_trial['longitude'];
		
		$data['heading_title']='View Trial Location';
		$data['error']=$error;
		$data['active']='trial';
		$data['submenuactive']='trialview';
		$data['get_single_trial']= $get_single_trial;
		$this->load->view('triallocation',$data);
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


	public function deletetrial_old(){
		$validateLogin = $this->validateLogin('trial');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$TrialID = $this->uri->segment(3);
		if($TrialID){
			$getsingletrial = $this->Trialadmin->get_single_trial($TrialID);

			$this->Trialadmin->deletetrial($TrialID,$data['userrole']);
			$this->session->set_flashdata('success', 'Trial been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');

			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Trial Delete Internal code: '.$getsingletrial['Internalcode'];
			$datalog['Data'] = json_encode($getsingletrial);

			$this->Trialadmin->insert_log($datalog);

		}
		redirect('admin/trial');
		exit();
	}

	public function deletetrial(){
		$validateLogin = $this->validateLogin('trial');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$TrialID = $_POST['DeleteID'];
		if($TrialID){
			$getsingletrial = $this->Trialadmin->get_single_trial($TrialID);

			$this->Trialadmin->deletetrial($TrialID,$data['userrole']);
			$this->session->set_flashdata('success', 'Trial been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');

			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Trial Delete Internal code: '.$getsingletrial['Internalcode'];
			$datalog['Data'] = json_encode($getsingletrial);

			$this->Trialadmin->insert_log($datalog);

		}
	}

	public function restoretrial(){
		$validateLogin = $this->validateLogin('trial');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$TrialID = $this->uri->segment(3);
		if($TrialID){
			$getsingletrial = $this->Trialadmin->get_single_trial($TrialID);

			$datapost = array();
			$datapost['is_deleted'] = '0';

			$this->Trialadmin->update_trial($datapost,$TrialID);
			
			$this->session->set_flashdata('success', 'Trial been Restore successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');

			$datalog['Activity'] = 'Restore';
			$datalog['Title'] = 'Trial Restore Internal code: '.$getsingletrial['Internalcode'];
			$datalog['Data'] = json_encode($getsingletrial);

			$this->Trialadmin->insert_log($datalog);

		}
		redirect('admin/trial');
		exit();
	}

	public function resizeImage($filename){
      $source_path = UPLOADROOT . 'Trial/' . $filename;
      $target_path = UPLOADROOT . 'Trial/thumbnail/';
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
   	function create_videothumbnail($filename){
		$video = UPLOADROOT.'Trial/'.$filename;
		$pathinfo =  pathinfo($video); 
		$video_filename =  $pathinfo['filename'];  
	  	$image = UPLOADROOT.'Trial/thumbnail/'.$video_filename.'.jpg';

		$ffmpeg = '/usr/bin/ffmpeg';
		$second = 1;
		$thumbSize	= '280x280';
		$cmd = "$ffmpeg -i $video 2>&1";
		if (preg_match('/Duration: ((\d+):(\d+):(\d+))/s', $cmd, $time)) {
		    $total = ($time[2] * 3600) + ($time[3] * 60) + $time[4];
		    $second = rand(1, ($total - 1));
		}
		$cmdreturn = "$ffmpeg -i $video -deinterlace -an -ss $second -t 00:00:01 -s $thumbSize -r 1 -y -vcodec mjpeg -f mjpeg $image 2>&1";
		exec($cmdreturn, $output, $retval);
	}

	private function validateLogin($module='',$type=''){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			redirect('admin/logout');
			exit();   
		}
		$get_user_detail=$this->Trialadmin->get_user_detail($this->session->userdata('UserID'));
		$userrole= $get_user_detail['userrole'];
		$user_permission= $get_user_detail['userpermission'];
		if($user_permission!=''){
			$userpermission= json_decode($user_permission);
		}else{	
			$userpermission= array();
		}

		if($userrole!='1' AND $userrole!='2' AND $userrole!='3' AND $userrole!='4' AND $userrole!='5' AND $userrole!='6' AND $userrole!='7'){
			redirect('admin/logout');
			exit();  
		}elseif (!in_array($module, $userpermission) AND ($userrole=='2' || $userrole=='3' || $userrole=='5')){
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

	public function reporttrial(){
		$validateLogin = $this->validateLogin('trial','trialedit');
		$TrialID = $this->uri->segment(3);
	
		$get_single_trial = $this->Trialadmin->get_single_trial($TrialID);
		// echo "<pre>";
		// print_r($get_single_trial);
		// echo "</pre>";
		$get_sampling = $this->Trialadmin->get_sampling($get_single_trial['Internalcode']);
		$Date = $get_single_trial['Date'];
		$exdate = explode("/",$Date); 
        @$newDate = $exdate[0].'_'.$exdate[1].'_'.$exdate[2];
		$get_users = $this->Trialadmin->get_users($get_single_trial['UserID']);
		$data['Fullname'] = $get_users['firstname'].' '.$get_users['lastname'];

		$get_date = $get_single_trial['AddedDate'];
		if($get_date){
			$data['AddedDate'] = $get_date;
		}
		$get_description = $get_single_trial['Description'];
		if($get_description){
			$data['Description'] = $get_description;
		}
		$get_seed = $this->Trialadmin->get_seed($get_sampling['Seed']);
		if($get_seed){
			$data['Varity'] = $get_seed['Variety'];
		}
		$get_crop = $this->Trialadmin->get_crop($get_sampling['Crop']);
		if($get_crop){
			$data['Crop'] = $get_crop['Title'];
		}
		$get_Control = $this->Trialadmin->get_seed($get_sampling['Controlvariety']);
		if($get_Control){
			$data['Controlvariety'] = $get_Control['Variety'];
		}
		$get_supplier = $this->Trialadmin->get_supplier($get_sampling['SupplierID']);
		if($get_supplier){
			$data['Supplier'] = $get_supplier['Name'];
		}
		$get_location = $get_sampling['Location'];
		if($get_location){
			$data['Location'] = $get_sampling['Location'];
		}
		$get_dateofsowing = $get_sampling['Dateofsowing'];
		if($get_dateofsowing){
			$data['Dateofsowing'] = $get_sampling['Dateofsowing'];
		}
		
		$this->load->library('Pdf');
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle($data['Supplier'].'_'.$data['Crop'].'_'.$newDate);
		$pdf->SetHeaderMargin(15);
		$pdf->SetTopMargin(15);
		$pdf->setFooterMargin(15);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		$pdf->SetMargins(15, 15, 15);
		$pdf->SetAutoPageBreak(TRUE, 15);
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		$lg = Array();
		$lg['a_meta_charset'] = 'UTF-8';
		// $lg['a_meta_dir'] = 'rtl';
		$lg['a_meta_language'] = 'fa';
		$lg['w_page'] = 'page';

		// set some language-dependent strings (optional)
		$pdf->setLanguageArray($lg);

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('dejavusans', '', 13);
		$pdf->AddPage();


		$htmlContent = "";
		$htmlContent1 = "";
		// $htmlContent2 = "";
		$htmlimg1 = "";
		// $htmlimg2 = "";

		$htmlContent .= "<div><b>".$data['Supplier'].' '.$data['Crop'].' '.$newDate."</b><div><br>";

		$pdf->writeHTML($htmlContent, true, 0, true, 0);
		if(isset($_POST['editor1']) AND $_POST['editor1']!=''){
			// $htmlContent1 .= "<p><b>Variety  :" .$Variety."</b>";
			// $htmlContent1 .= "<p><b>Control Variety :" .$Controlvariety."</b>";
			$htmlContent1 .= "<p>".$_POST['editor1']."</p><br/>";
		}

		$pdf->writeHTML($htmlContent1, true, 0, true, 0);

		$pdf->lastPage();

		$pdf->AddPage();
		$imgdata = base64_decode('iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABlBMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDrEX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==');

		// The '@' character is used to indicate that follows an image data stream and not an image file name
		$pdf->writeHTML($htmlimg1, true, 0, true, 0);
		//$pdf->lastPage();
		$x = 15;
		$y = 20;
		$w = 85;
		$h = 85;
		if(isset($_POST['Pictures_1'])){
			$Picture= $_POST['Pictures_1'];
			$cnt = 1;
			$cnt1 = 1;
			if(count($Picture)>0){
				foreach ($Picture as $value){
					//$htmlimg1 .= '<img src="'.$value.'" alt="test alt attribute" width="315" height="300" border="1" />'.' ';
					if($cnt1 == '7'){
						$pdf->AddPage();
						$y = 20;
						$cnt1 = 1;
					}
					if($cnt=='1'){
						$pdf->Image($value, $x, $y, $w, $h, '', '', '', false, 300);
						$cnt++;
					}elseif($cnt=='2'){
						$x = 110;
						$pdf->Image($value, $x, $y, $h, $h, '', '', '', false, 300);
						$cnt = 1;	
						$x = 15; 
						$y = $y+87;
					}
					$cnt1++;
				}
			}	
		}		

		$pdf->Output($data['Supplier'].'_'.$data['Crop'].'_'.$newDate.'.pdf','D');
	}

}

