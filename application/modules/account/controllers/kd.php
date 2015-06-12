<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class Kd extends kdController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->top_navbar = 'lay-top-navbar/kdNavbar';
        $this->load->model('aaccount');
        $this->load->model('assignment');
        $this->load->model('unit_model');
        $this->load->model('assignment');
        $this->load->model('ddepartment');
        $this->load->model('access_model');
        $this->load->model('sdm_model');
        $this->load->model('ppuskesmas');
        $this->load->model('surank');
        /*
        $this->theme_layout = 'template_login';
        $this->script_header = 'lay-scripts/header_login';
        $this->script_footer = 'lay-scripts/footer_login';
        $this->load->model('login/mLogin');*/
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
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
        redirect( base_url().'index.php/account/'.$this->uri->segment(2, 0).'/updateOwnAccount', 'refresh');
    }
	
	function monitoringSDM()
    {
        if( $this->session->userdata['telah_masuk']['idha'] != 14 && $this->session->userdata['telah_masuk']['idha'] != 19)
			$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
		else
			$data['allHC'] = $this->ppuskesmas->getAllEntry();
			
        $this->display('kpMonitoringSDM',$data);
    }
	
	function getSDM()
    {
		if( $this->session->userdata['telah_masuk']['idha'] != 14 && $this->session->userdata['telah_masuk']['idha'] != 19)
			$result = $this->sdm_model->getSDMByHC ($this->session->userdata['telah_masuk']['idgedung']);
		else{
			$idgedung = $this->input->post('puskesmas');
			$result = $this->sdm_model->getSDMByHC ($idgedung);
		}
			
		if ($result) 
		echo $this->getPivot ($result);
		else echo "[[\"NIK\",\"NAMA\",\"JABATAN\",\"PANGKAT\",\"GOLONGAN\",\"STATUS PEGAWAI\"], [\"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\"]]";
    }
	
	function clean($string) {
        return preg_replace('/[^A-Za-z0-9\-@ .,]/', '-', $string); // Removes special chars.
    }
	
	private function getPivot($data) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        $header = "[[";
        foreach ($data as $value) {
            foreach ($value as $key => $sembarang) {
                $header .= '"' . str_replace("_", " ", strtoupper($key)) . '"';
                break;
            }
            $count = 1;
            foreach ($value as $key => $sembarang) {
                if ($count > 1) {
                    $header .= ',"' . str_replace("_", " ", strtoupper($key)) . '"';
                }
                $count ++;
            }
            $header .= "]";
            break;
        }
        $vartemp="";
        foreach ($data as $value) {
            $header .= ",[";
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
//                if ($key == "ID_ICD") {
//                    $header .= '"<a href=\'' . base_url() . 'index.php/linknya/disini/lho/' . $value->ID_ICD.'/'.$value->CATEGORY.'/'.$value->SUBCATEGORY.'/'.$value->ENGLISH_NAME.'/'.$value->INDONESIAN_NAME. '\'>' . $data . '</a>"';
//                }
//                else {
                    $header .= '"' . $data . '"';
//                }
                break;
            }
            $count = 1;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                if ($count > 1) {
//                    if ($key == "ID_ICD") {
//                        $header .= '"<a href=\'' . base_url() . 'index.php/linknya/disini/lho/' . $value->ID_ICD.'/'.$value->CATEGORY.'/'.$value->SUBCATEGORY.'/'.$value->ENGLISH_NAME.'/'.$value->INDONESIAN_NAME. '\'>' . $data . '</a>"';
//                    }
//                    else {
                        $header .= ',"' . $data . '"';
//                    }
                    
                }
                $count ++;
            }
           // $header .= ',"<a id=\"'.$value['ID_RUANGAN'].'_'.$value['NAMA_RUANGAN'].'\" style=\"color: white;\" type=\"button\" onClick=update(this.id) class=\"btn btn-primary\"  data-toggle=\"modal\" href=\"#updateData\">Ubah</a>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }
}