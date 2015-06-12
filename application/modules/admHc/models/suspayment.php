<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Suspayment extends CI_model {

    function __construct() {
        parent::__construct();
    }

    function insertNewEntry($data) {
        if ($this->db->insert('sumber_pembayaran_pasien', $data)){
            return true;
        }
        return false;
    }
    
    function getAllEntry () {
        $query = $this->db->get('sumber_pembayaran_pasien');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }

    function deleteById ($param) {
        if ($this->db->delete('sumber_pembayaran_pasien', 
                array('ID_SUMBER'=> $param))) {
            return true;
        }
        return false;
    }
    
    function selectById ($id) {
        $this->db->from('sumber_pembayaran_pasien');
        $this->db->where('ID_SUMBER', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
    
    function updateEntry ($id, $data) {
        
        $this->db->where('ID_SUMBER', $id);
        
        if ($this->db->update('sumber_pembayaran_pasien', $data)) {
            return true;
        }
        else {
            return false;
        }
    }
}