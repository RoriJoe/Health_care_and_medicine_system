<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ppuskesmas extends CI_model {

    function __construct() {
        parent::__construct();
    }

    function insertNewEntry($data) {
        if ($this->db->insert('gedung', $data)){
            return true;
        }
        return false;
    }
    
    function getAllEntry () {
        $this->db->from('gedung');
		if($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 15 || $this->session->userdata['telah_masuk']['idha'] == 17 || $this->session->userdata['telah_masuk']['idha'] == 23 || $this->session->userdata['telah_masuk']['idha'] == 24 || $this->session->userdata['telah_masuk']['idha'] == 25)
        $this->db->where('flag_gedung <> 1 or flag_gedung is null');
		else
		$this->db->where('flag_gedung is null');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }

    function deleteById ($param) {
        if ($this->db->delete('gedung', 
                array('id_gedung'=> $param))) {
            return true;
        }
        return false;
    }
    
    function selectById ($id) {
        $this->db->from('gedung');
        $this->db->where('id_gedung', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
    
    function updateEntry ($id, $data) {
        
        $this->db->where('id_gedung', $id);
        
        if ($this->db->update('gedung', $data)) {
            return true;
        }
        else {
            return false;
        }
    }
}