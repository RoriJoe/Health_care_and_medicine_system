<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class mHomeCommon extends CI_model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
	
	function get_obat()
	{
		$sql = "select * from icd_table	";
		//$sql = "select * from obat 	";
		$temp = $this->db->query($sql);
		//$temp = $this->db->get('obat');
		return $temp->result();
	}
	
	function select_obat($string)
	{
		$sql = "select * from icd_table where icd_table.INDONESIAN_NAME LIKE '%$string%' or icd_table.ENGLISH_NAME LIKE '%$string%'";
		$temp = $this->db->query($sql);
		return $temp->result();
	}
    
    
}