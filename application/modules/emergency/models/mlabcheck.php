<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mLabCheck extends CI_Model {

    function getAllEntry($idunit) {
        $this->db->where('ID_UNIT',$idunit);
        $res = $this->db->get('pemeriksaan_laborat');
        return $res->result_array();
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
        $sql = 'SELECT cek_laborat.*, pemeriksaan_laborat.NAMA_PEM_LABORAT FROM cek_laborat
				left join pemeriksaan_laborat
				on cek_laborat.ID_PEM_LABORAT = pemeriksaan_laborat.ID_PEM_LABORAT
				where cek_laborat.ID_RIWAYAT_RM = ' . $id_rrm;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}
