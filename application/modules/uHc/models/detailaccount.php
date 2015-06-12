<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class DetailAccount extends CI_model {

    function __construct() {
        parent::__construct();
    }
    
    function getAllEntry () {
        $query = $this->db->get('view_detail_user');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }
    
    function selectByIdAccount ($id) {
        $this->db->from('view_detail_user');
        $this->db->where('id_akun', $id);
		$this->db->where('id_hakakses', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
    
	function selectByIdPenugasan ($id) {
        $this->db->from('view_detail_user');
        $this->db->where('id_penugasan', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } 
    }
}