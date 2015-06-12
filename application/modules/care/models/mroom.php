<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mRoom extends CI_Model {

	private $table, $primary_id;
	public function __construct () {
		parent::__construct ();
		$this->table = 'RUANGAN_RI';
		$this->primary_id = 'ID_TEMPAT_TIDUR';
	}
	
	public function getAllEntry () {
		$query = $this->db->get ($this->table);
		if ($query->num_rows > 0) return $query->result_array();
		else return null;
	}
	
	public function insertNewEntry ($data) {
		if ($this->db->insert($this->table, $data)) {
			return true;
		}
		else return false;
	}
	
	public function deleteEntry ($id) {
		$this->db->where ($primary_id, $id);
		$query = $this->db->get ($this->table);
		if ($query->num_rows >0) {
			return $query->result_array();
		}
		else return null;
	}
}