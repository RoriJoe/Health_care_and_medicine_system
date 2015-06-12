<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Mlogin extends CI_model {

    function __construct() {
        parent::__construct();
    }

    function login($id, $passw) {
        if (isset($id) && isset($passw) && $id != "" && $passw != "") {
            $sql = "call login('$id','$passw')";
            $result = $this->db->query($sql)->result();
            
            $this->db->close(); // <-- penting banget           
            return $result; 
        }
        
    }
	
    function loginMulti($id, $passw,$ha) {
        if (isset($id) && isset($passw) && $id != "" && $passw != "") {
            $sql = "call loginMulti($id,$passw,$ha)";
            $result = $this->db->query($sql)->result();
            return $result; 
        }        
    }
    
    function getAccRelated ($noid) {
    	$this->db->where('noid', $noid);
    	$query = $this->db->get ('view_acc_login_related');
    	if ($query->num_rows()>0) return $query->result_array();
    	else return null;
    }

}