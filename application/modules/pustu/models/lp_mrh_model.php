<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

// medical record history
class Lp_mrh_model extends CI_Model {

	private $table;

	public function __construct () {
		parent::__construct ();
		$this->table = 'riwayat_rm';
		$this->load->model ('Lp_queue_model');
	}
	
	/*public function insertNewEntry ($data, $pelayananDituju) {
		// var_dump ($data);
	
		$this->db->insert($this->table, $data);
		$last_medHistoryId = $this->db->insert_id();
		
		// var_dump ("medhist ".$last_medHistoryId);
		
		$data_queue = array (
				'id_unit' => $pelayananDituju['id_unit'],
				'id_riwayat_rm' => (string)$last_medHistoryId,
				'waktu_antrian_unit' => date('Y-m-d H:i:s'),
				'flag_antrian_unit' => 0
		);
		if (count($pelayananDituju) == 2) {
			$data_queue['sub_kia'] = $pelayananDituju['sub_kia'];
		}
		
		$this->Queue_model->insertNewEntry($data_queue);		
	}*/
	
	public function insertNewEntry ($data) {	
		$this->db->insert($this->table, $data);
		$last_medHistoryId = $this->db->insert_id();
		return $last_medHistoryId;
	}

	
}