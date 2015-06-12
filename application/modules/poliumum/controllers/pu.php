<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pu extends puController {

    private $home;

    public function __construct() {
        parent::__construct();
		$this->load->library('pagination');
        $this->home = base_url().$this->uri->segment(1).'/pu/';
        $this->load->model('mDrugsNow');
        $this->load->model('mHServices');
        $this->load->model('mAction');
        $this->load->model('mLabCheck');
		
		$this->load->model ('mAccount');
        $this->load->model ('mAssignment');
        $this->load->model ('mQueue');
        $this->load->model ('mMRHistory');
        $this->load->model ('mCaseStatus');
        $this->load->model ('mPatient');
        $this->load->model ('mComplaint');
        $this->load->model ('mDiagnosis');
        $this->load->model ('mIcd');
        $this->load->model ('unit_model');
		
		// model demit
		$this->load->model('mdental');
        $this->load->model('mdrughc');
    }

    function updateAllEntryRRM() {
        $data = $this->input->post(null, true);
        $id_rrm = $data['id_rrm'];
        unset($data['id_rrm']);
        
		$this->mMRHistory->updateEntry($data, $id_rrm);
        redirect($this->home);
    }

    public function index() {
        redirect($this->home . 'queue');
    }

    function getSearch() {
        // header('Cache-Control: no-cache, must-revalidate');
        // header('Access-Control-Allow-Origin: *');
        // header('Content-type: application/json');
        
		$data = $this->input->post('teksnya');

        $teks = $data['tanda'];
        $temp1 = $this->mIcd->getAllEntry($teks);

		if ($temp1) echo $this->getPivot($temp1);
    }

    function clean($string) {
        //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        //return str_replace(array('\'', '\\', '/', '*'), ' ', $string);
        return preg_replace('/[^A-Za-z0-9\-@ .,]/', '-', $string); // Removes special chars.
    }
	
	private function _setFlashData ($status) {
    	$key = 'error';
    	if ($status == true)
    		$message = 'success';
    	else $message = 'failed';
    
    	$this->session->set_flashdata ($key, $message);
    }

    private function getPivot($data) {
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
            $header .= ",\"KELOLA\"";
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
            $header .= ',"<a style=\'color: white;\' class=\'btn btn-success\' type=\'button\' onclick=\'ICDChoosed(' . $value['ID_ICD'] . ')\' ><i class=\'fa fa-check\'></i></a>"';
            $header .= "]";
        }
        $header .= "]";
        return $header;
    }

    private function _getFormFill() {
        $data = array(
            "error_msg" => $this->session->flashdata('error'),
            //"allKasus" => $this->mCaseStatus->getAllEntry (),
            "unit" => $this->unit_model->getUnitByHC(),
            "queues" => $this->mQueue->getAllByUnit($this->session->userdata['telah_masuk']['idunit']),
            "layanan" => $this->mHServices->getAllEntry()
                //"icd" => $this->mIcd->getAllEntry ()
        );
        return $data;
    }

    public function showICD() {
        $query = $this->input->post('query');
        $data = $this->mIcd->getEntryByQuery($query);
        if ($data)
            echo json_encode($data);
    }

    public function showICDById() {
        $id = $this->input->post('id');
        $result = $this->mIcd->getEntryById($id);
        if ($result)
            echo json_encode($result);
    }

    function showStocks() {
        $id_unit = $this->session->userdata['telah_masuk']['idunit'];
        $data = $this->mDrugsNow->getEntryByUnit($id_unit);
        if ($data) {
			echo $this->getPivotStocks($data);
		}
    }

    public function stocks() {
        $this->display('stockPoly');
    }

    // home
    public function queue() {
        $data = $this->_getFormFill();		
		// var_dump($data);
		$this->display('home', $data);
    }

    public function patient() {
        $this->display('patient');
    }

    public function profileMRH() {
        $id = $this->uri->segment(4, 0);

        $data['idrrm'] = $id;
        $data['profil'] = $this->mMRHistory->getProfilMRH($id);
        $data['riwayat_rm'] = $this->mMRHistory->getMRHById($id);
        $data['tindakan'] = $this->mHServices->getEntryById($id);
        $data['laborat'] = $this->mLabCheck->getEntryById($id);
        $data['icd'] = $this->mDiagnosis->getEntryById($id);
        $this->display('mrhProfile', $data);
    }

    public function patientMRH() {
        $id = $this->uri->segment(4, 0);
		// Perubahan !!!
		// idrrm to id_rm
        $data['id_rm'] = $id;
        $data['data_rrm'] = $this->mMRHistory->getMRHByIdMR($id, 100);
        $this->display('allMedRecord', $data);
    }

    function getSearch2() {
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');

		// Perubahan idrrm to id_rm
        $id_rm = $data['id_rm'];
        $rangedata = $data['range'];
        $temp1 = $this->mMRHistory->getMRHByIdMR($id_rm, $rangedata);
        $data["submit"] = $this->getPivot2($temp1);
        if ($data) {
            return $data["submit"];
        } else
            return "Kosong";
    }

    private function getPivot2($data) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        $header = "[[";
        foreach ($data as $value) {
			$header .= '"NOMOR"';
            foreach ($value as $key => $sembarang) {
				$header .= ',"' . str_replace("_", " ", strtoupper($key)) . '"';
            }
            $header .= ",\"DETIL\"]";
            break;
        }
		
		$counter = 1;
        foreach ($data as $value) {
            $header .= ",[";
			$header .= '"'.$counter.'"';
			$counter++;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                $header .= ',"' . $data . '"';
            }
            $header .= ',"<a target=\"_blank\" type=\"button\" style=\"color: white\" href=\"' . base_url() . $this->uri->segment(1) . '/'. $this->uri->segment(2). '/profileMRH/' . $value->ID_RIWAYAT_RM . '\" class=\"btn btn-primary\">Pilih</a>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }

	public function getLabResult () {
		$idRMHistory = $this->input->post('id');
		$result = $this->mLabCheck->getEntryById($idRMHistory);
		if ($result) {
            echo json_encode($result);
		}
	}
	
    public function getPatientData() {
        $idRMHistory = $this->input->post('id');
        $result = $this->mPatient->getEntryByRRM($idRMHistory);
        if ($result)
            echo json_encode($result);
    }
	
	public function getPatientHistory () {
		$idRMHistory = $this->input->post('id');
        $result = $this->mMRHistory->getMRHById($idRMHistory);
		if ($result)
            echo json_encode($result);
	}

	private function _updateRiwayat ($form_data) {
		$data = array(
			'CUMA_KONTROL' 			=> $form_data['CUMA_KONTROL'],
			'beratbadan_pasien' 	=> $form_data['berat'],
			'tinggibadan_pasien' 	=> $form_data['tinggi'],
			'sistol_pasien' 		=> $form_data['sistol'],
			'diastol_pasien' 		=> $form_data['diastol'],
			'suhu_badan' 			=> $form_data['suhu'],
			'detak_jantung' 		=> $form_data['jantung'],
			'napas_per_menit' 		=> $form_data['napas'],
			// 'umur_saat_ini' => (isset($form_data['umur']))?$form_data['umur']:null,	
			'stat_rawat_jalan' 		=> $form_data['rawat'],
			'tempat_rujukan' 		=> $form_data['rujuk'],
			'kunjungan_kasus'		=> $form_data['kunjungan']
		);
		$this->mMRHistory->updateEntry($data, $form_data['id_rrm']);
	}
	
	private function _updateLayananKesehatan ($form_data) {
		unset($form_data['layananKesehatan']);
		$data_tindakan = array ();			
		foreach ($form_data as $key => $value) {
				if (strpos($key, "layanan") !== false) {					
					$temps = explode("-", $key);
					$id = $temps[1];					
					$arr = array (
						'ID_RIWAYAT_RM' => $form_data['id_rrm'],
						'ID_LAYANAN_KES' => $id,
						'ID_AKUN' => $this->session->userdata['telah_masuk']['idakun'],
						'TANGGAL_TINDAKAN' => date('Y-m-d H:i:s')
					);
					$data_tindakan[] =  $arr;						
				}
		}
		foreach($data_tindakan as $tindakan) $this->mAction->insertNewEntry($tindakan);
		
	}
	
	private function _insertComplaintDiagnosis($idMRHistory, $keluhan, $diagnosis, $id, $data_icd, $form_data) {
        $keluhans = explode(",", $keluhan);
		foreach ($keluhans as $keluhkesah) {
			$data_keluhan = array(
				'ID_RIWAYAT_RM' => $idMRHistory,
				'DESKRIPSI_KELUHAN' => $keluhkesah,
				'ID_AKUN' => $id
			);			
			$this->mComplaint->insertNewEntry($data_keluhan);
		}
        foreach ($data_icd as $key => $item) {
            $data_diagnosis = array(
                'ID_RIWAYAT_RM' => $idMRHistory,
                'DESKRIPSI_DP' => $diagnosis,
                'ID_AKUN' => $id,
                'ID_ICD' => $key,
				'NAMA_STATUS_KASUS' => $form_data['kasus-'.$key]
            );
            $this->mDiagnosis->insertNewEntry($data_diagnosis);
        }
        return true;
    }
	
	private function _updateDataICD ($form_data) {
		$data_icd = array ();			
		foreach ($form_data as $key => $value) {
				if (strpos($key, "icd") !== false) {
					$temps = explode("-", $key);
					$id = $temps[1];	
					$data_icd[$id] =  $value;					
				}
		}	
		$this->_insertComplaintDiagnosis($form_data['id_rrm'], $form_data['keluhan'], $form_data['diagnosa'], $this->session->userdata['telah_masuk']['idakun'], $data_icd, $form_data);
	}
	
	private function _updateAntrian ($no_antrian) {
		$this->mQueue->updateQueue($no_antrian);
	}
	
	private function _masukAntrianPoliLain ($form_data) {
		$s = $this->input->post('tanggalAntrian2').' '.$this->input->post('waktuAntrian2');
		$date = strtotime($s);
		$waktuantrian = date('Y-m-d H:i:s', $date);
                
		$id_rrm = $form_data['id_rrm'];
		$idunit = $form_data['unit3'];			
		$idsumber = $this->input->post('pembayaranPasien');
		$roro = $this->mMRHistory->getMRHById($id_rrm);
		$med_record_history = array(
			'id_rekammedik' 		=> $roro[0]['ID_REKAMMEDIK'],
			'id_sumber' 			=> $idsumber,
			'tanggal_riwayat_rm' 	=> $waktuantrian,
			'session_kunjungan' 	=> $roro[0]['SESSION_KUNJUNGAN']
		);
		$last_medHistoryId = $this->mMRHistory->insertNewEntry($med_record_history, $idunit);		
		
		$data_queue = array(
			'id_unit' => $idunit,
			'id_riwayat_rm' => $last_medHistoryId,
			'waktu_antrian_unit' => $waktuantrian,
			'flag_intern' => 1
		);
		if (isset($form_data['subUnitPelayanan3'])) {
			$data_queue['sub_kia'] = $form_data['subUnitPelayanan3'];
		}	
		// masuk antrian
		$this->mQueue->insertNewEntry($data_queue);
	}
	
	private function _simpanRiwayat ($form_data) {
		$this->_updateRiwayat($form_data);
		$this->_updateLayananKesehatan($form_data);
		$this->_updateDataICD($form_data);	
		$this->_updateAntrian($form_data['hidden_noantrian']);
	}
	
    public function updateRMHistory() {
		
		// get all form fill
		$form_data = $this->input->post(null, true);
		checkIfEmpty($form_data, $this->home);
		
		// throw away garbage
		unset($form_data['pivot-table_length']);
		unset($form_data['queryicd']);

		$flagBtn = $form_data['flagbutton'];
		switch ($flagBtn) {
			case 1:
				// simpan data dan kembali ke antrian
				$this->_simpanRiwayat ($form_data);							
				redirect($this->home);
				break;
			case 2:
				// simpan dan buat resep
                                $noantrian = $this->input->post('hidden_noantrian');
				$this->_simpanRiwayat($form_data);			
				$id_rrm = $form_data['id_rrm'];
				$a_patient = $this->mPatient->getEntryByRRM($id_rrm);
				$idpasien = $a_patient['id_pasien'];
				redirect(base_url() . $this->uri->segment(1) . '/'. $this->uri->segment(2).'/receipt/addResep/' . $id_rrm . '/' . $idpasien. '/' .$noantrian);
				break;
			case 3:
				// simpan dan arahkan ke poli lain
				$this->_simpanRiwayat ($form_data);
				$this->_masukAntrianPoliLain($form_data);				
				redirect($this->home);
				break;
			case 4:
				// arahkan ke poli lain
				$s = $this->input->post('tanggalAntrian').' '.$this->input->post('waktuAntrian');
				$date = strtotime($s);
				$waktuantrian = date('Y-m-d H:i:s', $date);
                                
				$idunit = $this->input->post('unit4');
				$id_rrm = $this->input->post('id_rrm');
			
				$data_queue = array(
					'id_unit' => $idunit,
					'id_riwayat_rm' => $id_rrm,
					'waktu_antrian_unit' => $waktuantrian,
					'flag_intern' => 1
				);				
				if (isset($form_data['subUnitPelayanan4'])) {
					$data_queue['sub_kia'] = $form_data['subUnitPelayanan4'];
				}	
				$this->mQueue->insertNewEntry($data_queue);
				$this->_updateAntrian($form_data['hidden_noantrian']);
				redirect($this->home);
				break;
		}    
	}


    function showPatient() {
        $id_unit = $this->session->userdata['telah_masuk']['idunit'];
		// Perubahan!!!
        // $data = $this->mMRHistory->getHistoryRRM($id_unit);
		$data = $this->mMRHistory->getMedRecord ($id_unit);
		if ($data) echo $this->getPivotPatient($data);
	}
	
	private function renameHeader ($headerName) {
		$headerName = str_replace("_", " ", strtoupper($headerName));
		switch ($headerName) {
			case "NOID REKAMMEDIK" :
				$headerName = "NOMOR REKAM MEDIK";
				break;
				
			case "STOK OBAT SEKARANG":
				$headerName = "STOK SAAT INI";
			break;			
			
			case "EXPIRED DATE":
				$headerName = "TANGGAL KADALUARSA";
			break;
			
			case "NAMA SUMBER ANGGARAN OBAT":
				$headerName = "SUMBER ANGGARAN";
				break;
			
			default:
				break;			
        }
		return $headerName;
	}

    private function getPivotPatient($data) {
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
			$header .= ',"<a target=\"_blank\" type=\"button\" style=\"color: white\" href=\"' . base_url() . $this->uri->segment(1).'/'.$this->uri->segment(2) . '/patientMRH/' . $value['id_rekammedik'] . '\" class=\"btn btn-primary\">Detail</a>"';
            $header .= "]";
			$counter++;
        }
        $header .= "]";
        return $header;
    }

    function toLaborat() {
        $this->display('laboratorium');
    }

    function showLaborat() {
//		$id_unit = $this->session->userdata['telah_masuk']['idunit'];
        $temp = $this->mLabCheck->getIdLab_byGedung($this->session->userdata['telah_masuk']['idgedung']);
        $idlab = $temp[0]->ID_UNIT;
        $data = $this->mLabCheck->getAllEntry($idlab);
        echo $this->getPivotLaborat($data);
    }

    private function getPivotLaborat($data) {
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
            $header .= ',"<a type=\"button\" style=\"color: white\" onclick=\"addPemeriksaanLaborat(\'' . $value['ID_PEM_LABORAT'] . '\',\'' . $value['NAMA_PEM_LABORAT'] . '\')\" class=\"btn btn-primary\"><i class=\"fa fa-check\"></i></a>"';
            $header .= "]";
        }
        $header .= "]";
        return $header;
    }

    function insertCekLaborat() {
        $form_data = $this->input->post(null, true);
        checkIfEmpty($form_data, $this->home);

        $id_unit_tujuan = $form_data['id_unit_tujuan'];
        unset($form_data['id_unit_tujuan']);

        $id_rrm = $form_data['id_rrm'];
        unset($form_data['id_rrm']);

        $id_antrian = $form_data['id_antrian'];
        unset($form_data['id_antrian']);

        foreach ($form_data as $key => $value) {
            $data = array(
                'ID_RIWAYAT_RM' => $id_rrm,
                'ID_PEM_LABORAT' => $key
            );
            $this->mLabCheck->insertNewEntry($data);
        }
        //var_dump($id_antrian);
        $this->mQueue->updateQueue($id_antrian);

        $data_antrian = array(
            'FLAG_ANTRIAN_UNIT' => 0,
            'ID_UNIT' => $id_unit_tujuan,
            'ID_RIWAYAT_RM' => $id_rrm,
            'WAKTU_ANTRIAN_UNIT' => date('Y-m-d H:i:s')
        );


        $this->mQueue->insertNewEntry($data_antrian);
        redirect($this->home);
    }

    private function getPivotStocks($data) {
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

	
	// start fungsi de2mitgoekiel
    public function monitoringObat() {
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];

        $array['notifStok']= $this->mdrughc->notificationStok();
        $array['notifMinStok']= $this->mdrughc->notificationMinStokUNIT();
        $array['idUnit'] = $idUnit;
        $array['namaUnit'] = $namaUnit;
        $this->display('acMonitoringStok', $array);
    }
    
    public function transPermintaan(){
        $id_akun= $this->session->userdata['telah_masuk']["idakun"];
        $idUnit= $this->session->userdata['telah_masuk']['idunit'];
        
        $penugasan= $this->mdrughc->getPenugasan($id_akun, $idUnit);
        $tanggalTransaksi= $this->convert($this->input->post('transaksi'));
        $tanggalRekapTransaksi= $this->convert($this->input->post('transaksi_now'));
        $listKode= json_decode($this->input->post('total_kodeObat'));
        $listJml= json_decode($this->input->post('total_jumlahObat'));
        $jenisTransaksi= $this->input->post('jenis_transaksi');
            $param1= 'TRANSAKSI_UNIT_DARI';
            $param2= 'TRANSAKSI_UNIT_KE';
        
        $data = array(
            'ID_PENUGASAN' => $penugasan[0]['ID_PENUGASAN'],
            'ID_JENISTRANSAKSI' => $jenisTransaksi,
            'TANGGAL_TRANSAKSI' => $tanggalTransaksi,
            'TANGGAL_REKAP_TRANSAKSI' => $tanggalRekapTransaksi,
            $param1 => $this->input->post('dari'),    //unit
            $param2 => $this->input->post('ke'),   //unit
            'FLAG_KONFIRMASI' => $this->input->post('flag_konfirmasi'),
            'ID_RUJUKAN_KONFIRMASI' => $this->input->post('id_rujukan')
        );
        $lastID= $this->mdrughc->insertAndGetLast('transaksi_obat', $data);
        
        for($i=0; $i<sizeof($listKode); $i++):
            $data_obat= array(
                'ID_TRANSAKSI'=> $lastID,
                'ID_OBAT'=> $listKode[$i],
                'JUMLAH_OBAT'=> $listJml[$i],
                'ID_UNIT'=> $idUnit
            );
            $this->mdrughc->insert('detil_transaksi_obat', $data_obat);
        endfor;
    
        redirect(base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/showTransPermintaan/'.$lastID);
    }
    
    public function showTransPermintaan($idTransaksi){
        $queryTrans= $this->mdrughc->getSomeTransaksi($idTransaksi);
        $jenisTrans= $this->mdrughc->getSomeJenisTrans($queryTrans[0]['ID_JENISTRANSAKSI']);
        $param= array('ID_UNIT'=>$queryTrans[0]['TRANSAKSI_UNIT_DARI']);
        $temp= $this->mdrughc->getUnit($param);
        $dari= $temp[0]['NAMA_UNIT'];
        $param= array('ID_UNIT'=>$queryTrans[0]['TRANSAKSI_UNIT_KE']);
        $temp= $this->mdrughc->getUnit($param);
        $ke= $temp[0]['NAMA_UNIT'];
        
        $queryDetailTrans= $this->mdrughc->getSomeDetailTrans($idTransaksi);
        $listNamObat = array();
        $listJmlObat = array();
        $listSatObat = array();
        for($i=0; $i<sizeof($queryDetailTrans); $i++):
            $getObat= $this->mdrughc->getSomeObat($queryDetailTrans[$i]['ID_OBAT']);
            array_push($listNamObat, $getObat[0]['NAMA_OBAT']);
            array_push($listJmlObat, $queryDetailTrans[$i]['JUMLAH_OBAT']);
            array_push($listSatObat, $getObat[0]['SATUAN']);
        endfor;
        
        $array['trans']= $queryTrans; 
        $array['jenisTrans']= $jenisTrans;
        $array['dari']= $dari;
        $array['ke']= $ke;
        $array['detailTrans']= $queryDetailTrans;
        $array['listNamObat']= $listNamObat;
        $array['listJmlObat']= $listJmlObat;
        $array['listSatObat']= $listSatObat;
        $this->display('acShowResultTransaksiPermintaan', $array);
    }

    //function transaksi logistik obat
    public function addRequest() {
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];

        $penugasan = $this->mdrughc->getPenugasan($id_akun, $idUnit);
        $tanggalTransaksi = $this->convert($this->input->post('transaksi'));
        $tanggalRekapTransaksi = $this->convert($this->input->post('transaksi_now'));
        $listKode = json_decode($this->input->post('total_kodeObat'));
        $listBatch = json_decode($this->input->post('total_batch'));
        $listJml = json_decode($this->input->post('total_jumlahObat'));
        $jenisTransaksi = $this->input->post('jenis_transaksi');

        $data = array(
            'ID_PENUGASAN' => $penugasan[0]['ID_PENUGASAN'],
            'ID_JENISTRANSAKSI' => $this->input->post('jenis_transaksi'),
            'TANGGAL_TRANSAKSI' => $tanggalTransaksi,
            'TANGGAL_REKAP_TRANSAKSI' => $tanggalRekapTransaksi,
            'TRANSAKSI_UNIT_DARI' => $this->input->post('dari'),
            'TRANSAKSI_UNIT_KE' => $this->input->post('ke'),
            'FLAG_KONFIRMASI' => $this->input->post('flag_konfirmasi'),
            'ID_RUJUKAN_KONFIRMASI' => $this->input->post('id_rujukan')
        );
        $lastID = $this->mdrughc->insertAndGetLast('transaksi_obat', $data);

        $idTransBefore = $this->input->post('id_rujukan');
        if (isset($idTransBefore)) {    //cek if it has id_rujukan
            $dataResep = array(
                'FLAG_KONFIRMASI' => 1
            );
            $updateResep = $this->mdrughc->update('transaksi_obat', $dataResep, 'ID_TRANSAKSI', $idTransBefore);
        }

        for ($i = 0; $i < sizeof($listKode); $i++):
            if ($jenisTransaksi == 20) {   //Penerimaan Layanan / Unit dari Gudang Obat
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit Pengirim Obat
                $this->mdrughc->penambahanStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if ($jenisTransaksi == 10) {   //Pemakaian
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit Pengirim Obat
                $this->mdrughc->penguranganStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if ($jenisTransaksi == 22) {   //Retur Obat Unit ke Gudang Obat
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit Pengirim Obat
                $this->mdrughc->penguranganStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if ($jenisTransaksi == 11) { //Permintaan Unit / Layanan ke Gudang Obat 
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('ke'), $listBatch[$i], $listKode[$i]);  //idUnit Pengirim Obat
                $this->mdrughc->permintaanStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
        endfor;

        redirect(base_url() . 'index.php/' . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/showTrans/' . $lastID);
    }

    public function convert($date) {
        $mydate = date_create_from_format('d-m-Y', $date);
        return date_format($mydate, 'Y-m-d');
    }

    //function show result transaksi logistik obat
    public function showTrans($idTransaksi) {
        $queryTrans = $this->mdrughc->getSomeTransaksi($idTransaksi);
        $jenisTrans = $this->mdrughc->getSomeJenisTrans($queryTrans[0]['ID_JENISTRANSAKSI']);
        if ($jenisTrans[0]['ID_JENISTRANSAKSI'] != 15) {    //bukan Penerimaan Obat selain GFK
            $param = array('ID_UNIT' => $queryTrans[0]['TRANSAKSI_UNIT_DARI']);
            $temp = $this->mdrughc->getUnit($param);
            $dari = $temp[0]['NAMA_UNIT'];
            $param = array('ID_UNIT' => $queryTrans[0]['TRANSAKSI_UNIT_KE']);
            $temp = $this->mdrughc->getUnit($param);
            $ke = $temp[0]['NAMA_UNIT'];
        } else {
            $dari = $queryTrans[0]['NAMA_TRANSAKSI_SUMBER_LAIN'];
            $param = array('ID_UNIT' => $queryTrans[0]['TRANSAKSI_UNIT_KE']);
            $temp = $this->mdrughc->getUnit($param);
            $ke = $temp[0]['NAMA_UNIT'];
        }

        $queryDetailTrans = $this->mdrughc->getSomeDetailTrans($idTransaksi);
        $listNamObat = array();
        $listBatch = array();
        $listJmlObat = array();
        $listSatObat = array();
        $listExpired = array();
        for ($i = 0; $i < sizeof($queryDetailTrans); $i++):
            $getObat = $this->mdrughc->getSomeObat($queryDetailTrans[$i]['ID_OBAT']);
            array_push($listNamObat, $getObat[0]['NAMA_OBAT']);
            array_push($listJmlObat, $queryDetailTrans[$i]['JUMLAH_OBAT']);
            array_push($listSatObat, $getObat[0]['SATUAN']);
            array_push($listBatch, $queryDetailTrans[$i]['NOMOR_BATCH']);
            array_push($listExpired, $queryDetailTrans[$i]['EXPIRED_DATE']);
        endfor;

        $array['trans'] = $queryTrans;
        $array['jenisTrans'] = $jenisTrans;
        $array['dari'] = $dari;
        $array['ke'] = $ke;
        $array['detailTrans'] = $queryDetailTrans;
        $array['listNamObat'] = $listNamObat;
        $array['listJmlObat'] = $listJmlObat;
        $array['listSatObat'] = $listSatObat;
        $array['listBatch'] = $listBatch;
        $array['listExpired'] = $listExpired;
        $this->display('acShowResultTransaksi', $array);
    }

    public function request() {
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];

        $ke= $this->mdrughc->getDataLengkapPenugasan(2, $idGedung);//get Data Gudang Obat

        $jenisTrans = $this->mdrughc->getSomeJenisTrans(11); //Permintaan Unit / Layanan ke UP Obat
        $array['jenisTransId'] = $jenisTrans[0]['ID_JENISTRANSAKSI'];
        $array['jenisTransNama'] = $jenisTrans[0]['NAMA_JENIS'];
        $array['dari_id'] = $idUnit;
        $array['dari_nama'] = $namaUnit;
        $array['ke_id'] = $ke[0]['ID_UNIT'];
        $array['ke_nama'] = $ke[0]['NAMA_UNIT'];
        $this->display('acRequestDrug', $array);
    }
    
    //function obat masuk
    public function obatMasuk($tipe, $idTransaksi = 0, $idUnitParam = 0) {
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];

        $getObat = $this->mdrughc->getObat();
        $array['allObat'] = $getObat;

        $currentJob = $this->mdrughc->getHakAkses($id_akun); //get id_unit and id_gedung user
        $ke = $this->mdrughc->getUnitFilter($idGedung);   //get id all unit except Apotik

        switch ($tipe):
            case 'daftar_pengiriman':
                $array['pengiriman'] = $this->mdrughc->getSomeTransaksiParam(array(
                    'ID_JENISTRANSAKSI' => 4,
                    'TRANSAKSI_UNIT_KE' => $idUnit,
                    'FLAG_KONFIRMASI' => 0
                ));    //Pengiriman Apotik ke Layanan / Unit
                $listPengiriman = $array['pengiriman'];
                for ($i = 0; $i < sizeof($listPengiriman); $i++) {
                    $unit[$i] = $this->mdrughc->getUnit(array('ID_UNIT' => $listPengiriman[$i]['TRANSAKSI_UNIT_DARI']));
                    $ress[$i] = $this->mdrughc->getSomeTransaksiParam(array('ID_RUJUKAN_KONFIRMASI' => $listPengiriman[$i]['ID_TRANSAKSI']));
                }
                if (isset($unit))
                    $array['unit'] = $unit;
                if (isset($ress))
                    $array['flag'] = $ress;
                $jenisTrans1 = $this->mdrughc->getSomeJenisTrans(4);    //Pengiriman Apotik ke Layanan / Unit
                $array['jenisTransNama1'] = $jenisTrans1[0]['NAMA_JENIS'];
                $this->display('acGiftList', $array);
                break;
            case 'detail':
                $ke = $this->mdrughc->getUnit(array('ID_UNIT' => $idUnitParam));
                $array['trans'] = $this->mdrughc->getSomeTransaksiParam(array('ID_TRANSAKSI' => $idTransaksi));
                $array['detTrans'] = $this->mdrughc->getDetailTransObat($idTransaksi);
                $jenisTrans = $this->mdrughc->getSomeJenisTrans(20); //Penerimaan Layanan / Unit dari Apotik
                $array['jenisLokasi'] = 'unit-unit';
                $array['jenisTransId'] = $jenisTrans[0]['ID_JENISTRANSAKSI'];
                $array['jenisTransNama'] = $jenisTrans[0]['NAMA_JENIS'];
                $array['ke_id'] = $idUnit;
                $array['ke_nama'] = $namaUnit;
                $array['dari_id'] = $ke[0]['ID_UNIT'];
                $array['dari_nama'] = $ke[0]['NAMA_UNIT'];
                $array['flag'] = $idTransaksi;   //track id permintaan
                $this->display('acGiftDrugSuccess', $array);
                break;
        endswitch;
    }
    
    //fungsi pemakaian obat
    public function obatKeluar($tipe){
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];
        
        switch ($tipe){
            case 'pemakaian':
                $jenisTrans = $this->mdrughc->getSomeJenisTrans(10); //Pemakaian
                $array['jenisTransId'] = $jenisTrans[0]['ID_JENISTRANSAKSI'];
                $array['jenisTransNama'] = $jenisTrans[0]['NAMA_JENIS'];
                $array['dari_id'] = $idUnit;
                $array['ke_id'] = $idUnit;
                $array['dari_nama'] = $namaUnit;
                $this->display('acPemakaianObat', $array);
                break;
            case 'retur':
                $ke= $this->mdrughc->getDataLengkapPenugasan(2, $idGedung);//get Data Gudang Obat
                $jenisTrans = $this->mdrughc->getSomeJenisTrans(22); //Retur Obat Unit ke Gudang Obat
                $array['jenisTransId'] = $jenisTrans[0]['ID_JENISTRANSAKSI'];
                $array['jenisTransNama'] = $jenisTrans[0]['NAMA_JENIS'];
                $array['dari_id'] = $idUnit;
                $array['dari_nama'] = $namaUnit;
                $array['ke_id'] = $ke[0]['ID_UNIT'];
                $array['ke_nama'] = $ke[0]['NAMA_UNIT'];
                $this->display('acReturObat', $array);
                break;
        }
    }
    
    public function riwayatObat($tipe, $startRow=0){
        $this->title="";
        $id_hakakses= $this->session->userdata['telah_masuk']["idha"];
        $id_akun= $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses= $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit= $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit= $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung= $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung= $this->session->userdata['telah_masuk']['namagedung'];
        switch ($tipe):
            case 'masuk':
                $array['jenisTransNama']= 'Riwayat Obat Masuk';
                $url= $this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$this->uri->segment(4, 0);
                $perPage= 10;
                $total_rows= $this->mdrughc->getRiwayatObatMasukCount($id_hakakses, $idUnit);
                $pagination= $this->init_pagination($url,$total_rows,$perPage,5);
                $array['dataTrans']= $this->mdrughc->getRiwayatObatMasuk($id_hakakses, $idUnit, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('riwayatObat', $array);
                break;
            case 'minta':
                $array['jenisTransNama']= 'Riwayat Obat Minta';
                $url= $this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$this->uri->segment(4, 0);
                $perPage= 10;
                $total_rows= $this->mdrughc->getRiwayatObatMintaCount($id_hakakses, $idUnit);
                $pagination= $this->init_pagination($url,$total_rows,$perPage,5);
                $array['dataTrans']= $this->mdrughc->getRiwayatObatMinta($id_hakakses, $idUnit, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('riwayatObat', $array);
                break;
            case 'pemakaian':
                $array['jenisTransNama']= 'Riwayat Pemakaian Obat';
                $url= $this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$this->uri->segment(4, 0);
                $perPage= 10;
                $total_rows= $this->mdrughc->getRiwayatPemakaianObatCount($idUnit);
                $pagination= $this->init_pagination($url,$total_rows,$perPage,5);
                $array['dataTrans']= $this->mdrughc->getRiwayatPemakaianObat($idUnit, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('riwayatObat', $array);
                break;
            case 'retur':
                $array['jenisTransNama']= 'Riwayat Retur Obat';
                $url= $this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$this->uri->segment(4, 0);
                $perPage= 10;
                $total_rows= $this->mdrughc->getRiwayatReturObatCount($idUnit);
                $pagination= $this->init_pagination($url,$total_rows,$perPage,5);
                $array['dataTrans']= $this->mdrughc->getRiwayatReturObat($idUnit, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('riwayatObat', $array);
                break;
        endswitch;
    }
    
    public function init_pagination($url,$total_rows,$per_page,$segment){
        $config['base_url'] = base_url().$url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = $segment;
        $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_link'] = '&lt;&lt; Pertama';
        $config['last_link'] = 'Terakhir &gt;&gt;';
        $this->pagination->initialize($config);
        return $config;   
    }

    //function add resep pasien
    public function addResepPasien() {
        $id_akun= $this->session->userdata['telah_masuk']["idakun"];
        $idUnit= $this->session->userdata['telah_masuk']['idunit'];
        
        $penugasan= $this->mdrughc->getPenugasan($id_akun, $idUnit);
        $tanggalTransaksi= $this->convert($this->input->post('transaksi'));
        $tanggalRekapTransaksi= $this->convert($this->input->post('transaksi_now'));
        $listKode= json_decode($this->input->post('total_kodeObat'));
        $listJmlSehari = json_decode($this->input->post('total_jumlahSehari'));
        $listLamaHari = json_decode($this->input->post('total_lamaHari'));
        $listDeskObat = json_decode($this->input->post('total_deskripsiObat'));
        $listSigna= json_decode($this->input->post('total_signa'));
        $idRiwayatRM= $this->input->post('id_riwayat_rm');
        
        $jenisTransaksi= $this->input->post('jenis_transaksi');
            $param1= 'TRANSAKSI_UNIT_DARI';
            $param2= 'TRANSAKSI_UNIT_KE';
            
        $data = array(
            'ID_PENUGASAN' => $penugasan[0]['ID_PENUGASAN'],
            'ID_RIWAYAT_RM' => $idRiwayatRM,
            'ID_JENISTRANSAKSI' => $jenisTransaksi,
            'TANGGAL_TRANSAKSI' => $tanggalTransaksi,
            'TANGGAL_REKAP_TRANSAKSI' => $tanggalRekapTransaksi,
            $param1 => $this->input->post('dari'),    //unit
            $param2 => $this->input->post('ke'),   //unit
            'FLAG_KONFIRMASI' => $this->input->post('flag_konfirmasi')
        );
        $lastID= $this->mdrughc->insertAndGetLast('transaksi_obat', $data);
        
        for($i=0; $i<sizeof($listKode); $i++):
            $listJml = $listJmlSehari[$i] * $listLamaHari[$i];
            $data_obat= array(
                'ID_TRANSAKSI'=> $lastID,
                'ID_OBAT'=> $listKode[$i],
                'JUMLAH_OBAT'=> $listJml,
                'ID_UNIT'=> $idUnit
            );
            $lasIdDetail= $this->mdrughc->insertAndGetLast('detil_transaksi_obat', $data_obat);
            
            $data2 = array(
                'ID_RIWAYAT_RM' => $idRiwayatRM,
                'ID_AKUN' => $id_akun,
                'ID_DETIL_TO' => $lasIdDetail,
                'DESKRIPSI_OP' => $listDeskObat[$i],
                'JUMLAH_SEHARI' => $listJmlSehari[$i],
                'LAMA_HARI' => $listLamaHari[$i],
                'SIGNA'=>$listSigna[$i]
            );
            $this->mdrughc->insert('obat_pasien', $data2);
        endfor;
        
        redirect(base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/showTransResep/'.$lastID.'/'.$idRiwayatRM);
    }

    //function show transkrip resep pasien
    public function showTransResep($idTransaksi, $idRiwayatRm) {
        $queryTrans = $this->mdrughc->getSomeTransaksi($idTransaksi);
        $jenisTrans = $this->mdrughc->getSomeJenisTrans($queryTrans[0]['ID_JENISTRANSAKSI']);
        $rekamedik = $this->mdental->getRiwayatRMById($idRiwayatRm);

        $listNamObat = array();
        $listJmlObat = array();
        $listSatObat = array();
        $listJmlSehari = array();
        $listLamaHari = array();
        $listSigna = array();
        $listDeskObat = array();
        $queryDetailTrans = $this->mdrughc->getSomeDetailTrans($idTransaksi);
        for ($i = 0; $i < sizeof($queryDetailTrans); $i++):
            $getObat = $this->mdrughc->getSomeObat($queryDetailTrans[$i]['ID_OBAT']);
            array_push($listNamObat, $getObat[0]['NAMA_OBAT']);
            array_push($listJmlObat, $queryDetailTrans[$i]['JUMLAH_OBAT']);
            array_push($listSatObat, $getObat[0]['SATUAN']);
            $idDetilTo = $queryDetailTrans[$i]['ID_DETIL_TO'];
            $queryDetailObatPasien = $this->mdental->getSomeObatPasien($idDetilTo);
            array_push($listJmlSehari, $queryDetailObatPasien[0]['JUMLAH_SEHARI']);
            array_push($listLamaHari, $queryDetailObatPasien[0]['LAMA_HARI']);
            array_push($listDeskObat, $queryDetailObatPasien[0]['DESKRIPSI_OP']);
            array_push($listSigna, $queryDetailObatPasien[0]['SIGNA']);
        endfor;

        $array['namaPasien'] = $rekamedik[0]['NAMA_PASIEN'];
        $array['trans'] = $queryTrans;
        $array['jenisTrans'] = $jenisTrans;
        $array['detailTrans'] = $queryDetailTrans;
        $array['listNamObat'] = $listNamObat;
        $array['listJmlObat'] = $listJmlObat;
        $array['listSatObat'] = $listSatObat;
        $array['listJmlSehari'] = $listJmlSehari;
        $array['listLamaHari'] = $listLamaHari;
        $array['listDeskObat'] = $listDeskObat;
        $array['listSigna'] = $listSigna;
        $this->display('acShowResultTransaksiResep', $array);
    }

    //function show riwayat pasien
    public function receipt($tipe, $param1 = null, $param2 = null) {
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];

        switch ($tipe) {
            case 'listPasien':
                $this->display('acListPasien');
                break;
            case 'detailRiwayat':
                $array['namaPasien'] = $this->mdental->getTable('pasien', array('ID_PASIEN' => $param1));
                $url= $this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$this->uri->segment(4, 0).'/'.$this->uri->segment(5, 0);
                $perPage= 10;
                $total_rows= $this->mdental->getRiwayatResepCount($param1);
                $pagination= $this->init_pagination($url,$total_rows,$perPage,6);
                $array['riwayat'] = $this->mdental->getRiwayatResep($param1, $this->uri->segment(6, 0), $perPage);
                $array["links"] = $this->pagination->create_links();
                $ke = $this->mdrughc->getDataLengkapPenugasan(3, $idGedung);    //get id Apotik
                $tebusan = $this->mdental->getTebusanObat($param1, $ke[0]['ID_UNIT']); 
                for ($i = 0; $i < sizeof($tebusan); $i++) {
                    $flag_tebusan[$tebusan[$i]['ID_RIWAYAT_RM']] = $tebusan[$i]['ID_TRANSAKSI'];
                }
                if (isset($flag_tebusan))
                    $array['tebusan'] = $flag_tebusan;
                $array['idPasien'] = $param1;
                $this->display('acListRiwayat', $array);
                break;
            case 'addResep':
                $array['namaPasien'] = $this->mdental->getTable('pasien', array('ID_PASIEN' => $param2));
                $ke = $this->mdrughc->getDataLengkapPenugasan(3, $idGedung);    //get id Apotik
                $jenisTrans = $this->mdrughc->getSomeJenisTrans(16); //Resep Obat Pasien
                $array['jenisTransId'] = $jenisTrans[0]['ID_JENISTRANSAKSI'];
                $array['jenisTransNama'] = $jenisTrans[0]['NAMA_JENIS'];
                $array['dari_id'] = $idUnit;
                $array['dari_nama'] = $namaUnit;
                $array['ke_id'] = $ke[0]['ID_UNIT'];
                $array['ke_nama'] = $ke[0]['NAMA_UNIT'];
                $this->display('acAddResep', $array);
                break;
        }
    }
    
    function searchObatMaster(){
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');

        $teks = $data['tanda'];
        $temp1= $this->mdrughc->getSomeObatComplexParam($teks);
        $data["submit"] = $this->getPivotObatMaster($temp1);
        return $data["submit"];
    }
    
    private function getPivotObatMaster($data) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        $header = "[[";
        foreach ($data as $value) {
            $header .= '"NOMOR"';
            foreach ($value as $key => $sembarang) {
                    $header .= ',"' . str_replace("_", " ", strtoupper($key)) . '"';
            }
            $header .= ",\"KELOLA\"]";
            break;
        }
        $counter = 1;
        foreach ($data as $value) {
            $header .= ",[";
            $header .= '"'.$counter.'"';
            $counter++;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                $header .= ',"' . $data . '"';
            }
            $header .= ',"<button data-toggle=\"modal\" href=\"#myModal\" onclick=\"setObat(\''.$value->ID_OBAT.'\',\''.$this->replaceString($value->NAMA_OBAT).'\',\''.$value->SATUAN.'\')\" class=\"btn btn-primary\">Pilih</button>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }
    
    private function replaceString($input) {
        $output = str_replace("\"", "\\\"", $input);
        $output = str_replace("\'", "\\\'", $output);
        return $output;
    }

    function searchObat($idUnit, $tipe=null) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');

        $teks = $data['tanda'];
        $temp1 = $this->mdrughc->getAllStok($idUnit, $teks);
        $data["submit"] = $this->getPivotObat($temp1, $tipe);
        return $data["submit"];
    }

    private function getPivotObat($data, $tipe) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        $header = "[[";
        foreach ($data as $value) {
            $header .= '"NOMOR"';
            foreach ($value as $key => $sembarang) {
                    $header .= ',"' . str_replace("_", " ", strtoupper($key)) . '"';
            }
            $header .= ",\"KELOLA\"]";
            break;
        }
        $counter = 1;
        foreach ($data as $value) {
            $header .= ",[";
            $header .= '"'.$counter.'"';
            $counter++;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                $header .= ',"' . $data . '"';
            }
            $mydate2 = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
            $mydate1 = DateTime::createFromFormat('Y-m-d', $value->EXPIRED_DATE);
            $disabled= '';
            $btnName= 'Pilih';
            $btnColor= 'primary';
            if($mydate1 <= $mydate2 && $tipe!='retur') {
                $disabled= 'disabled';
                $btnName= 'Expired';
                $btnColor= 'danger';
            }
            $header .= ',"<button '.$disabled.' data-toggle=\"modal\" href=\"#myModal\" onclick=\"setObat(\'' . $value->ID_DETIL_TO . '\',\'' . $value->ID_OBAT . '\',\'' . $value->NOMOR_BATCH . '\',\'' . $this->replaceString($value->NAMA_OBAT) . '\',\'' . $value->STOK . '\',\'' . $value->SATUAN . '\',\'' . $value->EXPIRED_DATE . '\')\" class=\"btn btn-'.$btnColor.'\">'.$btnName.'</button>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }
    
    function searchObatBuang($idUnit) { //search obat yang akan dibuang
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');

        $teks = $data['tanda'];
        $temp1 = $this->mdrughc->getAllStok($idUnit, $teks);
        $data["submit"] = $this->getPivotObatBuang($temp1);
        return $data["submit"];
    }

    private function getPivotObatBuang($data) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        $header = "[[";
        foreach ($data as $value) {
            $header .= '"NOMOR"';
            foreach ($value as $key => $sembarang) {
                    $header .= ',"' . str_replace("_", " ", strtoupper($key)) . '"';
            }
            $header .= ",\"KELOLA\"]";
            break;
        }
        $counter = 1;
        foreach ($data as $value) {
            $header .= ",[";
            $header .= '"'.$counter.'"';
            $counter++;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                    $header .= ',"' . $data . '"';
            }
            $header .= ',"<button data-toggle=\"modal\" href=\"#myModal\" onclick=\"setObat(\'' . $value->ID_DETIL_TO . '\',\'' . $value->ID_OBAT . '\',\'' . $value->NOMOR_BATCH . '\',\'' . $value->NAMA_OBAT . '\',\'' . $value->STOK . '\',\'' . $value->SATUAN . '\',\'' . $value->EXPIRED_DATE . '\')\" class=\"btn btn-primary\">Pilih</button>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }

    function showResepPasien() {
        $id_unit = $this->session->userdata['telah_masuk']['idunit'];
        $data = $this->mMRHistory->getResepPasien($id_unit);
        echo $this->getResepPasien($data);
    }

    private function getResepPasien($data) {
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
            $header .= ",\"RIWAYAT RESEP\",\"BUAT RESEP\"";
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
            $header .= ',"<a type=\"button\" style=\"color: white\" href=\"' . base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/receipt/detailRiwayat/' . $value['id_pasien'] . '\" class=\"btn btn-warning\">Lihat</a>"';
            $header .= ',"<a type=\"button\" style=\"color: white\" href=\"' . base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/receipt/addResep/' . $value['id_riwayat_rm'] . '/' . $value['id_pasien'] . '\" class=\"btn btn-primary\">Buat Baru</a>"';
            $header .= "]";
        }
        $header .= "]";
        return $header;
    }
	
	function removeDataAntrian () {
		$form_data = $this->input->post(null, true);		
		$this->db->trans_start();
		$this->mQueue->removeEntry ($form_data['id_antrian']);
		$this->mMRHistory->removeEntry ($form_data['id_rrm']);		
		$this->db->trans_complete();	
		if ($this->db->trans_status() === true) {
			echo json_encode($form_data);
		}
	}
}
