<?php if (!defined('BASEPATH'))     
	exit('No direct script access allowed');

// Operator Distribusi
// Hak akses no 24

class ogfkDistribusiController extends MY_Controller{
    
	function __construct() {        
        parent::__construct();
        
		$this->theme_folder='newui';		
        $this->top_navbar = 'lay-top-navbar/navbar_ogfk_distribusi';        
               
        if(!isset($this->session->userdata['telah_masuk']) && !isset($this->session->userdata['telah_masuk']["idha"])){
            $this->session->set_userdata(array('last_url' => current_url()));
            redirect('index.php/login/notAuthorized');
        }
		
        if(24!=$this->session->userdata['telah_masuk']["idha"]){   
            $this->session->set_userdata(array('last_url' => current_url()));
            redirect('index.php/login/notAuthorized');
        }
    }   
}
?>
