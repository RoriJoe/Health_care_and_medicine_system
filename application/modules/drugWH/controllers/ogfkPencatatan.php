<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class OgfkPencatatan extends ogfkPencatatanController {

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
	
	private function replaceString($input) {
        $output = str_replace("\"", "\\\"", $input);
        $output = str_replace("\'", "\\\'", $output);
        return $output;
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
		echo json_encode ($result);	
	}
	
	public function showTotalDO () {
		$form_data = $this->input->post(null, true);
		
		$tanggal1 = DateTime::createFromFormat('d-m-Y', $form_data['tanggal1']);
		$tanggal1 = $tanggal1->format ('Y-m-d');
		$tanggal2 = DateTime::createFromFormat('d-m-Y', $form_data['tanggal2']);
		$tanggal2 = $tanggal2->format ('Y-m-d');
		
		$result = $this->mDrugsDetailTrans->showTotalDetTransByTransDate($tanggal1, $tanggal2);
		echo json_encode ($result);	
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
		else echo "Kosong";
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
		if($temp1)
		echo $this->getPivot($temp1);
		else echo "Kosong";
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
				$temps = explode("_", $key);
				$id_obat = $temps[1];
				$nomor_batch = $temps[2];
				
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
	
    // on page 'Obat Keluar'
    function drugsOut() {
        $data['error_msg'] = $this->session->flashdata('error');
        $data['allGedung'] = $this->mUnit->getDrugsWHHC();
        $data['allStocks'] = $this->mDrugs->getGFKRemain();
        $data['allSource'] = $this->mSource->getAllEntry();
		
        $this->display('drugs_out', $data);
    }
	
	function showAllDrugsGFKOut () {
		$temp1 = $this->mDrugs->getAllEntry();
		if ($temp1) {
			echo $this->getPivotOK($temp1);
		}
	}
	
	private function getPivotOK($data) {
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
			$header .= ',"<a style=\"color: white\" type=\"button\" data-toggle=\"modal\" href=\"#addStocksModal\" class=\"btn btn-xs btn-success\" onclick=\"toAddStocksModal(\''.$value['ID_OBAT'].'\',\''.$this->replaceString($value['NAMA_OBAT']).'\',\''.$value['TOTAL'].'\')\"><i class=\"fa fa-check\"></i></a>"';
            $header .= "]";
			$counter++;
        }
        $header .= "]";
        return $header;
    }
	
	// function showDrugsOut ($status) {
		// if ($status == null) redirect(base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/drugsOut');
		// $this->session->set_userdata('drugsOut_added_detail', null);
		// $data['error_msg'] = $this->session->flashdata('error') ;
		// $data['allGedung'] = $this->mUnit->getDrugsWHHC ();
		
		// // $data['allDrugs'] = $this->mDrugs->getAllEntry();
		// // $data['allDrugs'] = $this->mDrugs->getAllDrugsName ();
		
		// $data['allStocks'] = $this->mDrugs->getGFKRemain();	
		// $data['allSource'] = $this->mSource->getAllEntry();
		// return $data;
	// }
	
	// public function removeDrugsDetailOK () {
		// $form_data = $this->input->post(null, true);
		// $haystack = $this->session->userdata('drugsOut_added_detail');
	
        // if ($haystack) {
            // for ($i = 0; $i < count($haystack); $i++) {
                // if (in_array($form_data['id_obat'], $haystack[$i], true) && in_array($form_data['nomor_batch'], $haystack[$i], true)) {
					// unset($haystack[$i]);
                    // $this->session->set_userdata('drugsOut_added_detail', $haystack);  break;
                // }
            // }
        // }
	// }
	
	public function addDrugsDetailOK () {
		$form_data = $this->input->post (null, true);	
	
		$idObat = $form_data['inputObat'];
		$detailObat = $this->mDrugs->getAllDetailEntry($idObat);
		
		$jmlObatTotal = $form_data['inputJumlah'];
		$data_detail;
		$counter = 0;
		$tanda = false;
		foreach ($detailObat as $detail){
			$counter += $detail['STOK_OBAT_SEKARANG'];
			if ($counter >= $jmlObatTotal){  
				$sisa = $counter - $jmlObatTotal;
				$ygDiambil = $detail['STOK_OBAT_SEKARANG'] - $sisa;
				$detail['STOK_OBAT_SEKARANG'] = $ygDiambil;
				$tanda = true;
			}			
			
			$data_detail[] = $detail;
			if ($tanda) break;
		}
		echo json_encode ($data_detail);
	}
	
	
	public function addDrugsOut () {
		$form_data = $this->input->post (null, true);
		
		$data_obat = array ();
        foreach ($form_data as $key => $value) {
			if (strpos($key, "obat") !== false) {
				$temps = explode("_", $value);
				$data_detail = array(
					'ID_OBAT' => $temps[0],
					'NOMOR_BATCH' => $temps[1],					
					'EXPIRED_DATE' => $temps[2],					
					'STOK_OBAT_SEKARANG' => $temps[3],
					'ID_SUMBER_ANGGARAN_OBAT' => $temps[4],
					'ID_UNIT' => $this->session->userdata['telah_masuk']['idunit']
				);	
				array_push($data_obat, $data_detail);
			}
		}
		
		$dateConverted = $this->convert($form_data['inputTransaksi']);

 		$data = array (
				'id_penugasan' => $this->session->userdata['telah_masuk']['idpenugasan'],
				'id_jenistransaksi' => '2',
				'tanggal_transaksi' => $dateConverted,
				'tanggal_rekap_transaksi' => date('Y-m-d'),
 				'transaksi_unit_dari' => $this->session->userdata['telah_masuk']['idunit']
		);
		
		if ($form_data['inputPuskesmas'] == -1) {
			$data['nama_transaksi_sumber_lain'] = $form_data['inputSumberLain'];
		} else {
			$data['transaksi_unit_ke'] = $form_data['inputPuskesmas'];
		}
		
		$result = $this->mDrugsTransaction->insertNewEntryMinus ($data, $data_obat);	
		$this->_setFlashData($result);
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
		echo json_encode ($temp);
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
		if ($result != null) echo json_encode($result);
		// else echo "Kosong";
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
				// 'flag_konfirmasi' => 0,
				'id_rujukan_konfirmasi' => $form_data['inputIdTransaksi']
		);
		$this->mDrugsTransaction->updateEntry($form_data['inputIdTransaksi'], array('flag_konfirmasi' => (string)1));
				
		$detail = $this->mDrugsDetailTrans->getEntryById($form_data['inputIdTransaksi']);
		
		// cari detail per batch
		$data_detail;
		foreach ($detail as $det) {			
			$detailObat = $this->mDrugs->getAllDetailEntry($det['ID_OBAT']);
			$jmlObatTotal = $det['JUMLAH_OBAT'];
			
			$counter = 0;
			$tanda = false;
			foreach ($detailObat as $do){
				$counter += $do['STOK_OBAT_SEKARANG'];
				if ($counter >= $jmlObatTotal){  
					$sisa = $counter - $jmlObatTotal;
					$ygDiambil = $do['STOK_OBAT_SEKARANG'] - $sisa;
					$do['STOK_OBAT_SEKARANG'] = $ygDiambil;
					$tanda = true;
				}			
				
				$data_detail[] = $do;
				if ($tanda) break;
			}
		}

		$result = $this->mDrugsTransaction->insertNewEntryMinus ($data, $data_detail);
		// $this->_setFlashData($result);
		redirect (base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/drugsOutHC');
	}
	
	public function convert($date) {
        $mydate = date_create_from_format('d-m-Y', $date);
        return date_format($mydate, 'Y-m-d');
    }

	// end of page 'Keluar Puskesmas'

    function logIn() {
		// $data['log'] = $this->mLog->getLogIn ();
		$data['allStocks'] = $this->mDrugs->getGFKRemain ();
		$this->display('log_in', $data);
    }
	
	function getLogIn () {
		$data = $this->mLog->getLogIn ();
		if ($data) {
			echo $this->getPivotLogIn($data);
		}
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
		echo json_encode($data);
	}

    function logOut() {
        $data['log'] = $this->mLog->getLogOut ();
		$data['allStocks'] = $this->mDrugs->getGFKRemain ();
		$this->display('log_out', $data);
    }
	
	function getLogOut () {
		$data = $this->mLog->getLogOut ();
		if ($data) {
			echo $this->getPivotLogOut($data);
		}
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
		echo json_encode($data);
	}
	
	
	function logUnused() {
		// $data['log'] = $this->mLog->getLogOut ();
		$data['allStocks'] = $this->mDrugs->getGFKRemain ();
		$this->display('log_unused', $data);
	}
	
	function listDrugsOut () {		
		$data['allStocks'] = $this->mDrugs->getGFKRemain ();
		$data['obatKeluar'] = $this->mLog->getPendingLogOut ();
		$this->display('list_drugs_out', $data);
	}
	
	// 
	
	// tombol simpan jumlah habis diubah
	function updateRequestCITO () {
		$idObat = $this->input->post('id_obat');
		$idTransaksi = $this->input->post('id_transaksi');	
		
		// remove 
		$data_where = array (
			'id_transaksi' => $idTransaksi,
			'id_obat' => $idObat
		);		
		$total_baru = $this->input->post('total');
		$data_baru = array (
			'jumlah_obat' => $total_baru
		);
		$this->mDrugsDetailTrans->updateEntry($data_where, $data_baru);
		
		// // ambil lagi
		// $detailObat = $this->mDrugs->getAllDetailEntry($idObat);
		
		// $jmlObatTotal =$this->input->post('total');
		// $data_detail;
		// $counter = 0;
		// $tanda = false;
		// foreach ($detailObat as $detail){
			// $counter += $detail['STOK_OBAT_SEKARANG'];
			// if ($counter >= $jmlObatTotal){  
				// $sisa = $counter - $jmlObatTotal;
				// $ygDiambil = $detail['STOK_OBAT_SEKARANG'] - $sisa;
				// $detail['STOK_OBAT_SEKARANG'] = $ygDiambil;
				// $detail['ID_TRANSAKSI'] = $idTransaksi;
				// $tanda = true;
			// }			
			
			// $data_detail[] = $detail;
			// if ($tanda) break;
		// }
		
		// $result = $this->mDrugsDetailTrans->insertManyEntryMinus ($data_detail);	
	}
	
	function removeRequestCITO () {
		$idObat = $this->input->post('id_obat');
		$idTransaksi = $this->input->post('id_transaksi');	
		
		// remove 
		$data_where = array (
			'id_transaksi' => $idTransaksi,
			'id_obat' => $idObat
		);
		$this->mDrugsDetailTrans->removeAllEntry($data_where);		
		echo $idObat;
	}
	
	function removeDetailRequest () {
		$idObat = $this->input->post('id_obat');
		$idTransaksi = $this->input->post('id_transaksi');	
		
		// remove 
		$data_where = array (
			'id_transaksi' => $idTransaksi,
			'id_obat' => $idObat
		);
		$this->mDrugsDetailTrans->removeAllEntry($data_where);
		
		// ambil lagi
		$detailObat = $this->mDrugs->getAllDetailEntry($idObat);
		
		$jmlObatTotal =$this->input->post('total');
		$data_detail;
		$counter = 0;
		$tanda = false;
		foreach ($detailObat as $detail){
			$counter += $detail['STOK_OBAT_SEKARANG'];
			if ($counter > $jmlObatTotal){  
				$sisa = $counter - $jmlObatTotal;
				$ygDiambil = $detail['STOK_OBAT_SEKARANG'] - $sisa;
				$detail['STOK_OBAT_SEKARANG'] = $ygDiambil;
				$detail['ID_TRANSAKSI'] = $idTransaksi;
				$tanda = true;
			}			
			
			$data_detail[] = $detail;
			if ($tanda) break;
		}
		
		$result = $this->mDrugsDetailTrans->insertManyEntryMinus ($data_detail);	
	}
	
	function onlyRemoveDetailRequest () {
		$idObat = $this->input->post('id_obat');
		$idTransaksi = $this->input->post('id_transaksi');	
		
		// remove 
		$data_where = array (
			'id_transaksi' => $idTransaksi,
			'id_obat' => $idObat
		);
		$this->mDrugsDetailTrans->removeAllEntry($data_where);		
		echo $idObat;
	}
	
	function cancelRequest () {
		$idTransaksi = $this->input->post ('idtrans');		
		$this->mDrugsTransaction->removeEntry ($idTransaksi);
		$this->mDrugsDetailTrans->removeEntry ($idTransaksi);		
	}
	
}
