<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//dapat diganti extend dengan *contoh Admin_controller / Aplikan_controller di folder core. 
class kd extends kdController {

    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->load->model('ppuskesmas');
        $this->load->model('drugachieved_model');
        $this->load->model('drugused_model');
        $this->load->model('unit_model');
        $this->load->model('disease_model');
        $this->load->model('lplpo_model');
        $this->load->model('sdm_model');
        $this->load->model('service_model');
        $this->load->model('ri_model');
        $this->load->model('lab_model');
        $this->load->model ('mIcd');
        $this->load->model('inventaris_model');
        $this->load->library('Pdf');
    }

    //penjelasan fungsi index, diletakkan disini... 
    public function index() {
        
    }
	
	private function renameHeader ($headerName) {
		$headerName = str_replace("_", " ", strtoupper($headerName));
		switch ($headerName) {
			case "NOID REKAMMEDIK" :
				$headerName = "NOMOR REKAM MEDIK";
				break;
				
			case "STOK OBAT SEKARANG":
				$headerName = "STOK SAAT INI";
			break;			
			
			case "EXPIRED DATE":
				$headerName = "TANGGAL KADALUARSA";
			break;
			
			case "NAMA SUMBER ANGGARAN OBAT":
				$headerName = "SUMBER ANGGARAN";
				break;
			
			default:
				break;			
        }
		return $headerName;
	}
	
    public function AllunitInPuskesmas() {
        $id = $this->input->post('id');
        $data['units'] = $this->unit_model->getUnitByInputHC($id);
        echo json_encode($data);
    }

    function opname() {
        $data['allUnit'] = $this->unit_model->getUnitByHC();
        if ($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 19)
            $data['allHC'] = $this->ppuskesmas->getAllEntry();
        else
            $data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
        $this->display('opnameview', $data);
    }

    function opnamepdf() {
        $form_data = $this->input->post(null, true);
        $idPuskesmas = $form_data['inputHC'];
        $idUnit = $form_data['inputUnit'];
        $from = $this->convert ($form_data['inputDari']);
        $till = $this->convert ($form_data['inputHingga']);
        if ($idPuskesmas == '') {
            $idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
            $data['idUnit'] = $this->session->userdata['telah_masuk']['idunit'];
            $data['namaUnit'] = $this->session->userdata['telah_masuk']['namaunit'];
        } else {
            echo $idPuskesmas;
            $unitDetail = $this->unit_model->getUnitById($idUnit);
            $data['idUnit'] = $idUnit;
            $data['namaUnit'] = $unitDetail[0]['NAMA_UNIT'];
        }
        $data['lplpo'] = $this->lplpo_model->getAllLplpo($idPuskesmas, $idUnit, $from, $till);
        $data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);

        $this->load->view('opname', $data);
    }

    function LPLPO() {
        $data['allUnit'] = $this->unit_model->getUnitByHC();
        if ($this->session->userdata['telah_masuk']['idha'] == 14)
            $data['allHC'] = $this->ppuskesmas->getAllEntry();
        else
            $data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
        $this->display('LPLPOview', $data);
    }

    function LPLPOpdf() {
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
        if ($idPuskesmas == '') {
            $idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
            $data['idUnit'] = $this->session->userdata['telah_masuk']['idunit'];
            $data['namaUnit'] = $this->session->userdata['telah_masuk']['namaunit'];
        } else {
            echo $idPuskesmas;
            $unitDetail = $this->unit_model->getUnitById($idUnit);
            $data['idUnit'] = $idUnit;
            $data['namaUnit'] = $unitDetail[0]['NAMA_UNIT'];
        }
        $data['lplpo'] = $this->lplpo_model->getAllLplpo($idPuskesmas, $idUnit, $from, $till);
        $data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);

        $this->load->view('LPLPO', $data);
    }

    function LPLPOHc() {
        $data['allUnit'] = $this->unit_model->getUnitByHC();
        if ($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 19)
            $data['allHC'] = $this->ppuskesmas->getAllEntry();
        else
            $data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
        $this->display('LPLPOHcview', $data);
    }

    function LPLPOHcpdf() {
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
        if ($idPuskesmas == '') {
            $idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
        }
        $data['namaUnit'] = 'dummy';
        $data['lplpo'] = $this->lplpo_model->getAllLplpoPuskesmas($idPuskesmas, $from, $till);
        $data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);

        $this->load->view('LPLPOHc', $data);
    }

    function drugAchievedUnitdf() {
        if ($this->session->userdata['telah_masuk']['idha'] == 14)
            $data['allHC'] = $this->ppuskesmas->getAllEntry();
        else { //if kepala puskesmas
            $data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
            $data['allUnit'] = $this->unit_model->getUnitByHC();
        }
        $this->display('drugAchievedView', $data);
    }

    function drugAchieved() {
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
        $data['allDrugAchieved'] = $this->drugachieved_model->getAllAchievedDrugDetail($puskesmas, $unit, $from, $till);
        $this->load->view('drugAchieved', $data);
    }

    function drugUsedUnitdf() {
        if ($this->session->userdata['telah_masuk']['idha'] == 14)
            $data['allHC'] = $this->ppuskesmas->getAllEntry();
        else { //if kepala puskesmas
            $data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
            $data['allUnit'] = $this->unit_model->getUnitByHC();
        }
        $this->display('drugUsedView', $data);
    }

    function drugUsed($idPuskesmas = '', $idUnit = '') {
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
        $data['allDrugUsed'] = $this->drugused_model->getAllUsedDrugDetail($puskesmas, $unit, $from, $till);
        //echo $data['allDrugUsed'];
        $data['detailPuskesmas'] = $this->ppuskesmas->selectById($puskesmas);
        $this->load->view('drugUsed', $data);
    }

    function pRIPdf() {
        $this->load->view('pelayananRawatInap');
    }

    function pKesPdf() {
        $this->load->view('pelayananKesehatan');
    }

    function pPustuPdf() {
        $this->load->view('pelayananPustu');
    }

    function pPonkesdesPdf() {
        $this->load->view('pelayananPonkesdes');
    }

    function pPolindesPdf() {
        $this->load->view('pelayananPolindes');
    }

    function opnameStockPdf($idPuskesmas = 1, $idUnit = 13) {
        if ($idPuskemas == '') {
            $idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
            $data['idUnit'] = $this->session->userdata['telah_masuk']['idunit'];
            $data['namaUnit'] = $this->session->userdata['telah_masuk']['namaunit'];
        } else {
            $unitDetail = $this->unit_model->getUnitById($idUnit);
            $data['idUnit'] = $idUnit;
            $data['namaUnit'] = $unitDetail[0]['NAMA_UNIT'];
        }

        $data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);
        $this->load->view('opnameStock', $data);
    }

    function cardStockParentPdf() {
        $this->load->view('cardStockParent');
    }

    function cardStockHCarePdf() {
        $this->load->view('cardStockHCare');
    }

    function drugStockCardPdf() {
        if ($this->session->userdata['telah_masuk']['idha'] == 14)
            $data['allHC'] = $this->ppuskesmas->getAllEntry();
        else
            $data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);

        $this->display('drugStockView', $data);
    }

    function drugStockCard() {
        $form_data = $this->input->post(null, true);
        if ($this->session->userdata['telah_masuk']['idha'] != 14) {
            $idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
        } else {
            $idPuskesmas = $form_data['inputHC'];
        }

        $idUnit = $this->unit_model->getGOPID($idPuskesmas);
        $idUnit = $idUnit[0]['ID_UNIT'];
        $from = $form_data['inputDari'];
        $till = $form_data['inputHingga'];
        $data['dari'] = $from;
        $data['hingga'] = $till;

        $unitDetail = $this->unit_model->getUnitById($idUnit);
        $data['idUnit'] = $idUnit;
        $data['namaUnit'] = $unitDetail[0]['NAMA_UNIT'];
        $data['lplpo'] = $this->lplpo_model->getAllLplpo($idPuskesmas, $idUnit, $from, $till);
        $data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);

        $this->load->view('drugStockCard', $data);
    }

    function inventarisPdf() {
        if ($this->session->userdata['telah_masuk']['idha'] == 14)
            $data['allHC'] = $this->ppuskesmas->getAllEntry();
        else
            $data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);

        $this->display('inventarisView', $data);
    }

    function inventaris() {
        $form_data = $this->input->post(null, true);
        if ($this->session->userdata['telah_masuk']['idha'] != 14) {
            $idPuskesmas = $this->session->userdata['telah_masuk']['idgedung'];
        } else {
            $idPuskesmas = $form_data['inputHC'];
        }

        $from = $form_data['inputDari'];
        $till = $form_data['inputHingga'];

        $data['inventaris'] = $this->inventaris_model->getAllEntry($idPuskesmas, $from, $till);
        $data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);

        $this->load->view('inventaris', $data);
    }

    function drugAchievedPdf() {
        $this->load->view('drugAchieved');
    }

    function drugUsedPdf() {
        $this->load->view('drugUsed');
    }

    function hServicePdf() {
        $this->load->view('hCare');
    }

    function sdmHc() {
        if ($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 19)
            $data['allHC'] = $this->ppuskesmas->getAllEntry();
        else { //if kepala puskesmas
            $data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
        }
        $this->display('sdmView', $data);
    }

    function sdmHcPdf() {
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

    function hCare() {
        if ($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 19)
		{
            $hc = $this->ppuskesmas->getAllEntry();
			foreach($hc as $val)
			{
				if(strpos(strtoupper($val['NAMA_GEDUNG']),"GUDANG FARMASI") === false)
					$data['allHC'][]=$val;
				//var_dump($val);
			}
		}
        else { //if kepala puskesmas
            $data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
        }
        $this->display('hCareView', $data);
    }

    function hCarePdf() {
        $form_data = $this->input->post(null, true);
        $puskesmas = $form_data['inputHC'];
        $bulan = $form_data['bulan'];
        $tahun = $form_data['tahun'];
        $puskesmasDetail = $this->ppuskesmas->selectById($puskesmas);
        $data['namaPuskesmas'] = $puskesmasDetail[0]['NAMA_GEDUNG'];
        $data['kec'] = $puskesmasDetail[0]['KECAMATAN_GEDUNG'];
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['nKP'] = $form_data['nKP'];
        $data['nSP2TP'] = $form_data['nSP2TP'];
        $data['nipKP'] = $form_data['nipKP'];
        $data['nipSP2TP'] = $form_data['nipSP2TP'];
		
        $data['hcarekk'] = $this->service_model->getkk($puskesmas, $bulan, $tahun);
        $data['hcarepvisit'] = $this->service_model->getpvisit($puskesmas, $bulan, $tahun);
        $data['hcaregigiumum'] = $this->service_model->getgigiumum($puskesmas, $bulan, $tahun);
        $data['hcaresourcevisit'] = $this->service_model->getsourcekunjungan($puskesmas, $bulan, $tahun);
        $data['hcarekasus'] = $this->service_model->getkasus($puskesmas, $bulan, $tahun);
        $data['hcareservice'] = $this->service_model->getservice($puskesmas, $bulan, $tahun);
        $data['hcarerjalan'] = $this->service_model->getrjalan($puskesmas, $bulan, $tahun);
        $data['hcaresourceservice'] = $this->service_model->getsourceservice($puskesmas, $bulan, $tahun);
        $data['hcaresourcepayment'] = $this->service_model->getSP($puskesmas, $bulan, $tahun);
        $data['hcareugd'] = $this->service_model->getugd($puskesmas, $bulan, $tahun);

        $this->load->view('hCare', $data);
    }
    
    function hCareGrafik(){
//        $this->script_header = 'lay-scripts/header_grafik';
//        $this->script_footer = 'lay-scripts/footer_grafik';
        $form_data = $this->input->post(null, true);
        $puskesmas = $form_data['inputHC'];
        $bulan = $form_data['bulan'];
        $tahun = $form_data['tahun'];
        $puskesmasDetail = $this->ppuskesmas->selectById($puskesmas);
        $data['namaPuskesmas'] = $puskesmasDetail[0]['NAMA_GEDUNG'];
        $data['kec'] = $puskesmasDetail[0]['KECAMATAN_GEDUNG'];
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['hcarekk'] = $this->service_model->getkk($puskesmas, $bulan, $tahun);
        $data['hcarepvisit'] = $this->service_model->getpvisit($puskesmas, $bulan, $tahun);
        $data['hcaregigiumum'] = $this->service_model->getgigiumum($puskesmas, $bulan, $tahun);
        $data['hcaresourcevisit'] = $this->service_model->getsourcekunjungan($puskesmas, $bulan, $tahun);
        $data['hcarekasus'] = $this->service_model->getkasus($puskesmas, $bulan, $tahun);
        $data['hcareservice'] = $this->service_model->getservice($puskesmas, $bulan, $tahun);
        $data['hcarerjalan'] = $this->service_model->getrjalan($puskesmas, $bulan, $tahun);
        $data['hcaresourceservice'] = $this->service_model->getsourceservice($puskesmas, $bulan, $tahun);
        $data['hcaresourcepayment'] = $this->service_model->getSP($puskesmas, $bulan, $tahun);
        $data['hcareugd'] = $this->service_model->getugd($puskesmas, $bulan, $tahun);

        $this->load->view('hCareGrafik', $data);
    }

	function diseaseByAgePdf()
    {
		if($this->session->userdata['telah_masuk']['idgedung'] == 19 || $this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 15)
			{
            $hc = $this->ppuskesmas->getAllEntry();
			foreach($hc as $val)
			{
				if(strpos(strtoupper($val['NAMA_GEDUNG']),"GUDANG FARMASI") === false)
					$data['allHC'][]=$val;
				//var_dump($val);
			}
		}
		else
			$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
			
        $this->display('diseaseByAgeView', $data);
    }
	
	function diseaseByAge()
    {
		$form_data = $this->input->post(null, true);
		if($this->session->userdata['telah_masuk']['idha'] != 19 && $this->session->userdata['telah_masuk']['idha'] != 14 && $this->session->userdata['telah_masuk']['idha'] != 15)
		{
			$idPuskesmas = $form_data['inputHC'];
		}
		else
		{
			$idPuskesmas = $form_data['inputHC'];
		}
		
		$from = $form_data['inputDari'];
		$till = $form_data['inputHingga'];
		$data['from'] = $form_data['inputDari'];
		$data['till'] = $form_data['inputHingga'];
		$data['disease'] = $this->disease_model->getDiseaseByAge($idPuskesmas, $from, $till);
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);
		
        $this->load->view('diseaseByAge', $data);
    }
	
	function diseaseByAgeHCarePdf()
    {
		if($this->session->userdata['telah_masuk']['idgedung'] == 19 || $this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 15)
			{
            $hc = $this->ppuskesmas->getAllEntry();
			foreach($hc as $val)
			{
				if(strpos(strtoupper($val['NAMA_GEDUNG']),"GUDANG FARMASI") === false)
					$data['allHC'][]=$val;
				//var_dump($val);
			}
		}
		else
			$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
			
        $this->display('diseaseByAgeHCareView', $data);
    }
	
	function diseaseByAgeHCare()
    {
		$form_data = $this->input->post(null, true);
		if($this->session->userdata['telah_masuk']['idha'] != 19 && $this->session->userdata['telah_masuk']['idha'] != 14 && $this->session->userdata['telah_masuk']['idha'] != 15)
		{
			$icd = $form_data['inputIcd'];
		}
		else
		{
			$icd = $form_data['inputIcd'];
		}
		
		$from = $form_data['inputDari'];
		$till = $form_data['inputHingga'];
		$data['from'] = $form_data['inputDari'];
		$data['till'] = $form_data['inputHingga'];
		$data['kode'] = $form_data['kodeIcd'];
		$data['nama'] = $form_data['namapenyakit'];
		$data['disease'] = $this->disease_model->getDiseaseByAgeHCare($icd, $from, $till);
        $this->load->view('diseaseByAgeHCare', $data);
    }
	
	function getSearch() {
        // header('Cache-Control: no-cache, must-revalidate');
        // header('Access-Control-Allow-Origin: *');
        // header('Content-type: application/json');
        
		$data = $this->input->post('teksnya');

        $teks = $data['tanda'];
        $temp1 = $this->mIcd->getAllEntry($teks);

		if ($temp1)
        $data = $this->getPivot($temp1);        
		else $data = "[[\"ID ICD\",\"KODE ICD X\", \"ENGLISH NAME\", \"INDONESIAN NAME\", \"KELOLA\"], [\"Tidak ditemukan\", \"Tidak ditemukan\", \"Tidak ditemukan\", \"Tidak ditemukan\", \"-\"]]";;
		echo $data;
    }

    function clean($string) {
        //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        //return str_replace(array('\'', '\\', '/', '*'), ' ', $string);
        return preg_replace('/[^A-Za-z0-9\-@ .,]/', '-', $string); // Removes special chars.
    }
	
	private function getPivot($data) {
        $header = "[[";

        // get key nama kolom
        // hapus underscore _ dan JADI GEDE
        foreach ($data as $value) {
            $flag = true;
            foreach ($value as $key => $sembarang) {
                if ($flag) {
                    $header .= '"';
                    $flag = false;
                } else {
                    $header .= ',"';
                }
                $header .= $this->renameHeader($key) . '"';
            }
            $header .= ",\"KELOLA\"";
            $header .= "]";
            break;
        }

        // get value
        foreach ($data as $value) {
            $header .= ",[";
            $flagdata = true;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                if ($flagdata) {
                    $header .= '"';
                    $flagdata = false;
                } else
                    $header .= ',"';
                $header .= $data . '"';
            }
            $header .= ',"<a id=\"'.$value['ID_ICD'].'_'.$value['KODE_ICD_X'].'_'.$value['INDONESIAN_NAME'].'\" style=\'color: white;\' class=\'btn btn-success\' type=\'button\' onclick=fillICD(this.id) ><i class=\'fa fa-check\'></i></a>"';
            $header .= "]";
        }
        $header .= "]";
        return $header;
    }
	
	function diseasePdf()
    {
		if($this->session->userdata['telah_masuk']['idgedung'] == 19 || $this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 15)
			{
            $hc = $this->ppuskesmas->getAllEntry();
			foreach($hc as $val)
			{
				if(strpos(strtoupper($val['NAMA_GEDUNG']),"GUDANG FARMASI") === false)
					$data['allHC'][]=$val;
				//var_dump($val);
			}
		}
		else
			$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
			
        $this->display('diseaseView', $data);
    }
	
	function disease()
    {
		$form_data = $this->input->post(null, true);
		if($this->session->userdata['telah_masuk']['idha'] != 19 && $this->session->userdata['telah_masuk']['idha'] != 14 && $this->session->userdata['telah_masuk']['idha'] != 15)
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
	
	function diseaseHighestPdf()
    {
		if($this->session->userdata['telah_masuk']['idgedung'] == 19 || $this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 15)
		{
            $hc = $this->ppuskesmas->getAllEntry();
			foreach($hc as $val)
			{
				if(strpos(strtoupper($val['NAMA_GEDUNG']),"GUDANG FARMASI") === false)
					$data['allHC'][]=$val;
				//var_dump($val);
			}
		}
		else
			$data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
			
        $this->display('diseaseHighestView', $data);
    }
	
	function diseaseHighest()
    {
		$form_data = $this->input->post(null, true);
		if($this->session->userdata['telah_masuk']['idha'] != 19 && $this->session->userdata['telah_masuk']['idha'] != 14 && $this->session->userdata['telah_masuk']['idha'] != 15)
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
		$data['disease'] = $this->disease_model->getDiseaseHighest($idPuskesmas, $from, $till);
		$data['detailPuskesmas'] = $this->ppuskesmas->selectById($idPuskesmas);
		
        $this->load->view('diseaseHighest', $data);
    }

    function rInap() {
        if ($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 19 || $this->session->userdata['telah_masuk']['idha'] == 15)
		{
            $hc = $this->ppuskesmas->getAllEntry();
			foreach($hc as $val)
			{
				if(strpos(strtoupper($val['NAMA_GEDUNG']),"GUDANG FARMASI") === false)
					$data['allHC'][]=$val;
				//var_dump($val);
			}
		}
        else { //if kepala puskesmas
            $data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
        }
        $this->display('rInapView', $data);
    }

    function rInapPdf() {
        $form_data = $this->input->post(null, true);
        $puskesmas = $form_data['inputHC'];
        $bulan = $form_data['bulan'];
        $tahun = $form_data['tahun'];
        $puskesmasDetail = $this->ppuskesmas->selectById($puskesmas);
        $data['namaPuskesmas'] = $puskesmasDetail[0]['NAMA_GEDUNG'];
        $data['kec'] = $puskesmasDetail[0]['KECAMATAN_GEDUNG'];
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['nKP'] = $form_data['nKP'];
        $data['nKRI'] = $form_data['nKRI'];
        $data['nipKP'] = $form_data['nipKP'];
        $data['nipKRI'] = $form_data['nipKRI'];
        $data['riBedDetail'] = $this->ri_model->getRiBed($puskesmas);
        $data['riVSDetail'] = $this->ri_model->getRiVisitTime($puskesmas, $bulan, $tahun);
        $data['riC'] = $this->ri_model->getC($puskesmas, $bulan, $tahun);
        $data['riVC'] = $this->ri_model->getRiVisitCategory($puskesmas, $bulan, $tahun);
        $data['riDBA'] = $this->ri_model->getDBA($puskesmas, $bulan, $tahun);
        $data['riRIH'] = $this->ri_model->getRIH($puskesmas, $bulan, $tahun);
        $data['riDT'] = $this->ri_model->getDT($puskesmas, $bulan, $tahun);
        $data['riBP'] = $this->ri_model->getBP($puskesmas, $bulan, $tahun);
        $data['riPoned'] = $this->ri_model->getPONED($puskesmas, $bulan, $tahun);
        $data['rivkkia'] = $this->ri_model->getVKKIA($puskesmas, $bulan, $tahun);
        $data['rivll'] = $this->ri_model->getLL($puskesmas, $bulan, $tahun);
        $data['rikeluar'] = $this->ri_model->getkeluar($puskesmas, $bulan, $tahun);

        $this->load->view('rInap', $data);
    }
    
    function rInapGrafik(){
//        $this->script_header = 'lay-scripts/header_grafik';
//        $this->script_footer = 'lay-scripts/footer_grafik';
        $form_data = $this->input->post(null, true);
        $puskesmas = $form_data['inputHC'];
        $bulan = $form_data['bulan'];
        $tahun = $form_data['tahun'];
        $puskesmasDetail = $this->ppuskesmas->selectById($puskesmas);
        $data['namaPuskesmas'] = $puskesmasDetail[0]['NAMA_GEDUNG'];
        $data['kec'] = $puskesmasDetail[0]['KECAMATAN_GEDUNG'];
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['riBedDetail'] = $this->ri_model->getRiBed($puskesmas);
        $data['riVSDetail'] = $this->ri_model->getRiVisitTime($puskesmas, $bulan, $tahun);
        $data['riC'] = $this->ri_model->getC($puskesmas, $bulan, $tahun);
        $data['riVC'] = $this->ri_model->getRiVisitCategory($puskesmas, $bulan, $tahun);
        $data['riDBA'] = $this->ri_model->getDBA($puskesmas, $bulan, $tahun);
        $data['riRIH'] = $this->ri_model->getRIH($puskesmas, $bulan, $tahun);
        $data['riDT'] = $this->ri_model->getDT($puskesmas, $bulan, $tahun);
        $data['riBP'] = $this->ri_model->getBP($puskesmas, $bulan, $tahun);
        $data['riPoned'] = $this->ri_model->getPONED($puskesmas, $bulan, $tahun);
        $data['rivkkia'] = $this->ri_model->getVKKIA($puskesmas, $bulan, $tahun);
        $data['rivll'] = $this->ri_model->getLL($puskesmas, $bulan, $tahun);
        $data['rikeluar'] = $this->ri_model->getkeluar($puskesmas, $bulan, $tahun);

        $this->load->view('rInapGrafik', $data);
    }

    function labPdf() {
        if ($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 19 || $this->session->userdata['telah_masuk']['idha'] == 15)
		{
            $hc = $this->ppuskesmas->getAllEntry();
			foreach($hc as $val)
			{
				if(strpos(strtoupper($val['NAMA_GEDUNG']),"GUDANG FARMASI") === false)
					$data['allHC'][]=$val;
				//var_dump($val);
			}
		}
        else { //if kepala puskesmas
            $data['allHC'] = $this->ppuskesmas->selectById($this->session->userdata['telah_masuk']['idgedung']);
        }

        $this->display('labView', $data);
    }

    function lab() {
        $form_data = $this->input->post(null, true);
        if ($this->session->userdata['telah_masuk']['idha'] != 19 && $this->session->userdata['telah_masuk']['idha'] != 15 && $this->session->userdata['telah_masuk']['idha'] != 14) {
            $puskesmas = $this->session->userdata['telah_masuk']['idgedung'];
        } else {
            $puskesmas = $form_data['inputHC'];
        }

        $bulan = $form_data['inputBulan'];
        $tahun = $form_data['inputTahun'];

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $data['nKP'] = $form_data['nKP'];
        $data['nPL'] = $form_data['nPL'];
        $data['nipKP'] = $form_data['nipKP'];
        $data['nipPL'] = $form_data['nipPL'];
        $data['head'] = $this->lab_model->gethead($puskesmas, $bulan, $tahun);
        $data['hematologi'] = $this->lab_model->gethematologi($puskesmas, $bulan, $tahun);
        $data['urine'] = $this->lab_model->geturine($puskesmas, $bulan, $tahun);
        $data['kehamilan'] = $this->lab_model->gethamil($puskesmas, $bulan, $tahun);
        $data['feces'] = $this->lab_model->getfeces($puskesmas, $bulan, $tahun);
        $data['gula'] = $this->lab_model->getgula($puskesmas, $bulan, $tahun);
        $data['serologi'] = $this->lab_model->getserologi($puskesmas, $bulan, $tahun);
        $data['hati'] = $this->lab_model->gethati($puskesmas, $bulan, $tahun);
        $data['lemak'] = $this->lab_model->getlemak($puskesmas, $bulan, $tahun);
        $data['ginjal'] = $this->lab_model->getginjal($puskesmas, $bulan, $tahun);
        $data['direct'] = $this->lab_model->getdirect($puskesmas, $bulan, $tahun);

        $data['detailPuskesmas'] = $this->ppuskesmas->selectById($puskesmas);

        $this->load->view('labpdf', $data);
    }

	public function convert($date) {
        $mydate = date_create_from_format('d-m-Y', $date);
        return date_format($mydate, 'Y-m-d');
    }
}
