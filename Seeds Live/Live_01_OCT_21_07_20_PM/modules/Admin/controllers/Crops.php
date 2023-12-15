<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Crops extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('Cropsadmin','',TRUE);
		$this->load->library('session');
		$this->load->library('pagination');			
    } 

	public function index(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];	

		$data['heading_title']='Crops';
		$data['active']='entry';
		$data['submenuactive']='crops';

		$config = array();
		$config['base_url'] = base_url() .'admin/crops/';
		$config['use_page_numbers'] = false;
		$config['total_rows'] = $this->Cropsadmin->get_crops_count($data['userrole']);
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
		$data["crops"] = $this->Cropsadmin->get_crops($config["per_page"], $page,$data['userrole']);
        $data["links"] = $this->pagination->create_links();
		$this->load->view('crops',$data);
	}

	public function cropedit(){

		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$error = array();
		$error['title'] = '';
		$CropID = @$_GET['CropID']; 

		if (($this->input->server('REQUEST_METHOD') == 'POST')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title', 'Title', 'required|trim');
			if ($this->form_validation->run() == FALSE) {
				if(form_error('title')){
					$error['title']  =form_error('title');
				}
			}else{
				$datalog = array();
				$datalog['UserID'] = $this->session->userdata('UserID');

				if($CropID){
					$getcrop = $this->Cropsadmin->get_crop($CropID);

					$this->Cropsadmin->update_crop($this->input->post(),$CropID);
					$this->session->set_flashdata('success', 'Crop update successfully.');
					
					$datalog['Activity'] = 'Update';
					$datalog['Title'] = 'Crop update '.$this->input->post('title',true);
					$datalog['Data'] = json_encode($getcrop);
				}else{
					$datapost = $this->input->post();
					$datapost['UserID'] = $this->session->userdata('UserID');

					$CropID = $this->Cropsadmin->insert_crop($datapost);

					$datalog['Activity'] = 'Insert';
					$datalog['Title'] = 'Crop added '.$this->input->post('title',true);
					$datalog['Data'] = json_encode($this->input->post());
					$this->session->set_flashdata('success', 'Crop added successfully.');
				}
				$this->Cropsadmin->insert_log($datalog);	
				redirect('admin/crops');
				exit();
			}	
		}

		$get_crop =array();
		$get_crop['Title'] = '';
		if($CropID){			
			$get_crop = $this->Cropsadmin->get_crop($CropID);
			$data['heading_title']='Edit crop';
		}else{
			$data['heading_title']='Add crop';
		}
		$data['error']=$error;
		$data['active']='entry';
		$data['submenuactive']='cropedit';
		$data['get_crop']= $get_crop;
		$this->load->view('cropedit',$data);
	}



	public function deletecrop_old(){

		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$CropID = $this->uri->segment(3);



		if($CropID){
			$getcrop = $this->Cropsadmin->get_crop($CropID);
			$this->Cropsadmin->deletecrop($CropID,$data['userrole']);
			$this->session->set_flashdata('success', 'Crop been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Crop Deleted '.$getcrop['Title'];
			$datalog['Data'] = json_encode($getcrop);
			$this->Cropsadmin->insert_log($datalog);

		}
		redirect('admin/crops');
		exit();
	}

	public function deletecrop(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$CropID = $_POST['DeleteID'];



		if($CropID){
			$getcrop = $this->Cropsadmin->get_crop($CropID);
			$this->Cropsadmin->deletecrop($CropID,$data['userrole']);
			$this->session->set_flashdata('success', 'Crop been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Crop Deleted '.$getcrop['Title'];
			$datalog['Data'] = json_encode($getcrop);
			$this->Cropsadmin->insert_log($datalog);

		}
	}

	public function restorecrop(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$CropID = $this->uri->segment(3);
		if($CropID){
			$getcrop = $this->Cropsadmin->get_crop($CropID);
	
			$datapost = array();
			$datapost['is_deleted'] = '0';

			$this->Cropsadmin->update_crop($datapost,$CropID);

			$this->session->set_flashdata('success', 'Crop been Restore successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Restore';
			$datalog['Title'] = 'Crop Restore '.$getcrop['Title'];
			$datalog['Data'] = json_encode($getcrop);
			$this->Cropsadmin->insert_log($datalog);

		}
		redirect('admin/crops');
		exit();
	}

	private function validateLogin(){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			redirect('admin/logout');
			exit();   
		}
		$get_user_detail=$this->Cropsadmin->get_user_detail($this->session->userdata('UserID'));
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