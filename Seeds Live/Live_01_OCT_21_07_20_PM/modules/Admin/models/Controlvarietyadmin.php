<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Controlvarietyadmin extends CI_Model {
	function insert_controlvariety($data){
		$this->db->insert('controlvariety',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function update_controlvariety($data,$ControlvarietyID){
		$this->db->where('ControlvarietyID', $ControlvarietyID);
		$this->db->update('controlvariety', $data);
	}	

	public function get_controlvariety_count($userrole=''){
		if($userrole=='1'){
			$query = $this->db->get('controlvariety');
		}else{
			$query = $this->db->get_where('controlvariety',array('is_deleted'=>'0'));
		}	
		return $query->num_rows();
	}

	public function get_controlvariety($limit,$offset,$userrole=''){
		if($userrole=='1'){
			$query = $this->db->get('controlvariety',$limit,$offset);
		}else{
			$query = $this->db->get_where('controlvariety',array('is_deleted'=>'0'),$limit,$offset);
		}	
		return $query->result_array();
	}	

	public function get_single_controlvariety($ControlvarietyID){
		$query = $this->db->get_where('controlvariety',array('ControlvarietyID'=>$ControlvarietyID));
		$result = $query->result_array();
		return $result[0];
	}

	public function deletecontrolvariety($ControlvarietyID,$userrole=''){
		$this->db->where('ControlvarietyID',$ControlvarietyID);
		if($userrole=='1'){
			$this->db->delete('controlvariety');
		}else{
			$data = array('is_deleted'=>'1');
			$this->db->update('controlvariety', $data);
		}
	}

	public function get_crops(){
		$query = $this->db->get_where('crops',array('is_deleted'=>'0'));
		return $query->result_array();
	}

	public function get_seeds(){
		$query = $this->db->get_where('seeds',array('is_deleted'=>'0'));
		return $query->result_array();
	}

	public function get_user_detail($user_id){
		$query = $this->db->get_where('users',array('UserID'=>$user_id));
		$result = $query->result_array();
		return $result[0];
	}

	public function insert_log($data){
		$datalog = array();
	 	$datalog['ipaddress'] = $this->get_client_ip();
	    $datalog['Source'] = 'ADMIN';
	    $datalog['Module'] = 'Controlvariety';
	    $datalog['UserID'] = $data['UserID'];
	    $datalog['Activity'] = $data['Activity'];
	    $datalog['Title'] = $data['Title'];
	    $datalog['Data'] = $data['Data'];
	    $datalog['Createdate'] = date("d-m-Y h:i:s a");
		$this->db->insert('logs',$datalog);
		$this->db->insert_id();
	}	

	private function get_client_ip() {
	     $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}
}
?>