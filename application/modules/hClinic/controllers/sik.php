<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class sik extends sikController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->top_navbar = 'lay-top-navbar/sikNavbar';
        $this->load->model('pPuskesmas');
        $this->load->model('uhcmodel');
        $this->load->model('kpapgfk_available');
        $this->load->model('assignment');
        /*
        $this->theme_layout = 'template_login';
        $this->script_header = 'lay-scripts/header_login';
        $this->script_footer = 'lay-scripts/footer_login';
        $this->load->model('login/mLogin');*/
    }

    //halaman tambah unit
    public function index() {
		redirect( base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/createPuskesmas');
        //$this->display('pInsert',$data);
    }
    
    function createPuskesmas()
    {
        $this->title="";
        $data['allPuskesmas'] = $this->pPuskesmas->getAllEntry();
        $data['gfk'] = $this->pPuskesmas->getGFK();
        $data['dinas'] = $this->pPuskesmas->getDINAS();
        $data['allAvailableAcc'] = $this->kpapgfk_available->getAllEntry();
        $data['error_msg'] = $this->session->flashdata('error');
        $this->display('pInsert',$data);
    }

    function addPuskesmasSIK()
    {
        $form_data = $this->input->post(null, true);
        $idGedung = '';
        if ($form_data == null ) redirect( base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0), 'refresh');
        else
        {
            $data = array (
                'noid_gedung' => $form_data['inputNoidGedung'],
                'nama_gedung' => $form_data['inputNamaGedung'],
                'jalan_gedung' => $form_data['inputJalan'],
                'kelurahan_gedung' => $form_data['inputKelurahan'],
                'kecamatan_gedung' => $form_data['inputKecamatan'],
                'kabupaten_gedung' => $form_data['inputKabupaten'],
                'provinsi_gedung' => $form_data['inputProvinsi']
            );  
            if($this->pPuskesmas->insertNewEntry($data)=="true")
			{
				$idGedung = $this->pPuskesmas->selectByNoid($form_data['inputNoidGedung']);
				$data = array (																		//add unit ruang dokter
					'id_gedung' => $idGedung[0]['ID_GEDUNG'],
					'nama_unit' => 'Ruang Dokter'
				);  
				if($this->uhcmodel->insertNewEntry($data)=="true"){
					$idUnitDokter = $this->uhcmodel->getAllEntry();									//insert KP
					$unit = end($idUnitDokter);
					$unit = $unit['ID_UNIT'];
					
					$data = array (				
						'id_unit' => $unit,
						'id_akun' => $form_data['inputKP'],
						'id_hakakses' => '1',
						'flag_active_penugasan' => '1'
					);  
					$this->assignment->insertNewEntry($data);
							
					$data = array (
						'id_gedung' => $idGedung[0]['ID_GEDUNG']
					);
					$this->aaccount->updateEntry($form_data['inputKP'], $data);				//change user ID_GEDUNG
					
					$data = array (																	//add unit TU
						'id_gedung' => $idGedung[0]['ID_GEDUNG'],
						'nama_unit' => 'Tata Usaha'
					);  
					if($this->uhcmodel->insertNewEntry($data)=="true"){
						$idUnitTU = $this->uhcmodel->getAllEntry();									//insert AP
						$unit = end($idUnitTU);
						$unit = $unit['ID_UNIT'];
						$data = array (				
							'id_unit' => $unit,
							'id_akun' => $form_data['inputAP'],
							'id_hakakses' => '5',
						'flag_active_penugasan' => '1'
						);  
						$this->assignment->insertNewEntry($data);
						
						$data = array (
							'id_gedung' => $idGedung[0]['ID_GEDUNG']
						);
						$this->aaccount->updateEntry($form_data['inputAP'], $data);				//change user ID_GEDUNG
					
						$data = array (																//add unit GOP
							'id_gedung' => $idGedung[0]['ID_GEDUNG'],
							'nama_unit' => 'Gudang Obat Puskesmas',
							'flag_distribusi_obat' => 2
						);  
						if($this->uhcmodel->insertNewEntry($data)=="true"){
							$idUnitGOP = $this->uhcmodel->getAllEntry();									//insert AP
							$unit = end($idUnitGOP);
							$unit = $unit['ID_UNIT'];
							
							$data = array (				
								'id_unit' => $unit,
								'id_akun' => $form_data['inputGOP'],
								'id_hakakses' => '2',
						'flag_active_penugasan' => '1'
							);  
							$this->assignment->insertNewEntry($data);
							
							
						$data = array (
							'id_gedung' => $idGedung[0]['ID_GEDUNG']
						);
						$this->aaccount->updateEntry($form_data['inputGOP'], $data);				//change user ID_GEDUNG
					
							// redirect( base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0), 'refresh');
						}
						else {
							echo 'error';
						}
						redirect( base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0), 'refresh');
					}
					else 
					{
						echo 'error';
					}
					redirect( base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0), 'refresh');
				}
				else 
				{
					echo 'error';
				}
            }
			else 
			{
                echo 'error';
            }
        }
    }
    
	function addUnit()
    {
        $form_data = $this->input->post(null, true);
        if ($form_data == null ) redirect( base_url().'index.php/uHc', 'refresh');
        else
        {
            $data = array (
                'id_gedung' => $form_data['inputIdGedung'],
                'noid_unit' => $form_data['inputNoidUnit'],
                'nama_unit' => $form_data['inputNamaUnit']
            );  
            if($this->uhcmodel->insertNewEntry($data)=="true")
                redirect( base_url().'index.php/uHc', 'refresh');
            else {
                echo 'error';
            }
        }
    }
	
    function updatePuskesmas()
    {
        $this->title="";
        $id = $this->input->get('id');
		$currentBuilding = $this->pPuskesmas->selectById($id);
        $data['selectedPuskesmas'] = $currentBuilding;
        $data['KP'] = $this->assignment->findKPBy($id);
        $data['AP'] = $this->assignment->findAPBy($id);
        $data['GOP'] = $this->assignment->findGOPBy($id);
        $data['KGFK'] = $this->assignment->findKGFKBy($id);
        $data['KDinas'] = $this->assignment->findKDinasBy($id);
        $data['SIK'] = $this->assignment->findSIKBy($id);
        $data['KYankes'] = $this->assignment->findKYankesBy($id);
        $data['allAvailableAcc'] = $this->kpapgfk_available->getAllEntry();
		
        if ($data == null ) redirect( base_url().'index.php/hClinic', 'refresh');
        else
        {
			if($currentBuilding[0]['FLAG_GEDUNG'] == NULL)
            $this->display('pUpdateHClinicSIK', $data);
			ELSE if($currentBuilding[0]['FLAG_GEDUNG'] == 1)
            $this->display('pUpdateDinasSIK', $data);
			ELSE if($currentBuilding[0]['FLAG_GEDUNG'] == 2)
            $this->display('pUpdateGFKSIK', $data);
        }
    }
    
    function saveUpdatePuskesmas()
    {
        $form_data = $this->input->post(null, true);
        if ($form_data == null ) redirect( base_url().'index.php/hClinic', 'refresh');
        else
        {
            $data = array (
                'noid_gedung' => $form_data['inputNoidGedung'],
                'nama_gedung' => $form_data['inputNamaGedung'],
                'jalan_gedung' => $form_data['inputJalan'],
                'kelurahan_gedung' => $form_data['inputKelurahan'],
                'kecamatan_gedung' => $form_data['inputKecamatan'],
                'kabupaten_gedung' => $form_data['inputKabupaten'],
                'provinsi_gedung' => $form_data['inputProvinsi']
            );
        }
        $this->pPuskesmas->updateEntry($form_data['selectedIdGedung'], $data); 
		$gop = $this->uhcmodel->selectGOPById($form_data['selectedIdGedung']);
		$kp = $this->uhcmodel->selectRDById($form_data['selectedIdGedung']);
		$ap = $this->uhcmodel->selectTUById($form_data['selectedIdGedung']);
		$idGOP = $gop[0]['ID_UNIT'];
		$idKP = $kp[0]['ID_UNIT'];
		$idAP = $ap[0]['ID_UNIT'];
		$akunGOP = $form_data['inputGOP'];
		$akunKP = $form_data['inputKP'];
		$akunAP = $form_data['inputAP'];
		
		if(!isset($idGOP)){
		$data = array (																	//add unit GOP
			'id_gedung' => $form_data['selectedIdGedung'],
			'nama_unit' => 'Gudang Obat Puskesmas',
			'flag_distribusi_obat' => 4
		);  
		$this->uhcmodel->insertNewEntry($data);
		}
		
		if(!isset($idKP)){
		$data = array (																	//add unit RD
			'id_gedung' => $form_data['selectedIdGedung'],
			'nama_unit' => 'Ruang Dokter'
		);  
		$this->uhcmodel->insertNewEntry($data);
		}
		
		if(!isset($idAP)){
		$data = array (																	//add unit TU
			'id_gedung' => $form_data['selectedIdGedung'],
			'nama_unit' => 'Tata Usaha'
		);  
		$this->uhcmodel->insertNewEntry($data);
		}
		
		$gop = $this->uhcmodel->selectGOPById($form_data['selectedIdGedung']);
		$kp = $this->uhcmodel->selectRDById($form_data['selectedIdGedung']);
		$ap = $this->uhcmodel->selectTUById($form_data['selectedIdGedung']);
		$idGOP = $gop[0]['ID_UNIT'];
		$idKP = $kp[0]['ID_UNIT'];
		$idAP = $ap[0]['ID_UNIT'];
		
		$dataPenugasan = array (
					'flag_active_penugasan' => '0'
				);
		$dataPenugasanAktif = array (
					'flag_active_penugasan' => '1'
				);
		$this->assignment->updateEntry($idGOP, '2', $dataPenugasan);
		if($akunGOP != '')
		{
			if($this->assignment->existChecker($akunGOP,$idGOP,'2') != TRUE)
			{
				$data = array (				
									'id_unit' => $idGOP,
									'id_akun' => $akunGOP,
									'id_hakakses' => '2',
							'flag_active_penugasan' => '1'
								);  
								$this->assignment->insertNewEntry($data);
			}
			else
			{
				$this->assignment->activateEntry($idGOP, '2', $akunGOP, $dataPenugasanAktif);
			}
		}
		
		$this->assignment->updateEntry($idKP, '1', $dataPenugasan);
		if($akunKP != '')
		{
			if($this->assignment->existChecker($akunKP,$idKP,'1') != TRUE)
			{
				$data = array (				
									'id_unit' => $idKP,
									'id_akun' => $akunKP,
									'id_hakakses' => '1',
							'flag_active_penugasan' => '1'
								);  
								$this->assignment->insertNewEntry($data);
			}
			else
			{
				$this->assignment->activateEntry($idKP, '1', $akunKP, $dataPenugasanAktif);
			}
		}
		
		$this->assignment->updateEntry($idAP, '5', $dataPenugasan);
		if($akunAP != '')
		{
			if($this->assignment->existChecker($akunAP,$idAP,'5') != TRUE)
			{
				$data = array (				
									'id_unit' => $idAP,
									'id_akun' => $akunAP,
									'id_hakakses' => '5',
							'flag_active_penugasan' => '1'
								);  
								$this->assignment->insertNewEntry($data);
			}
			else
			{
				$this->assignment->activateEntry($idAP, '5', $akunAP, $dataPenugasanAktif);
			}
		}
		redirect( base_url().'hClinic/'.$this->uri->segment(2, 0).'/', 'refresh');   
    }
    
	function saveUpdateDinas()
    {
        $form_data = $this->input->post(null, true);
        if ($form_data == null ) redirect( base_url().'index.php/hClinic', 'refresh');
        else
        {
            $data = array (
                'noid_gedung' => $form_data['inputNoidGedung'],
                'nama_gedung' => $form_data['inputNamaGedung'],
                'jalan_gedung' => $form_data['inputJalan'],
                'kelurahan_gedung' => $form_data['inputKelurahan'],
                'kecamatan_gedung' => $form_data['inputKecamatan'],
                'kabupaten_gedung' => $form_data['inputKabupaten'],
                'provinsi_gedung' => $form_data['inputProvinsi']
            );
        }
        $this->pPuskesmas->updateEntry($form_data['selectedIdGedung'], $data); 
		$kdinkes = $this->uhcmodel->selectKDinkesById();
		$kyankes = $this->uhcmodel->selectKYankesById();
		$sik = $this->uhcmodel->selectSIKById();
		$idkdinkes = $kdinkes[0]['ID_UNIT'];
		$idkyankes = $kyankes[0]['ID_UNIT'];
		$idsik = $sik[0]['ID_UNIT'];
		$akunkdinkes = $form_data['inputKDinas'];
		$akunsik = $form_data['inputSIK'];
		$akunkyankes = $form_data['inputKYankes'];
				
		$dataPenugasan = array (
					'flag_active_penugasan' => '0'
				);
		$dataPenugasanAktif = array (
					'flag_active_penugasan' => '1'
				);
		$this->assignment->updateEntry($idkdinkes, '14', $dataPenugasan);
		if($akunkdinkes != '')
		{
			if($this->assignment->existChecker($akunkdinkes,$idkdinkes,'14') != TRUE)
			{
				$data = array (				
									'id_unit' => $idkdinkes,
									'id_akun' => $akunkdinkes,
									'id_hakakses' => '14'
								);  
								$this->assignment->insertNewEntry($data);
			}
			else
			{
				$this->assignment->activateEntry($idkdinkes, '14', $akunkdinkes, $dataPenugasanAktif);
			}
		}
		
		$this->assignment->updateEntry($idsik, '19', $dataPenugasan);
		if($akunsik != '')
		{
			if($this->assignment->existChecker($akunsik,$idsik,'19') != TRUE)
			{
				$data = array (				
									'id_unit' => $idsik,
									'id_akun' => $akunsik,
									'id_hakakses' => '19'
								);  
								$this->assignment->insertNewEntry($data);
			}
			else
			{
				$this->assignment->activateEntry($idsik, '19', $akunsik, $dataPenugasanAktif);
			}
		}
		
		$this->assignment->updateEntry($idkyankes, '15', $dataPenugasan);
		if($akunkyankes != '')
		{
			if($this->assignment->existChecker($akunkyankes,$idkyankes,'15') != TRUE)
			{
				$data = array (				
									'id_unit' => $idkyankes,
									'id_akun' => $akunkyankes,
									'id_hakakses' => '15'
								);  
								$this->assignment->insertNewEntry($data);
			}
			else
			{
				$this->assignment->activateEntry($idkyankes, '15', $akunkyankes, $dataPenugasanAktif);
			}
		}
		redirect( base_url().'hClinic/'.$this->uri->segment(2, 0).'/', 'refresh');   
    }
	
	function saveUpdateKGFK()
    {
        $form_data = $this->input->post(null, true);
        if ($form_data == null ) redirect( base_url().'index.php/hClinic', 'refresh');
        else
        {
            $data = array (
                'noid_gedung' => $form_data['inputNoidGedung'],
                'nama_gedung' => $form_data['inputNamaGedung'],
                'jalan_gedung' => $form_data['inputJalan'],
                'kelurahan_gedung' => $form_data['inputKelurahan'],
                'kecamatan_gedung' => $form_data['inputKecamatan'],
                'kabupaten_gedung' => $form_data['inputKabupaten'],
                'provinsi_gedung' => $form_data['inputProvinsi']
            );
        }
        $this->pPuskesmas->updateEntry($form_data['selectedIdGedung'], $data); 
		$kgfk = $this->uhcmodel->selectKGFKById($form_data['selectedIdGedung']);
		$idkgfk = $kgfk[0]['ID_UNIT'];
        $akunKGFK = $form_data['inputKGFK'];
				
		$dataPenugasan = array (
					'flag_active_penugasan' => '0'
				);
		$dataPenugasanAktif = array (
					'flag_active_penugasan' => '1'
				);
		$this->assignment->updateEntry($idkgfk, '17', $dataPenugasan);
		if($akunKGFK != '')
		{
			if($this->assignment->existChecker($akunKGFK,$idkgfk,'17') != TRUE)
			{
				$data = array (				
									'id_unit' => $idkgfk,
									'id_akun' => $akunKGFK,
									'id_hakakses' => '17',
									'flag_active_penugasan' => '1'
								);  
								$this->assignment->insertNewEntry($data);
			}
			else
			{
				$this->assignment->activateEntry($idkgfk, '17', $akunKGFK, $dataPenugasanAktif);
			}
		}
		
		redirect( base_url().'hClinic/'.$this->uri->segment(2, 0).'/', 'refresh');   
    }
	
    function removePuskesmas()
    {
        $form_data = $this->input->post(null, true);
        if(!is_null($form_data['selected']))
        {
            $this->pPuskesmas->deleteById ($form_data['selected']);
            redirect( base_url().'index.php/hClinic', 'refresh');
        }
    }
}