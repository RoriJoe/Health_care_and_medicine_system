<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

/*
-- Admin Gudang Farmasi Kabupaten
-- Hak akses no 16
*/
class navController extends MY_Controller{
    function __construct() {
        
        parent::__construct();
        $this->theme_folder='newui';
        $this->load->library ('pagination');
        $this->load->helper ('url');
               
        if(!isset($this->session->userdata['telah_masuk']) && !isset($this->session->userdata['telah_masuk']["idha"])){
            $this->session->set_userdata(array('last_url' => current_url()));
            redirect('index.php/login/notAuthorized');
        }
		
        switch($this->session->userdata['telah_masuk']["idha"]){
			case 1 :
				$this->top_navbar = 'lay-top-navbar/kpnavbar';
			break;
			case 2 :
				$this->top_navbar = 'lay-top-navbar/gopnavbar';
			break;
			case 3 :
				$this->top_navbar = 'lay-top-navbar/lonavbar';
			break;
			case 4 :
				$this->top_navbar = 'lay-top-navbar/apnavbar';
			break;
			case 5 :
				$this->top_navbar = 'lay-top-navbar/apnavbar';
			break;
			case 6 :
				$this->top_navbar = 'lay-top-navbar/kianavbar';
			break;
			case 7 :
				$this->top_navbar = 'lay-top-navbar/tunavbar';
			break;
			case 8 :
				$this->top_navbar = 'lay-top-navbar/navber_lp';
			break;
			case 9 :
				$this->top_navbar = 'lay-top-navbar/navbar_pu';
			break;
			case 10 :
				$this->top_navbar = 'lay-top-navbar/pgnavbar';
			break;
			case 11 :
				$this->top_navbar = 'lay-top-navbar/ugdnavbar';
			break;
			case 12 :
				$this->top_navbar = 'lay-top-navbar/labnavbar';
			break;
			case 13 :
				$this->top_navbar = 'lay-top-navbar/navbar_ri';
			break;
			case 14 :
				$this->top_navbar = 'lay-top-navbar/kdnavbar';
			break;
			case 15 :
				$this->top_navbar = 'lay-top-navbar/yknavbar';
			break;
			case 16 :
				$this->top_navbar = 'lay-top-navbar/navbar_agfk';
			break;
			case 17 :
				$this->top_navbar = 'lay-top-navbar/navbar_kgfk';
			break;
			case 18 :
				$this->top_navbar = 'lay-top-navbar/navbar_ogfk';
			break;
			case 19 :
				$this->top_navbar = 'lay-top-navbar/siknavbar';
			break;
			case 18 :
				$this->top_navbar = 'lay-top-navbar/navbar_ogfk';
			break;
		}
    }   
}
?>
