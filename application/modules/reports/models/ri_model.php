<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Ri_model extends CI_Model {
	
	private $table;
	
	function __construct () {
		parent::__construct ();
		$this->table = 'view_drug_used';
	}
	
	function getRiBed ($idPuskesmas='',$month='', $year='') {
		$sql = 'CALL bed_bycategory('.$idPuskesmas.')';
		$query = $this->db->query($sql);
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getRiVisitTime ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL rinap_byvisitstatus('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getRiVisitCategory ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL rinap_byvisitcategory('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getDBA($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL rinap_diarrheabyage('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getRiLakaLantas ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL rinap_lakalantas('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getC ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL rinap_bycategory('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	
	function getRIH ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL rinap_hour('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getDT ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL rinap_diedtime('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getBP ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL rinap_babypneumonia('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getPONED ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL rinap_poned('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getVKKIA ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL rinap_vkkia('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getLL ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL rinap_lakalantas('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getkeluar ($idPuskesmas='',$month='', $year='') {
		$query = $this->db->query('CALL rinap_keluar('.$idPuskesmas.','.$month.','.$year.')');
		$hasil = $query->result_array();
		$this->db->close();
		//print_r ($hasil);
		if ($query->num_rows> 0) return $hasil; 
		return null;
	}
	
	function getAllLplpoPuskesmas ($idPuskesmas='',$from='', $till='') {
		
		$sql = 'SELECT 
			main.NAMA_OBAT AS `NAMA_OBAT`,
			main.ID_OBAT AS `ID_OBAT`,
			main.KODE_OBAT AS `KODE_OBAT`,
			main.ID_UNIT AS `ID_UNIT`,
			main.SATUAN AS `SATUAN`,
			sa.STOK_AWAL AS `STOK_AWAL`,
			pen.PENERIMAAN AS `PENERIMAAN`,
			(sa.STOK_AWAL+pen.PENERIMAAN) AS `PERSEDIAAN`,
			IFNULL(pem.PEMAKAIAN,0) AS `PEMAKAIAN`,
			(IFNULL(sa.STOK_AWAL,0)+IFNULL(pen.PENERIMAAN,0)-IFNULL(pem.PEMAKAIAN,0)) AS `SISA_STOK`,
			IFNULL(sopt.STOK_OPT,0) AS `STOK_OPT`,
			IFNULL(perm.PERMINTAAN,0) AS `PERMINTAAN`,
			IFNULL(dau.DAU,0) AS `DAU`,
			IFNULL(askes.askes,0) AS `ASKES`,
			IFNULL(prog.PROG,0) AS `PROG`,
			IFNULL(lain.LAIN ,0)AS `LAIN`,
			(IFNULL(dau.DAU,0)+IFNULL(askes.askes,0)+IFNULL(prog.PROG,0)+IFNULL(lain.LAIN ,0)) AS `TOTAL`
			 FROM
			(
			SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
			o.ID_OBAT AS `ID_OBAT`,
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
			GROUP BY o.ID_OBAT, u.ID_GEDUNG
			) main
			LEFT JOIN
			(
			SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
			o.ID_OBAT AS `ID_OBAT`,
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
			WHERE  u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND (t.ID_JENISTRANSAKSI = 1 OR t.ID_JENISTRANSAKSI = 15 OR t.ID_JENISTRANSAKSI = 18 OR t.ID_JENISTRANSAKSI = 19 OR t.ID_JENISTRANSAKSI = 20 OR t.ID_JENISTRANSAKSI = 21)
			GROUP BY o.ID_OBAT, u.ID_GEDUNG
			) pen
			ON main.ID_OBAT = pen.ID_OBAT AND main.ID_UNIT = pen.ID_UNIT AND main.ID_GEDUNG = pen.ID_GEDUNG
			LEFT JOIN 
			(
			SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
			o.ID_OBAT AS `ID_OBAT`,
			dto.ID_UNIT AS `ID_UNIT`,
			dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
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
			WHERE  u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND  t.ID_JENISTRANSAKSI = 10
			GROUP BY o.ID_OBAT, u.ID_GEDUNG
			) pem
			ON main.ID_OBAT = pem.ID_OBAT AND main.ID_UNIT = pem.ID_UNIT AND main.ID_GEDUNG = pem.ID_GEDUNG
			LEFT JOIN
			(
			SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
			o.ID_OBAT AS `ID_OBAT`,
			dto.ID_UNIT AS `ID_UNIT`,
			dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
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
			WHERE  u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND t.ID_JENISTRANSAKSI = 6
			GROUP BY o.ID_OBAT, u.ID_GEDUNG
			) dau
			ON main.ID_OBAT = dau.ID_OBAT AND main.ID_UNIT = dau.ID_UNIT AND main.ID_GEDUNG = dau.ID_GEDUNG
			LEFT JOIN
			(
			SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
			o.ID_OBAT AS `ID_OBAT`,
			dto.ID_UNIT AS `ID_UNIT`,
			dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
			o.SATUAN AS `SATUAN`,
			o.KODE_OBAT AS `KODE_OBAT`,
			u.ID_GEDUNG AS `ID_GEDUNG`,
			SUM(dto.JUMLAH_OBAT) AS `ASKES`
			FROM detil_transaksi_obat dto
			LEFT JOIN transaksi_obat t
			ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
			LEFT JOIN obat o
			ON o.ID_OBAT = dto.ID_OBAT
			LEFT JOIN unit u
			ON u.ID_UNIT = dto.ID_UNIT
			WHERE  u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND t.ID_JENISTRANSAKSI = 7
			GROUP BY o.ID_OBAT, u.ID_GEDUNG
			) askes
			ON main.ID_OBAT = askes.ID_OBAT AND main.ID_UNIT = askes.ID_UNIT AND main.ID_GEDUNG = askes.ID_GEDUNG
			LEFT JOIN
			(
			SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
			o.ID_OBAT AS `ID_OBAT`,
			dto.ID_UNIT AS `ID_UNIT`,
			dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
			o.SATUAN AS `SATUAN`,
			o.KODE_OBAT AS `KODE_OBAT`,
			u.ID_GEDUNG AS `ID_GEDUNG`,
			SUM(dto.JUMLAH_OBAT) AS `PROG`
			FROM detil_transaksi_obat dto
			LEFT JOIN transaksi_obat t
			ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
			LEFT JOIN obat o
			ON o.ID_OBAT = dto.ID_OBAT
			LEFT JOIN unit u
			ON u.ID_UNIT = dto.ID_UNIT
			WHERE  u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND t.ID_JENISTRANSAKSI = 8
			GROUP BY o.ID_OBAT, u.ID_GEDUNG
			) prog
			ON main.ID_OBAT = prog.ID_OBAT AND main.ID_UNIT = prog.ID_UNIT AND main.ID_GEDUNG = prog.ID_GEDUNG
			LEFT JOIN
			(
			SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
			o.ID_OBAT AS `ID_OBAT`,
			dto.ID_UNIT AS `ID_UNIT`,
			dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
			o.SATUAN AS `SATUAN`,
			o.KODE_OBAT AS `KODE_OBAT`,
			u.ID_GEDUNG AS `ID_GEDUNG`,
			SUM(dto.JUMLAH_OBAT) AS `LAIN`
			FROM detil_transaksi_obat dto
			LEFT JOIN transaksi_obat t
			ON dto.ID_TRANSAKSI = t.ID_TRANSAKSI
			LEFT JOIN obat o
			ON o.ID_OBAT = dto.ID_OBAT
			LEFT JOIN unit u
			ON u.ID_UNIT = dto.ID_UNIT
			WHERE  u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND t.ID_JENISTRANSAKSI = 9
			GROUP BY o.ID_OBAT, u.ID_GEDUNG
			) lain
			ON main.ID_OBAT =lain.ID_OBAT AND main.ID_UNIT = lain.ID_UNIT AND main.ID_GEDUNG = lain.ID_GEDUNG
			LEFT JOIN
			(
			SELECT * FROM
			(
			SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
			o.ID_OBAT AS `ID_OBAT`,
			dto.ID_UNIT AS `ID_UNIT`,
			dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
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
			GROUP BY ID_OBAT, ID_GEDUNG
			) sa
			ON main.ID_OBAT =sa.ID_OBAT AND main.ID_UNIT = sa.ID_UNIT AND main.ID_GEDUNG = sa.ID_GEDUNG
			LEFT JOIN
			(
			SELECT * FROM
			(
			SELECT *
			FROM
			(SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
			o.ID_OBAT AS `ID_OBAT`,
			dto.ID_UNIT AS `ID_UNIT`,
			dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
			o.SATUAN AS `SATUAN`,
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
			ORDER BY T.ID_TRANSAKSI DESC
			) A
			GROUP BY TANGGAL_TRANSAKSI, ID_OBAT, ID_GEDUNG
			) main
			GROUP BY ID_OBAT, ID_GEDUNG
			) sopt
			ON main.ID_OBAT =sopt.ID_OBAT AND main.ID_UNIT = sopt.ID_UNIT AND main.ID_GEDUNG = sopt.ID_GEDUNG
			LEFT JOIN 
			(
			SELECT o.NAMA_OBAT AS `NAMA_OBAT`,
			o.ID_OBAT AS `ID_OBAT`,
			dto.ID_UNIT AS `ID_UNIT`,
			dto.JUMLAH_OBAT AS `JUMLAH_OBAT`,
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
			WHERE u.ID_GEDUNG = '.$idPuskesmas.' AND t.TANGGAL_TRANSAKSI BETWEEN "'.$from.'" AND "'.$till.'" AND t.ID_JENISTRANSAKSI = 11 OR t.ID_JENISTRANSAKSI = 12 OR t.ID_JENISTRANSAKSI = 13
			GROUP BY o.ID_OBAT, u.ID_GEDUNG
			) perm
			ON main.ID_OBAT = perm.ID_OBAT AND main.ID_UNIT = perm.ID_UNIT AND main.ID_GEDUNG = perm.ID_GEDUNG';
		$query = $this->db->query ($sql);
		if ($query->num_rows> 0) return $query->result_array(); 
		return null;
	}
}