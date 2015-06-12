<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pu extends oppusController {

    private $home;

    public function __construct() {
        parent::__construct();
        $this->home = base_url() . $this->uri->segment(1) . '/pu/';
        $this->load->model('mDrugsNow');
        $this->load->model('mHServices');
        $this->load->model('mAction');
        $this->load->model('mLabCheck');
        $this->load->model('mdrughc');
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
        $this->top_navbar = 'lay-top-navbar/oppusNavbar_pu';
    }

    function updateAllEntryRRM() {
        $data = $this->input->post(null, true);
        $id_rrm = $data['id_rrm'];
        unset($data['id_rrm']);

        $this->mMRHistory->updateEntry($data, $id_rrm);
        redirect($this->home);
    }

    public function index() {
        redirect($this->home . 'queue');
    }

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
            "queues" => $this->mQueue->getAllByUnit($this->session->userdata['telah_masuk']['idunit'], $this->uri->segment(2, 0)),
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
        $this->display('pu/stockPoly');
    }

    // home
    public function queue() {
        $data = $this->_getFormFill();
        $data['idUnit']= $this->session->userdata['telah_masuk']['idunit'];
        $this->display('pu/home', $data);
    }

    public function patient() {
        $this->display('pu/patient');
    }

    public function profileMRH() {
        $id = $this->uri->segment(4, 0);

        $data['idrrm'] = $id;
        $data['profil'] = $this->mMRHistory->getProfilMRH($id);
        $data['riwayat_rm'] = $this->mMRHistory->getMRHById($id);
        $data['tindakan'] = $this->mHServices->getEntryById($id);
        $data['laborat'] = $this->mLabCheck->getEntryById($id);
        $data['icd'] = $this->mDiagnosis->getEntryById($id);
        $this->display('pu/mrhProfile', $data);
    }

    public function patientMRH() {
        $id = $this->uri->segment(4, 0);
        // Perubahan !!!
        // idrrm to id_rm
        $data['id_rm'] = $id;
        $data['data_rrm'] = $this->mMRHistory->getMRHByIdMR($id, 100);
        $this->display('pu/allMedRecord', $data);
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

    public function getLabResult() {
        $idRMHistory = $this->input->post('id');
        $result = $this->mLabCheck->getEntryById($idRMHistory);
        if ($result)
            echo json_encode($result);
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
            'beratbadan_pasien' => (isset($form_data['berat'])) ? $form_data['berat'] : null,
            'tinggibadan_pasien' => (isset($form_data['tinggi'])) ? $form_data['tinggi'] : null,
            'sistol_pasien' => (isset($form_data['sistol'])) ? $form_data['sistol'] : null,
            'diastol_pasien' => (isset($form_data['diastol'])) ? $form_data['diastol'] : null,
            'suhu_badan' => (isset($form_data['suhu'])) ? $form_data['suhu'] : null,
            'napas_per_menit' => (isset($form_data['napas'])) ? $form_data['napas'] : null,
            'detak_jantung' => (isset($form_data['jantung'])) ? $form_data['jantung'] : null,
            'stat_rawat_jalan' => (isset($form_data['rawat'])) ? $form_data['rawat'] : null,
            'tempat_rujukan' => (isset($form_data['rujuk'])) ? $form_data['rujuk'] : null,
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
        $idunit = $form_data['unit3'];
        $dataUnit= explode("_",$idunit);
        $idsumber = $this->input->post('pembayaranPasien');
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

    public function updateRMHistory() {

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
                redirect($this->home);
                break;
            case 2:
                // simpan dan buat resep
                $this->_simpanRiwayat($form_data);
                $id_rrm = $form_data['id_rrm'];
                $a_patient = $this->mPatient->getEntryByRRM($id_rrm);
                $idpasien = $a_patient['id_pasien'];
                redirect(base_url() . $this->uri->segment(1) . '/kia/receipt/addResep/' . $id_rrm . '/' . $idpasien);
                break;
            case 3:
                // simpan dan arahkan ke poli lain
                $this->_simpanRiwayat($form_data);
                $this->_masukAntrianPoliLain($form_data);
                redirect($this->home);
                break;
            case 4:
                // arahkan ke poli lain
                $s = $this->input->post('tanggalAntrian2').' '.$this->input->post('waktuAntrian2');
                $date = strtotime($s);
                $waktuantrian = date('Y-m-d H:i:s', $date);
                
                $idunit = $this->input->post('unit4');
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
                redirect($this->home);
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

    function toLaborat() {
        $this->display('pu/laboratorium');
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
}
