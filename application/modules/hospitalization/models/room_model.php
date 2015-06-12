<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Room_model extends CI_model {

    function __construct() {
        parent::__construct();
    }

    function insertNewEntry($data) {
        if ($this->db->insert('ruangan_ri', $data)){
            return true;
        }
        return false;
    }
    
    function getAllEntry () {
		$this->db->select('ruangan_ri.NAMA_RUANGAN_RI AS NAMA_RUANGAN, ruangan_ri.ID_RUANGAN_RI AS ID_RUANGAN');
        $this->db->from('ruangan_ri');
        $this->db->join('unit', 'unit.ID_UNIT =ruangan_ri.ID_UNIT','left');
		$this->db->where('unit.ID_GEDUNG', $this->session->userdata['telah_masuk']['idgedung']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }

    function deleteById ($param) {
        if ($this->db->delete('ruangan_ri', 
                array('id_ruangan_ri'=> $param))) {
            return true;
        }
        return false;
    }
    
    function selectById ($id) {
        $this->db->from('ruangan_ri');
        $this->db->where('id_ruangan_ri', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
    
	function selectByIdUnit ($id) {
        $this->db->from('ruangan_ri');
        $this->db->where('id_unit', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
	
    function updateEntry ($id, $data) {
        
        $this->db->where('id_ruangan_ri', $id);
        
        if ($this->db->update('ruangan_ri', $data)) {
            return true;
        }
        else {
            return false;
        }
    }
}