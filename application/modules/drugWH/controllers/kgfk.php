<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Kgfk extends kgfkController {

    function __construct() {
        parent::__construct();
        $this->load->model('mDrugs');
        $this->load->model('mUnit');
        $this->load->model('mSource');
        $this->load->model('mDrugsTransaction');
		$this->load->model('mDrugsDetailTrans');		
		$this->load->model ('mGedung');	
		$this->load->model ('mDrugsNow');
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
	
	function clean($string) {
        return preg_replace('/[^A-Za-z0-9\-@ .,]/', '-', $string); // Removes special chars.
    }
	
	// on page Obat KADALUARSA
	public function drugsExp () {
		$this->display('drugs_exp');
	}
	
	// on page Recap
	public function recapDrugsOut () {
		$data['allStocks'] = $this->mDrugs->getGFKRemain();
        $data['error_msg'] = $this->session->flashdata('error');
		$this->display('recap', $data);		
	}
	
	public function showRecapDO () {
		$form_data = $this->input->post(null, true);
		
		$tanggal = DateTime::createFromFormat('d-m-Y', $form_data['tanggal']);
		$tanggal = $tanggal->format ('Y-m-d');
		
		$result = $this->mDrugsTransaction->showTransByTransDate($tanggal);
		if ($result) echo json_encode ($result);	
	}
	
	public function showTotalDO () {
		$form_data = $this->input->post(null, true);
		
		$tanggal1 = DateTime::createFromFormat('d-m-Y', $form_data['tanggal1']);
		$tanggal1 = $tanggal1->format ('Y-m-d');
		$tanggal2 = DateTime::createFromFormat('d-m-Y', $form_data['tanggal2']);
		$tanggal2 = $tanggal2->format ('Y-m-d');
		
		$result = $this->mDrugsDetailTrans->showTotalDetTransByTransDate($tanggal1, $tanggal2);
		if ($result) echo json_encode ($result);	
	}
	
	public function showDetailDO () {
		if ($this->uri->segment(4) && $this->uri->segment(5) && $this->uri->segment(6)){
			$id_unit = $this->uri->segment(4);
			$tanggal = DateTime::createFromFormat('d-m-Y', $this->uri->segment(5));
			$tanggal = $tanggal->format ('Y-m-d');
			$data['allStocks'] = $this->mDrugs->getGFKRemain();
			$data['rekapDetail'] = $this->mDrugsDetailTrans->showDetTransByPus($id_unit, $tanggal);
			$data['namaGedung'] = $this->uri->segment(6);
			$this->display('recap_detail', $data);
		}
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
		if($temp1) echo json_encode($temp1);		
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
            $flag = true;
            foreach ($value as $key => $sembarang) {
                if ($flag) {
                    $header .= '"';
                    $flag = false;
                } else {
                    $header .= ',"';
                }
                $header .= $this->renameHeader($key) . '"';
            }
            $header .= ",\"PILIH\"";
            $header .= "]";
            break;
        }

        // get value
        foreach ($data as $value) {
            $header .= ",[";
            $flagdata = true;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                if ($flagdata) {
                    $header .= '"';
                    $flagdata = false;
                } else
                    $header .= ',"';
                $header .= $data . '"';
            }
            $header .= ',"<a style=\"color: white\" type=\"button\" data-toggle=\"modal\" href=\"#addStocksModal\" onclick=\"toAddStocksModal(\'' . $value['ID_OBAT'] . '\', \'' . $this->replaceString($value['NAMA_OBAT']) . '\',\'\',\'\',\'\', \'\' )\" class=\"btn btn-xs btn-success\"><i class=\"fa fa-plus\"></i></a>"';
            $header .= "]";
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

    // add a drug into a basket
	public function removeDrugsDetailOM () {
		$form_data = $this->input->post(null, true);
		$haystack = $this->session->userdata('drugsIn_added_detail');
	
        if ($haystack) {
            for ($i = 0; $i < count($haystack); $i++) {
                if (in_array($form_data['id_obat'], $haystack[$i], true) && in_array($form_data['nomor_batch'], $haystack[$i], true)) {
					unset($haystack[$i]);
                    $this->session->set_userdata('drugsIn_added_detail', $haystack);  break;
                }
            }
        }
	}
	
    public function addDrugsDetailOM() {
        $form_data = $this->input->post(null, true);

        $data_detail = array(
            'id_obat' => $form_data['inputObat'],
            'nama_obat' => $form_data['inputNamaObat'],
            'jumlah_obat' => $form_data['inputJumlah'],
            'expired_date' => $form_data['inputKadaluarsa'],
            'nomor_batch' => $form_data['inputBatch'],
            'id_sumber_anggaran_obat' => $form_data['inputSumberAnggaran'],
			'harga_satuan' => $form_data['inputHargaSatuan'],
			'harga_total' => (string)((int)$form_data['inputJumlah'] * (int)$form_data['inputHargaSatuan']),
            // 'id_jenistransaksi' => '1',
			'penyedia_obat' => $form_data['inputPenyedia'],
            'id_unit' => $this->session->userdata['telah_masuk']['idunit']
        );

        $haystack = $this->session->userdata('drugsIn_added_detail');
        //if ($haystack) {
        $flag = true;
        if ($haystack) {
            for ($i = 0; $i < count($haystack); $i++) {
                if (in_array($form_data['inputObat'], $haystack[$i], true) && in_array($form_data['inputBatch'], $haystack[$i], true)) {
                    $haystack[$i]['jumlah_obat'] = $form_data['inputJumlah'];
                    $haystack[$i]['jumlah_obat'] = (string) $haystack[$i]['jumlah_obat'];
                    $this->session->set_userdata('drugsIn_added_detail', $haystack);
                    	
                    $flag = false;
                    break;
                }
            }
        }
        //	}
        //else {
        if ($flag)
            $haystack[] = $data_detail;
        //}
        $this->session->set_userdata('drugsIn_added_detail', $haystack);
        echo json_encode($this->session->userdata('drugsIn_added_detail'));
    }

    // drug checkout
    public function addDrugsIn() {
        $form_data = $this->input->post(null, true);
        
        $dateConverted = $this->convert($form_data['inputTransaksi']);

        $data = array(
            'id_penugasan' => $this->session->userdata['telah_masuk']['idpenugasan'],
            'id_jenistransaksi' => '1',
            'tanggal_transaksi' => $dateConverted,
            'tanggal_rekap_transaksi' => date('Y-m-d'),
            'transaksi_unit_dari' => $this->session->userdata['telah_masuk']['idunit'],
            'transaksi_unit_ke' => $this->session->userdata['telah_masuk']['idunit']
        );

        $result = $this->mDrugsTransaction->insertNewEntry($data, $this->session->userdata('drugsIn_added_detail'));

        $this->_setFlashData($result);
        $this->session->set_userdata('drugsIn_added_detail', null);
        redirect (base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/drugsIn');
    }
	// end of page 'Obat Masuk'

	
	
    // on page 'Obat Keluar'
    function drugsOut() {
        $this->session->set_userdata('drugsOut_added_detail', null);
        $data['error_msg'] = $this->session->flashdata('error');
        $data['allGedung'] = $this->mUnit->getDrugsWHHC();

        $data['allStocks'] = $this->mDrugs->getGFKRemain();
        $data['allSource'] = $this->mSource->getAllEntry();
        $this->display('drugs_out', $data);
    }
	
	function showAllDrugsGFKOut () {
		$temp1 = $this->mDrugs->getAllEntry();
		if ($temp1) echo $this->getPivotOK($temp1);
	}
	
	private function getPivotOK($data) {
        $header = "[[";
		
		// get key nama kolom
		// hapus underscore _ dan JADI GEDE
        foreach ($data as $value) {
			$flag = true;
            foreach ($value as $key => $sembarang) {
				if ($flag) {
					$header .= '"';
					$flag = false;					
				}
				else {
					$header .= ',"';
				}
				$header .= $this->renameHeader($key) . '"';
            }
			$header .= ",\"PILIH\"";
			// $header .= ",\"DETAIL\"";
            $header .= "]";
            break;
        }

		// get value
        foreach ($data as $value) {
            $header .= ",[";
			$flagdata = true;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
				if ($flagdata) {
                    $header .= '"';
					$flagdata = false;
				}
				else $header .= ',"';
				$header .= $data . '"';                
            }
			$header .= ',"<a style=\"color: white\" type=\"button\" data-toggle=\"modal\" href=\"#addStocksModal\" class=\"btn btn-xs btn-success\" onclick=\"toAddStocksModal(\''.$value['ID_OBAT'].'\',\''.$this->replaceString($value['NAMA_OBAT']).'\',\''.$value['TOTAL'].'\')\"><i class=\"fa fa-check\"></i></a>"';
            // $header .= "]";
			
			// $header .= ',"<a style=\"color: white\" type=\"button\" data-toggle=\"modal\" href=\"#detailObatModal\" class=\"btn btn-xs btn-warning\"  onclick=\"drugsDetailGFK(\''.$value['ID_OBAT'].'\')\"><i class=\"fa fa-search\"></i></a>"';
            $header .= "]";
        }
        $header .= "]";		
        return $header;
    }
	
	function showDrugsOut ($status) {
		if ($status == null) redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/drugsOut');
		$this->session->set_userdata('drugsOut_added_detail', null);
		$data['error_msg'] = $this->session->flashdata('error') ;
		$data['allGedung'] = $this->mUnit->getDrugsWHHC ();
		
		// $data['allDrugs'] = $this->mDrugs->getAllEntry();
		// $data['allDrugs'] = $this->mDrugs->getAllDrugsName ();
		
		$data['allStocks'] = $this->mDrugs->getGFKRemain();	
		$data['allSource'] = $this->mSource->getAllEntry();
		return $data;
	}
	
	public function removeDrugsDetailOK () {
		$form_data = $this->input->post(null, true);
		$haystack = $this->session->userdata('drugsOut_added_detail');
	
        if ($haystack) {
            for ($i = 0; $i < count($haystack); $i++) {
                if (in_array($form_data['id_obat'], $haystack[$i], true) && in_array($form_data['nomor_batch'], $haystack[$i], true)) {
					unset($haystack[$i]);
                    $this->session->set_userdata('drugsOut_added_detail', $haystack);  break;
                }
            }
        }
	}
	
	public function addDrugsDetailOK () {
		$form_data = $this->input->post (null, true);
		checkIfEmpty ($form_data, base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/drugsOut');
	
		$idObat = $form_data['inputObat'];
		$detailObat = $this->mDrugs->getAllDetailEntry($idObat);
		
		$jmlObatTotal = $form_data['inputJumlah'];
		$data_detail;
		$counter = 0;
		$tanda = false;
		foreach ($detailObat as $detail){
			$counter += $detail['STOK_OBAT_SEKARANG'];
			if ($counter > $jmlObatTotal){  
				$sisa = $counter - $jmlObatTotal;
				$ygDiambil = $detail['STOK_OBAT_SEKARANG'] - $sisa;
				$detail['STOK_OBAT_SEKARANG'] = $ygDiambil;
				$tanda = true;
			}			
			
			$data_detail[] = $detail;
			if ($tanda) break;
		}
		// echo json_encode ($data_detail);
		
		// $data_detail = array (
				// 'id_obat' => $form_data['inputObat'],
				// 'nama_obat' => $form_data['inputNamaObat'],
				// 'jumlah_obat' => $form_data['inputJumlah'],
				// 'expired_date' => $form_data['inputKadaluarsa'],
				// 'nomor_batch' => $form_data['inputBatch'],
				// 'id_sumber_anggaran_obat' => $form_data['inputSumberAnggaran'],
				// // 'id_jenistransaksi' => '2',
				// 'id_unit' => $this->session->userdata['telah_masuk']['idunit']	
		// );
				
		$haystack = $this->session->userdata('drugsOut_added_detail');
		$haystack_baru;
		if ($haystack) {
			foreach ($haystack as $key => $value) {
				if ($idObat != $value['ID_OBAT']) {
					$haystack_baru[] = $value;
				}
			}
		}
		for ($i=0; $i<count($data_detail); $i++) {
			$haystack_baru[] = $data_detail[$i];
		}
		$this->session->set_userdata('drugsOut_added_detail', $haystack_baru);		
		echo json_encode($this->session->userdata('drugsOut_added_detail'));
	}
	
	
	public function addDrugsOut () {
		$form_data = $this->input->post (null, true);
		checkIfEmpty ($form_data, base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/drugsOut');		
		
		$dateConverted = $this->convert($form_data['inputTransaksi']);
 		$data = array (
				'id_penugasan' => $this->session->userdata['telah_masuk']['idpenugasan'],
				'id_jenistransaksi' => '2',
				'tanggal_transaksi' => $dateConverted,
				'tanggal_rekap_transaksi' => date('Y-m-d'),
 				'transaksi_unit_ke' => $form_data['inputPuskesmas'],
 				'transaksi_unit_dari' => $this->session->userdata['telah_masuk']['idunit'],
				'flag_konfirmasi' => 0

		);
		
		//var_dump ($this->session->userdata('drugsOut_added_detail'));
		$this->session->set_userdata('idunittujuan', $form_data['inputPuskesmas']);
		$result = $this->mDrugsTransaction->insertNewEntryMinus ($data, $this->session->userdata('drugsOut_added_detail'));
		$this->_setFlashData($result);
		$this->session->set_userdata('drugsOut_added_detail', null);
		$this->session->set_userdata('idunittujuan', null);
		redirect (base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/drugsOut');
	}

	public function showRecommendation () {
		$this->display ('recom');		
	}
		
	
	public function showDataRecom () {
		// $id_unit = $this->uri->segment (4);
		// $id_unit = 25;
		$id_unit = $this->input->post('id');
		$id_obat = $this->input->post('id_obat');
		$temp = $this->mDrugsNow->getRecommendationCITO($id_unit, $id_obat);
		// if ($temp) echo $this->getPivotRecom($temp);
		if ($temp) echo json_encode ($temp);
	}
	
	private function getPivotRecom ($data) {
        $header = "[[";

        // get key nama kolom
        // hapus underscore _ dan JADI GEDE
        foreach ($data as $value) {
            $flag = true;
            foreach ($value as $key => $sembarang) {
                if ($flag) {
                    $header .= '"';
                    $flag = false;
                } else {
                    $header .= ',"';
                }
                $header .= $this->renameHeader($key) . '"';
            }
            $header .= "]";
            break;
        }

        // get value
        foreach ($data as $value) {
            $header .= ",[";
            $flagdata = true;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                if ($flagdata) {
                    $header .= '"';
                    $flagdata = false;
                } else
                    $header .= ',"';
                $header .= $data . '"';
            }
            $header .= "]";
        }
        $header .= "]";
        return $header;
    }
	// end of page 'Obat Keluar'

    // on page 'Keluar Puskesmas'
    function drugsOutHC() {
        $data['error_msg'] = $this->session->flashdata('error');
        $data['allStocks'] = $this->mDrugs->getGFKRemain();
        $data['allRequest'] = $this->mDrugsTransaction->getPendingRequest();
        $this->display('drugs_out_hc', $data);
    }
	
	function showDrugsOutHC ($status) {
		if ($status == null) redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/drugsOutHC');
		$data['error_msg'] = $this->session->flashdata('error') ;
		$data['allStocks'] = $this->mDrugs->getGFKRemain();	
		$data['allRequest'] = $this->mDrugsTransaction->getPendingRequest();
		return $data;
	}
	
	function showDetailRequest () {
		$id = $this->input->post ('id');		
		checkIfEmpty ($id, base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/drugsOutHC');
		
		$result = $this->mDrugsDetailTrans->getEntryById($id);
		if ($result) echo json_encode($result);		
	}
	
	public function addDrugsOutHC () {
		$form_data = $this->input->post (null, true);
		checkIfEmpty ($form_data, base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/drugsOutHC');
		// array (size=3)
		  // 'inputRekap' => string '2014-11-21' (length=10)
		  // 'inputIdTransaksi' => string '37' (length=2)
		  // 'inputUnit' => string '7' (length=1)
		$dateConverted = $this->convert($form_data['inputTransaksi']);
		
 		$data = array (
				'id_penugasan' => $this->session->userdata['telah_masuk']['idpenugasan'],
				'id_jenistransaksi' => '2',
				'tanggal_transaksi' => $dateConverted,
				'tanggal_rekap_transaksi' => date('Y-m-d'),
 				'transaksi_unit_ke' => $form_data['inputUnit'],
 				'transaksi_unit_dari' => $this->session->userdata['telah_masuk']['idunit'],
				'flag_konfirmasi' => 0,
				'id_rujukan_konfirmasi' => $form_data['inputIdTransaksi']
		);
		

		$this->mDrugsTransaction->updateEntry($form_data['inputIdTransaksi'], array('flag_konfirmasi' => (string)1));
		$detail = $this->mDrugsDetailTrans->getEntryById($form_data['inputIdTransaksi']);

		for ($i=0; $i<count($detail); $i++) {
			unset($detail[$i]['id_transaksi']);
			
			$idobat =''; $nomorbatch=''; $jmlobat='';
			foreach ($form_data as $key => $value) {
				if (strpos($key, "obat") !== false) {
					$temps = explode("-", $key);
					$idobat = $temps[1];	
					$nomorbatch = $temps[2];
					$jmlobat = $value;
					
					if (strcmp($detail[$i]['id_obat'],$idobat) == 0 && strcmp($detail[$i]['nomor_batch'],$nomorbatch) == 0){			
						$detail[$i]['jumlah_obat'] = (string) $jmlobat;
						$detail[$i]['id_unit'] = $this->session->userdata['telah_masuk']['idunit'];
						$idobat =''; $nomorbatch=''; $jmlobat='';
					}
					else  {	
						$detail[$i]['jumlah_obat'] = (string) $detail[$i]['jumlah_obat'];
						$detail[$i]['id_unit'] = $this->session->userdata['telah_masuk']['idunit'];
					}
				}
			}				
		}

		// $this->session->set_userdata('idunittujuan', $form_data['inputUnit']);
		$result = $this->mDrugsTransaction->insertNewEntryMinus ($data, $detail);
		$this->_setFlashData($result);
		// $this->session->set_userdata('idunittujuan', null);
		redirect (base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/drugsOutHC');
	}
	// end of page 'Keluar Puskesmas'

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
}
