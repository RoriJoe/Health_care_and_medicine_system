<?php if (!defined('BASEPATH'))     
exit('No direct script access allowed');

class mDrugs extends CI_Model {
	private $table;
	
	// constructor
    function __construct () {
        parent::__construct();
		$this->table = 'obat';
    }
    
	// insert data baru
    function insertNewEntry ($data) {
        if ($this->db->insert('obat', $data)){ return true; }
        else { return false; }
    }
	
	// untuk kulakan
	function getAllDrugsName () {		
		return $this->db->get($this->table)->result_array ();
	}

	// stok obat untuk unit ini
    function getAllEntry () {
		// tinggal tambahin not in nya hehe
		$sql = 'SELECT * from ( SELECT j.*, SUM(j.STOK_OBAT_SEKARANG) AS TOTAL FROM
				(
				SELECT * FROM
				(
				SELECT * FROM view_stok_obat_unit_terkini
				WHERE view_stok_obat_unit_terkini.ID_UNIT = '.$this->session->userdata['telah_masuk']['idunit'].' 
				AND view_stok_obat_unit_terkini.EXPIRED_DATE > NOW()
				) AS h 
				GROUP BY h.NOMOR_BATCH, h.ID_OBAT 
				ORDER BY h.EXPIRED_DATE ASC
				) AS j
				WHERE j.ID_JENISTRANSAKSI NOT IN (26)
				GROUP BY j.ID_OBAT) AS komplit WHERE komplit.TOTAL > 0 ORDER BY komplit.NAMA_OBAT';
    	$query = $this->db->query ($sql);
    	if ($query->num_rows() > 0) {
			$result = $query->result_array ();
			return $result;
		}
    	else { return null; }
    }
	
	function getAllDetailEntry ($id_obat) {
		$sql = 'select j.*, DATE_FORMAT(j.EXPIRED_DATE,"%d %M %Y") as TANGGAL_KADALUARSA from
				(
				select * from
				(
				select * from view_stok_obat_unit_terkini
				where view_stok_obat_unit_terkini.ID_UNIT = '.$this->session->userdata['telah_masuk']['idunit'].' 	
				AND view_stok_obat_unit_terkini.EXPIRED_DATE > NOW()				
				) as h 
				GROUP BY h.NOMOR_BATCH, h.ID_OBAT
				order by h.EXPIRED_DATE ASC
				) as j
				where j.ID_JENISTRANSAKSI NOT IN (26) and j.STOK_OBAT_SEKARANG>0 and j.ID_OBAT = '.$id_obat;
		$query = $this->db->query ($sql);
    	if ($query->num_rows() > 0) {
			$result = $query->result_array ();
			return $result;
		}
    	else { return null; }
	}
	
	function getAllEntryUnused () {
		// tinggal tambahin not in nya hehe
		$sql = 'SELECT j.*, DATE_FORMAT(j.EXPIRED_DATE, "%d %M %Y") as TGL_KADALUARSA, transaksi_obat.KETERANGAN_TRANSAKSI_OBAT AS KETERANGAN FROM
				(
				SELECT * FROM
				(
				SELECT * FROM view_stok_obat_unit_terkini
				WHERE view_stok_obat_unit_terkini.ID_UNIT = '.$this->session->userdata['telah_masuk']['idunit'].' 
				) AS h 
				GROUP BY h.NOMOR_BATCH, h.ID_OBAT
				ORDER BY h.EXPIRED_DATE ASC
				) AS j
				LEFT JOIN transaksi_obat
				ON transaksi_obat.ID_TRANSAKSI = j.ID_TRANSAKSI
				WHERE j.ID_JENISTRANSAKSI IN (26) ORDER BY j.ID_TRANSAKSI DESC';
    	$query = $this->db->query ($sql);
    	if ($query->num_rows() > 0) {
			$result = $query->result_array ();
			return $result;
		}
    	else { return null; }
    }
	
	// stok sisa dari gfk
	function getGFKRemain () {
    	$sql = 	'SELECT temp.*, tempo.TOTAL FROM 
				(
				SELECT * FROM (SELECT * FROM view_stok_obat_unit_terkini WHERE view_stok_obat_unit_terkini.ID_UNIT = '.$this->session->userdata['telah_masuk']['idunit'].') AS hai 
				WHERE expired_date <= DATE_ADD(NOW(), INTERVAL 1 MONTH)
				GROUP BY hai.NOMOR_BATCH, hai.ID_OBAT
				) AS temp

				LEFT JOIN

				(
				SELECT * FROM
				(
				SELECT j.*, SUM(j.STOK_OBAT_SEKARANG) AS TOTAL FROM
				(
				SELECT * FROM(SELECT * FROM view_stok_obat_unit_terkini WHERE view_stok_obat_unit_terkini.ID_UNIT = '.$this->session->userdata['telah_masuk']['idunit'].' ) AS h 
				GROUP BY h.NOMOR_BATCH, h.ID_OBAT
				ORDER BY h.EXPIRED_DATE ASC
				) AS j
				WHERE j.ID_JENISTRANSAKSI NOT IN (26)
				GROUP BY j.ID_OBAT 
				) AS allObat

				) AS tempo
				ON temp.ID_OBAT = tempo.ID_OBAT
				WHERE temp.ID_JENISTRANSAKSI NOT IN (26)'; // where expired_date > now()';
    	$query = $this->db->query ($sql);
    	if ($query->num_rows() > 0) return $query->result_array();
    	else { return null; }
    }
    
	// delete by id obat
	// tidak boleh sebenernya
    function deleteById ($param) {
        if ($this->db->delete('obat', array('ID_OBAT'=> $param))) { return true; }
        else { return false; }
    }
    
	// update by kode obat
    function updateEntry ($id, $data) {
        $this->db->where('kode_obat', $id);        
        if ($this->db->update('obat', $data)) { return true; }
        else { return false; }
    }
}