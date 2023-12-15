<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Evaluationapi extends CI_Model {
	
	public function addevaluation($data){
		$this->db->insert('evaluation',$data);
		return $this->db->insert_id();
	}

	public function get_evaluation($UserID){		  
		$query = $this->db->get_where('evaluation',array('is_deleted'=>'0','UserID'=>$UserID));
		return $query->result_array();
	}

	public function insert_log($data){
		$datalog = array();
	 	$datalog['ipaddress'] = $data['ipaddress'];
	    $datalog['Source'] = 'APP';
	    $datalog['Module'] = 'Evaluation';
	    $datalog['UserID'] = $data['UserID'];
	    $datalog['Activity'] = $data['Activity'];
	    $datalog['Title'] = $data['Title'];
	    $datalog['Data'] = $data['Data'];
	    $datalog['PostData'] = $data['PostData'];
	    $datalog['Createdate'] = date("d-m-Y h:i:s a");
		$this->db->insert('logs',$datalog);
		$this->db->insert_id();
	}

	public function get_single_evaluation($EvaluationID){
		$query = $this->db->get_where('evaluation',array('EvaluationID'=>$EvaluationID));
		$result = $query->result_array();
		return $result[0];
	}
	public function get_sampling(){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0'));
		return $query->result_array();
	}

	public function get_single_sampling($Internalsamplingcode){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0','Internalsamplingcode'=>$Internalsamplingcode));
		$query->result_array();
		$result = $query->result_array();
		if($query->num_rows()>0){
			return $result;
		}else{
			return false;
		}
	}
	public function get_seed($SeedID){
		$query = $this->db->get_where('seeds',array('SeedID'=>$SeedID));
		if($query->num_rows() == 1) {
			$result = $query->result_array();
           return $result[0];
        }else{
        	return false;
        }
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
	public function get_sampling_count($Internalsamplingcode){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0','Internalsamplingcode'=>$Internalsamplingcode));
		if($query->num_rows()>0){
			return false;
		}else{
			return true;
		}
	}	
	function getuser($UserID){
		$this->db->where('UserID', $UserID);
		$query = $this->db->get('users');
		$result = $query->result_array();
		return $result[0];
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
	public function check_recheck($EvaluationID){
		$query = $this->db->get_where('recheck',array('EvaluationID'=>$EvaluationID));
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
}
?>