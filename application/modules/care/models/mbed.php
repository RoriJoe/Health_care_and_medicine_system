<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mBed extends CI_Model {

	private $table, $primary_id;
	public function __construct () {
		parent::__construct ();
		$this->table = 'TEMPAT_TIDUR';
		$this->primary_id = 'ID_RUANGAN_RI';
	}
	
	public function getAllEntry () {
		$sql = 'SELECT tempat_tidur.*, kategori_tempat_tidur.NAMA_KATEGORI_TT, ruangan_ri.NAMA_RUANGAN_RI,
				ruangan_ri.ID_UNIT FROM tempat_tidur 
				left join kategori_tempat_tidur
				on tempat_tidur.ID_KAT_TT = kategori_tempat_tidur.ID_KAT_TT
				left join ruangan_ri
				on tempat_tidur.ID_RUANGAN_RI = ruangan_ri.ID_RUANGAN_RI where ruangan_ri.ID_UNIT = '.$this->session->userdata['telah_masuk']['idunit'];
		$query = $this->db->query($sql);
		if ($query->num_rows > 0) return $query->result_array();
		else return null;
	}
        
        public function getAllEntry_byUnit($idunit) {
		$sql = "SELECT tempat_tidur.*, kategori_tempat_tidur.NAMA_KATEGORI_TT, ruangan_ri.NAMA_RUANGAN_RI,
				ruangan_ri.ID_UNIT FROM tempat_tidur 
				left join kategori_tempat_tidur
				on tempat_tidur.ID_KAT_TT = kategori_tempat_tidur.ID_KAT_TT
				left join ruangan_ri
				on tempat_tidur.ID_RUANGAN_RI = ruangan_ri.ID_RUANGAN_RI
				where ruangan_ri.ID_UNIT = $idunit";
		$query = $this->db->query($sql);
		if ($query->num_rows > 0) return $query->result_array();
		else return null;
	}
	
	public function getBedCategory () {
		$query = $this->db->get('kategori_tempat_tidur');
		return $query->result_array();
	}
	
	public function insertNewEntry ($data) {
		if ($this->db->insert($this->table, $data)) {
			return true;
		}
		else return null;
	}
	
	public function deleteEntry ($id) {
		$this->db->where ($primary_id, $id);
		$query = $this->db->get ($this->table);
		if ($query->num_rows >0) {
			return $query->result_array();
		}
		else return null;
	}
	
	public function getRemainBed () {
		$sql ='SELECT tempat_tidur.*, kategori_tempat_tidur.NAMA_KATEGORI_TT, 	ruangan_ri.NAMA_RUANGAN_RI,
				ruangan_ri.ID_UNIT FROM tempat_tidur 
				left join kategori_tempat_tidur
				on tempat_tidur.ID_KAT_TT = kategori_tempat_tidur.ID_KAT_TT
				left join ruangan_ri
				on tempat_tidur.ID_RUANGAN_RI = ruangan_ri.ID_RUANGAN_RI
				where tempat_tidur.ID_TEMPAT_TIDUR not in
				(select data_rawat_inap.ID_TEMPAT_TIDUR from data_rawat_inap where data_rawat_inap.FLAG_OPNAME=1) and ruangan_ri.ID_UNIT = '.$this->session->userdata['telah_masuk']['idunit'];
		$query = $this->db->query($sql);
		if ($query->num_rows > 0) return $query->result_array();
		else return null;
	}
        
        public function getRemainBed_byUnit($idunit) {
		$sql ="SELECT tempat_tidur.*, kategori_tempat_tidur.NAMA_KATEGORI_TT, ruangan_ri.NAMA_RUANGAN_RI,
				ruangan_ri.ID_UNIT FROM tempat_tidur 
				left join kategori_tempat_tidur
				on tempat_tidur.ID_KAT_TT = kategori_tempat_tidur.ID_KAT_TT
				left join ruangan_ri
				on tempat_tidur.ID_RUANGAN_RI = ruangan_ri.ID_RUANGAN_RI
				where tempat_tidur.ID_TEMPAT_TIDUR not in
				(select data_rawat_inap.ID_TEMPAT_TIDUR from data_rawat_inap where data_rawat_inap.FLAG_OPNAME=1)
                                and ruangan_ri.ID_UNIT = $idunit";
		$query = $this->db->query($sql);
		if ($query->num_rows > 0) return $query->result_array();
		else return null;
	}
}