<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Drugachieved_model extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct ();
		$this->table = 'view_drug_achieved';
	}
	
	function getAllAchievedDrugByDate ($idPuskesmas='',$idUnit='',$from, $till) {
		if($idUnit != ''){
			$this->db->where ('ID_GEDUNG', $idPuskesmas);	
			$this->db->where ('ID_UNIT', $idUnit);
		}
		if($till != ''){
			$this->db->where ('TANGGAL_TRANSAKSI <', $till); 
			$this->db->where ('TANGGAL_TRANSAKSI >', $from); 
		}
		$query = $this->db->get ($this->table);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
	
	function getAllAchievedDrugDetail ($idPuskesmas='',$idUnit='',$from='', $till='') {
		
		$sql = 'SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
			o.ID_OBAT AS `ID_OBAT`,
			dto.ID_UNIT AS `ID_UNIT`,
			dto.NOMOR_BATCH AS `NOMOR_BATCH`,
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
			WHERE u.ID_UNIT = '.$idUnit.' AND u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND (t.ID_JENISTRANSAKSI = 1 OR t.ID_JENISTRANSAKSI = 15 OR t.ID_JENISTRANSAKSI = 18 OR t.ID_JENISTRANSAKSI = 19 OR t.ID_JENISTRANSAKSI = 20 OR t.ID_JENISTRANSAKSI = 21)
			GROUP BY o.ID_OBAT, u.ID_GEDUNG, dto.NOMOR_BATCH';
		$query = $this->db->query ($sql);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
}