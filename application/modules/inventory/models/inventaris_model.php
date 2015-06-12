<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Inventaris_model extends CI_model {

    function __construct() {
        parent::__construct();
    }

    function insertNewEntry($data) {
        if ($this->db->insert('inventaris_barang', $data)){
            return true;
        }
        return false;
    }
    
    function getAllEntry () {
        $query = $this->db->get('inventaris_barang');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }
    
    function getAllEntry_byGedung() {
        $this->db->where('id_gedung', $this->session->userdata['telah_masuk']['idgedung']);
        $query = $this->db->get('inventaris_barang');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }

    function deleteById ($param) {
        if ($this->db->delete('inventaris_barang', 
                array('id_inventaris'=> $param))) {
            return true;
        }
        return false;
    }
    
    function selectById ($id) {
        $this->db->from('inventaris_barang');
        $this->db->where('id_inventaris', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
    
    function updateEntry ($id, $data) {
        
        $this->db->where('id_inventaris', $id);
        
        if ($this->db->update('inventaris_barang', $data)) {
            return true;
        }
        else {
            return false;
        }
    }
}