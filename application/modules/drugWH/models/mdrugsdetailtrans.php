<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mDrugsDetailTrans extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('mDrugsNow');
    }

    // insert
    function insertNewEntry($data) {
        if ($this->db->insert('detil_transaksi_obat', $data)) {
            return true;
        }
        return false;
    }

	function removeAllEntry ($data) {
		$this->db->delete ('detil_transaksi_obat', $data);		
	}
	
	function removeEntry ($id) {
		$sql1 = 'set foreign_key_checks = 0';
		$sql2 = 'DELETE FROM detil_transaksi_obat WHERE ID_TRANSAKSI = '.$id;
		$sql3 = 'set foreign_key_checks = 1';
	
		$this->db->query ($sql1);
		$this->db->query ($sql2);
		$this->db->query ($sql3);
	}
	
	function updateEntry ($condition, $data) {
		$this->db->where ($condition);
		$this->db->update ('detil_transaksi_obat', $data);		
	}
	
    public function convert($date) {
//        $mydate = date_create_from_format('d-m-Y', $date);
//        return date_format($mydate, 'Y-m-d');
        return date("Y-m-d", strtotime($date));
    }

    function insertManyEntry($data) {
        foreach ($data as $item) {
            // unset($item['nama_obat']);
            // //unset($item['id_jenistransaksi']);
            // //$this->db->insert('detil_transaksi_obat', $item);
            // // $stock_now = array (
            // // 'id_unit' => $this->session->userdata['telah_masuk']['idunit'],
            // // 'id_obat' => $item['id_obat'],
            // // 'jumlah_obat_sekarang' => $item['jumlah_obat']
            // // );
            // // $this->mDrugsNow->updateEntry($stock_now);
            // // if ($this->session->userdata('idunittujuan') != null) {
            // // $stock_now['id_unit'] = $this->session->userdata('idunittujuan');
            // // $this->mDrugsNow->updateEntry($stock_now);
            // // }
            $convertedDate = $this->convert($item['expired_date']);
            $id_transaksi = $item['id_transaksi'];
            $id_obat = $item['id_obat'];
            $jumlah_obat = $item['jumlah_obat'];
            $expired_date = $convertedDate;
            $id_unit = $item['id_unit'];
            $nomor_batch = $item['nomor_batch'];
            $sumber_anggaran = $item['id_sumber_anggaran_obat'];
			$harga_satuan = $item['harga_satuan'];
			$harga_total = $item['harga_total'];
			$penyedia_obat = $item['penyedia_obat'];
			
            $sql = "call insert_detil_transaksi_obat_plus_new ('$id_transaksi','$id_obat','$jumlah_obat','$expired_date', '$id_unit','$nomor_batch', '$sumber_anggaran', '$harga_satuan', '$harga_total', '$penyedia_obat')";
            $result = $this->db->query($sql);
			$result->next_result();
        }
        return true;
    }

    function insertManyEntryMinus($data) {
        $this->db->trans_start();
		foreach ($data as $item) {            
            $id_transaksi = $item['ID_TRANSAKSI'];
            $id_obat = $item['ID_OBAT'];
            $jumlah_obat = $item['STOK_OBAT_SEKARANG'];
            $expired_date = $item['EXPIRED_DATE'];
            $id_unit = $item['ID_UNIT'];
            $nomor_batch = $item['NOMOR_BATCH'];
            $sumber_anggaran = $item['ID_SUMBER_ANGGARAN_OBAT'];

			$sql = "call insert_detil_transaksi_obat_minus ('$id_transaksi','$id_obat','$jumlah_obat','$expired_date', '$id_unit','$nomor_batch', '$sumber_anggaran')";
			$result = $this->db->query($sql);
			$result->next_result();
        }
		$this->db->trans_complete();
		if ($this->db->trans_status() === false) { 
			$this->db->trans_rollback();			
			return false;
		}
		else {
			$this->db->trans_commit();
			return true;
		}
    }

    // get detail by id transaksi
    function getEntryById($id) {
        // $sql = 'select detil_transaksi_obat.id_transaksi, detil_transaksi_obat.id_sumber_anggaran_obat, detil_transaksi_obat.nomor_batch, detil_transaksi_obat.id_obat, obat.nama_obat, detil_transaksi_obat.jumlah_obat, detil_transaksi_obat.expired_date
		// from detil_transaksi_obat
		// left join obat
		// on detil_transaksi_obat.id_obat = obat.id_obat
		// where detil_transaksi_obat.id_transaksi = ' . $id;
		$idunitini = $this->session->userdata['telah_masuk']['idunit'];
		
		// $sql = 'SELECT trans.*, terkini.KODE_OBAT, terkini.SATUAN, terkini.STOK_OBAT_SEKARANG, terkini.TOTAL FROM
		// (SELECT detil_transaksi_obat.ID_TRANSAKSI, detil_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT, detil_transaksi_obat.NOMOR_BATCH, detil_transaksi_obat.ID_OBAT, obat.NAMA_OBAT, detil_transaksi_obat.JUMLAH_OBAT, detil_transaksi_obat.EXPIRED_DATE
		// FROM detil_transaksi_obat
		// LEFT JOIN obat
		// ON detil_transaksi_obat.id_obat = obat.id_obat
		// WHERE detil_transaksi_obat.id_transaksi = ' . $id . ') AS trans
		// LEFT JOIN 
		// (
		// SELECT temp.*, SUM(temp.STOK_OBAT_SEKARANG) as TOTAL FROM
		// (SELECT * FROM
		// (SELECT * FROM view_stok_obat_unit_terkini 
		// WHERE view_stok_obat_unit_terkini.ID_UNIT = ' . $idunitini . ') AS h
		// GROUP BY h.NOMOR_BATCH) AS temp GROUP BY temp.ID_OBAT) AS terkini
		// ON trans.ID_OBAT = terkini.ID_OBAT';
		
		$sql = 'SELECT trans.*, ifnull(terkini.KODE_OBAT, "") as KODE_OBAT, ifnull(terkini.SATUAN, "") as SATUAN, terkini.TOTAL FROM
		(SELECT detil_transaksi_obat.ID_TRANSAKSI, 
		detil_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT, 
		detil_transaksi_obat.NOMOR_BATCH, 
		detil_transaksi_obat.ID_OBAT, 
		obat.NAMA_OBAT, SUM(detil_transaksi_obat.JUMLAH_OBAT) AS JUMLAH_OBAT, 
		detil_transaksi_obat.EXPIRED_DATE
		FROM detil_transaksi_obat
		LEFT JOIN obat
		ON detil_transaksi_obat.id_obat = obat.id_obat
		WHERE detil_transaksi_obat.id_transaksi = ' . $id . '
		GROUP BY detil_transaksi_obat.id_obat) AS trans
		LEFT JOIN 
		(
		SELECT temp.*, SUM(temp.STOK_OBAT_SEKARANG) AS TOTAL FROM
		(SELECT * FROM
		(SELECT * FROM view_stok_obat_unit_terkini 
		WHERE view_stok_obat_unit_terkini.ID_UNIT = ' . $idunitini . ' AND view_stok_obat_unit_terkini.EXPIRED_DATE > NOW() 
		) AS h
		GROUP BY h.NOMOR_BATCH) AS temp GROUP BY temp.ID_OBAT) AS terkini
		ON trans.ID_OBAT = terkini.ID_OBAT ORDER BY terkini.NAMA_OBAT';
		
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }
	
function getEntryByIdPerBatch($id) {
        // $sql = 'select detil_transaksi_obat.id_transaksi, detil_transaksi_obat.id_sumber_anggaran_obat, detil_transaksi_obat.nomor_batch, detil_transaksi_obat.id_obat, obat.nama_obat, detil_transaksi_obat.jumlah_obat, detil_transaksi_obat.expired_date
		// from detil_transaksi_obat
		// left join obat
		// on detil_transaksi_obat.id_obat = obat.id_obat
		// where detil_transaksi_obat.id_transaksi = ' . $id;
		$idunitini = $this->session->userdata['telah_masuk']['idunit'];
		
		$sql = 'SELECT trans.*, ifnull(terkini.KODE_OBAT, "") as KODE_OBAT, ifnull(terkini.SATUAN, "") as SATUAN, terkini.STOK_OBAT_SEKARANG FROM
		(SELECT detil_transaksi_obat.ID_TRANSAKSI, detil_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT, detil_transaksi_obat.NOMOR_BATCH, detil_transaksi_obat.ID_OBAT, obat.NAMA_OBAT, detil_transaksi_obat.JUMLAH_OBAT, detil_transaksi_obat.EXPIRED_DATE
		FROM detil_transaksi_obat
		LEFT JOIN obat
		ON detil_transaksi_obat.id_obat = obat.id_obat
		WHERE detil_transaksi_obat.id_transaksi = ' . $id . ') AS trans
		LEFT JOIN 
		(SELECT * FROM
		(SELECT * FROM view_stok_obat_unit_terkini 
		WHERE view_stok_obat_unit_terkini.ID_UNIT = ' . $idunitini . '
		) AS h
		GROUP BY h.NOMOR_BATCH) AS terkini
		ON (trans.id_obat = terkini.id_obat AND trans.nomor_batch = terkini.nomor_batch) ORDER BY trans.id_transaksi';
		
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    function getUndoneTransaction($id) {
        $this->db->where('id_transaksi', $id);
        $query = $this->db->get('view_daftarobat_puskesmas_minta');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    function hihi($id, $data) {
        $this->db->where('id_obat', $id);
        $this->db->update('detil_transaksi_obat', $data);
        return true;
    }

	function showTotalDetTransByTransDate ($date1, $date2) {
		$sql = 'select obat.KODE_OBAT, obat.NAMA_OBAT, obat.SATUAN, trans.TOTAL from
				(select detil_transaksi_obat.* , SUM(JUMLAH_OBAT) as TOTAL from detil_transaksi_obat
				where detil_transaksi_obat.ID_TRANSAKSI in
				(select transaksi_obat.ID_TRANSAKSI from transaksi_obat
				where transaksi_obat.ID_JENISTRANSAKSI = 2 and transaksi_obat.TRANSAKSI_UNIT_KE IS NOT NULL and 
				(transaksi_obat.TANGGAL_TRANSAKSI = \''.$date1.'\' or 
				transaksi_obat.TANGGAL_TRANSAKSI = \''.$date2.'\'))
				group by detil_transaksi_obat.ID_OBAT) trans
				left join obat
				on trans.ID_OBAT = obat.ID_OBAT';		
		$query = $this->db->query ($sql);
		if ($query->num_rows>0) return $query->result_array();
		else return null;
	}

	function showDetTransByPus ($unit, $date) {
		$sql = 'select obat.KODE_OBAT, obat.NAMA_OBAT, obat.SATUAN, trans.TOTAL from
				(select detil_transaksi_obat.* , SUM(JUMLAH_OBAT) as TOTAL from detil_transaksi_obat
				where detil_transaksi_obat.ID_TRANSAKSI in
				(select transaksi_obat.ID_TRANSAKSI from transaksi_obat
				where transaksi_obat.ID_JENISTRANSAKSI = 2 and transaksi_obat.TRANSAKSI_UNIT_KE = '.$unit.' and transaksi_obat.TANGGAL_TRANSAKSI = \''.$date.'\')
				group by detil_transaksi_obat.ID_OBAT) trans
				left join obat
				on trans.ID_OBAT = obat.ID_OBAT';		
		$query = $this->db->query ($sql);
		if ($query->num_rows>0) return $query->result_array();
		else return null;
	}
	
	function showDetailTransById ($id) {
		$sql = 'SELECT detil_transaksi_obat.*, DATE_FORMAT(detil_transaksi_obat.EXPIRED_DATE, "%d %M %Y") as TANGGAL_KADALUARSA, sumber_anggaran_obat.NAMA_SUMBER_ANGGARAN_OBAT, 
			obat.NAMA_OBAT, obat.SATUAN, obat.KODE_OBAT FROM detil_transaksi_obat
			LEFT JOIN sumber_anggaran_obat
			ON detil_transaksi_obat.ID_SUMBER_ANGGARAN_OBAT = sumber_anggaran_obat.ID_SUMBER_ANGGARAN_OBAT
			LEFT JOIN obat
			ON obat.ID_OBAT = detil_transaksi_obat.ID_OBAT
			WHERE detil_transaksi_obat.ID_TRANSAKSI = '.$id.' ORDER BY obat.NAMA_OBAT';
			//ORDER BY detil_transaksi_obat.ID_DETIL_TO DESC
		$query = $this->db->query ($sql);
		if ($query->num_rows>0) return $query->result_array();
		else return null;
	}
}
