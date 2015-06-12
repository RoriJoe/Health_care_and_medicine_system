<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mAssignment extends CI_Model {

	function getAssignment ($constraint) {		
		$this->db->where ($constraint);
		$query = $this->db->get ('penugasan');
		if ($query->num_rows> 0) {
			$result = $query->result_array();
			return $result[0]['ID_PENUGASAN'];
		} 
		else 
			return null;
	}

}