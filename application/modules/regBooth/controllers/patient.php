<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Patient extends lpController {
	
	private $home;
	
	public function __construct () {
		parent::__construct ();
		$this->theme_folder='newui';
        $this->top_navbar = 'lay-top-navbar/navbar_lp';
		$this->script_footer = 'lay-scripts/footer_lp';
		$this->home = base_url().'regBooth/patient/';
		$this->load->model ('mPatient');
		$this->load->model ('mMedicalRecord');
		$this->load->model ('mPaymentSource');
		$this->load->model ('mMRHistory');
		$this->load->model ('mUnit');
		$this->load->model ('mQueue');
	}
	
	public function index () {		
		$data['error_msg'] = $this->session->flashdata('error') ;
		$data['payment'] = $this->mPaymentSource->getAllEntry();
		$data['units'] = $this->mUnit->getUnitByHC ();
		$this->display ('patient', $data);
	}
		
	// Registrasi Pasien Baru
	// Buat Buku Rekam Medik
	// Buat Riwayat RM 
	// Masuk ke Antrian
	public function registration () {
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
		
		// last inserted patient id
		$last_id = $this->mPatient->insertNewEntry ($data);	
		
		// create medical record book
		$med_record = array (
			'id_pasien' => $last_id
		);
		$last_med_id = $this->mMedicalRecord->insertNewEntry ($med_record);	
		
		// create riwayat rm
		$med_record_history = array (
			'id_rekammedik' => $last_med_id,
			'id_sumber' => $form_data['pembayaranPasien'],
			'tanggal_riwayat_rm' => date('Y-m-d')
		);
		$last_medHistoryId = $this->mMRHistory->insertNewEntry ($med_record_history);		
		
		$data_queue = array (
			'id_unit' => $form_data['pelayananPasien'],
			'id_riwayat_rm' => $last_medHistoryId,
			'waktu_antrian_unit' => date('Y-m-d H:i:s')
		);
		// masuk antrian
		$this->_setFlashData($this->mQueue->insertNewEntry($data_queue));		
		redirect ($this->home);
	}
	
	private function _setFlashData ($status) {        
        $key = 'error';
        if ($status == true)
            $message = 'success';
        else $message = 'failed';
            
        $this->session->set_flashdata ($key, $message);        
        redirect ($this->home);
    } 
	
}