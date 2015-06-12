<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class RAdmHc extends backendController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->top_navbar = 'lay-top-navbar/navbar_su';
        // $this->left_sidebar = 'lay-left-sidebar/department_sidebar';
        $this->load->model('surank');
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
        $data['allRank'] = $this->surank->getAllEntry();
        $data['error_msg'] = $this->session->flashdata('error');
        $this->display('rControl',$data);
    }
    
    function createRank()
    {
        $this->title="";
        $this->display('rInsert');
    }

    function addRank()
    {
        $form_data = $this->input->post(null, true);
        
        if ($form_data == null ) redirect( base_url().'index.php/admHc/rAdmHc/createRank', 'refresh');
        else
        {
            $data = array (
                'nama_pangkat' => $form_data['inputNamaPangkat'],
                'golongan' => $form_data['inputGolongan'],
                'ruang' => $form_data['inputRuang']
            );  
            if($this->surank->insertNewEntry($data)=="true")
                redirect( base_url().'index.php/admHc/rAdmHc', 'refresh');
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
    
    function saveUpdateRank()
    {
        $form_data = $this->input->post(null, true);
        if ($form_data == null ) redirect( base_url().'index.php/admHc/rAdmHc', 'refresh');
        else
        {
            $data = array (
                'nama_pangkat' => $form_data['inputNamaPangkat'],
                'golongan' => $form_data['inputGolongan'],
                'ruang' => $form_data['inputRuang']
            );
        }
        $this->surank->updateEntry($form_data['selectedRank'], $data); 
        redirect( base_url().'index.php/admHc/rAdmHc', 'refresh');   
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
	
	function getRoom()
    {
		$result = $this->surank->getAllEntry();
		if ($result) 
		echo $this->getPivot ($result);
		else echo "[[\"NAMA RUANGAN\", \"KELOLA\"], [\"Kosong\", \"Kosong\"]]";
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
            $header .= ',"<a id=\"'.$value['ID_PANGKAT'].'_'.$value['NAMA_PANGKAT'].'_'.$value['GOLONGAN'].'_'.$value['RUANG'].'\" style=\"color: white;\" type=\"button\" onClick=update(this.id) class=\"btn btn-primary\"  data-toggle=\"modal\" href=\"#updateData\">Ubah</a>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }
}