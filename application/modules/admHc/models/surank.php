<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Surank extends CI_model {

    function __construct() {
        parent::__construct();
    }

    function insertNewEntry($data) {
        if ($this->db->insert('pangkat', $data)){
            return true;
        }
        return false;
    }
    
    function getAllEntry () {
        $query = $this->db->get('pangkat');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }

    function deleteById ($param) {
        if ($this->db->delete('pangkat', 
                array('id_pangkat'=> $param))) {
            return true;
        }
        return false;
    }
    
    function selectById ($id) {
        $this->db->from('pangkat');
        $this->db->where('id_pangkat', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
    
    function updateEntry ($id, $data) {
        
        $this->db->where('id_pangkat', $id);
        
        if ($this->db->update('pangkat', $data)) {
            return true;
        }
        else {
            return false;
        }
    }
}