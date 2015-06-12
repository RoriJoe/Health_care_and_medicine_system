<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class DrugWH extends backendController {
       
    private $home;
       
    public function __construct () {
        parent::__construct ();
		$this->load->model ('mUnit');
		$this->load->model ('mAssignment');
		$this->script_footer = 'lay-scripts/footer_agfk';
    }

    public function index () {
        $idha = $this->session->userdata['telah_masuk']["idha"];		
		// var_dump ($this->session->userdata['telah_masuk']);
        $path;
        switch ($idha){
                case 16:
                        $path = 'agfk/';
                        break;
                case 17:
                        $path = 'kgfk/';
                        break;
                case 18:
                        $path = 'ogfk/';
                        break;
				case 23:
                        $path = 'ogfkPencatatan/';
                        break;
				case 24:
                        $path = 'ogfkDistribusi/';
                        break;
				case 25:
                        $path = 'ogfkPenyimpanan/';
                        break;
                default:
                        break;
        }
        
		// echo (base_url().$this->uri->segment(1).'/'.$path);
		
		$session_arr = $this->session->userdata['telah_masuk'];        
		$constraint = array
		(
				'id_akun' => $session_arr['idakun'],
				'id_unit' => $session_arr['idunit']
		);
		$assignmentId = $this->mAssignment->getAssignment($constraint);
	   
		$ogfkId = $this->mUnit->getOgfkUnitID ();              
	   
		$session_arr['idunit'] = $ogfkId[0]['ID_UNIT'];
		$session_arr['idpenugasan'] = $assignmentId;
               
		$this->session->set_userdata('telah_masuk', $session_arr);
        redirect(base_url().$this->uri->segment(1).'/'.$path);
    }
       
}

?>
