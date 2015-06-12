<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class RHCare extends backendController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        /*
        $this->theme_layout = 'template_login';
        $this->script_header = 'lay-scripts/header_login';
        $this->script_footer = 'lay-scripts/footer_login';
        $this->load->model('login/mLogin');*/
		$this->load->library('Pdf');
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
    }
    
    function hCareReportPdf()
    {
        $this->load->view('hCare');
    }

	function drugStockCardPdf()
    {
        $this->load->view('drugStockCard');
    }
	
	function drugAchievedPdf()
    {
        $this->load->view('drugAchieved');
    }
	
	function drugUsedPdf()
    {
        $this->load->view('drugUsed');
    }
}