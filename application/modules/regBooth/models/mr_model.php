<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

// Medical Record
class Mr_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		$this->load->model ('Mrh_model');
	}
	
	/*function insertNewEntry ($data, $pembayaran, $pelayanan, $umur) {
		$this->db->insert('rekam_medik', $data);
		$last_med_id = $this->db->insert_id();
		$med_record_history = array (
				'id_rekammedik' => $last_med_id,
				'id_sumber' => $pembayaran,
				'tanggal_riwayat_rm' => date('Y-m-d'),
				'umur_saat_ini' => $umur
		);
		$this->Mrh_model->insertNewEntry ($med_record_history, $pelayanan);
	}*/
	
	function insertNewEntry ($data) {
		$this->db->insert('rekam_medik', $data);
		$last_med_id = $this->db->insert_id();
		return $last_med_id;
	}
	
	function getMRbyId ($patient_id) {
		$this->db->where ('id_pasien', $patient_id);
		$query = $this->db->get ('rekam_medik');
		if ($query ->num_rows() > 0)
			return 
				$query->result_array ();		
			return null;
	}

}