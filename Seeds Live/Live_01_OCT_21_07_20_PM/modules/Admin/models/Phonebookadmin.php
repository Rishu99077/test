<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Phonebookadmin extends CI_Model {
	function insert_phonebook($data){
		$this->db->insert('phonebook',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function get_phonebook($limit,$offset){
		$query = $this->db->select()
						  ->from('phonebook')
						  ->limit($limit,$offset)
						  ->get();
		return $query->result_array();
	}


	function get_filter_phonebook($Name,$Email,$limit,$offset){	
        
        $this->db->order_by('PhonebookID', 'DESC');
        $FindArray = array();

        if($Name!=''){
        	$FindArray['name'] = $Name;
    	}
    	if($Email!=''){
    		$FindArray['email'] = $Email;
    	}
		
		$query = $this->db->get_where('phonebook',$FindArray,$limit,$offset);
		// print_r($this->db->last_query());
		return $query->result_array();
    }

	// public function get_phonebook($limit,$offset){
	// 	$query = $this->db->order_by("PhonebookID", "desc")->get_where('phonebook',$limit,$offset);
	// 	print_r($this->db->last_query());
	// 	return $query->result_array();
	// }

	public function get_phonebook_count($userrole=''){
		if($userrole=='1'){
			$query = $this->db->get_where('phonebook');
		}elseif($userrole=='2') {
			$query = $this->db->get_where('phonebook',array('userrole'=>$userrole));
		}else{
			$query = $this->db->get_where('phonebook');
		}
		return $query->num_rows();
	}

	function filter_phonebook_num_row($userrole='',$Name,$Email){
        $this->db->order_by('PhonebookID', 'DESC');
        $FindArray = array();
        if($Name!=''){
        	$FindArray['name'] = $Name;
    	}
    	if($Email!=''){
    		$FindArray['email'] = $Email;
    	}

        $query = $this->db->get_where("phonebook",$FindArray);
        // echo "string ".$this->db->last_query();
        return $query->num_rows();
    }

    public function get_phonebook_export($Name='',$Email=''){

		$FindArray = array();

        if($Name!=''){
        	$FindArray['name'] = $Name;
    	}
    	if($Email!=''){
        	$FindArray['email'] = $Email;
    	}	
    	
		$query = $this->db->get_where('phonebook',$FindArray);
		return $query->result_array();
	}

	public function get_user_detail($user_id){
		$query = $this->db->get_where('users',array('UserID'=>$user_id));
		$result = $query->result_array();
		return $result[0];
	}


	public function get_phonebook_detail($PhonebookID){
		$query = $this->db->get_where('phonebook',array('PhonebookID'=>$PhonebookID));
		$result = $query->result_array();
		return $result[0];
	}

	function delete_phonebook($PhonebookID){
		$this ->db-> where('PhonebookID', $PhonebookID);
    	$this ->db-> delete('phonebook');
    	return $PhonebookID;
	}

	function get_userprofile($PhonebookID){
    	$query = $this->db->get_where('phonebook',array('PhonebookID'=>$PhonebookID));
    	$result = $query->result();
   		return $result[0]; 
	}

	function delete_profile_image_only($PhonebookID){
		$query = $this->db->get_where('phonebook',array('PhonebookID'=>$PhonebookID));
		$result = $query->row();
		@$delete_image = $result->image;
		@unlink(UPLOADROOT."Phonebook/".$delete_image );
		@unlink(UPLOADROOT."Phonebook/thumbnail/".$delete_image );
	}

	public function update_phonebook($data,$PhonebookID)
	{
		$this->db->where('PhonebookID', $PhonebookID);
		$this->db->update('phonebook', $data);
	}


	public function get_names(){
		$query = $this->db->order_by("name", "asc")->get_where('phonebook');
		return $query->result_array();
	}

	public function get_suppliers(){
		$query = $this->db->order_by("email", "asc")->get_where('phonebook');
		return $query->result_array();
	}
}
?>
