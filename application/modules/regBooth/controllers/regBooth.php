<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');


// default controller for this module
class RegBooth extends lpController {
	
	// this controller link
	private $home;
	
	public function __construct () {
		parent::__construct ();
		$this->home = base_url().'regBooth/';
	}
	
	public function index () {
		redirect ($this->home.'lp');
	}

}