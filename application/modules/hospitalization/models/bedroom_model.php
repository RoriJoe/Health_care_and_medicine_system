<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Bedroom_model extends CI_model {

    function __construct() {
        parent::__construct();
    }

    function insertNewEntry($data) {
        if ($this->db->insert('tempat_tidur', $data)){
            return true;
        }
        return false;
    }
    
    function getAllEntry () {
        $this->db->from('view_bedroom');
        $this->db->where('id_gedung', $this->session->userdata['telah_masuk']['idgedung']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }

    function deleteById ($param) {
        if ($this->db->delete('tempat_tidur', 
                array('id_tempat_tidur'=> $param))) {
            return true;
        }
        return false;
    }
    
    function selectById ($id) {
        $this->db->from('tempat_tidur');
        $this->db->where('id_tempat_tidur', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
    
    function updateEntry ($id, $data) {
        
        $this->db->where('id_tempat_tidur', $id);
        
        if ($this->db->update('tempat_tidur', $data)) {
            return true;
        }
        else {
            return false;
        }
    }
}