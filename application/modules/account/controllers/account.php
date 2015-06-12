<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class Account extends backendController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->load->model('aaccount');
        $this->top_navbar = 'lay-top-navbar/accountNavbar';
        $this->left_sidebar = 'lay-left-sidebar/account_sidebar';
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
        $form_data = $this->input->post(null, true);
        $data['allAkun'] = $this->aaccount->getAllEntry();
        $data['error_msg'] = $this->session->flashdata('error');
        $this->display('aControl',$data);
    }
	
	function updateOwnAccount()
    {
        $this->title="";
        $id = $this->input->get('id');
        $akunData = $this->aaccount->selectById($this->session->userdata['telah_masuk']["idakun"]);
        $data['selectedAkun'] = $akunData;
		$data['check'] = $this->session->flashdata('checkPass');
        if ($data == null ) redirect( base_url().'index.php/account', 'refresh');
        else
        {
            $this->display('ownAccountUpdate', $data);
        }
        
    }
    
    function saveOwnUpdateOwnAccount()
    {
		$this->session->set_flashdata('checkPass','');
        $form_data = $this->input->post(null, true);
		$akunData = $this->aaccount->selectById($this->session->userdata['telah_masuk']["idakun"]);
        if ($form_data == null ) redirect( base_url().'index.php/Account', 'refresh');
        else
        {
            $data = array (
                'noid' => $form_data['inputNoid'],
                'nama_akun' => $form_data['inputNama'],
                'alamat' => $form_data['inputAlamat'],
                'jenis_kelamin' => $form_data['inputSex'],
                'telepon' => $form_data['inputTelepon'],
                'hp' => $form_data['inputHandphone'],
                'email' => $form_data['inputEmail'],
                'agama' => $form_data['inputAgama']
            );
			$this->aaccount->updateEntry($form_data['selectedAkun'], $data);
			
			if($form_data['inputOld'] != '' || $form_data['inputCheck'] != '' || $form_data['inputNew'] != '')
			{
				if($form_data['inputOld'] != $form_data['inputCheck'] || md5($form_data['inputOld']) != $akunData[0]['PASSWORD']){
					$this->session->set_flashdata('checkPass','passError');
				}
				elseif(md5($form_data['inputOld']) == $akunData[0]['PASSWORD'])
				{
					$pass = array (
						'password' => md5($form_data['inputNew'])
					);
					$this->aaccount->updateEntry($form_data['selectedAkun'], $pass);
				}
			}
        }
		$this->redirectByTipeUser();
        //redirect( base_url().'index.php/account/'.$this->uri->segment(2, 0).'/updateOwnAccount', 'refresh');
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
}