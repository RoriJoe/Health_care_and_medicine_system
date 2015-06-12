<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Vpenugasan_akun extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct ();
		$this->table = 'view_penugasan_akun';
	}
	
	function getUnitByIdAkun () {
		$id_gedung = $this->session->userdata['telah_masuk']['idgedung'];
		$id_akun = $this->session->userdata['telah_masuk']['idakun'];
		$this->db->where ('ID_GEDUNG', $id_gedung); 
		$this->db->where ('ID_AKUN', $id_akun);
		$query = $this->db->get ($this->table);
        return $query->result();
	}
	
	function getMonitoringStok () {
		$id_gedung = $this->session->userdata['telah_masuk']['idgedung'];
		$id_akun = $this->session->userdata['telah_masuk']['idakun'];
		$this->db->where ('ID_GEDUNG', $id_gedung); 
		$this->db->where ('ID_AKUN', $id_akun);
		$query = $this->db->get ($this->table);
        return $query->result();
	}
}