<?php 

if (!defined('BASEPATH'))     
	exit('No direct script access allowed');

class Poliumum extends puController {

	public function __construct () {
		parent::__construct ();
	}
	
	public function index () {	
		redirect (base_url().$this->uri->segment(1).'/pu');
	}	
}