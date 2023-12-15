<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Logsadmin extends CI_Model {
	public function get_user_detail($user_id){
		$query = $this->db->get_where('users',array('UserID'=>$user_id));
		$result = $query->result_array();
		if($query->num_rows()>0){
			return $result[0];
		}else{
			return false;
		}
	}	
	
	public function get_logs_count(){
		$this->db->order_by('Createdate', 'DESC');
		$query = $this->db->get_where('logs',array());
		return $query->num_rows();
	}

	public function get_logs($limit,$offset){
		$this->db->order_by('Createdate', 'DESC');
		$query = $this->db->get_where('logs',array(),$limit,$offset);
		return $query->result();
	}
}
?>