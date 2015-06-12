<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

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
class Oppus extends oppusController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->load->model('mdrughc');
        
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
    public function antrian(){
        $this->title="";
        $id_hakakses= $this->session->userdata['telah_masuk']["idha"];
        $id_akun= $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses= $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit= $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit= $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung= $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung= $this->session->userdata['telah_masuk']['namagedung'];
        
        $this->display('antrianPasien');
    }
    
    public function monitoringObat()
    {
        $this->title="";
        $id_hakakses= $this->session->userdata['telah_masuk']["idha"];
        $id_akun= $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses= $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit= $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit= $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung= $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung= $this->session->userdata['telah_masuk']['namagedung'];
        
        $array['allStok']= $this->mdrughc->getAllStok($idUnit);
        $array['namaUnit']= $namaUnit;
        $array['idUnit']= $idUnit;
        $this->display('acMonitoringStok', $array);
    }
    
    public function request(){
        $this->title="";
        $id_hakakses= $this->session->userdata['telah_masuk']["idha"];
        $id_akun= $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses= $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit= $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit= $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung= $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung= $this->session->userdata['telah_masuk']['namagedung'];
        
        $getObat= $this->mdrughc->getObat();
        $ke= $this->mdrughc->getDataLengkapPenugasan(2, $idGedung);//get Data Gudang Obat:
       
        $jenisTrans= $this->mdrughc->getSomeJenisTrans(12); //Permintaan Pustu ke Gudang Obat
        $array['jenisLokasi']= 'unit-gedung';
        $array['jenisTransId']= $jenisTrans[0]['ID_JENISTRANSAKSI'];
        $array['jenisTransNama']= $jenisTrans[0]['NAMA_JENIS'];
        $array['allObat']= $getObat;
        $array['dari_id']= $idUnit;
        $array['dari_nama']= $namaUnit;
        $array['ke_id']= $ke[0]['ID_UNIT'];
        $array['ke_nama']= $ke[0]['NAMA_UNIT'];
        $this->display('acRequestDrug', $array);
    }
    
    public function addRequest(){
        $id_hakakses= $this->session->userdata['telah_masuk']["idha"];
        $id_akun= $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses= $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit= $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit= $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung= $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung= $this->session->userdata['telah_masuk']['namagedung'];
        
        $penugasan= $this->mdrughc->getPenugasan($id_akun, $idUnit);
        $tanggalTransaksi= $this->convert($this->input->post('transaksi'));
        $tanggalRekapTransaksi= $this->convert($this->input->post('transaksi_now'));
        $listKode= json_decode($this->input->post('total_kodeObat'));
        $listBatch= json_decode($this->input->post('total_batch'));
        $listJml= json_decode($this->input->post('total_jumlahObat'));
        $jenisTransaksi= $this->input->post('jenis_transaksi');
        
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
        $lastID= $this->mdrughc->insertAndGetLast('transaksi_obat', $data);
        
        $idTransBefore= $this->input->post('id_rujukan');
        if(isset($idTransBefore)){    //cek if it has id_rujukan
            $dataResep= array(
                    'FLAG_KONFIRMASI'=>1
            );
            $updateResep= $this->mdrughc->update('transaksi_obat', $dataResep, 'ID_TRANSAKSI', $idTransBefore);
        }
        
        for($i=0; $i<sizeof($listKode); $i++):
            if($jenisTransaksi==21){   //Penerimaan Pustu dari Gudang Obat
                $ress= $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit Pengirim Obat
                $this->mdrughc->penambahanStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if($jenisTransaksi==10){   //Pemakaian
                $ress= $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit Pengirim Obat
                $this->mdrughc->penguranganStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if($jenisTransaksi==12){ //Permintaan Pustu ke Gudang Obat
                $ress= $this->mdrughc->getSomeStokByBatchObat($this->input->post('ke'), $listBatch[$i], $listKode[$i]);  //idUnit Pengirim Obat
                $this->mdrughc->permintaanStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
        endfor;
        
        redirect(base_url().'index.php/'.$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/showTrans/'.$lastID);
    }
    
    public function convert($date){
        $mydate = date_create_from_format('d-m-Y', $date);
        return date_format($mydate, 'Y-m-d');
    }
    
    public function showTrans($idTransaksi){
        $queryTrans= $this->mdrughc->getSomeTransaksi($idTransaksi);
        $jenisTrans= $this->mdrughc->getSomeJenisTrans($queryTrans[0]['ID_JENISTRANSAKSI']);
        if($jenisTrans[0]['ID_JENISTRANSAKSI']!=15){    //bukan Penerimaan Obat selain GFK
            $param= array('ID_UNIT'=>$queryTrans[0]['TRANSAKSI_UNIT_DARI']);
            $temp= $this->mdrughc->getUnit($param);
            $dari= $temp[0]['NAMA_UNIT'];
            $param= array('ID_UNIT'=>$queryTrans[0]['TRANSAKSI_UNIT_KE']);
            $temp= $this->mdrughc->getUnit($param);
            $ke= $temp[0]['NAMA_UNIT'];
        }
        else {
            $dari= $queryTrans[0]['NAMA_TRANSAKSI_SUMBER_LAIN'];
            $param= array('ID_UNIT'=>$queryTrans[0]['TRANSAKSI_UNIT_KE']);
            $temp= $this->mdrughc->getUnit($param);
            $ke= $temp[0]['NAMA_UNIT'];
        }
        
        $queryDetailTrans= $this->mdrughc->getSomeDetailTrans($idTransaksi);
        $listNamObat = array();
        $listBatch = array();
        $listJmlObat = array();
        $listSatObat = array();
        $listExpired = array();
        for($i=0; $i<sizeof($queryDetailTrans); $i++):
            $getObat= $this->mdrughc->getSomeObat($queryDetailTrans[$i]['ID_OBAT']);
            array_push($listNamObat, $getObat[0]['NAMA_OBAT']);
            array_push($listJmlObat, $queryDetailTrans[$i]['JUMLAH_OBAT']);
            array_push($listSatObat, $getObat[0]['SATUAN']);
            array_push($listBatch, $queryDetailTrans[$i]['NOMOR_BATCH']);
            array_push($listExpired, $queryDetailTrans[$i]['EXPIRED_DATE']);
        endfor;
        
        $array['trans']= $queryTrans; 
        $array['jenisTrans']= $jenisTrans;
        $array['dari']= $dari;
        $array['ke']= $ke;
        $array['detailTrans']= $queryDetailTrans;
        $array['listNamObat']= $listNamObat;
        $array['listJmlObat']= $listJmlObat;
        $array['listSatObat']= $listSatObat;
        $array['listBatch']= $listBatch;
        $array['listExpired']= $listExpired;
        $this->display('acShowResultTransaksi', $array);
    }
    
    public function obatMasuk($tipe, $idTransaksi=0, $idUnitParam=0){
        $this->title="";
        $id_hakakses= $this->session->userdata['telah_masuk']["idha"];
        $id_akun= $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses= $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit= $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit= $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung= $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung= $this->session->userdata['telah_masuk']['namagedung'];
        
        $getObat= $this->mdrughc->getObat();
        $array['allObat']= $getObat;
        
        $currentJob= $this->mdrughc->getHakAkses($id_akun); //get id_unit and id_gedung user
        $ke= $this->mdrughc->getUnitFilter($idGedung);   //get id all unit except Apotik

        switch ($tipe):
            case 'daftar_pengiriman':
                $array['pengiriman']= $this->mdrughc->getSomeTransaksiParam(array(
                    'ID_JENISTRANSAKSI'=>5, 
                    'TRANSAKSI_UNIT_KE'=>$idUnit));    //Pengiriman Gudang Obat ke Pustu
                $listPengiriman= $array['pengiriman'];
                for($i=0; $i<sizeof($listPengiriman); $i++){
                    $unit[$i]= $this->mdrughc->getUnit(array('ID_UNIT'=>$listPengiriman[$i]['TRANSAKSI_UNIT_DARI']));
                    $ress[$i]= $this->mdrughc->getSomeTransaksiParam(array('ID_RUJUKAN_KONFIRMASI'=>$listPengiriman[$i]['ID_TRANSAKSI']));
                }
                if(isset($unit)) $array['unit']= $unit;
                if(isset($ress)) $array['flag']= $ress;
                $jenisTrans1= $this->mdrughc->getSomeJenisTrans(5);    //Pengiriman Gudang Obat ke Pustu
                $array['jenisTransNama1']= $jenisTrans1[0]['NAMA_JENIS'];
                $this->display('acGiftList', $array);
                break;
            case 'detail':
                $ke= $this->mdrughc->getUnit(array('ID_UNIT'=>$idUnitParam));
                $array['trans']= $this->mdrughc->getSomeTransaksiParam(array('ID_TRANSAKSI'=>$idTransaksi));
                $array['detTrans']= $this->mdrughc->getDetailTransObat($idTransaksi);
                $jenisTrans= $this->mdrughc->getSomeJenisTrans(21); //Penerimaan Pustu dari Gudang Obat
                $array['jenisLokasi']= 'unit-unit';
                $array['jenisTransId']= $jenisTrans[0]['ID_JENISTRANSAKSI'];
                $array['jenisTransNama']= $jenisTrans[0]['NAMA_JENIS'];
                $array['ke_id']= $idUnit;
                $array['ke_nama']= $namaUnit;
                $array['dari_id']= $ke[0]['ID_UNIT'];
                $array['dari_nama']= $ke[0]['NAMA_UNIT'];
                $array['flag']= $idTransaksi;   //track id permintaan
                $this->display('acGiftDrugSuccess', $array);
                break;
        endswitch;
    }
    
    function searchObat($idUnit){
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');

        $teks = $data['tanda'];
        $temp1= $this->mdrughc->getAllStok($idUnit, $teks);
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
}