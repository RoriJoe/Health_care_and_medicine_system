<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mDrugsTransaction extends CI_Model {

    function __construct () {
        parent::__construct();      
        $this->load->model('mDrugsDetailTrans');  
    }
    
    // HC Health Care
    function getRequestingHC () {
    	$sql = 'SELECT g.id_gedung, g.nama_gedung FROM transaksi_obat tob
				LEFT JOIN unit u ON tob.transaksi_unit_dari = u.id_unit
				left join gedung g on g.id_gedung = u.ID_GEDUNG
				where tob.id_jenistransaksi = 14 
				and tob.transaksi_unit_ke = '.$this->session->userdata['telah_masuk']['idunit'].' and tob.flag_transaksi = 0
				group by g.ID_GEDUNG;';
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }
    
    // ambil request puskesmas tertentu yg flag = 0
    function getHCRequest ($id) {
    	$sql = 'select transaksi_obat.ID_TRANSAKSI from transaksi_obat
				left join unit 
				on transaksi_obat.TRANSAKSI_UNIT_DARI = unit.ID_UNIT
				left join gedung
				on unit.ID_GEDUNG = gedung.ID_GEDUNG and gedung.ID_GEDUNG = '.$id.'
				where transaksi_obat.ID_JENISTRANSAKSI = 14 and transaksi_obat.FLAG_TRANSAKSI = 0
				and transaksi_obat.TRANSAKSI_UNIT_KE = '.$this->session->userdata['telah_masuk']['idunit'];
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }
    
    function getPendingRequest (){
    	$sql = 'select transaksi_obat.ID_TRANSAKSI, transaksi_obat.ID_JENISTRANSAKSI, transaksi_obat.TANGGAL_TRANSAKSI, unit.ID_UNIT, unit.NAMA_UNIT, gedung.NAMA_GEDUNG from
				transaksi_obat 
				left join unit
				on transaksi_obat.transaksi_unit_dari = unit.id_unit
    			left join gedung on unit.id_gedung = gedung.id_gedung
				where transaksi_obat.id_jenistransaksi in (14, 23) and transaksi_obat.transaksi_unit_ke = '.$this->session->userdata['telah_masuk']['idunit'].
				' and transaksi_obat.flag_konfirmasi = 0';
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0) {
    		return $query->result_array();
    	}
    	return null;
    }
    
    // masukkan entry baru
    function insertNewEntry ($data, $data_detail) {
    	// $this->db->trans_start();
        
		$this->db->insert('transaksi_obat', $data);
        $latest_id = $this->db->insert_id(); 
		
        if ($latest_id != -1) {
        	// insert into tabel detail
        	for ($i=0; $i<count($data_detail); $i++) {
        		$data_detail[$i]['id_transaksi'] = $latest_id;
        	}
        	return $this->mDrugsDetailTrans->insertManyEntry ($data_detail);
        }  
		return false;
		
        // $this->db->trans_complete();
        // if ($this->db->trans_status()) return true;
        // return false;
    }
	
	function insertNewEntryMinus ($data, $data_detail) {
		$this->db->insert('transaksi_obat', $data);
		
		if($this->db->affected_rows() > 0) {
			$latest_id = $this->db->insert_id(); 
			if ($latest_id != -1) {
				
				// insert into tabel detail
				for ($i=0; $i<count($data_detail); $i++) {
					$data_detail[$i]['ID_TRANSAKSI'] = $latest_id;
				}
	
				// minus gfk
				return $this->mDrugsDetailTrans->insertManyEntryMinus ($data_detail);
			}  
			else return false;
		}
		else return false;
    }
    
    // updata data transaksi
    function updateEntry ($id, $data) {
        $this->db->where('id_transaksi', $id);        
        if ($this->db->update('transaksi_obat', $data)) {
            return true;
        }
        else {
            return false;
        }
    }

    function getGfkStocks () {
        $this->db->order_by ('sisa', 'asc');
        $query = $this->db->get('view_masuk_keluar_gfk');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }
		
	function getUnitStocks ($id_unit) {
		$sql = 'select tob.transaksi_unit_ke, dto.id_obat, o.nama_obat, sum(dto.jumlah_obat) as pemasukan from transaksi_obat tob left join detil_transaksi_obat dto on tob.id_transaksi = dto.id_transaksi
		left join obat o on o.id_obat = dto.id_obat
		where tob.id_jenistransaksi = 4 and tob.transaksi_unit_ke = '.$id_unit.'
		group by dto.id_obat';
		
		$query = $this->db->query ($sql);
		if ($query->num_rows() >0) return $query->result_array();
		else return null;
	}
	
	function showTransByTransDate ($date) {
		$sql = 'select unit.ID_UNIT, unit.NAMA_UNIT, gedung.ID_GEDUNG, gedung.NAMA_GEDUNG
				from transaksi_obat
				left join unit
				on transaksi_obat.TRANSAKSI_UNIT_KE = unit.ID_UNIT
				left join gedung
				on unit.ID_GEDUNG = gedung.ID_GEDUNG
				where transaksi_obat.ID_JENISTRANSAKSI = 2
				and transaksi_obat.TANGGAL_TRANSAKSI = \''.$date.'\' and transaksi_obat.TRANSAKSI_UNIT_KE IS NOT NULL  
				group by transaksi_obat.TRANSAKSI_UNIT_KE';
		
		$query = $this->db->query ($sql);
		if ($query->num_rows() >0) return $query->result_array();
		else return null;
	}
	
	function findID ($new_id) {
		$this->db->where('noid_transaksi', $new_id);
		$query = $this->db->get ('transaksi_obat');
		if ($query->num_rows() > 0){
			return $query->result_array();
		} 
		else return null;
	}
	
	function removeEntry ($id) {
		$sql1 = 'set foreign_key_checks = 0';
		$sql2 = 'DELETE FROM transaksi_obat WHERE ID_TRANSAKSI = '.$id;
		$sql3 = 'set foreign_key_checks = 1';
	
		$this->db->query ($sql1);
		$this->db->query ($sql2);
		$this->db->query ($sql3);
	}
}