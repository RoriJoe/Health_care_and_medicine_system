<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mComplaint extends CI_Model {

	function insertNewEntry ($data) {		
		$keluhans = explode("," , $data['DESKRIPSI_KELUHAN']);
		
		$this->db->trans_start();
		foreach ($keluhans as $keluhan_pasien) {
			$data['DESKRIPSI_KELUHAN'] = $keluhan_pasien;
			$this->db->insert('keluhan_pasien', $data);
		}
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
}