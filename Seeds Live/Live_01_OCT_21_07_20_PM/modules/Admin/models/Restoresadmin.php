<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Restoresadmin extends CI_Model {

	public function get_user_detail($user_id){

		$query = $this->db->get_where('users',array('UserID'=>$user_id));

		$result = $query->result_array();

		return $result[0];

	}



	public function get_count_crops(){

        $query = $this->db->get_where('crops',array('is_deleted'=>'1'));

		return $query->num_rows();

    }



    public function get_count_evaluations(){

        $query = $this->db->get_where('evaluation',array('is_deleted'=>'1'));

		return $query->num_rows();

    }



    public function get_count_receivers(){

        $query = $this->db->get_where('receivers',array('is_deleted'=>'1'));

		return $query->num_rows();

    }



    public function get_count_seeds(){

        $query = $this->db->get_where('seeds',array('is_deleted'=>'1'));

		return $query->num_rows();

    }



    public function get_count_samplings(){

        $query = $this->db->get_where('sampling',array('is_deleted'=>'1'));

		return $query->num_rows();

    }



    public function get_count_suppliers(){

        $query = $this->db->get_where('suppliers',array('is_deleted'=>'1'));

		return $query->num_rows();

    }



    public function get_count_techncialteams(){

        $query = $this->db->get_where('techncialteam',array('is_deleted'=>'1'));

		return $query->num_rows();

    }



    public function get_count_trials(){

        $query = $this->db->get_where('trial',array('is_deleted'=>'1'));

		return $query->num_rows();

    }





    public function get_crops($limit,$offset){

        $query = $this->db->get_where('crops',array('is_deleted'=>'1'),$limit,$offset);

		$result = $query->result_array();

		return $result;

    }



    public function get_crop($CropID){

        $query = $this->db->get_where('crops',array('CropID'=>$CropID));

        if($query->num_rows() == 1) {

            $result = $query->result_array();

           return $result[0];

        }else{

            return false;

        }

    }



    public function get_evaluations($limit,$offset){

        $query = $this->db->get_where('evaluation',array('is_deleted'=>'1'),$limit,$offset);

		$result = $query->result_array();

		return $result;

    }



    public function get_receivers($limit,$offset){

        $query = $this->db->get_where('receivers',array('is_deleted'=>'1'),$limit,$offset);

		$result = $query->result_array();

		return $result;

    }



    public function get_seeds($limit,$offset){

        $query = $this->db->get_where('seeds',array('is_deleted'=>'1'),$limit,$offset);

		$result = $query->result_array();

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



    public function get_samplings($limit,$offset){

        $query = $this->db->get_where('sampling',array('is_deleted'=>'1'),$limit,$offset);

		$result = $query->result_array();

		return $result;

    }



    public function get_suppliers($limit,$offset){

        $query = $this->db->get_where('suppliers',array('is_deleted'=>'1'),$limit,$offset);

		$result = $query->result_array();

		return $result;

    }



    public function get_supplier($SupplierID){

        $query = $this->db->get_where('suppliers',array('SupplierID'=>$SupplierID));

        if($query->num_rows() == 1) {

            $result = $query->result_array();

           return $result[0];

        }else{

            return false;

        }

    }



    public function get_techncialteams($limit,$offset){

        $query = $this->db->get_where('techncialteam',array('is_deleted'=>'1'),$limit,$offset);

		$result = $query->result_array();

		return $result;

    }





    public function get_trials($limit,$offset){

        $query = $this->db->get_where('trial',array('is_deleted'=>'1'),$limit,$offset);

		$result = $query->result_array();

		return $result;

    }



    public function get_restore_delete_crops($type,$id){

        $this->db->where('CropID',$id);

        if($type=='delete'){

            $this->db->delete('crops');

        }else{

            $data = array('is_deleted'=>'0');

            $this->db->update('crops', $data);

        }

    }



    public function get_restore_delete_evaluations($type,$id){

        $this->db->where('EvaluationID',$id);

        if($type=='delete'){

            $this->db->delete('evaluation');

        }else{

            $data = array('is_deleted'=>'0');

            $this->db->update('evaluation', $data);

        }

    }



    public function get_restore_delete_receivers($type,$id){

        $this->db->where('ReceiverID',$id);

        if($type=='delete'){

            $this->db->delete('receivers');

        }else{

            $data = array('is_deleted'=>'0');

            $this->db->update('receivers', $data);

        }

    }



    public function get_restore_delete_samplings($type,$id){

        $this->db->where('SamplingID',$id);

        if($type=='delete'){

            $this->db->delete('sampling');

        }else{

            $data = array('is_deleted'=>'0');

            $this->db->update('sampling', $data);

        }

    }



    public function get_restore_delete_seeds($type,$id){

        $this->db->where('SeedID',$id);

        if($type=='delete'){

            $this->db->delete('seeds');

        }else{

            $data = array('is_deleted'=>'0');

            $this->db->update('seeds', $data);

        }

    }



    public function get_restore_delete_suppliers($type,$id){

        $this->db->where('SupplierID',$id);

        if($type=='delete'){

            $this->db->delete('suppliers');

        }else{

            $data = array('is_deleted'=>'0');

            $this->db->update('suppliers', $data);

        }

    }

    public function get_restore_delete_techncialteams($type,$id){

        $this->db->where('TechncialteamID',$id);

        if($type=='delete'){

            $this->db->delete('techncialteam');

        }else{

            $data = array('is_deleted'=>'0');

            $this->db->update('techncialteam', $data);

        }

    }

    public function get_restore_delete_trials($type,$id){

        $this->db->where('TrialID',$id);

        if($type=='delete'){

            $this->db->delete('trial');

        }else{

            $data = array('is_deleted'=>'0');

            $this->db->update('trial', $data);

        }

    }

}

?>