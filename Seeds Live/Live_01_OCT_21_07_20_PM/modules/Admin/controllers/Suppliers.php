<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Suppliers extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('Suppliersadmin','',TRUE);
		$this->load->library('session');
		$this->load->library('pagination');			
    } 

	public function index(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$data['heading_title']='Suppliers';
		$data['active']='entry';
		$data['submenuactive']='suppliers';
		$config = array();
		$config['base_url'] = base_url() .'admin/suppliers/';
		$config['use_page_numbers'] = false;
		$config['total_rows'] = $this->Suppliersadmin->get_suppliers_count($data['userrole']);
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
		$data["suppliers"] = $this->Suppliersadmin->get_suppliers($config["per_page"], $page,$data['userrole']);
        $data["links"] = $this->pagination->create_links();
		$this->load->view('suppliers',$data);
	}



	public function supplieredit(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$error = array();
		$error['Name'] = '';

		$get_supplier =array();
		$get_supplier['Name'] = '';
		$get_supplier['Note'] = '';
		

		$SupplierID = @$_GET['SupplierID']; 
		if($SupplierID){			
			$get_supplier = $this->Suppliersadmin->get_supplier($SupplierID);
			$data['heading_title']='Edit supplier';
		}else{
			$data['heading_title']='Add supplier';
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
				if($SupplierID){
					$getsupplier = $this->Suppliersadmin->get_supplier($SupplierID);

					$this->Suppliersadmin->update_supplier($this->input->post(),$SupplierID);
					$this->session->set_flashdata('success', 'Supplier update successfully.');

					$datalog['Activity'] = 'Update';
					$datalog['Title'] = 'Supplier Update '.$this->input->post('Name',true);
					$datalog['Data'] = json_encode($getsupplier);

				}else{

					$datapost = $this->input->post();
					$datapost['UserID'] = $this->session->userdata('UserID');
					$SupplierID = $this->Suppliersadmin->insert_supplier($datapost);
					$this->session->set_flashdata('success', 'Supplier added successfully.');
					
					$datalog['Activity'] = 'Insert';
					$datalog['Title'] = 'Supplier added '.$this->input->post('Name',true);
					$datalog['Data'] = json_encode($this->input->post());

				}
				$this->Suppliersadmin->insert_log($datalog);	
				redirect('admin/suppliers');
				exit();
			}

			$get_supplier['Name'] = $this->input->post('Name');
			$get_supplier['Note'] = $this->input->post('Note');

		}
		
		$data['error']=$error;
		$data['active']='entry';
		$data['submenuactive']='supplieredit';
		$data['get_supplier']= $get_supplier;
		$this->load->view('supplieredit',$data);
	}



	public function deletesupplier_old(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$SupplierID = $this->uri->segment(3);
		if($SupplierID){
			$getsupplier = $this->Suppliersadmin->get_supplier($SupplierID);

			$this->Suppliersadmin->deletesupplier($SupplierID,$data['userrole']);
			$this->session->set_flashdata('success', 'Supplier been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Supplier Delete '.$getsupplier['Name'];
			$datalog['Data'] = json_encode($getsupplier);

			$this->Suppliersadmin->insert_log($datalog);

		}
		redirect('admin/suppliers');
		exit();
	}

	public function deletesupplier(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$SupplierID = $_POST['DeleteID'];
		if($SupplierID){
			$getsupplier = $this->Suppliersadmin->get_supplier($SupplierID);

			$this->Suppliersadmin->deletesupplier($SupplierID,$data['userrole']);
			$this->session->set_flashdata('success', 'Supplier been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Supplier Delete '.$getsupplier['Name'];
			$datalog['Data'] = json_encode($getsupplier);

			$this->Suppliersadmin->insert_log($datalog);

		}
		
	}

	public function restoresupplier(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$SupplierID = $this->uri->segment(3);
		if($SupplierID){
			$getsupplier = $this->Suppliersadmin->get_supplier($SupplierID);
			$datapost = array();
			$datapost['is_deleted'] = '0';

			$this->Suppliersadmin->update_supplier($datapost,$SupplierID);
			
			$this->session->set_flashdata('success', 'Supplier been Restore successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Restore';
			$datalog['Title'] = 'Supplier Restore '.$getsupplier['Name'];
			$datalog['Data'] = json_encode($getsupplier);

			$this->Suppliersadmin->insert_log($datalog);

		}
		redirect('admin/suppliers');
		exit();
	}

	private function validateLogin(){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			redirect('admin/logout');
			exit();   
		}

		$get_user_detail=$this->Suppliersadmin->get_user_detail($this->session->userdata('UserID'));
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