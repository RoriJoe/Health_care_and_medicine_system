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

    public function getProfilMRH($id) {
        $sql = 'SELECT *
FROM pasien 
left join rekam_medik on pasien.ID_PASIEN = rekam_medik.ID_PASIEN
left join riwayat_rm on riwayat_rm.ID_REKAMMEDIK = rekam_medik.ID_REKAMMEDIK
where riwayat_rm.ID_RIWAYAT_RM = ' . $id;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return null;
    }

    public function getMRHById($id) {
        $this->db->where('id_riwayat_rm', $id);
        $query = $this->db->get('riwayat_rm');
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return null;
    }

    public function getMRHByIdMR($idRekammedik, $limit) {
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $sql = 'SELECT pasien.NAMA_PASIEN, riwayat_rm.TANGGAL_RIWAYAT_RM AS 	
                TANGGAL_KUNJUNGAN, riwayat_rm.ID_RIWAYAT_RM, `antrian_unit`.`ID_UNIT`
                FROM rekam_medik
                LEFT JOIN pasien ON rekam_medik.ID_PASIEN = pasien.ID_PASIEN
                LEFT JOIN riwayat_rm ON rekam_medik.ID_REKAMMEDIK = riwayat_rm.ID_REKAMMEDIK
                RIGHT JOIN `antrian_unit` ON `antrian_unit`.`ID_RIWAYAT_RM`=`riwayat_rm`.`ID_RIWAYAT_RM`
                WHERE rekam_medik.ID_REKAMMEDIK =? AND `antrian_unit`.`ID_UNIT`=?
                ORDER BY riwayat_rm.ID_RIWAYAT_RM DESC ';
        if ($limit != null) {
            $sql .= 'LIMIT ' . $limit;
        }
        $query = $this->db->query($sql, array($idRekammedik, $idUnit));
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    public function updateEntry($data, $id) {
        $this->db->query('SET foreign_key_checks = 0');
        $this->db->where('id_riwayat_rm', $id);
        if ($this->db->update('riwayat_rm', $data)) {
            $this->db->query('SET foreign_key_checks = 1');
            return true;
        } else {
            $this->db->query('SET foreign_key_checks = 1');
            return false;
        }
    }

    public function getHistoryRRM($idUnit) {
        $sql = 'select rm.id_rekammedik, rm.noid_rekammedik, rrm.id_riwayat_rm, p.id_pasien
                , p.nama_pasien,p.alamat_pasien, rrm.beratbadan_pasien, rrm.tinggibadan_pasien
                , rrm.sistol_pasien, rrm.diastol_pasien, rrm.tanggal_riwayat_rm, au.id_unit 
                , noid_pasien, gender_pasien, telepon_pasien, gol_darah_pasien, agama_pasien
                from antrian_unit au 
                left join riwayat_rm rrm on au.id_riwayat_rm = rrm.id_riwayat_rm 
                left join rekam_medik rm on rm.id_rekammedik = rrm.id_rekammedik 
                left join pasien p on p.id_pasien = rm.id_pasien where au.flag_antrian_unit = 1 and au.id_unit=?
                ORDER BY rrm.id_riwayat_rm DESC';
        $query = $this->db->query($sql, array($idUnit));
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return null;
    }

    public function getResepPasien($idUnit) {
        $sql = 'SELECT rm.id_rekammedik, rm.noid_rekammedik, rrm.id_riwayat_rm, p.id_pasien
                , p.nama_pasien,p.alamat_pasien, rrm.beratbadan_pasien, rrm.tinggibadan_pasien
                , rrm.sistol_pasien, rrm.diastol_pasien, rrm.tanggal_riwayat_rm, au.id_unit 
                , noid_pasien, gender_pasien, telepon_pasien, gol_darah_pasien, agama_pasien
                FROM antrian_unit au 
                LEFT JOIN riwayat_rm rrm ON au.id_riwayat_rm = rrm.id_riwayat_rm 
                LEFT JOIN rekam_medik rm ON rm.id_rekammedik = rrm.id_rekammedik 
                LEFT JOIN pasien p ON p.id_pasien = rm.id_pasien 
                WHERE au.flag_antrian_unit = 1 AND au.id_unit=?
                GROUP BY rm.id_rekammedik
                ORDER BY rrm.id_riwayat_rm DESC';
        $query = $this->db->query($sql, array($idUnit));
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return null;
    }

    public function getMedRecord($id_unit) {
        $sql = 'select rm.id_rekammedik, rm.noid_rekammedik, p.id_pasien, 		
                p.nama_pasien,p.alamat_pasien from antrian_unit au 
                left join riwayat_rm rrm on au.id_riwayat_rm = rrm.id_riwayat_rm 
                left join rekam_medik rm on rm.id_rekammedik = rrm.id_rekammedik 
                left join pasien p on p.id_pasien = rm.id_pasien 
                where au.flag_antrian_unit = 1 and au.id_unit= ' . $id_unit . '
                group by rm.id_rekammedik
                order by au.id_antrian_unit desc';
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return null;
    }

}
