<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Phonebook extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('Phonebookadmin','',TRUE);
		$this->load->library('session');
		$this->load->library('pagination');			
    }

	public function index(){
		$validateLogin = $this->validateLogin('phonebook','list');
		$data['heading_title']='Phonebook';
		$data['active']='phonebook';
		$data['submenuactive']='phonebook';

		$get_user_detail=$this->Phonebookadmin->get_user_detail($this->session->userdata('UserID'));
		$userrole= $get_user_detail['userrole'];

		$Name = $this->input->get('Name');
   		$Email = $this->input->get('Email');

   		if ($Name || $Email){
   			$total_rows = $this->Phonebookadmin->filter_phonebook_num_row($userrole,$Name,$Email);
   		}else{
   			$total_rows = $this->Phonebookadmin->get_phonebook_count($userrole);
   		} 


		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$config = array();
		$config['base_url'] = base_url() .'admin/phonebook/';
		$config['total_rows'] = $total_rows;
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

		$get_names = $this->Phonebookadmin->get_names();
		$names = array();
		$emails = array();
		foreach ($get_names as $value) {
			$names[$value['PhonebookID']] = $value['name'];
			$emails[$value['PhonebookID']] = $value['email'];
		}
	

		$data["names"]=$names;
        $data["emails"]=$emails;

        if ($Name || $Email ){
			$get_phonebook = $this->Phonebookadmin->get_filter_phonebook($Name, $Email,$config["per_page"], $page);
		}else{
			$get_phonebook = $this->Phonebookadmin->get_phonebook($config["per_page"], $page);
			
		}


		$data["phonebook"] = $get_phonebook;
        $data["links"] = $this->pagination->create_links();

		$this->load->view('phonebook',$data);
	}

	public function phonebookadd(){	
		$validateLogin = $this->validateLogin('phonebook','list');
		$data['heading_title']='Add Phonebook';
		$data['active']='phonebook';
		$data['submenuactive']='phonebookadd';

		$get_user_detail=$this->Phonebookadmin->get_user_detail($this->session->userdata('UserID'));
		$userrole= $get_user_detail['userrole'];

		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$UserID = $this->session->userdata('UserID');	
		$data['UserID'] = $UserID;
		$this->load->view('phonebookadd',$data);
	}

	public function addphonebookAjaxValidation(){
		
		if (($this->input->server('REQUEST_METHOD') == 'POST')){	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'Name', 'required|trim');
			$this->form_validation->set_rules('family_name', 'Family name', 'required|trim');

			$this->form_validation->set_rules('mobile1', 'Mobile 1', 'required|trim');
			$this->form_validation->set_rules('city', 'City', 'required|trim');
			$this->form_validation->set_rules('email', 'Email', 'required|trim');
			$this->form_validation->set_rules('issue', 'Issue', 'required|trim');
			
			
			if ($this->form_validation->run() == FALSE) {
    			$arrayData = array(
				    'name' => form_error('name'),
				    'family_name' => form_error('family_name'),
				    'mobile1' => form_error('mobile1'),
				    'city' => form_error('city'),
				    'email' => form_error('email'),
				    'issue' => form_error('issue'),
			    );
			    $array = array(
				    'error'   => true,
				    'data' => $arrayData,
			    );
			}else{
				$data=$this->input->post();
	         
				$data=array(
						'name'=>  $this->input->post('name',true),
						'family_name'=>$this->input->post('family_name',true),
						'telephone1'=>  $this->input->post('telephone1',true),
						'telephone2'=>$this->input->post('telephone2',true),
						'telephone3'=>  $this->input->post('telephone3',true),
						'mobile1'=>$this->input->post('mobile1',true),
						'mobile2'=>  $this->input->post('mobile2',true),
						'address'=>$this->input->post('address',true),
						'city'=>  $this->input->post('city',true),
						'postcode'=>$this->input->post('postcode',true),
						'email'=>  $this->input->post('email',true),
						'issue'=>$this->input->post('issue',true),
						'UserID'=>  $this->input->post('UserID',true),
					);

				$last_id = $this->Phonebookadmin->insert_phonebook($data);
				$this->session->set_flashdata('success','Phonebook added successfully');
				$array = array(
				    'error'   => false,
				    'last_id'=>$last_id,
				    'url'=>base_url('admin/phonebook')
			    );
			}
			echo json_encode($array);
			die;
		}
	}

	public function phonebookedit(){	
		$validateLogin = $this->validateLogin('phonebook','list');
		$data['heading_title']='Edit Phonebook';
		$data['active']='phonebook';
		$data['submenuactive']='phonebookedit';

		$get_user_detail=$this->Phonebookadmin->get_user_detail($this->session->userdata('UserID'));
		$userrole= $get_user_detail['userrole'];

		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$PhonebookID = $this->uri->segment(3);
		
		$get_hired_detail = $this->Phonebookadmin->get_phonebook_detail($PhonebookID);
		
		$data['phonebook']['PhonebookID'] = $get_hired_detail['PhonebookID'];
		$data['phonebook']['name'] = $get_hired_detail['name'];
		$data['phonebook']['family_name'] = $get_hired_detail['family_name'];

		$data['phonebook']['telephone1'] = $get_hired_detail['telephone1'];
		$data['phonebook']['telephone2'] = $get_hired_detail['telephone2'];
		$data['phonebook']['telephone3'] = $get_hired_detail['telephone3'];
		$data['phonebook']['mobile1'] = $get_hired_detail['mobile1'];
		$data['phonebook']['mobile2'] = $get_hired_detail['mobile2'];
		$data['phonebook']['address'] = $get_hired_detail['address'];

		$data['phonebook']['city'] = $get_hired_detail['city'];
		$data['phonebook']['postcode'] = $get_hired_detail['postcode'];
		$data['phonebook']['email'] = $get_hired_detail['email'];
		$data['phonebook']['issue'] = $get_hired_detail['issue'];
		
		$UserID = $this->session->userdata('UserID');	
		$data['UserID'] = $UserID;
		$this->load->view('phonebookedit',$data);
	}

	public function updatephonebookAjaxValidation(){
	
		$PhonebookID = $this->input->post('PhonebookID');
		$userprofile_data = $this->Phonebookadmin->get_userprofile($PhonebookID);


		if (($this->input->server('REQUEST_METHOD') == 'POST')){	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'Name', 'required|trim');
			$this->form_validation->set_rules('family_name', 'Family Name', 'required|trim');
			$this->form_validation->set_rules('mobile1', 'Mobile 1', 'required|trim');
			$this->form_validation->set_rules('city', 'City', 'required|trim');
			$this->form_validation->set_rules('email', 'Email', 'required|trim');
			$this->form_validation->set_rules('issue', 'Issue', 'required|trim');

			if ($this->form_validation->run() == FALSE) {
			    if(form_error('name')){
			    	$arrayData['name'] = form_error('name');
				}
				if(form_error('family_name')){
			    	$arrayData['family_name'] = form_error('family_name');
				}
				if(form_error('mobile1')){
			    	$arrayData['mobile1'] = form_error('mobile1');
				}
				if(form_error('city')){
			    	$arrayData['city'] = form_error('city');
				}
				if(form_error('email')){
			    	$arrayData['email'] = form_error('email');
				}
				if(form_error('issue')){
			    	$arrayData['issue'] = form_error('issue');
				}
				
			    $array = array(
				    'error'   => true,
				    'data' => $arrayData,
			    );
			}else{
				$PhonebookID =$this->input->post('PhonebookID');
				

				$data=array();			
				$data['name'] = $this->input->post('name',true);
				$data['family_name'] = $this->input->post('family_name',true);
				$data['telephone1'] = $this->input->post('telephone1',true);
				$data['telephone2'] = $this->input->post('telephone2',true);
				$data['telephone3'] = $this->input->post('telephone3',true);
				$data['mobile1'] = $this->input->post('mobile1',true);
				$data['mobile2'] = $this->input->post('mobile2',true);
				$data['address'] = $this->input->post('address',true);
				$data['city'] = $this->input->post('city',true);
				$data['postcode'] = $this->input->post('postcode',true);
				$data['email'] = $this->input->post('email',true);
				$data['issue'] = $this->input->post('issue',true);
				
			
				$this->session->set_flashdata('success','Phonebook Updated successfully');
				$this->Phonebookadmin->update_phonebook($data,$PhonebookID);
				$array = array(
				    'error'   => false,
			    );
			}
			echo json_encode($array);
			die;
		}
	}

	// private function validateLogin(){
	// 	if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
	// 		$array_items = array('UserID' =>'','logged_in' =>false);
	// 		$this->session->unset_userdata($array_items);
	// 		redirect('admin/login');
	// 		exit();   
	// 	}
	// }


	function phonebookexport(){
		$validateLogin = $this->validateLogin('phonebook','list');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$Name = $this->input->get('Name');
   		$Email = $this->input->get('Email');

   		if ($Name!='' || $Email!=''){
			$get_phonebook = $this->Phonebookadmin->get_phonebook_export($Name,$Email);
		}else{
			$get_phonebook = $this->Phonebookadmin->get_phonebook_export();
		}
        
		if(count($get_phonebook)>0){
			$this->ExportFile($get_phonebook);
		}
		redirect('admin/phonebook');
		exit(); 
	}

	function ExportFile($records){
		require_once dirname(__FILE__) . '/../../../../PHPExcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("SHIMI YAZD Co.")
							 ->setLastModifiedBy("SHIMI YAZD Co.")
							 ->setTitle("Phonebookreport")
							 ->setSubject("Phonebookreport")
							 ->setDescription("Phonebookreport")
							 ->setKeywords("Phonebookreport")
							 ->setCategory("Phonebookreport");

		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0,1,'Name')
            ->setCellValueByColumnAndRow(1,1,'Family_name')
            ->setCellValueByColumnAndRow(2,1,'Mobile')
            ->setCellValueByColumnAndRow(3,1,'Address')
            ->setCellValueByColumnAndRow(4,1,'City')
            ->setCellValueByColumnAndRow(5,1,'Postcode')
            ->setCellValueByColumnAndRow(6,1,'Email')
            ->setCellValueByColumnAndRow(7,1,'Issue');

        $row = 2;
		foreach($records as $rec) {
			$col = 0;   
		    foreach ($rec as $value) {  
        		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
        		$col++;  
    		}   
		    $row++;
		} 
		    
        $objPHPExcel->getActiveSheet()->setTitle('Phonebookreport');
        $objPHPExcel->setActiveSheetIndex(0);
  //       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8');
		header('Content-Disposition: attachment;filename="Phonebookreport.csv"');
		// header('Cache-Control: max-age=0');
		// //header('Cache-Control: max-age=1');
		// header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		// header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		// header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		// header ('Pragma: public'); // HTTP/1.0

		//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;				 
	} 

	private function validateLogin($module='',$type=''){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			redirect('admin/logout');
			exit();   
		}
		$get_user_detail=$this->Phonebookadmin->get_user_detail($this->session->userdata('UserID'));
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

	public function deletephonebook(){
		$PhonebookID = $this->uri->segment(3);
		$PhonebookID = $this->Phonebookadmin->delete_phonebook($PhonebookID);
		if($PhonebookID)
		{
			$this->session->set_flashdata('success', 'Phonebook have been Deleted successfully.');
			redirect('admin/phonebook');
			exit();
		}
	}
}
