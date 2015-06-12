<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mRinap extends CI_Model {

	private $table, $primary_id;
	public function __construct () {
		parent::__construct ();
		$this->table = 'DATA_RAWAT_INAP';
		$this->primary_id = 'ID_RAWAT_INAP';
	}
	
	public function getAllEntry () {
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0) return $query->result_array();
		else return null;
	}
	
	public function insertNewEntry ($data) {
		if ($this->db->insert($this->table, $data)) {
			return $this->db->insert_id();
		}
		else return -1;
	}
	
	public function deleteEntry ($id) {
		$this->db->where ($primary_id, $id);
		$query = $this->db->get ($this->table);
		if ($query->num_rows() >0) {
			return $query->result_array();
		}
		else return null;
	}
	
	public function updateEntry ($data, $id) {
		$this->db->where ($this->primary_id, $id);
		return $this->db->update($this->table, $data);		
	}
	
	public function getAllPasienKeluar ($idunit) {
		$sql = 'SELECT * FROM
				(
				SELECT 
				riwayat_rm.ID_RAWAT_INAP,
				pasien.NAMA_PASIEN,
				CONCAT(pasien.ALAMAT_PASIEN," RT.",pasien.RT_PASIEN, " RW.", pasien.RW_PASIEN," ", pasien.KELURAHAN_PASIEN) AS ALAMAT,
				DATE_FORMAT(data_rawat_inap.RI_START_OPNAME, "%d %b %Y %H:%i") AS MASUK_INAP,
				DATE_FORMAT(data_rawat_inap.RI_FINISH_OPNAME, "%d %b %Y %H:%i") AS KELUAR_INAP,
				CONCAT(TIMESTAMPDIFF(DAY, data_rawat_inap.RI_START_OPNAME ,data_rawat_inap.RI_FINISH_OPNAME), " hari") AS JML_HARI_INAP,
				IF (data_rawat_inap.STATUS_KELUAR_RI = 1, "SEHAT", IF (data_rawat_inap.STATUS_KELUAR_RI = 2, "MENINGGAL",IF (data_rawat_inap.STATUS_KELUAR_RI = 3, "PULANG PAKSA", IF (data_rawat_inap.STATUS_KELUAR_RI = 4, "DIRUJUK", "-" )))) AS STATUS_KELUAR,
				riwayat_rm.TEMPAT_RUJUKAN
				FROM data_rawat_inap
				LEFT JOIN riwayat_rm ON riwayat_rm.ID_RAWAT_INAP = data_rawat_inap.ID_RAWAT_INAP
				LEFT JOIN rekam_medik ON rekam_medik.ID_REKAMMEDIK = riwayat_rm.ID_REKAMMEDIK
				LEFT JOIN pasien ON pasien.ID_PASIEN = rekam_medik.ID_PASIEN
				LEFT JOIN tempat_tidur ON tempat_tidur.ID_TEMPAT_TIDUR = data_rawat_inap.ID_TEMPAT_TIDUR
				LEFT JOIN ruangan_ri ON ruangan_ri.ID_RUANGAN_RI = tempat_tidur.ID_RUANGAN_RI
				LEFT JOIN unit ON unit.ID_UNIT = ruangan_ri.ID_UNIT
				WHERE unit.ID_UNIT = ' .$idunit. ' AND data_rawat_inap.FLAG_OPNAME = 0
				ORDER BY riwayat_rm.ID_RIWAYAT_RM DESC
				) AS myTable GROUP BY myTable.ID_RAWAT_INAP';
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
			return $query->result_array ();			
		}
		else return null;
	}
}