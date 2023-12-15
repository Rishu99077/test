<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Techncialteam extends MX_Controller {

	function __construct()   {

		parent::__construct();

		$this->load->model('Techncialteamadmin','',TRUE);

		$this->load->library('session');

		$this->load->library('pagination');			

    } 

	public function index(){

		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];		

		$data['heading_title']='Techncial Team';

		$data['active']='entry';

		$data['submenuactive']='techncialteam';



		$config = array();

		$config['base_url'] = base_url() .'admin/techncialteam/';
		$config['use_page_numbers'] = false;
		$config['total_rows'] = $this->Techncialteamadmin->get_techncialteam_count($data['userrole']);
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
		$data["techncialteam"] = $this->Techncialteamadmin->get_techncialteam($config["per_page"], $page,$data['userrole']);
        $data["links"] = $this->pagination->create_links();
		$this->load->view('techncialteam',$data);

	}



	public function techncialteamedit(){

		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$error = array();
		$error['Name'] = '';

		$get_single_techncialteam =array();
		$get_single_techncialteam['Name'] = '';
		$get_single_techncialteam['Note'] = '';

		$TechncialteamID = @$_GET['TechncialteamID']; 
		if($TechncialteamID){			
			$get_single_techncialteam = $this->Techncialteamadmin->get_single_techncialteam($TechncialteamID);
			$data['heading_title']='Edit techncial team';
		}else{
			$data['heading_title']='Add techncial team';
		}

		if (($this->input->server('REQUEST_METHOD') == 'POST')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('Name', 'Name', 'required|trim');
			if ($this->form_validation->run() == FALSE) {
				if(form_error('Name')){
					$error['Name']  =form_error('Name');
				}
			}else{
				$datalog = array();
				$datalog['UserID'] = $this->session->userdata('UserID');
				if($TechncialteamID){
					$getsingletechncialteam = $this->Techncialteamadmin->get_single_techncialteam($TechncialteamID);
					$this->Techncialteamadmin->update_techncialteam($this->input->post(),$TechncialteamID);
					$this->session->set_flashdata('success', 'Techncial team update successfully.');
					$datalog['Activity'] = 'Update';
					$datalog['Title'] = 'Techncial team Update '.$this->input->post('Name',true);
					$datalog['Data'] = json_encode($getsingletechncialteam);
				}else{
					$datapost = $this->input->post();
					$datapost['UserID'] = $this->session->userdata('UserID');
					$TechncialteamID = $this->Techncialteamadmin->insert_techncialteam($datapost);
					$this->session->set_flashdata('success', 'Techncial team added successfully.');
					$datalog['Activity'] = 'Insert';
					$datalog['Title'] = 'Techncial team added '.$this->input->post('Name',true);
					$datalog['Data'] = json_encode($this->input->post());
				}	
				$this->Techncialteamadmin->insert_log($datalog);
				redirect('admin/techncialteam');
				exit();
			}

			$get_single_techncialteam['Name'] = $this->input->post('Name');
			$get_single_techncialteam['Note'] = $this->input->post('Note');

		}

		

		$data['error']=$error;
		$data['active']='entry';
		$data['submenuactive']='techncialteamedit';
		$data['get_single_techncialteam']= $get_single_techncialteam;
		$this->load->view('techncialteamedit',$data);

	}



	public function deletetechncialteam_old(){

		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$TechncialteamID = $this->uri->segment(3);
		if($TechncialteamID){

			$getsingletechncialteam = $this->Techncialteamadmin->get_single_techncialteam($TechncialteamID);
			
			$this->Techncialteamadmin->deletetechncialteam($TechncialteamID,$data['userrole']);

			$this->session->set_flashdata('success', 'Techncial team been Deleted successfully.');


			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Techncial team Delete '.$getsingletechncialteam['Name'];
			$datalog['Data'] = json_encode($getsingletechncialteam);

			$this->Techncialteamadmin->insert_log($datalog);

		}
		redirect('admin/techncialteam');
		exit();

	}

	public function deletetechncialteam(){

		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$TechncialteamID = $_POST['DeleteID'];
		if($TechncialteamID){

			$getsingletechncialteam = $this->Techncialteamadmin->get_single_techncialteam($TechncialteamID);
			
			$this->Techncialteamadmin->deletetechncialteam($TechncialteamID,$data['userrole']);

			$this->session->set_flashdata('success', 'Techncial team been Deleted successfully.');


			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Techncial team Delete '.$getsingletechncialteam['Name'];
			$datalog['Data'] = json_encode($getsingletechncialteam);

			$this->Techncialteamadmin->insert_log($datalog);
		}
		
	}

	public function restoretechncialteam(){

		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$TechncialteamID = $this->uri->segment(3);



		if($TechncialteamID){

			$getsingletechncialteam = $this->Techncialteamadmin->get_single_techncialteam($TechncialteamID);
			
			$datapost = array();
			$datapost['is_deleted'] = '0';

			$this->Techncialteamadmin->update_techncialteam($datapost,$TechncialteamID);

			$this->session->set_flashdata('success', 'Techncial team been Restore successfully.');


			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Restore';
			$datalog['Title'] = 'Techncial team Restore '.$getsingletechncialteam['Name'];
			$datalog['Data'] = json_encode($getsingletechncialteam);

			$this->Techncialteamadmin->insert_log($datalog);

		}

		redirect('admin/techncialteam');

			exit();

	}

	private function validateLogin(){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			redirect('admin/logout');
			exit();   
		}
		$get_user_detail=$this->Techncialteamadmin->get_user_detail($this->session->userdata('UserID'));
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

