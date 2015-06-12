<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Sdm_model extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct ();
		$this->table = 'view_sdm';
	}
	
	function getSDMByHC ($idgedung) {
		$this->db->where ('id_gedung', $idgedung); 
		$this->db->or_where ('id_puskesmas', $idgedung); 
		$query = $this->db->get ($this->table);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
}