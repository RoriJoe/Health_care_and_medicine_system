<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class SpAdmHc extends backendController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->top_navbar = 'lay-top-navbar/navbar_su';
        // $this->left_sidebar = 'lay-left-sidebar/department_sidebar';
        $this->load->model('suspayment');
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
        $data['allSPayment'] = $this->suspayment->getAllEntry();
        $data['error_msg'] = $this->session->flashdata('error');
        $this->display('spControl',$data);
    }
    
    function createSPayment()
    {
        $this->title="";
        $this->display('spInsert');
    }

    function addSPayment()
    {
        $form_data = $this->input->post(null, true);
        
        if ($form_data == null ) redirect( base_url().'index.php/admHc/spAdmHc/createSPayment', 'refresh');
        else
        {
            $data = array (
                'nama_sumber_pembayaran' => $form_data['inputNamaSumberPembayaran']
            );  
            if($this->suspayment->insertNewEntry($data)=="true")
                redirect( base_url().'index.php/admHc/spAdmHc', 'refresh');
            else {
                echo 'error';
            }
        }
    }
    
    function updateSPayment()
    {
        $this->title="";
        $id = $this->input->get('id');
        
        $data['selectedSPayment'] = $this->suspayment->selectById($id);
        if ($data == null ) redirect( base_url().'index.php/admHc/spAdmHc', 'refresh');
        else
        {
            $this->display('spUpdate', $data);
        }
    }
    
    function saveUpdateSPayment()
    {
        $form_data = $this->input->post(null, true);
        if ($form_data == null ) redirect( base_url().'index.php/admHc/spAdmHc', 'refresh');
        else
        {
            $data = array (
                'nama_sumber_pembayaran' => $form_data['inputNamaSumberPembayaran']
            );
        }
        $this->suspayment->updateEntry($form_data['selectedSPayment'], $data); 
        redirect( base_url().'index.php/admHc/spAdmHc', 'refresh');   
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