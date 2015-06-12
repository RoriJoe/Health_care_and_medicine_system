<?php if (!defined('BASEPATH'))     
	exit('No direct script access allowed');

// Operator Distribusi
// Hak akses no 23

class ogfkPencatatanController extends MY_Controller{
    
	function __construct() {        
        parent::__construct();
        
		$this->theme_folder='newui';		
        $this->top_navbar = 'lay-top-navbar/navbar_ogfk_pencatatan';        
               
        if(!isset($this->session->userdata['telah_masuk']) && !isset($this->session->userdata['telah_masuk']["idha"])){
            $this->session->set_userdata(array('last_url' => current_url()));
            redirect('index.php/login/notAuthorized');
        }
		
        if(23!=$this->session->userdata['telah_masuk']["idha"]){   
            $this->session->set_userdata(array('last_url' => current_url()));
            redirect('index.php/login/notAuthorized');
        }
    }   
}
?>
