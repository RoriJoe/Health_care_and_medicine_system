<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Lp extends lpController {

	private $home;
	
	public function __construct () {
		parent::__construct ();
		$this->home = base_url().'regBooth/lp/';	
	}
	
	public function index () {
		redirect ($this->home."oldPatient");
	}
	
	public function convert($date) {
        $mydate = date_create_from_format('d-m-Y', $date);
        return date_format($mydate, 'Y-m-d');
    }
	
	public function convert_reverse($date) {
        $mydate = date_create_from_format('Y-m-d', $date);
        return date_format($mydate, 'd-m-Y');
    }
	
	private function _getFormFill (){
		$data = array (
				"error_msg" =>$this->session->flashdata('error'),
				"payment" =>$this->mPaymentSource->getAllEntry (),
				"units" =>$this->mUnit->getUnitByHC ()
		);
		return $data;
	}
	
	// halaman pasien lama
	public function oldPatient () {
		$data = $this->_getFormFill();
		$this->output->cache(10);		
		$this->display ('home', $data);
	}
	
	public function showOldPatients () {
		$namaGedung = $this->session->userdata['telah_masuk']['namagedung'];
		$temp = explode ('Puskesmas ', $namaGedung);
		$namaPuskesmas = strtoupper($temp[1]);					
		$nomorPuskesmas = $this->mUnit->getNomorUrutPuskesmas ($namaPuskesmas);				
		
		$data = $this->mPatient->getAllPatientByUrutPuskesmas ($nomorPuskesmas);
		if ($data) echo $this->getPivot ($data);
	}
	
	private function renameHeader ($headerName) {
		$headerName = str_replace("_", " ", strtoupper($headerName));
		switch ($headerName) {
			case "NOID PASIEN":
				$headerName = "NOMOR IDENTITAS";
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
			$header .= ",\"PILIH\"";
			$header .= ",\"UBAH\"";
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
			$header .= ',"<a style=\"color: white\" type=\"button\" data-toggle=\"modal\" class=\"btn btn-xs btn-success\" onclick=\"antriPasien(\''.$value['ID_PASIEN'].'\',\''.$value['NOID_PASIEN'].'\',\''.$value['NAMA_PASIEN'].'\',\''.$value['GENDER_PASIEN'].'\',\''.$value['TEMPAT_LAHIR_PASIEN'].'\',\''.$this->convert_reverse($value['TGL_LAHIR_PASIEN']).'\',\''.$value['ALAMAT_PASIEN'].'\',\''.$value['RT_PASIEN'].'\',\''.$value['RW_PASIEN'].'\',\''.$value['KELURAHAN_PASIEN'].'\',\''.$value['KECAMATAN_PASIEN'].'\',\''.$value['KOTA_PASIEN'].'\',\''.$value['NO_KESEHATAN_PASIEN'].'\')\"><i class=\"fa fa-check\"></i></a>"';	
			
			$header .= ',"<a style=\"color: white\" type=\"button\" data-toggle=\"modal\" href=\"#editModal\" class=\"btn btn-xs btn-warning\" onclick=\"editPatient(\''.$value['ID_PASIEN'].'\',\''.$value['NOID_PASIEN'].'\',\''.$value['NAMA_PASIEN'].'\',\''.$value['GENDER_PASIEN'].'\',\''.$value['TEMPAT_LAHIR_PASIEN'].'\',\''.$this->convert_reverse($value['TGL_LAHIR_PASIEN']).'\',\''.$value['ALAMAT_PASIEN'].'\',\''.$value['RT_PASIEN'].'\',\''.$value['RW_PASIEN'].'\',\''.$value['KELURAHAN_PASIEN'].'\',\''.$value['KECAMATAN_PASIEN'].'\',\''.$value['KOTA_PASIEN'].'\',\''.$value['NO_KESEHATAN_PASIEN'].'\',\''.$value['TELEPON_PASIEN'].'\',\''.$value['TELEPON2_PASIEN'].'\',\''.$value['NAMA_KK_PASIEN'].'\',\''.$value['PENDIDIKAN_PASIEN'].'\',\''.$value['GOL_DARAH_PASIEN'].'\',\''.$value['AGAMA_PASIEN'].'\')\"><i class=\"fa fa-edit\"></i></a>"';
            $header .= "]";
			$counter++;
        }
        $header .= "]";
        return $header;
    }
	
	// halaman pendaftaran pasien baru
	public function newPatient () {
		$data = $this->_getFormFill();		
		$data['nomor_index'] = $this->getNomorIndex();
		$data['desa'] = $this->mUnit->getAllDesa ();
		$this->output->cache(10);
		$this->display ('patient', $data);
	}
	
	public function getNomorIndex () {
		$nomorIndex = '000000-';
		
		$namaGedung = $this->session->userdata['telah_masuk']['namagedung'];
		$temp = explode ('Puskesmas ', $namaGedung);
		$namaPuskesmas = strtoupper($temp[1]);	
				
		$nomorPuskesmas = $this->mUnit->getNomorUrutPuskesmas ($namaPuskesmas);
		$data = $this->mPatient->getAllPatientByUrutPuskesmas ($nomorPuskesmas);
		$jumlah_data = (string)(count($data)+1);
		while (strlen($jumlah_data) < 5) {
			$jumlah_data = '0'.$jumlah_data;
		}
		$nomorIndex .= $jumlah_data;
		
		if (!$nomorPuskesmas) $nomorPuskesmas = '0';
		if ($nomorPuskesmas < 10) $nomorPuskesmas = '0'. $nomorPuskesmas;		
		$nomorIndex = substr_replace($nomorIndex,$nomorPuskesmas,0,2);
		return $nomorIndex;
	}
	
	// halaman antrian pasien
	public function queue () {
		$data['units'] = $this->mUnit->getUnitByHC ();
		$this->display('queue', $data);
	}
	
	function showQueueUnit () {
		$form_data = $this->input->post(null, true);
		$result = $this->mQueue->getQueueByUnit ($form_data);
		if ($result) echo $this->getPivotAntrian ($result);
	}
	
	// halaman laporan
	public function report () {
		$this->display('report');
	}
	
	public function update () {
		$form_data = $this->input->post (null, true);
		checkIfEmpty ($form_data, $this->home);

		$id = $form_data['idpasien'];
		$data =  array (
                                'noid_pasien' =>$form_data['selectedIdPasien'],
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
				'tgl_lahir_pasien' => $this->convert($form_data['selectedTanggalLahirPasien'])
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
		$s = $this->input->post('tanggalAntrian').' '.$this->input->post('waktuAntrian');
		$date = strtotime($s);
		$waktuantrian = date('Y-m-d H:i:s', $date);
		$form_data = $this->input->post (null, true);	
		checkIfEmpty ($form_data, $this->home);		
		
		$temp = explode('-', $form_data['noKesehatanPasien']);
		$noIndex = $temp[0].'-';
		
		if ($form_data['tanggalLahirPasien'] != '') {
			$tglLahir = $this->convert($form_data['tanggalLahirPasien']);
		}
		else $tglLahir = '0000-00-00';
		
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
			'tgl_lahir_pasien' => $tglLahir,
			'tempat_lahir_pasien' => $form_data['tempatLahirPasien'],
			'hub_keluarga_pasien' => $form_data['hubunganPasien'],
			'pekerjaan_pasien' => $form_data['pekerjaanPasien'],
			'rt_pasien' => $form_data['rtPasien'],
			'rw_pasien' => $form_data['rwPasien'],
			'kota_pasien' => $form_data['kotaPasien'],
			'no_kesehatan_pasien' => $form_data['noKesehatanPasien']
		);
		
		$mydate1 = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
		$mydate2 = DateTime::createFromFormat('Y-m-d', $tglLahir);
		
		$this->db->trans_start();
		
		$last_inserted_pid = $this->mPatient->insertNewEntry($data);
		$med_record = array (
			'id_pasien' => $last_inserted_pid,
			'tanggal_buat_rm' => date('Y-m-d'),
			'noid_rekammedik' => $form_data['noKesehatanPasien']
		);
		$last_med_id = $this->Mr_model->insertNewEntry ($med_record);
		$med_record_history = array (
			'id_rekammedik' => $last_med_id,
			'id_sumber' => $form_data['pembayaranPasien'],
			'tanggal_riwayat_rm' => date('Y-m-d'),
			'umur_saat_ini' => diffInMonths ($mydate1, $mydate2),
			'session_kunjungan' => date('d-m-Y H:i:s')
		);
		
		$last_medHistoryId = $this->Mrh_model->insertNewEntry ($med_record_history);
		$data_queue = array (
				'id_unit' => $form_data['pelayananPasien'],
				'id_riwayat_rm' => (string)$last_medHistoryId,
				'waktu_antrian_unit' => $waktuantrian,
				'flag_antrian_unit' => 0,
				'flag_intern' => 0		
		);
		if (isset($form_data['subUnitPelayanan'])) {
			$data_queue['sub_kia'] = $form_data['subUnitPelayanan'];
		}		
		$this->Queue_model->insertNewEntry($data_queue);
		$this->db->trans_complete();		
		$this->_setFlashData($this->db->trans_status());		
		redirect ($this->home."newPatient");
	}		
	
	public function oldRegistration () {
		$s = $this->input->post('tanggalAntrian').' '.$this->input->post('waktuAntrian');
		$date = strtotime($s);
		$waktuantrian = date('Y-m-d H:i:s', $date);
		$form_data = $this->input->post (null, true);
		checkIfEmpty ($form_data, $this->home);
		 
		// get id rekam medik
		$id = $this->mMedicalRecord->getMRbyId ($form_data['no']);
		$MRId = $id[0]['ID_REKAMMEDIK'];
		 
		// create RM
		$mydate1 = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
		$mydate2 = DateTime::createFromFormat('Y-m-d', $form_data['tanggal']);
		
		$med_record_history = array (
				'id_rekammedik' => $MRId,
				'id_sumber' => $form_data['pembayaranPasien'],
				'tanggal_riwayat_rm' => date('Y-m-d'),
				'umur_saat_ini' => diffInMonths ($mydate1, $mydate2),
				'session_kunjungan' => date('d-m-Y H:i:s')
		);
		
		$this->db->trans_start();
		
		$last_medHistoryId = $this->Mrh_model->insertNewEntry ($med_record_history);
		$data_queue = array (
				'id_unit' => $form_data['pelayananPasien'],
				'id_riwayat_rm' => (string)$last_medHistoryId,
				'waktu_antrian_unit' => $waktuantrian,
				'flag_antrian_unit' => 0,
				'flag_intern' => 0
		);
		if (isset($form_data['subUnitPelayanan'])) {
			$data_queue['sub_kia'] = $form_data['subUnitPelayanan'];
		}		
		$result = $this->Queue_model->insertNewEntry($data_queue);
		
		$this->db->trans_complete();
		$this->_setFlashData($this->db->trans_status());
		redirect ($this->home);
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
				$headerName = "NOMOR IDENTITAS";
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
	
	public function setKecamatan () {
		$id = $this->input->post('id');		
		$kecamatan = $this->mUnit->getKecamatanByDesa($id);
		echo json_encode ($kecamatan);
	}
	
}