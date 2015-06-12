<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mMRHistory extends CI_Model {

	public function __construct () {
		parent::__construct ();
	}
	
	public function insertNewEntry ($data) {
		if ($this->db->insert('riwayat_rm', $data)) {
			return $this->db->insert_id();
		}
	}
	
	public function getMRHById ($id) {
		$this->db->where ('id_riwayat_rm', $id);
		$query = $this->db->get ('riwayat_rm');
		if ($query->num_rows()>0) return $query->result_array();
		else return null;
	}
	
	public function getMRHByIdMR($id) {
		$sql = 'select riwayat_rm.ID_REKAMMEDIK, status_kasus.NAMA_STATUS_KASUS, 
riwayat_rm.TANGGAL_RIWAYAT_RM, riwayat_rm.BERATBADAN_PASIEN, 
riwayat_rm.TINGGIBADAN_PASIEN, riwayat_rm.SISTOL_PASIEN,
riwayat_rm.DIASTOL_PASIEN, keluhan_pasien.DESKRIPSI_KELUHAN, diagnosa_pasien.DESKRIPSI_DP from riwayat_rm
left join keluhan_pasien
on keluhan_pasien.ID_RIWAYAT_RM = riwayat_rm.ID_RIWAYAT_RM
left join diagnosa_pasien
on diagnosa_pasien.ID_RIWAYAT_RM = keluhan_pasien.ID_RIWAYAT_RM
left join status_kasus on status_kasus.ID_STATUS_KASUS = riwayat_rm.ID_STATUS_KASUS
where riwayat_rm.ID_REKAMMEDIK = '.$id;
		$query = $this->db->query ($sql);
		if ($query->num_rows()>0) return $query->result_array();
		else return null;
	}
	
	public function updateEntry ($data, $id) {
		$this->db->where ('id_riwayat_rm', $id);
		if ( $this->db->update ('riwayat_rm', $data) ){
			return true;
		}
		else return false;
	}
	
	public function getHistoryRRM ($id) {
		$sql = 'select rm.id_rekammedik, rm.noid_rekammedik, rrm.id_riwayat_rm, p.id_pasien, p.nama_pasien,p.alamat_pasien, rrm.beratbadan_pasien, rrm.tinggibadan_pasien, rrm.sistol_pasien, rrm.diastol_pasien, rrm.tanggal_riwayat_rm, au.id_unit from antrian_unit au left join riwayat_rm rrm
				on au.id_riwayat_rm = rrm.id_riwayat_rm left join rekam_medik rm
				on rm.id_rekammedik = rrm.id_rekammedik left join pasien p on p.id_pasien = rm.id_pasien where au.id_unit='.$id;
		$query = $this->db->query ($sql);
		if ($query->num_rows()>0) return $query->result_array();
		else return null;
	}
	
}