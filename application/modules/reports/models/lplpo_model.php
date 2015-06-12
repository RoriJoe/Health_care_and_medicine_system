<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class LPLPO_model extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct ();
		$this->table = 'view_drug_used';
	}
	
	function getAllLplpobysource ($idPuskesmas='',$idUnit='',$from='', $till='', $idSource) {
		$sql = 'SELECT 
			main.NAMA_OBAT AS `NAMA_OBAT`,
			main.ID_OBAT AS `ID_OBAT`,
			main.KODE_OBAT AS `KODE_OBAT`,
			main.NOMOR_BATCH,
			main.ID_UNIT AS `ID_UNIT`,
			main.SATUAN AS `SATUAN`,
			IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0) AS `STOK_AWAL`,
			IFNULL(pempen.PENERIMAAN,0) AS `PENERIMAAN`,
			(IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0)+IFNULL(pempen.PENERIMAAN,0)) AS `PERSEDIAAN`,
			IFNULL(pempen.PEMAKAIAN,0) AS `PEMAKAIAN`,
			(IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0)+IFNULL(pempen.PENERIMAAN,0)-IFNULL(pempen.PEMAKAIAN,0)) AS `SISA_STOK`,
			(IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0)+IFNULL(pempen.PENERIMAAN,0)-IFNULL(pempen.PEMAKAIAN,0)) AS `STOK_OPT`,
			IFNULL(pempen.PERMINTAAN,0) AS `PERMINTAAN`,
			IFNULL(sumang.DAU,0) AS `DAU`,
			IFNULL(sumang.DAK,0) AS `DAK`,
			IFNULL(sumang.JKN,0) AS `JKN`,
			IFNULL(sumang.PROVINSI ,0) AS `PROVINSI`,
			IFNULL(sumang.APBN ,0) AS `APBN`,
			(IFNULL(sumang.DAU,0)+IFNULL(sumang.DAK,0)+IFNULL(sumang.JKN,0)+IFNULL(sumang.PROVINSI ,0)+IFNULL(sumang.APBN, 0)) AS `TOTAL`
			 FROM
			(
				SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
				o.ID_OBAT AS `ID_OBAT`,
				dto.NOMOR_BATCH,
				dto.ID_UNIT AS `ID_UNIT`,
				dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
				o.SATUAN AS `SATUAN`,
				o.KODE_OBAT AS `KODE_OBAT`,
				u.ID_GEDUNG AS `ID_GEDUNG`
				FROM detil_transaksi_obat dto
				LEFT JOIN transaksi_obat t
				ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
				LEFT JOIN obat o
				ON o.ID_OBAT = dto.ID_OBAT
				LEFT JOIN unit u
				ON u.ID_UNIT = dto.ID_UNIT
				WHERE u.ID_GEDUNG   = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" and dto.ID_SUMBER_ANGGARAN_OBAT = '.$idSource.'
				GROUP BY dto.NOMOR_BATCH, dto.ID_OBAT
				) main
			LEFT JOIN
			(
				SELECT *
				FROM
				(SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
				o.ID_OBAT AS `ID_OBAT`,
				dto.NOMOR_BATCH,
				dto.ID_UNIT AS `ID_UNIT`,
				dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
				o.SATUAN AS `SATUAN`,
				o.KODE_OBAT AS `KODE_OBAT`,
				u.ID_GEDUNG AS `ID_GEDUNG`,
				dto.JUMLAH_OBAT AS `PENERIMAAN`,
				dto.ID_DETIL_TO,
				dto.STOK_OBAT_SEKARANG
				FROM detil_transaksi_obat dto
				LEFT JOIN transaksi_obat t
				ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
				LEFT JOIN obat o
				ON o.ID_OBAT = dto.ID_OBAT
				LEFT JOIN unit u
				ON u.ID_UNIT = dto.ID_UNIT
				WHERE u.ID_GEDUNG   = '.$idPuskesmas.' AND  t.TANGGAL_TRANSAKSI < "'.$from.'" and dto.ID_SUMBER_ANGGARAN_OBAT = '.$idSource.'
				ORDER BY dto.ID_DETIL_TO DESC
				) A
				GROUP BY A.NOMOR_BATCH, A.ID_OBAT
				) STOKSEBELUM
			ON STOKSEBELUM.ID_OBAT = main.ID_OBAT AND main.NOMOR_BATCH = STOKSEBELUM.NOMOR_BATCH
			LEFT JOIN 
			(
				SELECT view_detail_transaksi_obat.*,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_JENISTRANSAKSI = 26 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 2 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 10 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 17 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 23, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `PEMAKAIAN`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_JENISTRANSAKSI = 1  OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 18 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 15, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `PENERIMAAN`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_JENISTRANSAKSI = 14, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `PERMINTAAN` FROM
				view_detail_transaksi_obat
				WHERE view_detail_transaksi_obat.ID_GEDUNG   = '.$idPuskesmas.' AND view_detail_transaksi_obat.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" and view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = '.$idSource.'
				GROUP BY view_detail_transaksi_obat.NOMOR_BATCH,view_detail_transaksi_obat.ID_OBAT
				) pempen
				ON main.ID_OBAT = pempen.ID_OBAT AND main.ID_UNIT = pempen.ID_UNIT AND main.ID_GEDUNG = pempen.ID_GEDUNG AND main.NOMOR_BATCH = pempen.NOMOR_BATCH
			LEFT JOIN
			(
				SELECT view_detail_transaksi_obat.*,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 1, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `DAU`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 2, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `DAK`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 3, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `JKN`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 4, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `PROVINSI`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 5, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `APBN`  FROM
				view_detail_transaksi_obat
				WHERE view_detail_transaksi_obat.ID_GEDUNG   = '.$idPuskesmas.' AND view_detail_transaksi_obat.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND (view_detail_transaksi_obat.ID_JENISTRANSAKSI = 1  OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 18 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 15) and view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = '.$idSource.'
				GROUP BY view_detail_transaksi_obat.NOMOR_BATCH,view_detail_transaksi_obat.ID_OBAT
				) sumang
				ON main.ID_OBAT = sumang.ID_OBAT AND main.ID_UNIT = sumang.ID_UNIT AND main.ID_GEDUNG = sumang.ID_GEDUNG AND main.NOMOR_BATCH = sumang.NOMOR_BATCH
			
			';
			
		$query = $this->db->query ($sql);
		if ($query->num_rows() > 0) return $query->result_array(); 
		return null;
	}
	
	function getAllLplpobyName ($idPuskesmas='',$idUnit='',$from='', $till='', $dname) {
		$sql = 'SELECT 
			main.NAMA_OBAT AS `NAMA_OBAT`,
			main.ID_OBAT AS `ID_OBAT`,
			main.KODE_OBAT AS `KODE_OBAT`,
			main.NOMOR_BATCH,
			main.ID_UNIT AS `ID_UNIT`,
			main.SATUAN AS `SATUAN`,
			IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0) AS `STOK_AWAL`,
			IFNULL(pempen.PENERIMAAN,0) AS `PENERIMAAN`,
			(IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0)+IFNULL(pempen.PENERIMAAN,0)) AS `PERSEDIAAN`,
			IFNULL(pempen.PEMAKAIAN,0) AS `PEMAKAIAN`,
			(IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0)+IFNULL(pempen.PENERIMAAN,0)-IFNULL(pempen.PEMAKAIAN,0)) AS `SISA_STOK`,
			(IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0)+IFNULL(pempen.PENERIMAAN,0)-IFNULL(pempen.PEMAKAIAN,0)) AS `STOK_OPT`,
			IFNULL(pempen.PERMINTAAN,0) AS `PERMINTAAN`,
			IFNULL(sumang.DAU,0) AS `DAU`,
			IFNULL(sumang.DAK,0) AS `DAK`,
			IFNULL(sumang.JKN,0) AS `JKN`,
			IFNULL(sumang.PROVINSI ,0) AS `PROVINSI`,
			IFNULL(sumang.APBN ,0) AS `APBN`,
			(IFNULL(sumang.DAU,0)+IFNULL(sumang.DAK,0)+IFNULL(sumang.JKN,0)+IFNULL(sumang.PROVINSI ,0)+IFNULL(sumang.APBN, 0)) AS `TOTAL`
			 FROM
			(
				SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
				o.ID_OBAT AS `ID_OBAT`,
				dto.NOMOR_BATCH,
				dto.ID_UNIT AS `ID_UNIT`,
				dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
				o.SATUAN AS `SATUAN`,
				o.KODE_OBAT AS `KODE_OBAT`,
				u.ID_GEDUNG AS `ID_GEDUNG`
				FROM detil_transaksi_obat dto
				LEFT JOIN transaksi_obat t
				ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
				LEFT JOIN obat o
				ON o.ID_OBAT = dto.ID_OBAT
				LEFT JOIN unit u
				ON u.ID_UNIT = dto.ID_UNIT
				WHERE u.ID_GEDUNG   = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" and o.NAMA_OBAT like "%'.$dname.'%"
				GROUP BY dto.NOMOR_BATCH, dto.ID_OBAT
				) main
			LEFT JOIN
			(
				SELECT *
				FROM
				(SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
				o.ID_OBAT AS `ID_OBAT`,
				dto.NOMOR_BATCH,
				dto.ID_UNIT AS `ID_UNIT`,
				dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
				o.SATUAN AS `SATUAN`,
				o.KODE_OBAT AS `KODE_OBAT`,
				u.ID_GEDUNG AS `ID_GEDUNG`,
				dto.JUMLAH_OBAT AS `PENERIMAAN`,
				dto.ID_DETIL_TO,
				dto.STOK_OBAT_SEKARANG
				FROM detil_transaksi_obat dto
				LEFT JOIN transaksi_obat t
				ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
				LEFT JOIN obat o
				ON o.ID_OBAT = dto.ID_OBAT
				LEFT JOIN unit u
				ON u.ID_UNIT = dto.ID_UNIT
				WHERE u.ID_GEDUNG   = '.$idPuskesmas.' AND  t.TANGGAL_TRANSAKSI < "'.$from.'"  and o.NAMA_OBAT like "%'.$dname.'%"
				ORDER BY dto.ID_DETIL_TO DESC
				) A
				GROUP BY A.NOMOR_BATCH, A.ID_OBAT
				) STOKSEBELUM
			ON STOKSEBELUM.ID_OBAT = main.ID_OBAT AND main.NOMOR_BATCH = STOKSEBELUM.NOMOR_BATCH
			LEFT JOIN 
			(
				SELECT view_detail_transaksi_obat.*,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_JENISTRANSAKSI = 26 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 2 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 10 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 17 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 23, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `PEMAKAIAN`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_JENISTRANSAKSI = 1  OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 18 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 15, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `PENERIMAAN`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_JENISTRANSAKSI = 14, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `PERMINTAAN` FROM
				view_detail_transaksi_obat
				WHERE view_detail_transaksi_obat.ID_GEDUNG   = '.$idPuskesmas.' AND view_detail_transaksi_obat.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" and view_detail_transaksi_obat.NAMA_OBAT like "%'.$dname.'%"
				GROUP BY view_detail_transaksi_obat.NOMOR_BATCH,view_detail_transaksi_obat.ID_OBAT
				) pempen
				ON main.ID_OBAT = pempen.ID_OBAT AND main.ID_UNIT = pempen.ID_UNIT AND main.ID_GEDUNG = pempen.ID_GEDUNG AND main.NOMOR_BATCH = pempen.NOMOR_BATCH
			LEFT JOIN
			(
				SELECT view_detail_transaksi_obat.*,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 1, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `DAU`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 2, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `DAK`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 3, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `JKN`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 4, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `PROVINSI`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 5, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `APBN`  FROM
				view_detail_transaksi_obat
				WHERE view_detail_transaksi_obat.ID_GEDUNG   = '.$idPuskesmas.' AND view_detail_transaksi_obat.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND (view_detail_transaksi_obat.ID_JENISTRANSAKSI = 1  OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 18 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 15) and view_detail_transaksi_obat.NAMA_OBAT like "%'.$dname.'%"
				GROUP BY view_detail_transaksi_obat.NOMOR_BATCH,view_detail_transaksi_obat.ID_OBAT
				) sumang
				ON main.ID_OBAT = sumang.ID_OBAT AND main.ID_UNIT = sumang.ID_UNIT AND main.ID_GEDUNG = sumang.ID_GEDUNG AND main.NOMOR_BATCH = sumang.NOMOR_BATCH
			
			';
			
		$query = $this->db->query ($sql);
		if ($query->num_rows() > 0) return $query->result_array(); 
		return null;
	}
	
	function getAllLplpobyEXP ($idPuskesmas='',$idUnit='',$from='', $till='',$efrom='', $etill='') {
		$sql = 'SELECT 
			main.NAMA_OBAT AS `NAMA_OBAT`,
			main.ID_OBAT AS `ID_OBAT`,
			main.KODE_OBAT AS `KODE_OBAT`,
			main.NOMOR_BATCH,
			main.ID_UNIT AS `ID_UNIT`,
			main.SATUAN AS `SATUAN`,
			IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0) AS `STOK_AWAL`,
			IFNULL(pempen.PENERIMAAN,0) AS `PENERIMAAN`,
			(IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0)+IFNULL(pempen.PENERIMAAN,0)) AS `PERSEDIAAN`,
			IFNULL(pempen.PEMAKAIAN,0) AS `PEMAKAIAN`,
			(IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0)+IFNULL(pempen.PENERIMAAN,0)-IFNULL(pempen.PEMAKAIAN,0)) AS `SISA_STOK`,
			(IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0)+IFNULL(pempen.PENERIMAAN,0)-IFNULL(pempen.PEMAKAIAN,0)) AS `STOK_OPT`,
			IFNULL(pempen.PERMINTAAN,0) AS `PERMINTAAN`,
			IFNULL(sumang.DAU,0) AS `DAU`,
			IFNULL(sumang.DAK,0) AS `DAK`,
			IFNULL(sumang.JKN,0) AS `JKN`,
			IFNULL(sumang.PROVINSI ,0) AS `PROVINSI`,
			IFNULL(sumang.APBN ,0) AS `APBN`,
			(IFNULL(sumang.DAU,0)+IFNULL(sumang.DAK,0)+IFNULL(sumang.JKN,0)+IFNULL(sumang.PROVINSI ,0)+IFNULL(sumang.APBN, 0)) AS `TOTAL`
			 FROM
			(
				SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
				o.ID_OBAT AS `ID_OBAT`,
				dto.NOMOR_BATCH,
				dto.ID_UNIT AS `ID_UNIT`,
				dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
				o.SATUAN AS `SATUAN`,
				o.KODE_OBAT AS `KODE_OBAT`,
				u.ID_GEDUNG AS `ID_GEDUNG`
				FROM detil_transaksi_obat dto
				LEFT JOIN transaksi_obat t
				ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
				LEFT JOIN obat o
				ON o.ID_OBAT = dto.ID_OBAT
				LEFT JOIN unit u
				ON u.ID_UNIT = dto.ID_UNIT
				WHERE u.ID_GEDUNG   = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" and dto.EXPIRED_DATE BETWEEN  "'.$efrom.'" AND "'.$etill.'"
				GROUP BY dto.NOMOR_BATCH, dto.ID_OBAT
				) main
			LEFT JOIN
			(
				SELECT *
				FROM
				(SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
				o.ID_OBAT AS `ID_OBAT`,
				dto.NOMOR_BATCH,
				dto.ID_UNIT AS `ID_UNIT`,
				dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
				o.SATUAN AS `SATUAN`,
				o.KODE_OBAT AS `KODE_OBAT`,
				u.ID_GEDUNG AS `ID_GEDUNG`,
				dto.JUMLAH_OBAT AS `PENERIMAAN`,
				dto.ID_DETIL_TO,
				dto.STOK_OBAT_SEKARANG
				FROM detil_transaksi_obat dto
				LEFT JOIN transaksi_obat t
				ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
				LEFT JOIN obat o
				ON o.ID_OBAT = dto.ID_OBAT
				LEFT JOIN unit u
				ON u.ID_UNIT = dto.ID_UNIT
				WHERE u.ID_GEDUNG   = '.$idPuskesmas.' AND  t.TANGGAL_TRANSAKSI < "'.$from.'" 
				ORDER BY dto.ID_DETIL_TO DESC
				) A
				GROUP BY A.NOMOR_BATCH, A.ID_OBAT
				) STOKSEBELUM
			ON STOKSEBELUM.ID_OBAT = main.ID_OBAT AND main.NOMOR_BATCH = STOKSEBELUM.NOMOR_BATCH
			LEFT JOIN 
			(
				SELECT view_detail_transaksi_obat.*,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_JENISTRANSAKSI = 26 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 2 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 10 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 17 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 23, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `PEMAKAIAN`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_JENISTRANSAKSI = 1  OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 18 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 15, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `PENERIMAAN`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_JENISTRANSAKSI = 14, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `PERMINTAAN` FROM
				view_detail_transaksi_obat
				WHERE view_detail_transaksi_obat.ID_GEDUNG   = '.$idPuskesmas.' AND view_detail_transaksi_obat.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" and view_detail_transaksi_obat.EXPIRED_DATE BETWEEN  "'.$efrom.'" AND "'.$etill.'"
				GROUP BY view_detail_transaksi_obat.NOMOR_BATCH,view_detail_transaksi_obat.ID_OBAT
				) pempen
				ON main.ID_OBAT = pempen.ID_OBAT AND main.ID_UNIT = pempen.ID_UNIT AND main.ID_GEDUNG = pempen.ID_GEDUNG AND main.NOMOR_BATCH = pempen.NOMOR_BATCH
			LEFT JOIN
			(
				SELECT view_detail_transaksi_obat.*,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 1, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `DAU`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 2, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `DAK`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 3, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `JKN`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 4, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `PROVINSI`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 5, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `APBN`  FROM
				view_detail_transaksi_obat
				WHERE view_detail_transaksi_obat.ID_GEDUNG   = '.$idPuskesmas.' AND view_detail_transaksi_obat.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND (view_detail_transaksi_obat.ID_JENISTRANSAKSI = 1  OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 18 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 15) and view_detail_transaksi_obat.EXPIRED_DATE BETWEEN  "'.$efrom.'" AND "'.$etill.'"
				GROUP BY view_detail_transaksi_obat.NOMOR_BATCH,view_detail_transaksi_obat.ID_OBAT
				) sumang
				ON main.ID_OBAT = sumang.ID_OBAT AND main.ID_UNIT = sumang.ID_UNIT AND main.ID_GEDUNG = sumang.ID_GEDUNG AND main.NOMOR_BATCH = sumang.NOMOR_BATCH
			
			';
		$query = $this->db->query ($sql);
		if ($query->num_rows() > 0) return $query->result_array(); 
		return null;
	}
	
	function getAllLplpo ($idPuskesmas='',$idUnit='',$from='', $till='') {
		
		$sql = 'SELECT 
			main.NAMA_OBAT AS `NAMA_OBAT`,
			main.ID_OBAT AS `ID_OBAT`,
			main.KODE_OBAT AS `KODE_OBAT`,
			main.NOMOR_BATCH,
			main.ID_UNIT AS `ID_UNIT`,
			main.SATUAN AS `SATUAN`,
			IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0) AS `STOK_AWAL`,
			IFNULL(pempen.PENERIMAAN,0) AS `PENERIMAAN`,
			(IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0)+IFNULL(pempen.PENERIMAAN,0)) AS `PERSEDIAAN`,
			IFNULL(pempen.PEMAKAIAN,0) AS `PEMAKAIAN`,
			(IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0)+IFNULL(pempen.PENERIMAAN,0)-IFNULL(pempen.PEMAKAIAN,0)) AS `SISA_STOK`,
			(IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0)+IFNULL(pempen.PENERIMAAN,0)-IFNULL(pempen.PEMAKAIAN,0)) AS `STOK_OPT`,
			IFNULL(pempen.PERMINTAAN,0) AS `PERMINTAAN`,
			IFNULL(sumang.DAU,0) AS `DAU`,
			IFNULL(sumang.DAK,0) AS `DAK`,
			IFNULL(sumang.JKN,0) AS `JKN`,
			IFNULL(sumang.PROVINSI ,0) AS `PROVINSI`,
			IFNULL(sumang.APBN ,0) AS `APBN`,
			(IFNULL(sumang.DAU,0)+IFNULL(sumang.DAK,0)+IFNULL(sumang.JKN,0)+IFNULL(sumang.PROVINSI ,0)+IFNULL(sumang.APBN, 0)) AS `TOTAL`
			 FROM
			(
				SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
				o.ID_OBAT AS `ID_OBAT`,
				dto.NOMOR_BATCH,
				dto.ID_UNIT AS `ID_UNIT`,
				dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
				o.SATUAN AS `SATUAN`,
				o.KODE_OBAT AS `KODE_OBAT`,
				u.ID_GEDUNG AS `ID_GEDUNG`
				FROM detil_transaksi_obat dto
				LEFT JOIN transaksi_obat t
				ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
				LEFT JOIN obat o
				ON o.ID_OBAT = dto.ID_OBAT
				LEFT JOIN unit u
				ON u.ID_UNIT = dto.ID_UNIT
				WHERE u.ID_GEDUNG   = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'"
				GROUP BY dto.NOMOR_BATCH, dto.ID_OBAT
				) main
			LEFT JOIN
			(
				SELECT *
				FROM
				(SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
				o.ID_OBAT AS `ID_OBAT`,
				dto.NOMOR_BATCH,
				dto.ID_UNIT AS `ID_UNIT`,
				dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
				o.SATUAN AS `SATUAN`,
				o.KODE_OBAT AS `KODE_OBAT`,
				u.ID_GEDUNG AS `ID_GEDUNG`,
				dto.JUMLAH_OBAT AS `PENERIMAAN`,
				dto.ID_DETIL_TO,
				dto.STOK_OBAT_SEKARANG
				FROM detil_transaksi_obat dto
				LEFT JOIN transaksi_obat t
				ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
				LEFT JOIN obat o
				ON o.ID_OBAT = dto.ID_OBAT
				LEFT JOIN unit u
				ON u.ID_UNIT = dto.ID_UNIT
				WHERE u.ID_GEDUNG   = '.$idPuskesmas.' AND  t.TANGGAL_TRANSAKSI < "'.$from.'"
				ORDER BY dto.ID_DETIL_TO DESC
				) A
				GROUP BY A.NOMOR_BATCH, A.ID_OBAT
				) STOKSEBELUM
			ON STOKSEBELUM.ID_OBAT = main.ID_OBAT AND main.NOMOR_BATCH = STOKSEBELUM.NOMOR_BATCH
			LEFT JOIN 
			(
				SELECT view_detail_transaksi_obat.*,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_JENISTRANSAKSI = 26 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 2 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 10 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 17 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 23, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `PEMAKAIAN`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_JENISTRANSAKSI = 1  OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 18 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 15, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `PENERIMAAN`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_JENISTRANSAKSI = 14, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `PERMINTAAN` FROM
				view_detail_transaksi_obat
				WHERE view_detail_transaksi_obat.ID_GEDUNG   = '.$idPuskesmas.' AND view_detail_transaksi_obat.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'"
				GROUP BY view_detail_transaksi_obat.NOMOR_BATCH,view_detail_transaksi_obat.ID_OBAT
				) pempen
				ON main.ID_OBAT = pempen.ID_OBAT AND main.ID_UNIT = pempen.ID_UNIT AND main.ID_GEDUNG = pempen.ID_GEDUNG AND main.NOMOR_BATCH = pempen.NOMOR_BATCH
			LEFT JOIN
			(
				SELECT view_detail_transaksi_obat.*,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 1, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `DAU`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 2, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `DAK`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 3, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `JKN`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 4, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `PROVINSI`,
				IFNULL(SUM(IF(view_detail_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = 5, view_detail_transaksi_obat.JUMLAH_OBAT, 0)),0) AS `APBN`  FROM
				view_detail_transaksi_obat
				WHERE view_detail_transaksi_obat.ID_GEDUNG   = '.$idPuskesmas.' AND view_detail_transaksi_obat.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND (view_detail_transaksi_obat.ID_JENISTRANSAKSI = 1  OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 18 OR view_detail_transaksi_obat.ID_JENISTRANSAKSI = 15)
				GROUP BY view_detail_transaksi_obat.NOMOR_BATCH,view_detail_transaksi_obat.ID_OBAT
				) sumang
				ON main.ID_OBAT = sumang.ID_OBAT AND main.ID_UNIT = sumang.ID_UNIT AND main.ID_GEDUNG = sumang.ID_GEDUNG AND main.NOMOR_BATCH = sumang.NOMOR_BATCH
			
			';
		$query = $this->db->query ($sql);
		if ($query->num_rows() > 0) return $query->result_array(); 
		return null;
	}
	
	function getopnamegfk ($idPuskesmas='',$idUnit='',$from='', $till='') {
		
		$sql = 'SELECT * FROM (
SELECT * FROM (
SELECT temp.*, temp2.HARGA_SATUAN FROM 
(SELECT
  `transaksi_obat`.`ID_TRANSAKSI`                    AS `ID_TRANSAKSI`,
  `transaksi_obat`.`ID_JENISTRANSAKSI`               AS `ID_JENISTRANSAKSI`,
  `transaksi_obat`.`TANGGAL_TRANSAKSI`               AS `tanggal_transaksi`,
  `detil_transaksi_obat`.`ID_DETIL_TO`               AS `ID_DETIL_TO`,
  `unit`.`ID_UNIT`                                   AS `ID_UNIT`,
  `unit`.`NAMA_UNIT`                                 AS `NAMA_UNIT`,
  `obat`.`ID_OBAT`                                   AS `ID_OBAT`,
  `obat`.`NAMA_OBAT`                                 AS `NAMA_OBAT`,
  `obat`.`KODE_OBAT`                                 AS `KODE_OBAT`,
  `obat`.`SATUAN`                                    AS `SATUAN`,
  `obat`.`JML_OBAT_MIN`                              AS `JML_OBAT_MIN`,
  IFNULL(`detil_transaksi_obat`.`STOK_OBAT_SEKARANG`,0)        AS `SISA_STOK`,
  `detil_transaksi_obat`.`NOMOR_BATCH`               AS `BATCH`,
  `detil_transaksi_obat`.`EXPIRED_DATE`              AS `KEDALUARSA`,
  `sumber_anggaran_obat`.`NAMA_SUMBER_ANGGARAN_OBAT` AS `NAMA_SUMBER_ANGGARAN_OBAT`,
  `sumber_anggaran_obat`.`ID_SUMBER_ANGGARAN_OBAT`   AS `ID_SUMBER_ANGGARAN_OBAT`
FROM ((((`detil_transaksi_obat`
      LEFT JOIN `unit`
        ON ((`unit`.`ID_UNIT` = `detil_transaksi_obat`.`ID_UNIT`)))
     LEFT JOIN `obat`
       ON ((`detil_transaksi_obat`.`ID_OBAT` = `obat`.`ID_OBAT`)))
    LEFT JOIN `sumber_anggaran_obat`
      ON ((`sumber_anggaran_obat`.`ID_SUMBER_ANGGARAN_OBAT` = `detil_transaksi_obat`.`ID_SUMBER_ANGGARAN_OBAT`)))
   LEFT JOIN `transaksi_obat`
     ON ((`transaksi_obat`.`ID_TRANSAKSI` = `detil_transaksi_obat`.`ID_TRANSAKSI`)))
ORDER BY `detil_transaksi_obat`.`ID_DETIL_TO` DESC) AS temp 
LEFT JOIN (
SELECT detil_transaksi_obat.ID_OBAT, detil_transaksi_obat.NOMOR_BATCH, detil_transaksi_obat.HARGA_SATUAN 
FROM detil_transaksi_obat
LEFT JOIN transaksi_obat ON transaksi_obat.ID_TRANSAKSI = detil_transaksi_obat.ID_TRANSAKSI
WHERE transaksi_obat.ID_JENISTRANSAKSI = 1
GROUP BY detil_transaksi_obat.NOMOR_BATCH, detil_transaksi_obat.ID_OBAT
) AS temp2
ON temp.ID_OBAT = temp2.ID_OBAT AND temp.BATCH = temp2.NOMOR_BATCH ) AS holong
WHERE tanggal_transaksi BETWEEN "'.$from.'" AND "'.$till.'" AND ID_UNIT = '.$idUnit.') AS A GROUP BY A.ID_OBAT, A.BATCH
';
		$query = $this->db->query ($sql);
		if ($query->num_rows() > 0) return $query->result_array(); 
		return null;
	}
	
	function getopname ($idPuskesmas='',$idUnit='',$from='', $till='') {
		
		$sql = 'SELECT * FROM (SELECT EXPIRED_DATE AS KEDALUARSA, NOMOR_BATCH AS BATCH, KODE_OBAT, NAMA_OBAT, SATUAN, IFNULL(STOK_OBAT_SEKARANG,0) AS SISA_STOK FROM view_stok_obat_unit_perbulan
WHERE ID_UNIT = '.$idUnit.' and tanggal_transaksi BETWEEN "'.$from.'" AND "'.$till.'")a  Group By KODE_OBAT';
		$query = $this->db->query ($sql);
		if ($query->num_rows() > 0) return $query->result_array(); 
		return null;
	}
	
	function getAllLplpoPuskesmas ($idPuskesmas='',$from='', $till='') {
		
		$sql = '	SELECT 
	main.NAMA_OBAT AS `NAMA_OBAT`,
	main.ID_OBAT AS `ID_OBAT`,
	main.KODE_OBAT AS `KODE_OBAT`,
	main.NOMOR_BATCH,
	main.ID_UNIT AS `ID_UNIT`,
	main.SATUAN AS `SATUAN`,
	IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0) AS `STOK_AWAL`,
	IFNULL(pen.PENERIMAAN,0) AS `PENERIMAAN`,
	(IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0)+IFNULL(pen.PENERIMAAN,0)) AS `PERSEDIAAN`,
	IFNULL(pem.PEMAKAIAN,0) AS `PEMAKAIAN`,
	(IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0)+IFNULL(pen.PENERIMAAN,0)-IFNULL(pem.PEMAKAIAN,0)) AS `SISA_STOK`,
	(IFNULL(STOKSEBELUM.STOK_OBAT_SEKARANG,0)+IFNULL(pen.PENERIMAAN,0)-IFNULL(pem.PEMAKAIAN,0)) AS `STOK_OPT`,
	IFNULL(perm.PERMINTAAN,0) AS `PERMINTAAN`,
	IFNULL(dau.DAU,0) AS `DAU`,
	IFNULL(dak.DAK,0) AS `DAK`,
	IFNULL(jkn.JKN,0) AS `JKN`,
	IFNULL(provinsi.PROVINSI ,0) AS `PROVINSI`,
	IFNULL(apbn.APBN ,0) AS `APBN`,
	(IFNULL(dau.DAU,0)+IFNULL(dak.DAK,0)+IFNULL(jkn.JKN,0)+IFNULL(provinsi.PROVINSI ,0)+IFNULL(apbn.APBN, 0)) AS `TOTAL`
	 FROM
	(
	SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
	o.ID_OBAT AS `ID_OBAT`,
	dto.NOMOR_BATCH,
	dto.ID_UNIT AS `ID_UNIT`,
	dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
	o.SATUAN AS `SATUAN`,
	o.KODE_OBAT AS `KODE_OBAT`,
	u.ID_GEDUNG AS `ID_GEDUNG`,
	SUM(dto.JUMLAH_OBAT) AS `PENERIMAAN`
	FROM detil_transaksi_obat dto
	LEFT JOIN transaksi_obat t
	ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
	LEFT JOIN obat o
	ON o.ID_OBAT = dto.ID_OBAT
	LEFT JOIN unit u
	ON u.ID_UNIT = dto.ID_UNIT
	WHERE u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'"
	GROUP BY dto.NOMOR_BATCH
	) main
	LEFT JOIN
	(
	SELECT *
	FROM
	(SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
	o.ID_OBAT AS `ID_OBAT`,
	dto.NOMOR_BATCH,
	dto.ID_UNIT AS `ID_UNIT`,
	dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
	o.SATUAN AS `SATUAN`,
	o.KODE_OBAT AS `KODE_OBAT`,
	u.ID_GEDUNG AS `ID_GEDUNG`,
	dto.JUMLAH_OBAT AS `PENERIMAAN`,
	dto.ID_DETIL_TO,
	dto.STOK_OBAT_SEKARANG
	FROM detil_transaksi_obat dto
	LEFT JOIN transaksi_obat t
	ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
	LEFT JOIN obat o
	ON o.ID_OBAT = dto.ID_OBAT
	LEFT JOIN unit u
	ON u.ID_UNIT = dto.ID_UNIT
	WHERE u.ID_GEDUNG = '.$idPuskesmas.' AND  t.TANGGAL_TRANSAKSI < "'.$from.'"
	ORDER BY dto.ID_DETIL_TO DESC
	) A
	GROUP BY A.NOMOR_BATCH
	) STOKSEBELUM
	ON STOKSEBELUM.ID_OBAT = main.ID_OBAT
	LEFT JOIN
	(
	SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
	o.ID_OBAT AS `ID_OBAT`,
	dto.ID_UNIT AS `ID_UNIT`,
	dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
	dto.NOMOR_BATCH,
	o.SATUAN AS `SATUAN`,
	o.KODE_OBAT AS `KODE_OBAT`,
	u.ID_GEDUNG AS `ID_GEDUNG`,
	IFNULL(dto.JUMLAH_OBAT,0) AS `PENERIMAAN`
	FROM detil_transaksi_obat dto
	LEFT JOIN transaksi_obat t
	ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
	LEFT JOIN obat o
	ON o.ID_OBAT = dto.ID_OBAT
	LEFT JOIN unit u
	ON u.ID_UNIT = dto.ID_UNIT
	WHERE u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND (t.ID_JENISTRANSAKSI = 1 OR t.ID_JENISTRANSAKSI = 15 OR t.ID_JENISTRANSAKSI = 18)
	GROUP BY dto.NOMOR_BATCH
	) pen
	ON main.ID_OBAT = pen.ID_OBAT AND main.ID_UNIT = pen.ID_UNIT AND main.ID_GEDUNG = pen.ID_GEDUNG
	LEFT JOIN 
	(
	SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
	o.ID_OBAT AS `ID_OBAT`,
	dto.ID_UNIT AS `ID_UNIT`,
	dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
	dto.NOMOR_BATCH,
	o.SATUAN AS `SATUAN`,
	o.KODE_OBAT AS `KODE_OBAT`,
	u.ID_GEDUNG AS `ID_GEDUNG`,
	IFNULL(SUM(dto.JUMLAH_OBAT),0) AS `PEMAKAIAN`
	FROM detil_transaksi_obat dto
	LEFT JOIN transaksi_obat t
	ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
	LEFT JOIN obat o
	ON o.ID_OBAT = dto.ID_OBAT
	LEFT JOIN unit u
	ON u.ID_UNIT = dto.ID_UNIT
	WHERE u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND  (t.ID_JENISTRANSAKSI = 10 OR t.ID_JENISTRANSAKSI = 2 OR t.ID_JENISTRANSAKSI = 17 OR t.ID_JENISTRANSAKSI = 23 OR t.ID_JENISTRANSAKSI = 26) 
	GROUP BY dto.NOMOR_BATCH
	) pem
	ON main.ID_OBAT = pem.ID_OBAT AND main.ID_UNIT = pem.ID_UNIT AND main.ID_GEDUNG = pem.ID_GEDUNG
	LEFT JOIN
	(
	SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
	o.ID_OBAT AS `ID_OBAT`,
	dto.ID_UNIT AS `ID_UNIT`,
	dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
	dto.NOMOR_BATCH,
	o.SATUAN AS `SATUAN`,
	o.KODE_OBAT AS `KODE_OBAT`,
	u.ID_GEDUNG AS `ID_GEDUNG`,
	SUM(dto.JUMLAH_OBAT) AS `DAU`
	FROM detil_transaksi_obat dto
	LEFT JOIN transaksi_obat t
	ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
	LEFT JOIN obat o
	ON o.ID_OBAT = dto.ID_OBAT
	LEFT JOIN unit u
	ON u.ID_UNIT = dto.ID_UNIT
	WHERE u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND dto.ID_SUMBER_ANGGARAN_OBAT = 1 AND (t.ID_JENISTRANSAKSI = 1 OR t.ID_JENISTRANSAKSI = 15 OR t.ID_JENISTRANSAKSI = 18)
	GROUP BY dto.NOMOR_BATCH
	) dau
	ON main.ID_OBAT = dau.ID_OBAT AND main.ID_UNIT = dau.ID_UNIT AND main.ID_GEDUNG = dau.ID_GEDUNG
	LEFT JOIN
	(
	SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
	o.ID_OBAT AS `ID_OBAT`,
	dto.ID_UNIT AS `ID_UNIT`,
	dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
	o.SATUAN AS `SATUAN`,
	dto.NOMOR_BATCH,
	o.KODE_OBAT AS `KODE_OBAT`,
	u.ID_GEDUNG AS `ID_GEDUNG`,
	SUM(dto.JUMLAH_OBAT) AS `DAK`
	FROM detil_transaksi_obat dto
	LEFT JOIN transaksi_obat t
	ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
	LEFT JOIN obat o
	ON o.ID_OBAT = dto.ID_OBAT
	LEFT JOIN unit u
	ON u.ID_UNIT = dto.ID_UNIT
	WHERE u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND dto.ID_SUMBER_ANGGARAN_OBAT = 2 AND (t.ID_JENISTRANSAKSI = 1 OR t.ID_JENISTRANSAKSI = 15 OR t.ID_JENISTRANSAKSI = 18)
	GROUP BY dto.NOMOR_BATCH
	) dak
	ON main.ID_OBAT = dak.ID_OBAT AND main.ID_UNIT = dak.ID_UNIT AND main.ID_GEDUNG = dak.ID_GEDUNG
	LEFT JOIN
	(
	SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
	o.ID_OBAT AS `ID_OBAT`,
	dto.ID_UNIT AS `ID_UNIT`,
	dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
	dto.NOMOR_BATCH,
	o.SATUAN AS `SATUAN`,
	o.KODE_OBAT AS `KODE_OBAT`,
	u.ID_GEDUNG AS `ID_GEDUNG`,
	SUM(dto.JUMLAH_OBAT) AS `JKN`
	FROM detil_transaksi_obat dto
	LEFT JOIN transaksi_obat t
	ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
	LEFT JOIN obat o
	ON o.ID_OBAT = dto.ID_OBAT
	LEFT JOIN unit u
	ON u.ID_UNIT = dto.ID_UNIT
	WHERE u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND dto.ID_SUMBER_ANGGARAN_OBAT = 3 AND (t.ID_JENISTRANSAKSI = 1 OR t.ID_JENISTRANSAKSI = 15 OR t.ID_JENISTRANSAKSI = 18)
	GROUP BY dto.NOMOR_BATCH
	) jkn
	ON main.ID_OBAT = jkn.ID_OBAT AND main.ID_UNIT = jkn.ID_UNIT AND main.ID_GEDUNG = jkn.ID_GEDUNG
	LEFT JOIN
	(
	SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
	o.ID_OBAT AS `ID_OBAT`,
	dto.ID_UNIT AS `ID_UNIT`,
	dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
	o.SATUAN AS `SATUAN`,
	dto.NOMOR_BATCH,
	o.KODE_OBAT AS `KODE_OBAT`,
	u.ID_GEDUNG AS `ID_GEDUNG`,
	SUM(dto.JUMLAH_OBAT) AS `PROVINSI`
	FROM detil_transaksi_obat dto
	LEFT JOIN transaksi_obat t
	ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
	LEFT JOIN obat o
	ON o.ID_OBAT = dto.ID_OBAT
	LEFT JOIN unit u
	ON u.ID_UNIT = dto.ID_UNIT
	WHERE u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND dto.ID_SUMBER_ANGGARAN_OBAT = 4 AND (t.ID_JENISTRANSAKSI = 1 OR t.ID_JENISTRANSAKSI = 15 OR t.ID_JENISTRANSAKSI = 18)
	GROUP BY dto.NOMOR_BATCH
	) provinsi
	ON main.ID_OBAT = provinsi.ID_OBAT AND main.ID_UNIT = provinsi.ID_UNIT AND main.ID_GEDUNG = provinsi.ID_GEDUNG
	LEFT JOIN
	(
	SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
	o.ID_OBAT AS `ID_OBAT`,
	dto.ID_UNIT AS `ID_UNIT`,
	dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
	o.SATUAN AS `SATUAN`,
	dto.NOMOR_BATCH,
	o.KODE_OBAT AS `KODE_OBAT`,
	u.ID_GEDUNG AS `ID_GEDUNG`,
	SUM(dto.JUMLAH_OBAT) AS `APBN`
	FROM detil_transaksi_obat dto
	LEFT JOIN transaksi_obat t
	ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
	LEFT JOIN obat o
	ON o.ID_OBAT = dto.ID_OBAT
	LEFT JOIN unit u
	ON u.ID_UNIT = dto.ID_UNIT
	WHERE u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND dto.ID_SUMBER_ANGGARAN_OBAT = 5 AND (t.ID_JENISTRANSAKSI = 1 OR t.ID_JENISTRANSAKSI = 15 OR t.ID_JENISTRANSAKSI = 18)
	GROUP BY dto.NOMOR_BATCH
	) apbn
	ON main.ID_OBAT = apbn.ID_OBAT AND main.ID_UNIT = apbn.ID_UNIT AND main.ID_GEDUNG = apbn.ID_GEDUNG
	LEFT JOIN
	(
	SELECT * FROM
	(
	SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
	o.ID_OBAT AS `ID_OBAT`,
	dto.ID_UNIT AS `ID_UNIT`,
	dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
	dto.NOMOR_BATCH,
	o.SATUAN AS `SATUAN`,
	o.KODE_OBAT AS `KODE_OBAT`,
	dto.STOK_OBAT_SEKARANG AS `STOK_AWAL`,
	u.ID_GEDUNG AS `ID_GEDUNG`,
	t.TANGGAL_TRANSAKSI AS `TANGGAL_TRANSAKSI`,
	t.ID_TRANSAKSI AS `ID_TRANSAKSI`
	FROM detil_transaksi_obat dto
	LEFT JOIN transaksi_obat t
	ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
	LEFT JOIN obat o
	ON o.ID_OBAT = dto.ID_OBAT
	LEFT JOIN unit u
	ON u.ID_UNIT = dto.ID_UNIT
	GROUP BY t.TANGGAL_TRANSAKSI, o.ID_OBAT, U.ID_GEDUNG
	) a
	GROUP BY NOMOR_BATCH
	) sa
	ON main.ID_OBAT =sa.ID_OBAT AND main.ID_UNIT = sa.ID_UNIT AND main.ID_GEDUNG = sa.ID_GEDUNG
	LEFT JOIN
	(

	SELECT *
	FROM
	(SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
	o.ID_OBAT AS `ID_OBAT`,
	dto.ID_UNIT AS `ID_UNIT`,
	dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
	o.SATUAN AS `SATUAN`,
	dto.NOMOR_BATCH,
	o.KODE_OBAT AS `KODE_OBAT`,
	dto.STOK_OBAT_SEKARANG AS `STOK_OPT`,
	u.ID_GEDUNG AS `ID_GEDUNG`,
	t.TANGGAL_TRANSAKSI AS `TANGGAL_TRANSAKSI`,
	t.ID_TRANSAKSI AS `ID_TRANSAKSI`
	FROM detil_transaksi_obat dto
	LEFT JOIN transaksi_obat t
	ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
	LEFT JOIN obat o
	ON o.ID_OBAT = dto.ID_OBAT
	LEFT JOIN unit u
	ON u.ID_UNIT = dto.ID_UNIT
	WHERE u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'"
	ORDER BY T.ID_TRANSAKSI DESC
	) A
	GROUP BY NOMOR_BATCH
	) sopt
	ON main.ID_OBAT =sopt.ID_OBAT AND main.ID_UNIT = sopt.ID_UNIT AND main.ID_GEDUNG = sopt.ID_GEDUNG
	LEFT JOIN 
	(
	SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
	o.ID_OBAT AS `ID_OBAT`,
	dto.ID_UNIT AS `ID_UNIT`,
	dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
	dto.NOMOR_BATCH,
	o.SATUAN AS `SATUAN`,
	o.KODE_OBAT AS `KODE_OBAT`,
	u.ID_GEDUNG AS `ID_GEDUNG`,
	IFNULL(SUM(dto.JUMLAH_OBAT),0) AS `PERMINTAAN`
	FROM detil_transaksi_obat dto
	LEFT JOIN transaksi_obat t
	ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
	LEFT JOIN obat o
	ON o.ID_OBAT = dto.ID_OBAT
	LEFT JOIN unit u
	ON u.ID_UNIT = dto.ID_UNIT
	WHERE u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND t.ID_JENISTRANSAKSI = 14 
	GROUP BY dto.NOMOR_BATCH
	) perm
	ON main.ID_OBAT = perm.ID_OBAT AND main.ID_UNIT = perm.ID_UNIT AND main.ID_GEDUNG = perm.ID_GEDUNG';
		$query = $this->db->query ($sql);
		if ($query->num_rows() > 0) return $query->result_array(); 
		return null;
	}
}