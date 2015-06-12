<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Inventaris_model extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct ();
		$this->table = 'view_inventori';
	}
	
	function getAllEntry ($idPuskesmas='',$from='', $till='') {
		$this->db->where ('id_gedung', $idPuskesmas); 
		$this->db->where ('tahun_pembelian_barang <=', $till);
		$this->db->where ('tahun_pembelian_barang >', $from);
		$query = $this->db->get ($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }
}