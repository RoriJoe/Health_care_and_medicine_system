<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lp_patient_model extends CI_Model {

    private $table;

    function __construct() {
        parent::__construct();
        $this->table = 'pasien';
    }

    public function insertNewEntry($data) {
        $this->db->insert($this->table, $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getAllEntry() {
        $query = $this->db->get($this->table);
        if ($query->num_rows > 0)
            return
                    $query->result_array();
        return null;
    }

    public function updateEntry($data, $id) {
        $this->db->where('noid_pasien', $id);
        if ($this->db->update($this->table, $data))
            return
                    true;
        return
                false;
    }

    public function updateByPID($data, $id) {
        $this->db->where('id_pasien', $id);
        if ($this->db->update($this->table, $data))
            return
                    true;
        return
                false;
    }

    public function removeEntryById($id) {
        if ($this->db->delete($this->table, array('ID_PASIEN' => $id))) {
            return true;
        }
        return false;
    }

    public function getAllPatientByUrutPuskesmas($no_urut) {
        $sql = 'CALL sp_pasien('.$no_urut.')';
		$query = $this->db->query($sql);
		$this->db->close();
		if ($query->num_rows() > 0)  {
			return	$query->result_array();
		} else {
			return null;
		}
    }

}
