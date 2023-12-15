<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Seedsadmin extends CI_Model {
	function insert_seed($data){
		$this->db->insert('seeds',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function update_seed($data,$SeedID){
		$this->db->where('SeedID', $SeedID);
		$this->db->update('seeds', $data);
	}	

	public function get_seeds_count($userrole=''){
		if($userrole=='1'){
			$query = $this->db->get('seeds');
		}elseif($userrole=='2') {
			$query = $this->db->get_where('seeds',array('is_deleted'=>'0','userrole'=>$userrole));
		}else{
			$query = $this->db->get_where('seeds',array('is_deleted'=>'0'));
		}	
		return $query->num_rows();
	}

	public function get_sampling_count($SeedID){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0','Seed'=>$SeedID));
		return $query->num_rows();
	}

	public function get_samplingstock_count($SeedID){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0','Seed'=>$SeedID));
		$result = $query->result_array();
		$count = 0;
		$cnt = 0;
		foreach ($result as  $value) {
			$Stockquantityfor = $value['Stockquantityfor'];
			$Stockquantity = $value['Stockquantity'];
			if($Stockquantityfor=='2'){
				$count += $Stockquantity;
			}elseif($Stockquantityfor=='0'){
				$count += $Stockquantity;
			}elseif($Stockquantityfor=='1'){
				$countStockquantity = $Stockquantity*1000;
				$count += $countStockquantity;		
			}
			$cnt++;
		}
		$response = array();
		$response['count'] = $count;
		$response['cnt'] = $cnt;
		return $response;	
	}


	public function get_seeds($limit,$offset,$userrole=''){
		$this->db->order_by('SeedID', 'DESC');
		if($userrole=='1'){
			$query = $this->db->get('seeds',$limit,$offset);
		}elseif($userrole=='2') {
			$query = $this->db->order_by("SeedID", "DESC")->get_where('seeds',array('is_deleted'=>'0','userrole'=>$userrole),$limit,$offset);
		}else{
			$query = $this->db->get_where('seeds',array('is_deleted'=>'0'),$limit,$offset);	
		}			  
		return $query->result_array();
	}
	// public function get_seeds_all(){
	// 	$this->db->select('Variety');
	// 	$this->db->distinct();
	// 	$query = $this->db->get_where('seeds',array('is_deleted'=>'0'));				  
	// 	return $query->result_array();
	// }
	
	public function get_seeds_all(){
		$query = $this->db->get_where('seeds',array('is_deleted'=>'0'));				  
		return $query->result_array();
	}

	public function get_seeds_export($userrole='',$Crop='',$Variety='',$Supplier='',$getStatus='',$FromDate='',$ToDate=''){
		$FindArray = array();
        if($userrole=='2'){
        	$this->db->where('seeds.userrole =', $userrole);
        }else{
        	$FindArray['is_deleted'] = '0';
        }

        if($Crop!=''){
        	$FindArray['Crop'] = $Crop;
    	}
    	if($Supplier!=''){
        	$FindArray['Supplier'] = $Supplier;
    	}
    	if($Variety!=''){
    		$variety_array = array('Variety' => $Variety);
    		$this->db->like($variety_array);
    	}	
    	if($getStatus!=''){
        	$FindArray['Status'] = $getStatus;
    	}

    	if($FromDate!='' AND $ToDate!=''){
    		$this->db->where('AddedDate >=', $FromDate.' 00:00:00');
			$this->db->where('AddedDate <=', $ToDate.' 23:59:59');
    	} 	
		$query = $this->db->get_where('seeds',$FindArray);
		return $query->result_array();
	}	


	public function get_seed($SeedID){
		$query = $this->db->get_where('seeds',array('SeedID'=>$SeedID));
		$result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
	}
	public function deleteseed($SeedID,$userrole=''){
		$this->db->where('SeedID',$SeedID);
		if($userrole=='1'){
			$this->db->delete('seeds');
		}else{
			$data = array('is_deleted'=>'1');
			$this->db->update('seeds', $data);
		}	
	}

	public function get_crops(){
		$query = $this->db->order_by("Title", "asc")->get_where('crops',array('is_deleted'=>'0'));
		return $query->result_array();
	}
	public function get_suppliers(){
		$query = $this->db->order_by("Name", "asc")->get_where('suppliers',array('is_deleted'=>'0'));
		return $query->result_array();
	}
	public function get_crop($CropID){
		$query = $this->db->get_where('crops',array('CropID'=>$CropID));
		$result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
		//return $result[0];
	}
	public function get_supplier($SupplierID){
		$query = $this->db->get_where('suppliers',array('SupplierID'=>$SupplierID));
		$result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
	}
	public function get_user_detail($user_id){
		$query = $this->db->get_where('users',array('UserID'=>$user_id));
		$result = $query->result_array();
		return $result[0];
	}
	public function checkvariety($data_array){
		$data = array();
		$data['Crop'] = $data_array['Crop'];
		$data['Supplier'] = $data_array['Supplier'];
		$data['Variety'] = $data_array['Variety'];
		$query = $this->db->get_where('seeds',$data);
		return $query->result_array();
	}

	function filter_seeds_num_row($userrole='',$Crop,$Supplier,$Variety,$getStatus='',$FromDate='',$ToDate='')
    {
    	$FindArray = array();
        if($userrole=='2'){
        	$this->db->where('seeds.userrole =', $userrole);
        }else{
        	$FindArray['is_deleted'] = '0';
        }

        if($Crop!=''){
        	$FindArray['Crop'] = $Crop;
    	}
    	if($Supplier!=''){
        	$FindArray['Supplier'] = $Supplier;
    	}
    	if($Variety!=''){
    		$variety_array = array('Variety' => $Variety);
    		$this->db->like($variety_array);
    	}	
    	if($getStatus!=''){
    		// foreach ($getStatus as $key => $value) {
    		// 	$this->db->or_where('Status', $value);
    		// }
        	$FindArray['Status'] = $getStatus;
    	}
        if($FromDate!='' AND $ToDate!=''){
    		$this->db->where('AddedDate >=', $FromDate.' 00:00:00');
			$this->db->where('AddedDate <=', $ToDate.' 23:59:59');
    	}
        $this->db->order_by('SeedID', 'DESC');
        
        $query = $this->db->get_where("seeds_seeds",$FindArray);
        //echo $this->db->last_query();
        return $query->num_rows();
    }

    function get_filter_seeds($userrole='',$Crop,$Supplier,$Variety,$limit,$offset,$getStatus='',$FromDate='',$ToDate='')
    {
    	$FindArray = array();
        if($userrole=='2'){
        	$this->db->where('seeds.userrole =', $userrole);
        }else{
        	$FindArray['is_deleted'] = '0';
        }

        if($Crop!=''){
        	$FindArray['Crop'] = $Crop;
    	}
    	if($Supplier!=''){
        	$FindArray['Supplier'] = $Supplier;
    	}
    	if($Variety!=''){
    		$variety_array = array('Variety' => $Variety);
    		$this->db->like($variety_array);
    	}
    	if($getStatus!=''){
    		// foreach ($getStatus as $key => $value) {
    		// 	$this->db->or_where('Status', $value);
    		// }
        	$FindArray['Status'] = $getStatus;
    	}

    	if($FromDate!='' AND $ToDate!=''){
    		$this->db->where('AddedDate >=', $FromDate.' 00:00:00');
			$this->db->where('AddedDate <=', $ToDate.' 23:59:59');
    	}
    	
        $this->db->order_by('SeedID', 'DESC');
		$query = $this->db->get_where('seeds',$FindArray,$limit,$offset);
		return $query->result_array();
    }

    function get_filter_variety_seeds($Crop,$Supplier){	
   
        $FindArray = array();   
        if($Crop!=''){
        	$FindArray['Crop'] = $Crop;
    	}
    	if($Supplier!=''){
    		$FindArray['Supplier'] = $Supplier;
    	}
		$query = $this->db->get_where('seeds',$FindArray);
		return $query->result_array();
    }

    public function insert_log($data){
		$datalog = array();
	 	$datalog['ipaddress'] = $this->get_client_ip();
	    $datalog['Source'] = 'ADMIN';
	    $datalog['Module'] = 'Seeds';
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

	//DEvelopment

	public function get_seed_summary($SeedID){
		$query = $this->db->get_where('seeds',array('SeedID'=>$SeedID));
		// print_r($this->db->last_query());
		$result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result;
        }
	}

	public function get_sampling($SeedID){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0','Seed'=>$SeedID));
		return $query->result_array();
	}

	public function get_trail($Internalsamplingcode){
		$query = $this->db->get_where('trial',array('Internalcode'=>$Internalsamplingcode));
		// print_r($this->db->last_query());
		$result = $query->result_array();
		return $result;
		
	}

	public function get_evaluation($Internalsamplingcode){
		$query = $this->db->get_where('evaluation',array('Internalsamplecode'=>$Internalsamplingcode));
		// print_r($this->db->last_query());
		$result = $query->result_array();
		return $result;
		
	}

	public function get_trail_counts($Internalsamplingcode){
		
		$query = $this->db->get_where('trial',array('Internalcode'=>$Internalsamplingcode,'is_deleted'=>'0'));
		return $query->num_rows();
	}

	public function get_evaluation_counts($Internalsamplingcode){
		
		$query = $this->db->get_where('evaluation',array('Internalsamplecode'=>$Internalsamplingcode));
		return $query->num_rows();
	}

	public function get_close($Internalsamplingcode){
		
		$query = $this->db->get_where('evaluation',array('Internalsamplecode'=>$Internalsamplingcode,'is_close'=>'1'));
		// print_r($this->db->last_query());
		return $query->num_rows();
	}

	// development 12/03/2021

	function insert_seeds_images($data){
		$this->db->insert('seed_images',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function get_seed_images($SeedID){
		$query = $this->db->get_where('seed_images',array('SeedID'=>$SeedID) );
		$result = $query->result_array();
        return $result;
	}

	// development 05/04/2021

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

	// development 12/08/2021

	function insert_seedstock($data){
		$this->db->insert('seedstock',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function get_seedsrecord_count($userrole='',$SeedID){
		if($userrole=='1'){
			$query = $this->db->get_where('seedstock',array('SeedID'=>$SeedID));
		}elseif($userrole=='2') {
			$query = $this->db->get_where('seedstock',array('is_deleted'=>'0','userrole'=>$userrole,'SeedID'=>$SeedID));
		}else{
			$query = $this->db->get_where('seedstock',array('is_deleted'=>'0','SeedID'=>$SeedID));
		}	
		return $query->num_rows();
	}


	public function get_seedrecord($limit,$offset,$userrole='',$SeedID){
		$this->db->order_by('SeedID', 'DESC');
		if($userrole=='1'){
			$query = $this->db->get_where('seedstock',array('SeedID'=>$SeedID),$limit,$offset);
		}elseif($userrole=='2') {
			$query = $this->db->order_by("SeedID", "DESC")->get_where('seedstock',array('is_deleted'=>'0','userrole'=>$userrole,'SeedID'=>$SeedID),$limit,$offset);
		}else{
			$query = $this->db->get_where('seedstock',array('is_deleted'=>'0','SeedID'=>$SeedID),$limit,$offset);	
		}			  
		return $query->result_array();
	}

	public function get_cropid($SeedID){
		$query = $this->db->get_where('seeds',array('SeedID'=>$SeedID));
		$result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
		//return $result[0];
	}

}
?>