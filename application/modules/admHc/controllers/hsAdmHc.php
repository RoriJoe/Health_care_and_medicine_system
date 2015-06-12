<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class HsAdmHc extends backendController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->top_navbar = 'lay-top-navbar/navbar_su';
        // $this->left_sidebar = 'lay-left-sidebar/department_sidebar';
        $this->load->model('suhservice');
        $this->load->model('suscategory');
        $this->load->library('Pdf');
        /*
        $this->theme_layout = 'template_login';
        $this->script_header = 'lay-scripts/header_login';
        $this->script_footer = 'lay-scripts/footer_login';
        $this->load->model('login/mLogin');*/
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
        $data['allHServices'] = $this->suhservice->getAllEntry();
        $data['allSCategory'] = $this->suscategory->getAllEntry();
        $data['error_msg'] = $this->session->flashdata('error');
        $this->display('hsControl',$data);
    }
    
	function toPdf()
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // Add a page
        $pdf->AddPage();
        $html = "<h1>Test Page</h1>";
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('example_001.pdf', 'I');
    }
	
    function createHServices()
    {
        $this->title="";
        $data['allSCategory'] = $this->suscategory->getAllEntry();
        $this->display('hsInsert',$data);
    }

    function addHServices()
    {
        $form_data = $this->input->post(null, true);
        
        if ($form_data == null ) redirect( base_url().'index.php/admHc/hsAdmHc/createHServices', 'refresh');
        else
        {
            $data = array (
                'id_kategori_layanan' => $form_data['inputIdSCategory'],
                'nama_layanan_kes' => $form_data['inputNamaLayananKesehatan'],
                'jasa_sarana_kes' => $form_data['inputJasaSarana'],
                'jasa_layanan_kes' => $form_data['inputJasaLayanan'],
                'keterangan_layanan_kes' => $form_data['inputKeterangan']
            );  
            if($this->suhservice->insertNewEntry($data)=="true")
                redirect( base_url().'index.php/admHc/hsAdmHc/', 'refresh');
            else {
                echo 'error';
            }
        }
    }
    
    function updateHServices()
    {
        $this->title="";
        $id = $this->input->get('id');
        
        $data['selectedHServices'] = $this->suhservice->selectById($id);
        $data['allSCategory'] = $this->suscategory->getAllEntry();
        if ($data == null ) redirect( base_url().'index.php/admHc/hsAdmHc', 'refresh');
        else
        {
            $this->display('hsUpdate', $data);
        }
        
    }
    
    function saveUpdateHServices()
    {
        $form_data = $this->input->post(null, true);
        if ($form_data == null ) redirect( base_url().'index.php/admHc/hsAdmHc', 'refresh');
        else
        {
            $data = array (
                'id_kategori_layanan' => $form_data['inputIdSCategory'],
                'nama_layanan_kes' => $form_data['inputNamaLayananKesehatan'],
                'jasa_sarana_kes' => $form_data['inputJasaSarana'],
                'jasa_layanan_kes' => $form_data['inputJasaLayanan'],
                'keterangan_layanan_kes' => $form_data['inputKeterangan']
            );
        }
        $this->suhservice->updateEntry($form_data['selectedIdHServices'], $data); 
        redirect( base_url().'index.php/admHc/hsAdmHc', 'refresh');   
    }
    
    function removeDepartment()
    {
        $form_data = $this->input->post(null, true);
        if(!is_null($form_data['selected']))
        {
            $this->dDepartment->deleteById ($form_data['selected']);
            redirect( base_url().'index.php/hClinic', 'refresh');
        }
    }
}