<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class Control extends navController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->load->model('adetailha');
        $this->load->model('aaccount');
        $this->left_sidebar = 'lay-left-sidebar/account_sidebar';
        /*
        $this->theme_layout = 'template_login';
        $this->script_header = 'lay-scripts/header_login';
        $this->script_footer = 'lay-scripts/footer_login';
        $this->load->model('login/mLogin');*/
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
        $form_data = $this->input->post(null, true);
        $data['allAkun'] = $this->aaccount->getAllEntry();
        $data['error_msg'] = $this->session->flashdata('error');
        $this->display('aControl',$data);
    }
    
    function createAccount()
    {
        $this->title="";
        $this->display('aRegister');
    }

    function addAccount()
    {
        $form_data = $this->input->post(null, true);
        
        if ($form_data == null ) redirect( base_url().'index.php/account', 'refresh');
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
                'agama' => $form_data['inputAgama'],
                'status_pegawai' => $form_data['inputStatus']
            );
            if($this->aaccount->insertNewEntry($data)=="true")
            {
                $idAkun = $this->aaccount->findID($form_data['inputNoid']);
                foreach($form_data['inputAkses'] as $ha)
                {
                    $data = array (
                    'id_akun' =>$idAkun[0]['ID_AKUN'],
                    'id_hakakses' => $ha
                    );
                    $this->adetailha->insertNewEntry($data);
                }
                redirect( base_url().'index.php/account', 'refresh');
            }else {
                echo 'error';
            }
        }
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
        redirect( base_url().'index.php/account/control/updateAccount', 'refresh');
    }
    
    function removeAccount()
    {
        $id = $this->input->get('id');
        if(!is_null($id))
        $this->aaccount->deleteById ($id);
    }
}