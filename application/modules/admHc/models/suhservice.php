<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Suhservice extends CI_model {

    function __construct() {
        parent::__construct();
    }

    function insertNewEntry($data) {
        if ($this->db->insert('layanan_kesehatan', $data)){
            return true;
        }
        return false;
    }
    
    function getAllEntry () {
        $query = $this->db->get('layanan_kesehatan');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }

    function deleteById ($param) {
        if ($this->db->delete('layanan_kesehatan', 
                array('id_layanan_kes'=> $param))) {
            return true;
        }
        return false;
    }
    
    function selectById ($id) {
        $this->db->from('layanan_kesehatan');
        $this->db->where('id_layanan_kes', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
    
    function updateEntry ($id, $data) {
        
        $this->db->where('id_layanan_kes', $id);
        
        if ($this->db->update('layanan_kesehatan', $data)) {
            return true;
        }
        else {
            return false;
        }
    }
}