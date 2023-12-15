<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Receiversadmin extends CI_Model {
	function insert_receiver($data){
		$this->db->insert('receivers',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function update_receiver($data,$ReceiverID){
		$this->db->where('ReceiverID', $ReceiverID);
		$this->db->update('receivers', $data);
	}	

	public function get_receivers_count($userrole=''){
		if($userrole=='1'){
			$query = $this->db->get('receivers');
		}else{
			$query = $this->db->get_where('receivers',array('is_deleted'=>'0'));
		}	
		return $query->num_rows();
	}

	public function get_receivers($limit,$offset,$userrole=''){
		$this->db->order_by('ReceiverID', 'DESC');
		if($userrole=='1'){
			$query = $this->db->get('receivers',$limit,$offset);
		}else{
			$query = $this->db->get_where('receivers',array('is_deleted'=>'0'),$limit,$offset);
		}					  
		return $query->result_array();
	}

	public function get_receivers_all($userrole=''){
		if($userrole=='1'){
			$query = $this->db->get('receivers');
		}else{
			$query = $this->db->get_where('receivers',array('is_deleted'=>'0'));
		}	
		return $query->result_array();
	}	

	public function get_receiver($ReceiverID){
		$query = $this->db->get_where('receivers',array('ReceiverID'=>$ReceiverID));
		$result = $query->result_array();
		return $result[0];
	}
	public function deletereceiver($ReceiverID,$userrole=''){
		$this->db->where('ReceiverID',$ReceiverID);
		if($userrole=='1'){
			$this->db->delete('receivers');
		}else{
			$data = array('is_deleted'=>'1');
			$this->db->update('receivers', $data);
		}	
	}
	public function get_user_detail($user_id){
		$query = $this->db->get_where('users',array('UserID'=>$user_id));
		$result = $query->result_array();
		return $result[0];
	}

	function filter_receivers_num_row($Name,$Province,$Mobile1,$userrole='')
    {
    	$FindArray = array();
        if($userrole=='1'){
        }else{
        	$FindArray['is_deleted'] = '0';
        }

        if($Name!=''){
    		$name_array = array('Name' => $Name);
    		$this->db->like($name_array);
    	}

        if($Province!=''){
    		$Province_array = array('Province' => $Province);
    		$this->db->like($Province_array);
    	}

    	if($Mobile1!=''){
    		$Mobile1_array = array('Mobile1' => $Mobile1);
    		$this->db->like($Mobile1_array);
    	}

        $this->db->order_by('ReceiverID', 'DESC');
        $query = $this->db->get_where("receivers",$FindArray);
        return $query->num_rows();
    }

    function get_filter_receivers($Name,$Province,$Mobile1,$limit,$offset,$userrole='')
    {
        $FindArray = array();
        if($userrole=='1'){
        }else{
        	$FindArray['is_deleted'] = '0';
        }

        if($Name!=''){
    		$name_array = array('Name' => $Name);
    		$this->db->like($name_array);
    	}

        if($Province!=''){
    		$Province_array = array('Province' => $Province);
    		$this->db->like($Province_array);
    	}

    	if($Mobile1!=''){
    		$Mobile1_array = array('Mobile1' => $Mobile1);
    		$this->db->like($Mobile1_array);
    	}
        $this->db->order_by('ReceiverID', 'DESC');
		$query = $this->db->get_where('receivers',$FindArray,$limit,$offset);
		return $query->result_array();
    }

    public function insert_log($data){
		$datalog = array();
	 	$datalog['ipaddress'] = $this->get_client_ip();
	    $datalog['Source'] = 'ADMIN';
	    $datalog['Module'] = 'Receiver';
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