<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mSource extends CI_Model {

	private $table;
	
    function __construct () {
        parent::__construct();
		$this->table = 'sumber_anggaran_obat';
    }
	
	function getAllEntry () {
		$query = $this->db->get ($this->table);
		if ($query->num_rows>0) return $query->result_array();
		else return null;
	}
    
}