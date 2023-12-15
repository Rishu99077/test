<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Controlvariety extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('Controlvarietyadmin','',TRUE);
		$this->load->library('session');
		$this->load->library('pagination');			
    } 

	public function index(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];			
		$data['heading_title']='Controlvariety';
		$data['active']='entry';
		$data['submenuactive']='controlvariety';
		$config = array();
		$config['base_url'] = base_url() .'admin/controlvariety/';
		$config['total_rows'] = $this->Controlvarietyadmin->get_controlvariety_count($data['userrole']);
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		//$config['num_links'] = 2;
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

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data["controlvariety"] = $this->Controlvarietyadmin->get_controlvariety($config["per_page"], $page,$data['userrole']);
        $data["links"] = $this->pagination->create_links();
		$this->load->view('controlvariety',$data);
	}

	public function controlvarietyedit(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$error = array();
		$error['Crop'] = '';
		$error['Variety'] = '';
		$error['title'] = '';
		$ControlvarietyID = @$_GET['ControlvarietyID']; 
		if (($this->input->server('REQUEST_METHOD') == 'POST')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title', 'Title', 'required|trim');
			$this->form_validation->set_rules('Crop', 'Crop', 'required|trim');
			$this->form_validation->set_rules('Variety', 'Variety', 'required|trim');
			if ($this->form_validation->run() == FALSE) {
				if(form_error('title')){
					$error['title']  =form_error('title');
				}
				if(form_error('Crop')){
					$error['Crop']  =form_error('Crop');
				}
				if(form_error('Variety')){
					$error['Variety']  =form_error('Variety');
				}
			}else{
				$datalog = array();
				$datalog['UserID'] = $this->session->userdata('UserID');
				if($ControlvarietyID){
					$getcontrolvariety = $this->Controlvarietyadmin->get_single_controlvariety($ControlvarietyID);

					$this->Controlvarietyadmin->update_controlvariety($this->input->post(),$ControlvarietyID);
					$this->session->set_flashdata('success', 'Control variety update successfully.');
					$datalog['Activity'] = 'Update';
					$datalog['Title'] = 'Control variety update '.$this->input->post('title',true);
					$datalog['Data'] = json_encode($getcontrolvariety);
				}else{
					$ControlvarietyID = $this->Controlvarietyadmin->insert_controlvariety($this->input->post());
					$this->session->set_flashdata('success', 'Control variety added successfully.');
					$datalog['Activity'] = 'Insert';
					$datalog['Title'] = 'Control variety added '.$this->input->post('title',true);
					$datalog['Data'] = json_encode($this->input->post());
				}	
				$this->Controlvarietyadmin->insert_log($datalog);
				redirect('admin/controlvariety');
				exit();
			}	
		}

		$get_controlvariety =array();
		$get_controlvariety['Title'] = '';
		$get_controlvariety['Crop'] = '';
		$get_controlvariety['Variety'] = '';
		if($ControlvarietyID){			
			$get_controlvariety = $this->Controlvarietyadmin->get_single_controlvariety($ControlvarietyID);
			$data['heading_title']='Edit control variety';
		}else{
			$data['heading_title']='Add control variety';
		}

		$data["crops"] = $this->Controlvarietyadmin->get_crops();
		$data["seeds"] = $this->Controlvarietyadmin->get_seeds();

		$data['error']=$error;
		$data['active']='entry';
		$data['submenuactive']='controlvarietyedit';
		$data['get_controlvariety']= $get_controlvariety;
		$this->load->view('controlvarietyedit',$data);
	}

	public function deletecontrolvariety(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$ControlvarietyID = $this->uri->segment(3);
		if($ControlvarietyID){

			$get_controlvariety = $this->Controlvarietyadmin->get_single_controlvariety($ControlvarietyID);


			$this->Controlvarietyadmin->deletecontrolvariety($ControlvarietyID,$data['userrole']);
			$this->session->set_flashdata('success', 'Control variety been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Control variety Deleted '.$get_controlvariety['Title'];
			$datalog['Data'] = json_encode($get_controlvariety);
			$this->Controlvarietyadmin->insert_log($datalog);
		}
		redirect('admin/controlvariety');
		exit();
	}

	public function restorecontrolvariety(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$ControlvarietyID = $this->uri->segment(3);
		if($ControlvarietyID){
			$get_controlvariety = $this->Controlvarietyadmin->get_single_controlvariety($ControlvarietyID);
			$datapost = array();
			$datapost['is_deleted'] = '0';

			$this->Controlvarietyadmin->update_controlvariety($datapost,$ControlvarietyID);


			$this->session->set_flashdata('success', 'Control variety been Restore successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Restore';
			$datalog['Title'] = 'Control variety Restore '.$get_controlvariety['Title'];
			$datalog['Data'] = json_encode($get_controlvariety);
			$this->Controlvarietyadmin->insert_log($datalog);
		}
		redirect('admin/controlvariety');
		exit();
	}

	private function validateLogin(){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			redirect('admin/logout');
			exit();   
		}
		$get_user_detail=$this->Controlvarietyadmin->get_user_detail($this->session->userdata('UserID'));
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