<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* controller di setiap modul dapat extends pada controller admin. Berfungsi untuk membatasi hak akses */

class lpController extends MY_Controller {

    public $mUnit, $mPaymentSource, $mPatient, $mMedicalRecord, $mMRHistory, $mQueue;

    function __construct() {

        parent::__construct();
        $this->theme_folder = 'newui';
        // $this->script_header = 'lay-scripts/header_pivot';
        $this->top_navbar = 'lay-top-navbar/navbar_lp';
        // $this->script_footer = 'lay-scripts/footer_lp';

        $this->mMedicalRecord = $this->load->model('Mr_model');
        $this->mMRHistory = $this->load->model('Mrh_model');
        $this->mPatient = $this->load->model('Patient_model');
        $this->mPaymentSource = $this->load->model('Payment_model');
        $this->mUnit = $this->load->model('Unit_model');
        $this->mQueue = $this->load->model('Queue_model');

        if (!isset($this->session->userdata['telah_masuk']) && !isset($this->session->userdata['telah_masuk']["idha"])) {
            $this->session->set_userdata(array('last_url' => current_url()));
            redirect('index.php/login/notAuthorized');
        }
        if (8 != $this->session->userdata['telah_masuk']["idha"]) {
            $this->session->set_userdata(array('last_url' => current_url()));
            redirect('index.php/login/notAuthorized');
        }
    }

    public function _setFlashData($status) {
        $key = 'error';
        if ($status == true)
            $message = 'success';
        else
            $message = 'failed';

        $this->session->set_flashdata($key, $message);
    }

    function clean($string) {
        //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        //return str_replace(array('\'', '\\', '/', '*'), ' ', $string);
        return preg_replace('/[^A-Za-z0-9\-@ .,]/', '-', $string); // Removes special chars.
    }

}

?>
