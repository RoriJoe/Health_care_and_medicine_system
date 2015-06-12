<?php if (!defined('BASEPATH'))     
	exit('No direct script access allowed');

class mUnit extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct ();
		$this->table = 'unit';
	}
	
	function getUnitsByHC ($id_gedung) {
		$this->db->where ('id_gedung = '. $id_gedung. ' and flag_distribusi_obat IN (3, 4)' ); 
		// $this->db->where ('flag_distribusi_obat', 4);
		// $this->db->or_where ('flag_distribusi_obat', 3);
		$query = $this->db->get ($this->table);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
	
	function getDrugsWHHC () {
		$sql = "select unit.ID_GEDUNG, unit.ID_UNIT, unit.NAMA_UNIT, gedung.NAMA_GEDUNG from unit
				left join gedung on unit.ID_GEDUNG = gedung.ID_GEDUNG
				where unit.NAMA_UNIT like '%Gudang Obat Puskesmas%'";
		$query = $this->db->query($sql);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
	
	function getOgfkUnitID (){
		$this->db->like('nama_unit', 'Operator GFK');
		$query = $this->db->get($this->table);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}

}