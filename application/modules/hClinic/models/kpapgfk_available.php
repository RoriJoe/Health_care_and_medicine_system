<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Kpapgfk_available extends CI_model {

    function __construct() {
        parent::__construct();
    }
    
    function getAllEntry () {
        $query = $this->db->get('view_kpapgfk_available');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }        
    }
}