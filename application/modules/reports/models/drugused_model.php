<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Drugused_model extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct ();
		$this->table = 'view_drug_used';
	}
	
	function getAllUsedDrugByDate ($idPuskesmas='',$idUnit='',$from, $till) {
		if($idUnit != ''){
			$this->db->where ('ID_GEDUNG', $idPuskesmas);	
			$this->db->where ('ID_UNIT', $idUnit);
		}
		if($till != ''){
			$this->db->where ('TANGGAL_TRANSAKSI <', $till); 
			$this->db->where ('TANGGAL_TRANSAKSI >', $from); 
		}
		$query = $this->db->get ($this->table);
		$this->output->enable_profiler(TRUE);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
	
	function getAllUsedDrugDetail ($idPuskesmas='',$idUnit='',$from='', $till='') {
		
		$sql = 'SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
			o.ID_OBAT as `ID_OBAT`,
			dto.ID_UNIT AS `ID_UNIT`,
			dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
			dto.NOMOR_BATCH AS `NOMOR_BATCH`,
			o.SATUAN AS `SATUAN`,
			o.KODE_OBAT AS `KODE_OBAT`,
			u.ID_GEDUNG AS `ID_GEDUNG`,
			IFNULL(SUM(dto.JUMLAH_OBAT),0) as `PEMAKAIAN`
			FROM detil_transaksi_obat dto
			LEFT JOIN transaksi_obat t
			ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
			LEFT JOIN obat o
			ON o.ID_OBAT = dto.ID_OBAT
			LEFT JOIN unit u
			ON u.ID_UNIT = dto.ID_UNIT
			where u.ID_UNIT = '.$idUnit.' and u.ID_GEDUNG = '.$idPuskesmas.' and t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND  (t.ID_JENISTRANSAKSI = 10 OR t.ID_JENISTRANSAKSI = 2 OR t.ID_JENISTRANSAKSI = 3 OR t.ID_JENISTRANSAKSI = 4 OR t.ID_JENISTRANSAKSI = 5 OR t.ID_JENISTRANSAKSI = 17 OR t.ID_JENISTRANSAKSI = 22 OR t.ID_JENISTRANSAKSI =23 OR t.ID_JENISTRANSAKSI = 26) 
			GROUP BY o.ID_OBAT, u.ID_GEDUNG, u.ID_UNIT';
		$query = $this->db->query ($sql);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
}