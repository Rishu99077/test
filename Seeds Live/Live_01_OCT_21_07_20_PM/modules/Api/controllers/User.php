<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('Userapi','',TRUE);
		$this->load->library('session');
		$this->load->library('email');
    } 
	public function index(){
		$output=array();
		$output['status']=false;

		if((!empty($this->input->get('access_token'))) && file_get_contents(base_url().'resource.php?access_token='.$this->input->get('access_token'))){

				if(empty($this->input->post('username',true))){
					$output['message']  ='Username fields is required';
					echo json_encode($output);
					die;
				}elseif(empty($this->input->post('ipaddress',true))){
						$output['message']  ='ipaddress field is required';
						echo json_encode($output);
						die;
				}elseif(empty($this->input->post('password',true))){
						$output['message']  ='Password field is required';
						echo json_encode($output);
						die;
				}
				$username = $this->input->post('username',true);
				$password = $this->input->post('password',true);
				$UserID = $this->Userapi->login($username,$password);

				$datalog = array();
				$datalog['UserID'] = $UserID;
				$datalog['ipaddress'] = $this->input->post('ipaddress',true);
				$datalog['Activity'] = 'Login';
				
				if($UserID){
					$getuser = $this->Userapi->getuser($UserID);
					if($getuser['userstatus']=='0'){
						$output['message'] = "Your account not activated yet!";
					}elseif($this->validateLogin($getuser)){
						$user_permission= $getuser['userpermission'];
						if($user_permission!=''){
							$user_permission1 = json_decode($user_permission);
							$userpermission = array();
							if(in_array('evaluation', $user_permission1)){
								$userpermission[] = 'evaluation';
							}
							if(in_array('trial', $user_permission1)){
								$userpermission[] = 'trial';
							}
						}else{	
							$userpermission= array();
						}
						$output['status']=true;
						$output['userid']= (int)$UserID;
						$output['username']= $getuser['username'];
						$output['email']= $getuser['email'];
						$output['firstname']= $getuser['firstname'];
						$output['lastname']= $getuser['lastname'];
						$output['mobilenumber']= $getuser['mobilenumber'];
						$output['userstatus']= $getuser['userstatus'];
						if($getuser['image']!=''){
							$output['image'] = base_url().'uploads/UserProfile/thumbnail/'.$getuser['image'];
						}else{
							$output['image'] = base_url().'adminasset/images/userlogo.png';
						}
						$output['userrole']= (int)$getuser['userrole'];
						$output['userpermission']= $userpermission;
						$output['message'] = 'Login Successfully';
						$datalog['Title'] = 'Login username: '.$this->input->post('username',true);
					}else{
						$output['message'] = "You don't have permission to access the account!";
						$datalog['Title'] = $this->input->post('username',true)." don't have permission to access the account!";
					}	
				}else{
					$output['message'] = 'Username and Password is incorrect.';
					$datalog['Title'] = $this->input->post('username',true)." Username and Password is incorrect.!";
				}
				$datalog['Data'] = json_encode($this->input->post());
				$this->Userapi->insert_log($datalog);			
		}else{
			$output['message'] = '405';
		}	
		echo json_encode($output);
		die;	
	}	
	
	private function validateLogin($user){
		$userrole= $user['userrole'];
		$user_permission= $user['userpermission'];
		if($user_permission!=''){
			$user_permission1 = json_decode($user_permission);
			$userpermission = array();
			if(in_array('evaluation', $user_permission1)){
				$userpermission[] = 'evaluation';
			}
			if(in_array('trial', $user_permission1)){
				$userpermission[] = 'trial';
			}
		}else{	
			$userpermission= array();
		}

		if($userrole=='5' || $userrole=='7'){
			if(count($userpermission)>0){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}