<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('Dashboardadmin','',TRUE);
		$this->load->library('session');
		$this->load->library('pagination');			
    } 
	public function index(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$data['heading_title']='Dashboard';
		$data['active']='dashboard';
		$data['submenuactive']='';
		
		$get_samplings = $this->Dashboardadmin->get_samplings();
		$samplings = array();
		foreach ($get_samplings as  $get_sampling) {
			$sampling = array();
			$sampling['get_crop'] = $this->Dashboardadmin->get_crop($get_sampling['Crop']);
			$sampling['SamplingID'] = $get_sampling['SamplingID'];
			$sampling['Location'] = $get_sampling['Location'];
			$sampling['Description'] = $get_sampling['Description'];
			$samplings[] = $sampling;
		}
		$data["samplings"] = $samplings;
		$data["trial"] = $this->Dashboardadmin->get_trials();
		$data["evaluation"] = $this->Dashboardadmin->get_evaluations();
		$data["crops"] = $this->Dashboardadmin->get_crops();

		$type = @$_GET['type'];
		$search = @$_GET['search'];


		if($type!='' AND $search!=''){
			$config = array();
			if ($type) $config['suffix'] = '?' . http_build_query($_GET, '', "&");


			$config['base_url'] = base_url() .'admin/';
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			$config['use_page_numbers'] = false;
			$config['per_page'] = 20;
			$config['uri_segment'] = 2;
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

	        if($type=='Crops'){
				$config['total_rows'] = $this->Dashboardadmin->get_search_crops_count($search);
			}elseif($type=='Controlvariety'){
				$config['total_rows'] = $this->Dashboardadmin->get_search_controlvariety_count($search);
			}elseif($type=='Suppliers'){
				$config['total_rows'] = $this->Dashboardadmin->get_search_suppliers_count($search);
			}elseif($type=='Receivers'){
				$config['total_rows'] = $this->Dashboardadmin->get_search_receivers_count($search);
			}elseif($type=='Techncialteam'){
				$config['total_rows'] = $this->Dashboardadmin->get_search_techncialteam_count($search);
			}elseif($type=='Seeds'){
				$config['total_rows'] = $this->Dashboardadmin->get_search_seeds_count($search);
			}elseif($type=='Sampling'){
				$config['total_rows'] = $this->Dashboardadmin->get_search_sampling_count($search);
			}elseif($type=='Trial'){
				$config['total_rows'] = $this->Dashboardadmin->get_search_trial_count($search);
			}elseif($type=='Evaluation'){
				$config['total_rows'] = $this->Dashboardadmin->get_search_evaluation_count($search);
			}elseif($type=='Recheck'){
				$config['total_rows'] = $this->Dashboardadmin->get_search_recheck_count($search);
			}elseif($type=='Precommercial'){
				$config['total_rows'] = $this->Dashboardadmin->get_search_precommercial_count($search);
			}	

	        if($this->uri->segment(3) > 0){
			    $start = $this->uri->segment(3)+1;
			    $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) + $config['per_page'];
			}else{
			    $start= (int)$this->uri->segment(3) * $config['per_page']+1;
			    $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
			}

			$data['result_count']= "Showing ".$start." - ".$end." of ".$config['total_rows']." Results";

			$this->pagination->initialize($config);
			$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
			$data["links"] = $this->pagination->create_links();

			if($type=='Crops'){

				$data["SearchCrops"] = $this->Dashboardadmin->get_search_crops($config["per_page"], $page,$search);

			}elseif($type=='Controlvariety'){
				$data["SearchControlvariety"] = $this->Dashboardadmin->get_search_controlvariety($config["per_page"], $page,$search);
			}elseif($type=='Suppliers'){
				$data["SearchSuppliers"] = $this->Dashboardadmin->get_search_suppliers($config["per_page"], $page,$search);
			}elseif($type=='Receivers'){
				$data["SearchReceivers"] = $this->Dashboardadmin->get_search_receivers($config["per_page"], $page,$search);
			}elseif($type=='Techncialteam'){
				$data["SearchTechncialteam"] = $this->Dashboardadmin->get_search_techncialteam($config["per_page"], $page,$search);
			}elseif($type=='Seeds'){
				$Status = array();
				$Status[] = 'New Sample';
				$Status[] = 'Re-check 1';
				$Status[] = 'Re-check 2';
				$Status[] = 'Re-check 3';
				$Status[] = 'Pre-commercial';
				$Status[] = 'Commercial or control variety';
				$Status[] = 'Drop';

				$Amountfor = array();
				$Amountfor[] = 'Gram';
				$Amountfor[] = 'Kg';
				$Amountfor[] = 'Seed';
				$getseeds =array();
				$get_search_seeds = $this->Dashboardadmin->get_search_seeds($config["per_page"], $page,$search);


		        foreach ($get_search_seeds as  $value) {
		        	$get_crop = $this->Dashboardadmin->get_crop($value['Crop']);
					$get_supplier = $this->Dashboardadmin->get_supplier($value['Supplier']);

			        $seed =array();
					$seed['Crop'] = $get_crop['Title'];
					$seed['Supplier'] = $get_supplier['Name'];
					$seed['Variety'] = $value['Variety'];
					$seed['Dateofrecivedsampel'] = $value['Dateofrecivedsampel'];
					$seed['Status'] = $Status[$value['Status']];
					$seed['Amountfor'] = $Amountfor[$value['Amountfor']];
					$seed['Amount'] = $value['Amount'];
					$getseeds[] = $seed;
				}
				$data["SearchSeeds"] = $getseeds;
			}elseif($type=='Sampling'){
				$getsamplings =array();
				$get_search_sampling = $this->Dashboardadmin->get_search_sampling($config["per_page"], $page,$search);
		        foreach ($get_search_sampling as  $value) {
		        	$get_crop = $this->Dashboardadmin->get_crop($value['Crop']);
					$get_controlvariety = $this->Dashboardadmin->get_controlvariety($value['Controlvariety']);

			        $getsampling =array();
					$getsampling['Location'] = $value['Location'];
					$getsampling['Internalsamplingcode'] = $value['Internalsamplingcode'];
					$getsampling['Crop'] = $get_crop['Title'];
					$getsampling['Controlvariety'] = $get_controlvariety['Title'];
					$getsamplings[] = $getsampling;
				}
				$data["SearchSampling"] = $getsamplings;
			}elseif($type=='Trial'){
				$data["SearchTrial"] = $this->Dashboardadmin->get_search_trial($config["per_page"], $page,$search);
			}elseif($type=='Evaluation'){
				$data["SearchEvaluation"] = $this->Dashboardadmin->get_search_evaluation($config["per_page"], $page,$search);
			}elseif($type=='Recheck'){
				$rechecks =array();
				$get_search_recheck = $this->Dashboardadmin->get_search_recheck($config["per_page"], $page,$search);
		        foreach ($get_search_recheck as  $value) {
		        	$get_crop = $this->Dashboardadmin->get_crop($value['Crop']);
					$get_supplier = $this->Dashboardadmin->get_supplier($value['Supplier']);

			        $recheck =array();
					$recheck['RecheckID'] = $value['RecheckID'];
					$recheck['Crop'] = $get_crop['Title'];
					$recheck['Variety'] = $value['Variety'];
					$recheck['Supplier'] = $get_supplier['Name'];
					$recheck['Numebrofseedsrequast'] = $value['Numebrofseedsrequast'];
					$recheck['Bywhen'] = $value['Bywhen'];
					$rechecks[] = $recheck;
				}
				$data["SearchRecheck"] = $rechecks;
			}elseif($type=='Precommercial'){
				$data["SearchPrecommercial"] = $this->Dashboardadmin->get_search_precommercial($config["per_page"], $page,$search);
			}
		}
		$this->load->view('dashboard',$data);
	}

	private function validateLogin(){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			redirect('admin/logout');
			exit();   
		}
		$get_user_detail=$this->Dashboardadmin->get_user_detail($this->session->userdata('UserID'));
		$userrole= $get_user_detail['userrole'];
		$user_permission= $get_user_detail['userpermission'];
		if($userrole!='1' AND $userrole!='2' AND $userrole!='3' AND $userrole!='4' AND $userrole!='6' AND $userrole!='7'){
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
