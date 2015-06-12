<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mIcd extends CI_Model {
	
	private $table;
	
	function __construct() {
		parent::__construct();
		$this->table = 'icd_table';		
	}
	
	public function getAllEntry ($text) {
		$sql = "select ID_ICD, CONCAT(CATEGORY, '.', SUBCATEGORY) as KODE_ICD_X, ENGLISH_NAME, INDONESIAN_NAME from icd_table where icd_table.INDONESIAN_NAME LIKE '%".$text."%' or icd_table.ENGLISH_NAME LIKE '%".$text."%'";
		$query = $this->db->query ($sql);
		if ($query->num_rows> 0) {
			return $query->result_array ();
		}
		else
			return null;
	}
	
	public function getEntryByQuery ($name) {
		$this->db->like ('indonesian_name', $name);
		$query = $this->db->get ($this->table);
		if ($query->num_rows> 0) {
			return array_slice($query->result_array (), 0, 20);
		}
		else
			return null;
	}
	
	public function getEntryById ($id) {
		$this->db->where ('ID_ICD', $id);
		$query = $this->db->get ($this->table);
		if ($query->num_rows> 0) {
			$arr = $query->result_array ();
			return $arr[0];
		}
		else
			return null;
	}
}