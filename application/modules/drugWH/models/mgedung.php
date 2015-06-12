<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

// Tabel Gedung
class mGedung extends CI_Model {

    function __construct () {
        parent::__construct();
    }
	
	// Get semua data puskesmas
	// like %Puskesmas%
	function getAllPuskesmas (){
		$this->db->like('nama_gedung', 'Puskesmas');
		$query = $this->db->get ('gedung');
		if ($query -> num_rows() > 0) {
			return $query -> result_array();
		}
		else 
			return null;
	}

}