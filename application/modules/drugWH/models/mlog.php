<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mLog extends CI_Model {

    function __construct () {
        parent::__construct();
    }
    
    function getLogIn () {
		$sql = "select 
			transaksi_obat.ID_TRANSAKSI, 
			transaksi_obat.NOID_TRANSAKSI,
			jenis_transaksi_obat.NAMA_JENIS, 
			DATE_FORMAT(transaksi_obat.TANGGAL_TRANSAKSI,'%d %M %Y') as TANGGAL_TRANSAKSI, 
			transaksi_obat.TANGGAL_REKAP_TRANSAKSI 
			from transaksi_obat 
			left join jenis_transaksi_obat on jenis_transaksi_obat.ID_JENISTRANSAKSI = transaksi_obat.ID_JENISTRANSAKSI 
			where transaksi_obat.ID_JENISTRANSAKSI = 1 order by transaksi_obat.ID_TRANSAKSI DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
		else return null;
    }
	
	// sudah keluar
	function getLogOut (){
		$sql = "SELECT transaksi_obat.ID_TRANSAKSI, jenis_transaksi_obat.NAMA_JENIS, 
				unit.NAMA_UNIT, gedung.NAMA_GEDUNG AS NAMA_PUSKESMAS, 
				transaksi_obat.NAMA_TRANSAKSI_SUMBER_LAIN AS PENGIRIMAN_SELAIN_PUSKESMAS, DATE_FORMAT(transaksi_obat.TANGGAL_TRANSAKSI,'%d %M %Y') as TANGGAL_TRANSAKSI,
				IF (transaksi_obat.FLAG_KONFIRMASI=0, 'belum dikonfirmasi', 'OK') AS STATUS_KONFIRMASI,
				transaksi_obat.TANGGAL_REKAP_TRANSAKSI FROM transaksi_obat
				LEFT JOIN jenis_transaksi_obat ON jenis_transaksi_obat.ID_JENISTRANSAKSI = transaksi_obat.ID_JENISTRANSAKSI
				LEFT JOIN unit ON unit.ID_UNIT = transaksi_obat.TRANSAKSI_UNIT_KE
				LEFT JOIN gedung ON gedung.ID_GEDUNG = unit.ID_GEDUNG
				WHERE transaksi_obat.ID_JENISTRANSAKSI = 2 AND transaksi_obat.FLAG_KONFIRMASI IS NOT NULL ORDER BY transaksi_obat.ID_TRANSAKSI DESC";
		$query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
		else return null;
	}
	
	// pending
	function getPendingLogOut (){
		$sql = 'select transaksi_obat.ID_TRANSAKSI, jenis_transaksi_obat.NAMA_JENIS, 
				unit.NAMA_UNIT, gedung.NAMA_GEDUNG,
				transaksi_obat.NAMA_TRANSAKSI_SUMBER_LAIN,
				DATE_FORMAT(transaksi_obat.TANGGAL_TRANSAKSI,"%d %M %Y") as TANGGAL_TRANSAKSI,
				transaksi_obat.TANGGAL_REKAP_TRANSAKSI from transaksi_obat
				left join jenis_transaksi_obat on jenis_transaksi_obat.ID_JENISTRANSAKSI = transaksi_obat.ID_JENISTRANSAKSI
				left join unit on unit.ID_UNIT = transaksi_obat.TRANSAKSI_UNIT_KE
				left join gedung on gedung.ID_GEDUNG = unit.ID_GEDUNG
				where transaksi_obat.ID_JENISTRANSAKSI = 2 and transaksi_obat.FLAG_KONFIRMASI IS NULL';
		$query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
		else return null;
	}

}