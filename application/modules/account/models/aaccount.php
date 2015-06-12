<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Aaccount extends CI_model {

    function __construct() {
        parent::__construct();
    }

    function insertNewEntry($data) {
        if ($this->db->insert('akun', $data)){
            return true;
        }
        return false;
    }
    
    function findID($noid) {
        $this->db->from('akun');
        $this->db->where('noid', $noid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    
    function getAllEntry () {
        $this->db->select('akun.*');
        $this->db->from('akun');
		if($this->session->userdata['telah_masuk']["idha"]!=19)
		{
			$this->db->join('penugasan', 'penugasan.ID_AKUN = akun.ID_AKUN', 'left');
			$this->db->join('unit', 'unit.ID_UNIT = penugasan.ID_UNIT', 'left');
			$this->db->where('unit.ID_GEDUNG ', $this->session->userdata['telah_masuk']["idgedung"]);
			$this->db->or_where('akun.ID_GEDUNG ', $this->session->userdata['telah_masuk']["idgedung"]);
        }
		$this->db->group_by("akun.ID_AKUN"); 
		
		$query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }

    function deleteById ($param) {
        if ($this->db->delete('akun', 
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
			//$this->output->enable_profiler(TRUE);
            return true;
        }
        else {
            return false;
        }
    }

}