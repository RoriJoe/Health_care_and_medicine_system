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
class Kia extends oppusController {

    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    private $home;

    public function __construct() {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('mkia');
        $this->load->model('mdrughc');
        $this->load->model('mDrugsNow');
        $this->load->model('mAccount');
        $this->load->model('mAssignment');
        $this->load->model('mQueue');
        $this->load->model('mMRHistory');
        $this->load->model('mCaseStatus');
        $this->load->model('mPatient');
        $this->load->model('mComplaint');
        $this->load->model('mDiagnosis');
        $this->load->model('mIcd');
        $this->load->model('unit_model');
        $this->load->model('mLabCheck');
        $this->load->model('mHServices');
        $this->load->model('mAction');
        $this->load->model('mMRHistory');
        $this->load->model('Unit_model');
        $this->home = base_url() . "pustu/kia/";
        $this->top_navbar = 'lay-top-navbar/oppusNavbar_kia';
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
    
    /*fungsi holong*/
    function updateAllEntryRRM() {
        $data = $this->input->post(null, true);
        $id_rrm = $data['id_rrm'];
        unset($data['id_rrm']);

        $this->mMRHistory->updateEntry($data, $id_rrm);
        redirect($this->home);
    }

//    public function index() {
//        redirect($this->home . '/dataRiwayat/'.$this->uri->segment(4, 0));
//    }

    function getSearch() {
        // header('Cache-Control: no-cache, must-revalidate');
        // header('Access-Control-Allow-Origin: *');
        // header('Content-type: application/json');

        $data = $this->input->post('teksnya');

        $teks = $data['tanda'];
        $temp1 = $this->mIcd->getAllEntry($teks);

        $data = $this->getPivot($temp1);
        echo $data;
    }

    function clean($string) {
        //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        //return str_replace(array('\'', '\\', '/', '*'), ' ', $string);
        return preg_replace('/[^A-Za-z0-9\-@ .,]/', '-', $string); // Removes special chars.
    }

    private function _setFlashData($status) {
        $key = 'error';
        if ($status == true)
            $message = 'success';
        else
            $message = 'failed';

        $this->session->set_flashdata($key, $message);
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
            $header .= ',"<a style=\'color: white;\' class=\'btn btn-success\' type=\'button\' onclick=\'ICDChoosed(' . $value['ID_ICD'] . ')\' ><i class=\'fa fa-check\'></i></a>"';
            $header .= "]";
        }
        $header .= "]";
        return $header;
    }

    private function _getFormFill() {
        $data = array(
            "error_msg" => $this->session->flashdata('error'),
            //"allKasus" => $this->mCaseStatus->getAllEntry (),
            "unit" => $this->unit_model->getUnitByHC(),
//            "queues" => $this->mQueue->getAllByUnit($this->session->userdata['telah_masuk']['idunit']),
            "queues" => $this->mQueue->getAllByUnit($this->session->userdata['telah_masuk']['idunit'], $this->uri->segment(4, 0)),
            "layanan" => $this->mHServices->getAllEntry()
                //"icd" => $this->mIcd->getAllEntry ()
        );
        return $data;
    }

    public function showICD() {
        $query = $this->input->post('query');
        $data = $this->mIcd->getEntryByQuery($query);
        if ($data)
            echo json_encode($data);
    }

    public function showICDById() {
        $id = $this->input->post('id');
        $result = $this->mIcd->getEntryById($id);
        if ($result)
            echo json_encode($result);
    }

    function showStocks() {
        $id_unit = $this->session->userdata['telah_masuk']['idunit'];
        $data = $this->mDrugsNow->getEntryByUnit($id_unit);
        if ($data) {
            echo $this->getPivotStocks($data);
        } else
            echo 'Kosong';
    }

    public function stocks() {
        $this->display('kia/stockPoly');
    }

    // home
    public function queue() {
//        $data = $this->_getFormFill();
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];
        
        $data['namaUnit']= $namaUnit;
        $this->display('kia/acDashboard', $data);
    }
    
    public function profileMRH($type,$id) {
        $data['idrrm'] = $id;
        $data['profil'] = $this->mMRHistory->getProfilMRH($id);
        $data['riwayat_rm'] = $this->mMRHistory->getMRHById($id);
        $data['tindakan'] = $this->mHServices->getEntryById($id);
        $data['laborat'] = $this->mLabCheck->getEntryById($id);
        $data['icd'] = $this->mDiagnosis->getEntryById($id);
        $data['dataKia'] = $this->mkia->getTable('data_kia', array('ID_RIWAYAT_RM'=>$id));
        $data['dataKb'] = $this->mkia->getDataKB($id);
        $data['dataBalita'] = $this->mkia->getTable('data_anak_balita', array('ID_RIWAYAT_RM'=>$id));
        $data['dataVkkia'] = $this->mkia->getTable('data_vkkia', array('ID_RIWAYAT_RM'=>$id));
        $this->display('kia/mrhProfile', $data);
    }

    public function patientMRH() {
        $id = $this->uri->segment(5, 0);
        // Perubahan !!!
        // idrrm to id_rm
        $data['id_rm'] = $id;
        $data['data_rrm'] = $this->mMRHistory->getMRHByIdMR($id, 100);
        $this->display('kia/allMedRecord', $data);
    }

    function getSearch2($type) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');
        
        $idrrm = $data['id_rm'];
        $rangedata = $data['range'];
        $temp1 = $this->mMRHistory->getMRHByIdMR($idrrm, $rangedata);
        $data["submit"] = $this->getPivot2($temp1,$type);
        if ($data) {
            return $data["submit"];
        } else
            return "nothing";
    }

    private function getPivot2($data) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        $header = "[[";
        foreach ($data as $value) {
            $header .= '"NOMOR"';
            foreach ($value as $key=> $sembarang) {
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

    public function getPatientData() {
        $idRMHistory = $this->input->post('id');
        $result = $this->mPatient->getEntryByRRM($idRMHistory);
        if ($result)
            echo json_encode($result);
    }

    public function getPatientHistory() {
        $idRMHistory = $this->input->post('id');
        $result = $this->mMRHistory->getMRHById($idRMHistory);
        if ($result)
            echo json_encode($result);
    }

    private function _updateRiwayat($form_data) {
        $data = array(
            'CUMA_KONTROL' => (isset($form_data['CUMA_KONTROL'])) ? $form_data['CUMA_KONTROL'] : null,
            'BERATBADAN_PASIEN' => (isset($form_data['BERATBADAN_PASIEN'])) ? $form_data['BERATBADAN_PASIEN'] : null,
            'TINGGIBADAN_PASIEN' => (isset($form_data['TINGGIBADAN_PASIEN'])) ? $form_data['TINGGIBADAN_PASIEN'] : null,
            'SISTOL_PASIEN' => (isset($form_data['SISTOL_PASIEN'])) ? $form_data['SISTOL_PASIEN'] : null,
            'DIASTOL_PASIEN' => (isset($form_data['DIASTOL_PASIEN'])) ? $form_data['DIASTOL_PASIEN'] : null,
            'SUHU_BADAN' => (isset($form_data['SUHU_BADAN'])) ? $form_data['SUHU_BADAN'] : null,
            'NAPAS_PER_MENIT' => (isset($form_data['NAPAS_PER_MENIT'])) ? $form_data['NAPAS_PER_MENIT'] : null,
            'DETAK_JANTUNG' => (isset($form_data['DETAK_JANTUNG'])) ? $form_data['DETAK_JANTUNG'] : null,
            'UMUR_SAAT_INI' => (isset($form_data['UMUR_SAAT_INI']))?$form_data['UMUR_SAAT_INI']:null,	
            'STAT_RAWAT_JALAN' => (isset($form_data['STAT_RAWAT_JALAN'])) ? $form_data['STAT_RAWAT_JALAN'] : null,
            'TEMPAT_RUJUKAN' => (isset($form_data['TEMPAT_RUJUKAN'])) ? $form_data['TEMPAT_RUJUKAN'] : null,
            'kunjungan_kasus' => (isset($form_data['kunjungan'])) ? $form_data['kunjungan'] : null
        );
        $this->mMRHistory->updateEntry($data, $form_data['id_rrm']);
    }

    private function _updateLayananKesehatan($form_data) {
        unset($form_data['layananKesehatan']);
        $data_tindakan = array();
        foreach ($form_data as $key => $value) {
            if (strpos($key, "layanan") !== false) {
                $temps = explode("-", $key);
                $id = $temps[1];
                $arr = array(
                    'ID_RIWAYAT_RM' => $form_data['id_rrm'],
                    'ID_LAYANAN_KES' => $id,
                    'ID_AKUN' => $this->session->userdata['telah_masuk']['idakun'],
                    'TANGGAL_TINDAKAN' => date('Y-m-d H:i:s')
                );
                $data_tindakan[] = $arr;
            }
        }
        foreach ($data_tindakan as $tindakan)
            $this->mAction->insertNewEntry($tindakan);
    }

    private function _insertComplaintDiagnosis($idMRHistory, $keluhan, $diagnosis, $id, $data_icd, $form_data) {
        $keluhans = explode(",", $keluhan);
        foreach ($keluhans as $keluhkesah) {
            $data_keluhan = array(
                'ID_RIWAYAT_RM' => $idMRHistory,
                'DESKRIPSI_KELUHAN' => $keluhkesah,
                'ID_AKUN' => $id
            );
            $this->mComplaint->insertNewEntry($data_keluhan);
        }
        foreach ($data_icd as $key => $item) {
            $data_diagnosis = array(
                'ID_RIWAYAT_RM' => $idMRHistory,
                'DESKRIPSI_DP' => $diagnosis,
                'ID_AKUN' => $id,
                'ID_ICD' => $key,
                'NAMA_STATUS_KASUS' => $form_data['kasus-'.$key]
            );
            $this->mDiagnosis->insertNewEntry($data_diagnosis);
        }
        return true;
    }

    private function _updateDataICD($form_data) {
        $data_icd = array();
        foreach ($form_data as $key => $value) {
            if (strpos($key, "icd") !== false) {
                $temps = explode("-", $key);
                $id = $temps[1];
                $data_icd[$id] = $value;
            }
        }
        $this->_insertComplaintDiagnosis($form_data['id_rrm'], $form_data['keluhan'], $form_data['diagnosa'], $this->session->userdata['telah_masuk']['idakun'], $data_icd, $form_data);
    }

    private function _updateAntrian($no_antrian) {
        $this->mQueue->updateQueue($no_antrian);
    }

    private function _masukAntrianPoliLain($form_data) {
        $id_rrm = $form_data['id_rrm'];
        $idunit = $form_data['id_unit_tujuan'];
        $dataUnit= explode("_",$idunit);
        $idsumber = $this->input->post('ID_SUMBER');
        $roro = $this->mMRHistory->getMRHById($id_rrm);
        $med_record_history = array(
            'id_rekammedik' => $roro[0]['ID_REKAMMEDIK'],
            'id_sumber' => $idsumber,
            'tanggal_riwayat_rm' => date('Y-m-d')
        );
        $last_medHistoryId = $this->mMRHistory->insertNewEntry($med_record_history, $dataUnit[0]);
        $s = $this->input->post('tanggalAntrian').' '.$this->input->post('waktuAntrian');
        $date = strtotime($s);
        $waktuantrian = date('Y-m-d H:i:s', $date);
        $data_queue = array(
            'id_unit' => $dataUnit[0],
            'id_riwayat_rm' => $last_medHistoryId,
            'FLAG_INTERN' => 1,
            'waktu_antrian_unit' => $waktuantrian,
            'sub_pustu' => $dataUnit[1]
        );
        // masuk antrian
        $this->mdrughc->insert('antrian_unit', $data_queue);
    }

    private function _simpanRiwayat($form_data) {
        $this->_updateRiwayat($form_data);
        $this->_updateLayananKesehatan($form_data);
        $this->_updateDataICD($form_data);
        $this->_updateAntrian($form_data['hidden_noantrian']);
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

    function toLaborat() {
        $this->display('kia/laboratorium');
    }

    function showLaborat() {
//		$id_unit = $this->session->userdata['telah_masuk']['idunit'];
        $data = $this->mLabCheck->getAllEntry();
        echo $this->getPivotLaborat($data);
    }

    private function getPivotLaborat($data) {
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
            $header .= ",\"PILIH\"";
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
            $header .= ',"<a type=\"button\" style=\"color: white\" onclick=\"addPemeriksaanLaborat(\'' . $value['ID_PEM_LABORAT'] . '\',\'' . $value['NAMA_PEM_LABORAT'] . '\')\" class=\"btn btn-primary\"><i class=\"fa fa-check\"></i></a>"';
            $header .= "]";
        }
        $header .= "]";
        return $header;
    }

    function insertCekLaborat() {
        $form_data = $this->input->post(null, true);
        checkIfEmpty($form_data, $this->home);

        $id_unit_tujuan = $form_data['id_unit_tujuan'];
        unset($form_data['id_unit_tujuan']);

        $id_rrm = $form_data['id_rrm'];
        unset($form_data['id_rrm']);

        $id_antrian = $form_data['id_antrian'];
        unset($form_data['id_antrian']);

        foreach ($form_data as $key => $value) {
            $data = array(
                'ID_RIWAYAT_RM' => $id_rrm,
                'ID_PEM_LABORAT' => $key
            );
            $this->mLabCheck->insertNewEntry($data);
        }
        //var_dump($id_antrian);
        $this->mQueue->updateQueue($id_antrian);

        $data_antrian = array(
            'FLAG_ANTRIAN_UNIT' => 0,
            'ID_UNIT' => $id_unit_tujuan,
            'ID_RIWAYAT_RM' => $id_rrm,
            'WAKTU_ANTRIAN_UNIT' => date('Y-m-d H:i:s')
        );


        $this->mQueue->insertNewEntry($data_antrian);
        redirect($this->home);
    }

    private function getPivotStocks($data) {
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
            $header .= "]";
        }
        $header .= "]";
        return $header;
    }
    /*end fungsi holong*/
    
    public function patient($type) {
        switch ($type):
            case 'balita':
                $this->display('kia/patientBalita');
                break;
            case 'kia':
                $this->display('kia/patientKia');
                break;
            case 'vkkia':
                $this->display('kia/patientVkkia');
                break;
            case 'kb':
                $this->display('kia/patientKb');
                break;
        endswitch;
    }
    
    function showPatient($type) {
        $id_unit = $this->session->userdata['telah_masuk']['idunit'];
        switch ($type):
            case 'balita':
                    $data = $this->mkia->getHistoryRRMbalita($id_unit);
                    echo $this->getPivotPatient($data, 'balita');
                break;
            case 'kia':
                    $data = $this->mkia->getHistoryRRMkia($id_unit);
                    echo $this->getPivotPatient($data, 'kia');
                break;
            case 'vkkia':
                    $data = $this->mkia->getHistoryRRMvkkia($id_unit);
                    echo $this->getPivotPatient($data, 'vkkia');
                break;
            case 'kb':
                    $data = $this->mkia->getHistoryRRMkb($id_unit);
                    echo $this->getPivotPatient($data, 'kb');
                break;
        endswitch;
    }
    
    
    //function KbPasien
    public function dataRiwayat($tipe) {
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];
        
        $array = $this->_getFormFill();
        $array['idUnit']= $idUnit;
        $array['alat_kb'] = $this->mdrughc->getTable('alat_kb');
        switch ($tipe):
            case 'dashboard':
                $this->queue();
                break;
            case 'kia':
                $array['skoring']= $this->mdrughc->getTable('data_master_skor_kia', array('UNIT_KIA' => 'bumil'));
                $this->display('kia/acFormKIA_Bumil', $array);
                break;
            case 'vkkia':
                $array['skoring']= $this->mdrughc->getTable('data_master_skor_kia', array('UNIT_KIA' => 'vkkia'));
                $this->display('kia/acFormKIA_VKKIA', $array);
                break;
            case 'balita':
                $this->display('kia/acFormKIA_Balita', $array);
                break;
            case 'kb':
                $array['couple'] = '';
                $array['suami'] = '';
                $array['istri'] = '';
                if (!empty($dataPasien[0]['ID_SUAMI'])) {
                    $array['couple'] = 'suami';
                    $array['suami'] = $this->mdrughc->getTable('view_pasien_rrm', array('ID_PASIEN' => $dataPasien[0]['ID_SUAMI']));
                } else if (!empty($dataPasien[0]['ID_ISTRI'])) {
                    $array['couple'] = 'istri';
                    $array['istri'] = $this->mdrughc->getTable('view_pasien_rrm', array('ID_PASIEN' => $dataPasien[0]['ID_ISTRI']));
                }
                $this->display('kia/acFormKIA_KB', $array);
                break;
        endswitch;
    }
    
    public function updateDataBalita() {
        $idAntrian = $this->input->post('hidden_noantrian');
        $idPasien = $this->input->post('ID_PASIEN');
        $idRiwayatRM = $this->input->post('id_rrm');
        
        $dataBalita = array(
            'ID_RIWAYAT_RM' => $idRiwayatRM,
            'TEMPAT_LAHIR' => $this->input->post('TEMPAT_LAHIR'),
            'FLAG_BCG' => $this->input->post('FLAG_BCG'),
            'FLAG_VIT_A_ANAK' => $this->input->post('FLAG_VIT_A_ANAK'),
            'FLAG_HBO' => $this->input->post('FLAG_HBO'),
            'FLAG_DPT_COMBO1' => $this->input->post('FLAG_DPT_COMBO1'),
            'FLAG_DPT_COMBO2' => $this->input->post('FLAG_DPT_COMBO2'),
            'FLAG_DPT_COMBO3' => $this->input->post('FLAG_DPT_COMBO3'),
            'FLAG_POLIO1' => $this->input->post('FLAG_POLIO1'),
            'FLAG_POLIO2' => $this->input->post('FLAG_POLIO2'),
            'FLAG_POLIO3' => $this->input->post('FLAG_POLIO3'),
            'FLAG_POLIO4' => $this->input->post('FLAG_POLIO4'),
            'FLAG_CAMPAK' => $this->input->post('FLAG_CAMPAK')
        );

        // get all form fill
        $form_data = $this->input->post(null, true);
        checkIfEmpty($form_data, $this->home);

        // throw away garbage
        unset($form_data['pivot-table_length']);
        unset($form_data['queryicd']);

        $flagBtn = $form_data['flagbutton'];
        switch ($flagBtn) {
            case 1:
                // simpan data dan kembali ke antrian
                $this->_simpanRiwayat($form_data);
                $this->mdrughc->insert('data_anak_balita', $dataBalita);
                redirect(base_url().$this->uri->segment(1, 0). '/kia/dataRiwayat/balita');
                break;
            case 2:
                // simpan dan buat resep
                $this->_simpanRiwayat($form_data);
                $this->mdrughc->insert('data_anak_balita', $dataBalita);
                $id_rrm = $form_data['id_rrm'];
                $a_patient = $this->mPatient->getEntryByRRM($id_rrm);
                $idpasien = $a_patient['id_pasien'];
                redirect(base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/receipt/addResep/' . $id_rrm . '/' . $idpasien);
                break;
            case 3:
                // simpan dan arahkan ke poli lain
                $this->_simpanRiwayat($form_data);
                $this->mdrughc->insert('data_anak_balita', $dataBalita);
                $this->_masukAntrianPoliLain($form_data);
                redirect(base_url().$this->uri->segment(1, 0). '/kia/dataRiwayat/balita');
                break;
            case 4:
                // arahkan ke poli lain
                $s = $this->input->post('tanggalAntrian').' '.$this->input->post('waktuAntrian');
                $date = strtotime($s);
                $waktuantrian = date('Y-m-d H:i:s', $date);
                
                $idunit = $this->input->post('id_unit_tujuan');
                $dataUnit= explode("_",$idunit);
                $id_rrm = $this->input->post('id_rrm');
                $data_queue = array(
                    'id_unit' => $dataUnit[0],
                    'id_riwayat_rm' => $id_rrm,
                    'FLAG_INTERN' => 1,
                    'waktu_antrian_unit' => $waktuantrian,
                    'sub_pustu' => $dataUnit[1]
                );
                $this->mdrughc->insert('antrian_unit', $data_queue);
                $this->_updateAntrian($form_data['hidden_noantrian']);
                redirect(base_url().$this->uri->segment(1, 0). '/kia/dataRiwayat/balita');
                break;
        }
    }
    
    public function updateDataBumil() {
        $idAntrian = $this->input->post('hidden_noantrian');
        $idPasien = $this->input->post('ID_PASIEN');
        $idRiwayatRM = $this->input->post('id_rrm');
        
        $dataBumil = array(
            'ID_RIWAYAT_RM' => $idRiwayatRM,
            'FLAG_HAMIL' => $this->input->post('FLAG_HAMIL'),
            'HAMIL_KE' => $this->input->post('HAMIL_KE'),
            'PENYAKIT_BUMIL' => $this->input->post('PENYAKIT_BUMIL'),
            'FLAG_GAGAL_HAMIL' => $this->input->post('FLAG_GAGAL_HAMIL'),
            'UMUR_KEHAMILAN' => $this->input->post('UMUR_KEHAMILAN'),
            'BUMIL_BENGKAK' => $this->input->post('BUMIL_BENGKAK'),
            'FLAG_KEMBAR_AIR' => $this->input->post('FLAG_KEMBAR_AIR'),
            'LETAK_SUNGSANG_LINTANG_KEPALA' => $this->input->post('LETAK_SUNGSANG_LINTANG_KEPALA'),
            'PENDARAHAN_KEHAMILAN_IN' => $this->input->post('PENDARAHAN_KEHAMILAN_IN'),
            'PREEKLAMPSIA_BERAT' => $this->input->post('PREEKLAMPSIA_BERAT'),
            'STATUS_OBSTETRI' => $this->input->post('STATUS_OBSTETRI'),
            'TAKSIRAN_PERSALINAN' => $this->convert($this->input->post('TAKSIRAN_PERSALINAN')),
            'TERKAHIR_HAID' => $this->convert($this->input->post('TERKAHIR_HAID')),
            'SIKLUS_HAID' => $this->input->post('SIKLUS_HAID'),
            'FLAG_IMUNISASI_TT' => $this->input->post('FLAG_IMUNISASI_TT'),
            'TANGGAL_IMUN_TT' => $this->convert($this->input->post('TANGGAL_IMUN_TT')),
            'FLAG_VIT_A_IBU' => $this->input->post('FLAG_VIT_A_IBU'),
            'TANGGAL_VIT_A_IBU' => $this->convert($this->input->post('TANGGAL_VIT_A_IBU')),
            'ANGKA_HB' => $this->input->post('ANGKA_HB'),
            'ANGKA_LILA' => $this->input->post('ANGKA_LILA'),
            'FLAG_KIE_PPIA' => $this->input->post('FLAG_KIE_PPIA'),
            'KUNJUNGAN_BUMIL_KE' => $this->input->post('KUNJUNGAN_BUMIL_KE'),
            'IMUNISASI_T0' => $this->input->post('IMUNISASI_T0'),
            'IMUNISASI_T1' => $this->input->post('IMUNISASI_T1'),
            'IMUNISASI_T2' => $this->input->post('IMUNISASI_T2'),
            'IMUNISASI_T3' => $this->input->post('IMUNISASI_T3'),
            'IMUNISASI_T4' => $this->input->post('IMUNISASI_T4'),
            'IMUNISASI_T5' => $this->input->post('IMUNISASI_T5'),
            'RIWAYAT_IMUNISASI_T0' => $this->input->post('RIWAYAT_IMUNISASI_T0'),
            'RIWAYAT_IMUNISASI_T1' => $this->input->post('RIWAYAT_IMUNISASI_T1'),
            'RIWAYAT_IMUNISASI_T2' => $this->input->post('RIWAYAT_IMUNISASI_T2'),
            'RIWAYAT_IMUNISASI_T3' => $this->input->post('RIWAYAT_IMUNISASI_T3'),
            'RIWAYAT_IMUNISASI_T4' => $this->input->post('RIWAYAT_IMUNISASI_T4'),
            'RIWAYAT_IMUNISASI_T5' => $this->input->post('RIWAYAT_IMUNISASI_T5')
        );

        // get all form fill
        $form_data = $this->input->post(null, true);
        checkIfEmpty($form_data, $this->home);

        // throw away garbage
        unset($form_data['pivot-table_length']);
        unset($form_data['queryicd']);

        $flagBtn = $form_data['flagbutton'];
        switch ($flagBtn) {
            case 1:
                // simpan data dan kembali ke antrian
                $this->_simpanRiwayat($form_data);
                $this->mdrughc->insert('data_kia', $dataBumil);
                redirect(base_url().$this->uri->segment(1, 0). '/kia/dataRiwayat/kia');
                break;
            case 2:
                // simpan dan buat resep
                $this->_simpanRiwayat($form_data);
                $this->mdrughc->insert('data_kia', $dataBumil);
                $id_rrm = $form_data['id_rrm'];
                $a_patient = $this->mPatient->getEntryByRRM($id_rrm);
                $idpasien = $a_patient['id_pasien'];
                redirect(base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/receipt/addResep/' . $id_rrm . '/' . $idpasien);
                break;
            case 3:
                // simpan dan arahkan ke poli lain
                $this->_simpanRiwayat($form_data);
                $this->mdrughc->insert('data_kia', $dataBumil);
                $this->_masukAntrianPoliLain($form_data);
                redirect(base_url().$this->uri->segment(1, 0). '/kia/dataRiwayat/kia');
                break;
            case 4:
                // arahkan ke poli lain
                $s = $this->input->post('tanggalAntrian').' '.$this->input->post('waktuAntrian');
                $date = strtotime($s);
                $waktuantrian = date('Y-m-d H:i:s', $date);
                
                $idunit = $this->input->post('id_unit_tujuan');
                $dataUnit= explode("_",$idunit);
                $id_rrm = $this->input->post('id_rrm');
                $data_queue = array(
                    'id_unit' => $dataUnit[0],
                    'id_riwayat_rm' => $id_rrm,
                    'FLAG_INTERN' => 1,
                    'waktu_antrian_unit' => $waktuantrian,
                    'sub_pustu' => $dataUnit[1]
                );
                $this->mdrughc->insert('antrian_unit', $data_queue);
                $this->_updateAntrian($form_data['hidden_noantrian']);
                redirect(base_url().$this->uri->segment(1, 0). '/kia/dataRiwayat/kia');
                break;
        }
    }
    
    public function updateDataKB() {
        $idAntrian = $this->input->post('hidden_noantrian');
        $idPasien = $this->input->post('ID_PASIEN');
        $idRiwayatRM = $this->input->post('id_rrm');
        $umurBulan= $this->input->post('KB_UMUR_ANAK_TERKECIL_BULAN');
        $umurTahun= $this->input->post('KB_UMUR_ANAK_TERKECIL_TAHUN');
        $umurTahun= $umurTahun*12;
        $umurTotal= $umurBulan+$umurTahun;
        $datakb = array(
            'ID_RIWAYAT_RM' => $idRiwayatRM,
            'KB_JML_ANAK_HIDUP_L' => $this->input->post('KB_JML_ANAK_HIDUP_L'),
            'JML_ANAK_HIDUP_P' => $this->input->post('JML_ANAK_HIDUP_P'),
            'KB_STAT_PESERTA_KB' => $this->input->post('KB_STAT_PESERTA_KB'),
            'KB_UMUR_ANAK_TERKECIL' => $umurTotal,
            'KB_HAID_TERAKHIR' => $this->convert($this->input->post('KB_HAID_TERAKHIR')),
            'KB_DIDUGA_HAMIL' => $this->input->post('KB_DIDUGA_HAMIL'),
            'KB_JML_GPA_GRAVIDA' => $this->input->post('KB_JML_GPA_GRAVIDA'),
            'KB_JML_GPA_PARTUS' => $this->input->post('KB_JML_GPA_PARTUS'),
            'KB_JML_GPA_ABORTUS' => $this->input->post('KB_JML_GPA_ABORTUS'),
            'KB_FLAG_MENYUSUI' => $this->input->post('KB_FLAG_MENYUSUI'),
            'KB_PENYAKIT_SEBELUMNYA_SKUNING' => $this->input->post('KB_PENYAKIT_SEBELUMNYA_SKUNING'),
            'KB_PENYAKIT_SEBELUMNYA_PERVAGINAM' => $this->input->post('KB_PENYAKIT_SEBELUMNYA_PERVAGINAM'),
            'KB_PENYAKIT_SEBELUMNYA_KEPUTIHAN' => $this->input->post('KB_PENYAKIT_SEBELUMNYA_KEPUTIHAN'),
            'KB_PENYAKIT_SEBELUMNYA_TUMOR' => $this->input->post('KB_PENYAKIT_SEBELUMNYA_TUMOR'),
            'KB_KEADAAN_UMUM' => $this->input->post('KB_KEADAAN_UMUM'),
            'KB_TANDA2_RADANG' => $this->input->post('KB_TANDA2_RADANG'),
            'KB_TUMOR_GINEKOLOGI' => $this->input->post('KB_TUMOR_GINEKOLOGI'),
            'KB_POSISI_RAHIM' => $this->input->post('KB_POSISI_RAHIM'),
            'KB_TANDA_DIABET' => $this->input->post('KB_TANDA_DIABET'),
            'KB_KELAINAN_PEMBEKUAN_DARAH' => $this->input->post('KB_KELAINAN_PEMBEKUAN_DARAH'),
            'KB_RADANG_ORCHITIS_EPIDIDYMITIS' => $this->input->post('KB_RADANG_ORCHITIS_EPIDIDYMITIS'),
            'KB_ID_ALAT_KONTRASEPSI_YG_BOLEH' => $this->input->post('KB_ID_ALAT_KONTRASEPSI_YG_BOLEH'),
            'KB_ID_ALAT_KONTRASEPSI_SEBELUMNYA' => $this->input->post('KB_ID_ALAT_KONTRASEPSI_SEBELUMNYA'),
            'KB_TANGGAL_DICABUT' => $this->convert($this->input->post('KB_TANGGAL_DICABUT')),
            'KB_TANGGAL_DIPESAN_KEMBALI' => $this->convert($this->input->post('KB_TANGGAL_DIPESAN_KEMBALI')),
            'KB_AKIBAT_KOMPLIKASI_BERAT' => $this->input->post('KB_AKIBAT_KOMPLIKASI_BERAT'),
            'KB_AKIBAT_KEGAGALAN' => $this->input->post('KB_AKIBAT_KEGAGALAN'),
            'KB_DROP_OUT' => $this->input->post('KB_DROP_OUT'),
            'KB_EFEK_SAMPING' => $this->input->post('KB_EFEK_SAMPING'),
            'ID_ALAT_KB' => $this->input->post('ID_ALAT_KB'),
            'KB_FLAG_SEDANG_KB' => $this->input->post('KB_FLAG_SEDANG_KB'),
            'KODE_KLINIK_KB' => $this->input->post('KODE_KLINIK_KB'),
            'SERI_KARTU_KB' => $this->input->post('SERI_KARTU_KB'),
            'KB_TUMOR_GINEKOLOGI_TAMBAHAN' => $this->input->post('KB_TUMOR_GINEKOLOGI_TAMBAHAN')
        );

        // get all form fill
        $form_data = $this->input->post(null, true);
        checkIfEmpty($form_data, $this->home);

        // throw away garbage
        unset($form_data['pivot-table_length']);
        unset($form_data['queryicd']);

        $flagBtn = $form_data['flagbutton'];
        switch ($flagBtn) {
            case 1:
                // simpan data dan kembali ke antrian
                $this->_simpanRiwayat($form_data);
                $this->mdrughc->insert('data_kb', $datakb);
                redirect(base_url().$this->uri->segment(1, 0). '/kia/dataRiwayat/kb');
                break;
            case 2:
                // simpan dan buat resep
                $this->_simpanRiwayat($form_data);
                $this->mdrughc->insert('data_kb', $datakb);
                $id_rrm = $form_data['id_rrm'];
                $a_patient = $this->mPatient->getEntryByRRM($id_rrm);
                $idpasien = $a_patient['id_pasien'];
                redirect(base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/receipt/addResep/' . $id_rrm . '/' . $idpasien);
                break;
            case 3:
                // simpan dan arahkan ke poli lain
                $this->_simpanRiwayat($form_data);
                $this->mdrughc->insert('data_kb', $datakb);
                $this->_masukAntrianPoliLain($form_data);
                redirect(base_url().$this->uri->segment(1, 0). '/kia/dataRiwayat/kb');
                break;
            case 4:
                // arahkan ke poli lain
                $s = $this->input->post('tanggalAntrian').' '.$this->input->post('waktuAntrian');
                $date = strtotime($s);
                $waktuantrian = date('Y-m-d H:i:s', $date);
                
                $idunit = $this->input->post('id_unit_tujuan');
                $dataUnit= explode("_",$idunit);
                $id_rrm = $this->input->post('id_rrm');
                $data_queue = array(
                    'id_unit' => $dataUnit[0],
                    'id_riwayat_rm' => $id_rrm,
                    'FLAG_INTERN' => 1,
                    'waktu_antrian_unit' => $waktuantrian,
                    'sub_pustu' => $dataUnit[1]
                );
                $this->mdrughc->insert('antrian_unit', $data_queue);
                $this->_updateAntrian($form_data['hidden_noantrian']);
                redirect(base_url().$this->uri->segment(1, 0). '/kia/dataRiwayat/kb');
                break;
        }
    }
    
    public function updateDataVKKIA() {
        $idAntrian = $this->input->post('hidden_noantrian');
        $idPasien = $this->input->post('ID_PASIEN');
        $idRiwayatRM = $this->input->post('id_rrm');
        
        $dataVKKIA = array(
            'ID_RIWAYAT_RM' => $idRiwayatRM,
            'MATI_DLM_KANDUNGAN' => $this->input->post('MATI_DLM_KANDUNGAN'),
            'LAHIR_DGN_VAKUM' => $this->input->post('LAHIR_DGN_VAKUM'),
            'LAHIR_DGN_INFUS_TRANSFUSI' => $this->input->post('LAHIR_DGN_INFUS_TRANSFUSI'),
            'OP_SESAR' => $this->input->post('OP_SESAR'),
            'LAHIR_DGN_URI_DIROGOH' => $this->input->post('LAHIR_DGN_URI_DIROGOH'),
            'BUMIL_DARAH_TINGGI' => $this->input->post('BUMIL_DARAH_TINGGI'),
            'FLAG_KEMBAR2_LEBIH' => $this->input->post('FLAG_KEMBAR2_LEBIH'),
            'KEHAMILAN_LEBIH_BULAN' => $this->input->post('KEHAMILAN_LEBIH_BULAN'),
            'VK_HAMIL_KELAINAN' => $this->input->post('VK_HAMIL_KELAINAN'),
            'VK_NIFAS_KELAINAN' => $this->input->post('VK_NIFAS_KELAINAN'),
            'VK_LAHIR_KELAINAN' => $this->input->post('VK_LAHIR_KELAINAN'),
            'VK_MATERNAL_RISTI' => $this->input->post('VK_MATERNAL_RISTI'),
            'VK_NEONATAL_RISTI' => $this->input->post('VK_NEONATAL_RISTI'),
            'JK_BAYI_LAHIR' => $this->input->post('JK_BAYI_LAHIR'),
            'JK_BAYI_LAHIR2' => $this->input->post('JK_BAYI_LAHIR2'),
            'JK_BAYI_LAHIR3' => $this->input->post('JK_BAYI_LAHIR3'),
            'JK_BAYI_LAHIR4' => $this->input->post('JK_BAYI_LAHIR4'),
            'JK_BAYI_LAHIR5' => $this->input->post('JK_BAYI_LAHIR5'),
            'JML_ANAK_LAHIR' => $this->input->post('JML_ANAK_LAHIR')
        );

        // get all form fill
        $form_data = $this->input->post(null, true);
        checkIfEmpty($form_data, $this->home);

        // throw away garbage
        unset($form_data['pivot-table_length']);
        unset($form_data['queryicd']);

        $flagBtn = $form_data['flagbutton'];
        switch ($flagBtn) {
            case 1:
                // simpan data dan kembali ke antrian
                $this->_simpanRiwayat($form_data);
                $this->mdrughc->insert('data_vkkia', $dataVKKIA);
                redirect(base_url().$this->uri->segment(1, 0). '/kia/dataRiwayat/vkkia');
                break;
            case 2:
                // simpan dan buat resep
                $this->_simpanRiwayat($form_data);
                $this->mdrughc->insert('data_vkkia', $dataVKKIA);
                $id_rrm = $form_data['id_rrm'];
                $a_patient = $this->mPatient->getEntryByRRM($id_rrm);
                $idpasien = $a_patient['id_pasien'];
                redirect(base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/receipt/addResep/' . $id_rrm . '/' . $idpasien);
                break;
            case 3:
                // simpan dan arahkan ke poli lain
                $this->_simpanRiwayat($form_data);
                $this->mdrughc->insert('data_vkkia', $dataVKKIA);
                $this->_masukAntrianPoliLain($form_data);
                redirect(base_url().$this->uri->segment(1, 0). '/kia/dataRiwayat/vkkia');
                break;
            case 4:
                // arahkan ke poli lain
                $s = $this->input->post('tanggalAntrian').' '.$this->input->post('waktuAntrian');
                $date = strtotime($s);
                $waktuantrian = date('Y-m-d H:i:s', $date);
                
                $idunit = $this->input->post('id_unit_tujuan');
                $dataUnit= explode("_",$idunit);
                $id_rrm = $this->input->post('id_rrm');
                $data_queue = array(
                    'id_unit' => $dataUnit[0],
                    'id_riwayat_rm' => $id_rrm,
                    'FLAG_INTERN' => 1,
                    'waktu_antrian_unit' => $waktuantrian,
                    'sub_pustu' => $dataUnit[1]
                );
                $this->mdrughc->insert('antrian_unit', $data_queue);
                $this->_updateAntrian($form_data['hidden_noantrian']);
                redirect(base_url().$this->uri->segment(1, 0). '/kia/dataRiwayat/vkkia');
                break;
        }
    }

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

        $array['allStok'] = $this->mdrughc->getAllStok($idUnit);
        $array['notifMinStok']= $this->mdrughc->notificationMinStokPUSTU();
        $array['idUnit'] = $idUnit;
        $array['namaUnit'] = $namaUnit;
        $this->display('kia/acMonitoringStok', $array);
    }

    public function convert($date) {
        $mydate = date_create_from_format('d-m-Y', $date);
        return date_format($mydate, 'Y-m-d');
    }

    //function add resep pasien
    public function addResepPasien() {
        $id_akun= $this->session->userdata['telah_masuk']["idakun"];
        $idUnit= $this->session->userdata['telah_masuk']['idunit'];
        
        $penugasan= $this->mdrughc->getPenugasan($id_akun, $idUnit);
        $tanggalTransaksi= $this->convert($this->input->post('transaksi'));
        $tanggalRekapTransaksi= $this->convert($this->input->post('transaksi_now'));
        $listKode= json_decode($this->input->post('total_kodeObat'));
        $listJmlSehari = json_decode($this->input->post('total_jumlahSehari'));
        $listLamaHari = json_decode($this->input->post('total_lamaHari'));
        $listDeskObat = json_decode($this->input->post('total_deskripsiObat'));
        $listSigna= json_decode($this->input->post('total_signa'));
        $idRiwayatRM= $this->input->post('id_riwayat_rm');
        
        $jenisTransaksi= $this->input->post('jenis_transaksi');
            $param1= 'TRANSAKSI_UNIT_DARI';
            $param2= 'TRANSAKSI_UNIT_KE';
            
        $data = array(
            'ID_PENUGASAN' => $penugasan[0]['ID_PENUGASAN'],
            'ID_RIWAYAT_RM' => $idRiwayatRM,
            'ID_JENISTRANSAKSI' => $jenisTransaksi,
            'TANGGAL_TRANSAKSI' => $tanggalTransaksi,
            'TANGGAL_REKAP_TRANSAKSI' => $tanggalRekapTransaksi,
            $param1 => $this->input->post('dari'),    //unit
            $param2 => $this->input->post('ke'),   //unit
            'FLAG_KONFIRMASI' => $this->input->post('flag_konfirmasi')
        );
        $lastID= $this->mdrughc->insertAndGetLast('transaksi_obat', $data);
        
        for($i=0; $i<sizeof($listKode); $i++):
            $listJml = $listJmlSehari[$i] * $listLamaHari[$i];
            $data_obat= array(
                'ID_TRANSAKSI'=> $lastID,
                'ID_OBAT'=> $listKode[$i],
                'JUMLAH_OBAT'=> $listJml,
                'ID_UNIT'=> $idUnit
            );
            $lasIdDetail= $this->mdrughc->insertAndGetLast('detil_transaksi_obat', $data_obat);
            
            $data2 = array(
                'ID_RIWAYAT_RM' => $idRiwayatRM,
                'ID_AKUN' => $id_akun,
                'ID_DETIL_TO' => $lasIdDetail,
                'DESKRIPSI_OP' => $listDeskObat[$i],
                'JUMLAH_SEHARI' => $listJmlSehari[$i],
                'LAMA_HARI' => $listLamaHari[$i],
                'SIGNA'=>$listSigna[$i]
            );
            $this->mdrughc->insert('obat_pasien', $data2);
        endfor;
        
        redirect(base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/showTransResep/'.$lastID.'/'.$idRiwayatRM);
    }

    //function show transkrip resep pasien
    public function showTransResep($idTransaksi, $idRiwayatRm) {
        $queryTrans = $this->mdrughc->getSomeTransaksi($idTransaksi);
        $jenisTrans = $this->mdrughc->getSomeJenisTrans($queryTrans[0]['ID_JENISTRANSAKSI']);
        $rekamedik = $this->mkia->getRiwayatRMById($idRiwayatRm);

        $listNamObat = array();
        $listJmlObat = array();
        $listSatObat = array();
        $listJmlSehari = array();
        $listLamaHari = array();
        $listSigna = array();
        $listDeskObat = array();
        $queryDetailTrans = $this->mdrughc->getSomeDetailTrans($idTransaksi);
        for ($i = 0; $i < sizeof($queryDetailTrans); $i++):
            $getObat = $this->mdrughc->getSomeObat($queryDetailTrans[$i]['ID_OBAT']);
            array_push($listNamObat, $getObat[0]['NAMA_OBAT']);
            array_push($listJmlObat, $queryDetailTrans[$i]['JUMLAH_OBAT']);
            array_push($listSatObat, $getObat[0]['SATUAN']);
            $idDetilTo = $queryDetailTrans[$i]['ID_DETIL_TO'];
            $queryDetailObatPasien = $this->mkia->getSomeObatPasien($idDetilTo);
            array_push($listJmlSehari, $queryDetailObatPasien[0]['JUMLAH_SEHARI']);
            array_push($listLamaHari, $queryDetailObatPasien[0]['LAMA_HARI']);
            array_push($listDeskObat, $queryDetailObatPasien[0]['DESKRIPSI_OP']);
            array_push($listSigna, $queryDetailObatPasien[0]['SIGNA']);
        endfor;

        $array['namaPasien'] = $rekamedik[0]['NAMA_PASIEN'];
        $array['trans'] = $queryTrans;
        $array['jenisTrans'] = $jenisTrans;
        $array['detailTrans'] = $queryDetailTrans;
        $array['listNamObat'] = $listNamObat;
        $array['listJmlObat'] = $listJmlObat;
        $array['listSatObat'] = $listSatObat;
        $array['listJmlSehari'] = $listJmlSehari;
        $array['listLamaHari'] = $listLamaHari;
        $array['listDeskObat'] = $listDeskObat;
        $array['listSigna'] = $listSigna;
        $this->display('kia/acShowResultTransaksiResep', $array);
    }

    //function show riwayat pasien
    public function receipt($tipe, $param1 = null, $param2 = null) {
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];

        switch ($tipe) {
            case 'listPasien':
                $this->display('kia/acListPasien');
                break;
            case 'detailRiwayat':
                $array['namaPasien'] = $this->mkia->getTable('pasien', array('ID_PASIEN' => $param1));
                $url= $this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$this->uri->segment(4, 0).'/'.$this->uri->segment(5, 0);
                $perPage= 10;
                $total_rows= $this->mkia->getRiwayatResepCount($param1);
                $pagination= $this->init_pagination($url,$total_rows,$perPage,6);
                $array['riwayat'] = $this->mkia->getRiwayatResep($param1, $this->uri->segment(6, 0), $perPage);
                $array["links"] = $this->pagination->create_links();
                $tebusan = $this->mkia->getTebusanObat($param1); //need some fungsion to disable riwayat when flag=1
                for ($i = 0; $i < sizeof($tebusan); $i++) {
                    $flag_tebusan[$tebusan[$i]['ID_RIWAYAT_RM']] = $tebusan[$i]['ID_TRANSAKSI'];
                }
                if (isset($flag_tebusan))
                    $array['tebusan'] = $flag_tebusan;
                $array['idPasien'] = $param1;
                $this->display('kia/acListRiwayat', $array);
                break;
            case 'addResep':
                $array['namaPasien'] = $this->mkia->getTable('pasien', array('ID_PASIEN' => $param2));
                $jenisTrans = $this->mdrughc->getSomeJenisTrans(16); //Resep Obat Pasien
                $array['jenisTransId'] = $jenisTrans[0]['ID_JENISTRANSAKSI'];
                $array['jenisTransNama'] = $jenisTrans[0]['NAMA_JENIS'];
                $array['dari_id'] = $idUnit;
                $array['dari_nama'] = $namaUnit;
                $array['ke_id'] = $idUnit;
                $array['ke_nama'] = 'Apotik '.$namaUnit;
                $this->display('kia/acAddResep', $array);
                break;
        }
    }
    
    function removeDataAntrian () {
        $form_data = $this->input->post(null, true);		
        $this->db->trans_start();
        $this->mQueue->removeEntry ($form_data['id_antrian']);
        $this->mMRHistory->removeEntry ($form_data['id_rrm']);		
        $this->db->trans_complete();	
        if ($this->db->trans_status() === true) {
                echo json_encode($form_data);
        }
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

    function searchObat($idUnit) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');

        $teks = $data['tanda'];
        $temp1 = $this->mdrughc->getAllStok($idUnit, $teks);
        $data["submit"] = $this->getPivotObat($temp1);
        return $data["submit"];
    }

    private function getPivotObat($data) {
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
            $header .= ',"<button data-toggle=\"modal\" href=\"#myModal\" onclick=\"setObat(\'' . $value->ID_DETIL_TO . '\',\'' . $value->ID_OBAT . '\',\'' . $value->NOMOR_BATCH . '\',\'' . $value->NAMA_OBAT . '\',\'' . $value->STOK . '\',\'' . $value->SATUAN . '\',\'' . $value->EXPIRED_DATE . '\')\" class=\"btn btn-primary\">Pilih</button>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }
    
    function showResepPasien() {
        $id_unit = $this->session->userdata['telah_masuk']['idunit'];
        $data = $this->mMRHistory->getResepPasien($id_unit);
        echo $this->getResepPasien($data);
    }

    private function getResepPasien($data) {
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
            $header .= ",\"RIWAYAT RESEP\",\"BUAT RESEP\"";
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
            $header .= ',"<a type=\"button\" style=\"color: white\" href=\"' . base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/receipt/detailRiwayat/' . $value['id_pasien'] . '\" class=\"btn btn-warning\">Lihat</a>"';
            $header .= ',"<a type=\"button\" style=\"color: white\" href=\"' . base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/receipt/addResep/' . $value['id_riwayat_rm'] . '/' . $value['id_pasien'] . '\" class=\"btn btn-primary\">Buat Baru</a>"';
            $header .= "]";
        }
        $header .= "]";
        return $header;
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

}
