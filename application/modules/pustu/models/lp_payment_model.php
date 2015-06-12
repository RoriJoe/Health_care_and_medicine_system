<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Lp_payment_model extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct ();
		$this->table = 'sumber_pembayaran_pasien';
	}
	
	function getAllEntry () {
		$query = $this->db->get($this->table);		
		if ($query-> num_rows > 0) return $query->result_array();
		return null;
	}	

}