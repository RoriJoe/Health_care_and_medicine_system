<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class yk extends backendController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->top_navbar = 'lay-top-navbar/ykNavbar';
        $this->load->model('suspayment');
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
		redirect(base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/manageSPayment');
    }
    
    function manageSPayment()
    {
        $this->title="";
        $data['allSPayment'] = $this->suspayment->getAllEntry();
        $this->display('spControl',$data);
    }

    function addSPayment()
    {
        $form_data = $this->input->post(null, true);
        
        if ($form_data == null ) redirect( base_url().'index.php/admHc/spAdmHc/createSPayment', 'refresh');
        else
        {
            $data = array (
                'nama_sumber_pembayaran' => $form_data['inputNamaSumberPembayaran']
            );  
            if($this->suspayment->insertNewEntry($data)=="true")
                redirect( base_url().'index.php/admHc/spAdmHc', 'refresh');
            else {
                echo 'error';
            }
        }
    }
    
    function updateSPayment()
    {
        $this->title="";
        $id = $this->input->get('id');
        
        $data['selectedSPayment'] = $this->suspayment->selectById($id);
        if ($data == null ) redirect( base_url().'index.php/admHc/spAdmHc', 'refresh');
        else
        {
            $this->display('spUpdate', $data);
        }
        
    }
    
    function saveUpdateSPayment()
    {
        $nama =$this->input->post('updateNamaSumberPembayaran'); 
        $id =$this->input->post('selectedSPayment');
		echo $nama;
        $form_data = $this->input->post(null, true);
            $data = array (
                'nama_sumber_pembayaran' => $nama
            );
        $this->suspayment->updateEntry($id, $data);
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
            $header .= ',"<button data-toggle=\"modal\" href=\"#myModal\" onclick=\"setObat(\''.$value->ID_DETIL_TO.'\',\''.$value->ID_OBAT.'\',\''.$value->NOMOR_BATCH.'\',\''.$value->NAMA_OBAT.'\',\''.$value->STOK.'\',\''.$value->SATUAN.'\',\''.$value->EXPIRED_DATE.'\')\" class=\"btn btn-primary\">Pilih</button>"';
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
	
	private function getPivotSP($data) {
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
            $header .= ',"<a id=\"'.$value['ID_SUMBER'].'_'.$value['NAMA_SUMBER_PEMBAYARAN'].'\" style=\"color: white;\" type=\"button\" onClick=update(this.id) class=\"btn btn-primary\"  data-toggle=\"modal\" href=\"#updateData\">Ubah</a>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }
	
	function getSPayment()
    {
		$result = $this->suspayment->getAllEntry();
		if ($result) 
		echo $this->getPivotSP($result);
		else echo "[[\"NAMA RUANGAN\", \"KELOLA\"], [\"Kosong\", \"Kosong\"]]";
    }
}