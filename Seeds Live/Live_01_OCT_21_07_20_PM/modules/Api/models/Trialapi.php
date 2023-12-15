<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trialapi extends CI_Model {

	

	public function addtrial($data){

		$this->db->insert('trial',$data);

		return $this->db->insert_id();

	}



	public function update_trial($data,$TrialID){

		$this->db->where('TrialID', $TrialID);

		$this->db->update('trial', $data);

	}



	public function get_trial($UserID){				  

		$query = $this->db->get_where('trial',array('is_deleted'=>'0','UserID'=>$UserID));

		return $query->result_array();

	}



	public function get_single_trial($TrialID){

		$query = $this->db->get_where('trial',array('TrialID'=>$TrialID));

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

		

	public function insert_log($data){

		$datalog = array();

	 	$datalog['ipaddress'] = $data['ipaddress'];

	    $datalog['Source'] = 'APP';

	    $datalog['Module'] = 'Trial';

	    $datalog['UserID'] = $data['UserID'];

	    $datalog['Activity'] = $data['Activity'];

	    $datalog['Title'] = $data['Title'];

	    $datalog['Data'] = $data['Data'];

	    $datalog['Createdate'] = date("d-m-Y h:i:s a");

		$this->db->insert('logs',$datalog);

		$this->db->insert_id();

	}



	function getuser($UserID){

		$this->db->where('UserID', $UserID);

		$query = $this->db->get('users');

		$result = $query->result_array();

		return $result[0];

	}

	

}

?>