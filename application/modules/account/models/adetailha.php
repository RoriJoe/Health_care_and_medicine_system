<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Adetailha extends CI_model {

    function __construct() {
        parent::__construct();
    }

    function insertNewEntry($data) {
        if ($this->db->insert('detil_ha_a', $data)){
            return true;
        }
        return false;
    }
    
    function getAllEntry () {
        $query = $this->db->get('detil_ha_a');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }

    function getIdHA ($id) {
        $this->db->select('ID_HAKAKSES'); 
        $this->db->from('detil_ha_a');   
        $this->db->where('ID_AKUN', $id);
        $query = $this->db->get();
        if (isset ($query)) {
            return $query->result_array();
        }        
    }
    
    function deleteByIdHA ($param) {
        if ($this->db->delete('detil_ha_a', 
                array('id_akun'=> $param))) {
            return true;
        }
        return false;
    }
    
    function selectById ($id) {
        $this->db->from('akun');
        $this->db->where('id_akun', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
    
    function updateEntry ($id, $data) {
        
        $this->db->where('id_akun', $id);
        
        if ($this->db->update('akun', $data)) {
            return true;
        }
        else {
            return false;
        }
    }

}