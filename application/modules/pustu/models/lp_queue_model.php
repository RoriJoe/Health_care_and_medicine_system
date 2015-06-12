<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Lp_Queue_model extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct();
		$this->table = 'antrian_unit';
	}
	
	function insertNewEntry ($data) {
		var_dump ($data);
		if ($this->db->insert($this->table, $data)) {
			return true;
		}
		else return false;
	}
	
	function getQueueByUnit ($array_unit) {
//		$id_unit = $array_unit['id'];
                $sub_unit= $array_unit['id'];
                $unitPustu = explode("_", $sub_unit);
		$sql = 'select antrian_unit.ID_ANTRIAN_UNIT, pasien.NOID_PASIEN, 
                        pasien.NAMA_PASIEN, antrian_unit.WAKTU_ANTRIAN_UNIT from antrian_unit
                        left join riwayat_rm
                        on antrian_unit.ID_RIWAYAT_RM = riwayat_rm.ID_RIWAYAT_RM
                        left join rekam_medik
                        on rekam_medik.ID_REKAMMEDIK = riwayat_rm.ID_REKAMMEDIK
                        left join pasien
                        on pasien.ID_PASIEN = rekam_medik.ID_PASIEN
                        where antrian_unit.FLAG_ANTRIAN_UNIT = 0 and antrian_unit.ID_UNIT = '.$unitPustu[0].'
                        and antrian_unit.SUB_PUSTU ="'.$unitPustu[1].'"';		
		
		$query = $this->db->query($sql);
		if ($query->num_rows>0) return $query->result_array();
		else return null;
	}

}