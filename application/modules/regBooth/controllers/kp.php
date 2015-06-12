<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Kp extends kpController {

	private $home;
	
	public function __construct () {
		parent::__construct ();
        $this->top_navbar = 'lay-top-navbar/kpNavbar';
        $this->load->model('Unit_model');
        $this->load->model('ri_model');
		$this->load->model('status_queue_model');
	}
	
	public function index () {
		redirect ($this->home."oldPatient");
	}
	
	private function _getFormFill (){
		$data = array (
				"error_msg" =>$this->session->flashdata('error'),
				"payment" =>$this->mPaymentSource->getAllEntry (),
				"units" =>$this->mUnit->getUnitByHC ()
		);
		return $data;
	}
	
	public function patientRI () {
		$this->display('queueKpRI');
	}
	
	
	function showRI () {
		$puskesmas = $this->input->post('puskesmas');
		$tanggal = $this->input->post('tanggal');
		$result = $this->ri_model->getRIPatientKD ($puskesmas,$tanggal);
		if ($result) 
		echo $this->getPivotAntrian ($result);
		else echo "[[\"NIK\",\"NAMA PASIEN\", \"UMUR\", \"JENIS KELAMIN\", \"TANGGAL MASUK\", \"TANGGAL_KELUAR\"], [\"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\"]]";
	}
	
	// halaman pasien lama
	public function oldPatient () {
		$data = $this->_getFormFill();
		$data['allPasien'] = $this->mPatient->getAllEntry ();		
		$this->display ('home', $data);
	}
	
	public function showOldPatients () {
		$data = $this->mPatient->getAllEntry ();
		echo $this->getPivot ($data);
	}
	
	private function renameHeader ($headerName) {
		$headerName = str_replace("_", " ", strtoupper($headerName));
		switch ($headerName) {
			case "NOID PASIEN":
				$headerName = "NIK";
			break;
			
			default:
			break;
		}
		return $headerName;
	}
	
	private function getPivot($data) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        $header = "[[";
        foreach ($data as $value) {
            foreach ($value as $key => $sembarang) {
                $header .= '"' . str_replace("_", " ", strtoupper($key)) . '"';
                break;
            }
            $count = 1;
            foreach ($value as $key => $sembarang) {
                if ($count > 1) {
                    $header .= ',"' . str_replace("_", " ", strtoupper($key)) . '"';
                }
                $count ++;
            }
            $header .= "]";
            break;
        }
        $vartemp="";
        foreach ($data as $value) {
            $header .= ",[";
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
//                if ($key == "ID_ICD") {
//                    $header .= '"<a href=\'' . base_url() . 'index.php/linknya/disini/lho/' . $value->ID_ICD.'/'.$value->CATEGORY.'/'.$value->SUBCATEGORY.'/'.$value->ENGLISH_NAME.'/'.$value->INDONESIAN_NAME. '\'>' . $data . '</a>"';
//                }
//                else {
                    $header .= '"' . $data . '"';
//                }
                break;
            }
            $count = 1;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                if ($count > 1) {
//                    if ($key == "ID_ICD") {
//                        $header .= '"<a href=\'' . base_url() . 'index.php/linknya/disini/lho/' . $value->ID_ICD.'/'.$value->CATEGORY.'/'.$value->SUBCATEGORY.'/'.$value->ENGLISH_NAME.'/'.$value->INDONESIAN_NAME. '\'>' . $data . '</a>"';
//                    }
//                    else {
                        $header .= ',"' . $data . '"';
//                    }
                    
                }
                $count ++;
            }
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }
	
	// halaman pendaftaran pasien baru
	public function newPatient () {
		$data = $this->_getFormFill();
		$this->display ('patient', $data);
	}
	
	// halaman antrian pasien
	public function queue () {
		$data['units'] = $this->Unit_model->getUnitByHC ();
		$this->display('queueKp', $data);
	}
	
	function showQueueUnit () {
		$unit = $this->input->post('unit');
		$tanggal = $this->input->post('tanggal');
		$result = $this->status_queue_model->getQueueByUnit ($unit, $this->session->userdata['telah_masuk']['idgedung'], $tanggal);
		if ($result) 
		echo $this->getPivot ($result);
		else echo "[[\"NOMOR ANTRIAN\",\"NIK\", \"NAMA PASIEN\", \"WAKTU ANTRIAN UNIT\", \"STATUS ANTRI\"], [\"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\"]]";
	}
	
	// halaman laporan
	public function report () {
		$this->display('report');
	}
	
	public function update () {
		$form_data = $this->input->post (null, true);
		checkIfEmpty ($form_data, $this->home);
	
		$id = $form_data['selectedIdPasien'];
		$data =  array (
				'nama_pasien' => $form_data['selectedNamaPasien'],
				'alamat_pasien' => $form_data['selectedAlamatPasien'],
				'telepon_pasien' => $form_data['selectedTeleponPasien1'],
				'telepon2_pasien' => $form_data['selectedTeleponPasien2'],
				'gender_pasien' => $form_data['selectedGenderPasien'],
				'agama_pasien' => $form_data['selectedAgamaPasien'],
				'gol_darah_pasien' => $form_data['selectedDarahPasien'],
				'nama_kk_pasien' => $form_data['selectedNomorKKPasien'],
				'kelurahan_pasien' => $form_data['selectedKelurahanPasien'],
				'kecamatan_pasien' => $form_data['selectedKecamatanPasien'],
				'pendidikan_pasien' => $form_data['selectedPendidikanPasien'],
				'tgl_lahir_pasien' => $form_data['selectedTanggalLahirPasien']
		);
		$this->_setFlashData($this->mPatient->updateEntry ($data, $id));
		redirect ($this->home."oldPatient");
	
	}
	
	public function remove () {
		$form_data = $this->input->post (null, true);
		$this->_setFlashData($this->mPatient->removeEntryById ($form_data['selected']));
		redirect ($this->home."oldPatient");
	}
	
	// Registrasi Pasien Baru
	// Buat Buku Rekam Medik
	// Buat Riwayat RM 
	// Masuk ke Antrian
	public function newRegistration () {
		$form_data = $this->input->post (null, true);	
		checkIfEmpty ($form_data, $this->home);		
		
		$data =  array (
			'noid_pasien' => $form_data['idPasien'],
			'nama_pasien' => $form_data['namaPasien'],
			'alamat_pasien' => $form_data['alamatPasien'],
			'telepon_pasien' => $form_data['telepon1Pasien'],
			'telepon2_pasien' => $form_data['telepon2Pasien'],
			'gender_pasien' => $form_data['genderPasien'],
			'agama_pasien' => $form_data['agamaPasien'],
			'gol_darah_pasien' => $form_data['darahPasien'],
			'nama_kk_pasien' => $form_data['namaKKPasien'],
			'kelurahan_pasien' => $form_data['kelurahanPasien'],
			'kecamatan_pasien' => $form_data['kecamatanPasien'],
			'pendidikan_pasien' => $form_data['pendidikanPasien'],
			'tgl_lahir_pasien' => $form_data['tanggalLahirPasien'],
			'tempat_lahir_pasien' => $form_data['tempatLahirPasien'],
			'hub_keluarga_pasien' => $form_data['hubunganPasien'],
			'pekerjaan_pasien' => $form_data['pekerjaanPasien'],
			'rt_pasien' => $form_data['rtPasien'],
			'rw_pasien' => $form_data['rwPasien'],
			'kota_pasien' => $form_data['kotaPasien'],
			'no_kesehatan_pasien' => $form_data['noKesehatanPasien']
		);
		
		$result = $this->mPatient->insertNewEntry ($data,
			$form_data['pembayaranPasien'],
			$form_data['pelayananPasien']
		);			
		$this->_setFlashData($result);		
		redirect ($this->home."newPatient");
	}		
	
	public function oldRegistration () {
		$form_data = $this->input->post (null, true);
		checkIfEmpty ($form_data, $this->home);
		 
		//var_dump ($form_data);
		// get id rekam medik
		$id = $this->mMedicalRecord->getMRbyId ($form_data['no']);
		$MRId = $id[0]['ID_REKAMMEDIK'];
		 
		// create RM
		$med_record_history = array (
				'id_rekammedik' => $MRId,
				'id_sumber' => $form_data['pembayaranPasien'],
				'tanggal_riwayat_rm' => date('Y-m-d')
		);
		
		//var_dump ($med_record_history);
		
		$last_medHistoryId = $this->mMRHistory->insertNewEntry ($med_record_history, $form_data['pelayananPasien']);
		
		 
		// $data_queue = array (
				// 'id_unit' => $form_data['pelayananPasien'],
				// 'id_riwayat_rm' => $last_medHistoryId,
				// 'waktu_antrian_unit' => date('Y-m-d H:i:s')
		// );
		// // masuk antrian
		// $this->_setFlashData($this->mQueue->insertNewEntry($data_queue));
		redirect ($this->home);
	}
	
	
	function clean($string) {
			return preg_replace('/[^A-Za-z0-9\-@ .,]/', '-', $string); // Removes special chars.
		}
	
	private function getPivotAntrian($data) {
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
				$header .= $this->renameHeaderAntrian($key) . '"';
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
				}
				else $header .= ',"';
				$header .= $data . '"';                
            }
            $header .= "]";
        }
        $header .= "]";		
        return $header;
    }
	
	private function renameHeaderAntrian ($headerName) {
		$headerName = str_replace("_", " ", strtoupper($headerName));
		switch ($headerName) {
			case "NOID PASIEN":
				$headerName = "NIK";
			break;
			case "ID ANTRIAN UNIT":
				$headerName = "NOMOR ANTRIAN";
			break;
			case "WAKTU ANTRIAN UNIT":
				$headerName = "WAKTU ANTRIAN";
			break;
			default:
			break;
		}
		return $headerName;
	}
	
	
	
}