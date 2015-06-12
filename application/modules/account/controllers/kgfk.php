<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class Kgfk extends kgfkController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->load->model('aaccount');
        $this->load->model('assignment');
        $this->load->model('unit_model');
        $this->load->model('assignment');
        $this->load->model('ddepartment');
        $this->load->model('access_model');
        $this->load->model('sdm_model');
        $this->load->model('ppuskesmas');
        $this->load->model('surank');
        /*
        $this->theme_layout = 'template_login';
        $this->script_header = 'lay-scripts/header_login';
        $this->script_footer = 'lay-scripts/footer_login';
        $this->load->model('login/mLogin');*/
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
        $form_data = $this->input->post(null, true);
        $data['allAkun'] = $this->aaccount->getAllEntry();
        $data['error_msg'] = $this->session->flashdata('error');
        $this->display('aControl',$data);
    }
    
    function createAccount()
    {
        $this->title="";
        $data['allAccess'] = $this->access_model->getAllEntryByHa();
		if($this->session->userdata['telah_masuk']['idha'] == 16 || $this->session->userdata['telah_masuk']['idha'] == 17)
			$data['allUnit'] = $this->unit_model->getUnitByHCGFK();
		else
			$data['allUnit'] = $this->unit_model->getUnitByHC();
        $data['allDepartment'] = $this->ddepartment->getAllEntry();
        $data['allRank'] = $this->surank->getAllEntry();
        $this->display('aRegister',$data);
    }
	
	function nikChecker()
	{
		$nik = $this->input->post('nik');
		$checker = $this->aaccount->findID ($nik);
		if(isset($checker))
			echo $nik;
		else
			echo '';
		}
		
	function addAccountWTask()
    {
        $form_data = $this->input->post(null, true);
		$numRow = $form_data['rowNum'];
		$dataAccount = array (
			'id_pangkat' => $this->input->post('inputPangkat'),
			'id_jabatan' => $this->input->post('inputJabatan'),
			'noid' => $this->input->post('inputNoid'),
			'nama_akun' => $this->input->post('inputNama'),
			'alamat' => $this->input->post('inputAlamat'),
			'jenis_kelamin' => $this->input->post('inputSex'),
			'telepon' => $this->input->post('inputTelepon'),
			'hp' => $this->input->post('inputHandphone'),
			'email' => $this->input->post('inputEmail'),
			'agama' => $this->input->post('inputAgama'),
			'status_pegawai' => $this->input->post('inputStatus'),
			'password' => '123',
			'id_gedung' => $this->session->userdata['telah_masuk']['idgedung']
		);
		$this->aaccount->insertNewEntry($dataAccount);
        
		$akun = $this->aaccount->findId($this->input->post('inputNoid'));
        $IdAkun = $akun[0]['ID_AKUN'];
		for($i = 1; $i<=$numRow;$i++)
		{
			if(isset($form_data['gfk'.$i]))
			{
				$arrIndex = $i;
				$unitName = $this->unit_model->getUnitByName($form_data['gfk'.$i]);
				if(!isset($unitName))
				{
					$data = array (
						'id_gedung' => $this->session->userdata['telah_masuk']['idgedung'],
						'nama_unit' => $form_data['gfk'.$i],
						'flag_distribusi_obat' => 1
					);
					$this->unit_model->insertNewEntry($data); 			//make unit if not exist
				}
				
				$unitName = $this->unit_model->getUnitByName($form_data['gfk'.$i]);
				$idHa = $this->access_model->getHAByUnit($unitName[0]['NAMA_UNIT']);
				$dataPenugasan = array (
					'id_akun' => $IdAkun,
					'id_unit' => $unitName[0]['ID_UNIT'],
					'id_hakakses' => $idHa[0]['ID_HAKAKSES'],
					'flag_active_penugasan' => 1
				);
				if($this->assignment->existChecker($IdAkun,$unitName[0]['ID_UNIT'],$idHa[0]['ID_HAKAKSES']) == false)
					$this->assignment->insertNewEntry($dataPenugasan);
			}
		}
		redirect( base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/', 'refresh');
    }
	
	function updateOwnAccount()
    {
        $this->title="";
        $id = $this->input->get('id');
		
        $akunData = $this->aaccount->selectById($this->session->userdata['telah_masuk']["idakun"]);
        $data['selectedAkun'] = $akunData;
		$data['check'] = $this->session->flashdata('checkPass');
        if ($data == null ) redirect( base_url().'index.php/account', 'refresh');
        else
        {
            $this->display('ownAccountUpdate', $data);
        }
        
    }
    
    function saveOwnUpdateOwnAccount()
    {
		$this->session->set_flashdata('checkPass','');
        $form_data = $this->input->post(null, true);
		$akunData = $this->aaccount->selectById($this->session->userdata['telah_masuk']["idakun"]);
        if ($form_data == null ) redirect( base_url().'index.php/Account', 'refresh');
        else
        {
            $data = array (
                'noid' => $form_data['inputNoid'],
                'nama_akun' => $form_data['inputNama'],
                'alamat' => $form_data['inputAlamat'],
                'jenis_kelamin' => $form_data['inputSex'],
                'telepon' => $form_data['inputTelepon'],
                'hp' => $form_data['inputHandphone'],
                'email' => $form_data['inputEmail'],
                'agama' => $form_data['inputAgama']
            );
			$this->aaccount->updateEntry($form_data['selectedAkun'], $data);
			
			if($form_data['inputOld'] != '' || $form_data['inputCheck'] != '' || $form_data['inputNew'] != '')
			{
				if($form_data['inputOld'] != $form_data['inputCheck'] || md5($form_data['inputOld']) != $akunData[0]['PASSWORD']){
					$this->session->set_flashdata('checkPass','passError');
				}
				elseif(md5($form_data['inputOld']) == $akunData[0]['PASSWORD'])
				{
					$pass = array (
						'password' => md5($form_data['inputNew'])
					);
					$this->aaccount->updateEntry($form_data['selectedAkun'], $pass);
				}
			}
        }
        redirect( base_url().'index.php/account/'.$this->uri->segment(2, 0).'/updateAccount', 'refresh');
    }
	
	function check_diff_multi($array1, $array2){
		$result = array();
		$flagFind = 0;
		$arrIndex = 0;
		if(isset($array1))
		{
			if(isset($array2))
			{
				foreach($array1 as $arr1)
				{
					foreach($array2 as $arr2)
					{
						if($arr1['ID_AKUN'] == $arr2['id_akun'] && $arr1['ID_UNIT'] == $arr2['id_unit'] && $arr1['ID_HAKAKSES'] == $arr2['id_hakakses'])
						{
							$flagFind = 1;
							break;
						}
					}
					
					if($flagFind == 1)
						$flagFind = 0;
					else
					{
						$result[$arrIndex] = $arr1;
						$arrIndex += 1;
					}
				}
			}else
			{
				$result = $array1;				//jika array pembanding kosong out array 1 untuk di deactive
			}
		}

		return $result;
	}

    function addAccount()
    {
        $form_data = $this->input->post(null, true);
        
        if ($form_data == null ) redirect( base_url().'index.php/account', 'refresh');
        else
        {
            $data = array (
                'noid' => $form_data['inputNoid'],
                'nama_akun' => $form_data['inputNama'],
                'alamat' => $form_data['inputAlamat'],
                'jenis_kelamin' => $form_data['inputSex'],
                'telepon' => $form_data['inputTelepon'],
                'hp' => $form_data['inputHandphone'],
                'email' => $form_data['inputEmail'],
                'agama' => $form_data['inputAgama'],
                'status_pegawai' => $form_data['inputStatus'],
                'password' => '123'
            );
			$this->aaccount->insertNewEntry($data);
        }
    }
    
	function addTask()
    {
        $gethakAkses =$this->input->post('dataHA'); 
        $getunit =$this->input->post('dataUnit');
		$akun = $this->aaccount->findId($this->input->post('dataAkun'));
        $IdAkun = $akun[0]['ID_AKUN'];
		$Ha = explode(",",$gethakAkses);
		$Unit = explode(",",$getunit);
		$index = 0;
		
			foreach($Ha as $row)
			{
				$data = array (
					'id_akun' => $IdAkun,
					'id_unit' => $Unit[$index],
					'id_hakakses' => $row
				);
				$this->assignment->insertNewEntry($data);
				$index += 1;
				if($index == sizeof($Ha)-1)
					break;
			}
		
    }
	
    function updateAccount()
    {
        $this->title="";
        $id = $this->input->get('id');
        $akunData = $this->aaccount->selectById($id);
        $data['selectedAkun'] = $akunData;
        $data['allAccess'] = $this->access_model->getAllEntryByHa();
        //$data['allUnit'] = $this->unit_model->getUnitByHC();
        $data['allDepartment'] = $this->ddepartment->getAllEntry();
        $data['allRank'] = $this->surank->getAllEntry();
        $data['allAssignment'] = $this->assignment->getAssignmentByIdAkunForGFK($id);
		
		if($this->session->userdata['telah_masuk']['idha'] == 16 || $this->session->userdata['telah_masuk']['idha'] == 17)
			$data['allUnit'] = $this->unit_model->getUnitByHCGFK();
		else
			$data['allUnit'] = $this->unit_model->getUnitByHC();
        $idHA = array(); ;
        // foreach($this->adetailha->getIdHA($akunData[0]['ID_AKUN']) as $row) 
        // {
            // array_push($idHA,$row['ID_HAKAKSES']);
        // }
        // $data['selectedDHA'] = $idHA;
        if ($data == null ) redirect( base_url().'index.php/account', 'refresh');
        else
        {
            $this->display('aUpdate', $data);
        }
        
    }
    
    function saveUpdateAccount()
    {
        $form_data = $this->input->post(null, true);
        if ($form_data == null ) redirect( base_url().'index.php/Account', 'refresh');
        else
        {
            $data = array (
				'id_pangkat' => $this->input->post('inputPangkat'),
				'id_jabatan' => $this->input->post('inputJabatan'),
                'noid' => $form_data['inputNoid'],
                'nama_akun' => $form_data['inputNama'],
                'alamat' => $form_data['inputAlamat'],
                'jenis_kelamin' => $form_data['inputSex'],
                'telepon' => $form_data['inputTelepon'],
                'hp' => $form_data['inputHandphone'],
                'email' => $form_data['inputEmail'],
                'agama' => $form_data['inputAgama'],
                'status_pegawai' => $form_data['inputStatus']
            );
        }
        $this->aaccount->updateEntry($form_data['selectedAkun'], $data);		
		
		$numRow = $form_data['rowNum'];
		
        $IdAkun = $form_data['selectedAkun']; 
        $data['allAssignment'] = $this->assignment->getAssignmentByIdAkunForGFK($IdAkun);
		$diffArray = array();
		for($i = 1; $i<=$numRow;$i++)
		{
			if(isset($form_data['unit'.$i]))
			{
				$arrIndex = $i;
				$unitName = $this->unit_model->getUnitByName($form_data['gfk'.$i]);
				if(!isset($unitName))
				{
					$data = array (
						'id_gedung' => $this->session->userdata['telah_masuk']['idgedung'],
						'nama_unit' => $form_data['gfk'.$i],
						'flag_distribusi_obat' => 1
					);
					$this->unit_model->insertNewEntry($data); 			//make unit if not exist
				}
				$unit = $this->unit_model->getUnitByName($form_data['gfk'.$i]);
				var_dump($form_data['gfk'.$i]);
				$idHa = $this->access_model->getHAByUnit($form_data['gfk'.$i]);
				$dataPenugasan = array (
					'id_akun' => $IdAkun,
					'id_unit' => $unit[0]['ID_UNIT'],
					'id_hakakses' => $idHa[0]['ID_HAKAKSES']
				);
				//var_dump($dataPenugasan);
				$diffArray[$arrIndex-1] = $dataPenugasan;
				if($this->assignment->existChecker($IdAkun,$unit[0]['ID_UNIT'],$idHa[0]['ID_HAKAKSES']) == false)
				{
					$this->assignment->insertNewEntry($dataPenugasan);
				}
				else
				{
					$dataPenugasan = array (
						'flag_active_penugasan' => 1
					);
					$this->assignment->deactivateAssignment($IdAkun,$idHa[0]['ID_HAKAKSES'],$unit[0]['ID_UNIT'],$dataPenugasan);
				}
			}
		}
		
		$haDeactivate = $this->check_diff_multi($data['allAssignment'],$diffArray);
		var_dump($haDeactivate);
		if(isset($haDeactivate))
		{
			foreach($haDeactivate as $row)
			{
				$dataPenugasan = array (
					'flag_active_penugasan' => 0
				);
				$this->assignment->deactivateAssignment($row['ID_AKUN'],$row['ID_HAKAKSES'],$row['ID_UNIT'],$dataPenugasan);
			}
			
		}
        redirect( base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0), 'refresh');
    }
    
	function monitoringSDM()
    {
        if( $this->session->userdata['telah_masuk']['idha'] != 14 && $this->session->userdata['telah_masuk']['idha'] != 19)
			$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
		else
			$data['allHC'] = $this->ppuskesmas->getAllEntry();
			
        $this->display('kpMonitoringSDM',$data);
    }
	
	function getAkun()
    {
		$result = $this->aaccount->getAllEntry();
		if ($result) 
		echo $this->getPivotAkun ($result);
		else echo "[[\"NIK\",\"NAMA\",\"JABATAN\",\"PANGKAT\",\"GOLONGAN\",\"STATUS PEGAWAI\"], [\"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\"]]";
    }
	
	function getSDM()
    {
		if( $this->session->userdata['telah_masuk']['idha'] != 14 && $this->session->userdata['telah_masuk']['idha'] != 19)
			$result = $this->sdm_model->getSDMByHC (1);
		else{
			$idgedung = $this->input->post('puskesmas');
			$result = $this->sdm_model->getSDMByHC ($idgedung);
		}
			
		if ($result) 
		echo $this->getPivot ($result);
		else echo "[[\"NIK\",\"NAMA\",\"JABATAN\",\"PANGKAT\",\"GOLONGAN\",\"STATUS PEGAWAI\"], [\"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\"]]";
    }
	
	function clean($string) {
        return preg_replace('/[^A-Za-z0-9\-@ .,]/', '-', $string); // Removes special chars.
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
	
	private function getPivotAkun($data) {
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
            $header .= ",\"KELOLA\"]";
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
            $header .= ',"<a style=\"color: white;\" type=\"button\" onClick=update(this.id) class=\"btn btn-primary\"  data-toggle=\"modal\" href=\"'.base_url().'account/'.$this->uri->segment(2, 0).'/updateAccount?id='.$value['ID_AKUN'].'\">Ubah</a>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }
	
    function removeAccount()
    {
        $id = $this->input->get('id');
        if(!is_null($id))
        $this->aaccount->deleteById ($id);
    }
}