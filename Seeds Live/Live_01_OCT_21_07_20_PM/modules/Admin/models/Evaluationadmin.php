<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Evaluationadmin extends CI_Model {

	function insert_evaluation($data){
		$this->db->insert('evaluation',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function update_evaluation($data,$EvaluationID){
		$this->db->where('EvaluationID', $EvaluationID);
		$this->db->update('evaluation', $data);
	}	


	public function get_evaluation_count($userrole=''){
		if($userrole=='1'){
			$query = $this->db->order_by("EvaluationID", "desc")->get_where('evaluation',array('is_close'=>'0'));
		}elseif($userrole=='7' || $userrole=='2') {
			$query = $this->db->order_by("EvaluationID", "desc")->get_where('evaluation',array('is_deleted'=>'0','is_close'=>'0','userrole'=>$userrole));
		}else{
			$query = $this->db->order_by("EvaluationID", "desc")->get_where('evaluation',array('is_deleted'=>'0','is_close'=>'0'));
		}
		return $query->num_rows();
	}

	public function get_evaluation($limit,$offset,$userrole=''){
		if($userrole=='1'){
			$query = $this->db->order_by("EvaluationID", "desc")->get_where('evaluation',array('is_close'=>'0'),$limit,$offset);
		}elseif($userrole=='7' || $userrole=='2') {
			$query = $this->db->order_by("EvaluationID", "desc")->get_where('evaluation',array('is_deleted'=>'0','is_close'=>'0','userrole'=>$userrole),$limit,$offset);
		}else{
			$query = $this->db->order_by("EvaluationID", "desc")->get_where('evaluation',array('is_deleted'=>'0','is_close'=>'0'),$limit,$offset);
		}
		// print_r($this->db->last_query());				  
		return $query->result_array();
	}	

	public function filter_get_evaluation_count($userrole='',$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$SowingFromDate,$SowingToDate,$HarvestFromDate,$HarvestToDate,$TransplantFromDate,$TransplantToDate,$Internalsamplingcode){
        $this->db->select('*');
		$this->db->from('evaluation');
		$this->db->join('sampling', 'sampling.Internalsamplingcode = evaluation.Internalsamplecode', 'inner');
		if($userrole=='7' || $userrole=='2'){
        	$this->db->where('evaluation.userrole =', $userrole);
        }else{
        	$this->db->where('evaluation.is_deleted =', '0');
        	$this->db->where('evaluation.is_close =', '0');
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
			$this->db->where('evaluation.AddedDate >=', $FromDate.' 00:00:00');
			$this->db->where('evaluation.AddedDate <=', $ToDate.' 23:59:59');
		}

		if($SowingFromDate!='' AND $SowingToDate!=''){
    		$this->db->where('Dateofsowing >=', $SowingFromDate.' 00:00:00');
			$this->db->where('Dateofsowing <=', $SowingToDate.' 23:59:59');
    	}
    	if($HarvestFromDate!='' AND $HarvestToDate!=''){
    		$this->db->where('Estimatedharvestingdate >=', $HarvestFromDate.' 00:00:00');
			$this->db->where('Estimatedharvestingdate <=', $HarvestToDate.' 23:59:59');
    	}
    	if($TransplantFromDate!='' AND $TransplantToDate!=''){
    		$this->db->where('Dateoftransplanted >=', $TransplantFromDate.' 00:00:00');
			$this->db->where('Dateoftransplanted <=', $TransplantToDate.' 23:59:59');
    	}

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();
	}

	public function filter_get_evaluation($limit,$offset,$userrole='',$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$SowingFromDate,$SowingToDate,$HarvestFromDate,$HarvestToDate,$TransplantFromDate,$TransplantToDate,$Internalsamplingcode){
		$this->db->select('*,evaluation.AddedDate AS evaluation_AddedDate');
		$this->db->from('evaluation');
		$this->db->join('sampling', 'sampling.Internalsamplingcode = evaluation.Internalsamplecode', 'inner');
		$this->db->join('users', 'users.UserID = evaluation.UserID' ,'inner');
		if($userrole=='7' || $userrole=='2'){
			$this->db->where('evaluation.userrole =', $userrole);
        }else{
        	$this->db->where('evaluation.is_deleted =', '0');
        	$this->db->where('evaluation.is_close =', '0');
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
			$this->db->where('evaluation.AddedDate >=', $FromDate.' 00:00:00');
			$this->db->where('evaluation.AddedDate <=', $ToDate.' 23:59:59');
		}
		if($SowingFromDate!='' AND $SowingToDate!=''){
    		$this->db->where('Dateofsowing >=', $SowingFromDate.' 00:00:00');
			$this->db->where('Dateofsowing <=', $SowingToDate.' 23:59:59');
    	}
    	if($HarvestFromDate!='' AND $HarvestToDate!=''){
    		$this->db->where('Estimatedharvestingdate >=', $HarvestFromDate.' 00:00:00');
			$this->db->where('Estimatedharvestingdate <=', $HarvestToDate.' 23:59:59');
    	}
    	if($TransplantFromDate!='' AND $TransplantToDate!=''){
    		$this->db->where('Dateoftransplanted >=', $TransplantFromDate.' 00:00:00');
			$this->db->where('Dateoftransplanted <=', $TransplantToDate.' 23:59:59');
    	}

		$this->db->order_by("evaluation.EvaluationID", "desc");
		$this->db->limit($limit,$offset);

		$query = $this->db->get();
		// print_r($this->db->last_query());
		return $query->result_array();
	}

	public function get_sampling_count($Internalsamplecode){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0','Internalsamplingcode'=>$Internalsamplecode));
		return $query->result_array();
	}

	public function get_sampling_counts($Internalsamplecode){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0','Internalsamplingcode'=>$Internalsamplecode));
		if($query->num_rows()>0){
			return false;
		}else{
			return true;
		}
	}

	public function get_sampling($Internalsamplingcode){
		$query = $this->db->get_where('sampling',array('Internalsamplingcode'=>$Internalsamplingcode));
		if($query->num_rows()>0){
			$result =  $query->result_array();
			return $result[0];
		}else{
			return false;
		}
	}

	public function get_single_evaluation($EvaluationID){
		$query = $this->db->get_where('evaluation',array('EvaluationID'=>$EvaluationID));
		$result = $query->result_array();
		if($query->num_rows()>0){
			$result =  $query->result_array();
			return $result[0];
		}else{
			return false;
		}
	}

	public function get_single_sampling($Internalsamplecode){
		$query = $this->db->get_where('sampling',array('Internalsamplingcode'=>$Internalsamplecode));
		$result = $query->result_array();
		return $result[0];
	}

	public function get_single_supplier($SupplierID){
		$query = $this->db->get_where('suppliers',array('SupplierID'=>$SupplierID));
		$result = $query->result_array();
		return $result[0];
	}

	public function get_single_crop($CropID){
		$query = $this->db->get_where('crops',array('CropID'=>$CropID));
		$result = $query->result_array();
		return $result[0];
	}

	public function get_single_variety($ControlvarietyID){
		$query = $this->db->get_where('seeds',array('SeedID'=>$ControlvarietyID));
		$result = $query->result_array();
		if($query->num_rows()>0){
			$result =  $query->result_array();
			return $result[0];
		}else{
			return false;
		}
	}

	public function get_single_evaluation_by_internalsamplecode($Internalsamplecode){
		$query = $this->db->get_where('evaluation',array('Internalsamplecode'=>$Internalsamplecode));
		$result = $query->result_array();
		$query->num_rows();
		if($query->num_rows()>0){
			return $result[0];
		}else{
			return false;
		}
	}

	public function deleteevaluation($EvaluationID,$userrole=''){
		$this->db->where('EvaluationID',$EvaluationID);
		if($userrole=='1'){
			$this->db->delete('evaluation');
		}else{
			$data = array('is_deleted'=>'1');
			$this->db->update('evaluation', $data);
		}
	}

	// development

	public function closeevaluation($EvaluationID,$userrole=''){
		$this->db->where('EvaluationID',$EvaluationID);
		$data = array('is_close'=>'1');
		$this->db->update('evaluation', $data);
		
	}

	public function closetrial($Internalcode,$userrole=''){
		$this->db->where('Internalcode',$Internalcode);
		$data = array('is_close'=>'1');
		$this->db->update('trial', $data);
	}

	public function closesampling($SamplingID,$userrole=''){
		$this->db->where('SamplingID',$SamplingID);
		$data = array('is_close'=>'1');
		$this->db->update('sampling', $data);
	}
	
	public function get_user_detail($user_id){
		$query = $this->db->get_where('users',array('UserID'=>$user_id));
		$result = $query->result_array();
		return $result[0];
	}

	public function get_trial($Internalcode){
		$query = $this->db->get_where('trial',array('is_deleted'=>'0','Internalcode'=>$Internalcode));			  
		return $query->result_array();
	}

	public function get_crop($CropID){
		$query = $this->db->get_where('crops',array('CropID'=>$CropID));
		$result = $query->result_array();
		$query->num_rows();
		if($query->num_rows()>0){
			return $result[0];
		}else{
			return false;
		}	
	}
	public function get_receiver($ReceiverID){
		$query = $this->db->get_where('receivers',array('ReceiverID'=>$ReceiverID));
		$query->num_rows();
		if($query->num_rows()>0){
			$result = $query->result_array();
			return $result[0];
		}else{
			return false;
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

	public function get_seed($SeedID){
		$query = $this->db->get_where('seeds',array('SeedID'=>$SeedID));
		$result = $query->result_array();
		$query->num_rows();
		if($query->num_rows()>0){
			return $result[0];
		}else{
			return false;
		}	
	}

	public function get_supplier($SupplierID){
		$query = $this->db->get_where('suppliers',array('SupplierID'=>$SupplierID));
		$result = $query->result_array();
		$query->num_rows();
		if($query->num_rows()>0){
			return $result[0];
		}else{
			return false;
		}	
	}

	public function get_seed_ID($UserID){
		$query = $this->db->get_where('seeds',array('UserID'=>$UserID));
		$result = $query->result_array();
		$query->num_rows();
		if($query->num_rows()>0){
			return $result[0];
		}else{
			return false;
		}	
	}

	public function get_crops(){
		$query = $this->db->order_by("Title", "ASC")->get_where('crops',array('is_deleted'=>'0'));
		$result = $query->result_array();
		return $result;
	}

	public function get_suppliers(){
		$query = $this->db->order_by("Name", "ASC")->get_where('suppliers',array('is_deleted'=>'0'));
		$result = $query->result_array();
		return $result;
	}

	public function get_techncialteams(){
		$query = $this->db->order_by("Name", "ASC")->get_where('techncialteam',array('is_deleted'=>'0'));
		$result = $query->result_array();
		return $result;
	}

	public function get_seeds(){
		$query = $this->db->get_where('seeds',array('is_deleted'=>'0'));
		$result = $query->result_array();
		return $result;
	}
	public function get_sampling_all(){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0'));
		$result = $query->result_array();
		return $result;
	}

	
	public function get_sampling_all_location(){
		$query = $this->db->order_by("Location", "ASC")->get_where('sampling',array('is_deleted'=>'0'));
		$result = $query->result_array();
		return $result;
	}

	// Rishabh

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


	/*===================For Re-check and Pre-commercial=========================*/
	public function insert_recheck($data){
		$this->db->insert('recheck',$data);
		$insert_id = $this->db->insert_id();
	}
	public function check_recheck($get_crop){
		$query = $this->db->get_where('recheck',array('Crop'=>$get_crop));
		return  $query->num_rows();
	}
	public function delete_recheck($EvaluationID){
		$this->db->where('EvaluationID',$EvaluationID);
		$this->db->delete('recheck');
	}

	public function insert_precommercial($data){
		$this->db->insert('precommercial',$data);
		$insert_id = $this->db->insert_id();
	}
	public function check_precommercial($EvaluationID){
		$query = $this->db->get_where('precommercial',array('EvaluationID'=>$EvaluationID));
		return  $query->num_rows();	
	}

	public function delete_precommercial($EvaluationID){
		$this->db->where('EvaluationID',$EvaluationID);
		$this->db->delete('precommercial');
	}

	/*===================END For Re-check and Pre-commercial=========================*/

	public function insert_log($data){
		$datalog = array();
	 	$datalog['ipaddress'] = $this->get_client_ip();
	    $datalog['Source'] = 'ADMIN';
	    $datalog['Module'] = 'Evaluation';
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

	public function get_single_trial($Internalsamplecode){
		$query = $this->db->get_where('trial',array('Internalcode'=>$Internalsamplecode));
		$result = $query->result_array();
		if($query->num_rows()>0){
			$result =  $query->result_array();
			return $result[0];
		}else{
			return false;
		}
	}

	public function get_single_samplings($Internalsamplecode){
		$query = $this->db->get_where('sampling',array('Internalsamplingcode'=>$Internalsamplecode));
		$result = $query->result_array();
		if($query->num_rows()>0){
			$result =  $query->result_array();
			return $result[0];
		}else{
			return false;
		}
	}

	// close Evaluation

	public function filter_get_evaluation_close_count_all($userrole='',$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode){
        $this->db->select('*');
		$this->db->from('evaluation');
		$this->db->join('sampling', 'sampling.Internalsamplingcode = evaluation.Internalsamplecode', 'inner');
		if($userrole=='1' || $userrole=='4'){
            
            $this->db->where('evaluation.is_close =', '1');

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
                $this->db->where('evaluation.AddedDate >=', $FromDate.' 00:00:00');
                $this->db->where('evaluation.AddedDate <=', $ToDate.' 23:59:59');
            }
        }

		$query = $this->db->get();
		return $query->result_array();
	}

	public function filter_get_evaluation_close_count($userrole='',$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode,$arr=array()){
        $this->db->select('*');
		$this->db->from('evaluation');
		$this->db->join('sampling', 'sampling.Internalsamplingcode = evaluation.Internalsamplecode', 'inner');
		$this->db->where_in('evaluation.EvaluationID', $arr);  
		if($userrole=='1' || $userrole=='4'){
            
            $this->db->where('evaluation.is_close =', '1');

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
                $this->db->where('evaluation.AddedDate >=', $FromDate.' 00:00:00');
                $this->db->where('evaluation.AddedDate <=', $ToDate.' 23:59:59');
            }
        }

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();
	}

	public function get_evaluation_close_all($userrole=''){
        if($userrole=='1' || $userrole=='4'){
            $query = $this->db->order_by("EvaluationID", "desc")->get_where('evaluation',array('is_close'=>'1'));
        	return $query->result_array();
        }
    }


	public function get_evaluation_close_count($userrole='',$arr=array()){
        if($userrole=='1' || $userrole=='4'){
            //$query = $this->db->order_by("EvaluationID", "desc")->get_where('evaluation',array('is_close'=>'1'));
            $this->db->where_in('EvaluationID', $arr);            
            $query = $this->db->order_by("EvaluationID", "desc")->get_where('evaluation',array('is_close'=>'1'));
        }
        return $query->num_rows();
    }

    public function filter_get_evaluation_close($limit,$offset,$userrole='',$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode,$arr=array()){
        $this->db->select('*,evaluation.AddedDate AS evaluation_AddedDate');
        $this->db->from('evaluation');
        $this->db->join('sampling', 'sampling.Internalsamplingcode = evaluation.Internalsamplecode', 'inner');
        $this->db->join('users', 'users.UserID = evaluation.UserID' ,'inner');
        $this->db->where_in('evaluation.EvaluationID', $arr);  
        if($userrole=='1' || $userrole=='4'){
       
            $this->db->where('evaluation.is_close =', '1');
            
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
                $this->db->where('evaluation.AddedDate >=', $FromDate.' 00:00:00');
                $this->db->where('evaluation.AddedDate <=', $ToDate.' 23:59:59');
            }

            $this->db->order_by("evaluation.EvaluationID", "desc");
            $this->db->limit($limit,$offset);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_evaluation_close($limit,$offset,$userrole='',$arr=array()){
        if($userrole=='1' || $userrole=='4' ){
        	$this->db->where_in('EvaluationID', $arr); 
            $query = $this->db->order_by("EvaluationID", "desc")->get_where('evaluation',array('is_close'=>'1'),$limit,$offset);
        }
        // print_r($this->db->last_query());                  
        return $query->result_array();
    } 

     //REcheck

     public function get_rechecks_evaluation($EvaluationID){
		$query = $this->db->get_where('evaluation',array('EvaluationID'=>$EvaluationID));
		$result = $query->result_array();
		return $result;
		} 

	public function get_rechecks_sampling($Internalsamplecode){
		$query = $this->db->get_where('sampling',array('Internalsamplingcode'=>$Internalsamplecode));
		$result = $query->result_array();
		return $result;
		} 

	public function get_rechecks_seeds($get_seed){
		$query = $this->db->get_where('seeds',array('SeedID'=>$get_seed));
		$result = $query->result_array();
		return $result;
		} 

	// View Close Evaluation 27/02/2021

	public function filter_get_viewevaluation_close_count($userrole='',$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode){
        $this->db->select('*');
		$this->db->from('evaluation');
		$this->db->join('sampling', 'sampling.Internalsamplingcode = evaluation.Internalsamplecode', 'inner');
		if($userrole=='1' || $userrole=='4'){
            
            $this->db->where('evaluation.is_close =', '1');

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
                $this->db->where('evaluation.AddedDate >=', $FromDate.' 00:00:00');
                $this->db->where('evaluation.AddedDate <=', $ToDate.' 23:59:59');
            }
        }

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();
	}

	public function get_viewevaluation_close_count($userrole=''){
        if($userrole=='1' || $userrole=='4'){
            $query = $this->db->order_by("EvaluationID", "desc")->get_where('evaluation',array('is_close'=>'1'));
        }
        return $query->num_rows();
    } 

    public function filter_get_viewevaluation_close($limit,$offset,$userrole='',$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode){
        $this->db->select('*,evaluation.AddedDate AS evaluation_AddedDate');
        $this->db->from('evaluation');
        $this->db->join('sampling', 'sampling.Internalsamplingcode = evaluation.Internalsamplecode', 'inner');
        $this->db->join('users', 'users.UserID = evaluation.UserID' ,'inner');
        if($userrole=='1' || $userrole=='4'){
       
            $this->db->where('evaluation.is_close =', '1');
            
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
                $this->db->where('evaluation.AddedDate >=', $FromDate.' 00:00:00');
                $this->db->where('evaluation.AddedDate <=', $ToDate.' 23:59:59');
            }

            $this->db->order_by("evaluation.EvaluationID", "desc");
            $this->db->limit($limit,$offset);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_viewevaluation_close($limit,$offset,$userrole=''){
        if($userrole=='1' || $userrole=='4' ){
            $query = $this->db->order_by("EvaluationID", "desc")->get_where('evaluation',array('is_close'=>'1'),$limit,$offset);
        }
        // print_r($this->db->last_query());                  
        return $query->result_array();
    }  

    public function update_recheck($data,$CropID){
		$this->db->where('Crop', $CropID);
		$this->db->update('recheck', $data);
		// print_r($this->db->last_query());
	}	


}
?>