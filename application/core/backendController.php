<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

/* controller di setiap modul dapat extends pada controller admin. Berfungsi untuk membatasi hak akses*/
class backendController extends MY_Controller{
    function __construct() {
        
        parent::__construct();
        $this->theme_folder='newui';
        // $this->theme_folder='uistuff';
        // $this->top_navbar = 'lay-top-navbar/default';
               
//        if(!isset($this->session->userdata['telah_masuk'])&& !isset($this->session->userdata['telah_masuk']["privilege"])){
//            $this->session->set_userdata(array('last_url' => current_url()));
//            redirect('user/login', 'refresh');
//        }
//        if("admin"!=$this->session->userdata['telah_masuk']["privilege"])
//        {   
//            $this->session->set_userdata(array('last_url' => current_url()));
//            redirect('user/login', 'refresh');
//        }
//        if(0>=$this->session->userdata['telah_masuk']["id"])
//        {
//            $this->session->set_userdata(array('last_url' => current_url()));
//            redirect('user/login', 'refresh');
//        }
    }   
    
    // function _setFlashData ($status) {
    	// $key = 'error';
    	// if ($status == true)
    		// $message = 'success';
    	// else $message = 'failed';
    
    	// $this->session->set_flashdata ($key, $message);
    // }
	
	// function clean($string) {
        // //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        // //return str_replace(array('\'', '\\', '/', '*'), ' ', $string);
        // return preg_replace('/[^A-Za-z0-9\-@ .,]/', '-', $string); // Removes special chars.
    // }
}
?>
