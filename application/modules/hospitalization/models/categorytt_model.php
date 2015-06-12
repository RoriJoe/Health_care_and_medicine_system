<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Categorytt_model extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct ();
		$this->table = 'kategori_tempat_tidur';
	}
	
	function getAllCTT () {
		$query = $this->db->get ($this->table);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
}