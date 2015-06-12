<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mLabCheck extends CI_Model {
	
	function getAllEntry () {
		$res = $this->db->get('pemeriksaan_laborat');
		return $res->result_array();
	}
	
	function insertNewEntry ($data) {
		$this->db->insert('cek_laborat', $data);
	}
	
	function getEntryById ($id_rrm) {
		$sql = 'SELECT cek_laborat.*, pemeriksaan_laborat.NAMA_PEM_LABORAT FROM spo.cek_laborat
				left join pemeriksaan_laborat
				on cek_laborat.ID_PEM_LABORAT = pemeriksaan_laborat.ID_PEM_LABORAT
				where cek_laborat.ID_RIWAYAT_RM = '.$id_rrm;
		$query = $this->db->query ($sql);
		return $query->result_array();
	}

}