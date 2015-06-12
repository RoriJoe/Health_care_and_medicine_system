<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mQueue extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct();
		$this->table = 'antrian_unit';
		$this->load->model ('mPatient');
	}
	
	function insertNewEntry ($data) {
		if ($this->db->insert($this->table, $data)) {
			return true;
		}
		else return false;
	}
	
	function removeEntry ($data) {
		$this->db->where('id_antrian_unit', $data);
		if ($this->db->delete($this->table)){
			return true;
		}
		else return false;
	}
	
	function getAllByUnit ($id_unit) {	
		$sql = "select au.id_antrian_unit, au.id_riwayat_rm, p.nama_pasien, au.waktu_antrian_unit, au.flag_intern 
                    from antrian_unit au 
                    left join riwayat_rm rrm on au.id_riwayat_rm = rrm.id_riwayat_rm
                    left join rekam_medik rm on rrm.id_rekammedik = rm.id_rekammedik 
                    left join pasien p on p.id_pasien = rm.id_pasien 
                    where au.flag_antrian_unit = 0 and au.id_unit = ".$id_unit."
                    order by au.id_antrian_unit ASC";
		$query = $this->db->query ($sql);
		if  ($query->num_rows() > 0) {
			return $query->result_array ();
		}
		else return null;
	}

	function updateQueue ($id_antrian_unit) {
		$this->db->where ('id_antrian_unit', $id_antrian_unit);
		$data = array ('flag_antrian_unit' => 1);
		if ($this->db->update($this->table, $data)) {
			return true;
		}
		return false;
	}
}