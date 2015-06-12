<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mlab extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function getAllByUnit($id_unit) {
        $sql = "select au.id_antrian_unit, rrm.ID_RIWAYAT_RM, au.id_riwayat_rm, p.nama_pasien, p.GENDER_PASIEN, p.GOL_DARAH_PASIEN, p.TGL_LAHIR_PASIEN, au.waktu_antrian_unit from antrian_unit au left join riwayat_rm rrm on au.id_riwayat_rm = rrm.id_riwayat_rm
		left join rekam_medik rm on rrm.id_rekammedik = rm.id_rekammedik left join pasien p
		on p.id_pasien = rm.id_pasien where au.flag_antrian_unit = 0 and au.id_unit = " . $id_unit . " order by au.id_antrian_unit ASC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }
    
    function updateTest($pemId,$data)
    {
        $this->db->where('ID_PEM_LABORAT', $pemId);
        $this->db->update('pemeriksaan_laborat', $data);
    }
    
    function insertTest($data)
    {
        $this->db->insert('pemeriksaan_laborat', $data);
    }

    function getList_byUnit($idunit) {
        $this->db->where('ID_UNIT', $idunit);
        $query = $this->db->get('pemeriksaan_laborat');
        return $query->result();
    }

    public function convert($date) {
        return date("Y-m-d", strtotime($date));
    }

    function updateValueTest($id, $tgl, $hasil, $idpetugas) {
        $data = array(
            'TANGGAL_TES_LAB' => $this->convert($tgl),
            'HASIL_TES_LAB' => $hasil,
            'ID_PETUGAS_LAB' => $idpetugas,
        );
        $this->db->where('ID_CEK_LABORAT', $id);
        $this->db->update('cek_laborat', $data);
    }

    function insertNewValueTest($idrrm, $idpem, $tgl, $hasil, $idpetugas) {
        $data = array(
            'ID_RIWAYAT_RM' => $idrrm,
            'ID_PEM_LABORAT' => $idpem,
            'TANGGAL_TES_LAB' => $this->convert($tgl),
            'HASIL_TES_LAB' => $hasil,
            'ID_PETUGAS_LAB' => $idpetugas,
        );
        $this->db->insert('cek_laborat', $data);
    }

    function getTestList($idrrm) {
        $sql = "select pasien.NAMA_PASIEN, rekam_medik.NOID_REKAMMEDIK, riwayat_rm.ID_RIWAYAT_RM, riwayat_rm.UMUR_SAAT_INI,
                cek_laborat.ID_CEK_LABORAT, cek_laborat.TANGGAL_TES_LAB, cek_laborat.HASIL_TES_LAB, pemeriksaan_laborat.ID_PEM_LABORAT, 
                pemeriksaan_laborat.NAMA_PEM_LABORAT, kategori_pem_laborat.NAMA_KP_LABORAT, kategori_spesimen.NAMA_SPESIMEN
                from cek_laborat
                left join pemeriksaan_laborat on ( pemeriksaan_laborat.ID_PEM_LABORAT = cek_laborat.ID_PEM_LABORAT )
                left join kategori_pem_laborat on ( kategori_pem_laborat.ID_KP_LABORAT = pemeriksaan_laborat.ID_KP_LABORAT)
                left join kategori_spesimen on ( kategori_spesimen.ID_KAT_SPES = pemeriksaan_laborat.ID_KAT_SPES)
                left join riwayat_rm on ( riwayat_rm.ID_RIWAYAT_RM = cek_laborat.ID_RIWAYAT_RM)
                left join rekam_medik on ( rekam_medik.ID_REKAMMEDIK = riwayat_rm.ID_REKAMMEDIK)
                left join pasien on ( pasien.ID_PASIEN = rekam_medik.ID_PASIEN)
                where riwayat_rm.ID_RIWAYAT_RM = $idrrm";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function getCheckList($idunit) {
        $sql = "select pemeriksaan_laborat.ID_PEM_LABORAT, pemeriksaan_laborat.NAMA_PEM_LABORAT, 
            pemeriksaan_laborat.NILAI_NORMAL_UJI, pemeriksaan_laborat.SATUAN_HASIL_UJI, 
            pemeriksaan_laborat.NAMA_PEM_LABORAT as NAMA_PENGUJIAN, kategori_pem_laborat.ID_KP_LABORAT ,
kategori_pem_laborat.NAMA_KP_LABORAT, kategori_spesimen.NAMA_SPESIMEN, kategori_spesimen.ID_KAT_SPES
from pemeriksaan_laborat 
left join kategori_pem_laborat on kategori_pem_laborat.ID_KP_LABORAT = pemeriksaan_laborat.ID_KP_LABORAT
left join kategori_spesimen on kategori_spesimen.ID_KAT_SPES = pemeriksaan_laborat.ID_KAT_SPES
WHERE pemeriksaan_laborat.ID_UNIT = $idunit";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else
            return null;
    }

    function checkListNotChecked($idunit, $idrrm) {
        $sql = "select pemeriksaan_laborat.ID_PEM_LABORAT, pemeriksaan_laborat.NAMA_PEM_LABORAT as NAMA_PENGUJIAN,
kategori_pem_laborat.NAMA_KP_LABORAT, kategori_spesimen.NAMA_SPESIMEN
from pemeriksaan_laborat 
left join kategori_pem_laborat on kategori_pem_laborat.ID_KP_LABORAT = pemeriksaan_laborat.ID_KP_LABORAT
left join kategori_spesimen on kategori_spesimen.ID_KAT_SPES = pemeriksaan_laborat.ID_KAT_SPES
WHERE pemeriksaan_laborat.ID_UNIT = $idunit and pemeriksaan_laborat.ID_PEM_LABORAT NOT IN 
(
select pemeriksaan_laborat.ID_PEM_LABORAT
                from cek_laborat
                left join pemeriksaan_laborat on ( pemeriksaan_laborat.ID_PEM_LABORAT = cek_laborat.ID_PEM_LABORAT )
                left join kategori_pem_laborat on ( kategori_pem_laborat.ID_KP_LABORAT = pemeriksaan_laborat.ID_KP_LABORAT)
                left join kategori_spesimen on ( kategori_spesimen.ID_KAT_SPES = pemeriksaan_laborat.ID_KAT_SPES)
                left join riwayat_rm on ( riwayat_rm.ID_RIWAYAT_RM = cek_laborat.ID_RIWAYAT_RM)
                left join rekam_medik on ( rekam_medik.ID_REKAMMEDIK = riwayat_rm.ID_REKAMMEDIK)
                left join pasien on ( pasien.ID_PASIEN = rekam_medik.ID_PASIEN)
                where riwayat_rm.ID_RIWAYAT_RM = $idrrm
)";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else
            return null;
    }

}
