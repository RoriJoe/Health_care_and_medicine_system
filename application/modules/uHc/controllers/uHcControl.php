<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class UHcControl extends backendController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->top_navbar = 'lay-top-navbar/navbar_su';
        $this->load->model('uHcModel');
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
        $data['allUnit'] = $this->uHcModel->getAllEntry();
        $data['error_msg'] = $this->session->flashdata('error');
        $this->display('management',$data);
    }
    
    function createUnit()
    {
        $this->title="";
        $this->load->model('detailAccount');
        //$penugasan = $this->session->userdata['telah_masuk']['idpenugasan'];
        $data['allPuskesmas'] = $this->detailAccount->selectByIdAccount("1");
        $this->display('register',$data);
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
                'nama_unit' => $form_data['inputNamaUnit'],
                'jalan_unit' => $form_data['inputJalan'],
                'kelurahan_unit' => $form_data['inputKelurahan'],
                'kecamatan_unit' => $form_data['inputKecamatan'],
                'kabupaten_unit' => $form_data['inputKabupaten'],
                'provinsi_unit' => $form_data['inputProvinsi']
            );  
            if($this->uHcModel->insertNewEntry($data)=="true")
                redirect( base_url().'index.php/uHc', 'refresh');
            else {
                echo 'error';
            }
        }
    }
    
    function updateUnit()
    {
        $this->title="";
        $id = $this->input->get('id');
        $data['allUnit'] = $this->uHcModel->getAllEntry();
        $data['selectedUnit'] = $this->uHcModel->selectById($id);
        
        if ($data == null ) redirect( base_url().'index.php/uHc', 'refresh');
        else
        {
            $this->display('update', $data);
        }
        
    }
    
    function saveUpdateUnit()
    {
        $form_data = $this->input->post(null, true);
        if ($form_data == null ) redirect( base_url().'index.php/uHc', 'refresh');
        else
        {
            $data = array (
                'id_gedung' => $form_data['inputNoidGedung'],
                'noid_unit' => $form_data['inputNoidGedung'],
                'nama_unit' => $form_data['inputNamaGedung'],
                'jalan_unit' => $form_data['inputJalan'],
                'kelurahan_unit' => $form_data['inputKelurahan'],
                'kecamatan_unit' => $form_data['inputKecamatan'],
                'kabupaten_unit' => $form_data['inputKabupaten'],
                'provinsi_unit' => $form_data['inputProvinsi']
            );
        }
        $this->uHcModel->updateEntry($form_data['selectedIdGedung'], $data); 
        redirect( base_url().'index.php/uHc', 'refresh');   
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