<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Restores extends MX_Controller {

	function __construct()   {

		parent::__construct();

		$this->load->model('Restoresadmin','',TRUE);

		$this->load->library('session');

		$this->load->library('pagination');			

    } 

	public function index(){

		$validateLogin = $this->validateLogin();

		$data['userpermission']=$validateLogin['userpermission'];

		$data['userrole']=$validateLogin['userrole'];

		$data['heading_title']='Restore Section';

		$data['active']='extra';

		$data['submenuactive']='restores';



		$modules = array();

	    $modules['crops'] = 'Crops';

	    $modules['evaluations'] = 'Evaluations';

	    $modules['receivers'] = 'Receivers';

	    $modules['samplings'] = 'Samplings';

	    $modules['seeds'] = 'Seeds';

	    $modules['suppliers'] = 'Suppliers';

	    $modules['techncialteams'] = 'Techncial teams';

	    $modules['trials'] = 'Trials';



	    $data['modules']= $modules;



	    $module = @$_GET['module'];



	    if (array_key_exists($module,$modules)){

	    	if($module=='crops'){

	    		$module_data_count = $this->Restoresadmin->get_count_crops();

	    	}elseif($module=='evaluations'){

	    		$module_data_count = $this->Restoresadmin->get_count_evaluations();

	    	}elseif($module=='receivers'){

	    		$module_data_count = $this->Restoresadmin->get_count_receivers();

	    	}elseif($module=='samplings'){

	    		$module_data_count = $this->Restoresadmin->get_count_samplings();

	    	}elseif($module=='seeds'){

	    		$module_data_count = $this->Restoresadmin->get_count_seeds();

	    	}elseif($module=='suppliers'){

	    		$module_data_count = $this->Restoresadmin->get_count_suppliers();

	    	}elseif($module=='techncialteams'){

	    		$module_data_count = $this->Restoresadmin->get_count_techncialteams();

	    	}elseif($module=='trials'){

	    		$module_data_count = $this->Restoresadmin->get_count_trials();

	    	}



	    	$config = array();

	    	if ($module) $config['suffix'] = '?' . http_build_query($_GET, '', "&");	    	

			$config['base_url'] = base_url() .'admin/restores/';

			$config['use_page_numbers'] = false;

			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);

			$config['total_rows'] = $module_data_count;

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



			$this->pagination->initialize($config);

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;



			$data['result_count']= "Showing ".$start." - ".$end." of ".$config['total_rows']." Results";



			if($module=='crops'){

	    		$module_data = $this->Restoresadmin->get_crops($config["per_page"], $page);

	    	}elseif($module=='evaluations'){

	    		$module_data = $this->Restoresadmin->get_evaluations($config["per_page"], $page);

	    	}elseif($module=='receivers'){

	    		$module_data = $this->Restoresadmin->get_receivers($config["per_page"], $page);

	    	}elseif($module=='samplings'){

	    		$module_data = array();

	    		$get_samplings = $this->Restoresadmin->get_samplings($config["per_page"], $page);

	    		foreach ($get_samplings as  $get_sampling) {

					$sampling = array();

					$get_crop = $this->Restoresadmin->get_crop($get_sampling['Crop']);

					if($get_crop){

						$sampling['Crop'] = $get_crop['Title'];

					}else{

						$sampling['Crop'] ='';

					}					

					$get_seed_Controlvariety = $this->Restoresadmin->get_seed($get_sampling['Controlvariety']);

					if($get_seed_Controlvariety){

						$sampling['Controlvariety'] = $get_seed_Controlvariety['Variety'];

					}else{

						$sampling['Controlvariety'] ='';

					}

					$sampling['SamplingID'] = $get_sampling['SamplingID'];

					$sampling['Internalsamplingcode'] = $get_sampling['Internalsamplingcode'];

					$sampling['Location'] = $get_sampling['Location'];

					$sampling['Dateofsowing'] = $get_sampling['Dateofsowing'];

					$sampling['Dateoftransplanted'] = $get_sampling['Dateoftransplanted'];

					$sampling['Estimatedharvestingdate'] = $get_sampling['Estimatedharvestingdate'];

					$sampling['Description'] = $get_sampling['Description'];

					$sampling['Technicalnotes'] = $get_sampling['Technicalnotes'];

					$sampling['is_deleted'] = $get_sampling['is_deleted'];

					$module_data[] = $sampling;

				}

	    	}elseif($module=='seeds'){

	    		$Status = array();

				$Status[] = 'New Sample';

				$Status[] = 'Re-check 1';

				$Status[] = 'Re-check 2';

				$Status[] = 'Re-check 3';

				$Status[] = 'Pre-commercial';

				$Status[] = 'Commercial or control variety';

				$Status[] = 'Drop';



	    		$module_data = array();

	    		$get_seeds = $this->Restoresadmin->get_seeds($config["per_page"], $page);

	    		foreach ($get_seeds as  $get_seed) {

					$seed = array();

					$get_crop = $this->Restoresadmin->get_crop($get_seed['Crop']);

					if($get_crop){

						$seed['Crop'] = $get_crop['Title'];

					}else{

						$seed['Crop'] ='';

					}



					$get_supplier = $this->Restoresadmin->get_supplier($get_seed['Supplier']);

					if($get_supplier){

						$seed['Supplier'] = $get_supplier['Name'];

					}else{

						$seed['Supplier'] ='';

					}



					$seed['SeedID'] = $get_seed['SeedID'];

					$seed['Variety'] = $get_seed['Variety'];

					$seed['Dateofrecivedsampel'] = $get_seed['Dateofrecivedsampel'];

					$seed['Status'] = $Status[$get_seed['Status']];

					$seed['is_deleted'] = $get_seed['is_deleted'];

					$module_data[] = $seed;

				}

	    	}elseif($module=='suppliers'){

	    		$module_data = $this->Restoresadmin->get_suppliers($config["per_page"], $page);

	    	}elseif($module=='techncialteams'){

	    		$module_data = $this->Restoresadmin->get_techncialteams($config["per_page"], $page);

	    	}elseif($module=='trials'){

	    		$module_data = $this->Restoresadmin->get_trials($config["per_page"], $page);

	    	}

	    	$data['module_data']= $module_data;

	    	$data["links"] = $this->pagination->create_links();

	    }	



		$this->load->view('restores',$data);

	}


	public function restore_delete(){

		$validateLogin = $this->validateLogin();



		$type = $this->uri->segment(3);

		$module = $this->uri->segment(4);

		$id = $this->uri->segment(5);



		$modules = array();

	    $modules['crops'] = 'Crops';

	    $modules['evaluations'] = 'Evaluations';

	    $modules['receivers'] = 'Receivers';

	    $modules['samplings'] = 'Samplings';

	    $modules['seeds'] = 'Seeds';

	    $modules['suppliers'] = 'Suppliers';

	    $modules['techncialteams'] = 'Techncial teams';

	    $modules['trials'] = 'Trials';



	    $redirecturl = base_url() .'admin/restore';



	    if (array_key_exists($module,$modules)){

			if($type=='delete' || $type=='restore'){

				if($module=='crops'){

		    		$this->Restoresadmin->get_restore_delete_crops($type,$id);

		    	}elseif($module=='evaluations'){

		    		$this->Restoresadmin->get_restore_delete_evaluations($type,$id);

		    	}elseif($module=='receivers'){

		    		$this->Restoresadmin->get_restore_delete_receivers($type,$id);

		    	}elseif($module=='samplings'){

		    		$this->Restoresadmin->get_restore_delete_samplings($type,$id);

		    	}elseif($module=='seeds'){

		    		$this->Restoresadmin->get_restore_delete_seeds($type,$id);

		    	}elseif($module=='suppliers'){

		    		$this->Restoresadmin->get_restore_delete_suppliers($type,$id);

		    	}elseif($module=='techncialteams'){

		    		$this->Restoresadmin->get_restore_delete_techncialteams($type,$id);

		    	}elseif($module=='trials'){

		    		$this->Restoresadmin->get_restore_delete_trials($type,$id);

		    	}

		    }	



		    if($type=='delete'){	

		    	$this->session->set_flashdata('success', $modules[$module].' been Deleted successfully.');

		    }elseif($type=='restore'){

		    	$this->session->set_flashdata('success', $modules[$module].' been Restore successfully.');

		    }

		    $redirecturl = base_url() .'admin/restores?module='.$module;

		}    

	    redirect($redirecturl);

		exit();

	}



	private function validateLogin(){

		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){

			redirect('admin/logout');

			exit();   

		}

		$get_user_detail=$this->Restoresadmin->get_user_detail($this->session->userdata('UserID'));

		$userrole= $get_user_detail['userrole'];

		$user_permission= $get_user_detail['userpermission'];

		if($userrole!='1'){

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

