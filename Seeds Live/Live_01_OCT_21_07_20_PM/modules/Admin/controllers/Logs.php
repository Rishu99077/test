<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('user','',TRUE);
		$this->load->model('Logsadmin','',TRUE);
		$this->load->library('session');
		$this->load->library('pagination');			
    } 
	public function index(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$data['heading_title']='Logs';
		$data['active']='extra';
		$data['submenuactive']='logs';

		$config = array();
		$config['base_url'] = base_url() .'admin/logs/';
		$config['use_page_numbers'] = false;
		$config['total_rows'] = $this->Logsadmin->get_logs_count();
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
		$logs = array();
		$get_logs = $this->Logsadmin->get_logs($config["per_page"], $page);
		foreach ($get_logs as $value) {
			$log = array();
			$getuserdetail=$this->Logsadmin->get_user_detail($value->UserID);
			if($getuserdetail){
				$log['username'] = $getuserdetail['username'];
			}else{
				$log['username'] = '';
			}

			$log['ipaddress'] = $value->ipaddress;
			$log['Source'] = $value->Source;
			$log['Module'] = $value->Module;
			$log['Activity'] = $value->Activity;
			$log['Title'] = $value->Title;
			$log['Createdate'] = $value->Createdate;
			$logs[] = $log;
		}
		$data["logs"] = $logs;
        $data["links"] = $this->pagination->create_links();

		$this->load->view('logs',$data);
	}

	public function clearlogs(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$this->db->empty_table('logs');
		redirect('admin/logs');
		exit();
	}

	private function validateLogin(){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			redirect('admin/logout');
			exit();   
		}
		$get_user_detail=$this->Logsadmin->get_user_detail($this->session->userdata('UserID'));
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