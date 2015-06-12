<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

/* controller di setiap modul dapat extends pada controller admin. Berfungsi untuk membatasi hak akses*/
class tuController extends MY_Controller{
    function __construct() {
        
        parent::__construct();
        $this->top_navbar = 'lay-top-navbar/tuNavbar';
               
        if(!isset($this->session->userdata['telah_masuk'])&& !isset($this->session->userdata['telah_masuk']["idha"])){
            $this->session->set_userdata(array('last_url' => current_url()));
            redirect('index.php/login/notAuthorized');
        }
        if(7!=$this->session->userdata['telah_masuk']["idha"])
        {   
            $this->session->set_userdata(array('last_url' => current_url()));
            redirect('index.php/login/notAuthorized');
        }
    }   
}
?>
