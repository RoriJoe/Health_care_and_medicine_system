<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class UHcModel extends CI_model {

    function __construct() {
        parent::__construct();
    }

    function insertNewEntry($data) {
        if ($this->db->insert('unit', $data)){
            return true;
        }
        return false;
    }
    
    function getAllEntry () {
        $query = $this->db->get('unit');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }
	
	function getAllPoli ($id) {
        $this->db->from('unit');
        $this->db->where('id_gedung', $id);
        $this->db->not_like('nama_unit', 'Pustu');
        $this->db->not_like('nama_unit', 'Polindes');
        $this->db->not_like('nama_unit', 'Ponkesdes');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }
	
	function getAllExceptPoli ($id) {
        $this->db->from('unit');
        $this->db->where('id_gedung', $id);
        $this->db->where("(nama_unit LIKE '%Pustu%' OR nama_unit LIKE '%Polindes%' OR nama_unit LIKE '%Ponkesdes%')");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }
	
    function deleteById ($param) {
        if ($this->db->delete('unit', 
                array('id_unit'=> $param))) {
            return true;
        }
        return false;
    }
    
    function selectById ($id) {
        $this->db->from('unit');
        $this->db->where('id_unit', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
    
	function selectByIdHC ($id) {
        $this->db->from('unit');
        $this->db->where('id_gedung', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
	
    function updateEntry ($id, $data) {
        
        $this->db->where('id_unit', $id);
        
        if ($this->db->update('unit', $data)) {
            return true;
        }
        else {
            return false;
        }
    }
}