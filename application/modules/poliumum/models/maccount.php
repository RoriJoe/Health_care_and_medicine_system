<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mAccount extends CI_Model {
	
	function getAccount ($noid) {
		$this->db->where ('noid', $noid);
		$query = $this->db->get('akun');
		if ($query->num_rows> 0) {
			return $query->result_array();
		} 
		else 
			return null;
	}

}