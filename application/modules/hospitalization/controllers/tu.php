<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class Tu extends tuController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->top_navbar = 'lay-top-navbar/tuNavbar';
        $this->load->model('categorytt_model');
        $this->load->model('bedroom_model');
        $this->load->model('room_model');
        $this->load->model('unit_model');
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
		redirect(base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/manageRoom');		
    }
	
	//Sumber Pembayaran
	function manageRoom()
    {
        $this->title="";
        $data['allRoom'] = $this->room_model->getAllEntry();
        $this->display('rControl',$data);
    }

    function addRoom()
    {
        $form_data = $this->input->post(null, true);
        
        if ($form_data == null ) redirect( base_url().'index.php/admHc/spAdmHc/createSPayment', 'refresh');
        else
        {
			$hoz = $this->unit_model->getHozpitalizeByHC();
            $data = array (
                'nama_ruangan_ri' => $form_data['inputNamaRuangan'],
                'id_unit' => $hoz[0]['ID_UNIT']
            );  
            if($this->room_model->insertNewEntry($data)=="true")
                redirect( base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/manageRoom', 'refresh');
            else {
                echo 'error';
            }
        }
    }
    
    function saveUpdateRoom()
    {
        $nama =$this->input->post('updateNamaRoom'); 
        $id =$this->input->post('selectedRoom');
		echo $nama;
        $form_data = $this->input->post(null, true);
            $data = array (
                'nama_ruangan_ri' => $nama
            );
        $this->room_model->updateEntry($id, $data);
    }
    
	function getRoom()
    {
		$result = $this->room_model->getAllEntry ();
		if ($result) 
		echo $this->getPivot ($result);
		else echo "[[\"NAMA RUANGAN\", \"KELOLA\"], [\"Kosong\", \"Kosong\"]]";
    }
	
	function getBedroom()
    {
		$result = $this->bedroom_model->getAllEntry ();
		if ($result) 
		echo $this->getPivotBedroom ($result);
		else echo "[[\"NOMOR TEMPAT TIDUR\",\"NAMA KATEGORI\",\"NAMA RUANGAN\",\"KELOLA\"], [\"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\"]]";
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
            $header .= ",\"KELOLA\"]";
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
            $header .= ',"<a id=\"'.$value['ID_RUANGAN'].'_'.$value['NAMA_RUANGAN'].'\" style=\"color: white;\" type=\"button\" onClick=update(this.id) class=\"btn btn-primary\"  data-toggle=\"modal\" href=\"#updateData\">Ubah</a>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }
	
	private function getPivotBedroom($data) {
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
            $header .= ",\"KELOLA\"]";
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
            $header .= ',"<a id=\"'.$value['ID_TEMPAT_TIDUR'].'_'.$value['NOMOR_TEMPAT_TIDUR'].'_'.$value['ID_KAT_TT'].'_'.$value['ID_RUANGAN_RI'].'\" style=\"color: white;\" type=\"button\" onClick=update(this.id) class=\"btn btn-primary\"  data-toggle=\"modal\" href=\"#updateData\">Ubah</a>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }
	
    function removeDepartment()
    {
        $form_data = $this->input->post(null, true);
        if(!is_null($form_data['selected']))
        {
            $this->dDepartment->deleteById ($form_data['selected']);
            redirect( base_url().'index.php/hClinic', 'refresh');
        }
    }
	//Sumber Pembayaran End
	
	//Pangkat
	function manageBR()
    {
		$ownUnit = $this->unit_model->getHozpitalizeByHC();
        $data['allCategoryTT'] = $this->categorytt_model->getAllCTT();
        $data['allBRoom'] = $this->bedroom_model->getAllEntry();
        $data['allHRoom'] = $this->room_model->selectByIdUnit($ownUnit[0]['ID_UNIT']);
        $this->display('brControl',$data);
    }

    function addBR()
    {
        $form_data = $this->input->post(null, true);
        
        if ($form_data == null ) redirect( base_url().'index.php/admHc/rAdmHc/createRank', 'refresh');
        else
        {
            $data = array (
                'nomor_tempat_tidur' => $form_data['inputNoTT'],
                'id_kat_tt' => $form_data['inputIdKTT'],
                'id_ruangan_ri' => $form_data['inputIdRRI']
            );  
            if($this->bedroom_model->insertNewEntry($data)=="true")
                redirect( base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0)."/manageBR", 'refresh');
            else {
                echo 'error';
            }
        }
    }
    
    function updateRank()
    {
        $this->title="";
        $id = $this->input->get('id');
        
        $data['selectedRank'] = $this->surank->selectById($id);
        if ($data == null ) redirect( base_url().'index.php/admHc/rAdmHc', 'refresh');
        else
        {
            $this->display('rUpdate', $data);
        }
        
    }
    
	function saveUpdateBR()
    {
        $nama =$this->input->post('updateNoTT'); 
		$gol =$this->input->post('updateIdKTT'); 
		$ruang =$this->input->post('updateIdRRI'); 
        $id =$this->input->post('selectedTT');
		echo $nama;
        $form_data = $this->input->post(null, true);
            $data = array (
                'nomor_tempat_tidur' => $nama,
                'id_kat_tt' => $gol,
                'id_ruangan_ri' => $ruang
            );
        $this->bedroom_model->updateEntry($id, $data);
    }
	//Pangkat End
}