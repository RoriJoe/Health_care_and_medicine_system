<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class DControl extends backendController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->top_navbar = 'lay-top-navbar/navbar_su';
        $this->left_sidebar = 'lay-left-sidebar/department_sidebar';
        $this->load->model('dDepartment');
        /*
        $this->theme_layout = 'template_login';
        $this->script_header = 'lay-scripts/header_login';
        $this->script_footer = 'lay-scripts/footer_login';
        $this->load->model('login/mLogin');*/
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
        $data['allDepartment'] = $this->dDepartment->getAllEntry();
        $data['error_msg'] = $this->session->flashdata('error');
        $this->display('dControl',$data);
    }
    
    function createDepartment()
    {
        $this->title="";
        $this->display('dInsert');
    }

    function addDepartment()
    {
        $form_data = $this->input->post(null, true);
        
        if ($form_data == null ) redirect( base_url().'index.php/department/dControl/createDepartment', 'refresh');
        else
        {
            $data = array (
                'nama_jabatan' => $form_data['inputNamaJabatan']
            );  
            if($this->dDepartment->insertNewEntry($data)=="true")
                redirect( base_url().'index.php/department', 'refresh');
            else {
                echo 'error';
            }
        }
    }
    
    function updateDepartment()
    {
        $this->title="";
        $id = $this->input->get('id');
        
        $data['selectedDepartment'] = $this->dDepartment->selectById($id);
        if ($data == null ) redirect( base_url().'index.php/department', 'refresh');
        else
        {
            $this->display('dUpdate', $data);
        }
        
    }
    
    function saveUpdateDepartment()
    {
        $form_data = $this->input->post(null, true);
        if ($form_data == null ) redirect( base_url().'index.php/department', 'refresh');
        else
        {
            $data = array (
                'nama_jabatan' => $form_data['inputNamaDepartment']
            );
        }
        $this->dDepartment->updateEntry($form_data['selectedIdDepartment'], $data); 
        redirect( base_url().'index.php/department', 'refresh');   
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