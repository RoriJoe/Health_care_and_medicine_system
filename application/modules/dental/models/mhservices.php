<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mHServices extends CI_Model {

	private $table;
	function __construct () {
		parent::__construct();		
		$this->table= "layanan_kesehatan";
	}
	
	function getAllEntry () {
		return $this->db->get($this->table)->result_array();
	}
	
	function getEntryById ($id_rrm) {
		$sql = 'SELECT layanan_kesehatan.* FROM spo.tindakan_pasien
				left join layanan_kesehatan
				on tindakan_pasien.ID_LAYANAN_KES = layanan_kesehatan.ID_LAYANAN_KES
				where tindakan_pasien.ID_RIWAYAT_RM = '.$id_rrm;
		$query = $this->db->query ($sql);
		return $query->result_array();
	}
}
	