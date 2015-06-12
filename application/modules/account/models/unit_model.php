<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Unit_model extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct ();
		$this->table = 'unit';
	}
	
	function getUnitByHC () {
		$id_gedung = $this->session->userdata['telah_masuk']['idgedung'];
		$this->db->where ('id_gedung', $id_gedung); 
		$this->db->where("(flag_distribusi_obat=3 OR flag_distribusi_obat=4 OR flag_distribusi_obat=2 OR nama_unit like 'Loket Pendaftaran' OR nama_unit like 'Tata Usaha') AND nama_unit not like '%Gudang Obat%'", NULL, FALSE);
		$query = $this->db->get ($this->table);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
	
	function getUnitByHCGFK () {
		$id_gedung = $this->session->userdata['telah_masuk']['idgedung'];
		$this->db->where ('id_gedung', $id_gedung); 
		$this->db->where ('flag_distribusi_obat', 1);
		$this->db->where ("(nama_unit <> 'Kepala GFK' AND nama_unit <> 'Admin GFK' AND nama_unit <> 'Operator GFK' AND nama_unit <> 'Operator')", NULL, FALSE);
		$query = $this->db->get ($this->table);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
	
	function insertNewEntry($data) {
        if ($this->db->insert('unit', $data)){
            return true;
        }
        return false;
    }
	
	function getUnitById ($id) {
		$this->db->where ('id_unit', $id); 
		$query = $this->db->get ($this->table);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
	
	function getUnitByName ($name) {
		$this->db->where ('nama_unit', $name); 
		$query = $this->db->get ($this->table);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
}