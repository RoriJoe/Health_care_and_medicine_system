<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Assignment extends CI_model {

    function __construct() {
        parent::__construct();
    }
	
    function insertNewEntry($data) {
        if ($this->db->insert('penugasan', $data)){
            return true;
        }
        return false;
    }
	
	function getAllEntry () {
        $query = $this->db->get('penugasan');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }
	
	function updateEntry ($idunit, $idha, $data) {
        
        $this->db->where('id_unit', $idunit);
        $this->db->where('id_hakakses', $idha);
        $this->db->where('flag_active_penugasan', 1);
        
        if ($this->db->update('penugasan', $data)) {
            return true;
        }
        else {
            return false;
        }
    }
	
	function activateEntry ($idunit, $idha, $idakun, $data) {
        
        $this->db->where('id_unit', $idunit);
        $this->db->where('id_hakakses', $idha);
        $this->db->where('id_akun', $idakun);
        
        if ($this->db->update('penugasan', $data)) {
            return true;
        }
        else {
            return false;
        }
    }
	
	function findKPBy ($idgedung) {
	$sql = '
		SELECT akun.ID_AKUN,
		akun.NAMA_AKUN
		FROM penugasan
		LEFT JOIN unit
		ON unit.ID_UNIT = penugasan.ID_UNIT
		LEFT JOIN akun
		ON akun.ID_AKUN = penugasan.ID_AKUN
		WHERE unit.ID_GEDUNG = '.$idgedung.' AND penugasan.ID_HAKAKSES = 1 and penugasan.FLAG_ACTIVE_PENUGASAN = 1';
		
		$query = $this->db->query ($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }
	
	function findKGFKBy ($idgedung) {
	$sql = '
		SELECT akun.ID_AKUN,
		akun.NAMA_AKUN
		FROM penugasan
		LEFT JOIN unit
		ON unit.ID_UNIT = penugasan.ID_UNIT
		LEFT JOIN akun
		ON akun.ID_AKUN = penugasan.ID_AKUN
		WHERE penugasan.ID_HAKAKSES = 17 and penugasan.FLAG_ACTIVE_PENUGASAN = 1';
		
		$query = $this->db->query ($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }
	
	function findKDinasBy ($idgedung) {
	$sql = '
		SELECT akun.ID_AKUN,
		akun.NAMA_AKUN
		FROM penugasan
		LEFT JOIN unit
		ON unit.ID_UNIT = penugasan.ID_UNIT
		LEFT JOIN akun
		ON akun.ID_AKUN = penugasan.ID_AKUN
		WHERE penugasan.ID_HAKAKSES = 14 and penugasan.FLAG_ACTIVE_PENUGASAN = 1';
		
		$query = $this->db->query ($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }
	
	function findKYankesBy ($idgedung) {
	$sql = '
		SELECT akun.ID_AKUN,
		akun.NAMA_AKUN
		FROM penugasan
		LEFT JOIN unit
		ON unit.ID_UNIT = penugasan.ID_UNIT
		LEFT JOIN akun
		ON akun.ID_AKUN = penugasan.ID_AKUN
		WHERE penugasan.ID_HAKAKSES = 15 and penugasan.FLAG_ACTIVE_PENUGASAN = 1';
		
		$query = $this->db->query ($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }
	
	function findSIKBy ($idgedung) {
	$sql = '
		SELECT akun.ID_AKUN,
		akun.NAMA_AKUN
		FROM penugasan
		LEFT JOIN unit
		ON unit.ID_UNIT = penugasan.ID_UNIT
		LEFT JOIN akun
		ON akun.ID_AKUN = penugasan.ID_AKUN
		WHERE penugasan.ID_HAKAKSES = 19 and penugasan.FLAG_ACTIVE_PENUGASAN = 1';
		
		$query = $this->db->query ($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }
	function findAPBy ($idgedung) {
	$sql = '
		SELECT akun.ID_AKUN,
		akun.NAMA_AKUN
		FROM penugasan
		LEFT JOIN unit
		ON unit.ID_UNIT = penugasan.ID_UNIT
		LEFT JOIN akun
		ON akun.ID_AKUN = penugasan.ID_AKUN
		WHERE unit.ID_GEDUNG = '.$idgedung.' AND penugasan.ID_HAKAKSES = 5 and penugasan.FLAG_ACTIVE_PENUGASAN = 1';
		
		$query = $this->db->query ($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }
	
	function findGOPBy ($idgedung) {
	$sql = '
		SELECT akun.ID_AKUN,
		akun.NAMA_AKUN
		FROM penugasan
		LEFT JOIN unit
		ON unit.ID_UNIT = penugasan.ID_UNIT
		LEFT JOIN akun
		ON akun.ID_AKUN = penugasan.ID_AKUN
		WHERE unit.ID_GEDUNG = '.$idgedung.' AND penugasan.ID_HAKAKSES = 2 and penugasan.FLAG_ACTIVE_PENUGASAN = 1';
		
		$query = $this->db->query ($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }
	
	function existChecker ($idakun, $idunit, $idha) {
        $this->db->from('penugasan');
        $this->db->where('id_akun', $idakun);
        $this->db->where('id_unit', $idunit);
        $this->db->where('id_hakakses', $idha);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } 
		else
		 return false;
    }
}