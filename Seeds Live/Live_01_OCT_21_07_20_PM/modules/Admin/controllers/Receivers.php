<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Receivers extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('Receiversadmin','',TRUE);
		$this->load->library('session');
		$this->load->library('pagination');			
    } 

	public function index(){

		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];	

		$data['heading_title']='Receivers';
		$data['active']='entry';
		$data['submenuactive']='receivers';

		$Name = $this->input->get('Name');
		$Province = $this->input->get('Province');
		$Mobile1 = $this->input->get('Mobile1');

		if ($Name || $Province || $Mobile1){
   			$total_rows = $this->Receiversadmin->filter_receivers_num_row($Name,$Province,$Mobile1);
   		}else{
   			$total_rows = $this->Receiversadmin->get_receivers_count($data['userrole']);
   		}	
 
 		$config = array();
		if ($Name || $Province || $Mobile1) $config['suffix'] = '?' . http_build_query($_GET, '', "&");

		$config['base_url'] = base_url() .'admin/receivers/';
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

		if ($Name || $Province || $Mobile1){
   			$data["receivers"] = $this->Receiversadmin->get_filter_receivers($Name,$Province,$Mobile1, $config["per_page"], $page);
   		}else{
   			$data["receivers"] = $this->Receiversadmin->get_receivers($config["per_page"], $page,$data['userrole']);
   		}
		
        $data["links"] = $this->pagination->create_links();

        $get_receivers_all = $this->Receiversadmin->get_receivers_all($data['userrole']);
        $receivers_name = array();
        foreach($get_receivers_all as $value){
        	$receivers_name[$value['Name']] = $value['Name'];
        }
        $data["receivers_name"] = $receivers_name;

        $receivers_province = array();
        foreach($get_receivers_all as $value){
        	$receivers_province[$value['Province']] = $value['Province'];
        }
        $data["receivers_province"] = $receivers_province;

        $receivers_mobile1 = array();
        foreach($get_receivers_all as $value){
        	$receivers_mobile1[$value['Mobile1']] = $value['Mobile1'];
        }
        $data["receivers_mobile1"] = $receivers_mobile1;

		$this->load->view('receivers',$data);
	}

	public function receiveredit(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$error = array();
		$error['Name'] = '';
		$error['Activity'] = '';
		$error['Province'] = '';
		$error['Telphone1'] = '';
		$error['Telphone2'] = '';
		$error['Mobile1'] = '';
		$error['Mobile2'] = '';
		$error['Address'] = '';
		$error['Location'] = '';
		$error['Note'] = '';

		$msg = 0;
		$Location = $this->input->post('Location',true);
		if ($Location==''){
			$msg = 1;
		}elseif(count($Location)<1){
			$msg = 1;
		}elseif(count($Location)>0){
			foreach ($Location as $valueLocation) {
				if($valueLocation==''){
					$msg = 1;
				}
			}
		}

		$ReceiverID = @$_GET['ReceiverID'];

		$get_receiver =array();
		$get_receiver['Name'] = '';
		$get_receiver['Activity'] = '';
		$get_receiver['Province'] = '';
		$get_receiver['Telphone1'] = '';
		$get_receiver['Telphone2'] = '';
		$get_receiver['Mobile1'] = '';
		$get_receiver['Mobile2'] = '';
		$get_receiver['Address'] = '';
		$get_receiver['Location'] = '';
		$get_receiver['Note'] = '';

		if($ReceiverID){
			$get_receiver = $this->Receiversadmin->get_receiver($ReceiverID);
			$data['heading_title']='Edit receiver';
		}else{
			$data['heading_title']='Add receiver';
		}

		if (($this->input->server('REQUEST_METHOD') == 'POST')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('Name', 'Name', 'required|trim');
			$this->form_validation->set_rules('Activity', 'Activity', 'required|trim');
			$this->form_validation->set_rules('Province', 'Province', 'required|trim');
			$this->form_validation->set_rules('Mobile1', 'Mobile 1', 'required|trim');
			if ($this->form_validation->run() == FALSE) {
				if(form_error('Name')){
					$error['Name']  =form_error('Name');
				}
				if(form_error('Activity')){
					$error['Activity']  =form_error('Activity');
				}
				if(form_error('Province')){
					$error['Province']  =form_error('Province');
				}
				if(form_error('Mobile1')){
					$error['Mobile1']  =form_error('Mobile1');
				}
				if ($msg) {
					$error['Location']  = "The Location field is required.";	
				}
			}elseif ($msg) {
				$error['Location']  = "The Location field is required.";		
			}else{
				$datapost=array();		
				$datapost['Name'] = $this->input->post('Name',true);
				$datapost['Activity'] = $this->input->post('Activity',true);
				$datapost['Province'] = $this->input->post('Province',true);
				$datapost['Telphone1'] = $this->input->post('Telphone1',true);
				$datapost['Telphone2'] = $this->input->post('Telphone2',true);
				$datapost['Mobile1'] = $this->input->post('Mobile1',true);
				$datapost['Mobile2'] = $this->input->post('Mobile2',true);
				$datapost['Address'] = $this->input->post('Address',true);
				if($this->input->post('Location',true)!=''){
					$datapost['Location'] = json_encode($this->input->post('Location',true));
				}else{
					$datapost['Location'] = '';
				}

				if($this->input->post('Address',true)!=''){
					$datapost['Address'] = json_encode($this->input->post('Address',true));
				}else{
					$datapost['Address'] = '';
				}
				
				$datapost['Note'] = $this->input->post('Note',true);

				$datalog = array();
				$datalog['UserID'] = $this->session->userdata('UserID');
				if($ReceiverID){
					$getreceiver = $this->Receiversadmin->get_receiver($ReceiverID);

					$this->Receiversadmin->update_receiver($datapost,$ReceiverID);
					$this->session->set_flashdata('success', 'Receiver update successfully.');

					$datalog['Activity'] = 'Update';
					$datalog['Title'] = 'Receiver Update '.$this->input->post('Name',true);
					$datalog['Data'] = json_encode($getreceiver);

				}else{
					$datapost['UserID'] = $this->session->userdata('UserID');
					$ReceiverID= $this->Receiversadmin->insert_receiver($datapost);
					$this->session->set_flashdata('success', 'Receiver added successfully.');

					$datalog['Activity'] = 'Insert';
					$datalog['Title'] = 'Receiver added '.$this->input->post('Name',true);
					$datalog['Data'] = json_encode($datapost);
				}
				$this->Receiversadmin->insert_log($datalog);
				redirect('admin/receivers');
				exit();
			}

			$get_receiver['Name'] = $this->input->post('Name',true);
			$get_receiver['Activity'] = $this->input->post('Activity',true);
			$get_receiver['Province'] = $this->input->post('Province',true);
			$get_receiver['Telphone1'] = $this->input->post('Telphone1',true);
			$get_receiver['Telphone2'] = $this->input->post('Telphone2',true);
			$get_receiver['Mobile1'] = $this->input->post('Mobile1',true);
			$get_receiver['Mobile2'] = $this->input->post('Mobile2',true);

			if($this->input->post('Address',true)!=''){
				$get_receiver['Address'] = json_encode($this->input->post('Address',true));
			}else{
				$get_receiver['Address'] = '';
			}

			if($this->input->post('Location',true)!=''){
				$get_receiver['Location'] = json_encode($this->input->post('Location',true));
			}else{
				$get_receiver['Location'] = '';
			}			
			$get_receiver['Note'] = $this->input->post('Note',true);
		}
		

		$data['error']=$error;
		$data['active']='entry';
		$data['submenuactive']='receiveredit';
		$data['get_receiver']= $get_receiver;
		$this->load->view('receiveredit',$data);
	}

	public function receiverview(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$error = array();
		$error['Name'] = '';
		$error['Activity'] = '';
		$error['Province'] = '';
		$error['Telphone1'] = '';
		$error['Telphone2'] = '';
		$error['Mobile1'] = '';
		$error['Mobile2'] = '';
		$error['Address'] = '';
		$error['Location'] = '';
		$error['Note'] = '';

		$msg = 0;
		$Location = $this->input->post('Location',true);
		if ($Location==''){
			$msg = 1;
		}elseif(count($Location)<1){
			$msg = 1;
		}elseif(count($Location)>0){
			foreach ($Location as $valueLocation) {
				if($valueLocation==''){
					$msg = 1;
				}
			}
		}

		$ReceiverID = @$_GET['ReceiverID'];

		$get_receiver =array();
		$get_receiver['Name'] = '';
		$get_receiver['Activity'] = '';
		$get_receiver['Province'] = '';
		$get_receiver['Telphone1'] = '';
		$get_receiver['Telphone2'] = '';
		$get_receiver['Mobile1'] = '';
		$get_receiver['Mobile2'] = '';
		$get_receiver['Address'] = '';
		$get_receiver['Location'] = '';
		$get_receiver['Note'] = '';

		if($ReceiverID){
			$get_receiver = $this->Receiversadmin->get_receiver($ReceiverID);
			$data['heading_title']='Edit receiver';
		}else{
			$data['heading_title']='Add receiver';
		}

		$data['error']=$error;
		$data['active']='entry';
		$data['submenuactive']='receiveredit';
		$data['get_receiver']= $get_receiver;
		$this->load->view('receiverview',$data);
	}

	public function deletereceiver_old(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		
		$ReceiverID = $this->uri->segment(3);
		if($ReceiverID){
			$getreceiver = $this->Receiversadmin->get_receiver($ReceiverID);

			$this->Receiversadmin->deletereceiver($ReceiverID,$data['userrole']);
			$this->session->set_flashdata('success', 'Receiver been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Receiver Delete '.$getreceiver['Name'];
			$datalog['Data'] = json_encode($getreceiver);

			$this->Receiversadmin->insert_log($datalog);
		}
		redirect('admin/receivers');
		exit();
	}

	public function deletereceiver(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		
		$ReceiverID = $_POST['DeleteID'];
		if($ReceiverID){
			$getreceiver = $this->Receiversadmin->get_receiver($ReceiverID);

			$this->Receiversadmin->deletereceiver($ReceiverID,$data['userrole']);
			$this->session->set_flashdata('success', 'Receiver been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Receiver Delete '.$getreceiver['Name'];
			$datalog['Data'] = json_encode($getreceiver);

			$this->Receiversadmin->insert_log($datalog);
		}
	
	}

	public function restorereceiver(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		
		$ReceiverID = $this->uri->segment(3);
		if($ReceiverID){
			$getreceiver = $this->Receiversadmin->get_receiver($ReceiverID);

			$datapost = array();
			$datapost['is_deleted'] = '0';

			$this->Receiversadmin->update_receiver($datapost,$ReceiverID);
			
			$this->session->set_flashdata('success', 'Receiver been Restore successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Restore';
			$datalog['Title'] = 'Receiver Restore '.$getreceiver['Name'];
			$datalog['Data'] = json_encode($getreceiver);

			$this->Receiversadmin->insert_log($datalog);
		}
		redirect('admin/receivers');
		exit();
	}

	private function validateLogin(){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			redirect('admin/logout');
			exit();   
		}
		$get_user_detail=$this->Receiversadmin->get_user_detail($this->session->userdata('UserID'));
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

