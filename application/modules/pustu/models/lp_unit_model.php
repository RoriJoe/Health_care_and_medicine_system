<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lp_unit_model extends CI_Model {

    private $table;

    function __construct() {
        parent::__construct();
        $this->table = 'unit';
    }

    function getAllUnit() {
        $this->db->where('flag_distribusi_obat', 4);
        $this->db->or_where('flag_distribusi_obat', 3);
        $this->db->or_where('flag_distribusi_obat', 2);
        $query = $this->db->get($this->table);
        if ($query->num_rows > 0)
            return $query->result_array();
        return null;
    }

    function getUnitByHC() {
        $id_gedung = $this->session->userdata['telah_masuk']['idgedung'];
        $this->db->where('id_gedung', $id_gedung);
        $this->db->where('flag_distribusi_obat', 4);
        // $this->db->or_where ('flag_distribusi_obat', 3);
        // $this->db->or_where ('flag_distribusi_obat', 2);
        // $this->db->or_where ('flag_distribusi_obat', 3);
        $query = $this->db->get($this->table);
        if ($query->num_rows > 0)
            return $query->result_array();
        return null;
    }

    function getUnitByInputHC($id = '') {
        if ($id == '')
            $id_gedung = $this->session->userdata['telah_masuk']['idgedung'];
        else
            $id_gedung = $id;

        $this->db->where('id_gedung', $id_gedung);
        // $this->db->or_where ('flag_distribusi_obat', 3);
        $query = $this->db->get($this->table);
        if ($query->num_rows > 0)
            return $query->result_array();
        return null;
    }

    function getIDRi($id = '') {
        if ($id = '')
            $id_gedung = $this->session->userdata['telah_masuk']['idgedung'];
        else
            $id_gedung = $id;
        $this->db->where('id_gedung', $id_gedung);
        $this->db->like('nama_unit', '%Rawat Inap%');
        $this->db->where('flag_distribusi_obat', 4);
        $this->db->or_where('flag_distribusi_obat', 3);
        $this->db->or_where('flag_distribusi_obat', 2);
        // $this->db->or_where ('flag_distribusi_obat', 3);
        $query = $this->db->get($this->table);
        if ($query->num_rows > 0)
            return $query->result_array();
        return null;
    }

    /* Tabel Nomor Urut Puskesmas */

    function getNomorUrutPuskesmas($namaPuskesmas) {
        $this->db->like('nama_puskesmas', $namaPuskesmas);
        $query = $this->db->get('nomor_urut_puskesmas');
        if ($query->num_rows > 0) {
            $arr = $query->result_array();
            return $arr[0]['nomor'];
        }
        return null;
    }

    function getAllDesa() {
        $query = $this->db->get('nomor_urut_desa');
        if ($query->num_rows > 0) {
            return $query->result_array();
        }
        return null;
    }

    function getKecamatanByDesa($id_nodesa) {
        $this->db->where('id_nodesa', $id_nodesa);
        $query = $this->db->get('nomor_urut_desa');
        if ($query->num_rows > 0) {
            $result = $query->result_array();
            return $result;
        }
        return null;
    }

}
