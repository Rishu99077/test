<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Suppliersadmin extends CI_Model {
	function insert_supplier($data){
		$this->db->insert('suppliers',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	public function update_supplier($data,$SupplierID){
		$this->db->where('SupplierID', $SupplierID);
		$this->db->update('suppliers', $data);
	}	
	public function get_suppliers_count($userrole=''){
		if($userrole=='1'){
			$query = $this->db->order_by("SupplierID", "desc")->get('suppliers');
		}else{
			$query = $this->db->order_by("SupplierID", "desc")->get_where('suppliers',array('is_deleted'=>'0'));
		}	
		return $query->num_rows();
	}
	public function get_suppliers($limit,$offset,$userrole=''){
		if($userrole=='1'){
			$query = $this->db->order_by("Name", "asc")->get('suppliers',$limit,$offset);
		}else{
   			$query = $this->db->order_by("Name", "asc")->get_where('suppliers',array('is_deleted'=>'0'),$limit,$offset);	
   		}
		return $query->result_array();
	}	
	public function get_supplier($SupplierID){
		$query = $this->db->get_where('suppliers',array('SupplierID'=>$SupplierID));
		$result = $query->result_array();
		return $result[0];
	}

	public function deletesupplier($SupplierID,$userrole=''){
		$this->db->where('SupplierID',$SupplierID);
		if($userrole=='1'){
			$this->db->delete('suppliers');
		}else{
			$data = array('is_deleted'=>'1');
			$this->db->update('suppliers', $data);
		}	
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
	    $datalog['Module'] = 'Supplier';
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