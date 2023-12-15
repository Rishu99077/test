<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboardadmin extends CI_Model {
	public function get_user_detail($user_id){
		$query = $this->db->get_where('users',array('UserID'=>$user_id));
		$result = $query->result_array();
		return $result[0];
	}


	public function get_samplings()
    {
        $query = $this->db->limit(6)->order_by("SamplingID", "desc")->get_where('sampling',array('is_deleted'=>'0'));
		return $query->result_array();
    }
    public function get_search_crops_count($search){
		$name_array = array('Title' => $search);
		$this->db->like($name_array);
		$query = $this->db->get_where('crops',array('is_deleted'=>'0'));
		return $query->num_rows();
	}
	public function get_search_crops($limit,$offset,$search){
		$name_array = array('Title' => $search);
		$this->db->like($name_array);
		$this->db->order_by('CropID', 'DESC');
		$query = $this->db->get_where('crops',array('is_deleted'=>'0'),$limit,$offset);
		$result = $query->result_array();
		return $result;
	}

	public function get_search_controlvariety_count($search){
		$name_array = array('Title' => $search);
		$this->db->like($name_array);
		$query = $this->db->get_where('controlvariety',array('is_deleted'=>'0'));
		return $query->num_rows();
	}
	public function get_search_controlvariety($limit,$offset,$search){
		$name_array = array('Title' => $search);
		$this->db->like($name_array);
		$this->db->order_by('ControlvarietyID', 'DESC');
		$query = $this->db->get_where('controlvariety',array('is_deleted'=>'0'),$limit,$offset);
		$result = $query->result_array();
		return $result;
	}

	public function get_search_suppliers_count($search){
		$name_array = array('Name' => $search);
		$this->db->like($name_array);
		$query = $this->db->get_where('suppliers',array('is_deleted'=>'0'));
		return $query->num_rows();
	}
	public function get_search_suppliers($limit,$offset,$search){
		$name_array = array('Name' => $search);
		$this->db->like($name_array);
		$this->db->order_by('SupplierID', 'DESC');
		$query = $this->db->get_where('suppliers',array('is_deleted'=>'0'),$limit,$offset);
		$result = $query->result_array();
		return $result;
	}

	public function get_search_receivers_count($search){
		$name_array = array('Name' => $search);
		$this->db->like($name_array);
		$query = $this->db->get_where('receivers',array('is_deleted'=>'0'));
		return $query->num_rows();
	}
	public function get_search_receivers($limit,$offset,$search){
		$name_array = array('Name' => $search);
		$this->db->like($name_array);
		$this->db->order_by('ReceiverID', 'DESC');
		$query = $this->db->get_where('receivers',array('is_deleted'=>'0'),$limit,$offset);
		$result = $query->result_array();
		return $result;
	}
	public function get_search_techncialteam_count($search){
		$name_array = array('Name' => $search);
		$this->db->like($name_array);
		$query = $this->db->get_where('techncialteam',array('is_deleted'=>'0'));
		return $query->num_rows();
	}
	public function get_search_techncialteam($limit,$offset,$search){
		$name_array = array('Name' => $search);
		$this->db->like($name_array);
		$this->db->order_by('TechncialteamID', 'DESC');
		$query = $this->db->get_where('techncialteam',array('is_deleted'=>'0'),$limit,$offset);
		$result = $query->result_array();
		return $result;
	}

	public function get_search_seeds_count($search){
		$name_array = array('Variety' => $search);
		$this->db->like($name_array);
		$query = $this->db->get_where('seeds',array('is_deleted'=>'0'));
		return $query->num_rows();
	}
	public function get_search_seeds($limit,$offset,$search){
		$name_array = array('Variety' => $search);
		$this->db->like($name_array);
		$this->db->order_by('SeedID', 'DESC');
		$query = $this->db->get_where('seeds',array('is_deleted'=>'0'),$limit,$offset);
		$result = $query->result_array();
		return $result;
	}

	public function get_search_sampling_count($search){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0','Internalsamplingcode'=>$search));
		return $query->num_rows();
	}
	public function get_search_sampling($limit,$offset,$search){
		$query = $this->db->get_where('sampling',array('is_deleted'=>'0','Internalsamplingcode'=>$search),$limit,$offset);
		$result = $query->result_array();
		return $result;
	}

	public function get_search_trial_count($search){
		$query = $this->db->get_where('trial',array('is_deleted'=>'0','Internalcode'=>$search));
		return $query->num_rows();
	}
	public function get_search_trial($limit,$offset,$search){
		$query = $this->db->get_where('trial',array('is_deleted'=>'0','Internalcode'=>$search),$limit,$offset);
		$result = $query->result_array();
		return $result;
	}

	public function get_search_evaluation_count($search){
		$query = $this->db->get_where('evaluation',array('is_deleted'=>'0','Internalsamplecode'=>$search));
		return $query->num_rows();
	}
	public function get_search_evaluation($limit,$offset,$search){
		$query = $this->db->get_where('evaluation',array('is_deleted'=>'0','Internalsamplecode'=>$search),$limit,$offset);
		$result = $query->result_array();
		return $result;
	}

	public function get_search_recheck_count($search){
		$name_array = array('Variety' => $search);
		$this->db->like($name_array);
		$query = $this->db->get_where('recheck',array('is_deleted'=>'0'));
		return $query->num_rows();
	}
	public function get_search_recheck($limit,$offset,$search){
		$name_array = array('Variety' => $search);
		$this->db->like($name_array);
		$this->db->order_by('RecheckID', 'DESC');
		$query = $this->db->get_where('recheck',array('is_deleted'=>'0'),$limit,$offset);
		$result = $query->result_array();
		return $result;
	}

	public function get_search_precommercial_count($search){
		$name_array = array('Variety' => $search);
		$this->db->like($name_array);
		$query = $this->db->get_where('precommercial',array('is_deleted'=>'0'));
		return $query->num_rows();
	}
	public function get_search_precommercial($limit,$offset,$search){
		$name_array = array('Variety' => $search);
		$this->db->like($name_array);
		$this->db->order_by('PrecommercialID', 'DESC');
		$query = $this->db->get_where('precommercial',array('is_deleted'=>'0'),$limit,$offset);
		$result = $query->result_array();
		return $result;
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
	public function get_controlvariety($ControlvarietyID){
		$query = $this->db->get_where('controlvariety',array('ControlvarietyID'=>$ControlvarietyID));
		$result = $query->result_array();
		return $result[0];
	}

	public function get_trials()
    {
        $query = $this->db->limit(6)->order_by("TrialID", "desc")->get_where('trial',array('is_deleted'=>'0'));
		return $query->result_array();
    }

    public function get_evaluations()
    {
        $query = $this->db->limit(6)->order_by("EvaluationID", "desc")->get_where('evaluation',array('is_deleted'=>'0'));
		return $query->result_array();
    }

    public function get_crops()
    {
        $query = $this->db->limit(6)->order_by("CropID", "desc")->get_where('crops',array('is_deleted'=>'0'));
		return $query->result_array();
    }



}
?>