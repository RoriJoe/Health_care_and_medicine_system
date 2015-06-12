<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

/* controller di setiap modul dapat extends pada controller admin. Berfungsi untuk membatasi hak akses*/
class kgfkController extends MY_Controller{
    function __construct() {
        
        parent::__construct();
		$this->theme_folder='newui';
        $this->top_navbar = 'lay-top-navbar/navbar_kgfk';
        // $this->script_footer = 'lay-scripts/footer_agfk';
        $this->load->library ('pagination');
        $this->load->helper ('url');
               
        if(!isset($this->session->userdata['telah_masuk'])&& !isset($this->session->userdata['telah_masuk']["idha"])){
            $this->session->set_userdata(array('last_url' => current_url()));
            redirect('index.php/login/notAuthorized');
        }
        if(17!=$this->session->userdata['telah_masuk']["idha"])
        {   
            $this->session->set_userdata(array('last_url' => current_url()));
            redirect('index.php/login/notAuthorized');
        }
    }   
}
?>
