<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mMRHistory extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insertNewEntry($data) {
        if ($this->db->insert('riwayat_rm', $data)) {
            return $this->db->insert_id();
        }
    }

    public function getMRHById($id) {
        $this->db->where('id_riwayat_rm', $id);
        $query = $this->db->get('riwayat_rm');
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return null;
    }

    public function getMRHByIdMR($id, $limit) {
        if($limit!=null)
        {
            $sql = 'select pasien.NAMA_PASIEN, riwayat_rm.TANGGAL_RIWAYAT_RM as TANGGAL_KUNJUNGAN, riwayat_rm.ID_RIWAYAT_RM,
                    diagnosa_pasien.DESKRIPSI_DP as DIAGNOSA_KETERANGAN,
                    (if (icd_table.SUBCATEGORY = \'\', icd_table.CATEGORY, CONCAT(icd_table.CATEGORY,\'.\',icd_table.SUBCATEGORY))) as KODE_ICD_X, 
                    icd_table.INDONESIAN_NAME as NAMA_ICD,
                    riwayat_rm.NAMA_STATUS_KASUS as KASUS
                    from pasien
                    left join rekam_medik on (pasien.ID_PASIEN = rekam_medik.ID_PASIEN)
                    left join riwayat_rm on ( rekam_medik.ID_REKAMMEDIK = riwayat_rm.ID_REKAMMEDIK )
                    left join diagnosa_pasien on ( riwayat_rm.ID_RIWAYAT_RM = diagnosa_pasien.ID_RIWAYAT_RM )
                    left join icd_table on  ( diagnosa_pasien.ID_ICD = icd_table.ID_ICD)
                    where rekam_medik.ID_REKAMMEDIK = ' . $id . '
                    ORDER BY riwayat_rm.TANGGAL_RIWAYAT_RM DESC LIMIT '.$limit;
        }
        else
        {
            $sql = 'select pasien.NAMA_PASIEN, riwayat_rm.TANGGAL_RIWAYAT_RM as TANGGAL_KUNJUNGAN, riwayat_rm.ID_RIWAYAT_RM,
                    diagnosa_pasien.DESKRIPSI_DP as DIAGNOSA_KETERANGAN,
                    (if (icd_table.SUBCATEGORY = \'\', icd_table.CATEGORY, CONCAT(icd_table.CATEGORY,\'.\',icd_table.SUBCATEGORY))) as KODE_ICD_X, 
                    icd_table.INDONESIAN_NAME as NAMA_ICD,
                    riwayat_rm.NAMA_STATUS_KASUS as KASUS
                    from pasien
                    left join rekam_medik on (pasien.ID_PASIEN = rekam_medik.ID_PASIEN)
                    left join riwayat_rm on ( rekam_medik.ID_REKAMMEDIK = riwayat_rm.ID_REKAMMEDIK )
                    left join diagnosa_pasien on ( riwayat_rm.ID_RIWAYAT_RM = diagnosa_pasien.ID_RIWAYAT_RM )
                    left join icd_table on  ( diagnosa_pasien.ID_ICD = icd_table.ID_ICD)
                    where rekam_medik.ID_REKAMMEDIK = ' . $id . '
                    ORDER BY riwayat_rm.TANGGAL_RIWAYAT_RM DESC';
        }
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    public function updateEntry($data, $id) {
        $this->db->where('id_riwayat_rm', $id);
        if ($this->db->update('riwayat_rm', $data)) {
            return true;
        } else
            return false;
    }

    public function getHistoryRRM($id) {
        $sql = 'select rm.id_rekammedik, rm.noid_rekammedik, rrm.id_riwayat_rm, p.id_pasien, p.nama_pasien,p.alamat_pasien, rrm.beratbadan_pasien, rrm.tinggibadan_pasien, rrm.sistol_pasien, rrm.diastol_pasien, rrm.tanggal_riwayat_rm, au.id_unit from antrian_unit au left join riwayat_rm rrm
				on au.id_riwayat_rm = rrm.id_riwayat_rm left join rekam_medik rm
				on rm.id_rekammedik = rrm.id_rekammedik left join pasien p on p.id_pasien = rm.id_pasien where au.id_unit=' . $id;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return null;
    }

}
