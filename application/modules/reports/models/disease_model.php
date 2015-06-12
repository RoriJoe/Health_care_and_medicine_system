<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Disease_model extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct ();
		$this->table = 'view_drug_used';
	}
	
	function getDiseaseByAge ($idPuskesmas='',$from='', $till='') {
		$query = $this->db->query('CALL disease_by_age('.$idPuskesmas.',"'.$from.'","'.$till.'")');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getDiseaseHighest ($idPuskesmas='',$from='', $till='') {
		$query = $this->db->query('CALL get_highest_disease_hcare('.$idPuskesmas.',"'.$from.'","'.$till.'")');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getDiseaseByAgeHCare ($idicd='',$from='', $till='') {
		$query = $this->db->query('CALL disease_by_age_hcare('.$idicd.',"'.$from.'","'.$till.'")');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	

	function getDiseaseDetail ($idPuskesmas='',$from='', $till='') {
		$stringQuery = "";
		if($idPuskesmas != -2)
		$stringQuery = " AND unit.ID_GEDUNG = ".$idPuskesmas;
		$sql = '
		SELECT 	
*,
INDONESIAN_NAME as NAMA_PENYAKIT,
IFNULL(SUM(IF(GENDER_PASIEN = "Laki-Laki" AND UPPER(sk) LIKE "%BARU%" ,1,0)),0) AS "LBARU",
IFNULL(SUM(IF(GENDER_PASIEN = "Perempuan" AND UPPER(sk) LIKE "%BARU%" ,1,0)),0) AS "PBARU",
IFNULL(SUM(IF(GENDER_PASIEN = "Laki-Laki" AND UPPER(sk) LIKE "%LAMA%" ,1,0)),0) AS "LLAMA",
IFNULL(SUM(IF(GENDER_PASIEN = "Perempuan" AND UPPER(sk) LIKE "%LAMA%" ,1,0)),0) AS "PLAMA",
IFNULL(SUM(IF(GENDER_PASIEN = "Laki-Laki" AND UPPER(sk) LIKE "%KKL%" ,1,0)),0) AS "LKKL",
IFNULL(SUM(IF(GENDER_PASIEN = "Perempuan" AND UPPER(sk) LIKE "%KKL%" ,1,0)),0) AS "PKKL"
FROM
(
SELECT icd_table.*,
pasien.*,
diagnosa_pasien.NAMA_STATUS_KASUS as sk 
from diagnosa_pasien
LEFT JOIN riwayat_rm
ON diagnosa_pasien.ID_RIWAYAT_RM = riwayat_rm.ID_RIWAYAT_RM
LEFT JOIN icd_table
ON icd_table.ID_ICD = diagnosa_pasien.ID_ICD
LEFT JOIN rekam_medik
ON rekam_medik.ID_PASIEN = riwayat_rm.ID_REKAMMEDIK
LEFT JOIN pasien
ON pasien.ID_PASIEN = rekam_medik.ID_PASIEN
LEFT JOIN antrian_unit
ON riwayat_rm.ID_RIWAYAT_RM = antrian_unit.ID_RIWAYAT_RM
LEFT JOIN unit
ON unit.ID_UNIT = antrian_unit.ID_UNIT
WHERE diagnosa_pasien.ID_ICD IS NOT NULL AND riwayat_rm.TANGGAL_RIWAYAT_RM BETWEEN "'.$from.'" AND "'.$till.'" '.$stringQuery.') A 
GROUP BY ID_ICD
';
		//echo $sql;
		$query = $this->db->query ($sql);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
}