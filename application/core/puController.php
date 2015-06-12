<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

/* controller di setiap modul dapat extends pada controller admin. Berfungsi untuk membatasi hak akses*/
class puController extends MY_Controller{
    function __construct() {
        
        parent::__construct();
        /* $this->top_navbar = 'lay-top-navbar/puNavbar';
        $this->script_header = 'lay-scripts/header_samples';
        $this->script_footer = 'lay-scripts/footer_samples'; */
		
        // $this->script_header = 'lay-scripts/header_pivot';
        $this->top_navbar = 'lay-top-navbar/navbar_pu';
        // $this->script_footer = 'lay-scripts/footer_poliumum';
        
        // $this->load->model ('mAccount');
        // $this->load->model ('mAssignment');
        // $this->load->model ('mQueue');
        // $this->load->model ('mMRHistory');
        // $this->load->model ('mCaseStatus');
        // $this->load->model ('mPatient');
        // $this->load->model ('mComplaint');
        // $this->load->model ('mDiagnosis');
        // $this->load->model ('mIcd');
        // $this->load->model ('unit_model');
        
               
        if(!isset($this->session->userdata['telah_masuk'])&& !isset($this->session->userdata['telah_masuk']["idha"])){
            $this->session->set_userdata(array('last_url' => current_url()));
            redirect('index.php/login/notAuthorized');
        }
        if(9!=$this->session->userdata['telah_masuk']["idha"])
        {   
            $this->session->set_userdata(array('last_url' => current_url()));
            redirect('index.php/login/notAuthorized');
        }
  
    }   

}
?>
