<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index() {
        //file-file yang dipanggil parsial
//        $menu = "auTopMenu";
//        $header = "auHeader";
//        $footer = "auFooter";
        //Set Title
        $this->template->title("Master HMVC-Template - Atcak");
        //Set Layout
//        $this->template->set_layout('frontend');
        //set header
//        $this->template->set_partial("header", $header);
        //set menu
//        $this->template->set_partial("menu", $menu);
        //set footer
//        $this->template->set_partial("footer", $footer);
        $this->template->build("home_new.php",$data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */