<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class tu extends tuController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->top_navbar = 'lay-top-navbar/tuNavbar';
        $this->load->model('inventaris_model');
        $this->load->model('unit_model');
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
        $data['allUnit'] = $this->unit_model->getUnitByHC();
        $data['allPuskesmas'] = $this->inventaris_model->getAllEntry_byGedung();
        $data['error_msg'] = $this->session->flashdata('error');
        $this->display('pInsert',$data);
    }
    
    function createPuskesmas()
    {
        $this->title="";
        $this->display('pInsert');
        $this->left_sidebar = 'lay-left-sidebar/hClinic_sidebar';
    }

    function addPuskesmas()
    {
        $form_data = $this->input->post(null, true);
        
        if ($form_data == null ) redirect( base_url().'index.php/hClinic', 'refresh');
        else
        {
            $data = array (
                'id_unit' => $form_data['inputNoidUnit'],
                'id_gedung'=> $form_data['idgedung'],
                'nama_barang' => $form_data['inputNama'],
                'kode_barang' => $form_data['inputKode'],
                'no_reg_barang' => $form_data['inputNoreg'],
                'merk_type' => $form_data['inputMerk'],
                'ukuran_cc' => $form_data['inputUkuran'],
                'bahan_barang' => $form_data['inputBahan'],
                'tahun_pembelian_barang' => $form_data['inputTahun'],
                'nomor_pabrik' => $form_data['inputNoPabrik'],
                'nomor_rangka' => $form_data['inputNoRangka'],
                'nomor_mesin' => $form_data['inputNoMesin'],
                'nomor_polisi' => $form_data['inputNoPolisi'],
                'nomor_bpkb' => $form_data['inputNoBPKB'],
                'cara_perolehan_barang' => $form_data['inputPerolehan'],
                'harga_barang' => $form_data['inputHarga'],
                'keterangan_barang' => $form_data['inputKet']
            );  
            if($this->inventaris_model->insertNewEntry($data)=="true")
                redirect( base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0), 'refresh');
            else {
                echo 'error';
            }
        }
    }
    
    function updateInventory()
    {
        $this->title="";
        $id = $this->input->get('id');
        $data['allUnit'] = $this->unit_model->getUnitByHC();
        $data['allPuskesmas'] = $this->inventaris_model->getAllEntry_byGedung();
        $data['selectedPuskesmas'] = $this->inventaris_model->selectById($id);
        
        if ($data == null ) redirect( base_url().'index.php/hClinic', 'refresh');
        else
        {
            $this->display('pUpdate', $data);
        }
        
    }
    
    function removeInventory()
    {
        $this->title="";
        $id = $this->input->get('id');
        $this->inventaris_model->deleteById($id);
        redirect('/');
    }
    
    function saveUpdatePuskesmas()
    {
        $form_data = $this->input->post(null, true);
        if ($form_data == null ) redirect( base_url().'index.php/hClinic', 'refresh');
        else
        {
            $data = array (
                'id_unit' => $form_data['inputNoidUnit'],
                'nama_barang' => $form_data['inputNama'],
                'kode_barang' => $form_data['inputKode'],
                'no_reg_barang' => $form_data['inputNoreg'],
                'merk_type' => $form_data['inputMerk'],
                'ukuran_cc' => $form_data['inputUkuran'],
                'bahan_barang' => $form_data['inputBahan'],
                'tahun_pembelian_barang' => $form_data['inputTahun'],
                'nomor_pabrik' => $form_data['inputNoPabrik'],
                'nomor_rangka' => $form_data['inputNoRangka'],
                'nomor_mesin' => $form_data['inputNoMesin'],
                'nomor_polisi' => $form_data['inputNoPolisi'],
                'nomor_bpkb' => $form_data['inputNoBPKB'],
                'cara_perolehan_barang' => $form_data['inputPerolehan'],
                'harga_barang' => $form_data['inputHarga'],
                'keterangan_barang' => $form_data['inputKet']
            );
        }
        $this->inventaris_model->updateEntry($form_data['selectedIdGedung'], $data); 
        redirect( base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0), 'refresh');   
    }
    
    function removePuskesmas()
    {
        $form_data = $this->input->post(null, true);
        if(!is_null($form_data['selected']))
        {
            $this->inventaris_model->deleteById ($form_data['selected']);
            redirect( base_url().'index.php/hClinic', 'refresh');
        }
    }
}