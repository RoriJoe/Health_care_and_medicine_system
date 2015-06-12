<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mLabCheck extends CI_Model {

    function getAllEntry($idunit) {
        $this->db->where('ID_UNIT',$idunit);
        $res = $this->db->get('pemeriksaan_laborat');
        return $res->result();
    }
    
    function getKatPemeriksaan()
    {
        $temp = $this->db->get('kategori_pem_laborat');
        return $temp->result();
    }
    
    function getSpesimen()
    {
        $temp = $this->db->get('kategori_spesimen');
        return $temp->result();
    }

    function insertNewEntry($data) {
        $this->db->insert('cek_laborat', $data);
    }

    function getIdLab_byGedung( $idgedung ) {
        $sql = "select unit.ID_UNIT 
                from unit left join gedung on unit.ID_GEDUNG = gedung.ID_GEDUNG
                where unit.NAMA_UNIT like '%laborat%' and gedung.ID_GEDUNG = $idgedung";
        return $this->db->query($sql)->result();
    }

    function getEntryById($id_rrm) {
        $sql = 'SELECT cek_laborat.*, pemeriksaan_laborat.NAMA_PEM_LABORAT, kategori_spesimen.`NAMA_SPESIMEN`, pemeriksaan_laborat.`NILAI_NORMAL_UJI`, pemeriksaan_laborat.`SATUAN_HASIL_UJI`, kategori_pem_laborat.NAMA_KP_LABORAT
                FROM cek_laborat
                LEFT JOIN pemeriksaan_laborat ON cek_laborat.ID_PEM_LABORAT = pemeriksaan_laborat.ID_PEM_LABORAT
                LEFT JOIN `kategori_spesimen` ON `kategori_spesimen`.`ID_KAT_SPES`=pemeriksaan_laborat.`ID_KAT_SPES`
                LEFT JOIN `kategori_pem_laborat` ON `kategori_pem_laborat`.`ID_KP_LABORAT`= pemeriksaan_laborat.`ID_KP_LABORAT`
                WHERE cek_laborat.ID_RIWAYAT_RM = ' . $id_rrm;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}
