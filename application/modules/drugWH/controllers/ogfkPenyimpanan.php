<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class OgfkPenyimpanan extends ogfkPenyimpananController {

    function __construct() {
        parent::__construct();
        $this->load->model('mDrugs');
        $this->load->model('mUnit');
        $this->load->model('mSource');
        $this->load->model('mDrugsTransaction');
		$this->load->model('mDrugsDetailTrans');		
		$this->load->model('mGedung');	
		$this->load->model('mDrugsNow');
		$this->load->model('mLog');	
    }

    function index() {
		redirect (base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/stocksGFK');
    }

	private function _setFlashData ($status) {
    	$key = 'error';
    	if ($status == true)
    		$message = 'success';
    	else $message = 'failed';
    
    	$this->session->set_flashdata ($key, $message);
    }
	
	private function clean($string) {
        return preg_replace('/[^A-Za-z0-9\-@ .,]/', '-', $string); // Removes special chars.
    }
	
    //on page 'Monitoring stok GFK'
    public function stocksGFK() {		
        $data['allStocks'] = $this->mDrugs->getGFKRemain();
        $data['error_msg'] = $this->session->flashdata('error');
		$this->session->set_userdata('drugs_throwed_detail', null);
        $this->display('monitoring_gfk', $data);
    }
	
	public function showAllDetailObat () {
		$id_obat = $this->input->post('id_obat');
		$temp1 = $this->mDrugs->getAllDetailEntry($id_obat);
		if ($temp1) echo json_encode($temp1);
	}
	
	public function updateDrugsGFK (){
		$form_data = $this->input->post(null, true);
		
		$data = array (
			'nama_obat' => $form_data['selectedNamaObat'],
			'satuan' => $form_data['selectedSatuanObat'],
			'jml_obat_min' => $form_data['selectedJmlObatMin']
		);
		
		$this->_setFlashData($this->mDrugs->updateEntry($form_data['selectedIdObat'], $data));
		redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/stocksGFK');
	} 
	
	// deprecated
	public function deleteDrugsGFK (){
		$form_data = $this->input->post(null, true);
		$id = $form_data['selected'];
		$res = $this->mDrugs->deleteById($id);
		$this->_setFlashData($this->mDrugs->deleteById ($id));
		redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/stocksGFK');
	}
	
	public function addDrugsGFK (){
		$form_data = $this->input->post(null, true);
		
		$data = array (
				'kode_obat' => $form_data['inputKode'],
				'nama_obat' => $form_data['inputNama'],
				'satuan' => $form_data['inputSatuan']
		);
		$this->_setFlashData ($this->mDrugs->insertNewEntry($data));
		redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/stocksGFK');
	}
	
	public function showAllDrugsGFK () {
		$temp1 = $this->mDrugs->getAllEntry();
		if($temp1) echo $this->getPivot($temp1);
	}
	
	public function showAllDrugsGFKUnused () {
		$temp1 = $this->mDrugs->getAllEntryUnused();
		if($temp1) echo $this->getPivot($temp1);
	}
	
	private function renameHeader ($headerName) {
		$headerName = str_replace("_", " ", strtoupper($headerName));
		switch ($headerName) {
			case "STOK OBAT SEKARANG":
				$headerName = "STOK SAAT INI";
			break;
			
			case "EXPIRED DATE":
				$headerName = "TANGGAL KADALUARSA";
			break;
			
			case "NAMA SUMBER ANGGARAN OBAT":
				$headerName = "SUMBER ANGGARAN";
			break;

			case "KODE OBAT":
                $headerName = "NOMOR LPLPO";
                break;
				
			default:
				break;
		}
		return $headerName;
	}
	
	private function getPivot($data) {
		$header = "[[";

        // get key nama kolom
        // hapus underscore _ dan JADI GEDE
        foreach ($data as $value) {
            $header .= '"NOMOR"';
            foreach ($value as $key => $sembarang) {				
                $header .= ',"' . $this->renameHeader($key) . '"';
            }
			$header .= ",\"UBAH\"";
			// $header .= ",\"HAPUS\"";
			$header .= ",\"BUANG\"";
			$header .= ",\"DETAIL\"";
            $header .= "]";
            break;
        }

		// get value
		$counter = 1;
        foreach ($data as $value) {
            $header .= ",[";
			$header .= '"' . $counter . '"';
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                $header .= ',"'. $data . '"';
            }
			$header .= ',"<a style=\"color: white\" type=\"button\" data-toggle=\"modal\" href=\"#editModal\" class=\"btn btn-xs btn-info\" onclick=\"drugsEditGFK(\''.$value['KODE_OBAT'].'\',\''.$this->replaceString($value['NAMA_OBAT']).'\',\''.$value['SATUAN'].'\',\''.$value['JML_OBAT_MIN'].'\')\"><i class=\"fa fa-edit\"></i></a>"';
			// $header .= ',"<a style=\"color: white\" type=\"button\" data-toggle=\"modal\" href=\"#deleteConfirmModal\" class=\"btn btn-xs btn-warning\"  onclick=\"drugsRemoveGFK(\''.$value['ID_OBAT'].'\',\''.$value['NAMA_OBAT'].'\',\''.$value['NOMOR_BATCH'].'\')\"><i class=\"fa fa-cut\"></i></a>"';
			$header .= ',"<a style=\"color: white\" type=\"button\" class=\"btn btn-xs btn-danger\"  onclick=\"drugsThrowGFK(\''.$value['ID_OBAT'].'\',\''.$this->replaceString($value['NAMA_OBAT']).'\',\''.$value['NOMOR_BATCH'].'\')\"><i class=\"fa fa-ban\"></i></a>"';
			
			$header .= ',"<a style=\"color: white\" type=\"button\" data-toggle=\"modal\" href=\"#detailObatModal\" class=\"btn btn-xs btn-warning\"  onclick=\"drugsDetailGFK(\''.$value['ID_OBAT'].'\')\"><i class=\"fa fa-search\"></i></a>"';
            $header .= "]";
			$counter++;
        }
        $header .= "]";
        return $header;
    }
	
	function addDrugsThrowed () {
		$form_data = $this->input->post(null, true);
		$id_unit = $this->session->userdata['telah_masuk']['idunit'];
		
		$data_obat = array ();
        foreach ($form_data as $key => $value) {
			if (strpos($key, "obat") !== false) {
				$temps = explode("_", $value);
				$id_obat = $temps[0];
				$nomor_batch = $temps[1];
				
				$dataObat = $this->mDrugsNow->getEntryByUnitIdBatch($id_unit, $id_obat, $nomor_batch);
				
				$data_detail = array(
					'ID_OBAT' => $dataObat['ID_OBAT'],
					'NAMA_OBAT' => $dataObat['NAMA_OBAT'],
					'STOK_OBAT_SEKARANG' => $dataObat['STOK_OBAT_SEKARANG'],
					'EXPIRED_DATE' => $dataObat['EXPIRED_DATE'],
					'NOMOR_BATCH' => $dataObat['NOMOR_BATCH'],
					'ID_SUMBER_ANGGARAN_OBAT' => $dataObat['ID_SUMBER_ANGGARAN_OBAT'],
					'ID_UNIT' => $id_unit
				);
				$data_obat[] = $data_detail;				
			}
		}		
		
        $dateConverted = $this->convert($form_data['inputTransaksi']);

        $data = array(
            'id_penugasan' => $this->session->userdata['telah_masuk']['idpenugasan'],
            'id_jenistransaksi' => '26',
            'tanggal_transaksi' => $dateConverted,
            'tanggal_rekap_transaksi' => date('Y-m-d'),
            'transaksi_unit_dari' => $this->session->userdata['telah_masuk']['idunit'],
            'transaksi_unit_ke' => $this->session->userdata['telah_masuk']['idunit'],
			'keterangan_transaksi_obat' => $form_data['inputAlasan']
        );

        $result = $this->mDrugsTransaction->insertNewEntryMinus($data, $data_obat);
        $this->_setFlashData($result);
        redirect (base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/stocksGFK');
	}
	// end of page 'Monitoring stok GFK'
	
	
	
    // on page 'Monitoring Stok Puskesmas'
    public function stocksHC() {        
        //redirect('drugWH/monitoring_hc');
		$data['allStocks'] = $this->mDrugs->getGFKRemain();	
		$data['allGedung'] = $this->mGedung->getAllPuskesmas ();
		$this->display('monitoring_hc', $data);
    }
	
	public function showUnitsHC () {
		$id = $this->input->post('id');
		$result = $this->mUnit->getUnitsByHC ($id);		
		if ($result) {
            echo json_encode($result);
        }
	}
	
	public function showUnitStocksHC () {
		$id = $this->input->post('id');
		$result = $this->mDrugsNow->getEntryByUnit ($id);
		if ($result) {
            echo json_encode($result);
        }
	}
	
	public function showStocksHC () {
		$id = $this->input->post('id');
		$result = $this->mDrugsNow->getEntryByHC ($id);
		if ($result) {
            echo json_encode($result);
		}
	}
	// end of page 'Monitoring Stok Puskesmas'
	
	
	
	

    // on page 'Obat Masuk'
    function drugsIn() {
        $data['error_msg'] = $this->session->flashdata('error');
        $this->session->set_userdata('drugsIn_added_detail', null);

        $data['allStocks'] = $this->mDrugs->getGFKRemain();
        $data['allSource'] = $this->mSource->getAllEntry();

        $this->display('drugs_in', $data);
    }
	
	function showAllDrugs() {
        $data = $this->mDrugs->getAllDrugsName();
		if ($data) echo $this->getPivotOM($data);
    }

    public function convert($date) {
        $mydate = date_create_from_format('d-m-Y', $date);
        return date_format($mydate, 'Y-m-d');
    }

    private function replaceString($input) {
        $output = str_replace("\"", "\\\"", $input);
        $output = str_replace("\'", "\\\'", $output);
        return $output;
    }

	// get pivot obat masuk
    private function getPivotOM ($data) {
		$header = "[[";

        // get key nama kolom
        // hapus underscore _ dan JADI GEDE
        foreach ($data as $value) {
            $header .= '"NOMOR"';
            foreach ($value as $key => $sembarang) {				
                $header .= ',"' . $this->renameHeader($key) . '"';
            }
			$header .= ",\"PILIH\"";
            $header .= "]";
            break;
        }

		// get value
		$counter = 1;
        foreach ($data as $value) {
            $header .= ",[";
			$header .= '"' . $counter . '"';
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                $header .= ',"'. $data . '"';
            }
			$header .= ',"<a style=\"color: white\" type=\"button\" data-toggle=\"modal\" href=\"#addStocksModal\" onclick=\"toAddStocksModal(\'' . $value['ID_OBAT'] . '\', \'' . $this->replaceString($value['NAMA_OBAT']) . '\',\'\',\'\',\'\', \'\' )\" class=\"btn btn-xs btn-success\"><i class=\"fa fa-plus\"></i></a>"';
            $header .= "]";
			$counter++;
        }
        $header .= "]";
        return $header;
    }

    // Get all drugs in table 'OBAT'
    function showDrugsIn($status) {
        if ($status == null)
            redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/drugsIn');
        $data['error_msg'] = $this->session->flashdata('error');
        $this->session->set_userdata('drugsIn_added_detail', null);

        $data['allStocks'] = $this->mDrugs->getGFKRemain();
        $data['allSource'] = $this->mSource->getAllEntry();

        return $data;
    }
	
    // drug checkout
    public function addDrugsIn() {
        $form_data = $this->input->post(null, true);
	
		$data_obat = array ();
        foreach ($form_data as $key => $value) {
			if (strpos($key, "obat") !== false) {
				$temps = explode("_", $value);
				$data_detail = array(
					'id_obat' => $temps[0],
					'nomor_batch' => $temps[1],					
					'expired_date' => $temps[2],					
					'jumlah_obat' => $temps[3],
					'harga_satuan' => $temps[4],
					'harga_total' => (string)((int)$temps[3] * (int)$temps[4]),
					'penyedia_obat' => $temps[5],
					'id_sumber_anggaran_obat' => $temps[6],
					'id_unit' => $this->session->userdata['telah_masuk']['idunit']
				);	
				$data_obat[] = $data_detail;
			}
		}
		
		$dateConverted = $this->convert($form_data['inputTransaksi']);

        $data = array(
            'id_penugasan' => $this->session->userdata['telah_masuk']['idpenugasan'],
            'id_jenistransaksi' => '1',
            'tanggal_transaksi' => $dateConverted,
            'tanggal_rekap_transaksi' => date('Y-m-d'),
            'transaksi_unit_dari' => $this->session->userdata['telah_masuk']['idunit'],
            'transaksi_unit_ke' => $this->session->userdata['telah_masuk']['idunit'],
			'noid_transaksi' => $form_data['inputNoIDTransaksi']
        );		

        $result = $this->mDrugsTransaction->insertNewEntry($data, $data_obat);
        $this->_setFlashData($result);
        redirect (base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/drugsIn');
    }
	// end of page 'Obat Masuk'

    function logIn() {
		// $data['log'] = $this->mLog->getLogIn ();
		$data['allStocks'] = $this->mDrugs->getGFKRemain ();
		$this->display('log_in', $data);
    }
	
	function getLogIn () {
		$data = $this->mLog->getLogIn ();
		if ($data) echo $this->getPivotLogIn($data);
	}
	
	private function getPivotLogIn ($data) {
        $header = "[[";

        // get key nama kolom
        // hapus underscore _ dan JADI GEDE
        foreach ($data as $value) {
            $header .= '"NOMOR"';
            foreach ($value as $key => $sembarang) {				
                $header .= ',"' . $this->renameHeader($key) . '"';
            }
			$header .= ",\"DETAIL\"";
            $header .= "]";
            break;
        }

		// get value
		$counter = 1;
        foreach ($data as $value) {
            $header .= ",[";
			$header .= '"' . $counter . '"';
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                $header .= ',"'. $data . '"';
            }
			$header .= ',"<a style=\"color: white\" type=\"button\" data-toggle=\"modal\" href=\"#detailObatModal\" class=\"btn btn-xs btn-success\" onclick=\"detail(\''.$value['ID_TRANSAKSI'].'\')\"><i class=\"fa fa-search\"></i></a>"';
            $header .= "]";
			$counter++;
        }
        $header .= "]";
        return $header;
    }
	
	function showDetailLogIn () {
		$id = $this->input->post('id');
		$data = $this->mDrugsDetailTrans->showDetailTransById($id);
		if ($data) echo json_encode($data);
	}

    function logOut() {
        $data['log'] = $this->mLog->getLogOut ();
		$data['allStocks'] = $this->mDrugs->getGFKRemain ();
		$this->display('log_out', $data);
    }
	
	function getLogOut () {
		$data = $this->mLog->getLogOut ();
		if ($data) echo $this->getPivotLogOut($data);
	}
	
	private function getPivotLogOut ($data) {
        $header = "[[";

        // get key nama kolom
        // hapus underscore _ dan JADI GEDE
        foreach ($data as $value) {
            $header .= '"NOMOR"';
            foreach ($value as $key => $sembarang) {				
                $header .= ',"' . $this->renameHeader($key) . '"';
            }
			$header .= ",\"DETAIL\"";
            $header .= "]";
            break;
        }

        // get value
		$counter = 1;
        foreach ($data as $value) {
            $header .= ",[";
			$header .= '"' . $counter . '"';
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                $header .= ',"'. $data . '"';
            }
			$header .= ',"<a style=\"color: white\" type=\"button\" data-toggle=\"modal\" href=\"#detailObatModal\" class=\"btn btn-xs btn-success\" onclick=\"detail(\''.$value['ID_TRANSAKSI'].'\')\"><i class=\"fa fa-search\"></i></a>"';
            $header .= "]";
			$counter++;
        }
        $header .= "]";
        return $header;
    }
	
	function showDetailLogOut () {
		$id = $this->input->post('id');
		$data = $this->mDrugsDetailTrans->showDetailTransById($id);
		if ($data) echo json_encode($data);
	}
	
	
	function logUnused() {
		// $data['log'] = $this->mLog->getLogOut ();
		$data['allStocks'] = $this->mDrugs->getGFKRemain ();
		$this->display('log_unused', $data);
	}

	function nikChecker() {
		$nik = $this->input->post('nik');
		$checker = $this->mDrugsTransaction->findID ($nik);
		echo json_encode($checker);
	}
	
	function kadaluarsaChecker() {
		$tanggal = $this->input->post('tanggal');
		$tanggal_sekarang = date ('d-m-Y');
		$flag = ($tanggal < $tanggal_sekarang);
		echo json_encode($flag);
	}
}
