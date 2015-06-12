<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class Sik extends sikController {
    
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
        $this->load->model('ppuskesmas');*/
        $this->top_navbar = 'lay-top-navbar/sikNavbar';
		$this->load->model('ppuskesmas');
		$this->load->model('drugachieved_model');
		$this->load->model('drugused_model');
		$this->load->model('unit_model');
		$this->load->model('lplpo_model');
		$this->load->model('disease_model');
		$this->load->model('sdm_model');
		$this->load->model('inventaris_model');
		$this->load->library('Pdf');
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
    }
    
	public function AllunitInPuskesmas () {
		$id = $this->input->post('id');
		$data['units'] = $this->unit_model->getUnitByInputHC($id);
		echo json_encode($data);
	}
	
	function opname()
    {
		$data['allUnit'] = $this->unit_model->getUnitByHC();
		if($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 19)
		$data['allHC'] = $this->ppuskesmas->getAllEntry();
		else
		$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
        $this->display('opnameview', $data);
    }
	
	function opnamepdf()
    {
		$form_data = $this->input->post(null, true);
		$idPuskesmas = $form_data['inputHC'];
		$idUnit = $form_data['inputUnit'];
		$from = $this->convert ($form_data['inputDari']);
		$till = $this->convert ($form_data['inputHingga']);
		if($idPuskesmas == '')
		{
			$idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
			$data['idUnit'] = $this->session->userdata['telah_masuk']['idunit'];
			$data['namaUnit'] = $this->session->userdata['telah_masuk']['namaunit'];
		}
		else
		{
			echo $idPuskesmas;
			$unitDetail = $this->unit_model->getUnitById($idUnit);
			$data['idUnit'] = $idUnit;
			$data['namaUnit'] = $unitDetail[0]['NAMA_UNIT'];
		}
		$data['lplpo'] = $this->lplpo_model->getAllLplpo($idPuskesmas,$idUnit, $from, $till);
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);
		
		$this->load->view('opname', $data);
    }
	
    function LPLPO()
    {
		$data['allUnit'] = $this->unit_model->getUnitByHC();
		if($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 19)
		$data['allHC'] = $this->ppuskesmas->getAllEntry();
		else
		$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
        $this->display('LPLPOview', $data);
    }
	
	function LPLPOpdf()
    {
		$form_data = $this->input->post(null, true);
		$idPuskesmas = $form_data['inputHC'];
		$idUnit = $form_data['inputUnit'];
		$from = $this->convert ($form_data['inputDari']);
		$till = $this->convert ($form_data['inputHingga']);
		if($idPuskesmas == '')
		{
			$idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
			$data['idUnit'] = $this->session->userdata['telah_masuk']['idunit'];
			$data['namaUnit'] = $this->session->userdata['telah_masuk']['namaunit'];
		}
		else
		{
			echo $idPuskesmas;
			$unitDetail = $this->unit_model->getUnitById($idUnit);
			$data['idUnit'] = $idUnit;
			$data['namaUnit'] = $unitDetail[0]['NAMA_UNIT'];
		}
		$data['lplpo'] = $this->lplpo_model->getAllLplpo($idPuskesmas,$idUnit, $from, $till);
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);
		
		$this->load->view('LPLPO', $data);
    }
	
	function LPLPOHc()
    {
		$data['allUnit'] = $this->unit_model->getUnitByHC();
		if($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 19)
		$data['allHC'] = $this->ppuskesmas->getAllEntry();
		else
		$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
        $this->display('LPLPOHcview', $data);
    }
	
	function LPLPOHcpdf()
    {
		$form_data = $this->input->post(null, true);
		$idPuskesmas = $form_data['inputHC'];
		$from = $this->convert ($form_data['inputDari']);
		$till = $this->convert ($form_data['inputHingga']);
		if($idPuskesmas == '')
		{
			$idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
		}
			$data['namaUnit'] = 'dummy';
		$data['lplpo'] = $this->lplpo_model->getAllLplpoPuskesmas($idPuskesmas, $from, $till);
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);
		
		$this->load->view('LPLPOHc', $data);
    }
	
	function drugAchievedUnitdf()
    {
		if($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 19)
		$data['allHC'] = $this->ppuskesmas->getAllEntry();
		else	//if kepala puskesmas
		{
			$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
			$data['allUnit'] = $this->unit_model->getUnitByHC();
		}
		$this->display('drugAchievedView', $data);
    }
	
	function drugAchieved()
    {
        $form_data = $this->input->post(null, true);
		$puskesmas = $form_data['inputHC'];
		$unit = $form_data['inputUnit'];
		$from = $form_data['inputDari'];
		$till = $form_data['inputHingga'];
		// if($idUnit == '')
		// {
			// $idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
			// $data['idUnit'] = $this->session->userdata['telah_masuk']['idunit'];
			// $data['namaUnit'] = $this->session->userdata['telah_masuk']['namaunit'];
		// }
		// else
		// {
			$unitDetail = $this->unit_model->getUnitById($unit);
			// $data['idUnit'] = $idUnit;
			$data['namaUnit'] = $unitDetail[0]['NAMA_UNIT'];
		// }
		
		$data['dari'] = $from;
		$data['hingga'] = $till;
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($puskesmas);
		$data['allDrugAchieved'] = $this->drugachieved_model->getAllAchievedDrugDetail($puskesmas,$unit,$from, $till);
        $this->load->view('drugAchieved', $data);
    }
	
	function drugUsedUnitdf()
	{
		if($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 19)
		$data['allHC'] = $this->ppuskesmas->getAllEntry();
		else	//if kepala puskesmas
		{
			$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
			$data['allUnit'] = $this->unit_model->getUnitByHC();
		}
		$this->display('drugUsedView', $data);
	}
	
	function drugUsed($idPuskesmas = '', $idUnit = '')
    {
        $form_data = $this->input->post(null, true);
		$puskesmas = $form_data['inputHC'];
		$unit = $form_data['inputUnit'];
		$from = $form_data['inputDari'];
		$till = $form_data['inputHingga'];
		// if($idUnit == '')
		// {
			// $idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
			// $data['idUnit'] = $this->session->userdata['telah_masuk']['idunit'];
			// $data['namaUnit'] = $this->session->userdata['telah_masuk']['namaunit'];
		// }
		// else
		// {
			$unitDetail = $this->unit_model->getUnitById($unit);
			// $data['idUnit'] = $idUnit;
			$data['namaUnit'] = $unitDetail[0]['NAMA_UNIT'];
		// }
		$data['dari'] = $from;
		$data['hingga'] = $till;
		$data['allDrugUsed'] = $this->drugused_model->getAllUsedDrugDetail($puskesmas,$unit,$from, $till);
		//echo $data['allDrugUsed'];
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($puskesmas);
        $this->load->view('drugUsed', $data);
    }
	
	function pRIPdf()
    {
        $this->load->view('pelayananRawatInap');
    }
	
	function pKesPdf()
    {
        $this->load->view('pelayananKesehatan');
    }
	
	function pPustuPdf()
    {
        $this->load->view('pelayananPustu');
    }
	
	function pPonkesdesPdf()
    {
        $this->load->view('pelayananPonkesdes');
    }
	
	function pPolindesPdf()
    {
        $this->load->view('pelayananPolindes');
    }
	
	function opnameStockPdf($idPuskesmas=1, $idUnit = 13)
    {
		if($idPuskemas == '')
		{
			$idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
			$data['idUnit'] = $this->session->userdata['telah_masuk']['idunit'];
			$data['namaUnit'] = $this->session->userdata['telah_masuk']['namaunit'];
		}
		else
		{
			$unitDetail = $this->unit_model->getUnitById($idUnit);
			$data['idUnit'] = $idUnit;
			$data['namaUnit'] = $unitDetail[0]['NAMA_UNIT'];
		}
		
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);
        $this->load->view('opnameStock', $data);
    }
	
	function cardStockParentPdf()
    {
        $this->load->view('cardStockParent');
    }
	
	function cardStockHCarePdf()
    {
        $this->load->view('cardStockHCare');
    }
	
	function drugStockCardPdf()
    {
		if($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 19)
			$data['allHC'] = $this->ppuskesmas->getAllEntry();
		else
			$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
        
		$this->display('drugStockView', $data);
    }
	
	function drugStockCard()
    {
		$form_data = $this->input->post(null, true);
		if($this->session->userdata['telah_masuk']['idha'] != 14 && $this->session->userdata['telah_masuk']['idha'] != 19)
		{
			$idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
		}
		else
		{
			$idPuskesmas = $form_data['inputHC'];
		}
		
		$idUnit = $this->unit_model->getGOPID($idPuskesmas);
		$idUnit = $idUnit[0]['ID_UNIT'];
		$from = $form_data['inputDari'];
		$till = $form_data['inputHingga'];
		
		$unitDetail = $this->unit_model->getUnitById($idUnit);
		$data['idUnit'] = $idUnit;
		$data['namaUnit'] = $unitDetail[0]['NAMA_UNIT'];
		$data['lplpo'] = $this->lplpo_model->getAllLplpo($idPuskesmas,$idUnit, $from, $till);
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);
		
		$this->load->view('drugStockCard', $data);
    }
	
	function inventarisPdf()
    {
		if($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 19)
			$data['allHC'] = $this->ppuskesmas->getAllEntry();
		else
			$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
			
        $this->display('inventarisView', $data);
    }
	
	function inventaris()
    {
		$form_data = $this->input->post(null, true);
		if($this->session->userdata['telah_masuk']['idha'] != 14 && $this->session->userdata['telah_masuk']['idha'] != 19)
		{
			$idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
		}
		else
		{
			$idPuskesmas = $form_data['inputHC'];
		}
		
		$from = $form_data['inputDari'];
		$till = $form_data['inputHingga'];
		
		$data['inventaris'] = $this->inventaris_model->getAllEntry($idPuskesmas, $from, $till);
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);
		
        $this->load->view('inventaris', $data);
    }
	function drugAchievedPdf()
    {
        $this->load->view('drugAchieved');
    }
	
	function drugUsedPdf()
    {
        $this->load->view('drugUsed');
    }
	
	function hServicePdf()
    {
        $this->load->view('hCare');
    }
	
	function sdmHc()
    {
        if($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 19)
		$data['allHC'] = $this->ppuskesmas->getAllEntry();
		else	//if kepala puskesmas
		{
			$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
		}
		$this->display('sdmView', $data);
    }
	
	function sdmHcPdf()
    {
        $form_data = $this->input->post(null, true);
		$puskesmas = $form_data['inputHC'];
		// if($idUnit == '')
		// {
			// $idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
			// $data['idUnit'] = $this->session->userdata['telah_masuk']['idunit'];
			// $data['namaUnit'] = $this->session->userdata['telah_masuk']['namaunit'];
		// }
		// else
		// {
			$puskesmasDetail = $this->ppuskesmas->selectById($puskesmas);
			// $data['idUnit'] = $idUnit;
			$data['namaPuskesmas'] = $puskesmasDetail[0]['NAMA_GEDUNG'];
		// }
		
		$data['allSDM'] = $this->sdm_model->getSDMByHC($puskesmas);
        $this->load->view('sdmHc', $data);
    }
	
	function hCare()
    {
        if($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 19)
		$data['allHC'] = $this->ppuskesmas->getAllEntry();
		else	//if kepala puskesmas
		{
			$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
		}
		$this->display('hCareView', $data);
    }
	
	function hCarePdf()
    {
        $form_data = $this->input->post(null, true);
		$puskesmas = $form_data['inputHC'];
		$bulan = $form_data['bulan'];
		$tahun = $form_data['tahun'];
		$puskesmasDetail = $this->ppuskesmas->selectById($puskesmas);
		$data['namaPuskesmas'] = $puskesmasDetail[0]['NAMA_GEDUNG'];
		$data['kec'] = $puskesmasDetail[0]['KECAMATAN_GEDUNG'];
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['allSDM'] = $this->sdm_model->getSDMByHC($puskesmas);
		
        $this->load->view('hCare', $data);
    }
	
	function diseasePdf()
    {
		if($this->session->userdata['telah_masuk']['idgedung'] == 19 || $this->session->userdata['telah_masuk']['idha'] == 14)
			$data['allHC'] = $this->ppuskesmas->getAllEntry();
		else
			$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
			
        $this->display('diseaseView', $data);
    }
	
	function disease()
    {
		$form_data = $this->input->post(null, true);
		if($this->session->userdata['telah_masuk']['idha'] != 19 && $this->session->userdata['telah_masuk']['idha'] != 14)
		{
			$idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
		}
		else
		{
			$idPuskesmas = $form_data['inputHC'];
		}
		
		$from = $form_data['inputDari'];
		$till = $form_data['inputHingga'];
		$data['from'] = $form_data['inputDari'];
		$data['till'] = $form_data['inputHingga'];
		$data['disease'] = $this->disease_model->getDiseaseDetail($idPuskesmas, $from, $till);
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);
		
        $this->load->view('disease', $data);
    }
}