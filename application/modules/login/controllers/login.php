<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class Login extends samplesController {

    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->top_navbar = 'lay-top-navbar/navbar_samples';
        $this->theme_layout = 'template_login';
        $this->script_header = 'lay-scripts/header_login';
        $this->script_footer = 'lay-scripts/footer_login';
        $this->load->model('login/mlogin');
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
//        --start of maintenance code--
//        untuk maintenance aktifkan kode dibawah ini
//        if (isset($this->session->userdata['telah_masuk']["idha"])) {
//            redirect('login/logout');
//        } else {
//            redirect('maintenance');
//        }
//        --end of maintenance code--
        
        if (isset($this->session->userdata['telah_masuk']["idha"])) {
            $this->redirectByTipeUser();
        } else {
            $data['error'] = "";
            $this->display('cLogin', $data);
        }
    }

    function checkLogin() {
        if (isset($this->session->userdata['telah_masuk']["idha"])) {
            $this->redirectByTipeUser();
        }
    }

    function submitLogin() {
        $this->checkLogin();
        $noid = $this->input->post('noid');
        $password = $this->input->post('password');
        if (!isset($noid) && !isset($password) && ord($password) == 0 && ord($noid) == 0) {
            $this->erorlogin(false);
        } else {
            $result = $this->mlogin->login($noid, $password);
            $session_arr = array();

            if (count($result) >= 2) {
                $session_arr = array(
                    "tempid" => $noid,
                    "temppwd" => $password);
                $this->session->set_userdata("tempsaja", $session_arr);
                $data['result'] = $result;
                $this->display('cChoose', $data);
            } else if (count($result) == 1) {
                $no_id = $this->input->post('noid');
                $acc_related = $this->mlogin->getAccRelated($no_id);
                $session_arr = array("idha" => $result[0]->ID_HAKAKSES,
                    "namauser" => $result[0]->NAMA_AKUN,
                    "hakakses" => $result[0]->NAMA_HAKAKSES,
                    "noid" => $no_id,
                    "idakun" => $acc_related[0]['ID_AKUN'],
                    "namagedung" => $acc_related[0]['NAMA_GEDUNG'],
                    "idgedung" => $acc_related[0]['ID_GEDUNG'],
                    "namaunit" => $acc_related[0]['NAMA_UNIT'],
                    "idunit" => $acc_related[0]['ID_UNIT']
                        // bisa ditambahkan sendiri
                );
                $this->session->set_userdata("telah_masuk", $session_arr);
                $this->redirectByTipeUser();
            } else {
                $this->erorlogin(false);
            }
        }
    }

    function loginMultiAccount() {
        $ha = $this->input->post('akses');
        $noid = $this->session->userdata['tempsaja']["tempid"];
        $password = $this->session->userdata['tempsaja']["temppwd"];
        $result = $this->mlogin->loginMulti($noid, $password, $ha);
        if (!isset($ha)) {
            $this->erorlogin(false);
        } else if (!empty($result)) {

            $session_arr = array();
            $session_arr = array("idha" => $result[0]->ID_HAKAKSES,
                "namauser" => $result[0]->NAMA_AKUN,
                "hakakses" => $result[0]->NAMA_HAKAKSES,
                "noid" => $result[0]->NOID,
                "idakun" => $result[0]->ID_AKUN,
                "namagedung" => $result[0]->NAMA_GEDUNG,
                "idgedung" => $result[0]->ID_GEDUNG,
                "namaunit" => $result[0]->NAMA_UNIT,
                "idunit" => $result[0]->ID_UNIT
            );
            $this->session->set_userdata("telah_masuk", $session_arr);
            $this->session->set_userdata('tempsaja', NULL);
            $this->redirectByTipeUser();
        }
    }

    function chooseAs($data) {
        $this->display('cChoose', $data);
    }

    function redirectByTipeUser() {
        if (1 == $this->session->userdata['telah_masuk']["idha"])
            redirect('drugHc/kp/');
        else if (2 == $this->session->userdata['telah_masuk']["idha"])
            redirect('drugHc/gop/monitoringObat/gop');
        else if (3 == $this->session->userdata['telah_masuk']["idha"])
            redirect('drugHc/lo/resepPasien/list');
        else if (4 == $this->session->userdata['telah_masuk']["idha"])
            redirect('doctor');
        else if (5 == $this->session->userdata['telah_masuk']["idha"])
            redirect('uHC/ap');
        else if (6 == $this->session->userdata['telah_masuk']["idha"])
            redirect('family/kia/queue');
        else if (7 == $this->session->userdata['telah_masuk']["idha"])
            redirect('inventory/tu');
        else if (8 == $this->session->userdata['telah_masuk']["idha"])
            redirect('regBooth');
        else if (9 == $this->session->userdata['telah_masuk']["idha"])
            redirect('poliumum');
        else if (10 == $this->session->userdata['telah_masuk']["idha"])
            redirect('dental/pg/queue');
        else if (11 == $this->session->userdata['telah_masuk']["idha"])
            redirect('emergency/ugd/queue');
        else if (12 == $this->session->userdata['telah_masuk']["idha"])
            redirect('laboratorium/lab');
        else if (13 == $this->session->userdata['telah_masuk']["idha"])
            redirect('care');
        else if (14 == $this->session->userdata['telah_masuk']["idha"])
            redirect('drugHc/kd/');
        else if (15 == $this->session->userdata['telah_masuk']["idha"])
            redirect('admHc/yk');
        else if (16 == $this->session->userdata['telah_masuk']["idha"])
            redirect('drugWH');
        else if (17 == $this->session->userdata['telah_masuk']["idha"])
            redirect('drugWH');
        else if (18 == $this->session->userdata['telah_masuk']["idha"])
            redirect('drugWH');
        else if (19 == $this->session->userdata['telah_masuk']["idha"])
            redirect('hClinic/sik/');
        else if (20 == $this->session->userdata['telah_masuk']["idha"])
            redirect('index.php/account/');
        else if (21 == $this->session->userdata['telah_masuk']["idha"])
            redirect('pustu/lp/registration/oldPatient');
        else if (22 == $this->session->userdata['telah_masuk']["idha"])
            redirect('birth');
		else if (23 == $this->session->userdata['telah_masuk']["idha"])
            redirect('drugWH');
		else if (24 == $this->session->userdata['telah_masuk']["idha"])
            redirect('drugWH');
		else if (25 == $this->session->userdata['telah_masuk']["idha"])
            redirect('drugWH');
    }

    function erorlogin($flag) {
        $data['error'] = "Username / Password Salah";
        $this->display('cLogin', $data);
    }

    function logout() {

        $this->session->set_userdata('telah_masuk', NULL);
        redirect("/");
    }

    function notAuthorized() {
        $this->display('cNotAuthorized');
    }

    //penjelasan fungsi getBuildingProperty(), diletakkan disini... 
    public function getBuildingProperty() {
        
    }

    //penjelasan fungsi getBuildingProperty(), diletakkan disini...
    //contoh private function, diawali _
    private function _getUser() {
        
    }

}
