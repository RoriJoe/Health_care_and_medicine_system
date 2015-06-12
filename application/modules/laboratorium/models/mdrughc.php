<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Mdrughc extends CI_model {

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
    
    function update($table, $data, $columnId, $idValue){
        $this->db->where($columnId, $idValue);
        $this->db->update($table, $data); 
        return ($this->db->affected_rows() != 1) ? false : true;
    }
            
    function getTable($nameTable, $array=null){
        $query= $this->db->get_where($nameTable, $array);
//        echo $this->db->last_query();
        return $query->result_array();
    }
    
    function getObatLimit($start, $totalRow) {
        $query= $this->db->get('obat', $totalRow, $start);
        return $query->result_array();
    }
    
    function getObat() {
        $query= $this->db->get('obat');
        return $query->result_array();
    }
    
    function getSomeObat($idObat) {
        $query= $this->db->get_where('obat', array('ID_OBAT' => $idObat));
        return $query->result_array();
    }
    
    function getSomeObatComplexParam($teks=null) {
        if(!empty($teks)){
            $this->db->where('KODE_OBAT like', '%'.$teks.'%');
            $this->db->or_where('NAMA_OBAT like', '%'.$teks.'%');
            $this->db->or_where('SATUAN like', '%'.$teks.'%');
        }
//        $this->db->order_by("ID_OBAT", "asc"); 
//        $this->db->limit(300);
        $query= $this->db->get('obat');
        return $query->result();
    }

    function getGFKData($idGedung, $namaUnit) {
        $this->db->where('ID_GEDUNG', $idGedung);
        $this->db->like('NAMA_UNIT', $namaUnit); 
        $query= $this->db->get('unit');
        return $query->result_array();
    }
    
    function getHakAkses($id_akun){
        $sql = "SELECT `ID_AKUN`, `ID_UNIT`, `NAMA_UNIT`, temp2.`ID_GEDUNG`, `NOID_GEDUNG`, `NAMA_GEDUNG`
                FROM (
                SELECT `ID_AKUN`, temp.`ID_UNIT`, `NAMA_UNIT`, `ID_GEDUNG`
                FROM ( 
                SELECT `akun`.`ID_AKUN`, `penugasan`.`ID_UNIT` FROM  `akun`
                INNER JOIN `penugasan`
                ON `akun`.`ID_AKUN`=`penugasan`.`ID_AKUN`
                WHERE `akun`.`NOID`= ?
                ) temp
                INNER JOIN `unit`
                ON temp.ID_UNIT=`unit`.`ID_UNIT`
                ) temp2
                INNER JOIN `gedung`
                ON temp2.ID_GEDUNG=`gedung`.`ID_GEDUNG`";
        $query= $this->db->query($sql, array($id_akun));
        return $query->result_array();
    }
    
    function getUnit($array){
        $query= $this->db->get_where('unit', $array);
        return $query->result_array();
    }
    
    function getUnitFilter($idGedung){  //get ID all unit except pustu and loket obat
        $sql = "SELECT `akun`.`ID_AKUN`, `penugasan`.`ID_UNIT`, unit.`NAMA_UNIT`, unit.`ID_GEDUNG`, 
                `NOID_GEDUNG`, `NAMA_GEDUNG`, `penugasan`.`ID_HAKAKSES`, `NAMA_HAKAKSES`
                FROM  `akun`
                INNER JOIN `penugasan` ON `akun`.`ID_AKUN`=`penugasan`.`ID_AKUN`
                INNER JOIN `unit` ON `penugasan`.ID_UNIT=`unit`.`ID_UNIT`
                INNER JOIN `gedung` ON `unit`.ID_GEDUNG=`gedung`.`ID_GEDUNG`
                INNER JOIN `hak_akses` ON `penugasan`.`ID_HAKAKSES`=`hak_akses`.`ID_HAKAKSES`
                WHERE `unit`.`ID_GEDUNG`=? AND `unit`.`FLAG_DISTRIBUSI_OBAT`=4";
        $query= $this->db->query($sql, array($idGedung));
        return $query->result_array();
    }
    
    function getDataLengkapPenugasan($idHakAkses, $idGedung){  //get ID all unit except pustu and loket obat
        $sql = "SELECT `akun`.`ID_AKUN`, `penugasan`.`ID_UNIT`, unit.`NAMA_UNIT`, unit.`ID_GEDUNG`, 
                `NOID_GEDUNG`, `NAMA_GEDUNG`, `penugasan`.`ID_HAKAKSES`, `NAMA_HAKAKSES`
                FROM  `akun`
                INNER JOIN `penugasan` ON `akun`.`ID_AKUN`=`penugasan`.`ID_AKUN`
                INNER JOIN `unit` ON `penugasan`.ID_UNIT=`unit`.`ID_UNIT`
                INNER JOIN `gedung` ON `unit`.ID_GEDUNG=`gedung`.`ID_GEDUNG`
                INNER JOIN `hak_akses` ON `penugasan`.`ID_HAKAKSES`=`hak_akses`.`ID_HAKAKSES`
                WHERE `penugasan`.`ID_HAKAKSES`=? AND `unit`.`ID_GEDUNG`=?";
        $query= $this->db->query($sql, array($idHakAkses, $idGedung));
        return $query->result_array();
    }

    function getPenugasan($id_akun, $id_unit) { //get penugasan
        $query= $this->db->get_where('penugasan', array('ID_AKUN' => $id_akun, 'ID_UNIT' => $id_unit));
        return $query->result_array();
    }
    
    function getSomeTransaksi($idTransaksi) {   //get transaksi by id
        $query= $this->db->get_where('transaksi_obat', array('ID_TRANSAKSI' => $idTransaksi));
        return $query->result_array();
    }
    
    function getSomeTransaksiParam($array) {    //get transaksi with other param
        $this->db->order_by("ID_TRANSAKSI", "desc"); 
        $query= $this->db->get_where('transaksi_obat', $array);
        return $query->result_array();
    }
    
    function getSomeDetailTrans($idTransaksi) { //get detail transaksi by id transaksi
        $query= $this->db->get_where('detil_transaksi_obat', array('ID_TRANSAKSI' => $idTransaksi));
        return $query->result_array();
    }
    
    function getDetailTransObat($idTransaksi){
        $sql = "SELECT `ID_DETIL_TO`, NOMOR_BATCH, EXPIRED_DATE, `id_transaksi`, obat.`ID_OBAT`, `KODE_OBAT`, `NAMA_OBAT`, `SATUAN`, `JUMLAH_OBAT` FROM `detil_transaksi_obat`
                INNER JOIN `obat`
                ON `obat`.`ID_OBAT`=`detil_transaksi_obat`.`ID_OBAT`
                WHERE `id_transaksi`=?
                ORDER BY `EXPIRED_DATE` desc";
        $query= $this->db->query($sql, array($idTransaksi));
        return $query->result_array();
    }
    
    function getSomeJenisTrans($idJenisTrans) { //get jenis transaksi 
        $query= $this->db->get_where('jenis_transaksi_obat', array('ID_JENISTRANSAKSI' => $idJenisTrans));
        return $query->result_array();
    }
    
    function getSomeGedung($idGedung){  //get gedung
        $query= $this->db->get_where('gedung', array('ID_GEDUNG' => $idGedung));
        return $query->result_array();
    }
    
    function getTransaksiAndRiwayatRM($flag, $jenisTransaksi, $start, $end){
        $sql = 'SELECT `pasien`.`ID_PASIEN`, `NAMA_PASIEN`, `NOID_REKAMMEDIK`, `ID_TRANSAKSI`,`TANGGAL_TRANSAKSI`,`riwayat_rm`.`ID_RIWAYAT_RM`, 
                `riwayat_rm`.`ID_REKAMMEDIK`, `ID_LAYANAN_KES`, `ID_SUMBER`, `TANGGAL_RIWAYAT_RM`, 
                `ID_JENISTRANSAKSI`, `FLAG_TRANSAKSI`
                FROM `transaksi_obat`
                INNER JOIN `riwayat_rm` ON `riwayat_rm`.`ID_RIWAYAT_RM`= `transaksi_obat`.`ID_RIWAYAT_RM`
                INNER JOIN `rekam_medik` ON `rekam_medik`.`ID_REKAMMEDIK`= `riwayat_rm`.`ID_REKAMMEDIK`
                INNER JOIN `pasien` ON `pasien`.`ID_PASIEN`=`rekam_medik`.`ID_PASIEN`
                WHERE `FLAG_KONFIRMASI`=? AND `ID_JENISTRANSAKSI`=?
                AND TANGGAL_TRANSAKSI BETWEEN "'.$start.'" AND "'.$end.'"
                ORDER BY `ID_TRANSAKSI` DESC';
        $query= $this->db->query($sql, array($flag, $jenisTransaksi));
        return $query->result_array();
    }
    
    function getDetailResepObatPasien($idUnit, $ID_TRANSAKSI, $FLAG_TRANSAKSI){
        $sql = "SELECT `ID_PASIEN`, `NAMA_PASIEN`, `NOID_REKAMMEDIK`, `ID_TRANSAKSI`, `TANGGAL_TRANSAKSI`, `ID_RIWAYAT_RM`
                , `ID_REKAMMEDIK`, `ID_JENISTRANSAKSI`, `FLAG_TRANSAKSI`, FLAG_KONFIRMASI
                , temp1.`NAMA_OBAT`, temp1.`SATUAN`
                ,`temp1`.`ID_OBAT`, `temp1`.`JUMLAH_OBAT`, temp1.`NOMOR_BATCH`, temp1.`ID_SUMBER_ANGGARAN_OBAT`, temp1.`EXPIRED_DATE`, STOK, temp1.ID_DETIL_TO
                ,`JUMLAH_SEHARI`, `LAMA_HARI`, `DESKRIPSI_OP`
                FROM (
                SELECT `pasien`.`ID_PASIEN`, `NAMA_PASIEN`, `NOID_REKAMMEDIK`, `transaksi_obat`.`ID_TRANSAKSI`,`TANGGAL_TRANSAKSI`,`riwayat_rm`.`ID_RIWAYAT_RM`
                , `riwayat_rm`.`ID_REKAMMEDIK`, `ID_JENISTRANSAKSI`, `FLAG_TRANSAKSI`, FLAG_KONFIRMASI
                , obat.`NAMA_OBAT`, obat.`SATUAN`
                ,`detil_transaksi_obat`.`ID_OBAT`, `detil_transaksi_obat`.`JUMLAH_OBAT`, `NOMOR_BATCH`, `ID_SUMBER_ANGGARAN_OBAT`, `EXPIRED_DATE`, detil_transaksi_obat.`ID_DETIL_TO`
                ,`JUMLAH_SEHARI`, `LAMA_HARI`, `DESKRIPSI_OP`
                FROM `transaksi_obat`
                INNER JOIN `riwayat_rm` ON `riwayat_rm`.`ID_RIWAYAT_RM`= `transaksi_obat`.`ID_RIWAYAT_RM`
                INNER JOIN `rekam_medik` ON `rekam_medik`.`ID_REKAMMEDIK`= `riwayat_rm`.`ID_REKAMMEDIK`
                INNER JOIN `pasien` ON `pasien`.`ID_PASIEN`=`rekam_medik`.`ID_PASIEN`
                INNER JOIN `detil_transaksi_obat` ON `detil_transaksi_obat`.`ID_TRANSAKSI`= `transaksi_obat`.`ID_TRANSAKSI`
                INNER JOIN `obat` ON `obat`.`ID_OBAT`= `detil_transaksi_obat`.`ID_OBAT`
                INNER JOIN `obat_pasien` ON `obat_pasien`.`ID_DETIL_TO`= detil_transaksi_obat.`ID_DETIL_TO`
                )temp1
                INNER JOIN (
                SELECT * FROM 
                (
                SELECT view_stok.`ID_DETIL_TO`, view_stok.`ID_OBAT`, `view_stok`.`NOMOR_BATCH`, view_stok.`NAMA_OBAT`, 
                view_stok.`STOK_OBAT_SEKARANG` AS STOK, obat.`SATUAN`, `view_stok`.`EXPIRED_DATE`
                FROM `view_stok_obat_unit_terkini` view_stok
                INNER JOIN obat ON obat.`ID_OBAT`=view_stok.`ID_OBAT`
                WHERE view_stok.`ID_UNIT`= ?
                ORDER BY view_stok.`ID_OBAT` DESC 
                )temp
                GROUP BY `ID_OBAT`,NOMOR_BATCH
                ORDER BY EXPIRED_DATE DESC
                ) temp2 ON temp2.NOMOR_BATCH=temp1.`NOMOR_BATCH` AND temp2.ID_OBAT=temp1.`ID_OBAT`
                WHERE temp1.`ID_TRANSAKSI`=? AND temp1.`FLAG_KONFIRMASI`= ?";
        $query= $this->db->query($sql, array($idUnit, $ID_TRANSAKSI, $FLAG_TRANSAKSI));
//        echo $this->db->last_query();
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
    
    function getAllStok($idUnit, $teks=null){
        $sql = "SELECT * FROM
                (
                SELECT view_stok.`ID_DETIL_TO`, view_stok.`ID_OBAT`, `view_stok`.`NOMOR_BATCH`, view_stok.`NAMA_OBAT`, view_stok.`STOK_OBAT_SEKARANG` as STOK, obat.`SATUAN`, `view_stok`.`EXPIRED_DATE` 
                FROM `view_stok_obat_unit_terkini` view_stok
                INNER JOIN obat ON obat.`ID_OBAT`=view_stok.`ID_OBAT`
                WHERE view_stok.`ID_UNIT`= ?
                ORDER BY view_stok.`ID_OBAT` DESC 
                )temp";
        if(!empty($teks)) $sql .= " WHERE `NOMOR_BATCH` LIKE '%".$teks."%' OR `NAMA_OBAT` LIKE '%".$teks."%' OR STOK LIKE '%".$teks."%'";
        $sql .= " GROUP BY `ID_OBAT`,NOMOR_BATCH
                ORDER BY EXPIRED_DATE asc";
        $query= $this->db->query($sql, array($idUnit));
        return $query->result();
    }
    
    function getSomeStokByBatchObat($idUnit, $NOMOR_BATCH, $ID_OBAT) { //get detail transaksi by NOMOR_BATCH and ID_OBAT
        $sql = "SELECT * FROM 
                (
                SELECT view_stok.ID_SUMBER_ANGGARAN_OBAT, view_stok.`ID_DETIL_TO`, view_stok.`ID_OBAT`, `view_stok`.`NOMOR_BATCH`, view_stok.`NAMA_OBAT`, view_stok.`STOK_OBAT_SEKARANG` as STOK, obat.`SATUAN`, `view_stok`.`EXPIRED_DATE` 
                FROM `view_stok_obat_unit_terkini` view_stok
                INNER JOIN obat ON obat.`ID_OBAT`=view_stok.`ID_OBAT`
                WHERE view_stok.`ID_UNIT`= ?
                ORDER BY view_stok.`ID_OBAT` DESC 
                )temp
                WHERE `NOMOR_BATCH`= ? AND `ID_OBAT`= ?
                GROUP BY `ID_OBAT`,NOMOR_BATCH
                ORDER BY EXPIRED_DATE desc";
        $query= $this->db->query($sql, array($idUnit, $NOMOR_BATCH, $ID_OBAT));
        return $query->result_array();
    }
    
    function getSomeStokByIdObat($idUnit, $ID_OBAT) { //get detail transaksi by ID_OBAT
        $sql = "SELECT * FROM 
                (
                SELECT view_stok.ID_SUMBER_ANGGARAN_OBAT, view_stok.`ID_DETIL_TO`, view_stok.`ID_OBAT`, `view_stok`.`NOMOR_BATCH`, view_stok.`NAMA_OBAT`, view_stok.`STOK_OBAT_SEKARANG` as STOK, obat.`SATUAN`, `view_stok`.`EXPIRED_DATE` 
                FROM `view_stok_obat_unit_terkini` view_stok
                INNER JOIN obat ON obat.`ID_OBAT`=view_stok.`ID_OBAT`
                WHERE view_stok.`ID_UNIT`= ?
                ORDER BY view_stok.`ID_OBAT` DESC 
                )temp
                WHERE `ID_OBAT`= ?
                GROUP BY `ID_OBAT`,NOMOR_BATCH
                ORDER BY EXPIRED_DATE desc";
        $query= $this->db->query($sql, array($idUnit, $ID_OBAT));
        return $query->result_array();
    }
    
    function getDetailTransCompareStok($idUnit, $idTransaksi){
        $sql = "SELECT xxx.`NOMOR_BATCH`, xxx.`ID_OBAT`, xxx.`JUMLAH_OBAT`, NAMA_OBAT, STOK, SATUAN, EXPIRED_DATE
                FROM (
                SELECT * FROM 
                (
                SELECT view_stok.`ID_DETIL_TO`, view_stok.`ID_OBAT`, `view_stok`.`NOMOR_BATCH`, view_stok.`NAMA_OBAT`, view_stok.`STOK_OBAT_SEKARANG` AS STOK, obat.`SATUAN`, `view_stok`.`EXPIRED_DATE` 
                FROM `view_stok_obat_unit_terkini` view_stok
                INNER JOIN obat ON obat.`ID_OBAT`=view_stok.`ID_OBAT`
                WHERE view_stok.`ID_UNIT`= ?
                ORDER BY view_stok.`ID_OBAT` DESC 
                )temp
                GROUP BY `ID_OBAT`,NOMOR_BATCH
                ORDER BY EXPIRED_DATE DESC
                )temp2
                INNER JOIN (
                SELECT `NOMOR_BATCH`, `ID_OBAT`, `JUMLAH_OBAT` FROM `detil_transaksi_obat` detil
                WHERE`ID_TRANSAKSI`= ?
                ORDER BY EXPIRED_DATE DESC
                )xxx
                ON xxx.NOMOR_BATCH=temp2.NOMOR_BATCH";
        $query= $this->db->query($sql, array($idUnit, $idTransaksi));
        return $query->result_array();
    }
    
    function getPasienRiwayatRekam($ID_RIWAYAT_RM){
        $sql = "SELECT * FROM `riwayat_rm`
                INNER JOIN `rekam_medik` ON `rekam_medik`.`ID_REKAMMEDIK`=`riwayat_rm`.`ID_REKAMMEDIK`
                WHERE `riwayat_rm`.`ID_RIWAYAT_RM`= ?";
        $query= $this->db->query($sql, array($ID_RIWAYAT_RM));
        return $query->result_array();
    }
    
    function getRiwayatObatMasuk($id_hakakses, $idUnit, $startRow, $perPage){
        $sql = "SELECT tr.`ID_TRANSAKSI`, tr.`ID_JENISTRANSAKSI`, tr.`ID_PENUGASAN`, tr.`ID_RIWAYAT_RM`, tr.`TANGGAL_TRANSAKSI`, 
                dari.nama_unit as dari, ke.nama_unit as ke, tr.`NAMA_TRANSAKSI_SUMBER_LAIN`
                FROM `transaksi_obat` tr
                LEFT JOIN `unit` dari ON dari.id_unit=tr.`TRANSAKSI_UNIT_DARI`
                LEFT JOIN `unit` ke ON ke.id_unit=tr.`TRANSAKSI_UNIT_KE`";
    if($id_hakakses==2) //gop
        $sql = $sql." WHERE tr.`ID_JENISTRANSAKSI`=18 OR tr.`ID_JENISTRANSAKSI`=15";
    else if($id_hakakses==3) //lo
        $sql = $sql." WHERE tr.`ID_JENISTRANSAKSI`=19";
    else if($id_hakakses==21) //pustu
        $sql = $sql." WHERE tr.`ID_JENISTRANSAKSI`=21";
    else if($id_hakakses==6 || $id_hakakses==9 || $id_hakakses==10 || $id_hakakses==11 || $id_hakakses==12 || $id_hakakses==13) //unit
        $sql = $sql." WHERE tr.`ID_JENISTRANSAKSI`=20";
        $sql = $sql." and tr.`TRANSAKSI_UNIT_KE`=?";
        $sql = $sql." ORDER BY tr.`ID_TRANSAKSI` desc
                LIMIT ".$startRow.", ".$perPage;
        $query= $this->db->query($sql, array($idUnit));
        return $query->result_array();
    }

    function getRiwayatObatMasukCount($id_hakakses, $idUnit){
        $sql = "SELECT tr.`ID_TRANSAKSI`, tr.`ID_JENISTRANSAKSI`, tr.`ID_PENUGASAN`, tr.`ID_RIWAYAT_RM`, tr.`TANGGAL_TRANSAKSI`, 
                dari.nama_unit as dari, ke.nama_unit as ke, tr.`NAMA_TRANSAKSI_SUMBER_LAIN`
                FROM `transaksi_obat` tr
                LEFT JOIN `unit` dari ON dari.id_unit=tr.`TRANSAKSI_UNIT_DARI`
                LEFT JOIN `unit` ke ON ke.id_unit=tr.`TRANSAKSI_UNIT_KE`";
    if($id_hakakses==2) //gop
        $sql = $sql." WHERE tr.`ID_JENISTRANSAKSI`=18 OR tr.`ID_JENISTRANSAKSI`=15";
    else if($id_hakakses==3) //lo
        $sql = $sql." WHERE tr.`ID_JENISTRANSAKSI`=19";
    else if($id_hakakses==21) //pustu
        $sql = $sql." WHERE tr.`ID_JENISTRANSAKSI`=21";
    else if($id_hakakses==6 || $id_hakakses==9 || $id_hakakses==10 || $id_hakakses==11 || $id_hakakses==12 || $id_hakakses==13) //unit
        $sql = $sql." WHERE tr.`ID_JENISTRANSAKSI`=20";
        $sql = $sql." and tr.`TRANSAKSI_UNIT_KE`=?";
        $query= $this->db->query($sql, array($idUnit));
        return $query->num_rows();
    }
    
    function getRiwayatObatMinta($id_hakakses, $idUnit, $startRow, $perPage){
        $sql = "SELECT tr.`ID_TRANSAKSI`, tr.`ID_JENISTRANSAKSI`, tr.`ID_PENUGASAN`, tr.`ID_RIWAYAT_RM`, tr.`TANGGAL_TRANSAKSI`, 
                dari.nama_unit as dari, ke.nama_unit as ke, tr.`NAMA_TRANSAKSI_SUMBER_LAIN`
                FROM `transaksi_obat` tr
                LEFT JOIN `unit` dari ON dari.id_unit=tr.`TRANSAKSI_UNIT_DARI`
                LEFT JOIN `unit` ke ON ke.id_unit=tr.`TRANSAKSI_UNIT_KE`";
    if($id_hakakses==2) //gop
        $sql = $sql." WHERE tr.`ID_JENISTRANSAKSI`=14";
    else if($id_hakakses==3) //lo
        $sql = $sql." WHERE tr.`ID_JENISTRANSAKSI`=13";
    else if($id_hakakses==21) //pustu
        $sql = $sql." WHERE tr.`ID_JENISTRANSAKSI`=12";
    else if($id_hakakses==6 || $id_hakakses==9 || $id_hakakses==10 || $id_hakakses==11 || $id_hakakses==12 || $id_hakakses==13) //unit
        $sql = $sql." WHERE tr.`ID_JENISTRANSAKSI`=11";
        $sql = $sql." and tr.`TRANSAKSI_UNIT_DARI`=?";
        $sql = $sql." ORDER BY tr.`ID_TRANSAKSI` desc
                LIMIT ".$startRow.", ".$perPage;
        $query= $this->db->query($sql, array($idUnit));
        return $query->result_array();
    }
    
    function getRiwayatObatMintaCount($id_hakakses, $idUnit){
        $sql = "SELECT tr.`ID_TRANSAKSI`, tr.`ID_JENISTRANSAKSI`, tr.`ID_PENUGASAN`, tr.`ID_RIWAYAT_RM`, tr.`TANGGAL_TRANSAKSI`, 
                dari.nama_unit as dari, ke.nama_unit as ke, tr.`NAMA_TRANSAKSI_SUMBER_LAIN`
                FROM `transaksi_obat` tr
                LEFT JOIN `unit` dari ON dari.id_unit=tr.`TRANSAKSI_UNIT_DARI`
                LEFT JOIN `unit` ke ON ke.id_unit=tr.`TRANSAKSI_UNIT_KE`";
    if($id_hakakses==2) //gop
        $sql = $sql." WHERE tr.`ID_JENISTRANSAKSI`=14";
    else if($id_hakakses==3) //lo
        $sql = $sql." WHERE tr.`ID_JENISTRANSAKSI`=13";
    else if($id_hakakses==21) //pustu
        $sql = $sql." WHERE tr.`ID_JENISTRANSAKSI`=12";
    else if($id_hakakses==6 || $id_hakakses==9 || $id_hakakses==10 || $id_hakakses==11 || $id_hakakses==12 || $id_hakakses==13) //unit
        $sql = $sql." WHERE tr.`ID_JENISTRANSAKSI`=11";
        $sql = $sql." and tr.`TRANSAKSI_UNIT_DARI`=?";
        $query= $this->db->query($sql, array($idUnit));
        return $query->num_rows();
    }
    
    function getRiwayatPemakaianObat($idUnit, $startRow, $perPage){
        $sql = "SELECT tr.`ID_TRANSAKSI`, tr.`ID_JENISTRANSAKSI`, tr.`ID_PENUGASAN`, tr.`ID_RIWAYAT_RM`, tr.`TANGGAL_TRANSAKSI`, 
                dari.nama_unit as dari, ke.nama_unit as ke, tr.`NAMA_TRANSAKSI_SUMBER_LAIN`
                FROM `transaksi_obat` tr
                LEFT JOIN `unit` dari ON dari.id_unit=tr.`TRANSAKSI_UNIT_DARI`
                LEFT JOIN `unit` ke ON ke.id_unit=tr.`TRANSAKSI_UNIT_KE`
                WHERE tr.`ID_JENISTRANSAKSI`=10
                and tr.`TRANSAKSI_UNIT_DARI`=?
                ORDER BY tr.`ID_TRANSAKSI` desc
                LIMIT ".$startRow.", ".$perPage;
        $query= $this->db->query($sql, array($idUnit));
        return $query->result_array();
    }
    
    function getRiwayatPemakaianObatCount($idUnit){
        $sql = "SELECT tr.`ID_TRANSAKSI`, tr.`ID_JENISTRANSAKSI`, tr.`ID_PENUGASAN`, tr.`ID_RIWAYAT_RM`, tr.`TANGGAL_TRANSAKSI`, 
                dari.nama_unit as dari, ke.nama_unit as ke, tr.`NAMA_TRANSAKSI_SUMBER_LAIN`
                FROM `transaksi_obat` tr
                LEFT JOIN `unit` dari ON dari.id_unit=tr.`TRANSAKSI_UNIT_DARI`
                LEFT JOIN `unit` ke ON ke.id_unit=tr.`TRANSAKSI_UNIT_KE`
                WHERE tr.`ID_JENISTRANSAKSI`=10
                and tr.`TRANSAKSI_UNIT_DARI`=?";
        $query= $this->db->query($sql, array($idUnit));
        return $query->num_rows();
    }
    
    function getRiwayatReturObat($idUnit, $startRow, $perPage){
        $sql = "SELECT tr.`ID_TRANSAKSI`, tr.`ID_JENISTRANSAKSI`, tr.`ID_PENUGASAN`, tr.`ID_RIWAYAT_RM`, tr.`TANGGAL_TRANSAKSI`, 
                dari.nama_unit as dari, ke.nama_unit as ke, tr.`NAMA_TRANSAKSI_SUMBER_LAIN`
                FROM `transaksi_obat` tr
                LEFT JOIN `unit` dari ON dari.id_unit=tr.`TRANSAKSI_UNIT_DARI`
                LEFT JOIN `unit` ke ON ke.id_unit=tr.`TRANSAKSI_UNIT_KE`
                WHERE tr.`ID_JENISTRANSAKSI`=22
                and tr.`TRANSAKSI_UNIT_DARI`=?
                ORDER BY tr.`ID_TRANSAKSI` desc
                LIMIT ".$startRow.", ".$perPage;
        $query= $this->db->query($sql, array($idUnit));
        return $query->result_array();
    }
    
    function getRiwayatReturObatCount($idUnit){
        $sql = "SELECT tr.`ID_TRANSAKSI`, tr.`ID_JENISTRANSAKSI`, tr.`ID_PENUGASAN`, tr.`ID_RIWAYAT_RM`, tr.`TANGGAL_TRANSAKSI`, 
                dari.nama_unit as dari, ke.nama_unit as ke, tr.`NAMA_TRANSAKSI_SUMBER_LAIN`
                FROM `transaksi_obat` tr
                LEFT JOIN `unit` dari ON dari.id_unit=tr.`TRANSAKSI_UNIT_DARI`
                LEFT JOIN `unit` ke ON ke.id_unit=tr.`TRANSAKSI_UNIT_KE`
                WHERE tr.`ID_JENISTRANSAKSI`=22
                and tr.`TRANSAKSI_UNIT_DARI`=?";
        $query= $this->db->query($sql, array($idUnit));
        return $query->num_rows();
    }
    
    function notificationStok () {
    	$sql = 'select * from (
                    select * from (
                    select * from view_stok_obat_unit_terkini 
                    where view_stok_obat_unit_terkini.ID_UNIT = '.$this->session->userdata['telah_masuk']['idunit'].'
                    ) as h
                    where expired_date <= date_add(now(), interval 1 month) or STOK_OBAT_SEKARANG <= 100
                    GROUP BY h.NOMOR_BATCH 
                    order by expired_date asc
                ) as temp where expired_date > now()';
    	$query = $this->db->query ($sql);
    	if ($query->num_rows() > 0) return $query->result_array();
    	else { return null; }
    }
    
    function notificationMinStokGOP(){
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $sql = 'CALL `get_stok_min_gop`(?)';
        $query = $this->db->query($sql, array($idUnit));
        if ($query->num_rows() > 0)
            return $query->result_array();
        else {
            return null;
        }
    }
    
    function notificationMinStokAPO(){
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $sql = 'CALL `get_stok_min_apo`(?)';
        $query = $this->db->query($sql, array($idUnit));
        if ($query->num_rows() > 0)
            return $query->result_array();
        else {
            return null;
        }
    }
    
    function notificationMinStokUNIT(){
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $sql = 'CALL `get_stok_min_unit`(?)';
        $query = $this->db->query($sql, array($idUnit));
        if ($query->num_rows() > 0)
            return $query->result_array();
        else {
            return null;
        }
    }
    
    function notificationMinStokPUSTU(){
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $sql = 'CALL `get_stok_min_pustu`(?)';
        $query = $this->db->query($sql, array($idUnit));
        if ($query->num_rows() > 0)
            return $query->result_array();
        else {
            return null;
        }
    }

}