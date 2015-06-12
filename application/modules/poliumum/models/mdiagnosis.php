<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mDiagnosis extends CI_Model {
	
	function insertNewEntry ($data) {
		if ($this->db->insert('diagnosa_pasien', $data)) {
			return true;
		} 
		else 
			return false;
	}
	
	function getEntryById ($id_rrm) {
		$sql = 'SELECT * FROM diagnosa_pasien
				left join icd_table
				on icd_table.ID_ICD = diagnosa_pasien.ID_ICD
				where diagnosa_pasien.ID_RIWAYAT_RM = '.$id_rrm;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

}