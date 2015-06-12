<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class ScAdmHc extends backendController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->top_navbar = 'lay-top-navbar/navbar_su';
        // $this->left_sidebar = 'lay-left-sidebar/department_sidebar';
        $this->load->model('suscategory');
        /*
        $this->theme_layout = 'template_login';
        $this->script_header = 'lay-scripts/header_login';
        $this->script_footer = 'lay-scripts/footer_login';
        $this->load->model('login/mLogin');*/
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
        $data['allCategory'] = $this->suscategory->getAllEntry();
        //$data['error_msg'] = $this->session->flashdata('error');
        $this->display('scControl',$data);
		// $this->display('scControl');
    }
    
    function createSCategory()
    {
        $this->title="";
        $this->display('scInsert');
    }

    function addSCategory()
    {
        $form_data = $this->input->post(null, true);
        
        if ($form_data == null ) redirect( base_url().'index.php/admHc/scAdmHc/createSCategory', 'refresh');
        else
        {
            $data = array (
                'nama_kategori_layanan' => $form_data['inputNamaKategoriLayanan']
            );  
            if($this->suscategory->insertNewEntry($data)=="true")
                redirect( base_url().'index.php/admHc', 'refresh');
            else {
                echo 'error';
            }
        }
    }
    
    function updateSCategory()
    {
        $this->title="";
        $id = $this->input->get('id');
        
        $data['selectedSCategory'] = $this->suscategory->selectById($id);
        if ($data == null ) redirect( base_url().'index.php/admHc/scAdmHc/', 'refresh');
        else
        {
            $this->display('scUpdate', $data);
        }
        
    }
    
    function saveUpdateSCategory()
    {
        $form_data = $this->input->post(null, true);
        if ($form_data == null ) redirect( base_url().'index.php/admHc/scAdmHc/', 'refresh');
        else
        {
            $data = array (
                'nama_kategori_layanan' => $form_data['inputNamaKategoriLayanan']
            );
        }
        $this->suscategory->updateEntry($form_data['selectedIdSCategory'], $data); 
        redirect( base_url().'index.php/admHc/scAdmHc/', 'refresh');   
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