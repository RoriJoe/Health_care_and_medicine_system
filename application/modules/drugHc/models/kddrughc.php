<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Kddrughc extends CI_model {

    function __construct() {
        parent::__construct();
    }
    
    function getAllStokBy($idUnit, $idPuskesmas, $tanggal){
        // $sql = "SELECT
				  // `detil_transaksi_obat`.`ID_DETIL_TO`               AS `ID_DETIL_TO`,
				  // `unit`.`ID_UNIT`                                   AS `ID_UNIT`,
				  // `unit`.`NAMA_UNIT`                                 AS `NAMA_UNIT`,
				  // `obat`.`ID_OBAT`                                   AS `ID_OBAT`,
				  // `obat`.`NAMA_OBAT`                                 AS `NAMA_OBAT`,
					// `obat`.`SATUAN`                                 AS `SATUAN`,
				  // `detil_transaksi_obat`.`STOK_OBAT_SEKARANG`        AS `STOK_OBAT_TERAKHIR`,
				  // `detil_transaksi_obat`.`NOMOR_BATCH`               AS `NOMOR_BATCH`,
				  // `detil_transaksi_obat`.`EXPIRED_DATE`              AS `EXPIRED_DATE`,
				  // `sumber_anggaran_obat`.`NAMA_SUMBER_ANGGARAN_OBAT` AS `NAMA_SUMBER_ANGGARAN_OBAT`,
				  // `sumber_anggaran_obat`.`ID_SUMBER_ANGGARAN_OBAT`   AS `ID_SUMBER_ANGGARAN_OBAT`,
				  // transaksi_obat.TANGGAL_TRANSAKSI   AS TANGGAL_TRANSAKSI
					// FROM detil_transaksi_obat
					 // LEFT JOIN unit
					   // ON unit.ID_UNIT = detil_transaksi_obat.ID_UNIT
					// LEFT JOIN obat
					  // ON detil_transaksi_obat.ID_OBAT = obat.ID_OBAT
					// LEFT JOIN transaksi_obat
					  // ON transaksi_obat.ID_TRANSAKSI = detil_transaksi_obat.ID_TRANSAKSI
				   // LEFT JOIN sumber_anggaran_obat
					 // ON sumber_anggaran_obat.ID_SUMBER_ANGGARAN_OBAT = detil_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT
					 // WHERE transaksi_obat.TANGGAL_TRANSAKSI  = '".$tanggal."' AND unit.ID_GEDUNG = ".$idPuskesmas." AND unit.ID_UNIT = ".$idUnit."
				// ORDER BY detil_transaksi_obat.ID_DETIL_TO";
				
		$sql = "SELECT * FROM 
                (
				SELECT view_stok.`ID_DETIL_TO`, view_stok.`ID_OBAT`, `view_stok`.`NOMOR_BATCH`, view_stok.`NAMA_OBAT`, view_stok.`STOK_OBAT_SEKARANG` AS STOK_OBAT_TERAKHIR, obat.`SATUAN`, `view_stok`.`EXPIRED_DATE` 
                FROM `view_stok_obat_unit_terkini` view_stok
                INNER JOIN obat ON obat.`ID_OBAT`=view_stok.`ID_OBAT`
                WHERE view_stok.`ID_UNIT`= ".$idUnit."
                ORDER BY view_stok.`ID_OBAT` DESC 
                )temp
				GROUP BY `ID_OBAT`,NOMOR_BATCH
                ORDER BY EXPIRED_DATE desc";
        $query= $this->db->query($sql, array($idUnit));
        return $query->result();
    }
	
	function getAllStokHCBy($idPuskesmas, $tanggal){
        $sql = "
				
				SELECT * FROM 
                (
				SELECT unit.ID_GEDUNG, view_stok.`ID_DETIL_TO`, view_stok.`ID_OBAT`, `view_stok`.`NOMOR_BATCH`, view_stok.`NAMA_OBAT`, view_stok.`STOK_OBAT_SEKARANG` AS STOK_OBAT_TERAKHIR, obat.`SATUAN`, `view_stok`.`EXPIRED_DATE` 
                FROM `view_stok_obat_unit_terkini` view_stok
                INNER JOIN obat ON obat.`ID_OBAT`=view_stok.`ID_OBAT`
                LEFT JOIN unit
                ON unit.ID_UNIT = view_stok.ID_UNIT
                WHERE unit.ID_GEDUNG= ".$idPuskesmas."                ORDER BY view_stok.`ID_OBAT` DESC 
                )temp
				GROUP BY `ID_OBAT`,NOMOR_BATCH
                ORDER BY EXPIRED_DATE desc";
		
        $query= $this->db->query($sql);
        return $query->result();
    }
}