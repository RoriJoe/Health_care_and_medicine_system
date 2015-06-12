<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Mdoctor extends CI_model {

    function __construct() {
        parent::__construct();
    }
    
    function insert($table, $data){
        $this->db->insert($table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

}