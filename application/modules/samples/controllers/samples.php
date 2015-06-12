<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * @package		Controller - CIMasterArtcak
 * @author		Felix - Artcak Media Digital
 * @copyright	Copyright (c) 2014
 * @link		http://artcak.com
 * @since		Version 1.0
 * @description
 * Contoh Tampilan administrator dashbard
 */

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class samples extends samplesController {

    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->load->model('samples/mHomeCommon');
    }

    /*
     * Digunakan untuk menampilkan dashboard di awal. Setiap tampilan view, harap menggunakan fungsi
     * index(). Pembentukan view terdiri atas:
     * 1. Title
     * 2. Set Partial Header
     * 3. Set Partial Right Top Menu
     * 4. Set Partial Left Menu
     * 5. Body
     * 6. Data-data tambahan yang diperlukan
     * Jika tidak di-set, maka otomatis sesuai dengan default
     */

    public function index() {
        $this->theme_layout = 'template_samples';
        $this->top_navbar = 'lay-top-navbar/navbar_samples';
        $this->script_header = 'lay-scripts/header_samples';
        $this->script_footer = 'lay-scripts/footer_samples_new';
        $this->display('acHome_2');
    }
    function getSearch() {
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');

        $teks = $data['tanda'];
        $temp1 = $this->mHomeCommon->select_obat($teks);
        $data["submit"] = $this->getPivot($temp1);
        return $data["submit"];
    }

    function all() {
        $temp1 = $this->mHomeCommon->get_obat();
        $data["submit"] = $this->getPivot($temp1);
        return $data["submit"];
    }

    function clean($string) {
        return preg_replace('/[^A-Za-z0-9\-@ .,]/', '-', $string); // Removes special chars.
    }

    private function getPivot($data) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        $header = "[[";
        foreach ($data as $value) {
			$header .= '"NOMOR"';
            foreach ($value as $key => $sembarang) {
				$header .= ',"' . str_replace("_", " ", strtoupper($key)) . '"';
            }
            $header .= ",\"KELOLA\"]";
            break;
        }
		
		$counter = 1;
        foreach ($data as $value) {
            $header .= ",[";
			$header .= '"'.$counter.'"';
			$counter++;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                $header .= ',"' . $data . '"';
            }
            $header .= ',"<button onclick=\"fungsi_alert(\'' . $value->ID_ICD . '\',\'' . $value->CATEGORY . '\',\'' . $value->SUBCATEGORY . '\',\'' . $value->ENGLISH_NAME . '\',\'' . $value->INDONESIAN_NAME . '\')\" class=\"btn btn-primary\">Pilih</button>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }

}
