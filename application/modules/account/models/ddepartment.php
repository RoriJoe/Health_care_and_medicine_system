<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class dDepartment extends CI_model {

    function __construct() {
        parent::__construct();
    }

    function insertNewEntry($data) {
        if ($this->db->insert('jabatan', $data)){
            return true;
        }
        return false;
    }
    
    function getAllEntry () {
        $query = $this->db->get('jabatan');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }

    function deleteById ($param) {
        if ($this->db->delete('jabatan', 
                array('id_jabatan'=> $param))) {
            return true;
        }
        return false;
    }
    
    function selectById ($id) {
        $this->db->from('jabatan');
        $this->db->where('id_jabatan', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
    
    function updateEntry ($id, $data) {
        
        $this->db->where('id_jabatan', $id);
        
        if ($this->db->update('jabatan', $data)) {
            return true;
        }
        else {
            return false;
        }
    }
}