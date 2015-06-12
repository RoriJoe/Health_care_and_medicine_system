<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mAction extends CI_Model {
	
	function insertNewEntry ($data) {
		$this->db->insert('tindakan_pasien', $data);
		return true;
	}

}