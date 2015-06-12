<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Ri_model extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct();
	}
	
	function getRIPatient ($id_gedung, $tanggal) {
	
		$sql = "SELECT 
				pasien.NAMA_PASIEN AS `NAMA_PASIEN`,
				riwayat_rm.UMUR_SAAT_INI AS `UMUR`,
				pasien.GENDER_PASIEN AS `JENIS_KELAMIN`,
				data_rawat_inap.RI_START_OPNAME AS `TANGGAL_MASUK`,
				pasien.NOID_PASIEN AS `NIK`
				FROM data_rawat_inap
				LEFT JOIN riwayat_rm
				ON data_rawat_inap.ID_RAWAT_INAP = riwayat_rm.ID_RAWAT_INAP
				LEFT JOIN rekam_medik
				ON rekam_medik.ID_REKAMMEDIK = riwayat_rm.ID_REKAMMEDIK
				LEFT JOIN pasien
				ON pasien.ID_PASIEN = rekam_medik.ID_PASIEN
				LEFT JOIN tempat_tidur
				ON tempat_tidur.ID_TEMPAT_TIDUR = data_rawat_inap.ID_TEMPAT_TIDUR
				LEFT JOIN ruangan_ri
				ON ruangan_ri.ID_RUANGAN_RI = tempat_tidur.ID_RUANGAN_RI
				LEFT JOIN unit
				ON unit.ID_UNIT = ruangan_ri.ID_UNIT
				WHERE data_rawat_inap.RI_FINISH_OPNAME IS NULL AND DATE(data_rawat_inap.RI_START_OPNAME) <= CURDATE() AND unit.ID_GEDUNG =".$id_gedung;

		$query = $this->db->query($sql);
		if ($query->num_rows>0) return $query->result_array();
		else return null;
	}

	function getRIPatientKD ($id_gedung, $tanggal) {
	
		$sql = "SELECT 
				pasien.NAMA_PASIEN AS `NAMA_PASIEN`,
				riwayat_rm.UMUR_SAAT_INI AS `UMUR`,
				pasien.GENDER_PASIEN AS `JENIS_KELAMIN`,
				data_rawat_inap.RI_START_OPNAME AS `TANGGAL_MASUK`,
				IFNULL(data_rawat_inap.RI_FINISH_OPNAME,'') AS TANGGAL_KELUAR, 
				pasien.NOID_PASIEN AS `NIK`
				FROM data_rawat_inap
				LEFT JOIN riwayat_rm
				ON data_rawat_inap.ID_RAWAT_INAP = riwayat_rm.ID_RAWAT_INAP
				LEFT JOIN rekam_medik
				ON rekam_medik.ID_REKAMMEDIK = riwayat_rm.ID_REKAMMEDIK
				LEFT JOIN pasien
				ON pasien.ID_PASIEN = rekam_medik.ID_PASIEN
				LEFT JOIN tempat_tidur
				ON tempat_tidur.ID_TEMPAT_TIDUR = data_rawat_inap.ID_TEMPAT_TIDUR
				LEFT JOIN ruangan_ri
				ON ruangan_ri.ID_RUANGAN_RI = tempat_tidur.ID_RUANGAN_RI
				LEFT JOIN unit
				ON unit.ID_UNIT = ruangan_ri.ID_UNIT
				WHERE  DATE(data_rawat_inap.RI_START_OPNAME) <= CURDATE() AND unit.ID_GEDUNG =".$id_gedung;

		$query = $this->db->query($sql);
		if ($query->num_rows>0) return $query->result_array();
		else return null;
	}
}