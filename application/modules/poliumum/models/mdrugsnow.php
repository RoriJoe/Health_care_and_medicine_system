<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mDrugsNow extends CI_Model {

	function __construct () {
		parent::__construct();
	}
	
	function insertNewEntry ($data) {
		if ($this->db->insert('stok_obat_sekarang', $data)) {
			return true;
		}
		return false;
	}
	
	function updateEntry ($data) {
		if ($this->session->userdata('idunittujuan') == null) {
			$sql = 'update stok_obat_sekarang set JUMLAH_OBAT_SEKARANG = JUMLAH_OBAT_SEKARANG + '
			.$data['jumlah_obat_sekarang'].' where ID_UNIT='.$data['id_unit'].' and id_obat ='
			.$data['id_obat'];
		}
		else {
			$sql = 'update stok_obat_sekarang set JUMLAH_OBAT_SEKARANG = JUMLAH_OBAT_SEKARANG - '
			.$data['jumlah_obat_sekarang'].' where ID_UNIT='.$data['id_unit'].' and id_obat ='
			.$data['id_obat'];
		}
		$this->db->query($sql);
		if ($this->db->affected_rows() > 0){
			return true;
		}
		else {
			return $this->insertNewEntry($data);
		}
		return false;
	}
	
	function getEntryByHC ($id_gedung) {
		$sql = 'select stok_obat_sekarang.ID_OBAT, obat.KODE_OBAT, 
				obat.NAMA_OBAT, sum(stok_obat_sekarang.JUMLAH_OBAT_SEKARANG) as JUMLAH_OBAT_SEKARANG  from stok_obat_sekarang
				left join unit
				on stok_obat_sekarang.ID_UNIT = unit.ID_UNIT
				left join gedung
				on unit.ID_GEDUNG = gedung.ID_GEDUNG
				left join obat
				on obat.ID_OBAT = stok_obat_sekarang.ID_OBAT
				where unit.ID_GEDUNG = '.$id_gedung.' group by stok_obat_sekarang.ID_OBAT';
		$query = $this->db->query ($sql);
		if ($query->num_rows>0) return $query->result_array();
		else return null;
	}
	
	function getEntryByUnit ($id_unit){
		$sql = 'call stok_semua_obat_unit('.$id_unit.')';
		$query = $this->db->query ($sql);
		if ($query->num_rows>0) return $query->result_array();
		else return null;
	}
}