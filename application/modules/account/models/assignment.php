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
	
	function getAssignmentByIdAkun ($idakun) {
        $query = $this->db->query('select unit.ID_UNIT as `ID_UNIT`,
			unit.NAMA_UNIT as `NAMA_UNIT`,
			penugasan.ID_AKUN as `ID_AKUN`,
			penugasan.ID_HAKAKSES as `ID_HAKAKSES`
			from penugasan
			left join unit
			on penugasan.ID_UNIT = unit.ID_UNIT
			where penugasan.FLAG_ACTIVE_PENUGASAN = 1 AND penugasan.ID_AKUN ='.$idakun);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
	
	function getAssignmentByIdAkunForAP($idakun) {
        $query = $this->db->query('select unit.ID_UNIT as `ID_UNIT`,
			unit.NAMA_UNIT as `NAMA_UNIT`,
			penugasan.ID_AKUN as `ID_AKUN`,
			penugasan.ID_HAKAKSES as `ID_HAKAKSES`,
			hak_akses.NAMA_HAKAKSES
			from penugasan
			left join unit
			on penugasan.ID_UNIT = unit.ID_UNIT
			left join hak_akses
			on penugasan.ID_HAKAKSES = hak_akses.ID_HAKAKSES
			where  penugasan.FLAG_ACTIVE_PENUGASAN = 1 AND penugasan.ID_AKUN ='.$idakun );
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
	
	function getAssignmentByIdAkunForGFK($idakun) {
        $query = $this->db->query('select unit.ID_UNIT as `ID_UNIT`,
			unit.NAMA_UNIT as `NAMA_UNIT`,
			penugasan.ID_AKUN as `ID_AKUN`,
			penugasan.ID_HAKAKSES as `ID_HAKAKSES`,
			hak_akses.NAMA_HAKAKSES
			from penugasan
			left join unit
			on penugasan.ID_UNIT = unit.ID_UNIT
			left join hak_akses
			on penugasan.ID_HAKAKSES = hak_akses.ID_HAKAKSES
			where  penugasan.FLAG_ACTIVE_PENUGASAN = 1 AND penugasan.ID_AKUN ='.$idakun );
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
	
	function deactivateAssignment ($idakun, $idha, $idunit, $data) {
        $this->db->where('id_akun', $idakun);
        $this->db->where('id_hakakses', $idha);
		$this->db->where('id_unit', $idunit);
		
        if ($this->db->update('penugasan', $data)) {
            return true;
        }
        else {
            return false;
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