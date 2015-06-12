<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Lab_model extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct ();
	}
	
	function gethead ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL keg_lab('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function gethematologi ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL lab_hematologi('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function geturine ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL lab_urine('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function gethamil ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL lab_kehamilan('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getfeces ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL lab_feces('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	
	function getgula ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL lab_gula('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	
	function getserologi ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL lab_serologi('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function gethati ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL lab_hati('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	
	function getlemak ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL lab_lemak('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getginjal ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL lab_ginjal('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getdirect ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL lab_direct('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getLabBy ($idgedung='',$bulan='',$tahun='') {
		
		$sql = 'SELECT main.NAMA_PEMERIKSAAN AS `NAMA_PEMERIKSAAN`,
				IFNULL(a.L,0) AS `L`,
				IFNULL(b.P,0) AS `P` FROM
				(
				SELECT pemeriksaan_laborat.NAMA_PEM_LABORAT AS `NAMA_PEMERIKSAAN`,
				pemeriksaan_laborat.ID_PEM_LABORAT AS `ID_PEMERIKSAAN`
				FROM cek_laborat
				LEFT JOIN riwayat_rm
				ON cek_laborat.ID_RIWAYAT_RM = riwayat_rm.ID_RIWAYAT_RM
				LEFT JOIN rekam_medik
				ON rekam_medik.ID_REKAMMEDIK = riwayat_rm.ID_REKAMMEDIK
				LEFT JOIN pasien
				ON pasien.ID_PASIEN = rekam_medik.ID_PASIEN
				LEFT JOIN pemeriksaan_laborat
				ON pemeriksaan_laborat.ID_PEM_LABORAT = cek_laborat.ID_PEM_LABORAT
				LEFT JOIN unit
				ON unit.ID_UNIT = pemeriksaan_laborat.ID_UNIT
				WHERE unit.ID_GEDUNG = '.$idgedung.' AND MONTH(cek_laborat.TANGGAL_TES_LAB) = '.$bulan.' AND YEAR(cek_laborat.TANGGAL_TES_LAB) = '.$tahun.'
				) main
				LEFT JOIN
				(
				SELECT pemeriksaan_laborat.NAMA_PEM_LABORAT AS `NAMA_PEMERIKSAAN`,
				pemeriksaan_laborat.ID_PEM_LABORAT AS `ID_PEMERIKSAAN`,
				COUNT(pasien.ID_PASIEN) AS `L`
				FROM cek_laborat
				LEFT JOIN riwayat_rm
				ON cek_laborat.ID_RIWAYAT_RM = riwayat_rm.ID_RIWAYAT_RM
				LEFT JOIN rekam_medik
				ON rekam_medik.ID_REKAMMEDIK = riwayat_rm.ID_REKAMMEDIK
				LEFT JOIN pasien
				ON pasien.ID_PASIEN = rekam_medik.ID_PASIEN
				LEFT JOIN pemeriksaan_laborat
				ON pemeriksaan_laborat.ID_PEM_LABORAT = cek_laborat.ID_PEM_LABORAT
				LEFT JOIN unit
				ON unit.ID_UNIT = pemeriksaan_laborat.ID_UNIT
				WHERE unit.ID_GEDUNG = '.$idgedung.' AND MONTH(cek_laborat.TANGGAL_TES_LAB) = '.$bulan.' AND YEAR(cek_laborat.TANGGAL_TES_LAB) = '.$tahun.' AND pasien.GENDER_PASIEN = "Laki-Laki"
				) a
				ON a.ID_PEMERIKSAAN = main.ID_PEMERIKSAAN
				LEFT JOIN
				(
				SELECT pemeriksaan_laborat.NAMA_PEM_LABORAT AS `NAMA_PEMERIKSAAN`,
				pemeriksaan_laborat.ID_PEM_LABORAT AS `ID_PEMERIKSAAN`,
				COUNT(pasien.ID_PASIEN) AS `P`
				FROM cek_laborat
				LEFT JOIN riwayat_rm
				ON cek_laborat.ID_RIWAYAT_RM = riwayat_rm.ID_RIWAYAT_RM
				LEFT JOIN rekam_medik
				ON rekam_medik.ID_REKAMMEDIK = riwayat_rm.ID_REKAMMEDIK
				LEFT JOIN pasien
				ON pasien.ID_PASIEN = rekam_medik.ID_PASIEN
				LEFT JOIN pemeriksaan_laborat
				ON pemeriksaan_laborat.ID_PEM_LABORAT = cek_laborat.ID_PEM_LABORAT
				LEFT JOIN unit
				ON unit.ID_UNIT = pemeriksaan_laborat.ID_UNIT
				WHERE unit.ID_GEDUNG = '.$idgedung.' AND MONTH(cek_laborat.TANGGAL_TES_LAB) = '.$bulan.' AND YEAR(cek_laborat.TANGGAL_TES_LAB) = '.$tahun.' AND pasien.GENDER_PASIEN = "Perempuan"
				) b
				ON main.ID_PEMERIKSAAN = b.ID_PEMERIKSAAN';
		$query = $this->db->query ($sql);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
	
}