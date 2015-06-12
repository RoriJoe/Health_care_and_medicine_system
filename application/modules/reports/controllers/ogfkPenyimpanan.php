<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class ogfkPenyimpanan extends ogfkPenyimpananController {
    
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
		$this->load->model('ppuskesmas');
		$this->load->model('drugachieved_model');
		$this->load->model('drugused_model');
		$this->load->model('unit_model');
		$this->load->model('lplpo_model');
		$this->load->model('source_money');
		$this->load->model('sbbk_model');
		$this->load->model('sdm_model');
		$this->load->model('inventaris_model');
		$this->load->library('Pdf');
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
    }
	
    function hServicePdf()
    {
        $this->load->view('hCare');
    }
	
	function sbbk()
    {
		$form_data = $this->input->post(null, true);
		$idtransaksi = $form_data['idtransaksi'];
		$data['sbbk'] = $this->sbbk_model->getkk($idtransaksi);
        $this->load->view('sbbk', $data);
    }
	
	function opname()
    {
		$data['allUnit'] = $this->unit_model->getUnitByHC();
		if($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 19 || $this->session->userdata['telah_masuk']['idha'] == 17)
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
		$from = $form_data['inputDari'];
		$till = $form_data['inputHingga'];
		$data['dari'] = $from;
		$data['hingga'] = $till;
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
		$data['lplpo'] = $this->lplpo_model->getopnamegfk($idPuskesmas,$idUnit, $from, $till);
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);
		
		$this->load->view('opnameGFK', $data);
    }
	
    function LPLPO()
    {
		$data['allUnit'] = $this->unit_model->getUnitByHC();
		$data['allHC'] = $this->ppuskesmas->getAllEntry();
        $this->display('LPLPOview', $data);
    }
	
	function LPLPOpdf()
    {
		$form_data = $this->input->post(null, true);
		$idPuskesmas = $form_data['inputHC'];
		$idUnit = $form_data['inputUnit'];
		$from = $this->convert ($form_data['inputDari']);
		$till = $this->convert ($form_data['inputHingga']);

        $data['nKP'] = $form_data['nKP'];
        $data['nPP'] = $form_data['nPP'];
        $data['nPOP'] = $form_data['nPOP'];
        $data['nipKP'] = $form_data['nipKP'];
        $data['nipPP'] = $form_data['nipPP'];
        $data['nipPOP'] = $form_data['nipPOP'];
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
		
		$this->load->view('LPLPOGFK', $data);
    }
	
	function drugAchievedUnitdf()
    {
		if($this->session->userdata['telah_masuk']['idha'] == 14)
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
		if($this->session->userdata['telah_masuk']['idha'] == 14)
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
	
	public function AllunitInPuskesmas () {
		$id = $this->input->post('id');
		$data['units'] = $this->unit_model->getUnitByInputHC($id);
		echo json_encode($data);
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
	
	function opnameStockPdf($idPuskesmas='', $idUnit = '')
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
		if($this->session->userdata['telah_masuk']['idha'] == 19 || $this->session->userdata['telah_masuk']['idha'] == 17)
			$data['allHC'] = $this->ppuskesmas->getAllEntry();
		else
			$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
        
			$data['allSource'] = $this->source_money->getAllEntry();
		$this->display('drugStockgfkView', $data);
    }
	
	function drugStockCard()
    {
		$form_data = $this->input->post(null, true);
		if($this->session->userdata['telah_masuk']['idha'] != 19 && $this->session->userdata['telah_masuk']['idha'] != 17)
		{
			$idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
			$idUnit = $this->unit_model->getGOPID($idPuskesmas);
			$idUnit = $idUnit[0]['ID_UNIT'];
		}
		else
		{
			$idPuskesmas = $form_data['inputHC'];
			$idUnit = $this->unit_model->getGOPID($idPuskesmas);
		//	var_dump($idUnit);
			$idUnit = $idUnit[0]['ID_UNIT'];
			
		}
		
		$from = $this->convert ($form_data['inputDari']);
		$till = $this->convert ($form_data['inputHingga']);
        $data['dari'] = $from;
        $data['hingga'] = $till;
		
		$unitDetail = $this->unit_model->getUnitById($idUnit);
		$data['idUnit'] = $idUnit;
		$data['namaUnit'] = $unitDetail[0]['NAMA_UNIT'];
		$data['lplpo'] = $this->lplpo_model->getAllLplpo($idPuskesmas,$idUnit, $from, $till);
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);
		
		$this->load->view('drugStockCardGFK', $data);
    }
	
	function drugStockCardBySource()
    {
		$form_data = $this->input->post(null, true);
		if($this->session->userdata['telah_masuk']['idha'] != 19 && $this->session->userdata['telah_masuk']['idha'] != 17)
		{
			$idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
			$idUnit = $this->unit_model->getGOPID($idPuskesmas);
			$idUnit = $idUnit[0]['ID_UNIT'];
		}
		else
		{
			$idPuskesmas = $form_data['inputHC'];
			$idUnit = $this->unit_model->getGOPID($idPuskesmas);
		//	var_dump($idUnit);
			$idUnit = $idUnit[0]['ID_UNIT'];
			
		}
		
		$from = $this->convert ($form_data['inputDari']);
		$till = $this->convert ($form_data['inputHingga']);
		$source = $form_data['inputSource'];
		
		$unitDetail = $this->unit_model->getUnitById($idUnit);
		$data['idUnit'] = $idUnit;
		$data['namaUnit'] = $unitDetail[0]['NAMA_UNIT'];
		$data['lplpo'] = $this->lplpo_model->getAllLplpobysource($idPuskesmas,$idUnit, $from, $till, $source);
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);
		
		$this->load->view('drugStockCardGFK', $data);
    }
	
	function drugStockCardName()
    {
		$form_data = $this->input->post(null, true);
		if($this->session->userdata['telah_masuk']['idha'] != 19 && $this->session->userdata['telah_masuk']['idha'] != 17)
		{
			$idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
			$idUnit = $this->unit_model->getGOPID($idPuskesmas);
			$idUnit = $idUnit[0]['ID_UNIT'];
		}
		else
		{
			$idPuskesmas = $form_data['inputHC'];
			$idUnit = $this->unit_model->getGOPID($idPuskesmas);
		//	var_dump($idUnit);
			$idUnit = $idUnit[0]['ID_UNIT'];
			
		}
		
		$from = $this->convert ($form_data['inputDari']);
		$till = $this->convert ($form_data['inputHingga']);
		$dname = $form_data['inputObatN'];
		
		$unitDetail = $this->unit_model->getUnitById($idUnit);
		$data['idUnit'] = $idUnit;
		$data['namaUnit'] = $unitDetail[0]['NAMA_UNIT'];
		$data['lplpo'] = $this->lplpo_model->getAllLplpobyName($idPuskesmas,$idUnit, $from, $till, $dname);
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);
		
		$this->load->view('drugStockCardGFK', $data);
    }
	
	function drugStockCardByEXP()
    {
		$form_data = $this->input->post(null, true);
		if($this->session->userdata['telah_masuk']['idha'] != 19 && $this->session->userdata['telah_masuk']['idha'] != 17)
		{
			$idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
			$idUnit = $this->unit_model->getGOPID($idPuskesmas);
			$idUnit = $idUnit[0]['ID_UNIT'];
		}
		else
		{
			$idPuskesmas = $form_data['inputHC'];
			$idUnit = $this->unit_model->getGOPID($idPuskesmas);
		//	var_dump($idUnit);
			$idUnit = $idUnit[0]['ID_UNIT'];
			
		}
		
		$from = $this->convert ($form_data['inputDari']);
		$till = $this->convert ($form_data['inputHingga']);
		$efrom = $this->convert ($form_data['inputDariK']);
		$etill = $this->convert ($form_data['inputHinggaK']);
		
		$unitDetail = $this->unit_model->getUnitById($idUnit);
		$data['idUnit'] = $idUnit;
		$data['namaUnit'] = $unitDetail[0]['NAMA_UNIT'];
		$data['lplpo'] = $this->lplpo_model->getAllLplpobyEXP($idPuskesmas,$idUnit, $from, $till, $efrom, $etill);
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);
		
		$this->load->view('drugStockCardGFK', $data);
    }
	
	function inventarisPdf()
    {
		if($this->session->userdata['telah_masuk']['idgedung'] == 19)
			$data['allHC'] = $this->ppuskesmas->getAllEntry();
		else
			$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
			
        $this->display('inventarisView', $data);
    }
	
	function inventaris()
    {
		$form_data = $this->input->post(null, true);
		if($this->session->userdata['telah_masuk']['idha'] != 19)
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
	
	function LPLPOHc()
    {
		$data['allUnit'] = $this->unit_model->getUnitByHC();
		$data['allHC'] = $this->ppuskesmas->getAllEntry();
        $this->display('LPLPOHcview', $data);
    }
	
	function LPLPOHcpdf()
    {
		$form_data = $this->input->post(null, true);
		$idPuskesmas = $form_data['inputHC'];
		$from = $this->convert ($form_data['inputDari']);
		$till = $this->convert ($form_data['inputHingga']);

        $data['nKP'] = $form_data['nKP'];
        $data['nPP'] = $form_data['nPP'];
        $data['nPOP'] = $form_data['nPOP'];
        $data['nipKP'] = $form_data['nipKP'];
        $data['nipPP'] = $form_data['nipPP'];
        $data['nipPOP'] = $form_data['nipPOP'];
		if($idPuskesmas == '')
		{
			$idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
		}
			$data['namaUnit'] = 'dummy';
		$data['lplpo'] = $this->lplpo_model->getAllLplpoPuskesmas($idPuskesmas, $from, $till);
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);
		
		$this->load->view('LPLPOHcGFK', $data);
    }
	
	public function convert($date) {
        $mydate = date_create_from_format('d-m-Y', $date);
        return date_format($mydate, 'Y-m-d');
    }
}