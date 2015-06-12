<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class access_model extends CI_model {

    function __construct() {
        parent::__construct();
    }
	
    function getAllEntryByHa () {
		$flagChoose = 2;
		switch($this->session->userdata['telah_masuk']["idha"]){
			case 5:
			$flagChoose = 1;
			break;
			case 19:
			$flagChoose = 2;
			break;
			case 16:
			$flagChoose = 3;
			break;
		}
        $this->db->from('hak_akses');   
        $this->db->where('FLAG_HA', $flagChoose);
        $query = $this->db->get();
        if (isset ($query)) {
            return $query->result_array();
        }         
    }
	
	function getHAByUnit($unitName)
	{
        $this->db->from('hak_akses');  
        $this->db->where('upper(nama_hakakses) like "%'.$unitName.'%"'); //find ha by unit name
        $query = $this->db->get();
		if (isset ($query)) {
            return $query->result_array();
        }
		else
		{
			$this->db->from('hak_akses');  
			$this->db->where('id_hakakses', 21);
			$query = $this->db->get();
            return $query->result_array();
		}
		
	}
}