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
        $this->load->library('pagination');
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
    
    public function index(){
        $this->title="";
        $id_hakakses= $this->session->userdata['telah_masuk']["idha"];
        $id_akun= $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses= $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit= $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit= $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung= $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung= $this->session->userdata['telah_masuk']['namagedung'];
        
        $this->top_navbar = 'lay-top-navbar/empty';
        $array['namaUnit']= $namaUnit;
        $array['idUnit']= $idUnit;
        $this->display('lo_drughc/acDashboard', $array);
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
        
        $array['notifStok']= $this->mdrughc->notificationStok();
        $array['notifMinStok']= $this->mdrughc->notificationMinStokPUSTU();
        $array['namaUnit']= $namaUnit;
        $array['idUnit']= $idUnit;
        $this->display('lo_drughc/acMonitoringStok', $array);
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
//            $this->mdrughc->permintaanStok($lastID, $listKode[$i], $listJml[$i], '', '', $idUnit, '');
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
        $this->display('lo_drughc/acShowResultTransaksiPermintaan', $array);
    }
    
    private function replaceString($input) {
        $output = str_replace("\"", "\\\"", $input);
        $output = str_replace("\'", "\\\'", $output);
        return $output;
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
        $this->display('lo_drughc/acRequestDrug', $array);
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
            else if ($jenisTransaksi == 22) {   //Retur Obat Unit ke Gudang Obat
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit Pengirim Obat
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
        $this->display('lo_drughc/acShowResultTransaksi', $array);
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
                    'FLAG_KONFIRMASI'=>0,
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
                $this->display('lo_drughc/acGiftList', $array);
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
                $this->display('lo_drughc/acGiftDrugSuccess', $array);
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
                $this->display('lo_drughc/acPemakaianObat', $array);
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
                $this->display('lo_drughc/acReturObat', $array);
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
                $this->display('lo_drughc/riwayatObat', $array);
                break;
            case 'minta':
                $array['jenisTransNama']= 'Riwayat Obat Minta';
                $url= $this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$this->uri->segment(4, 0);
                $perPage= 10;
                $total_rows= $this->mdrughc->getRiwayatObatMintaCount($id_hakakses, $idUnit);
                $pagination= $this->init_pagination($url,$total_rows,$perPage,5);
                $array['dataTrans']= $this->mdrughc->getRiwayatObatMinta($id_hakakses, $idUnit, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('lo_drughc/riwayatObat', $array);
                break;
            case 'pemakaian':
                $array['jenisTransNama']= 'Riwayat Pemakaian Obat';
                $url= $this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$this->uri->segment(4, 0);
                $perPage= 10;
                $total_rows= $this->mdrughc->getRiwayatPemakaianObatCount($idUnit);
                $pagination= $this->init_pagination($url,$total_rows,$perPage,5);
                $array['dataTrans']= $this->mdrughc->getRiwayatPemakaianObat($idUnit, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('lo_drughc/riwayatObat', $array);
                break;
            case 'retur':
                $array['jenisTransNama']= 'Riwayat Retur Obat';
                $url= $this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$this->uri->segment(4, 0);
                $perPage= 10;
                $total_rows= $this->mdrughc->getRiwayatReturObatCount($idUnit);
                $pagination= $this->init_pagination($url,$total_rows,$perPage,5);
                $array['dataTrans']= $this->mdrughc->getRiwayatReturObat($idUnit, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('lo_drughc/riwayatObat', $array);
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
    
    function clean($string) {
        return preg_replace('/[^A-Za-z0-9\-@ .,]/', '-', $string); // Removes special chars.
    }
}