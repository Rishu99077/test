<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Userapi extends CI_Model {
	
	function login($username,$password){
		//$this->db->where('userstatus', 1);
		$this->db->where("(username='$username')", NULL, FALSE);
		$query = $this->db->get('users');
		//print_r($query);
		if($query->num_rows()>0){
			$rows = $query->row();
			$hashed_password = $rows->password;
			if(password_verify($password, $hashed_password)){	
				$newdata = array(
					'UserID' 	=> $rows->UserID,
					'logged_in' => TRUE,
				);
				$this->session->set_userdata($newdata);
				return $rows->UserID;  
				
			}else{
				return false;
			}
		}
		return false;
	}

	function getuser($UserID){
		$this->db->where('UserID', $UserID);
		$query = $this->db->get('users');
		$result = $query->result_array();
		return $result[0];
	}

	public function insert_log($data){
		$datalog = array();
	 	$datalog['ipaddress'] = $data['ipaddress'];
	    $datalog['Source'] = 'APP';
	    $datalog['Module'] = 'User';
	    $datalog['UserID'] = $data['UserID'];
	    $datalog['Activity'] = $data['Activity'];
	    $datalog['Title'] = $data['Title'];
	    $datalog['Data'] = $data['Data'];
	    $datalog['Createdate'] = date("d-m-Y h:i:s a");
		$this->db->insert('logs',$datalog);
		$this->db->insert_id();
	}
	
}
?>
