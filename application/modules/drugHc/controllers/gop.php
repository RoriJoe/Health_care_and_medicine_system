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
class Gop extends gopController {

    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('mdrughc');
        $this->load->model('kddrughc');
        $this->load->model('unit_model');
        $this->load->model('mDrugsTransaction');
        $this->load->model('mDrugsDetailTrans');
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
        redirect(base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/monitoringObat');
    }

    public function monitoringObat($tipe) {
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];

        switch ($tipe):
            case 'gop':
                $array['notifStok'] = $this->mdrughc->notificationStok();
                $array['notifMinStok']= $this->mdrughc->notificationMinStokGOP();
                $array['namaUnit'] = $namaUnit;
                $array['idUnit'] = $idUnit;
                $this->display('acMonitoringStok', $array);
                break;
            case 'allUnit':
                $array['allStok'] = $this->mdrughc->getAllStok($idUnit);
                $array['namaUnit'] = $namaUnit;
                $array['allUnit'] = $this->unit_model->getUnitForMonitoring();
                $this->display('acAllUnitMonitoring', $array);
                break;
        endswitch;
    }

    function searchMonitoringUnit() {
        $idUnit = $this->input->post('unit');
        $tanggal = $this->input->post('tanggal');
        $temp1 = $this->kddrughc->getAllStokBy($idUnit, $this->session->userdata['telah_masuk']['idgedung'], $tanggal);
        if ($temp1)
            echo $this->getPivotObat($temp1);
        else
            echo "[[\"NOMOR BATCH\",\"NAMA OBAT\", \"STOK OBAT TERAKHIR\", \"SATUAN\", \"EXPIRED DATE\"], [\"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\", \"Kosong\"]]";
    }

    /* request gudang obat puskesmas always in Gudang farmasi kabupaten */
    public function request() {
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];

        $ke = $this->mdrughc->getGFKData(2, 'Operator GFK');    //id gedung GFK, jenis unit operator gfk

        $jenisTrans = $this->mdrughc->getSomeJenisTrans(14); //PERMINTAAN Gudang PUSKEMAS ke OBAT GFK
        $array['jenisTransId'] = $jenisTrans[0]['ID_JENISTRANSAKSI'];
        $array['jenisTransNama'] = $jenisTrans[0]['NAMA_JENIS'];
        $array['dari_id'] = $idUnit;
        $array['dari_nama'] = $namaUnit;
        $array['ke_id'] = $ke[0]['ID_UNIT'];
        $array['ke_nama'] = $ke[0]['NAMA_UNIT'];
        $array['flag'] = 0;  //set 0 only for GFK
        $this->display('acRequestDrug', $array);
    }

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
        if ($jenisTransaksi != 15) {    //bukan Penerimaan Obat selain GFK
            $param1 = 'TRANSAKSI_UNIT_DARI';
            $param2 = 'TRANSAKSI_UNIT_KE';
        } else {
            $param1 = 'NAMA_TRANSAKSI_SUMBER_LAIN';
            $param2 = 'TRANSAKSI_UNIT_KE';
        }

        $flag_transaksi = NULL;
        if ($jenisTransaksi == 14) {    //Permintaan Gudang Obat ke GFK
            $flag_transaksi = $this->input->post('flag_transaksi');
        }
        $data = array(
            'ID_PENUGASAN' => $penugasan[0]['ID_PENUGASAN'],
            'ID_JENISTRANSAKSI' => $jenisTransaksi,
            'TANGGAL_TRANSAKSI' => $tanggalTransaksi,
            'TANGGAL_REKAP_TRANSAKSI' => $tanggalRekapTransaksi,
            $param1 => $this->input->post('dari'), //unit
            $param2 => $this->input->post('ke'), //unit
            'FLAG_TRANSAKSI' => $flag_transaksi,
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

        if ($jenisTransaksi == 15) {   //Penerimaan Obat selain GFK
            $listExpired = json_decode($this->input->post('total_expired'));
            $listAnggaran = json_decode($this->input->post('total_anggaran'));
        }
        for ($i = 0; $i < sizeof($listKode); $i++):
            if ($jenisTransaksi == 18) {        //Penerimaan Gudang Obat dari GFK
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit GFK
                $this->mdrughc->penambahanStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if ($jenisTransaksi == 15) {   //Penerimaan Obat selain GFK
                $this->mdrughc->penambahanStok($lastID, $listKode[$i], $listJml[$i], $this->convert($listExpired[$i]), $listBatch[$i], $idUnit, $listAnggaran[$i]);
            }
            else if ($jenisTransaksi == 24) {   //Penerimaan Retur Gudang Obat dari Unit
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit Unit
                $this->mdrughc->penambahanStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if ($jenisTransaksi == 3) {    //Pengiriman Gudang Obat ke Apotik
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit GOP
                $this->mdrughc->penguranganStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if ($jenisTransaksi == 4) {    //Pengiriman Gudang Obat ke Layanan / Unit
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit GOP
                $this->mdrughc->penguranganStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if ($jenisTransaksi == 5) {    //Pengiriman Gudang Obat ke Pustu
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit GOP
                $this->mdrughc->penguranganStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if ($jenisTransaksi == 23) {    //Retur Obat Gudang Obat ke GFK
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit GOP
                $this->mdrughc->penguranganStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if ($jenisTransaksi == 27) {    //Pembuangan Obat oleh GOP
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit GOP
                $this->mdrughc->penguranganStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if ($jenisTransaksi == 14) {   //Permintaan Gudang Obat ke GFK
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('ke'), $listBatch[$i], $listKode[$i]);  //idUnit GFK
                $this->mdrughc->permintaanStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
        endfor;

        redirect(base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/showTrans/' . $lastID);
    }

    public function transPermintaan() {
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];

        $penugasan = $this->mdrughc->getPenugasan($id_akun, $idUnit);
        $tanggalTransaksi = $this->convert($this->input->post('transaksi'));
        $tanggalRekapTransaksi = $this->convert($this->input->post('transaksi_now'));
        $listKode = json_decode($this->input->post('total_kodeObat'));
        $listJml = json_decode($this->input->post('total_jumlahObat'));
        $jenisTransaksi = $this->input->post('jenis_transaksi');
        $param1 = 'TRANSAKSI_UNIT_DARI';
        $param2 = 'TRANSAKSI_UNIT_KE';

        $flag_transaksi = NULL;
        if ($jenisTransaksi == 14) {    //Permintaan Gudang Obat ke GFK
            $flag_transaksi = $this->input->post('flag_transaksi');
        }
        $data = array(
            'ID_PENUGASAN' => $penugasan[0]['ID_PENUGASAN'],
            'ID_JENISTRANSAKSI' => $jenisTransaksi,
            'TANGGAL_TRANSAKSI' => $tanggalTransaksi,
            'TANGGAL_REKAP_TRANSAKSI' => $tanggalRekapTransaksi,
            $param1 => $this->input->post('dari'), //unit
            $param2 => $this->input->post('ke'), //unit
            'FLAG_TRANSAKSI' => $flag_transaksi,
            'FLAG_KONFIRMASI' => $this->input->post('flag_konfirmasi'),
            'ID_RUJUKAN_KONFIRMASI' => $this->input->post('id_rujukan')
        );
        $lastID = $this->mdrughc->insertAndGetLast('transaksi_obat', $data);

        for ($i = 0; $i < sizeof($listKode); $i++):
            $data_obat = array(
                'ID_TRANSAKSI' => $lastID,
                'ID_OBAT' => $listKode[$i],
                'JUMLAH_OBAT' => $listJml[$i],
                'ID_UNIT' => $idUnit
            );
            $this->mdrughc->insert('detil_transaksi_obat', $data_obat);
        endfor;

        redirect(base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/showTransPermintaan/' . $lastID);
    }

    public function showTransPermintaan($idTransaksi) {
        $queryTrans = $this->mdrughc->getSomeTransaksi($idTransaksi);
        $jenisTrans = $this->mdrughc->getSomeJenisTrans($queryTrans[0]['ID_JENISTRANSAKSI']);
        $param = array('ID_UNIT' => $queryTrans[0]['TRANSAKSI_UNIT_DARI']);
        $temp = $this->mdrughc->getUnit($param);
        $dari = $temp[0]['NAMA_UNIT'];
        $param = array('ID_UNIT' => $queryTrans[0]['TRANSAKSI_UNIT_KE']);
        $temp = $this->mdrughc->getUnit($param);
        $ke = $temp[0]['NAMA_UNIT'];

        $queryDetailTrans = $this->mdrughc->getSomeDetailTrans($idTransaksi);
        $listNamObat = array();
        $listJmlObat = array();
        $listSatObat = array();
        for ($i = 0; $i < sizeof($queryDetailTrans); $i++):
            $getObat = $this->mdrughc->getSomeObat($queryDetailTrans[$i]['ID_OBAT']);
            array_push($listNamObat, $getObat[0]['NAMA_OBAT']);
            array_push($listJmlObat, $queryDetailTrans[$i]['JUMLAH_OBAT']);
            array_push($listSatObat, $getObat[0]['SATUAN']);
        endfor;

        $array['trans'] = $queryTrans;
        $array['jenisTrans'] = $jenisTrans;
        $array['dari'] = $dari;
        $array['ke'] = $ke;
        $array['detailTrans'] = $queryDetailTrans;
        $array['listNamObat'] = $listNamObat;
        $array['listJmlObat'] = $listJmlObat;
        $array['listSatObat'] = $listSatObat;
        $this->display('acShowResultTransaksiPermintaan', $array);
    }

    public function showTrans($idTransaksi) {
        $queryTrans = $this->mdrughc->getSomeTransaksi($idTransaksi);
        $jenisTrans = $this->mdrughc->getSomeJenisTrans($queryTrans[0]['ID_JENISTRANSAKSI']);
        $ke='';
        if ($jenisTrans[0]['ID_JENISTRANSAKSI'] != 15) {    //bukan Penerimaan Obat selain GFK
            $param = array('ID_UNIT' => $queryTrans[0]['TRANSAKSI_UNIT_DARI']);
            $temp = $this->mdrughc->getUnit($param);
            $dari = $temp[0]['NAMA_UNIT'];
            $param = array('ID_UNIT' => $queryTrans[0]['TRANSAKSI_UNIT_KE']);
            $temp = $this->mdrughc->getUnit($param);
            if($jenisTrans[0]['ID_JENISTRANSAKSI']!=27) $ke = $temp[0]['NAMA_UNIT'];
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

    public function obatKeluar($tipe, $idTransaksi = null, $idUnitParam = 0) {
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];

        switch ($tipe):
            case 'permintaan_apotik':
                $array['permintaan'] = $this->mdrughc->getSomeTransaksiParam(array(
                    'ID_JENISTRANSAKSI' => 13,
                    'FLAG_KONFIRMASI' => 0,
                    'TRANSAKSI_UNIT_KE' => $idUnit));    //permintaan apotik ke gudang obat
                $listPermintaan = $array['permintaan'];
                for ($i = 0; $i < sizeof($array['permintaan']); $i++) {
                    $ress[$i] = $this->mdrughc->getSomeTransaksiParam(array('ID_RUJUKAN_KONFIRMASI' => $listPermintaan[$i]['ID_TRANSAKSI']));
                }
                if (isset($ress))
                    $array['flag'] = $ress;
                $jenisTrans1 = $this->mdrughc->getSomeJenisTrans(13);    //permintaan apotik ke gudang obat
                $array['jenisTransNama1'] = $jenisTrans1[0]['NAMA_JENIS'];
                $this->display('acListRequest', $array);
                break;
            case 'permintaan_poli':
                $array['permintaan'] = $this->mdrughc->getSomeTransaksiParam(array(
                    'ID_JENISTRANSAKSI' => 11,
                    'FLAG_KONFIRMASI' => 0,
                    'TRANSAKSI_UNIT_KE' => $idUnit));    //Permintaan Unit / Layanan ke Gudang Obat
                $listPermintaan = $array['permintaan'];
                for ($i = 0; $i < sizeof($array['permintaan']); $i++) {
                    $unit[$i] = $this->mdrughc->getUnit(array('ID_UNIT' => $listPermintaan[$i]['TRANSAKSI_UNIT_DARI']));
                    $ress[$i] = $this->mdrughc->getSomeTransaksiParam(array('ID_RUJUKAN_KONFIRMASI' => $listPermintaan[$i]['ID_TRANSAKSI']));
                }
                if (isset($unit))
                    $array['unit'] = $unit;
                if (isset($ress))
                    $array['flag'] = $ress;
                $jenisTrans1 = $this->mdrughc->getSomeJenisTrans(11);    //Permintaan Unit / Layanan ke Gudang Obat
                $array['jenisTransNama1'] = $jenisTrans1[0]['NAMA_JENIS'];
                $this->display('acListRequest', $array);
                break;
            case 'permintaan_pustu':
                $array['permintaan'] = $this->mdrughc->getSomeTransaksiParam(array(
                    'ID_JENISTRANSAKSI' => 12,
                    'FLAG_KONFIRMASI' => 0,
                    'TRANSAKSI_UNIT_KE' => $idUnit));    //Permintaan Pustu ke Gudang Obat
                $listPermintaan = $array['permintaan'];
                for ($i = 0; $i < sizeof($array['permintaan']); $i++) {
                    $unit[$i] = $this->mdrughc->getUnit(array('ID_UNIT' => $listPermintaan[$i]['TRANSAKSI_UNIT_DARI']));
                    $ress[$i] = $this->mdrughc->getSomeTransaksiParam(array('ID_RUJUKAN_KONFIRMASI' => $listPermintaan[$i]['ID_TRANSAKSI']));
                }
                if (isset($unit))
                    $array['unit'] = $unit;
                if (isset($ress))
                    $array['flag'] = $ress;
                $jenisTrans1 = $this->mdrughc->getSomeJenisTrans(12);    //permintaan apotik ke gudang obat
                $array['jenisTransNama1'] = $jenisTrans1[0]['NAMA_JENIS'];
                $this->display('acListRequest', $array);
                break;
            case 'detail_apotik':
                $this->drugsOutHC($this->mdrughc->getSomeJenisTrans(3));
                break;
            case 'detail_poli':
                $this->drugsOutHC($this->mdrughc->getSomeJenisTrans(4));
                break;
            case 'detail_pustu':
                $this->drugsOutHC($this->mdrughc->getSomeJenisTrans(5));
                break;
            case 'newApotik':
                $this->drugsOut('apo', $this->mdrughc->getSomeJenisTrans(3));
                break;
            case 'newPoli':
                $this->drugsOut('unit', $this->mdrughc->getSomeJenisTrans(4));
                break;
            case 'newPustu':
                $this->drugsOut('pustu', $this->mdrughc->getSomeJenisTrans(5));
                break;
            case 'retur':
                $ke = $this->mdrughc->getGFKData(2, 'Operator GFK');    //id gedung GFK, jenis unit operator gfk
                $jenisTrans = $this->mdrughc->getSomeJenisTrans(23); //Retur Obat Gudang Obat ke GFK
                $array['jenisTransId'] = $jenisTrans[0]['ID_JENISTRANSAKSI'];
                $array['jenisTransNama'] = $jenisTrans[0]['NAMA_JENIS'];
                $array['dari_id'] = $idUnit;
                $array['dari_nama'] = $namaUnit;
                $array['ke_id'] = $ke[0]['ID_UNIT'];
                $array['ke_nama'] = $ke[0]['NAMA_UNIT'];
                $this->display('acReturObat', $array);
                break;
            case 'buang':
                $jenisTrans = $this->mdrughc->getSomeJenisTrans(27); //Pembuangan Obat oleh GOP
                $array['jenisTransId'] = $jenisTrans[0]['ID_JENISTRANSAKSI'];
                $array['jenisTransNama'] = $jenisTrans[0]['NAMA_JENIS'];
                $array['dari_id'] = $idUnit;
                $array['dari_nama'] = $namaUnit;
                $this->display('acBuangObat', $array);
                break;
        endswitch;
    }

    /* start dynamic transaksi pengiriman */
    /* obat keluar dari permintaan */
    function drugsOutHC($jenisTrans) {
        $data['error_msg'] = $this->session->flashdata('error');
        $data['notifStok'] = $this->mdrughc->notificationStok();
        $data['allRequest'] = $this->mDrugsTransaction->getPendingRequest();
        $data['jenisTrans'] = $jenisTrans;
        $this->display('drugs_out_hc', $data);
    }

    function showDetailRequest() {
        $id = $this->input->post('id');
        $result = $this->mDrugsDetailTrans->getEntryById($id);
        if ($result != null)
            echo json_encode($result);
        else
            echo "Kosong";
    }

    public function addDrugsOutHC($idJenisTrans) {
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $penugasan = $this->mdrughc->getPenugasan($id_akun, $idUnit);
        $form_data = $this->input->post(null, true);
        $dateConverted = $this->convert($form_data['inputTransaksi']);
        $data = array(
            'id_penugasan' => $penugasan[0]['ID_PENUGASAN'],
            'id_jenistransaksi' => $idJenisTrans,
            'tanggal_transaksi' => $dateConverted,
            'tanggal_rekap_transaksi' => date('Y-m-d'),
            'transaksi_unit_ke' => $form_data['inputUnit'],
            'transaksi_unit_dari' => $this->session->userdata['telah_masuk']['idunit'],
            'flag_konfirmasi' => 0,
            'id_rujukan_konfirmasi' => $form_data['inputIdTransaksi']
        );
        $this->mDrugsTransaction->updateEntry($form_data['inputIdTransaksi'], array('flag_konfirmasi' => (string) 1));

        // cari detail per batch
        $idObatInput = $this->input->post('idObat');
        $jmlObatInput = $this->input->post('jmlObat');
        $idObat = explode(",", $idObatInput);
        $jmlObat = explode(",", $jmlObatInput);
        $data_detail;
        for ($i = 0; $i < sizeof($idObat); $i++) {
            $detailObat = $this->mdrughc->getAllDetailEntry($idObat[$i]);
            $jmlObatTotal = $jmlObat[$i];

            $counter = 0;
            $tanda = false;
            foreach ($detailObat as $do) {
                $counter += $do['STOK_OBAT_SEKARANG'];
                if ($counter >= $jmlObatTotal) {
                    $sisa = $counter - $jmlObatTotal;
                    $ygDiambil = $do['STOK_OBAT_SEKARANG'] - $sisa;
                    $do['STOK_OBAT_SEKARANG'] = $ygDiambil;
                    $tanda = true;
                }

                $data_detail[] = $do;
                if ($tanda)
                    break;
            }
        }

        $lastIDTrans = $this->mDrugsTransaction->insertNewEntryMinus($data, $data_detail);
        redirect(base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/showTrans/' . $lastIDTrans);
    }
    /* end obat keluar dari permintaan */
    /* obat keluar langsung */

    function drugsOut($tipe, $jenisTrans) {
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $this->session->set_userdata('drugsOut_added_detail', null);
        $data['error_msg'] = $this->session->flashdata('error');
        $data['notifStok'] = $this->mdrughc->notificationStok();
        $data['jenisTrans'] = $jenisTrans;
        if ($tipe == 'unit') {
            $data['allUnit'] = $this->mdrughc->getUnitFilter($idGedung);   //get id all unit except Apotik
        } else if ($tipe == 'pustu') {
            $data['allUnit'] = $this->mdrughc->getDataLengkapPenugasan(21, $idGedung);    //get id pustu  //banyak PUSTU
        } else if ($tipe == 'apo') {
            $data['allUnit'] = $this->mdrughc->getDataLengkapPenugasan(3, $idGedung);    //get id Apotik
        }

        $data['allStocks'] = $this->mdrughc->getObatRemain();
        $this->display('drugs_out', $data);
    }

    function showAllDrugsGOPOut() {
        $temp1 = $this->mdrughc->getAllEntry();
        echo $this->getPivotOK($temp1);
    }

    private function getPivotOK($data) {
        $header = "[[";
        foreach ($data as $value) {
            $header .= '"NOMOR"';
            foreach ($value as $key => $sembarang) {
                $header .= ',"' . $this->renameHeader($key) . '"';
            }
            $header .= ",\"PILIH\"";
            $header .= "]";
            break;
        }

        // get value
        $counter = 1;
        foreach ($data as $value) {
            $header .= ",[";
            $header .= '"' . $counter . '"';
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                $header .= ',"' . $data . '"';
            }
            $header .= ',"<a style=\"color: white\" type=\"button\" data-toggle=\"modal\" href=\"#addStocksModal\" class=\"btn btn-xs btn-success\" onclick=\"toAddStocksModal(\'' . $value['ID_OBAT'] . '\',\'' . $this->replaceString($value['NAMA_OBAT']) . '\',\'' . $value['TOTAL'] . '\')\"><i class=\"fa fa-check\"></i></a>"';
            $header .= "]";
            $counter++;
        }
        $header .= "]";
        return $header;
    }

    private function renameHeader($headerName) {
        $headerName = str_replace("_", " ", strtoupper($headerName));
        switch ($headerName) {
            case "STOK OBAT SEKARANG":
                $headerName = "STOK SAAT INI";
                break;
            case "EXPIRED DATE":
                $headerName = "TANGGAL KADALUARSA";
                break;
            case "NAMA SUMBER ANGGARAN OBAT":
                $headerName = "SUMBER ANGGARAN";
                break;
            case "KODE OBAT":
                $headerName = "NOMOR LPLPO";
                break;

            default:
                break;
        }
        return $headerName;
    }

    public function removeDrugsDetailOK() {
        $form_data = $this->input->post(null, true);
        $haystack = $this->session->userdata('drugsOut_added_detail');

        if ($haystack) {
            for ($i = 0; $i < count($haystack); $i++) {
                if (in_array($form_data['id_obat'], $haystack[$i], true) && in_array($form_data['nomor_batch'], $haystack[$i], true)) {
                    unset($haystack[$i]);
                    $this->session->set_userdata('drugsOut_added_detail', $haystack);
                    break;
                }
            }
        }
    }

    public function addDrugsDetailOK() {
        $form_data = $this->input->post(null, true);
        $idObat = $form_data['inputObat'];
        $detailObat = $this->mdrughc->getAllDetailEntry($idObat);
        $jmlObatTotal = $form_data['inputJumlah'];
        $data_detail;
        $counter = 0;
        $tanda = false;
        foreach ($detailObat as $detail) {
            $counter += $detail['STOK_OBAT_SEKARANG'];
            if ($counter >= $jmlObatTotal) {
                $sisa = $counter - $jmlObatTotal;
                $ygDiambil = $detail['STOK_OBAT_SEKARANG'] - $sisa;
                $detail['STOK_OBAT_SEKARANG'] = $ygDiambil;
                $tanda = true;
            }
            $data_detail[] = $detail;
            if ($tanda)
                break;
        }
        $haystack = $this->session->userdata('drugsOut_added_detail');
        $haystack_baru;
        if ($haystack) {
            foreach ($haystack as $key => $value) {
                if ($idObat != $value['ID_OBAT']) {
                    $haystack_baru[] = $value;
                }
            }
        }
        for ($i = 0; $i < count($data_detail); $i++) {
            $haystack_baru[] = $data_detail[$i];
        }
        $this->session->set_userdata('drugsOut_added_detail', $haystack_baru);
        echo json_encode($this->session->userdata('drugsOut_added_detail'));
    }

    public function addDrugsOut($idJenisTrans) {
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $penugasan = $this->mdrughc->getPenugasan($id_akun, $idUnit);
        $form_data = $this->input->post(null, true);

        date_default_timezone_set("Asia/Jakarta");
        $dateConverted = $this->convert($form_data['inputTransaksi']);
        $data = array(
            'id_penugasan' => $penugasan[0]['ID_PENUGASAN'],
            'id_jenistransaksi' => $idJenisTrans,
            'tanggal_transaksi' => $dateConverted,
            'tanggal_rekap_transaksi' => date('Y-m-d'),
            'transaksi_unit_ke' => $form_data['inputPuskesmas'],
            'transaksi_unit_dari' => $this->session->userdata['telah_masuk']['idunit'],
            'flag_konfirmasi' => 0
        );

        $this->session->set_userdata('idunittujuan', $form_data['inputPuskesmas']);
        $lastIDTrans = $this->mDrugsTransaction->insertNewEntryMinus($data, $this->session->userdata('drugsOut_added_detail'));

        $this->session->set_userdata('drugsOut_added_detail', null);
        $this->session->set_userdata('idunittujuan', null);
        redirect(base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/showTrans/' . $lastIDTrans);
    }

    /* end obat keluar langsung */
    /* end transaksi pengiriman */

    public function obatMasuk($tipe = null, $idTransaksi = null, $idUnitParam = null) {
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];

        switch ($tipe):
            case 'penambahan':
                $jenisTrans = $this->mdrughc->getSomeJenisTrans(15); //Penerimaan Obat selain GFK
                $array['anggaran'] = $this->mdrughc->getTable('sumber_anggaran_obat');
                $array['jenisLokasi'] = 'nogfk-gedung';
                $array['jenisTransId'] = $jenisTrans[0]['ID_JENISTRANSAKSI'];
                $array['jenisTransNama'] = $jenisTrans[0]['NAMA_JENIS'];
                $array['ke_id'] = $idUnit;
                $array['ke_nama'] = $namaUnit;
                $this->display('acGiftDrugNotGFK', $array);
                break;
            case 'dariGfk':
                $array['pengiriman'] = $this->mdrughc->getSomeTransaksiParam(array(
                    'ID_JENISTRANSAKSI' => 2,
                    'TRANSAKSI_UNIT_KE' => $idUnit,
                    'FLAG_KONFIRMASI' => 0
                ));    //Pengiriman GFK ke Gudang Obat
                $listPengiriman = $array['pengiriman'];
                for ($i = 0; $i < sizeof($listPengiriman); $i++) {
                    $unit[$i] = $this->mdrughc->getUnit(array('ID_UNIT' => $listPengiriman[$i]['TRANSAKSI_UNIT_DARI']));
                    $ress[$i] = $this->mdrughc->getSomeTransaksiParam(array('ID_RUJUKAN_KONFIRMASI' => $listPengiriman[$i]['ID_TRANSAKSI']));
                }
                if (isset($unit))
                    $array['unit'] = $unit;
                if (isset($ress))
                    $array['flag'] = $ress;
                $jenisTrans1 = $this->mdrughc->getSomeJenisTrans(2);    //Pengiriman GFK ke Gudang Obat
                $array['jenisTransNama1'] = $jenisTrans1[0]['NAMA_JENIS'];
                $this->display('acGiftList', $array);
                break;
            case 'detail':
                $ke = $this->mdrughc->getUnit(array('ID_UNIT' => $idUnitParam));
                $array['trans'] = $this->mdrughc->getSomeTransaksiParam(array('ID_TRANSAKSI' => $idTransaksi));
                $array['detTrans'] = $this->mdrughc->getDetailTransObat($idTransaksi);
                $jenisTrans = $this->mdrughc->getSomeJenisTrans(18); //Penerimaan Gudang Obat dari GFK
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
            case 'returUnit':
                $array['pengiriman'] = $this->mdrughc->getSomeTransaksiParam(array(
                    'ID_JENISTRANSAKSI' => 22,
                    'TRANSAKSI_UNIT_KE' => $idUnit,
                    'FLAG_KONFIRMASI' => 0
                ));    //Retur Obat Unit ke Gudang Obat
                $listPengiriman = $array['pengiriman'];
                for ($i = 0; $i < sizeof($listPengiriman); $i++) {
                    $unit[$i] = $this->mdrughc->getUnit(array('ID_UNIT' => $listPengiriman[$i]['TRANSAKSI_UNIT_DARI']));
                    $ress[$i] = $this->mdrughc->getSomeTransaksiParam(array('ID_RUJUKAN_KONFIRMASI' => $listPengiriman[$i]['ID_TRANSAKSI']));
                }
                if (isset($unit))
                    $array['unit'] = $unit;
                if (isset($ress))
                    $array['flag'] = $ress;
                $jenisTrans1 = $this->mdrughc->getSomeJenisTrans(22);    //Pengiriman GFK ke Gudang Obat
                $array['jenisTransNama1'] = $jenisTrans1[0]['NAMA_JENIS'];
                $this->display('acReturList', $array);
                break;
            case 'retur':
                $ke = $this->mdrughc->getUnit(array('ID_UNIT' => $idUnitParam));
                $array['trans'] = $this->mdrughc->getSomeTransaksiParam(array('ID_TRANSAKSI' => $idTransaksi));
                $array['detTrans'] = $this->mdrughc->getDetailTransObat($idTransaksi);
                $jenisTrans = $this->mdrughc->getSomeJenisTrans(24); //Penerimaan Retur Gudang Obat dari Unit
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

    public function riwayatObat($tipe, $startRow = 0) {
        $this->title = "";
        $id_hakakses = $this->session->userdata['telah_masuk']["idha"];
        $id_akun = $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses = $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit = $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung = $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung = $this->session->userdata['telah_masuk']['namagedung'];
        switch ($tipe):
            case 'masuk':
                $array['jenisTransNama'] = 'Riwayat Obat Masuk';
                $url = $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/' . $this->uri->segment(3, 0) . '/' . $this->uri->segment(4, 0);
                $perPage = 10;
                $total_rows = $this->mdrughc->getRiwayatObatMasukCount($id_hakakses);
                $pagination = $this->init_pagination($url, $total_rows, $perPage, 5);
                $array['dataTrans'] = $this->mdrughc->getRiwayatObatMasuk($id_hakakses, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('riwayatObat', $array);
                break;
            case 'keluar':
                $array['jenisTransNama'] = 'Riwayat Obat Keluar';
                $url = $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/' . $this->uri->segment(3, 0) . '/' . $this->uri->segment(4, 0);
                $perPage = 10;
                $total_rows = $this->mdrughc->getRiwayatObatKeluarCount($id_hakakses);
                $pagination = $this->init_pagination($url, $total_rows, $perPage, 5);
                $array['dataTrans'] = $this->mdrughc->getRiwayatObatKeluar($id_hakakses, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('riwayatObat', $array);
                break;
            case 'minta':
                $array['jenisTransNama'] = 'Riwayat Obat Minta';
                $url = $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/' . $this->uri->segment(3, 0) . '/' . $this->uri->segment(4, 0);
                $perPage = 10;
                $total_rows = $this->mdrughc->getRiwayatObatMintaCount($id_hakakses);
                $pagination = $this->init_pagination($url, $total_rows, $perPage, 5);
                $array['dataTrans'] = $this->mdrughc->getRiwayatObatMinta($id_hakakses, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('riwayatObat', $array);
                break;
            case 'retur':
                $array['jenisTransNama'] = 'Riwayat Retur Obat ke GFK';
                $url = $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/' . $this->uri->segment(3, 0) . '/' . $this->uri->segment(4, 0);
                $perPage = 10;
                $total_rows = $this->mdrughc->getRiwayatReturObatCount($idUnit);
                $pagination = $this->init_pagination($url, $total_rows, $perPage, 5);
                $array['dataTrans'] = $this->mdrughc->getRiwayatReturObat($idUnit, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('riwayatObat', $array);
                break;
            case 'returMasuk':
                $array['jenisTransNama'] = 'Riwayat Penerimaan Retur Obat dari Unit';
                $url = $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/' . $this->uri->segment(3, 0) . '/' . $this->uri->segment(4, 0);
                $perPage = 10;
                $total_rows = $this->mdrughc->getRiwayatReturObatMasukCount($idUnit);
                $pagination = $this->init_pagination($url, $total_rows, $perPage, 5);
                $array['dataTrans'] = $this->mdrughc->getRiwayatReturMasukObat($idUnit, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('riwayatObat', $array);
                break;
        endswitch;
    }

    public function init_pagination($url, $total_rows, $per_page, $segment) {
        $config['base_url'] = base_url() . $url;
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

    function searchObat($idUnit) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');

        $teks = $data['tanda'];
        $temp1 = $this->mdrughc->getAllStok($idUnit, $teks);
        $data["submit"] = $this->getPivot($temp1);
        return $data["submit"];
    }

    function clean($string) {
        return preg_replace('/[^A-Za-z0-9\-@ .,]/', '-', $string); // Removes special chars.
    }

    private function replaceString($input) {
        $output = str_replace("\"", "\\\"", $input);
        $output = str_replace("\'", "\\\'", $output);
        return $output;
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
            $header .= '"' . $counter . '"';
            $counter++;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                $header .= ',"' . $data . '"';
            }
            $header .= ',"<button data-toggle=\"modal\" href=\"#myModal\" onclick=\"setObat(\'' . $value->ID_DETIL_TO . '\',\'' . $value->ID_OBAT . '\',\'' . $value->NOMOR_BATCH . '\',\'' . $this->replaceString($value->NAMA_OBAT) . '\',\'' . $value->STOK . '\',\'' . $value->SATUAN . '\',\'' . $value->EXPIRED_DATE . '\')\" class=\"btn btn-primary\">Pilih</button>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }

    function searchObatMaster() {
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');

        $teks = $data['tanda'];
        $temp1 = $this->mdrughc->getSomeObatComplexParam($teks);
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
            $header .= '"' . $counter . '"';
            $counter++;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                $header .= ',"' . $data . '"';
            }
            $header .= ',"<button data-toggle=\"modal\" href=\"#myModal\" onclick=\"setObat(\'' . $value->ID_OBAT . '\',\'' . $this->replaceString($value->NAMA_OBAT) . '\',\'' . $value->SATUAN . '\')\" class=\"btn btn-primary\">Pilih</button>"';
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }

    function checkBatchObat() {
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');

        $idUnit = $this->session->userdata['telah_masuk']['idunit'];
        $teks = $data['tanda'];
        $temp1 = $this->mdrughc->getAllStokForCheckBatch($idUnit, $teks);
        if (!empty($temp1))
            $nomorBatch = $temp1[0]['NOMOR_BATCH'];
        else
            $nomorBatch = 'false';
        $return["NOMOR_BATCH"] = $nomorBatch;
        $return["json"] = json_encode($return);
        echo json_encode($return);
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
            $header .= "]";
            break;
        }
        $vartemp = "";
        foreach ($data as $value) {
            $header .= ",[";
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                $header .= '"' . $data . '"';
                break;
            }
            $count = 1;
            foreach ($value as $key => $data) {
                $data = $this->clean($data);
                if ($count > 1) {
                    $header .= ',"' . $data . '"';
                }
                $count ++;
            }
            $header .= "]";
        }
        $header .= "]";
        echo $header;
    }

    public function convert($date) {
        $mydate = date_create_from_format('d-m-Y', $date);
        return date_format($mydate, 'Y-m-d');
    }

}
