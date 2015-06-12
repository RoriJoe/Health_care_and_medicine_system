<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Memergency extends CI_model {

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
    
    function getTebusanObat($idPasien, $idUnit){
        $sql = "SELECT rm.`ID_RIWAYAT_RM`, tr.`ID_TRANSAKSI`, tr.`TANGGAL_TRANSAKSI`,FLAG_KONFIRMASI, `ID_RUJUKAN_KONFIRMASI`
                FROM `riwayat_rm` rm
                LEFT JOIN `rekam_medik` ON `rekam_medik`.`ID_REKAMMEDIK`= rm.`ID_REKAMMEDIK`
                LEFT JOIN `transaksi_obat` tr ON tr.`ID_RIWAYAT_RM`=rm.`ID_RIWAYAT_RM`
                WHERE `ID_PASIEN`=? AND tr.`ID_JENISTRANSAKSI`=17 AND tr.TRANSAKSI_UNIT_DARI=?
                ORDER BY rm.ID_RIWAYAT_RM DESC";
        $query= $this->db->query($sql, array($idPasien, $idUnit));
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

}