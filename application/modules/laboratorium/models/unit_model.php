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
		$this->db->where ('flag_distribusi_obat', 4);
		$query = $this->db->get ($this->table);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
        
        function getGedung()
        {
            $id_gedung = $this->session->userdata['telah_masuk']['idgedung'];
            $this->db->where ('id_gedung', $id_gedung); 
            $query = $this->db->get ('gedung');
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
        }

}