<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mCaseStatus extends CI_Model {

	public function getAllEntry (){
		$query = $this->db->get('status_kasus');
		if ($query->num_rows() > 0) {
			return $query->result_array ();
		}
		else
			return null;
	}

}