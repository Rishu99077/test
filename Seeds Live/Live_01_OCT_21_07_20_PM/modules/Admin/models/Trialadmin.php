<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Trialadmin extends CI_Model {

	function insert_trial($data){
		$this->db->insert('trial',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function update_trial($data,$TrialID){
		$this->db->where('TrialID', $TrialID);
		$this->db->update('trial', $data);
	}	


	public function get_trial_count($userrole=''){
		if($userrole=='1'){
			$query = $this->db->get_where('trial',array('is_close'=>'0'));
		}elseif($userrole=='7' || $userrole=='2') {
			$query = $this->db->get_where('trial',array('is_deleted'=>'0','userrole'=>$userrole));
		}else{
			$query = $this->db->get_where('trial',array('is_deleted'=>'0'));
		}
		// print_r($this->db->last_query());
		return $query->num_rows();
	}

	public function get_trial($limit,$offset,$userrole=''){
		if($userrole=='1'){
			$query = $this->db->order_by("TrialID", "desc")->get_where('trial',array('is_close'=>'0'),$limit,$offset);
		}elseif($userrole=='7' || $userrole=='2') {
			$query = $this->db->order_by("TrialID", "desc")->get_where('trial',array('is_deleted'=>'0','userrole'=>$userrole),$limit,$offset);
		}else{
			$query = $this->db->order_by("TrialID", "desc")->get_where('trial',array('is_deleted'=>'0'),$limit,$offset);
		}
		// print_r($this->db->last_query());
		return $query->result_array();
	}
	// -----------------------------------------------
	public function get_trials($Internalcode){
		$query = $this->db->get_where('trial',array('is_deleted'=>'0','Internalcode'=>$Internalcode));			  
		return $query->result_array();
	}

	public function get_evaluation($Internalcode){
		$query = $this->db->get_where('evaluation',array('is_deleted'=>'0','Internalsamplecode'=>$Internalcode));			  
		return $query->result_array();
	}


	public function filter_get_trial_count($userrole='',$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$SowingFromDate,$SowingToDate,$HarvestFromDate,$HarvestToDate,$TransplantFromDate,$TransplantToDate,$Internalsamplingcode){
        $this->db->select('*');
		$this->db->from('trial');
		$this->db->join('sampling', 'sampling.Internalsamplingcode = trial.Internalcode', 'inner');
		if($userrole=='7' || $userrole=='2'){
			$this->db->where('trial.userrole =', $userrole);
        }else{
        	$this->db->where('trial.is_deleted =', '0');
        	$this->db->where('trial.is_close =', '0');
        }
        if($Crop!=''){
        	$this->db->where('sampling.Crop =', $Crop);
    	}

    	if($Supplier!=''){
        	$this->db->where('sampling.SupplierID =', $Supplier);
    	}
    	if($Variety!=''){
        	$this->db->where('sampling.Seed =', $Variety);
    	}

    	if($Location!=''){
    		$Location_array = array('sampling.Location' => $Location);
			$this->db->like($Location_array);
    	}

    	if($Techncialteam!=''){
        	$this->db->where('sampling.Techncialteam =', $Techncialteam);
    	}

    	if($Internalsamplingcode!=''){
        	$this->db->where('sampling.Internalsamplingcode =', $Internalsamplingcode);
    	}

		if($FromDate!='' AND $ToDate!=''){
			$this->db->where('trial.AddedDate >=', $FromDate.' 00:00:00');
			$this->db->where('trial.AddedDate <=', $ToDate.' 23:59:59');
		}

    	if($SowingFromDate!='' AND $SowingToDate!=''){
    		$this->db->where('sampling.Dateofsowing >=', $SowingFromDate.' 00:00:00');
			$this->db->where('sampling.Dateofsowing <=', $SowingToDate.' 23:59:59');
    	}
    	if($HarvestFromDate!='' AND $HarvestToDate!=''){
    		$this->db->where('sampling.Estimatedharvestingdate >=', $HarvestFromDate.' 00:00:00');
			$this->db->where('sampling.Estimatedharvestingdate <=', $HarvestToDate.' 23:59:59');
    	}
    	if($TransplantFromDate!='' AND $TransplantToDate!=''){
    		$this->db->where('sampling.Dateoftransplanted >=', $TransplantFromDate.' 00:00:00');
			$this->db->where('sampling.Dateoftransplanted <=', $TransplantToDate.' 23:59:59');
    	}


		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();
	}

	public function filter_get_trial($limit,$offset,$userrole='',$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$SowingFromDate,$SowingToDate,$HarvestFromDate,$HarvestToDate,$TransplantFromDate,$TransplantToDate,$Internalsamplingcode){
		$this->db->select('*,trial.AddedDate AS trial_AddedDate');
		$this->db->from('trial');
		$this->db->join('sampling', 'sampling.Internalsamplingcode = trial.Internalcode', 'inner');
		$this->db->join('users', 'users.UserID = trial.UserID', 'inner');
		if($userrole=='7' || $userrole=='2'){
			$this->db->where('trial.userrole =', $userrole);
        }else{
        	$this->db->where('trial.is_deleted =', '0');
        	$this->db->where('trial.is_close =', '0');
        }
        if($Crop!=''){
        	$this->db->where('sampling.Crop =', $Crop);
    	}

    	if($Supplier!=''){
        	$this->db->where('sampling.SupplierID =', $Supplier);
    	}
    	if($Variety!=''){
        	$this->db->where('sampling.Seed =', $Variety);
    	}

    	if($Location!=''){
    		$Location_array = array('sampling.Location' => $Location);
			$this->db->like($Location_array);
    	}

    	if($Techncialteam!=''){
        	$this->db->where('sampling.Techncialteam =', $Techncialteam);
    	}

    	if($Internalsamplingcode!=''){
        	$this->db->where('sampling.Internalsamplingcode =', $Internalsamplingcode);
    	}

		if($FromDate!='' AND $ToDate!=''){
			$this->db->where('trial.AddedDate >=', $FromDate.' 00:00:00');
			$this->db->where('trial.AddedDate <=', $ToDate.' 23:59:59');
		}

		if($SowingFromDate!='' AND $SowingToDate!=''){
    		$this->db->where('sampling.Dateofsowing >=', $SowingFromDate.' 00:00:00');
			$this->db->where('sampling.Dateofsowing <=', $SowingToDate.' 23:59:59');
    	}
    	if($HarvestFromDate!='' AND $HarvestToDate!=''){
    		$this->db->where('sampling.Estimatedharvestingdate >=', $HarvestFromDate.' 00:00:00');
			$this->db->where('sampling.Estimatedharvestingdate <=', $HarvestToDate.' 23:59:59');
    	}
    	if($TransplantFromDate!='' AND $TransplantToDate!=''){
    		$this->db->where('sampling.Dateoftransplanted >=', $TransplantFromDate.' 00:00:00');
			$this->db->where('sampling.Dateoftransplanted <=', $TransplantToDate.' 23:59:59');
    	}
	

		$this->db->order_by("trial.TrialID", "desc");
		$this->db->limit($limit,$offset);
		// print_r($this->db->last_query());
		$query = $this->db->get();
		return $query->result_array();
	}

		

	public function get_single_trial($TrialID){
		$query = $this->db->get_where('trial',array('TrialID'=>$TrialID));

		$result = $query->result_array();
        if($query->num_rows() == 1) {
           return $result[0];
        }else{
            return false;
        }
        
		/*$result = $query->result_array();
		return $result[0];*/
	}

	public function deletetrial($TrialID,$userrole=''){
		$this->db->where('TrialID',$TrialID);
		if($userrole=='1'){
			$this->db->delete('trial');
		}else{
			$data = array('is_deleted'=>'1');
			$this->db->update('trial', $data);
		}
	}
	public function get_user_detail($user_id){
		$query = $this->db->get_where('users',array('UserID'=>$user_id));
		$result = $query->result_array();
		return $result[0];
	}

	public function get_sampling_count($Internalsamplingcode){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0','Internalsamplingcode'=>$Internalsamplingcode));
		if($query->num_rows()>0){
			return false;
		}else{
			return true;
		}
	}
	
	public function get_sampling($Internalsamplingcode){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0','Internalsamplingcode'=>$Internalsamplingcode));
		if($query->num_rows()>0){
			$result = $query->result_array();
			return $result[0];
		}else{
			return true;
		}
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
	
	public function get_sampling_all(){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0'));
		$result = $query->result_array();
		return $result;
	}

	public function get_sampling_all_location(){
		$query = $this->db->order_by("Location", "asc")->get_where('sampling',array('is_deleted'=>'0'));
		$result = $query->result_array();
		return $result;
	}

	public function get_supplier($SupplierID){
		$query = $this->db->get_where('suppliers',array('is_deleted'=>'0','SupplierID'=>$SupplierID));
		if($query->num_rows()>0){
			$result = $query->result_array();
			return $result[0];
		}else{
			return true;
		}
	}

	public function get_suppliers(){
		$query = $this->db->order_by("Name", "asc")->get_where('suppliers',array('is_deleted'=>'0'));
		$result = $query->result_array();
		return $result;
	}

	public function get_seed($SeedID){
		$query = $this->db->get_where('seeds',array('is_deleted'=>'0','SeedID'=>$SeedID));
		if($query->num_rows()>0){
			$result = $query->result_array();
			return $result[0];
		}else{
			return true;
		}
	}

	public function get_seeds(){
		$query = $this->db->get_where('seeds',array('is_deleted'=>'0'));
		$result = $query->result_array();
		return $result;
	}

	public function get_crops(){
		$query = $this->db->order_by("Title", "asc")->get_where('crops',array('is_deleted'=>'0'));
		$result = $query->result_array();
		return $result;
	}

	public function get_crop($CropID){
		$query = $this->db->get_where('crops',array('is_deleted'=>'0','CropID'=>$CropID));
		if($query->num_rows()>0){
			$result = $query->result_array();
			return $result[0];
		}else{
			return true;
		}
	}

	public function get_techncialteams(){
		$query = $this->db->order_by("Name", "asc")->get_where('techncialteam',array('is_deleted'=>'0'));
		$result = $query->result_array();
		return $result;
	}

	public function insert_log($data){
		$datalog = array();
	 	$datalog['ipaddress'] = $this->get_client_ip();
	    $datalog['Source'] = 'ADMIN';
	    $datalog['Module'] = 'Trial';
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

	/* Abhishek */

	public function get_single_sampling($Internalsamplingcode){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0','Internalsamplingcode'=>$Internalsamplingcode));
		$query->result_array();
		$result = $query->result_array();
		if($query->num_rows()>0){
			$result = $query->result_array();
			return $result[0];
		}else{
			return false;
		}
	}

	public function get_crop_by_cropid($CropID){
		$query = $this->db->get_where('crops',array('CropID'=>$CropID));
		$result = $query->result_array();
		$query->num_rows();
		if($query->num_rows()>0){
			return $result[0];
		}else{
			return false;
		}	
	}


	public function get_crop_by_receiverid($ReceiverID){
		$query = $this->db->get_where('receivers',array('ReceiverID'=>$ReceiverID));
		$result = $query->result_array();
		$query->num_rows();
		if($query->num_rows()>0){
			return $result[0];
		}else{
			return false;
		}	
	}

	// Development Trail Summary Start
	
	public function filter_get_trialsummary_count($userrole='',$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode){
        $this->db->select('*');
		$this->db->from('trial');
		$this->db->join('sampling', 'sampling.Internalsamplingcode = trial.Internalcode', 'inner');
		if($userrole=='7' || $userrole=='2'){
			$this->db->where('trial.userrole =', $userrole);
        }else{
        	$this->db->where('trial.is_deleted =', '0');
        }
        if($Crop!=''){
        	$this->db->where('sampling.Crop =', $Crop);
    	}

    	if($Supplier!=''){
        	$this->db->where('sampling.SupplierID =', $Supplier);
    	}
    	if($Variety!=''){
        	$this->db->where('sampling.Seed =', $Variety);
    	}

    	if($Location!=''){
    		$Location_array = array('sampling.Location' => $Location);
			$this->db->like($Location_array);
    	}

    	if($Techncialteam!=''){
        	$this->db->where('sampling.Techncialteam =', $Techncialteam);
    	}

    	if($Internalsamplingcode!=''){
        	$this->db->where('sampling.Internalsamplingcode =', $Internalsamplingcode);
    	}




		if($FromDate!='' AND $ToDate!=''){
			$this->db->where('trial.AddedDate >=', $FromDate.' 00:00:00');
			$this->db->where('trial.AddedDate <=', $ToDate.' 23:59:59');
		}

		$query = $this->db->get();
		// echo $this->db->last_query();
		return $query->num_rows();
	}

	public function filter_get_trialsummary($limit,$offset,$userrole='',$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode){
		$this->db->select('*');
		$this->db->from('trial');
		$this->db->join('sampling', 'sampling.Internalsamplingcode = trial.Internalcode', 'inner');
		if($userrole=='7' || $userrole=='2'){
			$this->db->where('trial.userrole =', $userrole);
        }else{
        	$this->db->where('trial.is_deleted =', '0');
        }
        if($Crop!=''){
        	$this->db->where('sampling.Crop =', $Crop);
    	}

    	if($Supplier!=''){
        	$this->db->where('sampling.SupplierID =', $Supplier);
    	}
    	if($Variety!=''){
        	$this->db->where('sampling.Seed =', $Variety);
    	}

    	if($Location!=''){
    		$Location_array = array('sampling.Location' => $Location);
			$this->db->like($Location_array);
    	}

    	if($Techncialteam!=''){
        	$this->db->where('sampling.Techncialteam =', $Techncialteam);
    	}

    	if($Internalsamplingcode!=''){
        	$this->db->where('sampling.Internalsamplingcode =', $Internalsamplingcode);
    	}


		if($FromDate!='' AND $ToDate!=''){
			$this->db->where('trial.AddedDate >=', $FromDate.' 00:00:00');
			$this->db->where('trial.AddedDate <=', $ToDate.' 23:59:59');
		}

		$this->db->order_by("trial.TrialID", "desc");
		$this->db->limit($limit,$offset);

		$query = $this->db->get();
		// print_r($this->db->last_query());
		return $query->result_array();
	}		

	// Development Trail Summary End

	// Development View Trail Start

	public function filter_get_viewtrial_count($userrole='',$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode){
        $this->db->select('*');
		$this->db->from('trial');
		$this->db->join('sampling', 'sampling.Internalsamplingcode = trial.Internalcode', 'inner');
		if($userrole=='1' || $userrole=='4'){

			$this->db->where('trial.is_close =', '1');
       
	        if($Crop!=''){
	        	$this->db->where('sampling.Crop =', $Crop);
	    	}

	    	if($Supplier!=''){
	        	$this->db->where('sampling.SupplierID =', $Supplier);
	    	}
	    	if($Variety!=''){
	        	$this->db->where('sampling.Seed =', $Variety);
	    	}

	    	if($Location!=''){
	    		$Location_array = array('sampling.Location' => $Location);
				$this->db->like($Location_array);
	    	}

	    	if($Techncialteam!=''){
	        	$this->db->where('sampling.Techncialteam =', $Techncialteam);
	    	}

	    	if($Internalsamplingcode!=''){
	        	$this->db->where('sampling.Internalsamplingcode =', $Internalsamplingcode);
	    	}

			if($FromDate!='' AND $ToDate!=''){
				$this->db->where('trial.AddedDate >=', $FromDate.' 00:00:00');
				$this->db->where('trial.AddedDate <=', $ToDate.' 23:59:59');
			}
		}	
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();
	}

	public function get_viewtrial_count($userrole=''){
		if($userrole=='1' || $userrole=='4'){
            $query = $this->db->order_by("TrialID", "desc")->get_where('trial',array('is_close'=>'1'));
        }
		return $query->num_rows();
	}

	public function filter_get_viewtrial($limit,$offset,$userrole='',$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode){
		$this->db->select('*,trial.AddedDate AS trial_AddedDate');
		$this->db->from('trial');
		$this->db->join('sampling', 'sampling.Internalsamplingcode = trial.Internalcode', 'inner');
		$this->db->join('users', 'users.UserID = trial.UserID', 'inner');
		if($userrole=='1' || $userrole=='4'){
			
        	$this->db->where('trial.is_close =', '1');
       
	        if($Crop!=''){
	        	$this->db->where('sampling.Crop =', $Crop);
	    	}

	    	if($Supplier!=''){
	        	$this->db->where('sampling.SupplierID =', $Supplier);
	    	}
	    	if($Variety!=''){
	        	$this->db->where('sampling.Seed =', $Variety);
	    	}

	    	if($Location!=''){
	    		$Location_array = array('sampling.Location' => $Location);
				$this->db->like($Location_array);
	    	}

	    	if($Techncialteam!=''){
	        	$this->db->where('sampling.Techncialteam =', $Techncialteam);
	    	}

	    	if($Internalsamplingcode!=''){
	        	$this->db->where('sampling.Internalsamplingcode =', $Internalsamplingcode);
	    	}

			if($FromDate!='' AND $ToDate!=''){
				$this->db->where('trial.AddedDate >=', $FromDate.' 00:00:00');
				$this->db->where('trial.AddedDate <=', $ToDate.' 23:59:59');
			}
		

			$this->db->order_by("trial.TrialID", "desc");
			$this->db->limit($limit,$offset);

		}

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_viewtrial($limit,$offset,$userrole=''){
		if($userrole=='1' || $userrole=='4' ){
            $query = $this->db->order_by("TrialID", "desc")->get_where('trial',array('is_close'=>'1'),$limit,$offset);
        }
		return $query->result_array();
	}

	// Development View Trail End

}
?>