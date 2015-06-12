<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class Department extends backendController {
    
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
        $data['sidebar_enable']="true";
        $this->display('dControl',$data);
    }
}