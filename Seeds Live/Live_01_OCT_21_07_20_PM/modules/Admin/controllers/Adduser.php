<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adduser extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('user','',TRUE);
		$this->load->library('session');		
    } 
    
	public function index(){	
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$modules = array();
		$modules['seeds'] = 'Seeds';
		$modules['sampling'] = 'Sampling';
		$modules['evaluation'] = 'Evaluation';
		$modules['trial'] = 'Trial';
		$modules['export'] = 'Export';
		$data['modules']= $modules;

		$data['heading_title']='Add User';
		$data['active']='users';
		$data['submenuactive']='adduser';
		$this->load->view('adduser',$data);
	}

	public function adduserAjaxValidation(){
		$validateLogin = $this->validateLogin();
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		if (($this->input->server('REQUEST_METHOD') == 'POST')){	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
			/*if (empty($_FILES['image']['name'])) { 
			$this->form_validation->set_rules('image', 'Image', 'required');
			}*/
			$this->form_validation->set_rules('username', 'User Name', 'required|trim|min_length[5]|is_unique[users.username]');
			$this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email|is_unique[users.email]');
			$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]');
			$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|required|matches[password]');
			if ($this->form_validation->run() == FALSE) {
    			$arrayData = array(
				    'firstname' => form_error('firstname'),
				    'lastname' => form_error('lastname'),
				    //'image' => form_error('image'),
				    'username' => form_error('username'),
				    'email' => form_error('email'),
				    'password' => form_error('password'),
				    'confirmpassword' => form_error('confirmpassword'),
			    );
			    $array = array(
				    'error'   => true,
				    'data' => $arrayData,
			    );
			}else{
				$data=$this->input->post();
				

				$password = $this->input->post('password',true);
				$hashed_password = password_hash($password, PASSWORD_DEFAULT);
				if (empty($_FILES['image']['name'])) {
					$image = '';
				}else{ 
					$config['upload_path']   = 'uploads/UserProfile';
		            //$config['allowed_types'] = 'jpg|png|jpeg';
		            //$config['max_size'] = '3072';
		            $config['file_name'] = time()."".rand(1,1000)."_".trim(preg_replace('/\s+/', ' ', $_FILES['image']['name']));

					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if($this->upload->do_upload('image')){
		                $uploadData = $this->upload->data();
		                $this->profileresizeImage($uploadData['file_name']);                
			            $image = $uploadData['file_name'];
					}else{
	              		$image = '';
	            	}
	            }	


	            if ($this->input->post('userpermission',true)!=''){
	            	$userpermissionpost = $this->input->post('userpermission',true);
		        	$userrolepost = $this->input->post('userrole',true);
		        	$userpermissionpostarr = array();
	        		foreach ($userpermissionpost as $userpermissionpostvalue) {
	        			if($userrolepost=='5'){
	        				if($userpermissionpostvalue=='evaluation'){
	        					$userpermissionpostarr[] = $userpermissionpostvalue;
	        				}elseif($userpermissionpostvalue=='trial'){
	        					$userpermissionpostarr[] = $userpermissionpostvalue;	
	        				}
	        			}else{
	        				$userpermissionpostarr[] = $userpermissionpostvalue;
	        			}
	        		}

	        		if(count($userpermissionpostarr)>0){
	            		$userpermission = json_encode($userpermissionpostarr);
	        		}else{
	            		$userpermission = '';
	            	}
	            }else{
	            	$userpermission = '';
	            }

				$data=array(
						'firstname'=>  $this->input->post('firstname',true),
						'lastname'=> $this->input->post('lastname',true),
						'username'=>$this->input->post('username',true),	
						'email'=>$this->input->post('email',true),
						'password'=>$hashed_password,
						'image'=>$image,
						'userrole'=>$this->input->post('userrole',true),
						'userpermission'=>$userpermission,
						'userstatus'=>$this->input->post('userstatus',true),
						'createdby' => $this->session->userdata('UserID')
					);

				$this->session->set_flashdata('success','User added successfully');
				$last_id = $this->user->insert_user($data);

				$datalog = array();
				$datalog['UserID'] = $this->session->userdata('UserID');
				$datalog['Activity'] = 'Insert';
				$datalog['Title'] = 'New User added '.$this->input->post('firstname',true)." ".$this->input->post('lastname',true);
				$datalog['Data'] = json_encode($data);
				$this->user->insert_log($datalog);


				$array = array(
				    'error'   => false,
				    'last_id'=>$last_id,
				    'url'=>base_url('admin/users')
			    );
			}
			echo json_encode($array);
			die;
		}
	}

	public function profileresizeImage($filename){
      $source_path = UPLOADROOT . 'UserProfile/' . $filename;
      $target_path = UPLOADROOT . 'UserProfile/thumbnail/';
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
      if (!$this->image_lib->resize()) {
          echo $this->image_lib->display_errors();
      }
      $this->image_lib->clear();
   	}

	private function validateLogin(){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			redirect('admin/logout');
			exit();   
		}
		$get_user_detail=$this->user->get_user_detail($this->session->userdata('UserID'));
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