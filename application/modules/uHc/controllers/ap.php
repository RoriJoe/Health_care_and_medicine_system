<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class ap extends backendController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->top_navbar = 'lay-top-navbar/apNavbar';
        $this->load->model('uHcModel');
        $this->load->model('detailAccount');
    }

    //tambah unit
    public function index() {
        //$penugasan = $this->session->userdata['telah_masuk']['idakun'];
        redirect(base_url().'uHc/'.$this->uri->segment(2, 0).'/createUnit');
    }
    
	function availableUnit()
	{
        $data['allUnit'] = $this->uHcModel->selectByIdHC($this->session->userdata['telah_masuk']['idgedung']);
		$tempExistUnit = array();
		foreach($data['allUnit'] as $row)
		{
			array_push($tempExistUnit,$row['NAMA_UNIT']);
		}
		$staticUnit = array("Apotik","Poli Umum","Poli Gigi","Poli Umum","KIA","UGD","Laboratorium","Loket Pendaftaran","Rawat Inap");
		$result = array_diff($staticUnit, $tempExistUnit);
		
		return $result;
	}
	
    function createUnit()
    {
        $this->title="";
        //$penugasan = $this->session->userdata['telah_masuk']['idpenugasan'];
        $data['allUnit'] = $this->uHcModel->selectByIdHC($this->session->userdata['telah_masuk']['idgedung']);
        $data['allPoli'] = $this->uHcModel->getAllPoli($this->session->userdata['telah_masuk']['idgedung']);
        $data['allPustu'] = $this->uHcModel->getAllExceptPoli($this->session->userdata['telah_masuk']['idgedung']);
		
		$data['unitOption'] = $this->availableUnit();
        $this->display('management',$data);
    }
	
	function flagFinder($unitName)
	{
		$flag = 3;
		switch($unitName){
			case "Poli Umum":
			$flag = 4;
			break;
			case "Poli Gigi":
			$flag = 4;
			break;
			case "KIA":
			$flag = 4;
			break;
			case "VK KIA":
			$flag = 4;
			break;
			case "UGD":
			$flag = 4;
			break;
			case "Laboratorium":
			$flag = 4;
			break;
			case "Loket Pendaftaran":
			$flag = NULL;
			break;
			case "Rawat Inap":
			$flag = 4;
			break;
			case "Gudang Obat Puskesmas":
			$flag = 2;
			break;
			default:
			$flag = 3;
			break;
		}
		return $flag;
	}
    function addUnit()
    {
        $form_data = $this->input->post(null, true);
        $namanya = $form_data['namaAwalan'].' '.$form_data['inputNamaUnit'];
        if ($form_data == null ) redirect( base_url().'index.php/uHc', 'refresh');
        else
        {
            $data = array (
                'id_gedung' => $this->session->userdata['telah_masuk']['idgedung'],
                'noid_unit' => $form_data['inputNoidUnit'],
                'nama_unit' => $namanya,
                'jalan_unit' => $form_data['inputJalan'],
                'kelurahan_unit' => $form_data['inputKelurahan'],
                'kecamatan_unit' => $form_data['inputKecamatan'],
                'kabupaten_unit' => $form_data['inputKabupaten'],
                'provinsi_unit' => $form_data['inputProvinsi'],
				'flag_distribusi_obat' => $this->flagFinder($form_data['inputNamaUnit'])
            );  
            if($this->uHcModel->insertNewEntry($data)=="true")
                redirect( base_url().'index.php/uHc/ap', 'refresh');
            else {
                echo 'error';
            }
        }
    }
    
    function updateUnit()
    {
        $this->title="";
        $id = $this->input->get('id');
        $data['selectedUnit'] = $this->uHcModel->selectById($id);
		$data['selectedUnitName'] = $data['selectedUnit'][0]['NAMA_UNIT'];
		$data['selectedUnitNameFlag'] = $data['selectedUnit'][0]['FLAG_DISTRIBUSI_OBAT'];
        $data['allUnit'] = $this->uHcModel->selectByIdHC($this->session->userdata['telah_masuk']['idgedung']);
		$data['unitOption'] = $this->availableUnit();
        $data['allPoli'] = $this->uHcModel->getAllPoli($this->session->userdata['telah_masuk']['idgedung']);
        $data['allPustu'] = $this->uHcModel->getAllExceptPoli($this->session->userdata['telah_masuk']['idgedung']);
		
        if ($data['selectedUnit'] == null ) redirect( base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/createUnit', 'refresh');
        else
        {
            $this->display('apupdate', $data);
        }
        
    }
    
    function saveUpdateUnit()
    {
        $form_data = $this->input->post(null, true);
        $namanya = $form_data['namaAwalan'].' '.$form_data['inputNamaUnit'];
        if ($form_data == null ) redirect( base_url().'index.php/uHc', 'refresh');
        else
        {
            $data = array (
                'id_gedung' => $this->session->userdata['telah_masuk']['idgedung'],
                'noid_unit' => $form_data['inputNoidUnit'],
                'nama_unit' => $namanya,
                'jalan_unit' => $form_data['inputJalan'],
                'kelurahan_unit' => $form_data['inputKelurahan'],
                'kecamatan_unit' => $form_data['inputKecamatan'],
                'kabupaten_unit' => $form_data['inputKabupaten'],
                'provinsi_unit' => $form_data['inputProvinsi'],
				'flag_distribusi_obat' => $this->flagFinder($form_data['inputNamaUnit'])
            );
        }
        $this->uHcModel->updateEntry($form_data['inputIdUnit'], $data); 
        redirect( base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/createUnit', 'refresh');   
    }
    
    function removeUnit()
    {
        $form_data = $this->input->post(null, true);
        if(!is_null($form_data['selected']))
        {
            $this->uHcModel->deleteById ($form_data['selected']);
            redirect( base_url().'index.php/uHc', 'refresh');
        }
    }
}