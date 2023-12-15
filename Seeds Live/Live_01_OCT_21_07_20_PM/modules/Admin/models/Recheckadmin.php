<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Recheckadmin extends CI_Model {

	function insert_recheck($data){
		$this->db->insert('recheck',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	function insert_requestdate($data){
		$this->db->insert('requestdate',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function update_recheck($data,$RecheckID){
		$this->db->where('RecheckID', $RecheckID);
		$this->db->update('recheck', $data);
	}	

	public function update_evaluation($data,$EvaluationID){
		$this->db->where('EvaluationID', $EvaluationID);
		$this->db->update('evaluation', $data);
	}	

	public function update_recheck_status($data,$RecheckID){
		$this->db->where('RecheckID', $RecheckID);
		$this->db->set('request_count', 'request_count+1', FALSE);
		$this->db->update('recheck', $data);
	}	

	public function update_seed($data,$SeedID){
		$this->db->where('SeedID', $SeedID);
		$this->db->update('seeds', $data);
	}


	public function get_recheck_count($userrole=''){
		if($userrole=='1'){
			$query = $this->db->get('recheck');
		}else{
			$query = $this->db->get_where('recheck',array('is_deleted'=>'0'));
		}	
		return $query->num_rows();
	}

	function filter_get_recheck_count($userrole='',$Crop,$Supplier){
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
	        
	        $query = $this->db->get_where("recheck",$FindArray);
	        //echo $this->db->last_query();
	        return $query->num_rows();
	    }

	public function get_recheck($limit,$offset,$userrole=''){
		if($userrole=='1'){
			$query = $this->db->get('recheck',$limit,$offset);
		}else{
			$query = $this->db->get_where('recheck',array('is_deleted'=>'0'),$limit,$offset);
		}					  
		return $query->result_array();
	}

	function filter_get_recheck($userrole='',$Crop,$Supplier,$limit,$offset){
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
    	
        $this->db->order_by('RecheckID', 'DESC');
		$query = $this->db->get_where('recheck',$FindArray,$limit,$offset);
		// print_r($this->db->last_query());
		return $query->result_array();
    }

	public function get_single_recheck($RecheckID){
		$query = $this->db->get_where('recheck',array('RecheckID'=>$RecheckID));
		$num = $query->num_rows();
		if($num>0){
			$result = $query->result_array();
			return $result[0];
		}else{
			return false;
		}
	}

	public function deleterecheck($RecheckID,$userrole=''){
		$this->db->where('RecheckID',$RecheckID);
		if($userrole=='1'){
			$this->db->delete('recheck');
		}else{
			$data = array('is_deleted'=>'1');
			$this->db->update('recheck', $data);
		}	
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

	public function get_crops(){
		$query = $this->db->get_where('crops',array('is_deleted'=>'0'));
		return $query->result_array();
	}
	public function get_crop($CropID){
		$query = $this->db->get_where('crops',array('CropID'=>$CropID));
		$num = $query->num_rows();
		if($num>0){
			$result = $query->result_array();
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


	public function get_suppliers(){
		$query = $this->db->get_where('suppliers',array('is_deleted'=>'0'));
		return $query->result_array();
	}

	public function get_supplier_id($Supplier){
		$query = $this->db->get_where('suppliers',array('Name'=>$Supplier,'is_deleted'=>'0'));
		$num = $query->num_rows();
		if($num>0){
			$result = $query->result_array();
			return $result[0];
		}else{
			return false;
		}
	}
	
	public function get_supplier($SupplierID){
		$query = $this->db->get_where('suppliers',array('SupplierID'=>$SupplierID));
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
		$num = $query->num_rows();
		if($num>0){
			$result = $query->result_array();
			return $result[0];
		}else{
			return false;
		}
	}

	public function insert_log($data){
		$datalog = array();
	 	$datalog['ipaddress'] = $this->get_client_ip();
	    $datalog['Source'] = 'ADMIN';
	    $datalog['Module'] = 'Recheck';
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

	// development

	public function get_recheck_sampling($SeedID){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0','Seed'=>$SeedID));
		return $query->result_array();
	}

	public function get_seed_number($SeedID){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0','Seed'=>$SeedID));
		// print_r($this->db->last_query());
		return $query->num_rows();
		// if($query->num_rows()>0){
		// 	$result = $query->result_array();
		// 	return $result[0];
		// }else{
		// 	return false;
		// }
	}

	// public function get_recheck_sampling_number($SeedID,$Variety){
 //        $this->db->select('*');
	// 	$this->db->from('recheck');
	// 	$this->db->join('seeds', 'recheck.Variety = seeds.Variety', 'inner');

	// 	$query = $this->db->get();
	// 	echo $this->db->last_query();
	// 	return $query->num_rows();
	// }


	public function get_recheck_id($userrole='',$Variety=''){
		if($userrole=='1'){
			$query = $this->db->get_where('recheck',array('Variety'=>$Variety));
		}else{
			$query = $this->db->get_where('recheck',array('is_deleted'=>'0','Variety'=>$Variety));
		}
		// print_r($this->db->last_query());					  
		return $query->result_array();
	}

	public function get_recheck_evaluation($Internalsamplingcode){
		$query = $this->db->get_where('evaluation',array('Internalsamplecode'=>$Internalsamplingcode));
		// print_r($this->db->last_query());
		$result = $query->result_array();
		return $result;
		
	}

	public function get_users($UserID){
		$query = $this->db->get_where('users',array('UserID'=>$UserID));
		$query->num_rows();
		if($query->num_rows()>0){
			$result = $query->result_array();
			return $result[0];
		}else{
			return false;
		}	
	}
	
	public function get_seed_id($Variety){
		$query = $this->db->get_where('seeds',array('Variety'=>$Variety,'is_deleted'=>'0'));
		$num = $query->num_rows();
		if($num>0){
			$result = $query->result_array();
			return $result[0];
		}else{
			return false;
		}
	}

	public function get_date($EvaluationID){
		// $query = $this->db->group_by('requestDate');
		$query = $this->db->get_where('requestdate',array('EvaluationID'=>$EvaluationID));
		$num = $query->num_rows();
		if($num>0){
			$result = $query->result_array();
			return $result;
		}else{
			return false;
		}
	}

	 public function total_amount($SeedID) {
        
        $query = $this->db->get_where('sampling',array('Seed'=>$SeedID));

	    if ( $query->num_rows() > 0 )
	    {
	        $row = $query->result_array();
	        return $row;
	    }
  	}

  	public function get_seeds(){
		$query = $this->db->get_where('seeds',array('is_deleted'=>'0'));
		return $query->result_array();
	}

	public function get_seed_by_crop($Crop){
		$data =array();
		$data['is_deleted']='0';
		$data['Crop']=$Crop;
		$query = $this->db->get_where('seeds',$data);
		return $query->result_array();
	}


	public function get_variety($Variety){
		$query = $this->db->get_where('seeds',array('Variety'=>$Variety));
		$num = $query->num_rows();
		if($num>0){
			$result = $query->result_array();
			return $result[0];
		}else{
			return false;
		}
	}

	public function get_internalsamplingcode($SeedID){
		$query = $this->db->get_where('sampling',array('Seed'=>$SeedID,'is_deleted'=>'0'));
		$num = $query->num_rows();
		if($num>0){
			$result = $query->result_array();
			return $result[0];
		}else{
			return false;
		}
	}

	public function get_recheck_info($EvaluationID){
		$query = $this->db->get_where('recheck',array('EvaluationID'=>$EvaluationID));					  
		return $query->result_array();
	}

	public function update_recheck_evaluations($data,$EvaluationID){
		$this->db->where('EvaluationID', $EvaluationID);
		$this->db->update('recheck', $data);
	}	
}
?>