<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Mkia extends CI_model {

    function __construct() {
        parent::__construct();
    }
    
    function insert($table, $data){
        $this->db->insert($table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
    
    function insertAndGetLast($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    
    function getTable($nameTable, $array=null){
        $query= $this->db->get_where($nameTable, $array);
        return $query->result_array();
    }
    
    function getRiwayatRM($idPasien){
        $sql = "SELECT * FROM `riwayat_rm`
                INNER JOIN `rekam_medik`
                ON `rekam_medik`.`ID_REKAMMEDIK`= `riwayat_rm`.`ID_REKAMMEDIK`
                WHERE `ID_PASIEN`= ?
                ORDER BY ID_RIWAYAT_RM desc";
        $query= $this->db->query($sql, array($idPasien));
        return $query->result_array();
    }
    
    function getRiwayatRMById($idRiwayatRM){
        $sql = "SELECT * FROM (
                SELECT `ID_RIWAYAT_RM`, `riwayat_rm`.`ID_REKAMMEDIK`, `ID_LAYANAN_KES`, `ID_SUMBER`, `TANGGAL_RIWAYAT_RM`,
                `BERATBADAN_PASIEN`, `TINGGIBADAN_PASIEN`, `SISTOL_PASIEN`, `DIASTOL_PASIEN`, `ID_PASIEN`, `NOID_REKAMMEDIK` 
                FROM `riwayat_rm`
                INNER JOIN `rekam_medik`
                ON `rekam_medik`.`ID_REKAMMEDIK`= `riwayat_rm`.`ID_REKAMMEDIK`
                ) temp
                INNER JOIN `pasien`
                ON `pasien`.`ID_PASIEN`=temp.ID_PASIEN
                WHERE `ID_RIWAYAT_RM`= ?";
        $query= $this->db->query($sql, array($idRiwayatRM));
        return $query->result_array();
    }
    
    function getSomeObatPasien($idDetilTo) {
        $query= $this->db->get_where('obat_pasien', array('ID_DETIL_TO' => $idDetilTo));
        return $query->result_array();
    }
    
    function getRiwayatResep($idPasien, $startRow, $perPage){
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $sql = "SELECT rm.`ID_RIWAYAT_RM`, tr.`ID_TRANSAKSI`, tr.`TANGGAL_TRANSAKSI`, FLAG_KONFIRMASI, KETERANGAN_TRANSAKSI_OBAT
                FROM `riwayat_rm` rm
                LEFT JOIN `rekam_medik` ON `rekam_medik`.`ID_REKAMMEDIK`= rm.`ID_REKAMMEDIK`
                LEFT JOIN `transaksi_obat` tr ON tr.`ID_RIWAYAT_RM`=rm.`ID_RIWAYAT_RM`
                WHERE `ID_PASIEN`=? AND tr.`ID_JENISTRANSAKSI`=16 AND tr.TRANSAKSI_UNIT_DARI=".$idUnit."
                ORDER BY rm.ID_RIWAYAT_RM DESC 
                LIMIT ".$startRow.", ".$perPage;
        $query= $this->db->query($sql, array($idPasien));
        return $query->result_array();
    }
    
    function getRiwayatResepCount($idPasien){
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $sql = "SELECT rm.`ID_RIWAYAT_RM`, tr.`ID_TRANSAKSI`, tr.`TANGGAL_TRANSAKSI`, FLAG_KONFIRMASI, KETERANGAN_TRANSAKSI_OBAT
                FROM `riwayat_rm` rm
                LEFT JOIN `rekam_medik` ON `rekam_medik`.`ID_REKAMMEDIK`= rm.`ID_REKAMMEDIK`
                LEFT JOIN `transaksi_obat` tr ON tr.`ID_RIWAYAT_RM`=rm.`ID_RIWAYAT_RM`
                WHERE `ID_PASIEN`=? AND tr.`ID_JENISTRANSAKSI`=16 AND tr.TRANSAKSI_UNIT_DARI=".$idUnit."
                ORDER BY rm.ID_RIWAYAT_RM DESC";
        $query= $this->db->query($sql, array($idPasien));
        return $query->num_rows();
    }
    
    function getTebusanObat($idPasien){
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $sql = "SELECT rm.`ID_RIWAYAT_RM`, tr.`ID_TRANSAKSI`, tr.`TANGGAL_TRANSAKSI`,FLAG_KONFIRMASI, `ID_RUJUKAN_KONFIRMASI`
                FROM `riwayat_rm` rm
                LEFT JOIN `rekam_medik` ON `rekam_medik`.`ID_REKAMMEDIK`= rm.`ID_REKAMMEDIK`
                LEFT JOIN `transaksi_obat` tr ON tr.`ID_RIWAYAT_RM`=rm.`ID_RIWAYAT_RM`
                WHERE `ID_PASIEN`=? AND tr.`ID_JENISTRANSAKSI`=17 AND tr.TRANSAKSI_UNIT_DARI=".$idUnit."
                ORDER BY rm.ID_RIWAYAT_RM DESC";
        $query= $this->db->query($sql, array($idPasien));
        return $query->result_array();
    }
    
    function penambahanStok($ID_TRANSAKSI, $ID_OBAT, $JUMLAH_OBAT, $EXPIRED_DATE, $BATCH, $ID_UNIT, $ID_SUMBER_ANGGARAN){
        $sql = "call insert_detil_transaksi_obat_plus('$ID_TRANSAKSI','$ID_OBAT','$JUMLAH_OBAT','$EXPIRED_DATE','$ID_UNIT','$BATCH','$ID_SUMBER_ANGGARAN')";
        $result = $this->db->query($sql)->result();
        $this->db->close();
        return $result;
    }
    
    function penguranganStok($ID_TRANSAKSI, $ID_OBAT, $JUMLAH_OBAT, $EXPIRED_DATE, $BATCH, $ID_UNIT, $ID_SUMBER_ANGGARAN){
        $sql = "call insert_detil_transaksi_obat_minus('$ID_TRANSAKSI','$ID_OBAT','$JUMLAH_OBAT','$EXPIRED_DATE','$ID_UNIT','$BATCH','$ID_SUMBER_ANGGARAN')";
        $result = $this->db->query($sql)->result();
        $this->db->close();
        return $result;
    }
    
    function permintaanStok($ID_TRANSAKSI, $ID_OBAT, $JUMLAH_OBAT, $EXPIRED_DATE, $BATCH, $ID_UNIT, $ID_SUMBER_ANGGARAN){
        $sql = "call insert_detil_transaksi_obat_request('$ID_TRANSAKSI','$ID_OBAT','$JUMLAH_OBAT','$EXPIRED_DATE','$ID_UNIT','$BATCH','$ID_SUMBER_ANGGARAN')";
        $result = $this->db->query($sql)->result();
        $this->db->close();
        return $result;
    }
    
    public function getHistoryRRMkia($id) {
        $sql = 'select rm.id_rekammedik, rm.noid_rekammedik, rrm.id_riwayat_rm, p.id_pasien
                , p.nama_pasien,p.alamat_pasien, rrm.beratbadan_pasien, rrm.tinggibadan_pasien
                , rrm.sistol_pasien, rrm.diastol_pasien, rrm.tanggal_riwayat_rm, au.id_unit 
                , noid_pasien, gender_pasien, telepon_pasien, gol_darah_pasien, agama_pasien
                from antrian_unit au 
                left join riwayat_rm rrm on au.id_riwayat_rm = rrm.id_riwayat_rm 
                left join rekam_medik rm on rm.id_rekammedik = rrm.id_rekammedik
                RIGHT join data_kia kia on kia.id_riwayat_rm= rrm.id_riwayat_rm
                left join pasien p on p.id_pasien = rm.id_pasien where au.flag_antrian_unit = 1 and au.id_unit=' . $id;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return null;
    }
    
    
    public function getHistoryRRMkb($id) {
        $sql = 'select rm.id_rekammedik, rm.noid_rekammedik, rrm.id_riwayat_rm, p.id_pasien
                , p.nama_pasien,p.alamat_pasien, rrm.beratbadan_pasien, rrm.tinggibadan_pasien
                , rrm.sistol_pasien, rrm.diastol_pasien, rrm.tanggal_riwayat_rm, au.id_unit 
                , noid_pasien, gender_pasien, telepon_pasien, gol_darah_pasien, agama_pasien
                from antrian_unit au 
                left join riwayat_rm rrm on au.id_riwayat_rm = rrm.id_riwayat_rm 
                left join rekam_medik rm on rm.id_rekammedik = rrm.id_rekammedik
                RIGHT join data_kb kb on kb.id_riwayat_rm= rrm.id_riwayat_rm
                left join pasien p on p.id_pasien = rm.id_pasien where au.flag_antrian_unit = 1 and au.id_unit=' . $id;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return null;
    }
    
    public function getHistoryRRMbalita($id) {
        $sql = 'select rm.id_rekammedik, rm.noid_rekammedik, rrm.id_riwayat_rm, p.id_pasien
                , p.nama_pasien,p.alamat_pasien, rrm.beratbadan_pasien, rrm.tinggibadan_pasien
                , rrm.sistol_pasien, rrm.diastol_pasien, rrm.tanggal_riwayat_rm, au.id_unit 
                , noid_pasien, gender_pasien, telepon_pasien, gol_darah_pasien, agama_pasien
                from antrian_unit au 
                left join riwayat_rm rrm on au.id_riwayat_rm = rrm.id_riwayat_rm 
                left join rekam_medik rm on rm.id_rekammedik = rrm.id_rekammedik
                RIGHT join data_anak_balita balita on balita.id_riwayat_rm= rrm.id_riwayat_rm
                left join pasien p on p.id_pasien = rm.id_pasien where au.flag_antrian_unit = 1 and au.id_unit=' . $id;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return null;
    }
    
    public function getHistoryRRMvkkia($id) {
        $sql = 'select rm.id_rekammedik, rm.noid_rekammedik, rrm.id_riwayat_rm, p.id_pasien
                , p.nama_pasien,p.alamat_pasien, rrm.beratbadan_pasien, rrm.tinggibadan_pasien
                , rrm.sistol_pasien, rrm.diastol_pasien, rrm.tanggal_riwayat_rm, au.id_unit 
                , noid_pasien, gender_pasien, telepon_pasien, gol_darah_pasien, agama_pasien
                from antrian_unit au 
                left join riwayat_rm rrm on au.id_riwayat_rm = rrm.id_riwayat_rm 
                left join rekam_medik rm on rm.id_rekammedik = rrm.id_rekammedik
                RIGHT join data_vkkia vkkia on vkkia.id_riwayat_rm= rrm.id_riwayat_rm
                left join pasien p on p.id_pasien = rm.id_pasien where au.flag_antrian_unit = 1 and au.id_unit=' . $id;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return null;
    }
    
    public function getDataKB($idRiwayatRM){
        $sql = 'SELECT data_kb.ID_RIWAYAT_RM, `KODE_KLINIK_KB`, `SERI_KARTU_KB`, `rm`.`STAT_RAWAT_JALAN`, `rm`.`TEMPAT_RUJUKAN`,
                `JML_ANAK_HIDUP_P`, `KB_JML_ANAK_HIDUP_L`, `KB_UMUR_ANAK_TERKECIL`, `KB_STAT_PESERTA_KB`, `KB_FLAG_SEDANG_KB`,
                `KB_HAID_TERAKHIR`, `KB_DIDUGA_HAMIL`, KB_FLAG_MENYUSUI, KB_JML_GPA_GRAVIDA, KB_JML_GPA_PARTUS, KB_JML_GPA_ABORTUS,
                KB_PENYAKIT_SEBELUMNYA_SKUNING, KB_PENYAKIT_SEBELUMNYA_PERVAGINAM, KB_PENYAKIT_SEBELUMNYA_KEPUTIHAN, KB_PENYAKIT_SEBELUMNYA_TUMOR, 
                KB_KEADAAN_UMUM, KB_TANDA2_RADANG, KB_TUMOR_GINEKOLOGI,
                KB_TANDA_DIABET, KB_KELAINAN_PEMBEKUAN_DARAH, KB_RADANG_ORCHITIS_EPIDIDYMITIS, KB_TUMOR_GINEKOLOGI_TAMBAHAN, KB_POSISI_RAHIM,
                /*KB_ID_ALAT_KONTRASEPSI_YG_BOLEH, KB_ID_ALAT_KONTRASEPSI_SEBELUMNYA, data_kb.ID_ALAT_KB,*/
                kb2.`NAMA_ALAT_KB` AS kb_sebelum, kb3.`NAMA_ALAT_KB` kb_boleh, kb.`NAMA_ALAT_KB` AS kb_dipilih,
                KB_TANGGAL_DIPESAN_KEMBALI, KB_TANGGAL_DICABUT, KB_AKIBAT_KOMPLIKASI_BERAT, KB_AKIBAT_KEGAGALAN
                FROM `data_kb`
                INNER JOIN `riwayat_rm` rm ON rm.`ID_RIWAYAT_RM`=`data_kb`.`ID_RIWAYAT_RM`
                INNER JOIN `alat_kb` kb ON `kb`.`ID_ALAT_KB`=data_kb.`ID_ALAT_KB`
                INNER JOIN `alat_kb` kb2 ON `kb2`.`ID_ALAT_KB`=data_kb.`KB_ID_ALAT_KONTRASEPSI_SEBELUMNYA`
                RIGHT JOIN `alat_kb` kb3 ON `kb3`.`ID_ALAT_KB`=data_kb.`KB_ID_ALAT_KONTRASEPSI_YG_BOLEH`
                WHERE rm.`ID_RIWAYAT_RM`=?';
        $query = $this->db->query($sql, array($idRiwayatRM));
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return null;
    }
    
}