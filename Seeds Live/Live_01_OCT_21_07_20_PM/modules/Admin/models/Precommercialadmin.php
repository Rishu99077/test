<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Precommercialadmin extends CI_Model {
	function insert_precommercial($data){
		$this->db->insert('precommercial',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function update_precommercial($data,$PrecommercialID){
		$this->db->where('PrecommercialID', $PrecommercialID);
		$this->db->update('precommercial', $data);
	}	

	public function get_precommercial_count($userrole=''){
		if($userrole=='1'){
			$query = $this->db->get('precommercial');
		}else{
			$query = $this->db->get_where('precommercial',array('is_deleted'=>'0'));
		}	
		return $query->num_rows();
	}

	function filter_get_precommercial_count($userrole='',$Crop,$Supplier){
	    	$FindArray = array();
	        if($userrole=='1'){
	        }else{
	        	$FindArray['is_deleted'] = '0';
	        }

	        if($Crop!=''){
	        	$FindArray['Crop'] = $Crop;
	    	}
	    	if($Supplier!=''){
	        	$FindArray['Supplier'] = $Supplier;
	    	}
	        
	        $query = $this->db->get_where("precommercial",$FindArray);
	        //echo $this->db->last_query();
	        return $query->num_rows();
	    }

	public function get_precommercial($limit,$offset,$userrole=''){
		if($userrole=='1'){
			$query = $this->db->get('precommercial',$limit,$offset);
		}else{
			$query = $this->db->get_where('precommercial',array('is_deleted'=>'0'),$limit,$offset);
		}				  
		return $query->result_array();
	}

	function filter_get_precommercial($userrole='',$Crop,$Supplier,$limit,$offset){
    	$FindArray = array();
        if($userrole=='1'){
        }else{
        	$FindArray['is_deleted'] = '0';
        }

        if($Crop!=''){
        	$FindArray['Crop'] = $Crop;
    	}
    	if($Supplier!=''){
        	$FindArray['Supplier'] = $Supplier;
    	}
    	
        $this->db->order_by('PrecommercialID', 'DESC');
		$query = $this->db->get_where('precommercial',$FindArray,$limit,$offset);
		print_r($this->db->last_query());
		return $query->result_array();
    }	

	public function get_single_precommercial($PrecommercialID){
		$query = $this->db->get_where('precommercial',array('PrecommercialID'=>$PrecommercialID));
		$result = $query->result_array();
		return $result[0];
	}

	public function deleteprecommercial($PrecommercialID,$userrole=''){
		$this->db->where('PrecommercialID',$PrecommercialID);
		if($userrole=='1'){
			$this->db->delete('precommercial');
		}else{
			$data = array('is_deleted'=>'1');
			$this->db->update('precommercial', $data);
		}	
	}
	
	public function get_crops(){
		$query = $this->db->get_where('crops',array('is_deleted'=>'0'));
		return $query->result_array();
	}
	public function get_suppliers(){
		$query = $this->db->get_where('suppliers',array('is_deleted'=>'0'));
		return $query->result_array();
	}
	public function get_crop($CropID){
		$query = $this->db->get_where('crops',array('CropID'=>$CropID));
		$result = $query->result_array();
		return $result[0];
	}
	public function get_supplier($SupplierID){
		$query = $this->db->get_where('suppliers',array('SupplierID'=>$SupplierID));
		$result = $query->result_array();
		return $result[0];
	}

	public function get_evaluation($EvaluationID){
		$query = $this->db->get_where('evaluation',array('EvaluationID'=>$EvaluationID));
		$result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }else{
        	return false;
        }
	}

	public function get_sampling($Internalsamplingcode){
		$query = $this->db->get_where('sampling',array('Internalsamplingcode'=>$Internalsamplingcode));
		$result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }else{
        	return false;
        }
	}

	public function get_seed($SeedID){
		$query = $this->db->get_where('seeds',array('SeedID'=>$SeedID,'is_deleted'=>'0'));
		$num = $query->num_rows();
		if($num>0){
			$result = $query->result_array();
			return $result[0];
		}else{
			return false;
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
	    $datalog['Module'] = 'Precommercial';
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