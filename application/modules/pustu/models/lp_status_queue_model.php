<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Lp_Status_queue_model extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct();
		$this->table = 'antrian_unit';
	}
	
	function insertNewEntry ($data) {
		
		if ($this->db->insert($this->table, $data)) {
			return true;
		}
		else return false;
	}
	
	function getQueueByUnit ($id_unit, $id_gedung, $tanggal) {
	
		$sql = "SELECT IF(antrian_unit.FLAG_ANTRIAN_UNIT = 1, 'Selesai', 'Dalam Penanganan/Antri') AS `status_antri`, antrian_unit.ID_ANTRIAN_UNIT AS `NOMOR_ANTRIAN`, pasien.NOID_PASIEN AS `NIK`, pasien.NAMA_PASIEN AS `NAMA_PASIEN`, antrian_unit.WAKTU_ANTRIAN_UNIT FROM antrian_unit
		LEFT JOIN riwayat_rm
		ON antrian_unit.ID_RIWAYAT_RM = riwayat_rm.ID_RIWAYAT_RM
		LEFT JOIN rekam_medik
		ON rekam_medik.ID_REKAMMEDIK = riwayat_rm.ID_REKAMMEDIK
		LEFT JOIN pasien
		ON pasien.ID_PASIEN = rekam_medik.ID_REKAMMEDIK 
		LEFT JOIN unit
		ON antrian_unit.ID_UNIT = unit.ID_UNIT
		WHERE (antrian_unit.WAKTU_ANTRIAN_UNIT between '".$tanggal."' and '".$tanggal." 23:59:59') AND antrian_unit.FLAG_ANTRIAN_UNIT = 0 AND unit.ID_GEDUNG =".$id_gedung." AND antrian_unit.ID_UNIT = ".$id_unit;
		
		$query = $this->db->query($sql);
		//var_dump ($sql);
		if ($query->num_rows>0) return $query->result_array();
		else return null;
	}

}