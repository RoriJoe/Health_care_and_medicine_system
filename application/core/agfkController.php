<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

/*
-- Admin Gudang Farmasi Kabupaten
-- Hak akses no 16
*/
class agfkController extends MY_Controller{
    function __construct() {
        
        parent::__construct();
        $this->theme_folder='newui';
        $this->top_navbar = 'lay-top-navbar/navbar_agfk';
        // $this->script_footer = 'lay-scripts/footer_agfk';
        $this->load->library ('pagination');
        $this->load->helper ('url');
               
        if(!isset($this->session->userdata['telah_masuk']) && !isset($this->session->userdata['telah_masuk']["idha"])){
            $this->session->set_userdata(array('last_url' => current_url()));
            redirect('index.php/login/notAuthorized');
        }
        if(16!=$this->session->userdata['telah_masuk']["idha"])
        {   
            $this->session->set_userdata(array('last_url' => current_url()));
            redirect('index.php/login/notAuthorized');
        }
    }   
}
?>
