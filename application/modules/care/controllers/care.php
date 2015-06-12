<?php if (!defined('BASEPATH')) 
exit('No direct script access allowed');

class Care extends riController {
	
	function __construct () {
		parent::__construct();
	}
	
	function index (){ 
		redirect ('care/ri');
	}
}
