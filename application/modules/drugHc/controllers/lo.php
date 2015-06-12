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
class Lo extends loController {
    
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
    public function index(){
        redirect(base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/pasien/list');
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
        $array['notifMinStok']= $this->mdrughc->notificationMinStokAPO();
        $array['namaUnit']= $namaUnit;
        $array['idUnit']= $idUnit;
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
        
        $ke= $this->mdrughc->getDataLengkapPenugasan(2, $idGedung);//get Data Gudang Obat:
       
        $jenisTrans= $this->mdrughc->getSomeJenisTrans(13); //Permintaan Apotik ke Gudang Obat
        $array['jenisTransId']= $jenisTrans[0]['ID_JENISTRANSAKSI'];
        $array['jenisTransNama']= $jenisTrans[0]['NAMA_JENIS'];
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
        if($jenisTransaksi!=15){    //bukan Penerimaan Obat selain GFK
            $param1= 'TRANSAKSI_UNIT_DARI';
            $param2= 'TRANSAKSI_UNIT_KE';
        }
        else {
            $param1= 'NAMA_TRANSAKSI_SUMBER_LAIN';
            $param2= 'TRANSAKSI_UNIT_KE';
        }
        
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
        
        $idTransBefore= $this->input->post('id_rujukan');
        if(isset($idTransBefore)){    //cek if it has id_rujukan
            $dataResep= array(
                    'FLAG_KONFIRMASI'=>1
            );
            $updateResep= $this->mdrughc->update('transaksi_obat', $dataResep, 'ID_TRANSAKSI', $idTransBefore);
        }
        
        for($i=0; $i<sizeof($listKode); $i++):
            if($jenisTransaksi==19){        //Penerimaan Apotik dari Gudang Obat
                $ress= $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit Pengirim Obat
                $this->mdrughc->penambahanStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if($jenisTransaksi==4){    //Pengiriman Apotik ke Layanan / Unit
                $ress= $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit Pengirim Obat
                $this->mdrughc->penguranganStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if ($jenisTransaksi == 22) {   //Retur Obat Unit ke Gudang Obat
                $ress = $this->mdrughc->getSomeStokByBatchObat($this->input->post('dari'), $listBatch[$i], $listKode[$i]);  //idUnit Pengirim Obat
                $this->mdrughc->penguranganStok($lastID, $listKode[$i], $listJml[$i], $ress[0]['EXPIRED_DATE'], $listBatch[$i], $idUnit, $ress[0]['ID_SUMBER_ANGGARAN_OBAT']);
            }
            else if($jenisTransaksi==13){   //Permintaan Apotik ke Gudang Obat
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

    public function obatKeluar($tipe, $idTransaksi=0, $idUnitParam=0){
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
            case 'daftar_permintaan':
                $array['permintaan']= $this->mdrughc->getSomeTransaksiParam(array(
                    'ID_JENISTRANSAKSI'=>11, 
                    'TRANSAKSI_UNIT_KE'=>$idUnit));    //Permintaan Unit / Layanan ke Apotik
                $listPermintaan= $array['permintaan'];
                for($i=0; $i<sizeof($array['permintaan']); $i++){
                    $unit[$i]= $this->mdrughc->getUnit(array('ID_UNIT'=>$listPermintaan[$i]['TRANSAKSI_UNIT_DARI']));
                    $ress[$i]= $this->mdrughc->getSomeTransaksiParam(array('ID_RUJUKAN_KONFIRMASI'=>$listPermintaan[$i]['ID_TRANSAKSI']));
                }
                if(isset($unit)) $array['unit']= $unit;
                if(isset($ress)) $array['flag']= $ress;
                $jenisTrans1= $this->mdrughc->getSomeJenisTrans(11);    //Permintaan Unit / Layanan ke Apotik
                $array['jenisTransNama1']= $jenisTrans1[0]['NAMA_JENIS'];
                $this->display('acListRequest', $array);
                break;
            case 'detail_transaksi':
                $this->script_header = 'lay-scripts/header_table';
                $this->script_footer = 'lay-scripts/footer_table_popUp';
                
                $ke= $this->mdrughc->getUnit(array('ID_UNIT'=>$idUnitParam));
                $array['trans']= $this->mdrughc->getSomeTransaksiParam(array('ID_TRANSAKSI'=>$idTransaksi));
                $array['detTrans']= $this->mdrughc->getDetailTransCompareStok($idUnit, $idTransaksi);
                $array['allObat']= $this->mdrughc->getAllStok($idUnit);
                $jenisTrans= $this->mdrughc->getSomeJenisTrans(4); //Pengiriman Apotik ke Layanan / Unit
                $array['jenisLokasi']= 'unit-unit';
                $array['jenisTransId']= $jenisTrans[0]['ID_JENISTRANSAKSI'];
                $array['jenisTransNama']= $jenisTrans[0]['NAMA_JENIS'];
                $array['dari_id']= $idUnit;
                $array['dari_nama']= $namaUnit;
                $array['ke_id']= $ke[0]['ID_UNIT'];
                $array['ke_nama']= $ke[0]['NAMA_UNIT'];
                $array['flag']= $idTransaksi;   //track id permintaan
                $this->display('acGiftDrugByRequest', $array);
                break;
            case 'pengurangan':
                $jenisTrans= $this->mdrughc->getSomeJenisTrans(4); //Pengiriman Apotik ke Layanan / Unit
                $array['jenisLokasi']= 'unit-unit';
                $array['jenisTransId']= $jenisTrans[0]['ID_JENISTRANSAKSI'];
                $array['jenisTransNama']= $jenisTrans[0]['NAMA_JENIS'];
                $array['dari_id']= $idUnit;
                $array['dari_nama']= $namaUnit;
                $array['ke_allUnit']= $ke;
                $this->display('acGiftDrugUnit', $array);
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
        endswitch;
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
                    'ID_JENISTRANSAKSI'=>3, 
                    'TRANSAKSI_UNIT_KE'=>$idUnit,
                    'FLAG_KONFIRMASI'=>0
                    ));    //Pengiriman Gudang Obat ke Apotik
                $listPengiriman= $array['pengiriman'];
                for($i=0; $i<sizeof($listPengiriman); $i++){
                    $unit[$i]= $this->mdrughc->getUnit(array('ID_UNIT'=>$listPengiriman[$i]['TRANSAKSI_UNIT_DARI']));
                    $ress[$i]= $this->mdrughc->getSomeTransaksiParam(array('ID_RUJUKAN_KONFIRMASI'=>$listPengiriman[$i]['ID_TRANSAKSI']));
                }
                if(isset($unit)) $array['unit']= $unit;
                if(isset($ress)) $array['flag']= $ress;
                $jenisTrans1= $this->mdrughc->getSomeJenisTrans(3);    //Pengiriman Gudang Obat ke Apotik
                $array['jenisTransNama1']= $jenisTrans1[0]['NAMA_JENIS'];
                $this->display('acGiftList', $array);
                break;
            case 'detail':
                $ke= $this->mdrughc->getUnit(array('ID_UNIT'=>$idUnitParam));
                $array['trans']= $this->mdrughc->getSomeTransaksiParam(array('ID_TRANSAKSI'=>$idTransaksi));
                $array['detTrans']= $this->mdrughc->getDetailTransObat($idTransaksi);
                $jenisTrans= $this->mdrughc->getSomeJenisTrans(19); //Penerimaan Apotik dari Gudang Obat
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
                $total_rows= $this->mdrughc->getRiwayatObatMasukCount($id_hakakses);
                $pagination= $this->init_pagination($url,$total_rows,$perPage,5);
                $array['dataTrans']= $this->mdrughc->getRiwayatObatMasuk($id_hakakses, $startRow, $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('riwayatObat', $array);
                break;
            case 'minta':
                $array['jenisTransNama']= 'Riwayat Obat Minta';
                $url= $this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$this->uri->segment(4, 0);
                $perPage= 10;
                $total_rows= $this->mdrughc->getRiwayatObatMintaCount($id_hakakses);
                $pagination= $this->init_pagination($url,$total_rows,$perPage,5);
                $array['dataTrans']= $this->mdrughc->getRiwayatObatMinta($id_hakakses, $startRow, $perPage);
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
    
    public function resepPasien($tipe, $param1=null, $param2=null, $startRow=0){
        $this->title="";
        $id_hakakses= $this->session->userdata['telah_masuk']["idha"];
        $id_akun= $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses= $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit= $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit= $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung= $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung= $this->session->userdata['telah_masuk']['namagedung'];
        
        switch ($tipe):
            case 'list':
                $url= $this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$tipe.'/'.$param1.'/'.$param2;
                if(!isset($param1)){
                    $isDate1null= 1;
                    $tempParam1= date('d-m-Y',strtotime("-2 week"));
                    $param1= $this->convert(date('d-m-Y',strtotime("-2 week")));
                }
                else {
                    $isDate1null= 0;
                    $tempParam1= $param1;
                    $param1= $this->convert($param1);
                }
                if(!isset($param2)){ 
                    $isDate2null= 1;
                    $tempParam2= date('d-m-Y');
                    $param2= $this->convert(date('d-m-Y'));
                }
                else {
                    $isDate2null= 0;
                    $tempParam2= $param2;
                    $param2= $this->convert($param2);
                }
                
                if($isDate1null==1 || $isDate2null==1){
                    redirect(base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$tipe.'/'.$tempParam1.'/'.$tempParam2);
                }
                $total_rows= $this->mdrughc->getTransaksiAndRiwayatRMCount($idUnit, 0, 16, $param1, $param2);
                $perPage= 10;    //perpage pagination
                $this->init_pagination($url,$total_rows,$perPage,7);
                $array['pasien']= $this->mdrughc->getTransaksiAndRiwayatRM($idUnit, 0, 16, $param1, $param2, $startRow, $perPage); //get transaksi flag 0 and jenis resep
                $array["links"] = $this->pagination->create_links();
                $this->display('acListPasien', $array);
                break;
            case 'detailObat':
                /*param1 idPasien and param2 idTransaksi*/
                $array['pemberiResep']= $this->mdrughc->getDataPemberiResep($param2);
                $obatTotal= $this->mdrughc->getTotalStok($param2);//get data resep pasien
                $data_detail= '';
                for ($i = 0; $i < sizeof($obatTotal); $i++) {
                    if(is_null($obatTotal[$i]['CURRENT_STOK'])){
                        $data_detail[$i]['statsTidakAda']=1;
                        $data_detail[$i]['namaTidakAda']= $obatTotal[$i]['NAMA_OBAT'];
                        $data_detail[$i]['TANGGAL_TRANSAKSI']= $obatTotal[$i]['TANGGAL_TRANSAKSI'];
                        $data_detail[$i]['ID_PASIEN']= $obatTotal[$i]['ID_PASIEN'];
                        $data_detail[$i]['NAMA_PASIEN']= $obatTotal[$i]['NAMA_PASIEN'];
                        $data_detail[$i]['ID_RIWAYAT_RM']= $obatTotal[$i]['ID_RIWAYAT_RM'];
                        $data_detail[$i]['ID_TRANSAKSI_RESEP']= $obatTotal[$i]['ID_TRANSAKSI'];
                    }
                    else {
                        if($obatTotal[$i]['JML_PESAN']>$obatTotal[$i]['CURRENT_STOK']){
                            $data_detail[$i]['statsKurang']=1;
                            $data_detail[$i]['namaKurang']= $obatTotal[$i]['NAMA_OBAT'];
                            $data_detail[$i]['namaTidakAda']= $obatTotal[$i]['NAMA_OBAT'];
                            $data_detail[$i]['TANGGAL_TRANSAKSI']= $obatTotal[$i]['TANGGAL_TRANSAKSI'];
                            $data_detail[$i]['ID_PASIEN']= $obatTotal[$i]['ID_PASIEN'];
                            $data_detail[$i]['NAMA_PASIEN']= $obatTotal[$i]['NAMA_PASIEN'];
                            $data_detail[$i]['ID_RIWAYAT_RM']= $obatTotal[$i]['ID_RIWAYAT_RM'];
                            $data_detail[$i]['ID_TRANSAKSI_RESEP']= $obatTotal[$i]['ID_TRANSAKSI'];
                        } 
                        else {
                            $detailObat = $this->mdrughc->getAllDetailEntry($obatTotal[$i]['ID_OBAT']);
                            $jmlObatTotal = $obatTotal[$i]['JML_PESAN'];
                            $counter = 0;
                            $tanda = false;
                            foreach ($detailObat as $do) {
                                $do['JUMLAH_SEHARI']= $obatTotal[$i]['JUMLAH_SEHARI'];
                                $do['LAMA_HARI']= $obatTotal[$i]['LAMA_HARI'];
                                $do['SIGNA']= $obatTotal[$i]['SIGNA'];
                                $do['DESKRIPSI_OP']= $obatTotal[$i]['DESKRIPSI_OP'];
                                $do['TANGGAL_TRANSAKSI']= $obatTotal[$i]['TANGGAL_TRANSAKSI'];
                                $do['ID_PASIEN']= $obatTotal[$i]['ID_PASIEN'];
                                $do['NAMA_PASIEN']= $obatTotal[$i]['NAMA_PASIEN'];
                                $do['ID_RIWAYAT_RM']= $obatTotal[$i]['ID_RIWAYAT_RM'];
                                $do['ID_TRANSAKSI_RESEP']= $obatTotal[$i]['ID_TRANSAKSI'];
                                $do['statsTidakAda']=0;
                                $do['statsKurang']=0;
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
                    }
                }
                $this->session->set_userdata('drugsOut_resep_detail', null);
                for ($i = 0; $i < count($data_detail); $i++) {
                    $haystack_baru[] = $data_detail[$i];
                }
                $this->session->set_userdata('drugsOut_resep_detail', $haystack_baru);
                $array['resep']= $haystack_baru;
                $this->display('acListResep', $array);
                break;
            case 'updateObat':
                $array['listObat']= $this->mdrughc->getSomeStokByIdObat($idUnit, $param2);
                $detTransBefore= $this->mdrughc->getTable('detil_transaksi_obat', array('ID_DETIL_TO'=>$param1));
                $array['dataSebelumnya']= $detTransBefore[0];
                $array['id_detil_to_now']= $param1;
                $this->display('acEditTebusanObat', $array);
                break;
            case 'batal';
                $idTransaksi= $this->input->post('idTransaksiResep');
                $KETERANGAN_TRANSAKSI_OBAT= $this->input->post('KETERANGAN_TRANSAKSI_OBAT');
                $dataUpdate= array(
                    'FLAG_KONFIRMASI'=>2, 
                    'KETERANGAN_TRANSAKSI_OBAT'=>$KETERANGAN_TRANSAKSI_OBAT
                );
                $batal= $this->mdrughc->update('transaksi_obat', $dataUpdate, 'ID_TRANSAKSI', $idTransaksi);
                redirect(base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/resepPasien/list');
                break;
            case 'riwayatTebusan':
                $url= $this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/'.$this->uri->segment(3, 0).'/'.$this->uri->segment(4, 0);
                $perPage= 20;
                $total_rows= $this->mdrughc->getRiwayatTebusanCount($idUnit);
                $pagination= $this->init_pagination($url,$total_rows,$perPage,5);
                $array['tebusan'] = $this->mdrughc->getRiwayatTebusan($idUnit, $this->uri->segment(5, 0), $perPage);
                $array["links"] = $this->pagination->create_links();
                $this->display('acLisTebusan', $array);
                break;
        endswitch;
    }
    
    public function init_pagination($url,$total_rows,$per_page=20,$segment=7){
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
    
    public function createTebusan($idTransaksiResep, $idRiwayatRM, $idPasien){
        $id_akun= $this->session->userdata['telah_masuk']["idakun"];
        $idUnit= $this->session->userdata['telah_masuk']['idunit'];
        $idGedung= $this->session->userdata['telah_masuk']['idgedung'];
        
        $penugasan= $this->mdrughc->getPenugasan($id_akun, $idUnit);
        $transaksiResep= $this->mdrughc->getTable('transaksi_obat', array('ID_TRANSAKSI'=>$idTransaksiResep));

        $date= $this->convert(date('m-d-Y'));
        $data= array(
                'ID_RIWAYAT_RM' => $idRiwayatRM,
                'ID_PENUGASAN' => $penugasan[0]['ID_PENUGASAN'],
                'ID_JENISTRANSAKSI' => 17, //Tebusan Resep Obat Pasien
                'TANGGAL_TRANSAKSI' => $transaksiResep[0]['TANGGAL_TRANSAKSI'],
                'TANGGAL_REKAP_TRANSAKSI' => $date,
                'TRANSAKSI_UNIT_DARI' => $idUnit,
                'ID_RUJUKAN_KONFIRMASI' => $idTransaksiResep,
                'FLAG_KONFIRMASI' => 1
        );
        $idTransaksiTebusan= $this->mdrughc->insertAndGetLast('transaksi_obat', $data); //insert transaksi tebusan return id transaksi

        $dataResep= array(
                'FLAG_KONFIRMASI'=>1
        );
        $updateResep= $this->mdrughc->update('transaksi_obat', $dataResep, 'ID_TRANSAKSI', $idTransaksiResep);
        
        $data_detail= $this->session->userdata('drugsOut_resep_detail');
        for ($i = 0; $i < count($data_detail); $i++) {
            $idDetilTo= $this->mdrughc->penguranganStok($idTransaksiTebusan, $data_detail[$i]['ID_OBAT'], $data_detail[$i]['STOK_OBAT_SEKARANG'], $data_detail[$i]['EXPIRED_DATE'], $data_detail[$i]['NOMOR_BATCH'], $idUnit, $data_detail[$i]['ID_SUMBER_ANGGARAN_OBAT']);
        
            $data3= array(
                'ID_RIWAYAT_RM'=>$idRiwayatRM,
                'ID_AKUN'=>$id_akun,
                'ID_DETIL_TO'=>$idDetilTo[0]->lastid,
                'DESKRIPSI_OP'=>$data_detail[$i]['DESKRIPSI_OP'],
                'JUMLAH_SEHARI'=>$data_detail[$i]['JUMLAH_SEHARI'],
                'LAMA_HARI'=>$data_detail[$i]['LAMA_HARI'],
                'SIGNA'=>$data_detail[$i]['SIGNA']
            );
            $this->mdrughc->insert('obat_pasien', $data3); //insert obat pasien tebusan
        }
        $this->session->set_userdata('drugsOut_resep_detail', null);

        redirect(base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/showTransResep/'.$idTransaksiTebusan.'/'.$idRiwayatRM);
    }
    
    //function show transkrip resep pasien
    public function showTransResep($idTransaksi, $idRiwayatRm) {
        $queryTrans = $this->mdrughc->getSomeTransaksi($idTransaksi);
        $jenisTrans = $this->mdrughc->getSomeJenisTrans($queryTrans[0]['ID_JENISTRANSAKSI']);
        $rekamedik = $this->mdrughc->getRiwayatRMById($idRiwayatRm);

        $listBatch = array();
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
            array_push($listBatch, $queryDetailTrans[$i]['NOMOR_BATCH']);
            array_push($listNamObat, $getObat[0]['NAMA_OBAT']);
            array_push($listJmlObat, $queryDetailTrans[$i]['JUMLAH_OBAT']);
            array_push($listSatObat, $getObat[0]['SATUAN']);
            $idDetilTo = $queryDetailTrans[$i]['ID_DETIL_TO'];
            $queryDetailObatPasien = $this->mdrughc->getSomeObatPasien($idDetilTo);
            array_push($listJmlSehari, $queryDetailObatPasien[0]['JUMLAH_SEHARI']);
            array_push($listLamaHari, $queryDetailObatPasien[0]['LAMA_HARI']);
            array_push($listDeskObat, $queryDetailObatPasien[0]['DESKRIPSI_OP']);
            array_push($listSigna, $queryDetailObatPasien[0]['SIGNA']);
        endfor;

        $array['namaPasien'] = $rekamedik[0]['NAMA_PASIEN'];
        $array['trans'] = $queryTrans;
        $array['jenisTrans'] = $jenisTrans;
        $array['detailTrans'] = $queryDetailTrans;
        $array['listBatch']= $listBatch;
        $array['listNamObat'] = $listNamObat;
        $array['listJmlObat'] = $listJmlObat;
        $array['listSatObat'] = $listSatObat;
        $array['listJmlSehari'] = $listJmlSehari;
        $array['listLamaHari'] = $listLamaHari;
        $array['listDeskObat'] = $listDeskObat;
        $array['listSigna'] = $listSigna;
        $this->display('acShowResultTransaksiResep', $array);
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
    
    function checkBatchObat(){
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        
        $id_hakakses= $this->session->userdata['telah_masuk']["idha"];
        $id_akun= $this->session->userdata['telah_masuk']["idakun"];
        $nama_hakakses= $this->session->userdata['telah_masuk']["hakakses"];
        $idUnit= $this->session->userdata['telah_masuk']['idunit'];
        $namaUnit= $this->session->userdata['telah_masuk']['namaunit'];
        $idGedung= $this->session->userdata['telah_masuk']['idgedung'];
        $namaGedung= $this->session->userdata['telah_masuk']['namagedung'];
        
        $data = $this->input->post('teksnya');

        $input = $data['tanda'];
        $query= $this->mdrughc->getSomeStokByIdObat($idUnit, $input);
        echo  json_encode($query);
        
    }
    
    function clean($string) {
        return preg_replace('/[^A-Za-z0-9\-@ .,]/', '-', $string); // Removes special chars.
    }
}