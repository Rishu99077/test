<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Samplingadmin extends CI_Model {
	function insert_sampling($data){
		$this->db->insert('sampling',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function update_sampling($data,$SamplingID){
		$this->db->where('SamplingID', $SamplingID);
		$this->db->update('sampling', $data);
	}

	public function update_seeds($data,$SeedID){
		$this->db->where('SeedID', $SeedID);
		$this->db->update('seeds', $data);
	}	

	public function get_sampling_count($userrole=''){
		if($userrole=='1'){
			$query = $this->db->get_where('sampling',array('is_close'=>'0'));
		}elseif($userrole=='2') {
			$query = $this->db->get_where('sampling',array('is_deleted'=>'0','userrole'=>$userrole));
		}else{
			$query = $this->db->get_where('sampling',array('is_deleted'=>'0'));
		}
		return $query->num_rows();
	}

	public function get_sampling($limit,$offset,$userrole=''){
		if($userrole=='1'){
			$query = $this->db->order_by("SamplingID", "desc")->get_where('sampling',array('is_close'=>'0'),$limit,$offset);
		}elseif($userrole=='2') {
			$query = $this->db->order_by("SamplingID", "desc")->get_where('sampling',array('is_deleted'=>'0','userrole'=>$userrole),$limit,$offset);
		}else{
			$query = $this->db->order_by("SamplingID", "desc")->get_where('sampling',array('is_deleted'=>'0'),$limit,$offset);	
		}				  
		return $query->result_array();
	}

	public function get_sampling_all($userrole=''){
		if($userrole=='1'){
			$query = $this->db->get_where('sampling',array('is_close'=>'0'));
		}elseif($userrole=='2') {
			$query = $this->db->order_by("SamplingID", "desc")->get_where('sampling',array('is_deleted'=>'0','userrole'=>$userrole),$limit,$offset);
		}else{
			$query = $this->db->get_where('sampling',array('is_deleted'=>'0'));	
		}				  
		return $query->result_array();
	}

	public function get_sampling_all_location($userrole=''){
		if($userrole=='1'){
			$query = $this->db->order_by("Location", "asc")->get_where('sampling',array('is_close'=>'0'));
		}elseif($userrole=='2'){
			$query = $this->db->order_by("Location", "asc")->get_where('sampling',array('is_deleted'=>'0','userrole'=>$userrole));	
		}else{
			$query = $this->db->order_by("Location", "asc")->get_where('sampling',array('is_deleted'=>'0'));	
		}				  
		return $query->result_array();
	}


	public function get_samplings_export($userrole='',$Crop='',$Variety='',$Supplier='',$Location='',$Receiver='',$Techncialteam='',$FromDate='',$ToDate='',$Internalsamplingcode=''){

		$FindArray = array();
        if($userrole=='1'){
        	$FindArray['is_close'] = '0';
        }elseif($userrole=='2'){
        	$FindArray['is_deleted'] = '0';
        }else{
        	$FindArray['is_deleted'] = '0';
        }

        if($Crop!=''){
        	$FindArray['Crop'] = $Crop;
    	}
    	if($Supplier!=''){
        	$FindArray['SupplierID'] = $Supplier;
    	}
    	if($Variety!=''){
        	$FindArray['Seed'] = $Variety;
    	}	
    	if($Location!=''){
        	$FindArray['Location'] = $Location;
    	}
    	if($Receiver!=''){
        	$FindArray['Receiver'] = $Receiver;
    	}
    	if($Techncialteam!=''){
    		$FindArray['Techncialteam'] = $Techncialteam;
    	}
    	if($FromDate!='' AND $ToDate!=''){
    		$this->db->where('AddedDate >=', $FromDate.' 00:00:00');
			$this->db->where('AddedDate <=', $ToDate.' 23:59:59');
    	}

    	if($Internalsamplingcode!=''){
        	$FindArray['Internalsamplingcode'] = $Internalsamplingcode;
    	}
		$query = $this->db->get_where('sampling',$FindArray);
		return $query->result_array();
	}

	public function get_single_sampling($SamplingID){
		$query = $this->db->get_where('sampling',array('SamplingID'=>$SamplingID));
		$result = $query->result_array();
		return $result[0];
	}

	public function deletesampling($SamplingID,$userrole=''){
		$this->db->where('SamplingID',$SamplingID);
		if($userrole=='1'){
			$this->db->delete('sampling');
		}else{
			$data = array('is_deleted'=>'1');
			$this->db->update('sampling', $data);
		}	
	}
	public function get_controlvariety(){
		$query = $this->db->get_where('controlvariety',array('is_deleted'=>'0'));
		return $query->result_array();
	}

	public function get_receivers(){
		$query = $this->db->order_by("Name", "asc")->get_where('receivers',array('is_deleted'=>'0'));
		return $query->result_array();
	}
	public function get_receiver($ReceiverID){
		$query = $this->db->get_where('receivers',array('ReceiverID'=>$ReceiverID));
		$result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
		//return $result[0];
	}
	public function get_techncialteam(){
		$query = $this->db->get_where('techncialteam',array('is_deleted'=>'0'));
		return $query->result_array();
	}
	public function get_single_techncialteam($TechncialteamID){
		$query = $this->db->get_where('techncialteam',array('TechncialteamID'=>$TechncialteamID));
		$result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
	}

	public function get_seeds(){
		$query = $this->db->get_where('seeds',array('is_deleted'=>'0'));
		return $query->result_array();
	}
	
	public function get_techncialteams(){
	    $query = $this->db->order_by("Name", "ASC")->get_where('techncialteam',array('is_deleted'=>'0'));
	    $results = $query->result_array();
	    return $results;
	}

	function filter_samplings_rows($userrole='',$Crop,$Supplier){	
   
        $FindArray = array();
        if($userrole=='1'){
        	$FindArray['is_close'] = '0';
        }elseif($userrole=='2'){
        	$FindArray['is_deleted'] = '0';
        }else{
        	$FindArray['is_deleted'] = '0';   	
        }
        if($Crop!=''){
        	$FindArray['Crop'] = $Crop;
    	}
    	if($Supplier!=''){
    		$FindArray['SupplierID'] = $Supplier;
    	}
		$query = $this->db->get_where('sampling',$FindArray);
		$result =  $query->result_array();
		return $result;
    }

	public function get_seed($SeedID){
		$query = $this->db->get_where('seeds',array('is_deleted'=>'0','SeedID'=>$SeedID));
		if($query->num_rows() == 1) {
			$result = $query->result_array();
           return $result[0];
        }else{
        	return false;
        }
	}

	public function get_seed_count($SeedID,$Stock_quantityfor,$Stock_quantity,$SamplingID=''){
		$get_seed = $this->get_seed($SeedID);

		if($get_seed['Stockquantityfor']=='2'){
			$Stockquantity = $get_seed['Stockquantity'];
		}elseif($get_seed['Stockquantityfor']=='0'){
			$Stockquantity = $get_seed['Stockquantity'];
		}elseif($get_seed['Stockquantityfor']=='1'){
			$countStockquantity1 = $get_seed['Stockquantity']*1000;
			$Stockquantity = $countStockquantity1;		
		}

		$count = 0;
		if($Stock_quantityfor=='2'){
			$count += $Stock_quantity;
		}elseif($Stock_quantityfor=='0'){
			$count += $Stock_quantity;
		}elseif($Stock_quantityfor=='1'){
			$countStockquantity = $Stock_quantity*1000;
			$count += $countStockquantity;		
		}
		if($SamplingID!=''){
			$get_single_sampling = $this->get_single_sampling($SamplingID);
			$get_Stockquantityfor = $get_single_sampling['Stockquantityfor'];
			$get_Stockquantity = $get_single_sampling['Stockquantity'];

			if($get_Stockquantityfor=='2'){
				$count -= $get_Stockquantity;
			}elseif($get_Stockquantityfor=='0'){
				$count -= $get_Stockquantity;
			}elseif($get_Stockquantityfor=='1'){
				$countStockquantity = $get_Stockquantity*1000;
				$count -= $countStockquantity;		
			}
		}

		$reposnse = array();
		if($count<=$Stockquantity){
			$reposnse['message'] = '';
			$totalcount = 0;
			if($get_seed['Stockquantityfor']=='2'){
				$totalcount += $count;
			}elseif($get_seed['Stockquantityfor']=='0'){
				$totalcount += $count;
			}elseif($get_seed['Stockquantityfor']=='1'){
				$countStockquantity = $count/1000;
				$totalcount += $countStockquantity;		
			}
			$dataupdate = array();
			$dataupdate['Stockquantity'] = $get_seed['Stockquantity']-$totalcount;
			$this->update_seeds($dataupdate,$SeedID);
		}else{
			$cal = $Stockquantity;
			if($Stock_quantityfor=='2'){
				$cal = $Stockquantity;
				$label = 'Seed';
			}elseif($Stock_quantityfor=='1'){
				$cal = $Stockquantity/1000;
				$label = 'Kg';
			}else{
				$cal = $Stockquantity;
				$label = 'Gram';
			}
		
			$reposnse['message'] = 'You have '.$cal.' '.$label.' in stock';
		}
		return $reposnse;
	}
	public function get_seed_by_crop($Crop){
		$data =array();
		$data['is_deleted']='0';
		$data['Crop']=$Crop;
		$query = $this->db->get_where('seeds',$data);
		return $query->result_array();
	}

	public function get_seed_by_cropcontrolvariety($Crop){
		$data =array();
		$data['is_deleted']='0';
		$data['Status']='5';
		$data['Crop']=$Crop;
		$query = $this->db->get_where('seeds',$data);
		return $query->result_array();
	}

	public function get_crops(){
		$query = $this->db->get_where('crops',array('is_deleted'=>'0'));
		return $query->result_array();
	}
	public function get_suppliers(){
		$query = $this->db->order_by("Name", "asc")->get_where('suppliers',array('is_deleted'=>'0'));
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
		if($query->num_rows()>0){
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

	public function get_single_controlvariety($Controlvariety){
		$query = $this->db->get_where('controlvariety',array('ControlvarietyID' => $Controlvariety,'is_deleted'=>'0'));
		if($query->num_rows()>0){
			$result = $query->result_array();
			return $result[0];
		}else{
			return false;
		}
	}

	function filter_samplings_num_row($userrole='',$Crop,$Variety,$Supplier,$Location,$Receiver,$Techncialteam,$FromDate,$ToDate,$SowingFromDate,$SowingToDate,$HarvestFromDate,$HarvestToDate,$TransplantFromDate,$TransplantToDate,$DeliveryFromDate,$DeliveryToDate,$Internalsamplingcode){
        $this->db->order_by('SamplingID', 'DESC');
        $FindArray = array();
        if($userrole=='1'){
        	$FindArray['is_close'] = '0';
        }elseif($userrole=='2'){
        	$FindArray['is_deleted'] = '0';
        }else{
        	$FindArray['is_deleted'] = '0';
        	
        }
        if($Crop!=''){
        	$FindArray['Crop'] = $Crop;
    	}
    	if($Variety!=''){
    		$FindArray['Seed'] = $Variety;
    	}
    	if($Supplier!=''){
    		$FindArray['SupplierID'] = $Supplier;
    	}
    	if($Location!=''){
    		$Location_array = array('Location' => $Location);
			$this->db->like($Location_array);
    	}
    	if($Receiver!=''){
    		$FindArray['Receiver'] = $Receiver;
    	}
    	if($Techncialteam!=''){
    		$FindArray['Techncialteam'] = $Techncialteam;
    	}
    	if($FromDate!='' AND $ToDate!=''){
    		$this->db->where('AddedDate >=', $FromDate.' 00:00:00');
			$this->db->where('AddedDate <=', $ToDate.' 23:59:59');
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
    	if($DeliveryFromDate!='' AND $DeliveryToDate!=''){
    		$this->db->where('Deliverydate >=', $DeliveryFromDate.' 00:00:00');
			$this->db->where('Deliverydate <=', $DeliveryToDate.' 23:59:59');
    	}

    	if($Internalsamplingcode!=''){
        	$FindArray['Internalsamplingcode'] = $Internalsamplingcode;
    	}

        $query = $this->db->get_where("sampling",$FindArray);
        // echo "string ".$this->db->last_query();
        return $query->num_rows();
    }

    function get_filter_samplings($userrole='',$Crop,$Variety,$Supplier,$Location,$Receiver,$Techncialteam,$FromDate,$ToDate,$SowingFromDate,$SowingToDate,$HarvestFromDate,$HarvestToDate,$TransplantFromDate,$TransplantToDate,$DeliveryFromDate,$DeliveryToDate,$Internalsamplingcode,$limit,$offset){	
        

        $this->db->order_by('SamplingID', 'DESC');
        $FindArray = array();
        
        if($userrole=='1'){
        	$FindArray['is_close'] = '0';
        }elseif($userrole=='2'){
        	$FindArray['is_deleted'] = '0';
        }else{
        	$FindArray['is_deleted'] = '0';
        }

        if($Crop!=''){
        	$FindArray['Crop'] = $Crop;
    	}
    	if($Variety!=''){
    		$FindArray['Seed'] = $Variety;
    	}
    	if($Supplier!=''){
    		$FindArray['SupplierID'] = $Supplier;
    	}
		if($Location!=''){
    		$Location_array = array('Location' => $Location);
			$this->db->like($Location_array);
    	}
    	if($Receiver!=''){
    		$FindArray['Receiver'] = $Receiver;
    	}
    	if($Techncialteam!=''){
    		$FindArray['Techncialteam'] = $Techncialteam;
    	}
    	
    	if($FromDate!='' AND $ToDate!=''){
    		$this->db->where('AddedDate >=', $FromDate.' 00:00:00');
			$this->db->where('AddedDate <=', $ToDate.' 23:59:59');
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
    	if($DeliveryFromDate!='' AND $DeliveryToDate!=''){
    		$this->db->where('Deliverydate >=', $DeliveryFromDate.' 00:00:00');
			$this->db->where('Deliverydate <=', $DeliveryToDate.' 23:59:59');
    	}
    	if($Internalsamplingcode!=''){
        	$FindArray['Internalsamplingcode'] = $Internalsamplingcode;
    	}
		
		$query = $this->db->get_where('sampling',$FindArray,$limit,$offset);
		// print_r($this->db->last_query());
		return $query->result_array();
    }

    public function insert_log($data){
		$datalog = array();
	 	$datalog['ipaddress'] = $this->get_client_ip();
	    $datalog['Source'] = 'ADMIN';
	    $datalog['Module'] = 'Sampling';
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


}
?>