<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Sbbk_model extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct ();
		$this->table = 'view_drug_used';
	}
	
	function getkkbatch ($idtrans='') {
		$sql = 'CALL sbbk_gfk('.$idtrans.')';
		$query = $this->db->query($sql);
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows() > 0) return $hasil; 
		return null;
	}
	
	function getkk ($idtrans='') {
		$sql = 'CALL sbbk_gfk_umum('.$idtrans.')';
		$query = $this->db->query($sql);
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows() > 0) return $hasil; 
		return null;
	}
}