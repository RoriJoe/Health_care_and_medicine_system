
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lab extends labController {

    private $home;

    public function __construct() {
        parent::__construct();
        $this->load->model('mLab');
        $this->load->model('mLabCheck');
        $this->load->model('mQueue');
        $this->load->model('mMRHistory');
        $this->load->model('unit_model');
        $this->load->model('mdrughc');
        $this->load->model('mDiagnosis');
        $this->load->model('mHServices');
        $this->load->model('unit_model');
    }

    private function _getFormFill() {
        $data = array(
            "error_msg" => $this->session->flashdata('error'),
            "queues" => $this->mQueue->getAllByUnit($this->session->userdata['telah_masuk']['idunit'])
        );
        return $data;
    }

    public function index() {
        $data = $this->_getFormFill();
        $this->display('home', $data);
    }
    
    public function updateTest()
    {
        echo $this->input->post('satuan');
        $iduji = $this->input->post('idpengujian');
        $data = array(
            "NAMA_PEM_LABORAT" => $this->input->post('namaUji'),
            "ID_KAT_SPES" => $this->input->post('spesimen'),
            "ID_KP_LABORAT" => $this->input->post('katUji'),
            "NILAI_NORMAL_UJI" => $this->input->post('nilaiNormal'),
            "SATUAN_HASIL_UJI" => $this->input->post('satuan')
        );
        $this->mLab->updateTest($iduji,$data);
        redirect('laboratorium/lab/masterTestList');
    }
    
    public function insertTest()
    {
//        echo $this->input->post('satuan');
        //$iduji = $this->input->post('idpengujian');
        echo $this->session->userdata['telah_masuk']['idunit'];
        $data = array(
            "NAMA_PEM_LABORAT" => $this->input->post('namaUji2'),
            "ID_KAT_SPES" => $this->input->post('spesimen2'),
            "ID_KP_LABORAT" => $this->input->post('katUji2'),
            "ID_UNIT" => $this->session->userdata['telah_masuk']['idunit'],
            "NILAI_NORMAL_UJI" => $this->input->post('nilaiNormal2'),
            "SATUAN_HASIL_UJI" => $this->input->post('satuan2')
        );
//        print_r($data);
        $this->mLab->insertTest($data);
        redirect('laboratorium/lab/masterTestList');
    }
    
    public function masterTestList() {
        $temp = $this->mLabCheck->getIdLab_byGedung($this->session->userdata['telah_masuk']['idgedung']);
        $idlab = $temp[0]->ID_UNIT;
        $ceklist = $this->mLab->getCheckList($idlab);
        $data['katPem'] = $this->mLabCheck->getKatPemeriksaan();
        $data['spesimen'] = $this->mLabCheck->getSpesimen();
        $data['mastertestlist'] = $ceklist;
        $this->display('testList',$data);
    }

    public function fillResult() {
        $idrrm = $this->input->post('idrrm');
        $idantrian = $this->input->post('idantrian');
        $data = array(
            "testlist" => $this->mLab->getTestList($idrrm),
            "idrrm" => $idrrm,
            "idantrian" => $idantrian
        );
        $data['listUnit']= $this->unit_model->getUnitByHC();
        $this->display('labFillResult', $data);
    }
    
    public function printResult(){
        
    }

    function getSearch() {
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');
        $idunit = $data['idunit'];
        $idrrm = $data['idrrm'];
        $temp1 = $this->mLab->checkListNotChecked($idunit,$idrrm);

        $data["submit"] = $this->getPivot($temp1);
        return $data["submit"];
    }

    function clean($string) {
        //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        //return str_replace(array('\'', '\\', '/', '*'), ' ', $string);
        return preg_replace('/[^A-Za-z0-9\-@ .,]/', '-', $string); // Removes special chars.
    }
    
    function updateTestValue()
    {
        $form_data = $this->input->post(null, true);
        
        $idrrm =  $this->input->post('idrrm');
        $idantrian = $this->input->post('idantrian');
        $temp = $this->mLab->getTestList($idrrm);
        $jml = count($temp);
        
        $jmlbaru = $this->input->post('jmlbaru');
        
        for($y=0;$y<$jml;$y++)
        {
            $tglCekLab= $this->input->post('tglresult_'.$temp[$y]['ID_CEK_LABORAT']);
            $this->mLab->updateValueTest($temp[$y]['ID_CEK_LABORAT'], $this->convert($tglCekLab), $this->input->post('result_'.$temp[$y]['ID_CEK_LABORAT']), $this->session->userdata['telah_masuk']['idakun']);
        }
        
        if($jmlbaru>0)
        {
            for($o=0;$o<$jmlbaru;$o++)
            {
                $counter= $o+1;
                $tglCekLab= $this->input->post('tanggalbaru'.$counter);
                $this->mLab->insertNewValueTest($idrrm,$this->input->post('idpemlaborat'.($o+1)), $this->convert($tglCekLab), $this->input->post('valuebaru'.($o+1)), $this->session->userdata['telah_masuk']['idakun']);
            }
            
        }
        $this->mQueue->updateQueue($idantrian);
        
        $idunit= $this->input->post('save_unit');
        $dataUnit= explode("_",$idunit);
        if(isset($dataUnit[1])){
            $data_queue = array(
                'id_unit' => $dataUnit[0],
                'id_riwayat_rm' => $idrrm,
                'FLAG_INTERN' => 1,
                'waktu_antrian_unit' => date('Y-m-d H:i:s'),
                'sub_kia' => $dataUnit[1]
            );
        }
        else {
            $data_queue = array(
                'id_unit' => $dataUnit[0],
                'id_riwayat_rm' => $idrrm,
                'FLAG_INTERN' => 1,
                'waktu_antrian_unit' => date('Y-m-d H:i:s')
            );
        }
        $this->mdrughc->insert('antrian_unit', $data_queue);
        redirect('laboratorium/lab/profileMRH/'.$idrrm);
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
        $vartemp = "";
        foreach ($data as $value) {
            $header .= ",[";

            foreach ($value as $key => $data) {
                $data = $this->clean($data);
//                if ($key == "ID_ICD") {
//                    $header .= '"<a href=\'' . base_url() . 'index.php/linknya/disini/lho/' . $value->ID_ICD . '/' . $value->CATEGORY . '/' . $value->SUBCATEGORY . '/' . $value->ENGLISH_NAME . '/' . $value->INDONESIAN_NAME . '\'>' . $data . '</a>"';
//                } else {
                    $header .= '"' . $data . '"';
//                }
                break;
            }
            $count = 1;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                if ($count > 1) {
//                    if ($key == "ID_ICD") {
//                        $header .= '"<a href=\'' . base_url() . 'index.php/linknya/disini/lho/' . $value->ID_ICD . '/' . $value->CATEGORY . '/' . $value->SUBCATEGORY . '/' . $value->ENGLISH_NAME . '/' . $value->INDONESIAN_NAME . '\'>' . $data . '</a>"';
//                    } else {
                    $header .= ',"' . $data . '"';
//                    }
                }
                $count ++;
            }
            $header .= ',"<button onclick=\"fungsi_alert(\'' . $value->ID_PEM_LABORAT . '\',\'' . $value->NAMA_PENGUJIAN. '\',\'' . $value->NAMA_KP_LABORAT. '\',\'' . $value->NAMA_SPESIMEN . '\')\" class=\"btn btn-primary\">Pilih</button>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }
    
    public function convert($date) {
        $mydate = date_create_from_format('d-m-Y', $date);
        return date_format($mydate, 'Y-m-d');
    }
    
    public function profileMRH() {
        $id = $this->uri->segment(4, 0);
        $data['idrrm'] = $id;
        $data['profil'] = $this->mMRHistory->getProfilMRH($id);
        $data['laborat'] = $this->mLabCheck->getEntryById($id);
//        $data['riwayat_rm'] = $this->mMRHistory->getMRHById($id);
//        $data['tindakan'] = $this->mHServices->getEntryById($id);
//        $data['icd'] = $this->mDiagnosis->getEntryById($id);
        $this->display('mrhProfile', $data);
    }
    
    public function profileMRHpdf(){
        $id = $this->uri->segment(4, 0);
        $data['idrrm'] = $id;
        $data['profil'] = $this->mMRHistory->getProfilMRH($id);
        $data['laborat'] = $this->mLabCheck->getEntryById($id);
        $data['gedung'] = $this->unit_model->getGedung();
        $this->load->view('cetakLabNew', $data);
    }
    
    function getSearch2() {
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');

        // Perubahan idrrm to id_rm
        $id_rm = $data['id_rm'];
        $rangedata = $data['range'];
        $temp1 = $this->mMRHistory->getMRHByIdMR($id_rm, $rangedata);
        $data["submit"] = $this->getPivot2($temp1);
        if ($data) {
            return $data["submit"];
        } else
            return "Kosong";
    }

    private function getPivot2($data) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        $header = "[[";
        foreach ($data as $value) {
            $header .= '"NOMOR"';
            foreach ($value as $key => $sembarang) {
                    $header .= ',"' . str_replace("_", " ", strtoupper($key)) . '"';
            }
            $header .= ",\"DETIL\"]";
            break;
        }
        
        $counter= 1;
        foreach ($data as $value) {
            $header .= ",[";
            $header .= '"'.$counter.'"';
            $counter++;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                    $header .= ',"' . $data . '"';
            }
            $header .= ',"<a type=\"button\" style=\"color: white\" href=\"' . base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/profileMRH/' . $value->ID_RIWAYAT_RM . '\" class=\"btn btn-primary\">Pilih</a>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }
    
    public function patient() {
        $this->display('patient');
    }
    
    function showPatient() {
        $id_unit = $this->session->userdata['telah_masuk']['idunit'];
        // Perubahan!!!
        // $data = $this->mMRHistory->getHistoryRRM($id_unit);
        $data = $this->mMRHistory->getMedRecord($id_unit);
        echo $this->getPivotPatient($data);
    }

    private function renameHeader($headerName) {
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

    private function getPivotPatient($data) {
        $header = "[[";

        // get key nama kolom
        // hapus underscore _ dan JADI GEDE
        foreach ($data as $value) {
            $header .= '"NOMOR"';
            $flag = false;
            foreach ($value as $key => $sembarang) {
                if ($flag) {
                    $header .= '"';
                    $flag = false;
                } else {
                    $header .= ',"';
                }
                $header .= $this->renameHeader($key) . '"';
            }
            $header .= ",\"DETAIL\"";
            $header .= "]";
            break;
        }

        $counter= 1;
        foreach ($data as $value) {
            $header .= ",[";
            $flagdata = false;
            $header .= '"'.$counter.'"';
            $counter++;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                if ($flagdata) {
                    $header .= '"';
                    $flagdata = false;
                } else
                    $header .= ',"';
                $header .= $data . '"';
            }

            // Perubahan !!!
            // tidak pakai id rrm tapi id rm
            $header .= ',"<a type=\"button\" style=\"color: white\" href=\"' . base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/patientMRH/' . $value['id_rekammedik'] . '\" class=\"btn btn-primary\">Detail</a>"';
            $header .= "]";
        }
        $header .= "]";
        return $header;
    }
    
    public function patientMRH() {
        $id = $this->uri->segment(4, 0);
        // Perubahan !!!
        // idrrm to id_rm
        $data['id_rm'] = $id;
        $data['data_rrm'] = $this->mMRHistory->getMRHByIdMR($id, 100);
        $this->display('allMedRecord', $data);
    }
    
    //start logistics management
    
    //function monitoring stok obat
    public function monitoringObat() {
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];

        $array['notifStok']= $this->mdrughc->notificationStok();
        $array['notifMinStok']= $this->mdrughc->notificationMinStokUNIT();
        $array['idUnit'] = $idUnit;
        $array['namaUnit'] = $namaUnit;
        $this->display('acMonitoringStok', $array);
    }
    
    public function transPermintaan(){
        $id_akun= $this->session->userdata['telah_masuk']["idakun"];
        $idUnit= $this->session->userdata['telah_masuk']['idunit'];
        
        $penugasan= $this->mdrughc->getPenugasan($id_akun, $idUnit);
        $tanggalTransaksi= $this->convert($this->input->post('transaksi'));
        $tanggalRekapTransaksi= $this->convert($this->input->post('transaksi_now'));
        $listKode= json_decode($this->input->post('total_kodeObat'));
        $listJml= json_decode($this->input->post('total_jumlahObat'));
        $jenisTransaksi= $this->input->post('jenis_transaksi');
            $param1= 'TRANSAKSI_UNIT_DARI';
            $param2= 'TRANSAKSI_UNIT_KE';
        
        $data = array(
            'ID_PENUGASAN' => $penugasan[0]['ID_PENUGASAN'],
            'ID_JENISTRANSAKSI' => $jenisTransaksi,
            'TANGGAL_TRANSAKSI' => $tanggalTransaksi,
            'TANGGAL_REKAP_TRANSAKSI' => $tanggalRekapTransaksi,
            $param1 => $this->input->post('dari'),    //unit
            $param2 => $this->input->post('ke'),   //unit
            'FLAG_KONFIRMASI' => $this->input->post('flag_konfirmasi'),
            'ID_RUJUKAN_KONFIRMASI' => $this->input->post('id_rujukan')
        );
        $lastID= $this->mdrughc->insertAndGetLast('transaksi_obat', $data);
        
        for($i=0; $i<sizeof($listKode); $i++):
            $data_obat= array(
                'ID_TRANSAKSI'=> $lastID,
                'ID_OBAT'=> $listKode[$i],
                'JUMLAH_OBAT'=> $listJml[$i],
                'ID_UNIT'=> $idUnit
            );
            $this->mdrughc->insert('detil_transaksi_obat', $data_obat);
        endfor;
    
        redirect(base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/showTransPermintaan/'.$lastID);
    }
    
    public function showTransPermintaan($idTransaksi){
        $queryTrans= $this->mdrughc->getSomeTransaksi($idTransaksi);
        $jenisTrans= $this->mdrughc->getSomeJenisTrans($queryTrans[0]['ID_JENISTRANSAKSI']);
        $param= array('ID_UNIT'=>$queryTrans[0]['TRANSAKSI_UNIT_DARI']);
        $temp= $this->mdrughc->getUnit($param);
        $dari= $temp[0]['NAMA_UNIT'];
        $param= array('ID_UNIT'=>$queryTrans[0]['TRANSAKSI_UNIT_KE']);
        $temp= $this->mdrughc->getUnit($param);
        $ke= $temp[0]['NAMA_UNIT'];
        
        $queryDetailTrans= $this->mdrughc->getSomeDetailTrans($idTransaksi);
        $listNamObat = array();
        $listJmlObat = array();
        $listSatObat = array();
        for($i=0; $i<sizeof($queryDetailTrans); $i++):
            $getObat= $this->mdrughc->getSomeObat($queryDetailTrans[$i]['ID_OBAT']);
            array_push($listNamObat, $getObat[0]['NAMA_OBAT']);
            array_push($listJmlObat, $queryDetailTrans[$i]['JUMLAH_OBAT']);
            array_push($listSatObat, $getObat[0]['SATUAN']);
        endfor;
        
        $array['trans']= $queryTrans; 
        $array['jenisTrans']= $jenisTrans;
        $array['dari']= $dari;
        $array['ke']= $ke;
        $array['detailTrans']= $queryDetailTrans;
        $array['listNamObat']= $listNamObat;
        $array['listJmlObat']= $listJmlObat;
        $array['listSatObat']= $listSatObat;
        $this->display('acShowResultTransaksiPermintaan', $array);
    }
    
    //function show result transaksi logistik obat
    public function showTrans($idTransaksi) {
        $queryTrans = $this->mdrughc->getSomeTransaksi($idTransaksi);
        $jenisTrans = $this->mdrughc->getSomeJenisTrans($queryTrans[0]['ID_JENISTRANSAKSI']);
        if ($jenisTrans[0]['ID_JENISTRANSAKSI'] != 15) {    //bukan Penerimaan Obat selain GFK
            $param = array('ID_UNIT' => $queryTrans[0]['TRANSAKSI_UNIT_DARI']);
            $temp = $this->mdrughc->getUnit($param);
            $dari = $temp[0]['NAMA_UNIT'];
            $param = array('ID_UNIT' => $queryTrans[0]['TRANSAKSI_UNIT_KE']);
            $temp = $this->mdrughc->getUnit($param);
            $ke = $temp[0]['NAMA_UNIT'];
        } else {
            $dari = $queryTrans[0]['NAMA_TRANSAKSI_SUMBER_LAIN'];
            $param = array('ID_UNIT' => $queryTrans[0]['TRANSAKSI_UNIT_KE']);
            $temp = $this->mdrughc->getUnit($param);
            $ke = $temp[0]['NAMA_UNIT'];
        }

        $queryDetailTrans = $this->mdrughc->getSomeDetailTrans($idTransaksi);
        $listNamObat = array();
        $listBatch = array();
        $listJmlObat = array();
        $listSatObat = array();
        $listExpired = array();
        for ($i = 0; $i < sizeof($queryDetailTrans); $i++):
            $getObat = $this->mdrughc->getSomeObat($queryDetailTrans[$i]['ID_OBAT']);
            array_push($listNamObat, $getObat[0]['NAMA_OBAT']);
            array_push($listJmlObat, $queryDetailTrans[$i]['JUMLAH_OBAT']);
            array_push($listSatObat, $getObat[0]['SATUAN']);
            array_push($listBatch, $queryDetailTrans[$i]['NOMOR_BATCH']);
            array_push($listExpired, $queryDetailTrans[$i]['EXPIRED_DATE']);
        endfor;

        $array['trans'] = $queryTrans;
        $array['jenisTrans'] = $jenisTrans;
        $array['dari'] = $dari;
        $array['ke'] = $ke;
        $array['detailTrans'] = $queryDetailTrans;
        $array['listNamObat'] = $listNamObat;
        $array['listJmlObat'] = $listJmlObat;
        $array['listSatObat'] = $listSatObat;
        $array['listBatch'] = $listBatch;
        $array['listExpired'] = $listExpired;
        $this->display('acShowResultTransaksi', $array);
    }

    public function request() {
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];

        $ke= $this->mdrughc->getDataLengkapPenugasan(2, $idGedung);//get Data Gudang Obat

        $jenisTrans = $this->mdrughc->getSomeJenisTrans(11); //Permintaan Unit / Layanan ke Gudang Obat 
        $array['jenisTransId'] = $jenisTrans[0]['ID_JENISTRANSAKSI'];
        $array['jenisTransNama'] = $jenisTrans[0]['NAMA_JENIS'];
        $array['dari_id'] = $idUnit;
        $array['dari_nama'] = $namaUnit;
        $array['ke_id'] = $ke[0]['ID_UNIT'];
        $array['ke_nama'] = $ke[0]['NAMA_UNIT'];
        $this->display('acRequestDrug', $array);
    }
    
    //function transaksi logistik obat
    public function addRequest() {
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];

        $penugasan = $this->mdrughc->getPenugasan($id_akun, $idUnit);
        $tanggalTransaksi = $this->convert($this->input->post('transaksi'));
        $tanggalRekapTransaksi = $this->convert($this->input->post('transaksi_now'));
        $listKode = json_decode($this->input->post('total_kodeObat'));
        $listBatch = json_decode($this->input->post('total_batch'));
        $listJml = json_decode($this->input->post('total_jumlahObat'));
        $jenisTransaksi = $this->input->post('jenis_transaksi');

        $data = array(
            'ID_PENUGASAN' => $penugasan[0]['ID_PENUGASAN'],
            'ID_JENISTRANSAKSI' => $this->input->post('jenis_transaksi'),
            'TANGGAL_TRANSAKSI' => $tanggalTransaksi,
            'TANGGAL_REKAP_TRANSAKSI' => $tanggalRekapTransaksi,
            'TRANSAKSI_UNIT_DARI' => $this->input->post('dari'),
            'TRANSAKSI_UNIT_KE' => $this->input->post('ke'),
            'FLAG_KONFIRMASI' => $this->input->post('flag_konfirmasi'),
            'ID_RUJUKAN_KONFIRMASI' => $this->input->post('id_rujukan')
        );
        $lastID = $this->mdrughc->insertAndGetLast('transaksi_obat', $data);

        $idTransBefore = $this->input->post('id_rujukan');
        if (isset($idTransBefore)) {    //cek if it has id_rujukan
            $dataResep = array(
                'FLAG_KONFIRMASI' => 1
            );
            $updateResep = $this->mdrughc->update('transaksi_obat', $dataResep, 'ID_TRANSAKSI', $idTransBefore);
        }

        for ($i = 0; $i < sizeof($listKode); $i++):
            if ($jenisTransaksi == 20) {   //Penerimaan Layanan / Unit dari Gudang Obat
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit Pengirim Obat
                $this->mdrughc->penambahanStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if ($jenisTransaksi == 10) {   //Pemakaian
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit Pengirim Obat
                $this->mdrughc->penguranganStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if ($jenisTransaksi == 22) {   //Retur Obat Unit ke Gudang Obat
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit Pengirim Obat
                $this->mdrughc->penguranganStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if ($jenisTransaksi == 11) { //Permintaan Unit / Layanan ke Gudang Obat 
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('ke'), $listBatch[$i], $listKode[$i]);  //idUnit Pengirim Obat
                $this->mdrughc->permintaanStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
        endfor;

        redirect(base_url() . 'index.php/' . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/showTrans/' . $lastID);
    }
    
    //function obat masuk
    public function obatMasuk($tipe, $idTransaksi = 0, $idUnitParam = 0) {
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];

        $getObat = $this->mdrughc->getObat();
        $array['allObat'] = $getObat;

        $currentJob = $this->mdrughc->getHakAkses($id_akun); //get id_unit and id_gedung user
        $ke = $this->mdrughc->getUnitFilter($idGedung);   //get id all unit except Apotik

        switch ($tipe):
            case 'daftar_pengiriman':
                $array['pengiriman'] = $this->mdrughc->getSomeTransaksiParam(array(
                    'ID_JENISTRANSAKSI' => 4,
                    'TRANSAKSI_UNIT_KE' => $idUnit,
                    'FLAG_KONFIRMASI' => 0
                ));    //Pengiriman Apotik ke Layanan / Unit
                $listPengiriman = $array['pengiriman'];
                for ($i = 0; $i < sizeof($listPengiriman); $i++) {
                    $unit[$i] = $this->mdrughc->getUnit(array('ID_UNIT' => $listPengiriman[$i]['TRANSAKSI_UNIT_DARI']));
                    $ress[$i] = $this->mdrughc->getSomeTransaksiParam(array('ID_RUJUKAN_KONFIRMASI' => $listPengiriman[$i]['ID_TRANSAKSI']));
                }
                if (isset($unit))
                    $array['unit'] = $unit;
                if (isset($ress))
                    $array['flag'] = $ress;
                $jenisTrans1 = $this->mdrughc->getSomeJenisTrans(4);    //Pengiriman Apotik ke Layanan / Unit
                $array['jenisTransNama1'] = $jenisTrans1[0]['NAMA_JENIS'];
                $this->display('acGiftList', $array);
                break;
            case 'detail':
                $ke = $this->mdrughc->getUnit(array('ID_UNIT' => $idUnitParam));
                $array['trans'] = $this->mdrughc->getSomeTransaksiParam(array('ID_TRANSAKSI' => $idTransaksi));
                $array['detTrans'] = $this->mdrughc->getDetailTransObat($idTransaksi);
                $jenisTrans = $this->mdrughc->getSomeJenisTrans(20); //Penerimaan Layanan / Unit dari Apotik
                $array['jenisLokasi'] = 'unit-unit';
                $array['jenisTransId'] = $jenisTrans[0]['ID_JENISTRANSAKSI'];
                $array['jenisTransNama'] = $jenisTrans[0]['NAMA_JENIS'];
                $array['ke_id'] = $idUnit;
                $array['ke_nama'] = $namaUnit;
                $array['dari_id'] = $ke[0]['ID_UNIT'];
                $array['dari_nama'] = $ke[0]['NAMA_UNIT'];
                $array['flag'] = $idTransaksi;   //track id permintaan
                $this->display('acGiftDrugSuccess', $array);
                break;
        endswitch;
    }
    
    //fungsi pemakaian obat
    public function obatKeluar($tipe){
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];
        
        switch ($tipe){
            case 'pemakaian':
                $jenisTrans = $this->mdrughc->getSomeJenisTrans(10); //Pemakaian
                $array['jenisTransId'] = $jenisTrans[0]['ID_JENISTRANSAKSI'];
                $array['jenisTransNama'] = $jenisTrans[0]['NAMA_JENIS'];
                $array['dari_id'] = $idUnit;
                $array['ke_id'] = $idUnit;
                $array['dari_nama'] = $namaUnit;
                $this->display('acPemakaianObat', $array);
                break;
            case 'retur':
                $ke= $this->mdrughc->getDataLengkapPenugasan(2, $idGedung);//get Data Gudang Obat
                $jenisTrans = $this->mdrughc->getSomeJenisTrans(22); //Retur Obat Unit ke Gudang Obat
                $array['jenisTransId'] = $jenisTrans[0]['ID_JENISTRANSAKSI'];
                $array['jenisTransNama'] = $jenisTrans[0]['NAMA_JENIS'];
                $array['dari_id'] = $idUnit;
                $array['dari_nama'] = $namaUnit;
                $array['ke_id'] = $ke[0]['ID_UNIT'];
                $array['ke_nama'] = $ke[0]['NAMA_UNIT'];
                $this->display('acReturObat', $array);
                break;
        }
    }
    
    public function riwayatObat($tipe, $startRow=0){
        $this->title="";
        $id_hakakses= $this->session->userdata['telah_masuk']["idha"];
        $id_akun= $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses= $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit= $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit= $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung= $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung= $this->session->userdata['telah_masuk']['namagedung'];
        switch ($tipe):
            case 'masuk':
                $array['jenisTransNama']= 'Riwayat Obat Masuk';
                $url= $this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$this->uri->segment(4, 0);
                $perPage= 10;
                $total_rows= $this->mdrughc->getRiwayatObatMasukCount($id_hakakses, $idUnit);
                $pagination= $this->init_pagination($url,$total_rows,$perPage,5);
                $array['dataTrans']= $this->mdrughc->getRiwayatObatMasuk($id_hakakses, $idUnit, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('riwayatObat', $array);
                break;
            case 'minta':
                $array['jenisTransNama']= 'Riwayat Obat Minta';
                $url= $this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$this->uri->segment(4, 0);
                $perPage= 10;
                $total_rows= $this->mdrughc->getRiwayatObatMintaCount($id_hakakses, $idUnit);
                $pagination= $this->init_pagination($url,$total_rows,$perPage,5);
                $array['dataTrans']= $this->mdrughc->getRiwayatObatMinta($id_hakakses, $idUnit, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('riwayatObat', $array);
                break;
            case 'pemakaian':
                $array['jenisTransNama']= 'Riwayat Pemakaian Obat';
                $url= $this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$this->uri->segment(4, 0);
                $perPage= 10;
                $total_rows= $this->mdrughc->getRiwayatPemakaianObatCount($idUnit);
                $pagination= $this->init_pagination($url,$total_rows,$perPage,5);
                $array['dataTrans']= $this->mdrughc->getRiwayatPemakaianObat($idUnit, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('riwayatObat', $array);
                break;
            case 'retur':
                $array['jenisTransNama']= 'Riwayat Retur Obat';
                $url= $this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$this->uri->segment(4, 0);
                $perPage= 10;
                $total_rows= $this->mdrughc->getRiwayatReturObatCount($idUnit);
                $pagination= $this->init_pagination($url,$total_rows,$perPage,5);
                $array['dataTrans']= $this->mdrughc->getRiwayatReturObat($idUnit, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('riwayatObat', $array);
                break;
        endswitch;
    }
    
    public function init_pagination($url,$total_rows,$per_page,$segment){
        $config['base_url'] = base_url().$url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = $segment;
        $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_link'] = '&lt;&lt; Pertama';
        $config['last_link'] = 'Terakhir &gt;&gt;';
        $this->pagination->initialize($config);
        return $config;   
    }
    
    function searchObatMaster(){
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');

        $teks = $data['tanda'];
        $temp1= $this->mdrughc->getSomeObatComplexParam($teks);
        $data["submit"] = $this->getPivotObatMaster($temp1);
        return $data["submit"];
    }
    
    private function getPivotObatMaster($data) {
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
            $header .= ',"<button data-toggle=\"modal\" href=\"#myModal\" onclick=\"setObat(\''.$value->ID_OBAT.'\',\''.$this->replaceString($value->NAMA_OBAT).'\',\''.$value->SATUAN.'\')\" class=\"btn btn-primary\">Pilih</button>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }
    
    private function replaceString($input) {
        $output = str_replace("\"", "\\\"", $input);
        $output = str_replace("\'", "\\\'", $output);
        return $output;
    }

    function searchObat($idUnit, $tipe=null) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');

        $teks = $data['tanda'];
        $temp1 = $this->mdrughc->getAllStok($idUnit, $teks);
        $data["submit"] = $this->getPivotObat($temp1, $tipe);
        return $data["submit"];
    }

    private function getPivotObat($data, $tipe) {
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
            $mydate2 = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
            $mydate1 = DateTime::createFromFormat('Y-m-d', $value->EXPIRED_DATE);
            $disabled= '';
            $btnName= 'Pilih';
            $btnColor= 'primary';
            if($mydate1 <= $mydate2 && $tipe!='retur') {
                $disabled= 'disabled';
                $btnName= 'Expired';
                $btnColor= 'danger';
            }
            $header .= ',"<button '.$disabled.' data-toggle=\"modal\" href=\"#myModal\" onclick=\"setObat(\'' . $value->ID_DETIL_TO . '\',\'' . $value->ID_OBAT . '\',\'' . $value->NOMOR_BATCH . '\',\'' . $this->replaceString($value->NAMA_OBAT) . '\',\'' . $value->STOK . '\',\'' . $value->SATUAN . '\',\'' . $value->EXPIRED_DATE . '\')\" class=\"btn btn-'.$btnColor.'\">'.$btnName.'</button>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }
    
    function searchObatBuang($idUnit) { //search obat yang akan dibuang
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');

        $teks = $data['tanda'];
        $temp1 = $this->mdrughc->getAllStok($idUnit, $teks);
        $data["submit"] = $this->getPivotObatBuang($temp1);
        return $data["submit"];
    }

    private function getPivotObatBuang($data) {
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
            $header .= ',"<button data-toggle=\"modal\" href=\"#myModal\" onclick=\"setObat(\'' . $value->ID_DETIL_TO . '\',\'' . $value->ID_OBAT . '\',\'' . $value->NOMOR_BATCH . '\',\'' . $value->NAMA_OBAT . '\',\'' . $value->STOK . '\',\'' . $value->SATUAN . '\',\'' . $value->EXPIRED_DATE . '\')\" class=\"btn btn-primary\">Pilih</button>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }

}
