<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mDrugsNow extends CI_Model {

	function __construct () {
		parent::__construct();
	}
	
	function insertNewEntry ($data) {
		if ($this->db->insert('stok_obat_sekarang', $data)) {
			return true;
		}
		return false;
	}
	
	function updateEntry ($data) {
		if ($this->session->userdata('idunittujuan') == null) {
			$sql = 'update stok_obat_sekarang set JUMLAH_OBAT_SEKARANG = JUMLAH_OBAT_SEKARANG + '
			.$data['jumlah_obat_sekarang'].' where ID_UNIT='.$data['id_unit'].' and id_obat ='
			.$data['id_obat'];
		}
		else {
			$sql = 'update stok_obat_sekarang set JUMLAH_OBAT_SEKARANG = JUMLAH_OBAT_SEKARANG - '
			.$data['jumlah_obat_sekarang'].' where ID_UNIT='.$data['id_unit'].' and id_obat ='
			.$data['id_obat'];
		}
		$this->db->query($sql);
		if ($this->db->affected_rows() > 0){
			return true;
		}
		else {
			return $this->insertNewEntry($data);
		}
		return false;
	}
	
	function getEntryByHC ($id_gedung) {
		$sql = 'select temp.*, SUM(temp.stok_obat_sekarang) as TOTAL from
				(
				select view_stok_obat_unit_terkini.* from view_stok_obat_unit_terkini
				left join unit on view_stok_obat_unit_terkini.ID_UNIT = unit.ID_UNIT
				left join gedung on unit.ID_GEDUNG = gedung.ID_GEDUNG
				where unit.ID_GEDUNG = '.$id_gedung.'  
				order by view_stok_obat_unit_terkini.ID_DETIL_TO DESC
				) temp
				group by temp.ID_OBAT';
		$query = $this->db->query ($sql);
		if ($query->num_rows>0) return $query->result_array();
		else return null;
	}
	
	function getEntryByUnit ($id_unit){
		$sql = 'select temp.*, SUM(temp.stok_obat_sekarang) as TOTAL from
				(
				select view_stok_obat_unit_terkini.* from view_stok_obat_unit_terkini
				where view_stok_obat_unit_terkini.ID_UNIT = '.$id_unit.' 
				order by view_stok_obat_unit_terkini.ID_DETIL_TO DESC
				) temp
				group by temp.ID_OBAT';
		$query = $this->db->query ($sql);
		if ($query->num_rows>0) return $query->result_array();
		else return null;
	}
	
	function getEntryByUnitIdBatch ($id_unit, $id_obat, $batch) {
		$sql = 'select * from
				(
				select view_stok_obat_unit_terkini.* from view_stok_obat_unit_terkini
				where view_stok_obat_unit_terkini.ID_UNIT = '.$id_unit.' and 
				view_stok_obat_unit_terkini.ID_OBAT = '.$id_obat.' and 
				view_stok_obat_unit_terkini.NOMOR_BATCH = \''.$batch.'\'
				order by view_stok_obat_unit_terkini.ID_DETIL_TO DESC
				) temp
				group by temp.ID_OBAT';
				
		// echo $sql;
		$query = $this->db->query ($sql);
		if ($query->num_rows>0) { 
			$result = $query->result_array();
			return $result[0];
		}
		else return null;
	}
	
	function getRecommendationCITO ($id_unit, $id_obat) {
		$sql = 'SELECT bulan_kedua.*,
ROUND(((IFNULL(0,bulan_pertama.STOK_AKHIR)-IFNULL(0,bulan_pertama.STOK_AWAL))+(IFNULL(0,bulan_kedua.STOK_AKHIR)-IFNULL(0,bulan_kedua.STOK_AWAL))-bulan_kedua.STOK_AKHIR) * 1.25) AS REKOMENDASI
FROM
(
SELECT awal_bulan_1.*, akhir_bulan_1.STOK_AKHIR FROM
(
SELECT awal_bulan.ID_OBAT, awal_bulan.NAMA_OBAT, SUM(awal_bulan.STOK_OBAT_SEKARANG) AS STOK_AWAL  FROM
(
SELECT view_stok_obat_unit_terkini.*, transaksi_obat.TANGGAL_TRANSAKSI FROM view_stok_obat_unit_terkini
LEFT JOIN detil_transaksi_obat
ON detil_transaksi_obat.ID_DETIL_TO = view_stok_obat_unit_terkini.ID_DETIL_TO
LEFT JOIN transaksi_obat
ON transaksi_obat.ID_TRANSAKSI = detil_transaksi_obat.ID_TRANSAKSI
WHERE view_stok_obat_unit_terkini.ID_UNIT = '.$id_unit. ' AND
TIMESTAMPDIFF(MONTH, transaksi_obat.TANGGAL_TRANSAKSI, NOW()) = 2
ORDER BY view_stok_obat_unit_terkini.ID_DETIL_TO ASC
) awal_bulan
GROUP BY awal_bulan.ID_OBAT
) awal_bulan_1
RIGHT JOIN 
(
SELECT akhir_bulan.ID_OBAT, akhir_bulan.NAMA_OBAT, SUM(akhir_bulan.STOK_OBAT_SEKARANG) AS STOK_AKHIR FROM
(
SELECT view_stok_obat_unit_terkini.*, transaksi_obat.TANGGAL_TRANSAKSI FROM view_stok_obat_unit_terkini
LEFT JOIN detil_transaksi_obat
ON detil_transaksi_obat.ID_DETIL_TO = view_stok_obat_unit_terkini.ID_DETIL_TO
LEFT JOIN transaksi_obat
ON transaksi_obat.ID_TRANSAKSI = detil_transaksi_obat.ID_TRANSAKSI
WHERE view_stok_obat_unit_terkini.ID_UNIT = '.$id_unit. ' AND
TIMESTAMPDIFF(MONTH, transaksi_obat.TANGGAL_TRANSAKSI, NOW()) = 2
ORDER BY view_stok_obat_unit_terkini.ID_DETIL_TO DESC
) akhir_bulan
GROUP BY akhir_bulan.ID_OBAT
) akhir_bulan_1
ON awal_bulan_1.ID_OBAT = akhir_bulan_1.ID_OBAT
) AS bulan_pertama
RIGHT JOIN
(
SELECT awal_bulan_2.*, akhir_bulan_2.STOK_AKHIR FROM
(
SELECT awal_bulan.ID_OBAT, awal_bulan.NAMA_OBAT, SUM(awal_bulan.STOK_OBAT_SEKARANG) AS STOK_AWAL  FROM
(
SELECT view_stok_obat_unit_terkini.*, transaksi_obat.TANGGAL_TRANSAKSI FROM view_stok_obat_unit_terkini
LEFT JOIN detil_transaksi_obat
ON detil_transaksi_obat.ID_DETIL_TO = view_stok_obat_unit_terkini.ID_DETIL_TO
LEFT JOIN transaksi_obat
ON transaksi_obat.ID_TRANSAKSI = detil_transaksi_obat.ID_TRANSAKSI
WHERE view_stok_obat_unit_terkini.ID_UNIT = '.$id_unit. ' AND
TIMESTAMPDIFF(MONTH, transaksi_obat.TANGGAL_TRANSAKSI, NOW()) = 1
ORDER BY view_stok_obat_unit_terkini.ID_DETIL_TO ASC
) awal_bulan
GROUP BY awal_bulan.ID_OBAT
) awal_bulan_2
RIGHT JOIN 
(
SELECT akhir_bulan.ID_OBAT, akhir_bulan.NAMA_OBAT, SUM(akhir_bulan.STOK_OBAT_SEKARANG) AS STOK_AKHIR FROM
(
SELECT view_stok_obat_unit_terkini.*, transaksi_obat.TANGGAL_TRANSAKSI FROM view_stok_obat_unit_terkini
LEFT JOIN detil_transaksi_obat
ON detil_transaksi_obat.ID_DETIL_TO = view_stok_obat_unit_terkini.ID_DETIL_TO
LEFT JOIN transaksi_obat
ON transaksi_obat.ID_TRANSAKSI = detil_transaksi_obat.ID_TRANSAKSI
WHERE view_stok_obat_unit_terkini.ID_UNIT = '.$id_unit. ' AND
TIMESTAMPDIFF(MONTH, transaksi_obat.TANGGAL_TRANSAKSI, NOW()) = 1
ORDER BY view_stok_obat_unit_terkini.ID_DETIL_TO DESC
) akhir_bulan
GROUP BY akhir_bulan.ID_OBAT
) akhir_bulan_2
ON awal_bulan_2.ID_OBAT = akhir_bulan_2.ID_OBAT
) AS bulan_kedua
ON bulan_pertama.ID_OBAT = bulan_kedua.ID_OBAT
WHERE bulan_kedua.ID_OBAT = '.$id_obat;
		
		$query = $this->db->query ($sql);
		if ($query->num_rows>0){	
			$result = $query->result_array();
			return $result[0];
		}
		else return null;
	}
}