<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edituser extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('user','',TRUE);
		$this->load->library('session');		
    } 
	
	public function index(){	
		$user_id = $this->uri->segment(3);
		$validateLogin = $this->validateLogin($user_id);
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$modules = array();
		$modules['seeds'] = 'Seeds';
		$modules['sampling'] = 'Sampling';
		$modules['evaluation'] = 'Evaluation';
		$modules['trial'] = 'Trial';
		$modules['export'] = 'Export';
		$data['modules']= $modules;

		$data['heading_title']='Edit User';
		$data['active']='users';
		$data['submenuactive']='';
	
		$get_user_detail = $this->user->get_user_detail($user_id);
		$data['user']['UserID'] = $get_user_detail['UserID'];
		$data['user']['firstname'] = $get_user_detail['firstname'];
		$data['user']['lastname'] = $get_user_detail['lastname'];
		$data['user']['username'] = $get_user_detail['username'];
		$data['user']['email'] = $get_user_detail['email'];
		if($get_user_detail['image']!=''){
			$data['user']['image'] = $get_user_detail['image'];
		}else{
			$data['user']['image'] = '';
		}
		if($get_user_detail['userpermission']!=''){
			$data['user']['userpermission'] = json_decode($get_user_detail['userpermission']);
		}else{
			$data['user']['userpermission'] = array();
		}
		$data['user']['userrole'] = $get_user_detail['userrole'];
		$data['user']['userstatus'] = $get_user_detail['userstatus'];
		$data['current_user'] = $this->session->userdata('UserID'); 
		$this->load->view('edituser',$data);
	}

	public function updateuserAjaxValidation(){
		$UserID = $this->input->post('UserID');
		$validateLogin = $this->validateLogin($UserID);

		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$userprofile_data = $this->user->get_userprofile($UserID);
		$data['image'] = $userprofile_data->image;
		if (($this->input->server('REQUEST_METHOD') == 'POST')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
			$check_password =$this->input->post('check_password');
			$arrayData = array();
			if(!empty($check_password)){
				$this->form_validation->set_rules('check_password', 'Check Password', 'required|trim');
				$this->form_validation->set_rules('newpassword', 'New Password', 'required|trim|min_length[8]');
				$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|trim|matches[newpassword]');

			}

			if ($this->form_validation->run() == FALSE) {
			    if(form_error('firstname')){
			    	$arrayData['firstname'] = form_error('firstname');
				}
				if(form_error('lastname')){
			    	$arrayData['lastname'] = form_error('lastname');
				}
				if(form_error('check_password')){
		    		$arrayData['check_password'] = form_error('check_password');
				}
				
				if(form_error('newpassword')){
			    	$arrayData['newpassword'] = form_error('newpassword');
				}elseif(form_error('confirmpassword')){
			    	$arrayData['confirmpassword'] = form_error('confirmpassword');
				}
			    $array = array(
				    'error'   => true,
				    'data' => $arrayData,
			    );
			}else{
				$UserID =$this->input->post('UserID');
				if(@$_FILES["image"]["name"] != '')
		        {	
		        	$this->user->delete_profile_image_only($UserID);
		        	$config['upload_path']   = 'uploads/UserProfile';
		            //$config['allowed_types'] = 'jpg|png|jpeg';
		            //$config['max_size'] = '3072';
		            $config['file_name'] = time()."".rand(1,1000)."_".trim(preg_replace('/\s+/', ' ', $_FILES['image']['name']));

					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if($this->upload->do_upload('image')){
		                $uploadData = $this->upload->data();
		                $this->profileresizeImage($uploadData['file_name']);                
			            $profile_image = $uploadData['file_name'];
					}else{
	              		$data = 'Sorry, there was an error uploading your file.';
	            	}
		        }else{
		        	$profile_image = $userprofile_data->image;
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

				$data=array();			
				$data['firstname'] = $this->input->post('firstname',true);
				$data['lastname'] = $this->input->post('lastname',true);
				$data['userrole'] = $this->input->post('userrole',true);
				$data['userpermission'] = $userpermission;
				$data['userstatus'] = $this->input->post('userstatus',true);
				$data['image'] = $profile_image ;

				
				if(!empty($check_password)){
					$password = $this->input->post('newpassword',true);
					$hashed_password = password_hash($password, PASSWORD_DEFAULT);	
					$data['password'] = $hashed_password;
				}

				$userprofiledata = $this->user->get_userprofile($UserID);


				$this->session->set_flashdata('success','User Updated successfully');
				$this->user->update_user($data,$UserID);

				$datalog = array();
				$datalog['UserID'] = $this->session->userdata('UserID');
				$datalog['Activity'] = 'Update';
				$datalog['Title'] = 'User Updated '.$this->input->post('firstname',true)." ".$this->input->post('lastname',true);
				$datalog['Data'] = json_encode($userprofiledata);
				$this->user->insert_log($datalog);

				$array = array(
				    'error'   => false,
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

	private function validateLogin($UserID){
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