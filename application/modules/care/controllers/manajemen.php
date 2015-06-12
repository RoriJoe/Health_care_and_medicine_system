<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Manajemen extends riController{

    public function __construct() {
        parent::__construct();
		$this->load->model ('mQueue');
		$this->load->model ('mPatient');
		$this->load->model ('mBed');
		$this->load->model ('mRoom');
		$this->load->model ('mRinap');
    }
	
	public function index (){ 
		$data['bedcat'] = $this->mBed->getBedCategory();
		$data['rooms'] = $this->mRoom->getAllEntry();
		$data['rinap'] = $this->mRinap->getAllEntry();
		$this->display ('manajemen', $data);
	}
	
}