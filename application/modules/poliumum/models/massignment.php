<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mAssignment extends CI_Model {
	
	function getAssignment ($account_id) {
		$sql = "select p.id_akun, p.id_unit, u.id_gedung, g.nama_gedung from penugasan p left join unit u
				on p.id_unit = u.id_unit left join gedung g on u.id_gedung = g.id_gedung where p.id_akun =".$account_id." limit 1";
		$query = $this->db->query ($sql);
		if ($query->num_rows> 0) {
			return $query->result_array();
		} 
		else 
			return null;
	}

}