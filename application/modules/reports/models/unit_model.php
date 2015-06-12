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
		if($this->session->userdata['telah_masuk']['idha'] == 16 || $this->session->userdata['telah_masuk']['idha'] == 17 || $this->session->userdata['telah_masuk']['idha'] == 18)
		
		$this->db->where ('(flag_distribusi_obat = 4 or flag_distribusi_obat = 3 or flag_distribusi_obat = 2 or flag_distribusi_obat = 1)');
		else
		$this->db->where ('(flag_distribusi_obat = 4 or flag_distribusi_obat = 3 or flag_distribusi_obat = 2)');
		$query = $this->db->get ($this->table);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
	
	function getGOPID ($idGedung) {
		$flagChooser = $this->selectByIdPus($idGedung);
		$this->db->where ('id_gedung', $idGedung); 
		if($flagChooser[0]['FLAG_GEDUNG'] != 2)
			$this->db->where ('nama_unit', 'Gudang Obat Puskesmas');
		else
			$this->db->where ('nama_unit', 'Operator GFK');
		$query = $this->db->get ($this->table);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
	
	function getHozpitalizeByHC () {
		$id_gedung = $this->session->userdata['telah_masuk']['idgedung'];
		$this->db->where ('id_gedung', $id_gedung); 
		$this->db->like ('nama_unit', 'Rawat Inap'); 
		$this->db->where ("(flag_distribusi_obat='3' OR flag_distribusi_obat='2' OR flag_distribusi_obat='4')", NULL, FALSE);
		$query = $this->db->get ($this->table);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
	
	function getUnitByInputHC ($id='') {
		if($id == '')
			$id_gedung = $this->session->userdata['telah_masuk']['idgedung'];
		else
			$id_gedung = $id;
		
		$this->db->where ('id_gedung', $id_gedung); 
		// $this->db->or_where ('flag_distribusi_obat', 3);
		$query = $this->db->get ($this->table);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
	
	function getUnitById ($id) {
		$this->db->where ('id_unit', $id); 
		$query = $this->db->get ($this->table);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
	
	function selectByIdPus ($id) {
        $this->db->from('gedung');
        $this->db->where('id_gedung', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
}