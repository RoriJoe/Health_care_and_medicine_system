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
class Lo extends oppusController {
    
    //1. seluruh fungsi yang tidak public, menggunakan awalan '_' , contoh: _getProperty()
    //2. di atas fungsi diberikan penjelasan proses apa yang dilakukan. dari mana ambil data, 
    //inputnya apa dan outputnya apa. contoh di fungsi index()
    //3. Penamaan fungsi harus PUNUK ONTA dengan awalan huruf kecil $ Menggunakan Bahasa Inggris
    //4. Penamaan nama fungsi maksimal 3 kata

    public function __construct() {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('mdrughc');
        $this->top_navbar = 'lay-top-navbar/oppusNavbar_lo';
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
        redirect(base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/resepPasien/list');
    }
    
    public function convert($date){
        $mydate = date_create_from_format('d-m-Y', $date);
        return date_format($mydate, 'Y-m-d');
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
                if(!isset($param1)) 
                    $param1= $this->convert(date('d-m-Y',strtotime("-2 week")));
                else $param1= $this->convert($param1);
                if(!isset($param2)) 
                    $param2= $this->convert(date('d-m-Y'));
                else $param2= $this->convert($param2);
                $total_rows= $this->mdrughc->getTransaksiAndRiwayatRMCount($idUnit, 0, 16, $param1, $param2);
                $perPage= 10;    //perpage pagination
                $this->init_pagination($url,$total_rows,$perPage,7);
                $array['pasien']= $this->mdrughc->getTransaksiAndRiwayatRM($idUnit, 0, 16, $param1, $param2, $startRow, $perPage); //get transaksi flag 0 and jenis resep
                $array["links"] = $this->pagination->create_links();
                $this->display('lo_drughc/acListPasien', $array);
                break;
            case 'detailObat':/*param1 idPasien and param2 idTransaksi*/
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
                $this->display('lo_drughc/acListResep', $array);
                break;
            case 'updateObat':
                $array['listObat']= $this->mdrughc->getSomeStokByIdObat($idUnit, $param2);
                $detTransBefore= $this->mdrughc->getTable('detil_transaksi_obat', array('ID_DETIL_TO'=>$param1));
                $array['dataSebelumnya']= $detTransBefore[0];
                $array['id_detil_to_now']= $param1;
                $this->display('lo_drughc/acEditTebusanObat', $array);
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
                $this->display('lo_drughc/acLisTebusan', $array);
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
    public function showTransResep($idTransaksi, $idRiwayatRm){
        $queryTrans= $this->mdrughc->getSomeTransaksi($idTransaksi);
        $jenisTrans= $this->mdrughc->getSomeJenisTrans($queryTrans[0]['ID_JENISTRANSAKSI']);
        $rekamedik= $this->mdrughc->getRiwayatRMById($idRiwayatRm);
        
        $listBatch = array();
        $listNamObat = array();
        $listJmlObat = array();
        $listSatObat = array();
        $listJmlSehari = array();
        $listLamaHari = array();
        $listDeskObat = array();
        $listSigna = array();
        $queryDetailTrans= $this->mdrughc->getSomeDetailTrans($idTransaksi);
        for($i=0; $i<sizeof($queryDetailTrans); $i++):
            $getObat= $this->mdrughc->getSomeObat($queryDetailTrans[$i]['ID_OBAT']);
            array_push($listBatch, $queryDetailTrans[$i]['NOMOR_BATCH']);
            array_push($listNamObat, $getObat[0]['NAMA_OBAT']);
            array_push($listJmlObat, $queryDetailTrans[$i]['JUMLAH_OBAT']);
            array_push($listSatObat, $getObat[0]['SATUAN']);
            $idDetilTo= $queryDetailTrans[$i]['ID_DETIL_TO'];
            $queryDetailObatPasien= $this->mdrughc->getSomeObatPasien($idDetilTo);
            array_push($listJmlSehari, $queryDetailObatPasien[0]['JUMLAH_SEHARI']);
            array_push($listLamaHari, $queryDetailObatPasien[0]['LAMA_HARI']);
            array_push($listDeskObat, $queryDetailObatPasien[0]['DESKRIPSI_OP']);
            array_push($listSigna, $queryDetailObatPasien[0]['SIGNA']);
        endfor;
        
        $array['namaPasien']= $rekamedik[0]['NAMA_PASIEN'];
        $array['trans']= $queryTrans; 
        $array['jenisTrans']= $jenisTrans;
        $array['detailTrans']= $queryDetailTrans;
        $array['listBatch']= $listBatch;
        $array['listNamObat']= $listNamObat;
        $array['listJmlObat']= $listJmlObat;
        $array['listSatObat']= $listSatObat;
        $array['listJmlSehari']= $listJmlSehari;
        $array['listLamaHari']= $listLamaHari;
        $array['listDeskObat']= $listDeskObat;
        $array['listSigna'] = $listSigna;
        $this->display('lo_drughc/acShowResultTransaksiResep', $array);
    }
    
    function searchObat($idUnit){
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $data = $this->input->post('teksnya');

        $teks = $data['tanda'];
        $temp1= $this->mdrughc->getAllStok($idUnit, $teks);
        $data["submit"] = $this->getPivotObat($temp1);
        return $data["submit"];
    }
    
    function clean($string) {
        return preg_replace('/[^A-Za-z0-9\-@ .,]/', '-', $string); // Removes special chars.
    }
    
    private function getPivotObat($data) {
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
            $disabled= '';
            $mydate2 = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
            $mydate1 = DateTime::createFromFormat('Y-m-d', $value->EXPIRED_DATE);
            if(diffInMonths($mydate1, $mydate2) <= 1) $disabled= 'disabled';
            $header .= ',"<button '.$disabled.' data-toggle=\"modal\" href=\"#myModal\" onclick=\"setObat(\'' . $value->ID_DETIL_TO . '\',\'' . $value->ID_OBAT . '\',\'' . $value->NOMOR_BATCH . '\',\'' . $value->NAMA_OBAT . '\',\'' . $value->STOK . '\',\'' . $value->SATUAN . '\',\'' . $value->EXPIRED_DATE . '\')\" class=\"btn btn-primary\">Pilih</button>"';
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
//        $return["result"] = $query;
//        return $query;
//        $return["json"] = json_encode($return);
        echo  json_encode($query);
        
    }
}