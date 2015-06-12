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
    
	function selectRDById ($id) {
        $this->db->from('unit');
        $this->db->where('nama_unit', 'Ruang Dokter');
        $this->db->where('id_gedung', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
	
	function selectTUById ($id) {
        $this->db->from('unit');
        $this->db->where('nama_unit', 'Tata Usaha');
        $this->db->where('id_gedung', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
	function selectKGFKById () {
        $this->db->from('unit');
        $this->db->where('nama_unit', 'Kepala GFK');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
	
	function selectKDinkesById () {
        $this->db->from('unit');
        $this->db->where('nama_unit', 'Kadis Kesehatan');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
	
	function selectKYankesById () {
        $this->db->from('unit');
        $this->db->where('nama_unit', 'Kabid Yankes');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
	
	function selectSIKById () {
        $this->db->from('unit');
        $this->db->where('nama_unit', 'SIK');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
	
	function selectGOPById ($id) {
        $this->db->from('unit');
        $this->db->where('nama_unit', 'Gudang Obat Puskesmas');
        $this->db->where('id_gedung', $id);
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